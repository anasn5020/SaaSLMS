<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;
use Modules\Localization\Entities\Language;
use Modules\CourseSetting\Entities\CourseLevel;

class StorePageSection extends Component
{

    protected $request, $categories;

    public function __construct($request, $categories)
    {
        $this->request = $request;
        $this->categories = $categories;
    }

    public function render()
    {
        $query = Course::with('enrollUsers', 'cartUsers', 'quiz', 'quiz.assign', 'user', 'reviews', 'courseLevel', 'BookmarkUsers')->where('scope', 1);


        $type = $this->request->type;
        if (empty($type)) {
            $type = '';
        } else {
            $types = explode(',', $type);
            if (count($types) == 1) {
                foreach ($types as $t) {
                    if ($t == 'free') {
                        $query->where('price', 0);
                    } elseif ($t == 'paid') {
                        $query = $query->where('price', '>', 0);
                    }
                }
            }
        }

        $language = $this->request->language;
        if (empty($language)) {
            $language = '';
        } else {
            $row_languages = explode(',', $language);
            $languages = [];
            $LanguageList = Language::whereIn('code', $row_languages)->first();
            foreach ($row_languages as $l) {
                $lang = $LanguageList->where('code', $l)->first();
                if ($lang) {
                    $languages[] = $lang->id;
                }
            }
            $query->whereIn('lang_id', $languages);
        }


        $level = $this->request->level;
        if (empty($level)) {
            $level = '';
        } else {
            $levels = explode(',', $level);
            $query->whereIn('level', $levels);
        }
        if (isModuleActive('Org')) {
            $required_type_request = $this->request->required_type;
            if (!empty($required_type_request)) {
                $required_type = [];
                $types = explode(',', $required_type_request);
                foreach ($types as $type) {
                    if ($type == 'compulsory') {
                        $required_type[] = 1;
                    } elseif ($type == 'open') {
                        $required_type[] = 0;
                    }
                }
                $query->whereIn('required_type', $required_type);
            }
        }
        $mode = $this->request->mode;
        if (empty($mode)) {
            $mode = '';
        } else {
            $modes = explode(',', $mode);
            $query->whereIn('mode_of_delivery', $modes);
        }

        $category = $this->request->category;
        if (empty($category)) {
            $category = '';
        } else {
            $categories = explode(',', $category);

            $query->whereHas('quiz', function ($q) use ($categories) {
                $q->whereIn('category_id', $categories);
            });

        }
        $subCategory = $this->request->get('sub-category');
        if (!empty($subCategory)) {

            $query->whereHas('quiz', function ($q) use ($subCategory) {
                $q->where('sub_category_id', $subCategory);
            });

        }

        if (currentTheme() == 'tvt') {
            $subject = $this->request->get('subject');
            if (!empty($subject)) {
                $subjects = explode(',', $subject);
                $query->whereIn('school_subject_id', $subjects);

            }
        }

        $query->where('type', 2)->where('status', 1);

        $order = $this->request->order;

        if (currentTheme() == 'wetech') {
            if (empty($order)) {
                $query->latest();
            } else {
                if ($order == "title") {
                    $query->orderBy('title');
                } elseif ($order == "enroll") {
                    $query->orderBy('total_enrolled');
                } elseif ($order == "created_at") {
                    $query->orderBy('created_at');
                } elseif ($order == "end_date") {
                    $query->orderBy('required_type', 'desc');
                }
            }
        } else {
            if (empty($order)) {
                $query->orderBy('total_enrolled', 'desc');
            } else {
                if ($order == "price") {
                    $query->orderBy('price', 'desc');
                } else {
                    $query->latest();
                }
            }
        }

        $courses = $query->paginate(itemsGridSize());
        $total = $courses->total();
        $levels = CourseLevel::select('id', 'title')->where('status', 1)->get();

        // return view(theme('components.store-page-section'), compact('levels', 'mode', 'category', 'level', 'order', 'language', 'type', 'total', 'courses'));
        return view(theme('components.store-page-section'), compact('levels', 'order', 'category', 'level', 'order', 'language', 'type', 'total', 'courses', 'mode'));
    }
}
