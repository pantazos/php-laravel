<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PaginationTrait;
use App\Http\Middleware\ValidateUserRole;
use App\Http\Resources\Api\BookingCollection;
use App\Http\Resources\Api\BookingResource;
use App\Models\Booking;
use App\Models\PromoCode;
use App\Models\Role;
use App\Models\Service;
use App\Models\Status;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Symfony\Component\HttpFoundation\Response;

class BookingApiController extends Controller
{
    use PaginationTrait;

    /**
     * Store a new booking in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        abort_if(Gate::denies('booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'booking_at' => 'required|date|date_format:Y-m-d h:i A|after_or_equal:today',
            'service_key' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'address_name' => 'required|string',
            'address_details' => 'required|string'
        ]);

        $user = $request->user();
        $service = Service::byKey($request->input('service_key'))->first();
        $initialStatus = Status::byKey(Status::NEW)->first();

        $promoCode = null;
        if ($request->input('promo_code'))
            $promoCode = PromoCode::where('code', $request->input('promo_code'))->firstOrFail();

        $booking = new Booking([
            'booking_at' => $request->input('booking_at'),
            'notes' => $request->input('notes'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'address_name' => $request->input('address_name'),
            'address_details' => $request->input('address_details')
        ]);

        $booking->customer()->associate($user);
        $booking->service()->associate($service);
        $booking->status()->associate($initialStatus);
        $booking->promo_code()->associate($promoCode);
        $booking->save();

        // Send notifications to this service providers
        $providers = $service->category->providers()->whereNotNull('fcm_token')->get();
        foreach ($providers as $provider) {
            $this->sendNotification(
                $provider,
                trans('notifications.new_booking.title', ['service' => $service->name]),
                trans('notifications.new_booking.body')
            );
        }

        return response(new BookingResource($booking), 201);
    }

    /**
     * Get bookings list for the authenticated user.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role = $request->header(ValidateUserRole::ROLE);
        $statusQuery = $request->query('status');
        $statusArray = explode(',', $statusQuery);

        if ($role == Role::CUSTOMER) {

            $bookings = $request->user()->bookings()
                ->when($statusQuery, function ($query) use ($statusArray) {
                    $query->byStatusArray($statusArray);
                })
                ->latest()
                ->cursorPaginate($this->getPerPage());

            return response(new BookingCollection($bookings));

        } elseif ($role == Role::PROVIDER) {

            $bookings = $request->user()->leads()
                ->when($statusQuery, function ($query) use ($statusArray) {
                    $query->byStatusArray($statusArray);
                })
                ->latest()
                ->cursorPaginate($this->getPerPage());

            return response(new BookingCollection($bookings));
        }

        return response(['message' => 'Invalid role'], 400);
    }

    /**
     * Get bookings list for the authenticated provider, filtered by status NEW and by provider categories
     *
     * @param Request $request
     * @return Response
     */
    public function leads(Request $request): Response
    {
        abort_if(Gate::denies('review_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $providerCategories = $request->user()->categories->map(function ($category) {
            return $category->key;
        });
        $leads = Booking::byStatus(Status::NEW)
            ->byCategoryArray($providerCategories)
            ->latest()
            ->cursorPaginate($this->getPerPage());

        return response(new BookingCollection($leads));
    }

    /**
     * Get booking details.
     *
     * @param $key
     * @return Response
     */
    public function show($key): Response
    {
        abort_if(Gate::denies('review_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking = Booking::byKey($key)->first();
        return response(new BookingResource($booking));
    }

    /**
     * Update the booking status to accepted and assign a provider to this booking
     *
     * @param Request $request
     * @param $key
     * @return Response
     * @throws AuthorizationException
     */
    public function accept(Request $request, $key): Response
    {
        abort_if(Gate::denies('review_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $provider = $request->user();
        $booking = Booking::byKey($key)->first();
        $accepted = Status::byKey(Status::ACCEPTED)->first();

        $this->authorize('accept', $booking);

        if ($booking->provider != null || $booking->status->key != Status::NEW) {
            return response(['message' => 'Invalid status'], 400);
        }

        $booking
            ->provider()->associate($provider)
            ->status()->associate($accepted)
            ->update();

        $this->sendNotification(
            $booking->customer,
            trans('notifications.booking_accepted.title'),
            trans('notifications.booking_accepted.body', ['provider' => $provider->first_name])
        );

        return response(new BookingResource($booking));
    }

    /**
     * Update the booking status to onTheWay, means the provider started moving to the booking location
     *
     * @param Request $request
     * @param $key
     * @return Response
     * @throws AuthorizationException
     */
    public function onTheWay(Request $request, $key): Response
    {
        abort_if(Gate::denies('review_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking = Booking::byKey($key)->first();
        $onTheWay = Status::byKey(Status::ON_THE_WAY)->first();

        $this->authorize('updateAsProvider', $booking);

        // Make sure the previous status is accepted
        if ($booking->status->key != Status::ACCEPTED) {
            return response(['message' => 'Invalid status'], 400);
        }

        $booking->status()
            ->associate($onTheWay)
            ->update();

        $this->sendNotification(
            $booking->customer,
            trans('notifications.provider_on_the_way.title'),
            trans('notifications.provider_on_the_way.body', ['provider' => $request->user()->first_name])
        );

        return response(new BookingResource($booking));
    }

    /**
     * Update the booking status to arrived, means the provider arrived to the booking location
     *
     * @param Request $request
     * @param $key
     * @return Response
     * @throws AuthorizationException
     */
    public function arrived(Request $request, $key): Response
    {
        abort_if(Gate::denies('review_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking = Booking::byKey($key)->first();
        $arrived = Status::byKey(Status::ARRIVED)->first();

        $this->authorize('updateAsProvider', $booking);

        // Make sure the current status is on the way
        if ($booking->status->key != Status::ON_THE_WAY) {
            return response(['message' => 'Invalid status'], 400);
        }

        $booking->status()
            ->associate($arrived)
            ->update();

        $this->sendNotification(
            $booking->customer,
            trans('notifications.provider_arrived.title'),
            trans('notifications.provider_arrived.body', ['provider' => $request->user()->first_name])
        );

        return response(new BookingResource($booking));
    }

    /**
     * Update the booking status to inProgress, means the provider started working
     *
     * @param Request $request
     * @param $key
     * @return Response
     * @throws AuthorizationException
     */
    public function inProgress(Request $request, $key): Response
    {
        abort_if(Gate::denies('review_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking = Booking::byKey($key)->first();
        $inProgress = Status::byKey(Status::IN_PROGRESS)->first();

        $this->authorize('updateAsProvider', $booking);

        // Make sure the current status is arrived
        if ($booking->status->key != Status::ARRIVED) {
            return response(['message' => 'Invalid status'], 400);
        }

        $booking->status()
            ->associate($inProgress)
            ->update();

        $this->sendNotification(
            $booking->customer,
            trans('notifications.work_in_progress.title'),
            trans('notifications.work_in_progress.body', ['provider' => $request->user()->first_name])
        );

        return response(new BookingResource($booking));
    }

    /**
     * Update the booking status to pending customer approval, means the provider has finished work
     *
     * @param Request $request
     * @param $key
     * @return Response
     * @throws AuthorizationException
     */
    public function workDone(Request $request, $key): Response
    {
        abort_if(Gate::denies('review_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking = Booking::byKey($key)->first();
        $pendingApproval = Status::byKey(Status::PENDING_APPROVAL)->first();

        $this->authorize('updateAsProvider', $booking);

        // Make sure the previous status is in progress
        if ($booking->status->key != Status::IN_PROGRESS) {
            return response(['message' => 'Invalid status'], 400);
        }

        $booking->status()
            ->associate($pendingApproval)
            ->update();

        $this->sendNotification(
            $booking->customer,
            trans('notifications.work_done.title'),
            trans('notifications.work_done.body', ['provider' => $request->user()->first_name])
        );

        return response(new BookingResource($booking));
    }

    /**
     * Update the booking status to pending payment, means the customer has approved the work
     *
     * @param $key
     * @return Response
     * @throws AuthorizationException
     */
    public function approveWork($key): Response
    {
        abort_if(Gate::denies('review_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking = Booking::byKey($key)->first();
        $pendingPayment = Status::byKey(Status::PENDING_PAYMENT)->first();

        $this->authorize('updateAsCustomer', $booking);

        // Make sure the previous status is pending approval
        if ($booking->status->key != Status::PENDING_APPROVAL) {
            return response(['message' => 'Invalid status'], 400);
        }

        $booking->status()
            ->associate($pendingPayment)
            ->update();

        $this->sendNotification(
            $booking->provider,
            trans('notifications.work_approved.title'),
            trans('notifications.work_approved.body', ['customer' => $booking->customer->first_name])
        );

        return response(new BookingResource($booking));
    }

    /**
     * Update the booking status to done, means the provider has confirmed customer payment
     *
     * @param $key
     * @return Response
     */
    public function confirmPayment($key): Response
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking = Booking::byKey($key)->first();
        $booking->markAsDone();

        $this->sendNotification(
            $booking->customer,
            trans('notifications.payment_confirmed.title'),
            trans('notifications.payment_confirmed.body', ['provider' => $booking->provider->first_name])
        );

        return response(new BookingResource($booking));
    }

    /**
     * Update the booking status to canceled
     *
     * @param $key
     * @return Response
     * @throws AuthorizationException
     */
    public function cancel($key): Response
    {
        abort_if(Gate::denies('review_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking = Booking::byKey($key)->first();
        $canceled = Status::byKey(Status::CANCELED)->first();

        $this->authorize('updateAsCustomer', $booking);

        $booking->status()
            ->associate($canceled)
            ->update();

        if ($booking->provider)
            $this->sendNotification(
                $booking->provider,
                trans('notifications.booking_canceled.title'),
                trans('notifications.booking_canceled.body', ['customer' => $booking->customer->first_name])
            );

        return response(new BookingResource($booking));
    }

    /**
     * Send push notification to specific device
     *
     * @param $targetedUser
     * @param $title
     * @param $message
     */
    private function sendNotification($targetedUser, $title, $message)
    {
        $firebaseMessaging = Firebase::messaging();
        $notification = CloudMessage::new()->withNotification(Notification::create($title, $message));

        try {
            $tokensArray = $targetedUser
                ->notificationTokens
                ->map(function ($notificationToken) {
                    return $notificationToken->token;
                })
                ->toArray();

            $firebaseMessaging->sendMulticast($notification, $tokensArray);
        } catch (MessagingException | FirebaseException $e) {
        }
    }
}
