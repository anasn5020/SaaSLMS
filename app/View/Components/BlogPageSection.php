<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Entities\BlogCategory;

class BlogPageSection extends Component
{
    public function render()
    {
        $query = Blog::where('status', 1)->with('user','category');
        if (request('query')) {
            $query->where('title', 'LIKE', "%" . request('query') . "%");
        }

        if (request('category')) {
            $categories = explode(',', request('category'));
            foreach ($categories as $key => $cat) {
                $category = BlogCategory::find($cat);

                if ($category) {
                    $ids = $category->getAllChildIds($category);
                    $ids[count($ids)] = $cat;
                    if ($key == 0) {
                        $query->whereIn('category_id', $ids);
                    } else {
                        $query->orWhereIn('category_id', $ids);
                    }
                }
            }

        }

        if (isModuleActive('Org')) {
            $query->where(function ($q) {
                $q->where('audience', 1)
                    ->orWhere(function ($q) {
                        $q->where('audience', 2);
                        if (Auth::check()) {
                            if (Auth::user()->role_id != 1) {
                                $q->whereHas('branches', function ($q) {
                                    $q->whereIn('branch_id', getAllChildCodeIds(Auth::user()->branch, [Auth::user()->branch->id]));
                                });
                            }
                        } else {
                            $q->whereHas('branches', function ($q) {
                                $q->where('branch_id', 0);
                            });
                        }
                    });
            });

            $query->where(function ($q) {
                $q->where('position_audience', 1)
                    ->orWhere(function ($q) {
                        $q->where('position_audience', 2);
                        if (Auth::check()) {
                            if (Auth::user()->role_id != 1) {
                                $q->whereHas('positions', function ($q) {
                                    $q->whereIn('position_id', getAllChildCodeIds(Auth::user()->position, [Auth::user()->position->id]));
                                });
                            }
                        } else {
                            $q->whereHas('positions', function ($q) {
                                $q->where('position_id', 0);
                            });
                        }
                    });
            });

        }


        if (Auth::check() && Auth::user()->role_id == 3) {
            $query->where(function ($q) {
                $institute_id = Auth::check() ? Auth::user()->institute_id : 0;
                $q->whereNull('institute_id')->orWhere('institute_id', $institute_id);
            });
        }

        if (!Auth::check()) {
            $query->whereNull('institute_id');
        }
        $query->where('authored_date_time', '<=', date('Y-m-d H:i:s'));
        $blogs = $query->orderBy('id', 'desc')->paginate(10);
        return view(theme('components.blog-page-section'), compact('blogs'));
    }
}
