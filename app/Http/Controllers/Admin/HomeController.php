<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Review;
use App\Models\User;

class HomeController
{
    public function index()
    {
        $bookings = [
            'title' => trans('panel.bookings_card_title'),
            'count' => Booking::count()
        ];

        $earnings = [
            'title' => trans('panel.earnings_card_title'),
            'count' => Booking::all()->sum('total')
        ];

        $customers = [
            'title' => trans('panel.customers_card_title'),
            'count' => User::customer()->count()
        ];

        $providers = [
            'title' => trans('panel.providers_card_title'),
            'count' => User::provider()->count()
        ];

        $latestProviders = User::provider()->latest()->take(5)->get();

        $latestReviews = Review::latest()->take(5)->get();

        return view('home', compact('bookings', 'earnings', 'providers', 'customers',
            'latestProviders', 'latestReviews'));
    }
}
