<?php

namespace App\Http\Resources\api\v2\Course;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        switch ($this->mode_of_delivery) {
            case 1:
                $deliveryMode = [
                    'id' => 1,
                    'name' => 'Online',
                ];
                break;

            case 2:
                $deliveryMode = [
                    'id' => 2,
                    'name' => 'Distance Learning',
                ];
                break;

            case 3:
                $deliveryMode = [
                    'id' => 3,
                    'name' => 'Face To Face',
                ];
                break;

            default:
                $deliveryMode = [
                    'id' => 1,
                    'name' => 'Online',
                ];
                break;
        }

        switch ($this->scope) {
            case 0:
                $scope = [
                    'id' => 0,
                    'name' => 'Private',
                ];
                break;
            case 1:
                $scope = [
                    'id' => 1,
                    'name' => 'Public',
                ];
                break;
            default:
                $scope = [
                    'id' => 0,
                    'name' => 'Private',
                ];
                break;
        }

        $assistantInstructors = [];
        foreach (json_decode($this->assistant_instructors) ?? [] as $assIns) {
            $user = User::find($assIns);
            $assistantInstructors[] = [
                'id'    => (int)$user->id,
                'name'  => (string)$user->name,
            ];
        }

        $chapters = [];
        foreach ($this->chapters ?? [] as $chap) {
            $chapters[] = [
                'id'            => (int)$chap->id,
                'course_id'     => (int)$chap->course_id,
                'name'          => (string)$chap->name,
                'chapter_no'    => (float)$chap->chapter_no,
                'is_lock'       => (int)$chap->is_lock,
                'position'      => (int)$chap->position,
            ];
        }

        $files = [];
        foreach ($this->files as $file) {
            $files[] = [
                'id'        => (int)$file->id,
                'course_id' => (int)$file->course_id,
                'fileName'  => (string)$file->fileName,
                'file'      => file_exists($file->file) ? (string)asset($file->file) : '',
                'lock'      => (int)$file->lock,
                'status'    => (int)$file->status,
            ];
        }

        $pricePlans = null;
        if (isModuleActive('EarlyBird')) {
            if(!empty($this->pricePlans)) {
                $pricePlans = PricePlansResource::collection($this->pricePlans);
            }
        }


        if ($this->certificate->id) {
            $cretificate = [
                'id' => (int)$this->certificate->id,
                'name' => (string)trim($this->certificate->title),
            ];
        } else {
            $cretificate = null;
        }

        if ($this->quiz->id) {
            $quiz = [
                'id' => (int)$this->quiz->id,
                'name' => (string)trim($this->quiz->title),
            ];
        } else {
            $quiz = null;
        }

        return [
            'id'                            => (int)$this->id,
            'type'                          => (int)$this->type,
            'title'                         => (string)$this->title,
            'category'                      => [
                'id'    => (int)$this->category->id,
                'name'  => (string)$this->category->name,
            ],
            'subcategory'                   => [
                'id'    => (int)$this->subCategory->id,
                'name'  => (string)$this->subCategory->name,
            ],
            'language'                      => [
                'id'    => (int)$this->language->id,
                'name'  => (string)$this->language->name,
            ],
            'image'                         => file_exists($this->image) ? (string)asset($this->image) : '',
            'thumbnail'                     => file_exists($this->thumbnail) ? (string)asset($this->thumbnail) : '',
            'requirement'                   => (string)$this->requirements,
            'description'                   => (string)$this->about,
            'outcome'                       => (string)$this->outcomes,
            'mode_of_delivery'              => $deliveryMode,
            'level'                         => [
                'id'    => (int)$this->courseLevel->id,
                'title' => (string)$this->courseLevel->title,
            ],
            'duration'                      => (float)$this->duration,
            'free_course'                   => $this->price > 0 ? false : true,
            'price'                         => (float)$this->price,
            'sequence'                      => (bool)$this->complete_order,
            'discount_course'               => (bool)$this->discount_price,
            'discount_price'                => (float)$this->discount_price,
            'in_app_purchase_course'        => (bool)$this->iap_product_id,
            'in_app_purchase_product_id'    => (string)$this->iap_product_id,
            'support'                       => (bool)$this->support,
            'is_upcoming_course'            => (bool)$this->is_upcoming_course,
            'publish_date'                  => (string)date('m-d-Y', strtotime($this->publish_date)),
            'is_allow_prebooking'           => (bool)$this->is_allow_prebooking,
            'booking_amount'                => (float)$this->booking_amount,
            'view_scope'                    => $scope,
            'drip_content'                  => (bool)$this->drip,
            'meta_keyword'                  => (string)$this->meta_keywords,
            'meta_description'              => (string)$this->meta_description,
            'total_enrolled'                => (int)$this->total_enrolled,
            'reveiw'                        => (float)$this->reveiw,
            'veiw'                          => (int)$this->veiw,
            'assign_instructor'             => [
                'id'    => (int)$this->instructor->id,
                'name'  => (string)$this->instructor->name
            ],
            'assistant_instructor'          => $assistantInstructors,
            'chapters'                      => (array)$chapters,
            'files'                         => $files,
            'assign_certificate'            => $cretificate,
            'quiz'                          => $quiz,
            'price_plan'                    => $pricePlans,
            'access_limit_in_days'          => (int)$this->access_limit,
        ];
    }
}
