<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PaginationTrait;
use App\Http\Resources\Api\ReviewCollection;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ReviewApiController extends Controller
{
    use PaginationTrait;

    public function index($serviceKey)
    {
        abort_if(Gate::denies('review_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service = Service::byKey($serviceKey)->first();

        if (!$service) {
            return response(['message' => 'Invalid service key'], 400);
        }

        $reviews = $service
            ->reviews()
            ->latest()
            ->cursorPaginate($this->getPerPage());
        return response(new ReviewCollection($reviews));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('review_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'content' => 'required|string',
            'rating' => 'required|numeric',
            'booking_key' => 'required|string'
        ]);

        $review = new Review([
            'content' => $request->input('content'),
            'rating' => $request->input('rating')
        ]);

        $user = $request->user();
        $booking = Booking::byKey($request->input('booking_key'))->first();

        $review->customer()->associate($user);
        $review->booking()->associate($booking);
        $review->service()->associate($booking->service);
        $review->save();

        return response(['message' => 'Review created'], 201);
    }
}
