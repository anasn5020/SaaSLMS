<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InstallmentOverviewPageSection extends Component
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $installmentData = $this->data;
        return view(theme('components.installment-overview-page-section'), compact('installmentData'));
    }
}
