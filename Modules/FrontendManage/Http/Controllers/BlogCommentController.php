<?php

namespace Modules\FrontendManage\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FrontendManage\Repositories\BlogCommentRepository;
use Yajra\DataTables\Facades\DataTables;

class BlogCommentController extends Controller
{

    protected $blogCommentRepository;

    public function __construct(BlogCommentRepository $blogCommentRepository)
    {
        $this->middleware('auth');
        $this->middleware('RoutePermissionCheck:blogs.comments.index', ['only' => ['index', 'datatable']]);
        $this->middleware('RoutePermissionCheck:blogs.comments.reply', ['only' => ['reply']]);
        $this->middleware('RoutePermissionCheck:blogs.comments.destroy', ['only' => ['destroy']]);

        $this->blogCommentRepository = $blogCommentRepository;
    }


    public function index()
    {
        try {
            return view('frontendmanage::blog_comments.index');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function reply(Request $request)
    {
        $request->validate([
            'comment' => 'required',
            'id' => 'required',
        ]);
        try {
            $msg = trans('blog.Replied') . ' ' . trans('lang.Successfully');
            $this->blogCommentRepository->reply($request->all());
            return response()->json(['msg' => $msg], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    public function datatable(Request $request)
    {

        try {

            $data = $this->blogCommentRepository->query($request->all());
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return showDate($row->created_at);
                })
                ->editColumn('type', function ($row) {
                    if ($row->type == 1) {
                        return trans('frontend.Main Comment');
                    } else {
                        return trans('frontend.Replied');
                    }
                })
                ->addColumn('user', function ($row) {
                    if ($row->user_id) {
                        return $row->user->name;
                    }
                    return $row->name;
                })
                ->addColumn('blog', function ($row) {
                    return view('frontendmanage::blog_comments.components._blog', ['row' => $row]);
                })
                ->editColumn('comment', function ($row) {
                    return view('frontendmanage::blog_comments.components._comment_btn', ['row' => $row]);
                })
                ->addColumn('status', function ($row) {
                    return view('frontendmanage::blog_comments.components._status', ['row' => $row]);
                })
                ->addColumn('action', function ($row) {
                    return view('frontendmanage::blog_comments.components._action', ['row' => $row]);
                })
                ->rawColumns(['action', 'comment', 'blog'])
                ->toJson();
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), trans('common.Failed'));
            return response()->json([
                'error' => $e->getMessage()
            ], 503);
        }


    }

    public function destroy(Request $request)
    {

        if (demoCheckById($request->id,range(1,10))) {
            return redirect()->back();
        }
        $request->validate([
            'id' => 'required'
        ]);

        try {
            $success = trans('lang.Deleted') . ' ' . trans('lang.Successfully');
            $this->blogCommentRepository->delete($request->id);
            Toastr::success($success, trans('common.Success'));
            return redirect()->back();

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }
}
