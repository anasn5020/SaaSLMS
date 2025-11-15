<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Category;

class CategoryWithQuizCount extends Component
{

    public function render()
    {
        $categories = Category::where('status', 1)->with(
            'quizzesCategoryCount',
            'quizzesSubCategoryCount'
        )->get();
        return view(theme('components.category-with-quiz-count'), compact('categories'));
    }
}
