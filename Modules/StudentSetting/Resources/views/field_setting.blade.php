@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/student_list.css')}}"/>
@endpush
@php
    $table_name='users'
@endphp
@section('table')
    {{$table_name}}
@endsection

@section('mainContent')

    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="mb_30">
                            <form action="{{route('student.student_field_store')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="">
                                            <div class="white_box_tittle list_header">
                                                <h4>{{__('common.Input Field Showing in Registration')}}</h4>
                                            </div>
                                            <div class=" d-flex justify-content-between mb-3">
                                                <p>{{ __('common.company') }}</p>
                                                <label class="switch_toggle">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           name="show_company"
                                                           value="1" {{ $field->show_company ? 'checked' : '' }}>
                                                    <i class="slider round"></i>
                                                </label>
                                            </div>

                                            <div class=" d-flex justify-content-between mb-3">
                                                <p>{{ __('common.gender') }}</p>
                                                <label class="switch_toggle">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           name="show_gender"
                                                           value="1" {{ $field->show_gender ? 'checked' : '' }}>
                                                    <i class="slider round"></i>
                                                </label>
                                            </div>

                                            <div class=" d-flex justify-content-between mb-3">
                                                <p>{{ __('common.student_type') }}</p>
                                                <label class="switch_toggle">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           name="show_student_type"
                                                           value="1" {{ $field->show_student_type ? 'checked' : '' }}>
                                                    <i class="slider round"></i>
                                                </label>
                                            </div>

                                            <div class=" d-flex justify-content-between mb-3">
                                                <p>{{ __('common.identification_number') }}</p>
                                                <label class="switch_toggle">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           name="show_identification_number"
                                                           value="1" {{ $field->show_identification_number ? 'checked' : '' }}>
                                                    <i class="slider round"></i>
                                                </label>
                                            </div>

                                            <div class=" d-flex justify-content-between mb-3">
                                                <p>{{ __('common.job_title') }}</p>
                                                <label class="switch_toggle">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           name="show_job_title"
                                                           value="1" {{ $field->show_job_title ? 'checked' : '' }}>
                                                    <i class="slider round"></i>
                                                </label>
                                            </div>

                                            <div class=" d-flex justify-content-between mb-3">
                                                <p>{{ __('common.Date of Birth') }}</p>
                                                <label class="switch_toggle">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           name="show_dob"
                                                           value="1" {{ $field->show_dob ? 'checked' : '' }}>
                                                    <i class="slider round"></i>
                                                </label>
                                            </div>


                                            <div class=" d-flex justify-content-between mb-3">
                                                <p>{{ __('common.Phone') }}</p>
                                                <label class="switch_toggle">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           name="show_phone"
                                                           value="1" {{ $field->show_phone ? 'checked' : '' }}>
                                                    <i class="slider round"></i>
                                                </label>
                                            </div>
                                            <div class=" d-flex justify-content-between mb-3">
                                                <p>{{ __('student.Institute') }}</p>
                                                <label class="switch_toggle">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           name="show_institute"
                                                           value="1" {{ $field->show_institute ? 'checked' : '' }}>
                                                    <i class="slider round"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="">
                                            <div class="white_box_tittle list_header">
                                                <h4>{{__('common.Required Field')}}</h4>
                                            </div>
                                            <div class=" d-flex justify-content-between mb-3">
                                                <p>{{ __('common.company') }}</p>
                                                <label class="switch_toggle">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           name="required_company"
                                                           value="1" {{ $field->required_company ? 'checked' : '' }}>
                                                    <i class="slider round"></i>
                                                </label>
                                            </div>

                                            <div class=" d-flex justify-content-between mb-3">
                                                <p>{{ __('common.gender') }}</p>
                                                <label class="switch_toggle">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           name="required_gender"
                                                           value="1" {{ $field->required_gender ? 'checked' : '' }}>
                                                    <i class="slider round"></i>
                                                </label>
                                            </div>

                                            <div class=" d-flex justify-content-between mb-3">
                                                <p>{{ __('common.student_type') }}</p>
                                                <label class="switch_toggle">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           name="required_student_type"
                                                           value="1" {{ $field->required_student_type ? 'checked' : '' }}>
                                                    <i class="slider round"></i>
                                                </label>
                                            </div>

                                            <div class=" d-flex justify-content-between mb-3">
                                                <p>{{ __('common.identification_number') }}</p>
                                                <label class="switch_toggle">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           name="required_identification_number"
                                                           value="1" {{ $field->required_identification_number ? 'checked' : '' }}>
                                                    <i class="slider round"></i>
                                                </label>
                                            </div>

                                            <div class=" d-flex justify-content-between mb-3">
                                                <p>{{ __('common.job_title') }}</p>
                                                <label class="switch_toggle">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           name="required_job_title"
                                                           value="1" {{ $field->required_job_title ? 'checked' : '' }}>
                                                    <i class="slider round"></i>
                                                </label>
                                            </div>

                                            <div class=" d-flex justify-content-between mb-3">
                                                <p>{{ __('common.Date of Birth') }}</p>
                                                <label class="switch_toggle">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           name="required_dob"
                                                           value="1" {{ $field->required_dob ? 'checked' : '' }}>
                                                    <i class="slider round"></i>
                                                </label>
                                            </div>


                                            <div class=" d-flex justify-content-between mb-3">
                                                <p>{{ __('common.Phone') }}</p>
                                                <label class="switch_toggle">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           name="required_phone"
                                                           value="1" {{ $field->required_phone ? 'checked' : '' }}>
                                                    <i class="slider round"></i>
                                                </label>
                                            </div>

                                            <div class=" d-flex justify-content-between mb-3">
                                                <p>{{ __('student.Institute') }}</p>
                                                <label class="switch_toggle">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           name="required_institute"
                                                           value="1" {{ $field->required_institute ? 'checked' : '' }}>
                                                    <i class="slider round"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="d-flex justify-content-center align-items-center">
                                        <button type="submit" class="primary-btn fix-gr-bg">
                                            <i class="ti-check"></i>
                                            {{__('common.Update')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Add Modal Item_Details -->
                </div>
            </div>
        </div>
    </section>

@endsection
