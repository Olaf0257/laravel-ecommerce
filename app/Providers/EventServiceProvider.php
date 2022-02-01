<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        'App\Events\ProductSaved' => ['App\Listeners\MakeProductSearchable'],
        'App\Events\ProductDeleted' => ['App\Listeners\MakeProductUnsearchable'],
        'cart.added' => ['App\Listeners\UpdateCouponDiscount'],
        'cart.updated' => ['App\Listeners\UpdateCouponDiscount'],
        'cart.removed' => ['App\Listeners\UpdateCouponDiscount']
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
