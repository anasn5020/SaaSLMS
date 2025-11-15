<?php

namespace App\Http\Resources\api\v1\Course;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassDetailResource extends JsonResource
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
                if(!$user){
                    continue;
                }
                $assistantInstructors[] = [
                    'id' => (int)$user->id,
                    'name' => (string)$user->name,
                    'photo' => $user->photo ? (string)asset($user->photo) : '',
                    'image' => $user->image ? (string)asset($user->image) : '',
                    'avatar' => $user->avatar ? (string)asset($user->avatar) : '', // cancel
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
                    'status' => (int)$review->status,
                    'star' => (float)$review->star,
                    'comment' => (string)$review->comment,
                    'created_at' => (string)$review->created_at,
                    'userId' => (int)$review->userId,
                    'userName' => (string)$review->userName,
                    'userImage' => $review->userImage ? asset($review->userImage) : null,
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
                                'photo' => $reply->user->photo ? (string)asset($reply->user->photo) : '',
                                'image' => $reply->user->image ? (string)asset($reply->user->image) : '',
                                'avatar' => $reply->user->avatar ? (string)asset($reply->user->avatar) : '',
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
                    'replies' => $replies,
                ];
            }
        }

        $zooms = null;
        $bbbs = null;
        $jitsis = null;
        $customs = null;
        if ($this->class) {
            switch ($this->class->host) {
                case 'Zoom':
                    if (!empty($this->class->zoomMeetings)) {
                        foreach ($this->class->zoomMeetings as $zoom) {
                            $zooms[] = $zoom;
                        }
                    }
                    break;
                case 'BBB':
                    if (!empty($this->class->bbbMeetings)) {
                        foreach ($this->class->bbbMeetings as $bbb) {
                            $bbbs[] = $bbb;
                        }
                    }
                    break;
                case 'Jitsi':
                    if (!empty($this->class->jitsiMeetings)) {
                        foreach ($this->class->jitsiMeetings as $jitsi) {
                            $jitsis[] = $jitsi;
                        }
                    }
                    break;
                case 'Custom':
                    if (!empty($this->class->customMeetings)) {
                        foreach ($this->class->customMeetings as $custom) {
                            $customs[] = $custom;
                        }
                    }
                    break;

                default:
                    break;
            }
        }

        return [
            "id" => (int)$this->id,
            "category_id" => (int)$this->category_id,
            "subcategory_id" => (int)$this->subcategory_id,
            "quiz_id" => (int)$this->quiz_id,
            "class_id" => (int)$this->class_id,
            "user_id" => (int)$this->user_id,
            "lang_id" => (int)$this->lang_id,
            "title" => (string)$this->title,
            "enrolled_status" => (bool)@$this->isLoginUserEnrolled,
            "duration" => (int)$this->duration,
            "image" => $this->image ? (string)asset($this->image) : '',
            "thumbnail" => $this->thumbnail ? (string)asset($this->thumbnail) : '',
            "price" => (float)$this->price,
            "discount_price" => (float)$this->discount_price,
            "publish" => (int)$this->publish,
            "status" => (int)$this->status,
            "level" => (int)$this->level,
            "trailer_link" => (string)$this->trailer_link,
            "host" => (string)$this->host,
            "about" => (string)$this->about,
            "total_enrolled" => (int)$this->enrollCount,
            "reveune" => (int)$this->reveune,
            "reveiw" => (int)$this->review,
            "type" => (int)$this->type,
            "subscription" => (int)$this->subscription,
            "requirements" => (string)$this->requirements,
            "outcomes" => (string)$this->outcomes,
            "total_rating" => (int)$this->total_rating,
            "scope" => (int)$this->scope,
            "complete_order" => (int)$this->complete_order,
            "certificate_id" => (int)$this->certificate_id,
            "show_overview_media" => (int)$this->show_overview_media,
            "show_mode_of_delivery" => (int)$this->show_mode_of_delivery,
            "mode_of_delivery" => (int)$this->mode_of_delivery,
            "view" => (int)$this->view,
            "feature" => (int)$this->feature,
            "offer" => (int)$this->offer,
            "instructors" => [
                'id' => (int)$this->instructor->id,
                'name' => (string)$this->instructor->name,
                'photo' => $this->instructor->photo ? (string)asset($this->instructor->photo) : '',
                'image' => $this->instructor->image ? (string)asset($this->instructor->image) : '',
                'avatar' => $this->instructor->avatar ? (string)asset($this->instructor->avatar) : '',
                'email' => (string)$this->instructor->email,
                'phone' => (string)$this->instructor->phone,
                'about' => (string)$this->instructor->about,
                'total_rating' => (string)$this->instructor->total_rating,
                'headline' => (string)$this->instructor->headline,
            ],
            'assistant_instructors' => $assistantInstructors,
            "required_type" => (int)$this->required_type,
            "waiting_list_status" => (int)$this->waiting_list_status,
            "is_all_member" => (int)$this->is_all_member,
            "is_membership" => (int)$this->is_membership,
            "membership_level_id" => (int)$this->membership_level_id,
            "iap_product_id" => (int)$this->iap_product_id,
            "school_subject_id" => (int)$this->school_subject_id,
            "advance_test" => (int)$this->advance_test,
            "publish_date" => (int)$this->publish_date,
            "publish_status" => (int)$this->publish_status,
            "is_allow_prebooking" => (int)$this->is_allow_prebooking,
            "booking_amount" => (float)$this->booking_amount,
            "access_limit" => (int)$this->access_limit,
            "pro_certificate_id" => (int)$this->pro_certificate_id,
            "support" => (int)$this->support,
            "total_chapters" => (int)$this->total_chapters,
            "total_lessons" => (int)$this->total_lessons,
            "total_quiz_lessons" => (int)$this->total_quiz_lessons,
            "total_comments" => (int)$this->total_comments,
            "total_reviews" => (int)$this->total_reviews,
            'reviews' => $reviews,
            'review' => (int)$this->starWiseReview,
            'comments' => $comments,
            "dateFormat" => (string)$this->dateFormat,
            "publishedDate" => (string)$this->publishedDate,
            "purchasePrice" => (float)$this->purchasePrice,
            "enrollCount" => (int)$this->enrollCount,
            'course_level' => [
                'id' => (int)$this->courseLevel->id,
                'title' => (string)$this->courseLevel->title,
            ],
            "class" => [
                "id" => (int)$this->class->id,
                "fees" => (float)$this->class->fees,
                "type" => (int)$this->class->type,
                "start_date" => (string)$this->class->start_date,
                "end_date" => (string)$this->class->end_date,
                "time" => (string)$this->class->time,
                "image" => $this->class->image ? (string)asset($this->class->image) : '',
                "host" => (string)$this->class->host,
                "lang_id" => (int)$this->class->lang_id,
                "status" => (int)$this->class->status,
                "total_class" => (int)$this->class->total_class,
                "is_all_member" => (int)$this->class->is_all_member,
                "is_membership" => (int)$this->class->is_membership,
                "zoom_meetings" => $zooms,
                "custom_meetings" => $customs,
                "bbb_meetings" => $bbbs,
                "jitsi_meetings" => $jitsis,
            ],
        ];
    }
}
