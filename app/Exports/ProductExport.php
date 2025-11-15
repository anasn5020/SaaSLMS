<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductExport implements FromView
{

    protected $data;

    function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        // waitlist::courses.index
        $products = $this->data;
        return view('store::products.product_export', compact('products'));
    }
}
