<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Traits\GoogleAnalytics4;
use App\Traits\ImageStore;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Entities\BlogCategory;
use Modules\Blog\Entities\BlogComment;

class BlogController extends Controller
{
    use GoogleAnalytics4, ImageStore;

    public function index(Request $request)
    {
        try {
            $blogs = Blog::where(function ($q) {
                $q->where('institute_id', auth()->user()->institute_id)
                    ->orWhereNull('institute_id')
                    ->orWhere('institute_id',0);

            })->when(!empty($request->query), function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->get('query') . '%');
                })
                ->when(!empty($request->status), function ($q) use ($request) {
                    $q->where('status', $request->get('status', 1));
                })
                ->paginate((int)$request->get('per_page', 10));

            $response = [
                'success' => true,
                'blogs' => $blogs,
                'message' => "Getting List",
            ];
            return response()->json($response, 200);

        } catch (Exception $exception) {
            $response = [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
            return response()->json($response, 500);
        }
    }

    public function store(Request $request)
    {

        $rules = [
            "title" => "required",
            "slug" => "required|unique:blogs",
            "category" => "required",

        ];
        $this->validate($request, $rules, validationMessage($rules));


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
        $blog->status = Settings('blog_auto_approval') == 1 ? 1 : 0;

        $blog->authored_date = !empty($request->publish_date) ? Carbon::createFromFormat('Y-m-d', $request->publish_date)->format('m/d/Y') : date('m/d/y');
        $blog->authored_time = !empty($request->publish_time) ? $request->publish_time : date('H:i:s');

        if ($request->hasFile('image')) {
            $blog->image = $this->saveImage($request->image);
            $blog->thumbnail = $this->saveImage($request->image);
        } else {
            $blog->image = '';
            $blog->thumbnail = '';
        }
        $blog->save();
        $response = [
            'success' => true,
            'message' => "Blog post added Successfully",
        ];
        return response()->json($response);
    }

    public function show($id)
    {
        try {

            $blog = Blog::where('user_id', Auth::user()->id)->find($id);

            if (!$blog) {
                return response()->json([
                    'success' => false,
                    'message' => 'Blog not found',
                ], 404);
            }

            $response = [
                'success' => true,
                'data' => $blog,
                'message' => "Getting Details",
            ];
            return response()->json($response);
        } catch (Exception $exception) {
            $response = [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
            return response()->json($response, 500);
        }
    }


    public function update(Request $request, $id)
    {

        $rules = [
            "title.en" => "required",
            "slug" => "required",
            "category" => "required",

        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $blog = Blog::where('id', $id)->where('user_id', Auth::id())->first();

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

            $blog->status = Settings('blog_auto_approval') == 1 ? 1 : $blog->status;


            $blog->authored_date = !empty($request->publish_date) ? Carbon::createFromFormat('Y-m-d', $request->publish_date)->format('m/d/Y') : date('m/d/y');
            $blog->authored_time = !empty($request->publish_time) ? $request->publish_time : date('H:i:s');

            if ($request->hasFile('image')) {
                $blog->image = $this->saveImage($request->image);
                $blog->thumbnail = $this->saveImage($request->image);
            }
            $blog->save();
            $response = [
                'success' => true,
                'message' => "Blog post updated Successfully",
            ];
            return response()->json($response);


        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
            return response()->json($response, 500);
        }

    }

    public function blogList(Request $request)
    {
        $query = Blog::where('status', 1)->with('user:id,name,image');
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


        if (Auth::check() && Auth::user()->role_id != 1) {
            $query->where(function ($q) {
                $institute_id = Auth::check() ? Auth::user()->institute_id : 0;
                $q->whereNull('institute_id')->orWhere('institute_id', $institute_id);
            });
        }
        $query->where('authored_date_time', '<=', date('Y-m-d H:i:s'));
        $blogs = $query->orderBy('id', 'desc')->paginate(10);

        $response = [
            'success' => true,
            'blogs' => $blogs,
            'message' => "Getting Details",
        ];
        return response()->json($response);

    }

    public function blogDetails($id)
    {

        $blog = Blog::where('id', $id)
            ->with(
                'user:id,name,image',
                'comments:id,user_id,name,email,comment,comment_id,blog_id',
                'comments.user:id,name,image',
                'comments.replies:id,user_id,name,email,comment,comment_id,blog_id',
                'comments.replies.user:id,name,image'
            )
            ->withCount('likers')->first();
        if (!$blog) {
            return response()->json([
                'success' => false,
                'message' => 'Blog not found',
            ], 404);
        }
        try {

            if ($blog->status == 0) {
                $response = [
                    'success' => false,
                    'message' => "Blog post is not active",
                ];
                return response()->json($response, 403);
            }
            $this->postEvent([
                'name' => 'view_blog',
                'params' => [
                    "items" => [
                        [
                            "item_id" => $blog->id,
                            "item_name" => $blog->title,
                        ]
                    ],
                ],
            ]);

            $current_date = Carbon::now();

            if (Carbon::parse($blog->authored_date_time)->gt($current_date)) {
                return response()->json([
                    'success' => false,
                    'message' => trans('blog.Blog is not published yet'),
                ], 403);

            }

            if (Auth::check() && Auth::user()->role_id != 1) {

                $institute_id = Auth::check() ? Auth::user()->institute_id : 0;
                if (!empty($blog->institute_id) && $blog->institute_id != $institute_id) {
                    return response()->json([
                        'success' => false,
                        'message' => trans('common.Access Denied'),
                    ], 403);
                }
            }


            $blog->viewed = $blog->viewed + 1;
            $blog->save();
            MarkAsBlogRead($blog->id);

            return response()->json([
                'success' => true,
                'data' => $blog,
                'message' => 'Getting Details',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function blogCommentList($blog_id)
    {
        $comments=  BlogComment::where('blog_id', $blog_id)->where('status',1)->where('type', 1)->with(
            'user:id,name,image',
            'replies:id,user_id,name,email,comment,comment_id,blog_id',
            'replies.user:id,name,image'
        )->get();

        return [
            'success' => true,
            'data' => $comments,
            'message' => "Getting comment list",
        ];
    }

    public function blogCommentSubmit($blog_id, Request $request)
    {
        if (!Auth::check()) {
            $validate_rules = [
                'name' => 'required',
                'email' => 'required|email',
                'comment' => 'required',
                'type' => 'required',

            ];
        } else {
            $validate_rules = [
                'comment' => 'required',
                'type' => 'required',
            ];
        }

        $request->validate($validate_rules, validationMessage($validate_rules));

        try {
            $comment = new BlogComment();
            if (\auth()->check()) {
                $comment->user_id = \auth()->id();
            } else {
                $comment->name = $request->name;
                $comment->email = $request->email;
            }

            $comment->comment = $request->comment;
            if ($request->type != 1) {
                $comment->comment_id = $request->comment_id;
            }
            $comment->blog_id = $blog_id;
            $comment->type = $request->type;
            $comment->save();
            checkGamification('each_comment', 'communication');

            $response = [
                'success' => true,
                'message' => "Blog comment added Successfully",
            ];
            return response()->json($response);
        } catch (Exception $exception) {
            $response = [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
            return response()->json($response, 500);
        }
    }

    public function blogCommentDelete($id)
    {
        $comment = BlogComment::findOrFail($id);

        try {
            if ($comment->type == 1) {
                $replies = $comment->replies;
                foreach ($replies as $reply) {
                    $sec_reply = $reply->second_replies;
                    foreach ($sec_reply as $item) {
                        $item->delete();
                    }

                    $reply->delete();
                }
            } else {
                $sec_reply = $comment->second_replies;
                foreach ($sec_reply as $item) {
                    $item->delete();
                }
            }

            $comment->delete();

            $response = [
                'success' => true,
                'message' => "Blog comment deleted Successfully",
            ];
            return response()->json($response);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $user = Auth::user();
            Blog::where('user_id', $user->id)->where('id', $id)->delete();
            $response = [
                'success' => true,
                'message' => "Blog delete successfully",
            ];
            return response()->json($response, 200);
        } catch (Exception $exception) {
            $response = [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
            return response()->json($response, 500);
        }
    }

    public function blogCategories()
    {
        $categories =BlogCategory::orderBy('position_order', 'asc')->where('status', 1)->get();
        $response = [
            'success' => true,
            'data'=>$categories,
            'message' => "getting blog categories",
        ];
        return response()->json($response, 200);
    }

}
