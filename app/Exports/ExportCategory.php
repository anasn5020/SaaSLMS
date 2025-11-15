<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Modules\CourseSetting\Entities\Category;

class ExportCategory implements FromView
{

    public function view(): View
    {
        $categories = Category::whereNull('parent_id')->latest()->get();

        return view('quiz::exports.categories', [
            'categories' => $categories
        ]);
    }
}
