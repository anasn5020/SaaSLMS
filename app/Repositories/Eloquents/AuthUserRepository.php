<?php

namespace App\Repositories\Eloquents;

use App\User;
use Carbon\Carbon;
use App\Traits\Filepond;
use App\Models\UserSkill;
use App\Traits\ImageStore;
use App\Traits\UploadMedia;
use App\Models\UserDocument;
use App\Models\UserEducation;
use App\Models\UserExperience;
use Illuminate\Validation\Rule;
use App\Models\UserInstantMessage;
use Illuminate\Support\Facades\DB;
use Modules\Setting\Repositories\MediaManagerRepository;
use App\Repositories\Interfaces\AuthUserRepositoryInterface;

class AuthUserRepository implements AuthUserRepositoryInterface
{
    use /* UploadMedia, */ Filepond, ImageStore;
    private $mediaManagerRepository;
    public function __construct(MediaManagerRepository $mediaManagerRepository)
    {
        $this->mediaManagerRepository = $mediaManagerRepository;
    }
    public function basicInfoUpdate(object $request): bool
    {
        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->currency_id = $request->currency_id;
        $user->language_id = $request->language_id;
        $user->save();

        $user->userInfo()->updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'user_id' => auth()->id(),
                'timezone_id' => $request->timezone_id,
            ]
        );

        $rules = [
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
        ];
        $request->validate($rules, validationMessage($rules));
        if ($request->file('profile_image')) {
            $user->image = $this->saveImage($request->file('profile_image'));
            $user->save();
        }

        if ($request->file('cover_photo')) {
            $user->userInfo()->updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'user_id' => auth()->id(),
                    'cover_photo' => $this->saveImage($request->file('cover_photo')),
                ]
            );
        }
        return true;
    }
    public function aboutUpdate(object $request): bool
    {
        try {
            DB::transaction(function () use ($request) {
                $user = User::find(auth()->id());
                $user->update(['job_title' => $request->job_title, 'about' => $request->about]);

                $user->userInfo()->updateOrCreate(
                    ['user_id' => auth()->id()],
                    [
                        'user_id' => auth()->id(),
                        'short_description' => $request->short_description,
                    ]
                );
            });
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function educationStore(object $request): bool
    {
        $startDate = $request->start_date ? Carbon::createFromFormat('m-d-Y', $request->start_date)->format('Y-m-d') : null;
        $endDate = $request->end_date ? Carbon::createFromFormat('m-d-Y', $request->end_date)->format('Y-m-d') : null;

        UserEducation::create([
            'user_id' => auth()->id(),
            'institution' => $request->institution,
            'degree' => $request->degree,
            'start_date' => isset($request->start_date) ? $startDate : null,
            'end_date' => isset($request->end_date) ? $endDate : null,
        ]);
        return true;
    }
    public function educationUpdate(object $request): bool
    {
        $startDate = $request->start_date ? Carbon::createFromFormat('m-d-Y', $request->start_date)->format('Y-m-d') : null;
        $endDate = $request->end_date ? Carbon::createFromFormat('m-d-Y', $request->end_date)->format('Y-m-d') : null;

        UserEducation::where('id', $request->id)->update([
            'institution' => $request->institution,
            'degree' => $request->degree,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
        return true;
    }
    public function educationDestroy(object $request): bool
    {
        UserEducation::destroy($request->education_id);
        return true;
    }
    public function experienceStore(object $request): bool
    {
        UserExperience::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'company_name' => $request->company_name,
            'currently_working' => (bool) $request->is_currently_working,
            'start_date' => isset($request->start_date) ? Carbon::createFromFormat('m-d-Y', $request->start_date)->format('Y-m-d') : null,
            'end_date' => isset($request->end_date) ? Carbon::createFromFormat('m-d-Y', $request->end_date)->format('Y-m-d') : null,
        ]);
        return true;
    }
    public function experienceUpdate(object $request): bool
    {
        UserExperience::where('id', $request->experience_id)->update([
            'title' => $request->title,
            'company_name' => $request->company_name,
            'currently_working' => (bool)$request->is_currently_working,
            'start_date' => isset($request->start_date) ? Carbon::createFromFormat('m-d-Y', $request->start_date)->format('Y-m-d') : null,
            'end_date' => isset($request->end_date) ? Carbon::createFromFormat('m-d-Y', $request->end_date)->format('Y-m-d') : null,
        ]);
        return true;
    }
    public function experienceDestroy(object $request): bool
    {
        UserExperience::destroy($request->experience_id);
        return true;
    }
    public function skillStore(object $request): bool
    {
        UserSkill::updateOrCreate(
            [
                'user_id' => auth()->id(),
            ],
            [
                'user_id' => auth()->id(),
                'skills' => $request->skills,
            ]
        );
        return true;
    }
    public function extraInfoUpdate(object $request): bool
    {
        $request->merge([
            'country' => $request->country_id,
            'state' => $request->state_id,
            'city' => $request->city_id,
            'zip' => $request->zip_code,
        ]);

        User::where('id', auth()->id())->update([
            'gender' => $request->gender,
            'dob' => $request->dob ? Carbon::createFromFormat('m-d-Y', $request->dob)->format('Y-m-d') : null,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'zip' => $request->zip,
            'address' => $request->address,
        ]);
        return true;
    }
    public function documentUpdate(object $request): bool
    {
        $from = $request->get('from');
        $passport = UserDocument::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'name' => 'passport'
            ],
            [
                'document' => null,
            ]
        );
        if ($from == 'frontend') {
            if ($request->file('passport')) {
                $passport->document = $this->saveImage($request->file('passport'));
                $passport->save();
            }
        } else {
            if ($request->passport) {
                $passport->document = $this->saveImage($request->file('passport'));
                $passport->save();
            }
        }

        $nid = UserDocument::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'name' => 'nid'
            ],
            [
                'document' => null,
            ]
        );
        if ($from == 'frontend') {
            if ($request->file('nid')) {
                $nid->document = $this->saveImage($request->file('nid'));
                $nid->save();
            }
        } else {
            if ($request->nid) {
                $nid->document = $this->saveImage($request->file('nid'));
                $nid->save();
            }
        }

        $oldDocuments = UserDocument::where('user_id', auth()->id())
            ->where('name', '!=', 'passport')
            ->where('name', '!=', 'nid')
            ->get();
        if ($from != 'frontend') {
            foreach ($oldDocuments as $oldDocument) {
                $oldDocument->document = null;
                $oldDocument->save();
            }
        }

        if ($request->other_documents) {
            foreach ($request->other_documents as $key => $document) {
                if (isset($document['document_name']) && $document['document_name']) {
                    $userDoc = UserDocument::updateOrCreate(
                        [
                            'user_id' => auth()->id(),
                            'name' => $document['document_name']
                        ]
                    );
                    if ($from == 'frontend') {
                        if (isset($document['document_image']) && $document['document_image']) {
                            $userDoc->document = $this->saveImage($document->document_image);
                        }
                    } else {
                        if (isset($document['document_image'])) {
                            $userDoc->document = $userDoc->document = $this->saveImage($document->document_image);
                        }
                    }
                    $userDoc->save();
                }
            }
        }

        if ($request->document_name) {
            foreach ($request->document_name as $key => $document) {
                $userDoc = UserDocument::updateOrCreate(
                    [
                        'user_id' => auth()->id(),
                        'name' => $document
                    ]
                );
                if ($from == 'frontend') {
                    if (isset($request->document_image[$key]) && $request->document_image[$key]) {
                        $userDoc->document = $userDoc->document = $this->saveImage($request->document_image[$key]);
                    }
                } else {
                    if (isset($request->document_image[$key])) {
                        $userDoc->document = $this->saveImage($request->document_image[$key]);
                    }
                }
                $userDoc->save();
            }
        }
        return true;
    }
    public function socialInfoUpdate(object $request): bool
    {
        try {
            DB::transaction(function () use ($request) {
                User::where('id', auth()->id())->update([
                    'facebook' => $request->facebook,
                    'twitter' => $request->twitter,
                    'linkedin' => $request->linkedin,
                    'instagram' => $request->instagram,
                ]);

                UserInstantMessage::where('user_id', auth()->id())->delete();
                if ($request->instant_messaging) {
                    foreach ($request->instant_messaging as $msg) {
                        if ($msg['service'] && $msg['username']) {
                            UserInstantMessage::create([
                                'user_id' => auth()->id(),
                                'service' => $msg['service'],
                                'username' => $msg['username'],
                            ]);
                        }
                    }
                }
            });
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
