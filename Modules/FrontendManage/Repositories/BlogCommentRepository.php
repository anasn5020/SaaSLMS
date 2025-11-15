<?php

namespace Modules\FrontendManage\Repositories;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Entities\BlogComment;


class BlogCommentRepository
{

    public function query($data = [])
    {

        $query = BlogComment::query();
        if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
            $query->whereHas('blog.user', function ($q) {
                $q->where('organization_id', Auth::id());
                $q->orWhere('id', Auth::id());
            });
        }

        if (isModuleActive('LmsSaas')) {
            $query->where('lms_id', app('institute')->id);
        } else {
            $query->where('lms_id', 1);
        }
        if (isset($data['f_type']) && $data['f_type']) {
            $query->where('type', $data['f_type']);
        }
        if (isset($data['f_status']) && $data['f_status']) {
            if ($data['f_status'] == 'published') {
                $query->where('status', 1);
            } elseif ($data['f_status'] == 'pending') {
                $query->where('status', 0);
            }
        }

        if (isset($data['f_date']) && $data['f_date']) {
            $query->whereBetween(DB::raw('DATE(created_at)'), formatDateRangeData($data['f_date']));
        }


        $query->with(['user', 'blog'])->select('blog_comments.*');

        return $query;

    }

    public function delete($id)
    {
        $query = BlogComment::find($id);
        if ($query) {
            foreach ($query->replies as $q) {
                $q->delete();
            }
            $query->delete();
        }

        return true;
    }

    public function reply(array $data)
    {
        $row = BlogComment::where('id', $data['id'])->first();
        return BlogComment::create([
            'user_id' => Auth::id(),
            'comment' => $data['comment'],
            'comment_id' => $data['id'],
            'type' => 2,
            'blog_id' => $row->blog_id,
        ]);
    }


}
