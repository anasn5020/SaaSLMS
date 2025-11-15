<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CourseSetting\Entities\CourseLevel;

class ClassPageSectionSidebar extends Component
{
    public $level, $type, $categories, $category, $languages, $language, $mode;

    public function __construct($level, $type, $categories, $category, $languages, $language, $mode)
    {
        $this->level = $level;
        $this->type = $type;
        $this->category = $category;
        $this->categories = $categories;
        $this->languages = $languages;
        $this->language = $language;
        $this->mode = $mode;
    }


    public function render()
    {
        $levels = CourseLevel::getAllActiveData();
        $required_type = request('required_type', '');
        return view(theme('components.class-page-section-sidebar'), compact('levels', 'required_type'));
    }
}
