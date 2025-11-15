@extends('backend.master')

@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor mb-20 student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row ">

                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-20" role="tablist">
                            <li class="nav-item m-1">
                                <a class="nav-link @if(!Session::has('course') && !Session::has('instructor'))active @endif "
                                   href="#Flat"
                                   role="tab" data-bs-toggle="tab">{{__('setting.Flat Commission')}}</a>
                            </li>
                            <li class="nav-item m-1">
                                <a class="nav-link @if(Session::has('instructor'))active @endif"
                                   href="#Instructor"
                                   role="tab" data-bs-toggle="tab">
                                    @if(isModuleActive('Organization'))
                                        {{__('setting.Instructor or Organization Commission')}}
                                    @else
                                        {{__('setting.Instructor Commission')}}
                                    @endif
                                </a>

                            </li>
                            <li class="nav-item m-1">
                                <a class="nav-link @if(Session::has('course')) active @endif"
                                   href="#Course"
                                   role="tab" data-bs-toggle="tab">{{__('setting.Course Commission')}}</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div
                            class="tab-pane fade   @if(!Session::has('course') && !Session::has('instructor'))show active @endif"
                            id="Flat" role="tabpanel"
                            aria-labelledby="General-tab">
                            <div class="white-box">

                                <div class="main-title mb-25">
                                    <h3 class="mb-0">{{ __('courses.Course Fee Settings') }}</h3>
                                </div>
                                <form
                                    action="@if(permissionCheck('setting.setCourseFee_update')){{route('saveFlat')}} @endif"
                                    method="post">

                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('setting.Admin Revenue percentage of course fee') }}</label>
                                                <input class="primary_input_field" max="100"
                                                       value="{{@(int)$commission}}"
                                                       name="commission" placeholder="Admin Commission(%)"
                                                       oninput="calCommission()"
                                                       id="admin_comm" type="text">
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">
                                                    @if(isModuleActive('Organization'))
                                                        {{ __('setting.Instructor or Organization Revenue percentage of course fee') }}
                                                    @else
                                                        {{ __('setting.Instructor Revenue percentage of course fee') }}
                                                    @endif

                                                </label>

                                                <input class="primary_input_field"
                                                       value="{{@(int)$instructor_commission}}"
                                                       readonly
                                                       name="instructor_comm" id="instructor_comm"
                                                       placeholder="Instructor Commission(%)"
                                                       type="text">
                                            </div>
                                        </div>


                                        @php
                                            $tooltip = "";
                                            if(permissionCheck('setting.setCourseFee_update')){
                                                $tooltip = "";
                                            }else{
                                                $tooltip = "You have no permission to add";
                                            }
                                        @endphp

                                        <div class="col-12 mb-10 pt_15">
                                            <div class="submit_btn text-center">
                                                <button class="primary-btn fix-gr-bg" data-bs-toggle="tooltip"
                                                        title="{{$tooltip}}" type="submit"><i
                                                        class="ti-check"></i> {{ __('common.Save') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>


                        </div>

                        <div class="tab-pane fade @if(Session::has('instructor'))show active @endif " id="Instructor"
                             role="tabpanel"
                             aria-labelledby="General-tab">
                            <div class="white-box">
                                <div class="main-title mb-25">
                                    <h3 class="mb-0">{{ __('courses.Specific Instructor Commission Setup') }}</h3>
                                </div>

                                <form
                                    action="@if(permissionCheck('setting.instructorCommission_update')){{route('instructor_commission')}} @endif"
                                    method="post">

                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('common.Select') }} {{ __('courses.Instructor') }}</label>
                                                <select name="user_id" class="primary_select mb-25" required>
                                                    <option
                                                        value="">{{ __('common.Select') }} {{ __('courses.Instructor') }}</option>
                                                    @foreach ($users as $user)

                                                        <option
                                                            value="{{@$user->id}}"
                                                            @if(Session::has('user_id'))
                                                                @if(Session::get('user_id')==$user->id)
                                                                    selected
                                                            @endif
                                                            @endif
                                                        >
                                                            <img class="tab_thumb" src="{{asset(@$user->image)}}"
                                                                 alt=""> {{@$user->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('setting.Instructor Revenue percentage of course fee') }}</label>
                                                <input class="primary_input_field"
                                                       value="@if(Session::has('amount')){{Session::get('amount') }}@endif"
                                                       name="special_commission" id="instructor_comm"
                                                       placeholder="{{__('setting.Instructor Commission')}}(%)"
                                                       type="number" min="0" required>

                                            </div>
                                        </div>


                                        @php
                                            $tooltip = "";
                                            if(permissionCheck('setting.instructorCommission_update')){
                                                $tooltip = "";
                                            }else{
                                                $tooltip = "You have no permission to Update";
                                            }
                                        @endphp

                                        <div class="col-12 mb-10 pt_15">
                                            <div class="submit_btn text-center">
                                                <button class="primary-btn fix-gr-bg" data-bs-toggle="tooltip"
                                                        title="{{$tooltip}}" type="submit"><i
                                                        class="ti-check"></i> {{ __('common.Update') }} {{ __('setting.Settings') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-lg-12 mt-20">
                                <div class="white-box">

                                    <div class="box_header">
                                        <div class="main-title d-flex flex-wrap mb-0">
                                            <h3 class="mb-0">{{ __('setting.Specific Instructor List') }}</h3>
                                        </div>
                                    </div>
                                    <div class="QA_section QA_section_heading_custom check_box_table">
                                        <div class="QA_table ">
                                            <!-- table-responsive -->
                                            <div class="">
                                                <table class="table Crm_table_active3">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col"> {{__('common.SL')}} </th>
                                                        <th scope="col"> {{__('common.Name')}} </th>
                                                        {{--                                                        <th scope="col"> {{__('common.Username')}} </th>--}}
                                                        <th scope="col"> {{__('courses.Instructor Commission')}} </th>
                                                        <th scope="col"> {{__('courses.Admin Commission')}} </th>
                                                        <th scope="col"> {{__('common.Email')}} </th>
                                                        <th scope="col"> {{__('common.Action')}} </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($instructors as $key => $instructor)
                                                        @php
                                                            $admin_commission=100-$instructor->special_commission;
                                                        @endphp
                                                        <tr>
                                                            <th>{{$key+1}}</th>

                                                            <td class="nowrap">{{@$instructor->name}}</td>
                                                            {{--                                                            <td class="nowrap">{{@$instructor->username}}</td>--}}
                                                            <td class="nowrap">{{@$instructor->special_commission}}</td>
                                                            <td class="nowrap">{{@$admin_commission}}</td>
                                                            <td class="nowrap">{{@$instructor->email}}</td>
                                                            <td class="nowrap">


                                                                <div class="dropdown CRM_dropdown">
                                                                    <button class="btn btn-secondary dropdown-toggle"
                                                                            type="button"
                                                                            id="dropdownMenu2{{@$instructor->id}}"
                                                                            data-bs-toggle="dropdown"
                                                                            aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                        {{__('common.Action')}}
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-right"
                                                                         aria-labelledby="dropdownMenu2{{@$instructor->id}}">
                                                                        @if (permissionCheck('setting.instructorCommission_edit'))
                                                                            <a href="#" data-bs-toggle="modal"
                                                                               data-bs-target="#editInstractor{{@$instructor->id}}"
                                                                               class="dropdown-item"
                                                                               type="button">{{ __('common.Edit') }}</a>
                                                                        @endif

                                                                    </div>
                                                                </div>
                                                            </td>

                                                        </tr>


                                                        <div class="modal fade admin-query"
                                                             id="editInstractor{{@$instructor->id}}">
                                                            <div class="modal-dialog modal_800px modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">{{ __('common.Update') }} {{ __('courses.Commission') }} </h4>
                                                                        <button type="button" class="close "
                                                                                data-bs-dismiss="modal">
                                                                            <i class="ti-close "></i>
                                                                        </button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{route('instructor_commission')}}"
                                                                            method="post">
                                                                            @csrf
                                                                            <input type="hidden" name="user_id"
                                                                                   value="{{@$instructor->id}}">
                                                                            <div class="row">
                                                                                <div class="col-xl-12">
                                                                                    <div class="primary_input mb-25">
                                                                                        <label
                                                                                            class="primary_input_label"
                                                                                            for="">{{ __('courses.Instructor Commission Percentage') }}</label>
                                                                                        <div class="tagInput_field">
                                                                                            <input
                                                                                                class="primary_input_field"
                                                                                                name="special_commission"
                                                                                                type="text"
                                                                                                value="{{@(int)$instructor->special_commission}}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div
                                                                                    class="col-lg-12 text-center pt_15">
                                                                                    <div
                                                                                        class="d-flex justify-content-center">
                                                                                        <button
                                                                                            class="primary-btn semi_large2  fix-gr-bg"
                                                                                            type="submit"><i
                                                                                                class="ti-check"></i>{{ __('common.Update') }} {{ __('setting.Settings') }}
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="tab-pane fade @if(Session::has('course'))show active @endif " id="Course"
                             role="tabpanel"
                             aria-labelledby="General-tab">
                            <div class="white-box">
                                <div class="main-title mb-25">
                                    <h3 class="mb-0">{{__('setting.Specific Course Commission Setup')}} </h3>
                                </div>

                                <form
                                    action="@if(permissionCheck('setting.courseCommission_update')){{route('courseCommission')}} @endif"
                                    method="post">

                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('courses.Select Course')}}</label>
                                                <select name="course" class="primary_select mb-25" required>
                                                    <option value="">{{__('courses.Select Course')}}</option>
                                                    @foreach ($allcourses as $course)

                                                        <option value="{{@$course->id}}"
                                                                @if(Session::has('course_id'))
                                                                    @if(Session::get('course_id')==$course->id)
                                                                        selected
                                                            @endif
                                                            @endif
                                                        >  {{@$course->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">
                                                    @if(isModuleActive('Organization'))
                                                        {{ __('setting.Instructor or Organization Revenue percentage of course fee') }}
                                                    @else
                                                        {{ __('setting.Instructor Revenue percentage of course fee') }}
                                                    @endif
                                                </label>

                                                <input class="primary_input_field"
                                                       value="@if(Session::has('amount')){{Session::get('amount')}}@endif"
                                                       name="course_commission" id="instructor_comm"
                                                       placeholder="{{isModuleActive('Organization')?trans('setting.Instructor or Organization Commission'):trans('setting.Instructor Commission')}} (%)"
                                                       type="number" min="0" required>
                                            </div>
                                        </div>


                                        @php
                                            $tooltip = "";
                                            if(permissionCheck('setting.courseCommission_update')){
                                                $tooltip = "";
                                            }else{
                                                $tooltip = "You have no permission to Update";
                                            }
                                        @endphp

                                        <div class="col-12 mb-10 pt_15">
                                            <div class="submit_btn text-center">
                                                <button class="primary-btn fix-gr-bg" type="submit"><i
                                                        class="ti-check"></i> {{__('common.Update')}} {{__('setting.Setting')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-12 mt-20 p-0">
                                <div class="box_header">
                                    <div class="main-title d-flex flex-wrap mb-0">
                                        <h3 class="mb-0">{{__('setting.Specific Course List')}}</h3>
                                    </div>
                                </div>

                                <div class="QA_section QA_section_heading_custom check_box_table">
                                    <div class="QA_table ">
                                        <!-- table-responsive -->
                                        <div class="">
                                            <table id="lms_table" class="table Crm_table_active3">
                                                <thead>
                                                <tr>

                                                    <th scope="col"> {{__('common.SL')}} </th>
                                                    <th scope="col"> {{__('common.Image')}} </th>
                                                    <th scope="col"> {{__('courses.Course Title')}} </th>
                                                    <th scope="col"> {{__('courses.Created')}} </th>
                                                    <th scope="col"> {{__('courses.Instructor Revenue')}} </th>
                                                    <th scope="col"> {{__('courses.Admin Revenue')}} </th>
                                                    <th scope="col"> {{__('courses.Enrolls')}} </th>
                                                    <th scope="col"> {{__('common.Action')}} </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($courses as $key => $course)
                                                    @php
                                                        $admin_commission=100-$course->special_commission;
                                                    @endphp
                                                    <tr>
                                                        <th>{{$key+1}}</th>

                                                        <td class="nowrap">
                                                            <div class="profile_info">
                                                                <img
                                                                    src="{{getProfileImage($course->user->image,$course->user->name)}}">
                                                            </div>
                                                        </td>
                                                        <td class="nowrap">{{@$course->title}}</td>
                                                        <td class="nowrap">{{@$course->user->name}}</td>
                                                        <td class="nowrap">{{@$course->special_commission}}</td>
                                                        <td class="nowrap">{{@$admin_commission}}</td>
                                                        <td class="nowrap">{{@$course->enrollCount}}</td>
                                                        <td class="nowrap">


                                                            <div class="dropdown CRM_dropdown">
                                                                <button class="btn btn-secondary dropdown-toggle"
                                                                        type="button"
                                                                        id="dropdownMenu3{{@$course->id}}"
                                                                        data-bs-toggle="dropdown"
                                                                        aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                    {{__('common.Action')}}
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right"
                                                                     aria-labelledby="dropdownMenu3{{@$course->id}}">
                                                                    @if (permissionCheck('setting.courseCommission_edit'))
                                                                        <a href="#" data-bs-toggle="modal"
                                                                           data-bs-target="#editCourse{{@$course->id}}"
                                                                           class="dropdown-item"
                                                                           type="button">{{ __('common.Edit') }}</a>
                                                                    @endif

                                                                    @if (permissionCheck('setting.courseCommission.delete'))
                                                                        <a href="{{route('setting.courseCommission.delete',@$course->id)}}"
                                                                           class="dropdown-item delete_course_commission"
                                                                           type="button">{{ __('common.Delete') }}</a>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </td>

                                                    </tr>


                                                    <div class="modal fade admin-query"
                                                         id="editCourse{{@$course->id}}">
                                                        <div class="modal-dialog modal_800px modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">{{@$course->title}}</h4>
                                                                    <button type="button" class="close "
                                                                            data-bs-dismiss="modal">
                                                                        <i class="ti-close "></i>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form action="{{route('courseCommission')}}"
                                                                          method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="course"
                                                                               value="{{@$course->id}}">
                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="primary_input mb-25">
                                                                                    <label class="primary_input_label"
                                                                                           for="">{{__('courses.Instructor Commission Percentage')}}</label>
                                                                                    <div class="tagInput_field">
                                                                                        <input
                                                                                            class="primary_input_field"
                                                                                            name="course_commission"
                                                                                            type="text"
                                                                                            value="{{@(int)$course->special_commission}}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-12 text-center pt_15">
                                                                                <div
                                                                                    class="d-flex justify-content-center">
                                                                                    <button
                                                                                        class="primary-btn semi_large2  fix-gr-bg"
                                                                                        type="submit"><i
                                                                                            class="ti-check"></i>{{__('common.Update')}} {{__('setting.Settings')}}
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
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
            </div>
        </div>
    </section>
    @include('backend.partials.delete_modal')
    @include('setting::page_components.script')
@endsection
@push('scripts')
    <script>
        (function ($) {
            "use strict";

            $(document).ready(function () {

                $(document).on('click', '.delete_course_commission', function (event) {
                    event.preventDefault();
                    let link = $(this).attr('href');
                    confirm_modal(link);
                });
            });
        })(jQuery);

    </script>
@endpush
