@extends('backend.master')
@section('mainContent')
    <style>
        @media (max-width: 991px) {
            .input-effect {
                margin-bottom: 30px;
            }
        }
    </style>
    {{generateBreadcrumb()}}
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('zoom.settings.update') }}" method="POST">
                        @csrf
                        <div class="white-box">
                            <div class="row p-0">
                                <div class="col-lg-12">
                                    <div class="row mb-40 mt-40">


                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('zoom.Auto Recording')}}
                                                    </p>
                                                </div>

                                                <div class="col-lg-4 mb-25 p-0">
                                                    <label class="primary_checkbox d-flex mr-12"
                                                           for="auto_recording_none">
                                                        <input type="radio" name="auto_recording"
                                                               id="auto_recording_none" value="none"
                                                               class="common-radio relationButton"@if(!empty($setting))
                                                            {{ old('auto_recording',$setting->auto_recording) == 'none' ? 'checked': ''}}
                                                            @endif>
                                                        <span
                                                            class="checkmark me-2"></span> {{__('zoom.None')}}
                                                    </label>
                                                </div>
                                                <div class="col-lg-4 mb-25 p-0">
                                                    <label class="primary_checkbox d-flex mr-12"
                                                           for="auto_recording_local">
                                                        <input type="radio" name="auto_recording"
                                                               id="auto_recording_local" value="local"
                                                               class="common-radio relationButton"@if(!empty($setting))
                                                            {{ old('auto_recording',$setting->auto_recording) == 'local' ? 'checked': ''}}
                                                            @endif>
                                                        <span
                                                            class="checkmark me-2"></span> {{__('zoom.Local')}}
                                                    </label>
                                                </div>
                                                @if(isModuleActive('ZoomPro'))
                                                    <div class="col-lg-4 mb-25 p-0">
                                                        <label class="primary_checkbox d-flex mr-12"
                                                               for="auto_recording_cloud">
                                                            <input type="radio" name="auto_recording"
                                                                   id="auto_recording_cloud" value="cloud"
                                                                   class="common-radio relationButton"@if(!empty($setting))
                                                                {{ old('auto_recording',$setting->auto_recording) == 'cloud' ? 'checked': ''}}
                                                                @endif>
                                                            <span
                                                                class="checkmark me-2"></span> {{__('zoom.Cloud')}}
                                                        </label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p class="text-uppercase fw-500 mb-10"> {{__('zoom.Audio Options')}}</p>
                                                </div>
                                                <div class="col-lg-4 mb-25 p-0">
                                                    <label class="primary_checkbox d-flex mr-12"
                                                           for="audio_both">
                                                        <input type="radio" name="audio"
                                                               id="audio_both" value="both"
                                                               class="common-radio relationButton"@if(!empty($setting))
                                                            {{ old('audio',$setting->audio) == 'both' ? 'checked': ''}}
                                                            @endif>
                                                        <span
                                                            class="checkmark me-2"></span> {{__('zoom.Both')}}
                                                    </label>
                                                </div>
                                                <div class="col-lg-4 mb-25 p-0">
                                                    <label class="primary_checkbox d-flex mr-12"
                                                           for="audio_telephony">
                                                        <input type="radio" name="audio"
                                                               id="audio_telephony" value="telephony"
                                                               class="common-radio relationButton"@if(!empty($setting))
                                                            {{ old('audio',$setting->audio) == 'telephony' ? 'checked': ''}}
                                                            @endif>
                                                        <span
                                                            class="checkmark me-2"></span> {{__('zoom.Telephony')}}
                                                    </label>
                                                </div>
                                                <div class="col-lg-4 mb-25 p-0">
                                                    <label class="primary_checkbox d-flex mr-12"
                                                           for="audio_voip">
                                                        <input type="radio" name="audio"
                                                               id="audio_voip" value="voip"
                                                               class="common-radio relationButton"@if(!empty($setting))
                                                            {{ old('audio',$setting->audio) == 'voip' ? 'checked': ''}}
                                                            @endif>
                                                        <span
                                                            class="checkmark me-2"></span> {{__('zoom.Voip')}}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('zoom.Host Video')}} </p>
                                                </div>
                                                <div class="col-lg-6 mb-25 p-0">
                                                    <div class="">
                                                        <label class="primary_checkbox d-flex mr-12"
                                                               for="host_video_on">
                                                            <input type="radio" name="host_video"
                                                                   id="host_video_on" value="1"
                                                                   class="common-radio relationButton"@if(!empty($setting))
                                                                {{ old('host_video',$setting->host_video) == 1 ? 'checked': ''}}
                                                                @endif>
                                                            <span
                                                                class="checkmark me-2"></span> {{__('zoom.Enable')}}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-25 p-0">
                                                    <div class="">
                                                        <label class="primary_checkbox d-flex mr-12"
                                                               for="host_video">
                                                            <input type="radio" name="host_video"
                                                                   id="host_video" value="0"
                                                                   class="common-radio relationButton" @if(!empty($setting))
                                                                {{ old('host_video',$setting->host_video) == '0' ? 'checked': ''}}
                                                                @endif>
                                                            <span
                                                                class="checkmark me-2"></span> {{__('zoom.Disable')}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('zoom.Participant video')}} </p>
                                                </div>
                                                <div class="col-lg-6 mb-25 p-0">
                                                    <div class="">
                                                        <label class="primary_checkbox d-flex mr-12"
                                                               for="participant_video_on">
                                                            <input type="radio" name="participant_video"
                                                                   id="participant_video_on" value="1"
                                                                   class="common-radio relationButton" @if(!empty($setting))
                                                                {{ old('participant_video',$setting->participant_video) == 1? 'checked': ''}}
                                                                @endif>
                                                            <span
                                                                class="checkmark me-2"></span> {{__('zoom.Enable')}}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-25 p-0">
                                                    <div class="">
                                                        <label class="primary_checkbox d-flex mr-12"
                                                               for="participant_video">
                                                            <input type="radio" name="participant_video"
                                                                   id="participant_video" value="0"
                                                                   class="common-radio relationButton"@if(!empty($setting))
                                                                {{ old('participant_video',$setting->participant_video) == 0? 'checked': ''}}
                                                                @endif>
                                                            <span
                                                                class="checkmark me-2"></span> {{__('zoom.Disable')}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('zoom.Join Before Host')}} </p>
                                                </div>
                                                <div class="col-lg-6 mb-25 p-0">
                                                    <div class="">
                                                        <label class="primary_checkbox d-flex mr-12"
                                                               for="join_before_host_on">
                                                            <input type="radio" name="join_before_host"
                                                                   id="join_before_host_on" value="1"
                                                                   class="common-radio relationButton" @if(!empty($setting))
                                                                {{ old('join_before_host',$setting->join_before_host) == 1? 'checked': '' }}
                                                                @endif>
                                                            <span
                                                                class="checkmark me-2"></span>{{__('zoom.Enable')}}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-25 p-0">
                                                    <div class="">
                                                        <label class="primary_checkbox d-flex mr-12"
                                                               for="join_before_host">
                                                            <input type="radio" name="join_before_host"
                                                                   id="join_before_host" value="0"
                                                                   class="common-radio relationButton" @if(!empty($setting))
                                                                {{ old('join_before_host',$setting->join_before_host) == 0? 'checked': '' }}
                                                                @endif>
                                                            <span
                                                                class="checkmark me-2"></span> {{__('zoom.Disable')}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('zoom.Waiting Room')}}</p>
                                                </div>
                                                <div class="col-lg-6 mb-25 p-0">
                                                    <div class="">
                                                        <label class="primary_checkbox d-flex mr-12"
                                                               for="waiting_room_on">
                                                            <input type="radio" name="waiting_room"
                                                                   id="waiting_room_on" value="1"
                                                                   class="common-radio relationButton" @if(!empty($setting))
                                                                {{ old('waiting_room',$setting->waiting_room) == 1? 'checked': '' }}
                                                                @endif>
                                                            <span
                                                                class="checkmark me-2"></span> {{__('zoom.Enable')}}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-25 p-0">
                                                    <div class="">
                                                        <label class="primary_checkbox d-flex mr-12"
                                                               for="waiting_room">
                                                            <input type="radio" name="waiting_room"
                                                                   id="waiting_room" value="0"
                                                                   class="common-radio relationButton" @if(!empty($setting))
                                                                {{ old('waiting_room',$setting->waiting_room) == 0? 'checked': '' }}
                                                                @endif>
                                                            <span
                                                                class="checkmark me-2"></span> {{__('zoom.Disable')}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p class="text-uppercase fw-500 mb-10">
                                                        {{__('zoom.Mute Upon Entry')}} </p>
                                                </div>
                                                <div class="col-lg-6 mb-25 p-0">
                                                    <div class="">
                                                        <label class="primary_checkbox d-flex mr-12 "
                                                               for="mute_upon_entr_on">
                                                            <input type="radio" name="mute_upon_entry"
                                                                   id="mute_upon_entr_on" value="1"
                                                                   class="common-radio relationButton" @if(!empty($setting))
                                                                {{ old('mute_upon_entry',$setting->mute_upon_entry) == 1? 'checked': ''}}
                                                                @endif>
                                                            <span
                                                                class="checkmark me-2"></span> {{__('zoom.Enable')}}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-25 p-0">
                                                    <div class="">
                                                        <label class="primary_checkbox d-flex mr-12 "
                                                               for="mute_upon_entry">
                                                            <input type="radio" name="mute_upon_entry"
                                                                   id="mute_upon_entry" value="0"
                                                                   class="common-radio relationButton" @if(!empty($setting))
                                                                {{ old('mute_upon_entry',$setting->mute_upon_entry) == 0? 'checked': ''}}
                                                                @endif>
                                                            <span
                                                                class="checkmark me-2"></span> {{__('zoom.Disable')}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('zoom.Class Join Approval')}}</p>
                                                </div>
                                                <div class="col-lg-4 mb-25 p-0">
                                                    <label class="primary_checkbox d-flex mr-12"
                                                           for="approval_type_0">
                                                        <input type="radio" name="approval_type"
                                                               id="approval_type_0" value="0"
                                                               class="common-radio relationButton"@if(!empty($setting))
                                                            {{ old('approval_type',$setting->approval_type) == '0' ? 'checked': ''}}
                                                            @endif>
                                                        <span
                                                            class="checkmark me-2"></span> {{__('zoom.Automatically')}}
                                                    </label>
                                                </div>
                                                <div class="col-lg-4  text-nowrap mb-25 p-0">
                                                    <label class="primary_checkbox d-flex mr-12"
                                                           for="approval_type_1">
                                                        <input type="radio" name="approval_type"
                                                               id="approval_type_1" value="1"
                                                               class="common-radio relationButton"@if(!empty($setting))
                                                            {{ old('approval_type',$setting->approval_type) == '1' ? 'checked': ''}}
                                                            @endif>
                                                        <span
                                                            class="checkmark me-2"></span> {{__('zoom.Manually Approve')}}
                                                    </label>
                                                </div>
                                                <div class="col-lg-4 text-nowrap mb-25 p-0">
                                                    <label class="primary_checkbox d-flex mr-12"
                                                           for="approval_type_2">
                                                        <input type="radio" name="approval_type"
                                                               id="approval_type_2" value="2"
                                                               class="common-radio relationButton"@if(!empty($setting))
                                                            {{ old('approval_type',$setting->approval_type) == '2' ? 'checked': ''}}
                                                            @endif>
                                                        <span
                                                            class="checkmark me-2"></span> {{__('zoom.No Registration Required')}}
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>

                            <div class="row mb-3 ">
                                <div class="col-lg-12 pb_20">
                                    <p>
                                        <i class="fa fa-info-circle"></i> {{__('virtual-class.Zoom')}}  {{__('virtual-class.Server-to-Server OAuth credentials')}}
                                    </p>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <label class="mb-3">{{__('zoom.Account ID')}}<span
                                                class="required_mark">*</span> </label>

                                        <input
                                            class="primary-input-field form-control "
                                            type="text" name="zoom_account_id"
                                            value="@if(!empty($setting)) {{ old('zoom_account_id',$setting->zoom_account_id) }} @endif">
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <label class="mb-3">{{__('zoom.Client ID') }}<span
                                                class="required_mark">*</span></label>

                                        <input
                                            class="primary-input-field form-control "
                                            type="text" name="zoom_client_id"
                                            value=" @if(!empty($setting)) {{ old('zoom_client_id',$setting->zoom_client_id) }} @endif">
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <label class="mb-3">{{__('zoom.Client secret') }}<span
                                                class="required_mark">*</span></label>
                                        <input
                                            class="primary-input-field form-control"
                                            type="text" name="zoom_client_secret"
                                            value=" @if(!empty($setting)) {{ old('zoom_client_secret',$setting->zoom_client_secret) }} @endif">
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                            </div>

                            <div class="row ">
                                <div class="col-lg-12 d-flex justify-content-center align-items-center">
                                    <button type="submit" class="primary-btn fix-gr-bg"
                                            id="_submit_btn_admission">
                                        <i class="ti-check"></i>
                                        {{__('zoom.Update')}}
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                    @if(isModuleActive('ZoomPro'))
                        <div class="tab-pane fade white-box active show mt-3 " id="SMS" role="tabpanel"
                             aria-labelledby="SMS-tab">
                            <input type="hidden" name="g_set" value="1">
                            <div class="General_system_wrap_area d-block">
                                <div class="single_system_wrap">
                                    <h5>{{_trans('zoom.To run automatic getting zoom cloud record')}}
                                        .</h5>
                                    <div class="single_system_wrap_inner text-center">

                                        <p style="overflow-wrap: anywhere;">{{ 'cd ' . base_path() . '/ && php artisan get-zoom-meeting-record >> /dev/null 2>&1' }}</p>

                                    </div>
                                    <h6>{{_trans('gift.In cPanel you should set time interval 10 minutes')}}.</h6>
                                </div>

                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
