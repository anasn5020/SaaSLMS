<?php

namespace App\Observers;

use Modules\Payment\Entities\Cart;
use Modules\Payment\Entities\Checkout;

class CheckoutObserver
{
    function resetCartCount($traking)
    {
        $cart = Cart::where('tracking', $traking)->get();

        $cart_count = $cart->count();
        $checkout = Checkout::where('tracking', $traking)->first();
        if ($checkout){
            $checkout->cart_count = $cart_count;

            if (isModuleActive('Gift')) {
                $gift_cart = $cart->where('is_gift', 1);
                $checkout->has_gift = $gift_cart->count();
            }
            $checkout->save();
        }


    }

    /**
     * Handle the Cart "created" event.
     */
    public function created(Checkout $checkout): void
    {
        $this->resetCartCount($checkout->tracking);
    }

    /**
     * Handle the Cart "updated" event.
     */
    public function updated(Checkout $checkout): void
    {
        $this->resetCartCount($checkout->tracking);
    }

    /**
     * Handle the Cart "deleted" event.
     */
    public function deleted(Checkout $checkout): void
    {
        $this->resetCartCount($checkout->tracking);
    }

    /**
     * Handle the Cart "restored" event.
     */
    public function restored(Checkout $checkout): void
    {
        $this->resetCartCount($checkout->tracking);
    }

    /**
     * Handle the Cart "force deleted" event.
     */
    public function forceDeleted(Checkout $checkout): void
    {
        $this->resetCartCount($checkout->tracking);
    }
}

