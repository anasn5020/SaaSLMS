<?php

namespace App\Http\Resources\api\v1\Course;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\HLS\Entities\HlsVideo;

class CoursesDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $assistantInstructors = null;
        if (!empty($this->assistantInstructorsIds)) {
            foreach ($this->assistantInstructorsIds as $id) {
                $user = User::find($id);
                $assistantInstructors[] = [
                    'id' => (int)$user->id,
                    'name' => (string)$user->name,
                    'photo' => getProfileImage($user->image, $user->name),
                    'image' =>  getProfileImage($user->image, $user->name),
                    'avatar' => getProfileImage($user->image, $user->name),
                    'email' => (string)$user->email,
                    'phone' => (string)$user->phone,
                    'about' => (string)$user->about,
                    'total_rating' => (string)$user->total_rating,
                    'headline' => (string)$user->headline,
                ];
            }
        }

        $reviews = [];
        if (!empty($this->reviews)) {
            foreach ($this->reviews as $review) {
                $reviews[] = [
                    'id' => (int)$review->id,
                    'star' => (float)$review->star,
                    'comment' => (string)$review->comment,
                    'created_at' => (string)$review->created_at,
                    'userId' => (int)$review->userId,
                    'userName' => (string)$review->userName,
                    'userImage' =>  getProfileImage($review->userImage),
                ];
            }
        }

        $comments = [];
        if (!empty($this->comments)) {
            foreach ($this->comments as $comment) {
                $replies = [];
                if (!empty($comment->replies)) {
                    foreach ($comment->replies as $reply) {
                        $replies[] = [
                            'id' => (int)$reply->id,
                            'user_id' => (int)$reply->user_id,
                            'course_id' => (int)$reply->course_id,
                            'comment_id' => (int)$reply->comment_id,
                            'status' => (int)$reply->status,
                            'reply' => (string)$reply->reply,
                            'canDeleteReply' => (bool)$reply->canDeleteReply,
                            'replyDate' => (string)$reply->replyDate,
                            'user' => [
                                'id' => (int)$reply->user->id,
                                'role_id' => (int)$reply->user->role_id,
                                'name' => (string)$reply->user->name,
                                'photo' =>  getProfileImage($reply->user->image, $reply->user->name),
                                'image' =>  getProfileImage($reply->user->image, $reply->user->name),
                                'avatar' =>  getProfileImage($reply->user->image, $reply->user->name),
                            ],
                        ];
                    }
                }
                $comments[] = [
                    'id' => (int)$comment->id,
                    'user_id' => (int)$comment->user_id,
                    'course_id' => (int)$comment->course_id,
                    'instructor_id' => (int)$comment->instructor_id,
                    'status' => (int)$comment->status,
                    'comment' => (string)$comment->comment,
                    'canDelete' => (bool)$comment->canDelete,
                    'submittedDate' => (string)$comment->submittedDate,
                    'commentDate' => (string)$comment->commentDate,
                    'user' => [
                        'id' => (int)$comment->user->id,
                        'role_id' => (int)$comment->user->role_id,
                        'name' => (string)$comment->user->name,
                        'photo' =>  getProfileImage($comment->user->image, $comment->user->name),
                        'image' =>  getProfileImage($comment->user->image, $comment->user->name),
                        'avatar' =>  getProfileImage($comment->user->image, $comment->user->name),
                    ],
                    'replies' => $replies,
                ];
            }
        }

        $chapters = [];
        if (!empty($this->chapters)) {
            foreach ($this->chapters as $chapter) {
                $chapters[] = [
                    'id' => (int)$chapter->id,
                    'course_id' => (int)$chapter->course_id,
                    'name' => (string)$chapter->name,
                    'chapter_no' => (int)$chapter->chapter_no,
                    'is_lock' => (int)$chapter->is_lock,
                    'position' => (int)$chapter->position,
                ];
            }
        }

        $lessons = [];
        if (!empty($this->lessons)) {
            foreach ($this->lessons as $lesson) {
                $quizes = [];
                if (!empty($lesson->quiz)) {
                    foreach ($lesson->quiz as $quiz) {
                        $quizes[] = [
                            'id' => (int)$quiz->id,
                            'title' => (string)$quiz->title,
                            'percentage' => (float)$quiz->percentage,
                            'instruction' => (string)$quiz->instruction,
                            'status' => (int)$quiz->status,
                            'is_taken' => (int)$quiz->is_taken,
                            'is_closed' => (int)$quiz->is_closed,
                            'is_waiting' => (int)$quiz->is_waiting,
                            'is_running' => (int)$quiz->is_running,
                            'active_status' => (int)$quiz->active_status,
                            'category_id' => (int)$quiz->category_id,
                            'sub_category_id' => (int)$quiz->sub_category_id,
                            'course_id' => (int)$quiz->course_id,
                            'show_result_each_submit' => (int)$quiz->show_result_each_submit,
                            'multiple_attend' => (int)$quiz->multiple_attend,
                            'group_id' => (int)$quiz->group_id,
                            'show_ans_with_explanation' => (int)$quiz->show_ans_with_explanation,
                            'type' => (string)$quiz->type,
                            'losing_focus_acceptance_number' => (int)$quiz->losing_focus_acceptance_number,
                            'losing_type' => (int)$quiz->losing_type,
                            'show_ans_sheet' => (int)$quiz->show_ans_sheet,
                            'show_score_result' => (int)$quiz->show_score_result,
                            'multiple_attend_count' => (int)$quiz->multiple_attend_count,
                            'default_setting' => (int)$quiz->default_setting,
                            'show_correct_ans_in_ans_sheet' => (int)$quiz->show_correct_ans_in_ans_sheet,
                            'show_only_wrong_ans_in_ans_sheet' => (int)$quiz->show_only_wrong_ans_in_ans_sheet,
                            'show_total_correct_answer' => (int)$quiz->show_total_correct_answer,
                            'total_questions' => (int)$quiz->total_questions,
                            'total_marks' => (float)$quiz->total_marks,
                        ];
                    }
                }


                if (isModuleActive('HLS') && $lesson->host == 'm3u8') {

                    $extractId = extractId($lesson->video_url);
                    if ($extractId) {
                        $m3Video = HlsVideo::where([
                            'id' => $extractId
                        ])->first();
                    } else {
                        $m3Links = explode('/', $lesson->video_url);
                        $total = count($m3Links);
                        $m3Video = HlsVideo::where([
                            'playlist' => $m3Links[$total - 1] ?? '',
                            'id' => $m3Links[$total - 2] ?? 0,
                        ])->first();
                    }


                    if ($m3Video) {
                        $lesson->video_url = $m3Video->live_path;
                    }
                }

                $lessons[] = [
                    'id' => (int)$lesson->id,
                    'course_id' => (int)$lesson->course_id,
                    'chapter_id' => (int)$lesson->chapter_id,
                    'quiz_id' => (int)$lesson->quiz_id,
                    'is_completed'=>$lesson->completed?1:0,
                    'name' => (string)$lesson->name,
                    'description' => (string)$lesson->description,
                    'video_url' => (string)$lesson->video_url,
                    'host' => (string)$lesson->host,
                    'duration' => (int)$lesson->duration,
                    'is_lock' => (int)$lesson->is_lock,
                    'is_quiz' => (int)$lesson->is_quiz,
                    'position' => (int)$lesson->position,
                    'quiz' => $quizes,
                ];
            }
        }

        $files = [];
        if (!empty($this->files)) {
            foreach ($this->files as $file) {
                $files[] = [
                    'id' => (int)$file->id,
                    'course_id' => (int)$file->course_id,
                    'fileName' => (string)$file->fileName,
                    'file' => $file->file ? (string)asset($file->file) : '',
                    'lock' => (int)$file->lock,
                    'status' => (int)$file->status,
                ];
            }
        }

        return [
            'id' => (int)$this->id,
            'user_id' => (int)$this->user_id,
            'category_id' => (int)$this->category_id,
            'subcategory_id' => (int)$this->subcategory_id,
            'title' => (string)$this->title,
            'duration' => (int)$this->duration,
            'price' => (float)$this->price,
            'discount_price' => (float)$this->discount_price,
            'purchase_price' => (float)$this->purchasePrice,
            'publish' => (int)$this->publish,
            'enrolled_status' => (bool)@$this->isLoginUserEnrolled,
            'status' => (int)$this->status,
            'level' => [
                'id' => (int)$this->courseLevel->id,
                'title' => (string)$this->courseLevel->title,
            ],
            'image' => $this->image ? (string)asset($this->image) : '',
            'thumbnail' => $this->thumbnail ? (string)asset($this->thumbnail) : '',
            'host' => (string)$this->host,
            'about' => (string)$this->about,
            'total_enrolled' => (int)$this->enrollCount,
            'reveiw' => (int)$this->review,
            'type' => (int)$this->type,
            'subscription' => (int)$this->subscription,
            'requirements' => (string)$this->requirements,
            'outcomes' => (string)$this->outcomes,
            'total_rating' => (float)$this->total_rating,
            'scope' => (int)$this->scope,
            'complete_order' => (int)$this->complete_order,
            'certificate_id' => (int)$this->certificate_id,
            'show_overview_media' => (int)$this->show_overview_media,
            'show_mode_of_delivery' => (int)$this->show_mode_of_delivery,
            'mode_of_delivery' => (int)$this->mode_of_delivery,
            'view' => (int)$this->view,
            'feature' => (int)$this->feature,
            'offer' => (int)$this->offer,
            'instructors' => [
                'id' => (int)$this->instructor->id,
                'name' => (string)$this->instructor->name,

                'photo' =>  getProfileImage($this->instructor->image, $this->instructor->name),
                'image' =>  getProfileImage($this->instructor->image, $this->instructor->name),
                'avatar' =>  getProfileImage($this->instructor->image, $this->instructor->name),

                'email' => (string)$this->instructor->email,
                'phone' => (string)$this->instructor->phone,
                'about' => (string)$this->instructor->about,
                'total_rating' => (string)$this->instructor->total_rating,
                'headline' => (string)$this->instructor->headline,
            ],
            'assistant_instructors' => $assistantInstructors,
            'iap_product_id' => (string)$this->iap_product_id,
            'school_subject_id' => (int)$this->school_subject_id,
            'advance_test' => (int)$this->advance_test, //invalid
            'is_upcoming_course' => (int)$this->is_upcoming_course,
            'publish_status' => (int)$this->publish_status,
            'access_limit' => (int)$this->access_limit,
            'pro_certificate_id' => (int)$this->pro_certificate_id,
            'support' => (int)$this->support,
            'total_chapters' => (int)$this->total_chapters,
            'total_lessons' => (int)$this->total_lessons,
            'total_quiz_lessons' => (int)$this->total_quiz_lessons,
            'total_comments' => (int)$this->total_comments,
            'total_reviews' => (int)$this->total_reviews,
            'total_percentage' => (float)$this->total_percentage,
            'reviews' => $reviews,
            'review' => (int)$this->starWiseReview,
            'comments' => $comments,
            'dateFormat' => (string)$this->dateFormat,
            'publishedDate' => (string)$this->publishedDate,
            'sumRev' => (float)$this->sumRev,
            'purchasePrice' => (float)$this->purchasePrice,
            'enrollCount' => (int)$this->enrollCount,
            'course_level' => [
                'id' => (int)$this->courseLevel->id,
                'title' => (string)$this->courseLevel->title,
            ],
            'chapters' => $chapters,
            'lessons' => $lessons,
            'files' => $files,
        ];
    }
}
