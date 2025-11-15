<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;

class OfferPageSection extends Component
{
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }


    public function render()
    {
        $query = Course::orderBy('total_enrolled', 'desc')->with('user', 'category', 'subCategory', 'enrolls', 'comments', 'reviews', 'lessons', 'activeReviews', 'enrollUsers', 'cartUsers', 'courseLevel')->where('scope', 1);


        $query->where('type', 1)->where('offer', 1)->where('status', 1);

        $order = $this->request->order;
        if (empty($order)) {
            $order = '';
        } else {
            if ($order == "price") {
                $query->orderBy('price', 'asc');
            } else {
                $query->latest();
            }
        }
        $courses = $query->paginate(12);
        $total = $courses->total();
        return view(theme('components.offer-page-section'), compact('order', 'order', 'total', 'courses'));

    }
}
