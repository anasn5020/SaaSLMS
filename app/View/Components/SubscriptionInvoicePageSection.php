<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SubscriptionInvoicePageSection extends Component
{
    public $enroll;

    public function __construct($enroll)
    {
        $this->enroll = $enroll;
    }

    public function render()
    {
        return view(theme('components.subscription-invoice-page-section'));
    }
}
