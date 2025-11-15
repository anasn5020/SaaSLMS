<?php

namespace Modules\Blog\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Jobs\BlogNotification;
use App\Traits\UploadMedia;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Entities\BlogCategory;
use Modules\Org\Entities\OrgBlogBranch;
use Modules\Org\Entities\OrgBlogPosition;
use Modules\Org\Entities\OrgBranch;
use Modules\StudentSetting\Entities\Institute;


class BlogController extends Controller
{
    use UploadMedia;

    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $query = Blog::with('user');
            if ($user->role_id == 2) {
                $query->where('user_id', $user->id);
            } else {
                if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                    $query->whereHas('user', function ($q) {
                        $q->where('organization_id', Auth::id());
                        $q->orWhere('id', Auth::id());
                    });
                }
            }
            if ($request->category) {
                $query->where('category_id', $request->category);
            }

            $query->with('category')->withCount('likers');

            $blogs = $query->latest()->get();

            $query2 = BlogCategory::with('user');

            $categories = $query2->where('status', 1)->orderBy('position_order', 'asc')->get();
            return view('blog::index', compact('blogs', 'categories'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function create()
    {
        $user = Auth::user();
        $query2 = BlogCategory::with('user');

        $categories = $query2->where('status', 1)->orderBy('position_order')->get();
        $data = [];
        if (isModuleActive('Org')) {
            $data['codes'] = [];
            $data['position_ids'] = [];
        }
        $data['institutes'] = Institute::where('status',1)->get();

        return view('blog::create', $data, compact('categories'));
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
            'category' => 'required',
            'slug' => ['required', Rule::unique('blogs', 'slug')->when(isModuleActive('LmsSaas'), function ($q) {
                return $q->where('lms_id', app('institute')->id);
            })],
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
            $blog->institute_id = $request->institute_id;
            $blog->slug = $request->slug;
            $blog->minutes = (int)$request->minutes;
            $blog->category_id = $request->category;
            $blog->tags = $request->tags;
            $blog->user_id = Auth::id();

            if (Settings('blog_auto_approval') == 1) {
                $status = 1;
            } else {
                $status = 0;
            }

            $blog->status = $status;


            $blog->authored_date = !empty($request->publish_date) ? getPhpDateFormat($request->publish_date) : date('m/d/y');
            $blog->authored_time = !empty($request->publish_time) ? $request->publish_time : date('H:i:s');


            $blog->save();
            if ($request->image) {
                $blog->image = $this->generateLink($request->image, $blog->id, get_class($blog), 'image');
                $blog->thumbnail = $this->generateLink($request->image, $blog->id, get_class($blog), 'thumbnail');
            }
            $code = auth()->user()->language_code??Settings('language_code');
            $blog->words_count  =$request->word_count_description[$code]??0;
            $blog->save();
            getBlogBonus($blog);

            checkGamification('each_blog_post', 'blogs');

            if (isModuleActive('Org')) {
                $blog->audience = $request->audience;
                $blog->position_audience = $request->position_audience;
                $blog->save();
                $this->saveOrgBlogBranch($blog, $request->branch);
                $this->saveOrgBlogPosition($blog, $request->position);

            }
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
            return redirect()->route('blogs.index');
        } catch (Exception $e) {
            dd($e);
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    public function saveOrgBlogBranch($blog, $branches): void
    {
        if ($blog->audience != 1) {
            if (!empty($branches)) {
                foreach ($branches as $key => $branch) {

                    $orgBranch = OrgBranch::with('childs')->find($branch);
                    if ($orgBranch) {
                        $ids = $orgBranch->getIds($orgBranch, [$orgBranch->id]);
                        foreach ($ids as $id) {
                            $data = [
                                'blog_id' => $blog->id,
                                'branch_id' => $id
                            ];
                            OrgBlogBranch::updateOrCreate(
                                $data
                            );
                        }
                    }
                }
            }
        }
    }

    public function saveOrgBlogPosition($blog, $positions): void
    {
        if ($blog->position_audience != 1) {
            if (!empty($positions)) {
                foreach ($positions as $key => $position) {
                    if ($position == 1) {
                        $branch = new OrgBlogPosition();
                        $branch->blog_id = $blog->id;
                        $branch->position_id = $key;
                        $branch->save();
                    }
                }
            }
        }
    }

    public function edit($id)
    {
        $user = Auth::user();

        $query2 = BlogCategory::with('user');

        $categories = $query2->where('status', 1)->orderBy('position_order')->get();
        $blog = Blog::findOrFail($id);
        $data = [];
        if (isModuleActive('Org')) {
            $branches = OrgBranch::orderBy('order', 'asc')->with('assignBranchInGroupPolicy');
            $org_policy_branch = OrgBlogBranch::where('blog_id', $blog->id)->pluck('branch_id')->toArray();
            $data['codes'] = $branches->whereIn('id', $org_policy_branch)->pluck('code')->toArray();
            $data['position_ids'] = OrgBlogPosition::where('blog_id', $blog->id)->pluck('position_id')->toArray();
        }

        $data['institutes'] = Institute::where('status',1)->get();
        return view('blog::edit', $data, compact('blog', 'categories'));
    }

    public function update(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'title' => 'required',
            'id' => 'required',
            'category' => 'required',
            'slug' => ['required', Rule::unique('blogs', 'slug')->ignore($request->slug, 'slug')->when(isModuleActive('LmsSaas'), function ($q, $request) {
                return $q->where('lms_id', app('institute')->id)->where('id', '!=', $request->id);
            })],
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {


            $blog = Blog::find($request->id);
            foreach ($request->title as $key => $name) {
                $blog->setTranslation('title', $key, $name);
            }
            foreach ($request->description as $key => $description) {
                $blog->setTranslation('description', $key, $description);
            }
            $blog->institute_id = $request->institute_id;
            $blog->slug = $request->slug;
            $blog->user_id = Auth::id();
            $blog->authored_date = !empty($request->publish_date) ? getPhpDateFormat($request->publish_date) : date('m/d/y');
            $blog->authored_time = !empty($request->publish_time) ? $request->publish_time : date('H:i:s');


            $blog->tags = $request->tags;
            $blog->category_id = $request->category;
            $blog->minutes = (int)$request->minutes;
            $blog->image = null;
            $blog->thumbnail = null;
            $blog->save();

            $this->removeLink($blog->id, get_class($blog));

            if ($request->image) {
                $blog->image = $this->generateLink($request->image, $blog->id, get_class($blog), 'image');
                $blog->thumbnail = $this->generateLink($request->image, $blog->id, get_class($blog), 'thumbnail');
            }
            $blog->save();

            $code = auth()->user()->language_code??Settings('language_code');
            $blog->words_count  =$request->word_count_description[$code]??0;
            $blog->save();

            getBlogBonus($blog);
            if (isModuleActive('Org')) {
                OrgBlogBranch::where('blog_id', $blog->id)->delete();
                OrgBlogPosition::where('blog_id', $blog->id)->delete();

                $blog->audience = $request->audience;
                $blog->position_audience = $request->position_audience;
                $blog->save();
                $this->saveOrgBlogBranch($blog, $request->branch);
                $this->saveOrgBlogPosition($blog, $request->position);
            }

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('blogs.index');

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    public function destroy(Request $request)
    {
        if (demoCheckById($request->id,range(1,10))) {
            return redirect()->back();
        }
        $rules = [
            'id' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $blog = Blog::findOrFail($request->id);

            if (isModuleActive('Org')) {
                OrgBlogBranch::where('blog_id', $blog->id)->delete();
            }
            $blog->delete();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }


    public function sendNotification($blog_id)
    {
        BlogNotification::dispatch($blog_id);
    }

    public function toggleLike($blog_id)
    {
        $user = Auth::user();
        $post = Blog::findOrFail($blog_id);

        $user->toggleLike($post);

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return back();
    }
}
