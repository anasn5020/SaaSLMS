@extends('backend.master')

@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="mb-40 student-details">
        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="row">
                            <div class="main-title ps-3 pt-0">
                                <h3 class="mb-20">{{__('setting.Vimeo Settings')}}</h3>
                            </div>
                        </div>
                        @if (permissionCheck('vimeosetting.update'))
                            <form class="form-horizontal" action="{{route('vimeosetting.update')}}" method="POST">
                                @endif
                                @csrf
                                <div>

                                    <div class="col-md-12 p-0">
                                        <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                        <input type="hidden" name="id" value="{{@$videoSetting->id}}">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="row">
                                                    @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
                                                        <div class="col-xl-6 ">
                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-6">

                                                                        <div class="row">
                                                                            <div class="col-md-12 mb-3">
                                                                                <label class="primary_input_label"
                                                                                       for="    "> {{__('setting.Common API User For All User')}}</label>
                                                                            </div>
                                                                            <div class="col-md-4 mb-25">
                                                                                <label
                                                                                    class="primary_checkbox d-flex mr-12"
                                                                                    for="yes">
                                                                                    <input type="radio"
                                                                                           class="common-radio "
                                                                                           id="yes"
                                                                                           name="common_use"
                                                                                           {{config('vimeo.connections.main.common_use')?'checked':''}}
                                                                                           value="1">
                                                                                    <span
                                                                                        class="checkmark me-2"></span> {{__('common.Yes')}}
                                                                                </label>
                                                                            </div>
                                                                            <div class="col-md-4 mb-25">
                                                                                <label
                                                                                    class="primary_checkbox d-flex mr-12"
                                                                                    for="no">
                                                                                    <input type="radio"
                                                                                           class="common-radio "
                                                                                           id="no"
                                                                                           name="common_use"
                                                                                           value="0" {{!config('vimeo.connections.main.common_use')?'checked':''}}>
                                                                                    <span
                                                                                        class="checkmark me-2"></span> {{__('common.No')}}
                                                                                </label>
                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-xl-6">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('setting.Vimeo Client') }} *</label>
                                                            <input class="primary_input_field" placeholder="-"
                                                                   type="text"
                                                                   name="vimeo_client"
                                                                   value="{{!empty($videoSetting)?$videoSetting->vimeo_client:''}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('setting.Vimeo Secret') }} *</label>
                                                            <input class="primary_input_field" placeholder="-"
                                                                   type="text"
                                                                   name="vimeo_secret"
                                                                   value="{{!empty($videoSetting)?$videoSetting->vimeo_secret:''}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('setting.Vimeo Access') }} *</label>
                                                            <input class="primary_input_field" placeholder="-"
                                                                   type="text"
                                                                   name="vimeo_access"
                                                                   value="{{!empty($videoSetting)?$videoSetting->vimeo_access:''}}">
                                                        </div>
                                                    </div>

                                                    @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
                                                        <div class="col-xl-6 ">
                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-6">

                                                                        <div class="row">
                                                                            <div class="col-md-12 mb-3">
                                                                                <label class="primary_input_label"
                                                                                       for="    "> {{__('setting.Vimeo Video Upload Type')}}</label>
                                                                            </div>
                                                                            <div class="col-md-5 mb-25">
                                                                                <label
                                                                                    class="primary_checkbox d-flex mr-12  text-nowrap"
                                                                                    for="upload_type_direct">
                                                                                    <input type="radio"
                                                                                           class="common-radio "
                                                                                           id="upload_type_direct"
                                                                                           name="upload_type"
                                                                                           {{config('vimeo.connections.main.upload_type')=="Direct"?'checked':''}}
                                                                                           value="Direct">
                                                                                    <span
                                                                                        class="checkmark me-2 "></span> {{__('setting.Direct Upload')}}
                                                                                </label>
                                                                            </div>
                                                                            <div class="col-md-5 mb-25">
                                                                                <label
                                                                                    class="primary_checkbox d-flex mr-12  text-nowrap"
                                                                                    for="upload_type_list">
                                                                                    <input type="radio"
                                                                                           class="common-radio "
                                                                                           id="upload_type_list"
                                                                                           name="upload_type"
                                                                                           value="List" {{config('vimeo.connections.main.upload_type')=="List"?'checked':''}}>
                                                                                    <span
                                                                                        class="checkmark me-2 "></span> {{__('setting.From List')}}
                                                                                </label>
                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="col-lg-12">
                                                        <code><a target="_blank" title="Google map api key"
                                                                 href="https://developer.vimeo.com/apps/new">{{__('setting.Click Here to Get Vimeo Api Key')}}
                                                                | {{__('setting.Scopes need to allow')}}
                                                                <b>{{__('setting.public')}}</b>,<b>{{__('setting.private')}}</b>,<b>{{__('setting.edit')}}</b>,<b>{{__('setting.upload')}} </b></a></code>

                                                        <ul>
                                                            <li>
                                                                {{__('setting.For Secure, Change Privacy to')}}
                                                                <b>{{__('setting.Hide From Vimeo')}}</b>
                                                            </li>
                                                            <li>{{__('setting.Where can the video be embedded? Set')}}
                                                                <b>{{__('setting.Use Specific domains')}}</b>
                                                                {{__('setting.& register your domain without http/https')}}
                                                            </li>
                                                            <li>
                                                                {{__('setting.Direct upload is not allow for Vimeo basic plan')}}
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    @php
                                        $tooltip = "";
                                        if(!permissionCheck('vimeosetting.update')){
                                            $tooltip = "You have no permission to Update";
                                        }
                                    @endphp
                                    <div class="row ">
                                        <div class="col-lg-12 d-flex align-items-center justify-content-center">
                                            <button type="submit" class="primary-btn fix-gr-bg" data-bs-toggle="tooltip"
                                                    title="{{$tooltip}}">
                                                <i class="ti-check"></i>
                                                {{__('common.Update')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
