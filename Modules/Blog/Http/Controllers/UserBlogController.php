<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ImageStore;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Entities\BlogCategory;

class UserBlogController extends Controller
{
    use ImageStore;

    public function index()
    {
        try {
            return view(theme('pages.my_blogs'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function create()
    {
        try {
            $categories = BlogCategory::where('status', 1)->get();
            return view(theme('pages.my_blog_create'), compact('categories'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function store(Request $request)
    {

        if (saasPlanCheck('blog_post')) {
            Toastr::error(trans('blog.You have reached blog post limit'), trans('common.Failed'));
            return redirect()->back();
        }
        if (demoCheck()) {
            return redirect()->back();
        }

        $code = auth()->user()->language_code;


        $rules = [
            'title.' . $code => 'required|max:255',
            "slug" => "required",
            "category" => "required",

        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $blog = new Blog;
            foreach ($request->title as $key => $name) {
                $blog->setTranslation('title', $key, $name);
            }
            foreach ($request->description as $key => $description) {
                $blog->setTranslation('description', $key, $description);
            }
            $blog->slug = $request->slug;
            $blog->category_id = $request->category;
            $blog->tags = $request->tags;
            $blog->user_id = Auth::id();
            $blog->institute_id = Auth::user()->institute_id;

            $blog->status = Settings('blog_auto_approval') == 1? 1 : 0;


            $blog->authored_date = !empty($request->publish_date) ? Carbon::createFromFormat('Y-m-d', $request->publish_date)->format('m/d/Y') : date('m/d/y');
            $blog->authored_time = !empty($request->publish_time) ? $request->publish_time : date('H:i:s');

            if ($request->hasFile('image')) {
                $blog->image = $this->saveImage($request->image);
                $blog->thumbnail = $this->saveImage($request->image);
            } else {
                $blog->image = '';
                $blog->thumbnail = '';
            }
            $code = auth()->user()->language_code??Settings('language_code');
            $blog->words_count  =$request->word_count_description[$code]??0;
            $blog->save();
            getBlogBonus($blog);

            if ($blog->status!=1 && Auth::user()->role_id != 1) {
                $admin =User::where('role_id', 1)->first();
                \App\Jobs\SendNotification::dispatch('BlogPostApproval', $admin, [
                    'name'=>$admin->name,
                    'blog_title'=>$blog->title,
                    'blog_author'=>Auth::user()->name,
                    'blog_date'=>$blog->authored_date,
                ],[
                    'actionText' =>trans('common.View'),
                    'actionUrl' => route('blogs.index'),
                ]);
            }

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('users.blog.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function show($id)
    {
        return view('blog::show');
    }


    public function edit($id)
    {
        try {
            $categories = BlogCategory::where('status', 1)->get();
            $blog = Blog::where('id', $id)->where('user_id', Auth::id())->first();
            if ($blog) {
                return view(theme('pages.my_blog_edit'), compact('categories', 'blog'));
            } else {
                Toastr::error(trans('blog.Blog not Found'), trans('common.Error'));
                return back();
            }

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    public function update(Request $request, $id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $rules = [
            "title.en" => "required",
            "slug" => "required",
            "category" => "required",

        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $blog = Blog::where('id', $id)->where('user_id', Auth::id())->first();
            if ($blog) {
                foreach ($request->title as $key => $name) {
                    $blog->setTranslation('title', $key, $name);
                }
                foreach ($request->description as $key => $description) {
                    $blog->setTranslation('description', $key, $description);
                }
                $blog->slug = $request->slug;
                $blog->category_id = $request->category;
                $blog->tags = $request->tags;
                $blog->user_id = Auth::id();

                $blog->status = Settings('blog_auto_approval') == 1? 1 : $blog->status;


                $blog->authored_date = !empty($request->publish_date) ? Carbon::createFromFormat('Y-m-d', $request->publish_date)->format('m/d/Y') : date('m/d/y');
                $blog->authored_time = !empty($request->publish_time) ? $request->publish_time : date('H:i:s');

                if ($request->hasFile('image')) {
                    $blog->image = $this->saveImage($request->image);
                    $blog->thumbnail = $this->saveImage($request->image);
                }
                $blog->save();

                $code = auth()->user()->language_code??Settings('language_code');
                $blog->words_count  =$request->word_count_description[$code]??0;
                $blog->save();
                getBlogBonus($blog);
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->route('users.blog.index');
            } else {
                Toastr::error(trans('blog.Blog not Found'), trans('common.Error'));
                return back();
            }


        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function delete($id)
    {
        try {
            $blog = Blog::where('id', $id)->where('user_id', Auth::id())->first();
            if ($blog) {
                $blog->delete();
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return back();
            }
            Toastr::error(trans('blog.Blog not Found'), trans('common.Error'));
            return redirect()->route('users.blog.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
