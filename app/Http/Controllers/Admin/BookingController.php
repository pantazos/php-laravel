<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\PromoCode;
use App\Models\Service;
use App\Models\ServiceExtra;
use App\Models\Status;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookings = Booking::with(['customer', 'provider', 'service', 'extras', 'status', 'promo_code'])->latest()->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function edit(Booking $booking)
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = User::get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $providers = User::get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $services = Service::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $extras = ServiceExtra::pluck('name', 'id');

        $statuses = Status::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $promo_codes = PromoCode::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $booking->load('customer', 'provider', 'service', 'extras', 'status', 'promo_code');

        return view('admin.bookings.edit', compact('customers', 'providers', 'services', 'extras', 'statuses', 'booking', 'promo_codes'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update($request->all());
        $booking->extras()->sync($request->input('extras', []));

        return redirect()->route('admin.bookings.index');
    }

    public function show(Booking $booking)
    {
        abort_if(Gate::denies('booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->load('customer', 'provider', 'service', 'extras', 'status', 'promo_code');

        return view('admin.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        abort_if(Gate::denies('booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->delete();

        return back();
    }

    public function massDestroy(MassDestroyBookingRequest $request)
    {
        Booking::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
