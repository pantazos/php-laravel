<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Review;
use App\Models\Role;
use App\Models\Service;
use App\Models\Status;
use App\Observers\BookingObserver;
use App\Observers\CategoryObserver;
use App\Observers\PaymentMethodObserver;
use App\Observers\ReviewObserver;
use App\Observers\RoleObserver;
use App\Observers\ServiceObserver;
use App\Observers\StatusObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Review::observe(ReviewObserver::class);
        Booking::observe(BookingObserver::class);
        Category::observe(CategoryObserver::class);
        PaymentMethod::observe(PaymentMethodObserver::class);
        Service::observe(ServiceObserver::class);
        Status::observe(StatusObserver::class);
        Role::observe(RoleObserver::class);
    }
}
