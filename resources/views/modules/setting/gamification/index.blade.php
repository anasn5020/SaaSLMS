@extends('backend.master')

@push('styles')
    <style>
        .point-input {
            min-width: 80px !important;
            width: 100% !important;
            flex: 0;
            height: 40px;
        }

        .disable-btn > .checkmark,
        .disable-btn > .slider:before {
            background: #999 !important;
            cursor: not-allowed;
        }

        .student-details .accordion {
            overflow: auto;
        }

        .student-details .accordion .card {
            width: max-content;
            overflow: auto;
            min-width: 100%;
        }

        .student-details .accordion::-webkit-scrollbar {
            height: 4px;
            width: 4px;
        }

        .primary_input_field.point-input {
            text-align: center;
            padding-left: 16px;
            padding-right: 16px;
        }

    </style>
@endpush
@section('mainContent')

    {{ generateBreadcrumb() }}
    <section class=" student-details">
        <div class="container-fluid p-0">
            <div class="row">

                <div class="col-lg-12">


                    <form class="form-horizontal"
                          action="{{ permissionCheck('gamification.setting.update')?route('gamification.setting.update'):'' }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf


                        <div class="white-box  student-details header-menu">
                            <div class="offset-lg-10 col-lg-2 text-end col-md-12 mb-15">

                                <div class="mb_25">
                                    <label class="switch_toggle " for="gamification_status">
                                        <input type="checkbox" class="gamification" name="gamification_status"
                                               id="gamification_status"
                                               {{ Settings('gamification_status') ? 'checked' : '' }}
                                               value="1">
                                        <i class="slider round"></i>


                                    </label>
                                    {{ __('setting.Gamification') }} <span id="gamificationStatus"> {{ __('setting.On') }}
                                </span>

                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="row mb-30">
                                    <div class="col-md-12 item_list p-0">
                                        @if (!isModuleActive('Org'))
                                            <div class="pb-2" data-id="1">
                                                <div class="accordion" id="accordionPointContent">
                                                    <div class="card">
                                                        <div class="card-header" id="heading1">
                                                            <h2 class="mb-0 d-flex align-item-center justify-content-between">
                                                                <div class="  text-start">

                                                                    <div class="">
                                                                        {{ __('setting.Points') }}
                                                                        <label class="switch_toggle "
                                                                               for="gamification_point_status">
                                                                            <input type="checkbox"
                                                                                   class="gamification_point_status item_status"
                                                                                   name="gamification_point_status"
                                                                                   id="gamification_point_status"
                                                                                   {{ Settings('gamification_point_status') ? 'checked' : '' }}
                                                                                   value="1">
                                                                            <i class="slider round"></i>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </h2>
                                                        </div>

                                                        <div class="collapse show">
                                                            <div class="card-body">


                                                                <div class="primary_input mb-25">
                                                                    <div class="row">

                                                                        <div class="col-md-12">
                                                                            <div class="d-flex align-items-center">
                                                                                <label
                                                                                    class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                    for="gamification_point_each_login_status">
                                                                                    <input type="checkbox"
                                                                                           class="common-radio"
                                                                                           id="gamification_point_each_login_status"
                                                                                           name="gamification_point_each_login_status"
                                                                                           {{ Settings('gamification_point_each_login_status') ? 'checked' : '' }}
                                                                                           value="1">
                                                                                    <span
                                                                                        class="checkmark me-2"></span>
                                                                                    {{ __('setting.Each login gives') }}


                                                                                </label>
                                                                                <input
                                                                                    class="primary_input_field w-auto point-input"
                                                                                    placeholder="" type="number"
                                                                                    min="0"
                                                                                    step="any"
                                                                                    name="gamification_point_each_login_point"
                                                                                    value="{{ Settings('gamification_point_each_login_point') }}">
                                                                                <span>
                                                                                <span class="ps-2">
                                                                                    {{ __('setting.Points') }}</span>
                                                                            </span>
                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                <div class="primary_input mb-25">
                                                                    <div class="row">

                                                                        <div class="col-md-12">
                                                                            <div class="d-flex align-items-center">
                                                                                <label
                                                                                    class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                    for="gamification_point_each_unit_complete_status">
                                                                                    <input type="checkbox"
                                                                                           class="common-radio"
                                                                                           id="gamification_point_each_unit_complete_status"
                                                                                           name="gamification_point_each_unit_complete_status"
                                                                                           {{ Settings('gamification_point_each_unit_complete_status') ? 'checked' : '' }}
                                                                                           value="1">
                                                                                    <span
                                                                                        class="checkmark me-2"></span>
                                                                                    {{ __('setting.Each unit completion gives') }}


                                                                                </label>
                                                                                <input
                                                                                    class="primary_input_field w-auto point-input"
                                                                                    placeholder="" type="number"
                                                                                    min="0"
                                                                                    step="any"
                                                                                    name="gamification_point_each_unit_complete_point"
                                                                                    value="{{ Settings('gamification_point_each_unit_complete_point') }}">
                                                                                <span>
                                                                                <span class="ps-2">
                                                                                    {{ __('setting.Points') }}</span>
                                                                            </span>
                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                <div class="primary_input mb-25">
                                                                    <div class="row">

                                                                        <div class="col-md-12">
                                                                            <div class="d-flex align-items-center">
                                                                                <label
                                                                                    class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                    for="gamification_point_each_course_complete_status">
                                                                                    <input type="checkbox"
                                                                                           class="common-radio"
                                                                                           id="gamification_point_each_course_complete_status"
                                                                                           name="gamification_point_each_course_complete_status"
                                                                                           {{ Settings('gamification_point_each_course_complete_status') ? 'checked' : '' }}
                                                                                           value="1">
                                                                                    <span
                                                                                        class="checkmark me-2"></span>
                                                                                    {{ __('setting.Each course completion gives') }}


                                                                                </label>
                                                                                <input
                                                                                    class="primary_input_field w-auto point-input"
                                                                                    placeholder="" type="number"
                                                                                    min="0"
                                                                                    step="any"
                                                                                    name="gamification_point_each_course_complete_point"
                                                                                    value="{{ Settings('gamification_point_each_course_complete_point') }}">
                                                                                <span>
                                                                                <span class="ps-2">
                                                                                    {{ __('setting.Points') }}</span>
                                                                            </span>
                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                <div class="primary_input mb-25">
                                                                    <div class="row">

                                                                        <div class="col-md-12">
                                                                            <div class="d-flex align-items-center">
                                                                                <label
                                                                                    class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                    for="gamification_point_each_certificate_status">
                                                                                    <input type="checkbox"
                                                                                           class="common-radio"
                                                                                           id="gamification_point_each_certificate_status"
                                                                                           name="gamification_point_each_certificate_status"
                                                                                           {{ Settings('gamification_point_each_certificate_status') ? 'checked' : '' }}
                                                                                           value="1">
                                                                                    <span
                                                                                        class="checkmark me-2"></span>
                                                                                    {{ __('setting.Each certificate gives') }}


                                                                                </label>
                                                                                <input
                                                                                    class="primary_input_field w-auto point-input"
                                                                                    placeholder="" type="number"
                                                                                    min="0" step="any"
                                                                                    name="gamification_point_each_certificate_point"
                                                                                    value="{{ Settings('gamification_point_each_certificate_point') }}"/>
                                                                                <span>
                                                                                <span class="ps-2">
                                                                                    {{ __('setting.Points') }}</span>
                                                                            </span>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                @if(isModuleActive('Assignment'))
                                                                    <div class="primary_input mb-25">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="d-flex align-items-center">
                                                                                    <label
                                                                                        class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                        for="gamification_point_each_assignment_complete_status">
                                                                                        <input type="checkbox"
                                                                                               class="common-radio"
                                                                                               id="gamification_point_each_assignment_complete_status"
                                                                                               name="gamification_point_each_assignment_complete_status"
                                                                                               {{ Settings('gamification_point_each_assignment_complete_status') ? 'checked' : '' }}
                                                                                               value="1">
                                                                                        <span
                                                                                            class="checkmark me-2"></span>
                                                                                        {{ __('setting.Each successful assignment completion gives') }}


                                                                                    </label>
                                                                                    <input
                                                                                        class="primary_input_field w-auto point-input"
                                                                                        placeholder="" type="number"
                                                                                        min="0" step="any"
                                                                                        name="gamification_point_each_assignment_complete_point"
                                                                                        value="{{ Settings('gamification_point_each_assignment_complete_point') }}">
                                                                                    <span>
                                                                                <span class="ps-2">
                                                                                    {{ __('setting.Points') }}</span>
                                                                            </span>
                                                                                </div>

                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <div class="primary_input mb-25">
                                                                    <div class="row">

                                                                        <div class="col-md-12">
                                                                            <div class="d-flex align-items-center">
                                                                                <label
                                                                                    class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                    for="gamification_point_each_comment_status">
                                                                                    <input type="checkbox"
                                                                                           class="common-radio"
                                                                                           id="gamification_point_each_comment_status"
                                                                                           name="gamification_point_each_comment_status"
                                                                                           {{ Settings('gamification_point_each_comment_status') ? 'checked' : '' }}
                                                                                           value="1">
                                                                                    <span
                                                                                        class="checkmark me-2"></span>
                                                                                    {{ __('setting.Each discussion topic or comment gives') }}


                                                                                </label>
                                                                                <input
                                                                                    class="primary_input_field w-auto point-input"
                                                                                    placeholder="" type="number"
                                                                                    min="0" step="any"
                                                                                    name="gamification_point_each_comment_point"
                                                                                    value="{{ Settings('gamification_point_each_comment_point') }}">
                                                                                <span>
                                                                                <span class="ps-2">
                                                                                    {{ __('setting.Points') }}</span>
                                                                            </span>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif


                                        <div class="pb-2" data-id="2">
                                            <div class="accordion" id="accordionBadgeContent">
                                                <div class="card">
                                                    <div class="card-header" id="heading2">
                                                        <h2 class="mb-0 d-flex align-item-center justify-content-between">
                                                            <div class="  text-start">

                                                                <div class="">
                                                                    {{ __('setting.Badges') }}
                                                                    <label class="switch_toggle "
                                                                           for="gamification_badges_status">
                                                                        <input type="checkbox"
                                                                               class="gamification_badges_status item_status"
                                                                               name="gamification_badges_status"
                                                                               id="gamification_badges_status"
                                                                               {{ Settings('gamification_badges_status') ? 'checked' : '' }}
                                                                               value="1">
                                                                        <i class="slider round"></i>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </h2>
                                                    </div>

                                                    <div class="collapse show">
                                                        <div class="card-body">

                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_badges_activity_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_badges_activity_status"
                                                                                       name="gamification_badges_activity_status"
                                                                                       {{ Settings('gamification_badges_activity_status') ? 'checked' : '' }}
                                                                                       value="1">
                                                                                <span class="checkmark me-2"></span>
                                                                                {{ __('setting.Activity badges') }}
                                                                                <span>
                                                                                @if (count($activity) != 0)
                                                                                        (
                                                                                        {{ $activity->pluck('point')->join(', ') }}
                                                                                        {{ __('setting.logins') }}
                                                                                        )
                                                                                    @else
                                                                                        <span class="text-danger">
                                                                                        ({{ __('setting.No badges assign') }})
                                                                                    </span>
                                                                                    @endif
                                                                            </span>
                                                                                <span class="text-nowrap ps-2">
                                                                                [{{ __('common.Available For') }}:
                                                                                <b>{{ availableRolesForBadges('activity') }}
                                                                                </b>] </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="primary_input ">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_badges_registration_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_badges_registration_status"
                                                                                       name="gamification_badges_registration_status"
                                                                                       {{ Settings('gamification_badges_registration_status') ? 'checked' : '' }}
                                                                                       value="1">
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            @if (isModuleActive('Org'))
                                                                <div class="primary_input mb-25">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="d-flex align-items-center">
                                                                                <label
                                                                                    class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                    for="gamification_badges_registration_status">
                                                                                    <input type="checkbox"
                                                                                           class="common-radio"
                                                                                           id="gamification_badges_registration_status"
                                                                                           name="gamification_badges_registration_status"
                                                                                           {{ Settings('gamification_badges_registration_status') ? 'checked' : '' }}
                                                                                           value="1">
                                                                                    <span
                                                                                        class="checkmark me-2"></span>
                                                                                    {{ __('setting.Registration badges') }}
                                                                                    <span>
                                                                                @if (count($registration) != 0)
                                                                                            (
                                                                                            {{ $registration->pluck('point')->join(', ') }}
                                                                                            {{ __('common.Days') }}
                                                                                            )
                                                                                        @else
                                                                                            <span
                                                                                                class="text-danger">
                                                                                        ({{ __('setting.No badges assign') }})
                                                                                    </span>
                                                                                        @endif
                                                                            </span>
                                                                                    <span class="text-nowrap ps-2">
                                                                                [{{ __('common.Available For') }}:
                                                                                <b>{{ availableRolesForBadges('registration') }}
                                                                                </b>] </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="primary_input mb-25">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="d-flex align-items-center">
                                                                                <label
                                                                                    class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                    for="gamification_badges_learning_status">
                                                                                    <input type="checkbox"
                                                                                           class="common-radio"
                                                                                           id="gamification_badges_learning_status"
                                                                                           name="gamification_badges_learning_status"
                                                                                           {{ Settings('gamification_badges_learning_status') ? 'checked' : '' }}
                                                                                           value="1">
                                                                                    <span
                                                                                        class="checkmark me-2"></span>
                                                                                    {{ __('setting.Learning badges') }}
                                                                                    <span>
                                                                                @if (count($learning) != 0)
                                                                                            (
                                                                                            {{ $learning->pluck('point')->join(', ') }}
                                                                                            {{ __('setting.lerning') }}
                                                                                            )
                                                                                        @else
                                                                                            <span
                                                                                                class="text-danger">
                                                                                        ({{ __('setting.No badges assign') }})
                                                                                    </span>
                                                                                        @endif
                                                                            </span>
                                                                                    <span class="text-nowrap ps-2">
                                                                                [{{ __('common.Available For') }}:
                                                                                <b>{{ availableRolesForBadges('learning') }}
                                                                                </b>] </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div
                                                                            class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_badges_test_status">
                                                                                <input
                                                                                    type="checkbox"
                                                                                    class="common-radio"
                                                                                    id="gamification_badges_test_status"
                                                                                    name="gamification_badges_test_status"
                                                                                    {{ Settings('gamification_badges_test_status') ? 'checked' : '' }}
                                                                                    value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span>
                                                                                {{ __('setting.Test badges') }}

                                                                                <span>
                                                                                @if (count($test) != 0)
                                                                                        (
                                                                                        {{ $test->pluck('point')->join(', ') }}
                                                                                        {{ __('setting.passed tests') }}
                                                                                        )
                                                                                    @else
                                                                                        <span
                                                                                            class="text-danger">
                                                                                        ({{ __('setting.No badges assign') }})
                                                                                    </span>
                                                                                    @endif
                                                                            </span>
                                                                                <span
                                                                                    class="text-nowrap ps-2">
                                                                                [{{ __('common.Available For') }}:
                                                                                <b>{{ availableRolesForBadges('learning') }}
                                                                                </b>] </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if(isModuleActive('Assignment'))
                                                                <div class="primary_input mb-25">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div
                                                                                class="d-flex align-items-center">
                                                                                <label
                                                                                    class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                    for="gamification_badges_assignment_status">
                                                                                    <input
                                                                                        type="checkbox"
                                                                                        class="common-radio"
                                                                                        id="gamification_badges_assignment_status"
                                                                                        name="gamification_badges_assignment_status"
                                                                                        {{ Settings('gamification_badges_assignment_status') ? 'checked' : '' }}
                                                                                        value="1">
                                                                                    <span
                                                                                        class="checkmark me-2"></span>
                                                                                    {{ __('setting.Assignment badges') }}

                                                                                    <span>
                                                                                    @if (count($assignment) != 0)
                                                                                            (
                                                                                            {{ $assignment->pluck('point')->join(', ') }}
                                                                                            {{ __('setting.passed assignments') }}
                                                                                            )
                                                                                        @else
                                                                                            <span
                                                                                                class="text-danger">
                                                                                            ({{ __('setting.No badges assign') }})
                                                                                        </span>
                                                                                        @endif
                                                                                </span>
                                                                                    <span
                                                                                        class="text-nowrap ps-2">
                                                                                    [{{ __('common.Available For') }}:
                                                                                    <b>{{ availableRolesForBadges('assignment') }}
                                                                                    </b>] </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div
                                                                            class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_badges_perfectionism_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_badges_perfectionism_status"
                                                                                       name="gamification_badges_perfectionism_status"
                                                                                       {{ Settings('gamification_badges_perfectionism_status') ? 'checked' : '' }}
                                                                                       value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span>
                                                                                {{ __('setting.Perfectionism badges') }}

                                                                                <span>
                                                                                @if (count($perfectionism) != 0)
                                                                                        (
                                                                                        {{ $perfectionism->pluck('point')->join(', ') }}
                                                                                        {{ __('setting.tests or assignments with score 90%+') }}
                                                                                        )
                                                                                    @else
                                                                                        <span
                                                                                            class="text-danger">
                                                                                        ({{ __('setting.No badges assign') }})
                                                                                    </span>
                                                                                    @endif
                                                                            </span>
                                                                                <span
                                                                                    class="text-nowrap ps-2">
                                                                                [{{ __('common.Available For') }}:
                                                                                <b>{{ availableRolesForBadges('performance') }}
                                                                                </b>] </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if(isModuleActive('Survey'))
                                                                <div class="primary_input mb-25">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div
                                                                                class="d-flex align-items-center">
                                                                                <label
                                                                                    class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                    for="gamification_badges_survey_status">
                                                                                    <input type="checkbox"
                                                                                           class="common-radio"
                                                                                           id="gamification_badges_survey_status"
                                                                                           name="gamification_badges_survey_status"
                                                                                           {{ Settings('gamification_badges_survey_status') ? 'checked' : '' }}
                                                                                           value="1">
                                                                                    <span
                                                                                        class="checkmark me-2"></span>
                                                                                    {{ __('setting.Survey badges') }}

                                                                                    <span>
                                                                                @if (count($survey) != 0)
                                                                                            (
                                                                                            {{ $survey->pluck('point')->join(', ') }}
                                                                                            {{ __('setting.completed surveys') }}
                                                                                            )
                                                                                        @else
                                                                                            <span
                                                                                                class="text-danger">
                                                                                        ({{ __('setting.No badges assign') }})
                                                                                    </span>
                                                                                        @endif
                                                                            </span>
                                                                                    <span
                                                                                        class="text-nowrap ps-2">
                                                                                [{{ __('common.Available For') }}:
                                                                                <b>{{ availableRolesForBadges('survey') }}
                                                                                </b>] </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if (Settings('hide_ecommerce') == 0)
                                                                <div class="primary_input mb-25">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div
                                                                                class="d-flex align-items-center">
                                                                                <label
                                                                                    class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                    for="gamification_badges_communication_status">
                                                                                    <input
                                                                                        type="checkbox"
                                                                                        class="common-radio"
                                                                                        id="gamification_badges_communication_status"
                                                                                        name="gamification_badges_communication_status"
                                                                                        {{ Settings('gamification_badges_communication_status') ? 'checked' : '' }}
                                                                                        value="1">
                                                                                    <span
                                                                                        class="checkmark me-2"></span>
                                                                                    {{ __('setting.Communication badges') }}
                                                                                    <span>
                                                                                    @if (count($communication) != 0)
                                                                                            (
                                                                                            {{ $communication->pluck('point')->join(', ') }}
                                                                                            {{ __('setting.topics or comments') }}
                                                                                            )
                                                                                        @else
                                                                                            <span
                                                                                                class="text-danger">
                                                                                            ({{ __('setting.No badges assign') }})
                                                                                        </span>
                                                                                        @endif
                                                                                </span>
                                                                                    <span
                                                                                        class="text-nowrap ps-2">
                                                                                    [{{ __('common.Available For') }}:
                                                                                    <b>{{ availableRolesForBadges('comment') }}
                                                                                    </b>] </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif


                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div
                                                                            class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_badges_certification_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_badges_certification_status"
                                                                                       name="gamification_badges_certification_status"
                                                                                       {{ Settings('gamification_badges_certification_status') ? 'checked' : '' }}
                                                                                       value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span>
                                                                                {{ __('setting.Certification badges') }}
                                                                            </label>

                                                                            @if (count($certification) != 0)
                                                                                (
                                                                                {{ $certification->pluck('point')->join(', ') }}
                                                                                {{ __('setting.certificates') }}
                                                                                )
                                                                            @else
                                                                                <span
                                                                                    class="text-danger">
                                                                                        ({{ __('setting.No badges assign') }})
                                                                                    </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="pb-2" data-id="3">
                                            <div class="accordion" id="accordionLevelContent">
                                                <div class="card">
                                                    <div class="card-header" id="heading3">
                                                        <h2 class="mb-0 d-flex align-item-center justify-content-between">
                                                            <div class="  text-start">

                                                                <div class="">
                                                                    {{ __('setting.Levels') }}
                                                                    <label
                                                                        class="switch_toggle "
                                                                        for="gamification_level_status">
                                                                        <input
                                                                            type="checkbox"
                                                                            class="gamification_level_status item_status"
                                                                            name="gamification_level_status"
                                                                            id="gamification_level_status"
                                                                            {{Settings('gamification_level_status')?'checked':''}}
                                                                            value="1">
                                                                        <i class="slider round"></i>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </h2>
                                                    </div>

                                                    <div class="collapse show">
                                                        <div class="card-body">


                                                            <div class="primary_input mb-25">
                                                                <div class="row">

                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_level_entry_point_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_level_entry_point_status"
                                                                                       name="gamification_level_entry_point_status"
                                                                                       {{Settings('gamification_level_entry_point_status')?'checked':''}}
                                                                                       value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('setting.Upgrade level every')}}


                                                                            </label>
                                                                            <input
                                                                                class="primary_input_field w-auto point-input"
                                                                                placeholder="" type="number" min="0"
                                                                                step="any"
                                                                                name="gamification_level_entry_point"
                                                                                value="{{Settings('gamification_level_entry_point')}}">
                                                                            <span>
                                                                          <span
                                                                              class="ps-2">  {{ __('setting.points') }}</span>
                                                                        </span>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="primary_input mb-25">
                                                                <div class="row">

                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_level_entry_complete_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_level_entry_complete_status"
                                                                                       name="gamification_level_entry_complete_status"
                                                                                       {{Settings('gamification_level_entry_complete_status')?'checked':''}}
                                                                                       value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('setting.Upgrade level every')}}
                                                                            </label>
                                                                            <input
                                                                                class="primary_input_field w-auto point-input"
                                                                                placeholder="" type="number" min="0"
                                                                                step="any"
                                                                                name="gamification_level_entry_complete_point"
                                                                                value="{{Settings('gamification_level_entry_complete_point')}}">
                                                                            <span>
                                                                          <span
                                                                              class="ps-2">  {{ __('setting.completed courses') }}</span>
                                                                        </span>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="primary_input mb-25">
                                                                <div class="row">

                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_level_entry_badge_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_level_entry_badge_status"
                                                                                       name="gamification_level_entry_badge_status"
                                                                                       {{Settings('gamification_level_entry_badge_status')?'checked':''}}
                                                                                       value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('setting.Upgrade level every')}}
                                                                            </label>
                                                                            <input
                                                                                class="primary_input_field w-auto point-input"
                                                                                placeholder="" type="number" min="0"
                                                                                step="any"
                                                                                name="gamification_level_entry_badge_point"
                                                                                value="{{Settings('gamification_level_entry_badge_point')}}">
                                                                            <span>
                                                                          <span
                                                                              class="ps-2">  {{ __('setting.badges') }}</span>
                                                                        </span>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pb-2" data-id="4">
                                            <div class="accordion" id="accordionRewardContent">
                                                <div class="card">
                                                    <div class="card-header" id="heading4">
                                                        <h2 class="mb-0 d-flex align-item-center justify-content-between">
                                                            <div class="  text-start">

                                                                <div class="">
                                                                    {{ __('setting.Rewards') }}
                                                                    <label
                                                                        class="switch_toggle "
                                                                        for="gamification_reward_status">
                                                                        <input
                                                                            type="checkbox"
                                                                            class="gamification_reward_status item_status"
                                                                            name="gamification_reward_status"
                                                                            id="gamification_reward_status"
                                                                            {{Settings('gamification_reward_status')?'checked':''}}
                                                                            value="1">
                                                                        <i class="slider round"></i>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </h2>
                                                    </div>

                                                    <div class="collapse show">
                                                        <div class="card-body">

                                                            <div class="primary_input mb-25">
                                                                <div class="row">

                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_reward_discount_course_point_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_reward_discount_course_point_status"
                                                                                       name="gamification_reward_discount_course_point_status"
                                                                                       {{Settings('gamification_reward_discount_course_point_status')?'checked':''}}
                                                                                       value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span>


                                                                            </label>

                                                                            <input
                                                                                class="primary_input_field w-auto point-input me-2"
                                                                                placeholder="" type="number" min="0"
                                                                                step="any"
                                                                                name="gamification_reward_discount_course_point"
                                                                                value="{{Settings('gamification_reward_discount_course_point')}}">
                                                                            % {{__('setting.discount for course purchases with more than')}}

                                                                            <input
                                                                                class="primary_input_field w-auto point-input ms-2"
                                                                                placeholder="" type="number" min="0"
                                                                                step="any"
                                                                                name="gamification_reward_course_point"
                                                                                value="{{Settings('gamification_reward_course_point')}}">
                                                                            <span>
                                                                          <span
                                                                              class="ps-2">  {{ __('setting.points') }}</span>
                                                                        </span>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>


                                                            <div class="primary_input mb-25">
                                                                <div class="row">

                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_reward_discount_course_badge_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_reward_discount_course_badge_status"
                                                                                       name="gamification_reward_discount_course_badge_status"
                                                                                       {{Settings('gamification_reward_discount_course_badge_status')?'checked':''}}
                                                                                       value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span>


                                                                            </label>

                                                                            <input
                                                                                class="primary_input_field w-auto point-input me-2"
                                                                                placeholder="" type="number" min="0"
                                                                                step="any"
                                                                                name="gamification_reward_discount_course_badge"
                                                                                value="{{Settings('gamification_reward_discount_course_badge')}}">
                                                                            % {{__('setting.discount for course purchases with more than')}}

                                                                            <input
                                                                                class="primary_input_field w-auto point-input ms-2"
                                                                                placeholder="" type="number" min="0"
                                                                                step="any"
                                                                                name="gamification_reward_course_badge"
                                                                                value="{{Settings('gamification_reward_course_badge')}}">
                                                                            <span>
                                                                          <span
                                                                              class="ps-2">  {{ __('setting.badges') }}</span>
                                                                        </span>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="primary_input mb-25">
                                                                <div class="row">

                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_reward_discount_course_level_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_reward_discount_course_level_status"
                                                                                       name="gamification_reward_discount_course_level_status"
                                                                                       {{Settings('gamification_reward_discount_course_level_status')?'checked':''}}
                                                                                       value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span>


                                                                            </label>

                                                                            <input
                                                                                class="primary_input_field w-auto point-input me-2"
                                                                                placeholder="" type="number" min="0"
                                                                                step="any"
                                                                                name="gamification_reward_discount_course_level"
                                                                                value="{{Settings('gamification_reward_discount_course_level')}}">
                                                                            % {{__('setting.discount for course purchases on level')}}

                                                                            <input
                                                                                class="primary_input_field w-auto point-input ms-2"
                                                                                placeholder="" type="number" min="0"
                                                                                step="any"
                                                                                name="gamification_reward_course_level"
                                                                                value="{{Settings('gamification_reward_course_level')}}">
                                                                            <span>
                                                                          <span
                                                                              class="ps-2">  {{ __('setting.upwards') }}</span>
                                                                        </span>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="primary_input mb-25">
                                                                <div class="row">

                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_reward_point_conversion_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_reward_point_conversion_status"
                                                                                       name="gamification_reward_point_conversion_status"
                                                                                       {{Settings('gamification_reward_point_conversion_status')?'checked':''}}
                                                                                       value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span>


                                                                            </label>

                                                                            {{__('setting.Points conversion')}}

                                                                            <input
                                                                                class="primary_input_field w-auto point-input ms-2"
                                                                                placeholder="" type="number" min="0"
                                                                                step="any"
                                                                                name="gamification_reward_point_conversion_rate"
                                                                                value="{{Settings('gamification_reward_point_conversion_rate')}}">
                                                                            <span>
                                                                          <span
                                                                              class="ps-2"> {{__('setting.points')}} = 1 {{Settings('currency_code')}} ({{Settings('currency_symbol')}})</span>
                                                                        </span>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pb-2" data-id="2">
                                            <div class="accordion" id="accordionBadgeContent">
                                                <div class="card">
                                                    <div class="card-header" id="heading2">
                                                        <h2 class="mb-0 d-flex align-item-center justify-content-between">
                                                            <div class="  text-start">

                                                                <div class="">
                                                                    {{ __('setting.Leaderboard') }}
                                                                    <label
                                                                        class="switch_toggle "
                                                                        for="gamification_leaderboard_status">
                                                                        <input
                                                                            type="checkbox"
                                                                            class="gamification_leaderboard_status item_status"
                                                                            name="gamification_leaderboard_status"
                                                                            id="gamification_leaderboard_status"
                                                                            {{Settings('gamification_leaderboard_status')?'checked':''}}
                                                                            value="1">
                                                                        <i class="slider round"></i>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </h2>
                                                    </div>

                                                    <div class="collapse show">
                                                        <div class="card-body">

                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_leaderboard_show_level_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_leaderboard_show_level_status"
                                                                                       name="gamification_leaderboard_show_level_status"
                                                                                       {{Settings('gamification_leaderboard_show_level_status')?'checked':''}}
                                                                                       value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('setting.Show levels')}}

                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_leaderboard_show_point_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_leaderboard_show_point_status"
                                                                                       name="gamification_leaderboard_show_point_status"
                                                                                       {{Settings('gamification_leaderboard_show_point_status')?'checked':''}}
                                                                                       value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('setting.Show points')}}

                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_leaderboard_show_badges_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_leaderboard_show_badges_status"
                                                                                       name="gamification_leaderboard_show_badges_status"
                                                                                       {{Settings('gamification_leaderboard_show_badges_status')?'checked':''}}
                                                                                       value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('setting.Show badges')}}

                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_leaderboard_show_courses_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_leaderboard_show_courses_status"
                                                                                       name="gamification_leaderboard_show_courses_status"
                                                                                       {{Settings('gamification_leaderboard_show_courses_status')?'checked':''}}
                                                                                       value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('setting.Show courses')}}

                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_leaderboard_show_certificate_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_leaderboard_show_certificate_status"
                                                                                       name="gamification_leaderboard_show_certificate_status"
                                                                                       {{Settings('gamification_leaderboard_show_certificate_status')?'checked':''}}
                                                                                       value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('setting.Show certificates')}}

                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="pb-2" data-id="2">
                                            <div class="accordion" id="accordionBadgeContent">
                                                <div class="card">
                                                    <div class="card-header" id="heading2">
                                                        <h2 class="mb-0 d-flex align-item-center justify-content-between">
                                                            <div class="text-start">

                                                                <div class="">
                                                                    {{ __('setting.Leaderboard') }} {{ __('setting.Filter') }}
                                                                    <label
                                                                        class="switch_toggle "
                                                                        for="gamification_leaderboard_filter_status">
                                                                        <input
                                                                            type="checkbox"
                                                                            class="gamification_leaderboard_filter_status item_status"
                                                                            name="gamification_leaderboard_filter_status"
                                                                            id="gamification_leaderboard_filter_status"
                                                                            {{Settings('gamification_leaderboard_filter_status')?'checked':''}}
                                                                            value="1">
                                                                        <i class="slider round"></i>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </h2>
                                                    </div>

                                                    <div class="collapse show">
                                                        <div class="card-body">

                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_leaderboard_filter_course_level_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_leaderboard_filter_course_level_status"
                                                                                       name="gamification_leaderboard_filter_course_level_status"
                                                                                       {{Settings('gamification_leaderboard_filter_course_level_status')?'checked':''}}
                                                                                       value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('setting.Course Level')}}

                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_leaderboard_filter_class_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_leaderboard_filter_class_status"
                                                                                       name="gamification_leaderboard_filter_class_status"
                                                                                       {{Settings('gamification_leaderboard_filter_class_status')?'checked':''}}
                                                                                       value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('setting.Class')}}

                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <label
                                                                                class="primary_checkbox w-auto h-auto text-nowrap d-flex mr-12"
                                                                                for="gamification_leaderboard_filter_institute_status">
                                                                                <input type="checkbox"
                                                                                       class="common-radio"
                                                                                       id="gamification_leaderboard_filter_institute_status"
                                                                                       name="gamification_leaderboard_filter_institute_status"
                                                                                       {{Settings('gamification_leaderboard_filter_institute_status')?'checked':''}}
                                                                                       value="1">
                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('setting.Institute')}}

                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-40">
                                <div
                                    class="col-lg-12  d-flex justify-content-center text-center flex-wrap">
                                    @if (permissionCheck('gamification.setting.update'))
                                        <button type="submit" class="primary-btn fix-gr-bg m-2">
                                            <i class="ti-check"></i>
                                            {{ __('common.Update') }}
                                        </button>
                                    @endif
                                    @if (permissionCheck('gamification.setting.reset'))
                                        <button type="button" class="primary-btn fix-gr-bg  m-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#confirm-reset">
                                            <i class="ti-reload"></i>

                                            {{ __('setting.Reset to default') }}
                                        </button>
                                    @endif
                                    @if (permissionCheck('gamification.reset.statistic'))
                                        <a class="primary-btn fix-gr-bg btn-modal  m-2"
                                           data-container="#commonModal"
                                           type="button"
                                           href="{{ route('gamification.reset.statistic') }}">
                                            <i class="ti-reload"></i>

                                            {{ __('setting.Reset Statistic') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>


                    </form>

                </div>


            </div>
        </div>
    </section>

    @if (permissionCheck('gamification.setting.reset'))
        <div class="modal fade admin-query" id="confirm-reset">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('setting.Reset to default setting') }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="ti-close "></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('gamification.setting.reset') }}" method="post">
                            @csrf
                            <h3 class="text-center">
                                {{ __('setting.Are you sure you want to reset to default settings') }}</h3>
                            <h6 class="text-center text-danger">
                                {{ __('setting.This action cannot be undone') }}
                            </h6>
                            <div class="col-lg-12 text-center">
                                <div class="mt-40 d-flex justify-content-between">
                                    <button type="button" class="primary-btn tr-bg"
                                            data-bs-dismiss="modal">{{ __('common.Cancel') }}</button>
                                    <button type="submit" id=""
                                            class="primary-btn semi_large2 fix-gr-bg">{{ __('common.Reset') }}</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
@push('scripts')
    <script>
        let gamification = $('#gamification_status');
        let point = $('#gamification_point_status');
        let badges = $('#gamification_badges_status');
        let level = $('#gamification_level_status');
        let reward = $('#gamification_reward_status');
        let leaderboard = $('#gamification_leaderboard_status');
        let filter = $('#gamification_leaderboard_filter_status');


        $(document).ready(function () {
            gamificationStatusCheck();
            allNodeCheck();
        });


        $(document).on('click', '#gamification_status', function () {
            gamificationStatusCheck();
            allNodeCheck();
        });

        function gamificationStatusCheck() {
            let gamification_status = gamification.is(":checked");

            changeStatus(point, gamification_status)
            changeStatus(badges, gamification_status)
            changeStatus(level, gamification_status)
            changeStatus(reward, gamification_status)
            changeStatus(leaderboard, gamification_status)
            changeStatus(filter, gamification_status)
        }

        function changeStatus(element, status) {
            let parent = element.parent('.switch_toggle')

            if (!status) {
                element.attr('disabled', true)
                parent.addClass('disable-btn');
            } else {
                element.attr('disabled', false)
                parent.removeClass('disable-btn');
            }
            allNodeCheck();
        }


        function changeNodeStatus(element) {
            let gamification_status = gamification.is(":checked");
            let element_status;
            if (!gamification_status) {
                element_status = false;
            } else {
                element_status = element.is(":checked");
            }

            element.closest('.accordion').find('.primary_input_field').each(function () {
                if (element_status) {
                    $(this).attr('disabled', false)
                } else {
                    $(this).attr('disabled', true)
                }
            });
            element.closest('.accordion').find('input:checkbox').each(function () {
                console.log($(this))
                let parent = $(this).parent('.primary_checkbox');
                if (parent.length != 0) {
                    if (!element_status) {
                        parent.addClass('disable-btn');
                    } else {
                        parent.removeClass('disable-btn');
                    }
                    if (element_status) {
                        $(this).attr('disabled', false)
                    } else {
                        $(this).attr('disabled', true)
                    }
                }

            });
        }

        function allNodeCheck() {
            $('.item_status').each(function () {
                changeNodeStatus($(this))
            });
        }

        $(document).on('click', '.item_status', function () {
            allNodeCheck();
        });
    </script>
@endpush
