<div class="modal-dialog modal-dialog-centered  modal_800px">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ __('common.User') }} {{ __('common.Details') }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal">
                <i class="ti-close "></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">

                            <table id="lms_table_student" class="table table-data ">
                                <tbody>
                                <tr>
                                    <th class="text-start">{{__('common.Name')}}</th>
                                    <td class="text-start">{{$user->name}}</td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('common.Email')}}</th>
                                    <td class="text-start">{{$user->email}}</td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('common.Phone')}}</th>
                                    <td class="text-start">{{$user->phone}}</td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('common.Currency')}}</th>
                                    <td class="text-start">{{$user->currency->name}}</td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('common.Language')}}</th>
                                    <td class="text-start">{{$user->language_name}}</td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('profile.timezone')}}</th>
                                    <td class="text-start">{{$user->userInfo?->timezone?->time_zone}}</td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('profile.job_title')}}</th>
                                    <td class="text-start">{{$user->job_title}}</td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('profile.short_description')}}</th>
                                    <td class="text-start">{{$user?->userInfo?->short_description}}</td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('profile.biography')}}</th>
                                    <td class="text-start">{{$user?->about}}</td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('profile.education')}}</th>
                                    <td class="text-start">
                                        @foreach($user?->userEducations as $education )
                                            <h4 class="mb-1">{{$education->institution}}</h4>
                                            <p class="text-muted">{{$education->degree}}</p>
                                            <small
                                                class="text-muted">{{showDate($education->start_date)}} @if($education->end_date)
                                                    -
                                                @endif {{showDate($education->end_date)}}</small>
                                        @endforeach

                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('profile.experience')}}</th>
                                    <td class="text-start">
                                        @foreach($user?->userExperiences as $experience )
                                            <h4 class="mb-1">{{$experience->title}}</h4>
                                            <p class="text-muted">{{$experience->company_name}}</p>
                                            @if($experience->duration())
                                                <small class="text-muted">{{showDate($experience->start_date)}}
                                                    - {{$experience->currently_working?'Present':showDate($experience->end_date)}}
                                                    [ {{$experience->duration()}} ]</small>
                                            @endif
                                        @endforeach

                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('profile.skills')}}</th>
                                    <td class="text-start">
                                        @if($user->userSkill && $user->userSkill->skills)
                                            @foreach(explode(',',$user->userSkill->skills) as $skill)
                                                <a href="javascript:void(0);" class="badge badge-custom">{{$skill}}</a>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('profile.financial')}}</th>
                                    <td class="text-start">
                                        {{$user?->userPayoutAccount?->payoutAccount?->title }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="text-start">{{__('common.gender')}}</th>
                                    <td class="text-start">
                                        {{$user?->gender}}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('common.Date of Birth')}}</th>
                                    <td class="text-start">
                                        {{$user->dob?date('m/d/Y',strtotime(@$user->dob)):''}}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('common.Country')}}</th>
                                    <td class="text-start">
                                        {{$user->userCountry->name}}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('common.State')}}</th>
                                    <td class="text-start">
                                        {{$user->stateDetails->name}}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('common.City')}}</th>
                                    <td class="text-start">
                                        {{$user->cityDetails->name}}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('common.Address')}}</th>
                                    <td class="text-start">
                                        {{$user->address}}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="text-start">{{__('profile.nid')}}</th>
                                    <td class="text-start">
                                        <img id="nid_show" class="center image_preview p-1"
                                             src="{{$nid_document?showImage($nid_document->document): showImage()}}"
                                             alt="NID">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('profile.passport')}}</th>
                                    <td class="text-start">
                                        <img id="passport_show" class="center image_preview p-1"
                                             src="{{$passport_document?showImage($passport_document->document): showImage()}}"
                                             alt="Passport">
                                    </td>
                                </tr>
                                @foreach($others_documents as $document)
                                    <tr>
                                        <th class="text-start">{{$document->name}}</th>
                                        <td class="text-start">

                                            <img data-id="{{$document->id}}"
                                                 id="ex_document_show_{{$document->id}}"
                                                 class="center image_preview ex_document_show p-2"
                                                 src="{{showImage($document->document)}}" alt="Document">

                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th class="text-start">{{__('common.Facebook URL')}}</th>
                                    <td class="text-start">
                                        {{$user->facebook}}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('common.Twitter URL')}}</th>
                                    <td class="text-start">
                                        {{$user->twitter}}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">{{__('common.Instagram URL')}}</th>
                                    <td class="text-start">
                                        {{$user->LinkedIn}}
                                    </td>
                                </tr>
                                @foreach($instant_messages as $i_msg)
                                    <tr>
                                        <th class="text-start">{{$i_msg->service}}</th>
                                        <td class="text-start">
                                            {{$i_msg->username}}
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

