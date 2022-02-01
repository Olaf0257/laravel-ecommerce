<?php

namespace App\Jobs;

use App\Coupon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCouponSession implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $coupon;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subtotal = doubleval(Cart::subtotal(2, '.', ''));
        $tax = round((config('cart.tax') / 100) * $subtotal, 2);
        $newSubtotal = $subtotal + $tax;

        session()->put('coupon', [
            'code' => $this->coupon->code,
            'type' => $this->coupon->fixed_value ? Coupon::FIXED_VALUE : Coupon::PERCENT_OFF,
            'percent' => $this->coupon->percent_off ?? null, 
            'discount' => $this->coupon->discount($newSubtotal)
        ]);
    }
}
