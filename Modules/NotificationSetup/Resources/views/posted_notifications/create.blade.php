@extends('backend.master')
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <div class="white-box mb_30 ">
                        <form action="{{route('notifications.posted.store')}}" method="POST"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="row">

                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="title">{{ __('common.Title') }} <strong
                                                class="text-danger">*</strong></label>
                                        <input value="{{old('title')}}" class="primary_input_field" placeholder="-"
                                               type="text" name="title">

                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="type">{{ __('common.Type') }} <strong
                                                class="text-danger">*</strong> </label>
                                        <select class="primary_select mb-25" name="type"
                                                id="type">
                                            <option value="" selected>{{__('common.Select One')}}</option>
                                            @foreach($types as $type)
                                                <option
                                                    {{old('type') == $type ? 'selected':''}} value="{{$type}}">{{$type}}</option>
                                            @endforeach

                                        </select>
                                        <small>{{__('setting.The notification will be received by these users and will be displayed on their panel and email address.')}}</small>

                                    </div>
                                </div>


                            </div>

                            <div class="row course_div">

                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="course">{{ __('common.Course') }} <strong
                                                class="text-danger">*</strong> </label>
                                        <select class="primary_select mb-25" name="course"
                                                id="course">
                                            <option value="" selected>{{__('common.Select One')}}</option>
                                            @foreach($courses as $course)
                                                <option
                                                    {{old('course') == $course->id ? 'selected':''}} value="{{$course->id}}">{{$course->title}}</option>
                                            @endforeach

                                        </select>


                                    </div>
                                </div>


                            </div>

                            <div class="row user_div">
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="user">{{ __('common.User') }} <strong
                                                class="text-danger">*</strong> </label>
                                        <select class="primary_select mb-25" name="user"
                                                id="user">
                                            <option value="" selected>{{__('common.Select One')}}</option>
                                            @foreach($users as $user)
                                                <option
                                                    {{old('user') == $user->id ? 'selected':''}} value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="row specific_users_div">


                                <div class="col-xl-6">

                                    <label class="primary_input_label"
                                           for="specific_users">{{ __('setting.Specific Users') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="primary_input mb-15">
                                        <select name="specific_users[]" id="specific_users"
                                                class="multypol_check_select active mb-15 e1"
                                                multiple>
                                            @foreach($users as $user)
                                                <option
                                                    {{old('specific_users')?in_array($user->id,old('specific_users')) ? 'selected':'':''}} value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>


                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="primary_input mb-35">
                                        <label class="primary_input_label"
                                               for="message">{{__('setting.Message')}} <strong
                                                class="text-danger">*</strong> </label>
                                        <textarea class="lms_summernote" name="message" id="message"
                                                  cols="30"
                                                  rows="10">{{ old('message') }}</textarea>
                                    </div>

                                </div>
                            </div>

                            <div class="row">

                                <div class="col-lg-12 text-center">
                                    <div class="d-flex justify-content-center pt_20">
                                        <button type="submit" class="primary-btn semi_large fix-gr-bg"
                                                data-bs-toggle="tooltip"
                                                id="save_button_parent">
                                            <i class="ti-check"></i>
                                            {{ __('common.Send') }}
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

    @include('backend.partials.delete_modal')
@endsection
@push('scripts')
    <script>
        (function ($) {
            "use strict";
            // let _token = $('meta[name=_token]').attr('content') ;
            $(document).ready(function () {

                typeChangeDivToggle();

                $(document).on('change', '#type', function (event) {
                    typeChangeDivToggle();
                });

                function typeChangeDivToggle() {
                    let type = $('#type').val();
                    let courseDiv = $('.course_div');
                    let userDiv = $('.user_div');
                    let specificUserDiv = $('.specific_users_div');
                    courseDiv.hide();
                    userDiv.hide();
                    specificUserDiv.hide();
                    if (type === 'Course Students') {
                        courseDiv.show();
                    } else if (type === 'Single User') {
                        userDiv.show();
                    } else if (type === 'Specific Users') {
                        specificUserDiv.show();
                    }
                }
            });
        })(jQuery);
    </script>
@endpush
