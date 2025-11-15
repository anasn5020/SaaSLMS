<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Invoice\Entities\Invoice;

class MyInvoiceList extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function render()
    {
        $myInvoices = Invoice::withCount('courses')->with('user', 'offlinePayment')->where('user_id', auth()->user()->id)->latest()->paginate(10);
        return view(theme('components.my-invoice-list'), compact('myInvoices'));
    }
}
