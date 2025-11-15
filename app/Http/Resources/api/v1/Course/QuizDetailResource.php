<?php

namespace App\Http\Resources\api\v1\Course;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizDetailResource extends JsonResource
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
                    'photo' => $user->photo ? (string)asset($user->photo) : '',
                    'image' => $user->image ? (string)asset($user->image) : '',
                    'avatar' => $user->avatar ? (string)asset($user->avatar) : '',
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

        $quiz = null;
        if (!empty($this->quiz)) {
            $q = $this->quiz;
            $assign = null;
            if (!empty($q->assign)) {
                foreach ($q->assign as $ass) {
                    $qBank = null;
                    if (!empty($ass->questionBank)) {
                        $qb = $ass->questionBank;
                        if (!empty($qb->questionMuInSerial)) {
                            $qMu = null;
                            foreach ($qb->questionMuInSerial as $qm) {
                                $qMu[] = [
                                    "id" => (int)$qm->id,
                                    "title" => (string)$qm->title,
                                    "status" => (int)$qm->status,
                                    "type" => (int)$qm->type,
                                    "option_index" => (int)$qm->option_index,
                                ];
                            }
                        }
                        $qBank = [
                            "id" => (int)$qb->id,
                            "type" => (string)$qb->type,
                            "question" => (string)$qb->question,
                            "marks" => (float)$qb->marks,
                            "trueFalse" => (bool)$qb->trueFalse,
                            "number_of_option" => (int)$qb->number_of_option,
                            "q_group_id" => (int)$qb->q_group_id,
                            "active_status" => (int)$qb->active_status,
                            "image" => $qb->image ? (string)asset($qb->image) : '',
                            "explanation" => (string)$qb->explanation,
                            "level" => (string)$qb->level,
                            "pre_condition" => (int)$qb->pre_condition,
                            "number_of_qus" => (int)$qb->number_of_qus,
                            "number_of_ans" => (int)$qb->number_of_ans,
                            "shuffle" => (int)$qb->shuffle,
                            "question_mu" => $qMu,
                        ];
                    }
                    $assign[] = [
                        "id" => (int)$ass->id,
                        "online_exam_id" => (int)$ass->online_exam_id,
                        "question_bank_id" => (int)$ass->question_bank_id,
                        "question_bank" => $qBank,
                    ];
                }
            }
            $quiz = [
                "id" => (int)$q->id,
                "title" => (string)$q->title,
                "percentage" => (int)$q->percentage,
                "instruction" => (string)$q->instruction,
                "status" => (int)$q->status,
                "is_taken" => (int)$q->is_taken,
                "is_closed" => (int)$q->is_closed,
                "is_waiting" => (int)$q->is_waiting,
                "is_running" => (int)$q->is_running,
                "active_status" => (int)$q->active_status,
                "random_question" => (int)$q->random_question,
                "question_time_type" => (int)$q->question_time_type,
                "question_time" => (string)$q->question_time,
                "question_review" => (int)$q->question_review,
                "show_result_each_submit" => (int)$q->show_result_each_submit,
                "multiple_attend" => (int)$q->multiple_attend,
                "group_id" => (int)$q->group_id,
                "show_ans_with_explanation" => (int)$q->show_ans_with_explanation,
                "type" => $q->type,
                "losing_focus_acceptance_number" => (int)$q->losing_focus_acceptance_number,
                "losing_type" => (int)$q->losing_type,
                "show_ans_sheet" => (int)$q->show_ans_sheet,
                "show_score_result" => (int)$q->show_score_result,
                "multiple_attend_count" => (int)$q->multiple_attend_count,
                "default_setting" => (int)$q->default_setting,
                "show_correct_ans_in_ans_sheet" => (int)$q->show_correct_ans_in_ans_sheet,
                "show_only_wrong_ans_in_ans_sheet" => (int)$q->show_only_wrong_ans_in_ans_sheet,
                "show_total_correct_answer" => (int)$q->show_total_correct_answer,
                "total_questions" => (int)$q->total_questions,
                "total_marks" => (int)$q->total_marks,
                "assign" => $assign,
            ];
        }
        $level = null;
        if($this->level){
            $lvl = $this->level;
            $level = [
                'id' => $lvl->id,
                'title' => $lvl->title,
            ];
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
            "duration" => (int)$this->duration,
            "image" => isset($this->image) ? asset($this->image) : '',
            "thumbnail" => isset($this->thumbnail) ? asset($this->thumbnail) : '',
            "price" => (float)$this->price,
            "discount_price" => (float)$this->discount_price,
            "purchase_price" => (float)$this->purchase_price,
            "publish" => (int)$this->publish,
            "status" => (int)$this->status,
            "level" => $level,
            "trailer_link" => (string)$this->trailer_link,
            "host" => (string)$this->host,
            "about" => (string)$this->about,
            "total_enrolled" => (int)$this->total_enrolled,
            "reveiw" => (int)$this->starWiseReview,
            "type" => (int)$this->type,
            "drip" => (int)$this->drip,
            "subscription" => (int)$this->subscription,
            "requirements" => (string)$this->requirements,
            "outcomes" => (string)$this->outcomes,
            "total_rating" => (float)$this->total_rating,
            "scope" => (int)$this->scope,
            "complete_order" => (int)$this->complete_order,
            "certificate_id" => (int)$this->certificate_id,
            "show_overview_media" => (int)$this->show_overview_media,
            "show_mode_of_delivery" => (int)$this->show_mode_of_delivery,
            "mode_of_delivery" => (int)$this->mode_of_delivery,
            "view" => (int)$this->view,
            "feature" => (int)$this->feature,
            "offer" => (int)$this->offer,
            "assistant_instructors" => $assistantInstructors,
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
            "required_type" => (int)$this->required_type,
            "waiting_list_status" => (int)$this->waiting_list_status,
            "is_all_member" => (int)$this->is_all_member,
            "is_membership" => (int)$this->is_membership,
            "membership_level_id" => (int)$this->membership_level_id,
            "iap_product_id" => (string)$this->iap_product_id,
            "school_subject_id" => (int)$this->school_subject_id,
            "advance_test" => (int)$this->advance_test, //invalid
            "is_upcoming_course" => (int)$this->is_upcoming_course,
            "publish_date" => (int)$this->publish_date,
            "pro_certificate_id" => (int)$this->pro_certificate_id,
            "support" => (int)$this->support,
            "total_chapters" => (int)$this->total_chapters,
            "total_lessons" => (int)$this->total_lessons,
            "total_quiz_lessons" => (int)$this->total_quiz_lessons,
            "total_comments" => (int)$this->total_comments,
            "total_reviews" => (int)$this->total_reviews,
            "reviews" => $reviews,
            "review" => (int)$this->starWiseReview,
            "comments" => $comments,
            "dateFormat" => (string)$this->dateFormat,
            "publishedDate" => (string)$this->publishedDate,
            "sumRev" => (float)$this->sumRev,
            "purchasePrice" => (float)$this->purchasePrice,
            "enrollCount" => (int)$this->enrollCount,
            "quiz" => $quiz,
        ];
    }
}
