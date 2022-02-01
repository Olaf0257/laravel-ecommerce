<?php

namespace App\Listeners;

use App\Coupon;
use App\Jobs\UpdateCouponSession;
use Illuminate\Queue\InteractsWithQueue;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateCouponDiscount
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if ($couponSession = session()->get('coupon')) {
            $coupon = Coupon::where('code', $couponSession['code'])->first();

            dispatch_now(new UpdateCouponSession($coupon));
        }
    }
}
