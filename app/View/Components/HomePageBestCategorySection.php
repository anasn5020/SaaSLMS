<?php

namespace App\View\Components;

use Illuminate\View\Component;
use function Symfony\Component\Translation\t;

class HomePageBestCategorySection extends Component
{

    public $homeContent, $categories;

    public function __construct($homeContent, $categories)
    {
        $this->homeContent = $homeContent;
        $this->categories = $categories;
    }

    public function render()
    {
        return view(theme('components.home-page-best-category-section'));
    }
}
