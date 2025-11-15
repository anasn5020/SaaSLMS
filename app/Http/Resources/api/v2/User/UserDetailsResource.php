<?php

namespace App\Http\Resources\api\v2\User;

use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $nid = UserDocument::where('user_id', $this->id)->where('name', 'nid')->first();
        $passport = UserDocument::where('user_id', $this->id)->where('name', 'passport')->first();
        $otherDocuments = UserDocument::where('user_id', $this->id)->whereNotIn('name', ['nid', 'passport'])->pluck('document', 'name');

        $currency = null;
        if (isset($this->currency)) {
            $crncy = $this->currency;
            $currency = [
                'id' => $crncy->id ? (int)$crncy->id : null,
                'name' => (string)trim($crncy->name),
            ];
        }
        $language = null;
        if (isset($this->userLanguage)) {
            $lang = $this->userLanguage;
            $language = [
                'id' => $lang->id ? (int)$lang->id : null,
                'name' => (string)trim($lang->name),
            ];
        }
        $timezone = null;
        if (isset($this->userInfo) && isset($this->userInfo->timezone)) {
            $tz = $this->userInfo->timezone;
            $timezone = [
                'id' => $tz->id ? (int)$tz->id : null,
                'name' => (string)trim($tz->time_zone),
            ];
        }

        $country = null;
        if (isset($this->userCountry)) {
            $contry = $this->userCountry;
            $country = [
                'id' => $contry->id ? (int)$contry->id : null,
                'name' => (string)$contry->name,
            ];
        }

        $city = null;
        if (isset($this->cityDetails)) {
            $ct = $this->cityDetails;
            $city = [
                'id' => $ct->id ? (int)$ct->id : null,
                'name' => (string)$ct->name,
            ];
        }

        $state = null;
        if (isset($this->stateDetails)) {
            $stt = $this->stateDetails;
            $state = [
                'id' => $stt->id ? (int)$stt->id : null,
                'name' => (string)$stt->name,
            ];
        }

        return [
            'id'            => (int)$this->id,
            'basic_info'    => [
                'image'     => getProfileImage($this->image,$this->name),
                'name'      => (string)$this->name,
                'email'     => (string)$this->email,
                'phone'     => (string)$this->phone,
                'currency'  => $currency,
                'language'  => $language,
                'timezone'  => $timezone,
            ],
            'about'         => [
                'job_title' => (string)$this->job_title,
                'short_description' => (string)trim($this->userInfo->short_description),
                'biography' => (string)$this->about,
            ],
            'education'    => EducationResource::collection($this->userEducations),
            'experience'   => ExperienceResource::collection($this->userExperiences),
            'skills'        => [
                'name'      => (string)@$this->userSkill->skills
            ],
            'finantial' => (string)@$this->userPayoutAccount->payoutAccount->title,
            'api'   => [
                'zoom_api_key'          => (string)$this->zoom_api_key_of_user,
                'zoom_api_serect_key'   => (string)$this->zoom_api_serect_of_user
            ],
            'extra_information' => [
                'gender' => (string)$this->gender,
                'date_of_birth' => $this->dob ? (string)date('m-d-Y', strtotime($this->dob)): null,
                'country' => $country,
                'state' => $state,
                'city' => $city,
                'zip_code' => (string)$this->zip,
                'address' => (string)$this->address,
            ],
            'identity_and_documents' => [
                'nid'       => $nid?->document,
                'passport'  => $passport?->document,
                'other_documents' => $otherDocuments,
            ],
            'social_and_contact'  => [
                'facebook'  => (string)$this->facebook,
                'twitter'   => (string)$this->twitter,
                'linkedin'  => (string)$this->linkedin,
                'instagram'   => (string)$this->instagram,
                'others' => $this->otherSocialInfo->pluck('username', 'service'),
            ],
        ];
    }
}
