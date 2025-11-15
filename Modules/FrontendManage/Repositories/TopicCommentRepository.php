<?php

namespace Modules\FrontendManage\Repositories;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\CourseSetting\Entities\CourseComment;
use Modules\CourseSetting\Entities\CourseCommentReply;


class TopicCommentRepository
{


    public function query($data = [])
    {
        $instituteId = isModuleActive('LmsSaas') ? app('institute')->id : 1;

        // Fetch comments
        $courseComments = CourseComment::where('course_comments.lms_id', $instituteId)
            ->join('users', 'course_comments.user_id', '=', 'users.id')
            ->join('courses', 'courses.id', '=', 'course_comments.course_id')
            ->select(
                'users.name as user_name',
                'courses.title as course_title',
                'course_comments.comment',
                'course_comments.created_at',
                'course_comments.id',
                'course_comments.user_id',
                'course_comments.course_id',
                'course_comments.status',
                DB::raw("'Main Comment' as type"),
                DB::raw("'course_comments' as source_table"),
                DB::raw("'null' as reply_id")
            )
            ->get();

        // Fetch replies
        $courseCommentReplies = CourseCommentReply::where('course_comment_replies.lms_id', $instituteId)
            ->join('users', 'course_comment_replies.user_id', '=', 'users.id')
            ->join('courses', 'courses.id', '=', 'course_comment_replies.course_id')
            ->select(
                'users.name as user_name',
                'courses.title as course_title',
                'course_comment_replies.reply as comment',
                'course_comment_replies.created_at',
                'course_comment_replies.id',
                'course_comment_replies.user_id',
                'course_comment_replies.course_id',
                'course_comment_replies.status',
                DB::raw("'Reply' as type"),
                DB::raw("'course_comment_replies' as source_table"),
                'course_comment_replies.reply_id as reply_id'
            )
            ->get();

        // Merge the collections
        $combined = $courseComments->merge($courseCommentReplies);

        // Optionally apply additional filters after combining
        if (!empty($data['f_date'])) {
            $dateRange = formatDateRangeData($data['f_date']);
            $combined = $combined->whereBetween('created_at', $dateRange);
        }

        if (!empty($data['f_user'])) {
            $combined = $combined->where('user_id', $data['f_user']);
        }

        if (!empty($data['f_course'])) {
            $combined = $combined->where('course_id', $data['f_course']);
        }

        // Sort the combined collection (optional)
        $combined = $combined->sortByDesc('created_at')->values();

        return $combined;
    }



    public function delete($id, $table)
    {
        if ($table == 'course_comments') {
            $row = CourseComment::find($id);
            if ($row) {
                foreach ($row->replies as $q) {
                    $q->delete();
                }
                $row->delete();
            }
        }

        if ($table == 'course_comment_replies') {
            $row = CourseCommentReply::find($id);
            if ($row) {
                if ($row->reply_id) {
                    $row->delete();
                } else {
                    $replies = CourseCommentReply::where('reply_id', $id)->get();
                    foreach ($replies as $q) {
                        $q->delete();
                    }
                    $row->delete();
                }


            }
        }


        return true;
    }

    public function reply(array $data)
    {
        if ($data['table'] == 'course_comments') {
            $row = CourseComment::where('id', $data['id'])->first();
            return CourseCommentReply::create([
                'user_id' => Auth::id(),
                'course_id' => $row->course_id,
                'comment_id' => $data['id'],
                'reply' => $data['comment'],
                'reply_id' => null,
            ]);

        }

        if ($data['table'] == 'course_comment_replies') {
            $row = CourseCommentReply::where('id', $data['id'])->first();
            return CourseCommentReply::create([
                'user_id' => Auth::id(),
                'course_id' => $row->course_id,
                'comment_id' => $row->comment_id,
                'reply' => $data['comment'],
                'reply_id' => $data['id']
            ]);

        }

    }


}
