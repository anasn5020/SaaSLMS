<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BlogDetailsShareSection extends Component
{
    public $blog;

    public function __construct($blog)
    {
        $this->blog = $blog;
    }

    public function render()
    {
        return view(theme('components.blog-details-share-section'));
    }
}
