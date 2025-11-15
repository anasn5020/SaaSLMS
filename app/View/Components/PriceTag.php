<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PriceTag extends Component
{
    public $price, $discount,$text;

    public function __construct($price, $discount = null,$text =null)
    {
        $this->price = $price;
        $this->discount = $discount;
        $this->text=$text;
    }


    public function render()
    {
        return view(theme('components.price-tag'));
    }
}
