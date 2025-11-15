@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/student_list.css')}}"/>
@endpush
@php
    $table_name='users';
@endphp
@section('table')
    {{$table_name}}
@endsection

@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="main-title">
                            <h3>{{__('student.Import Student')}}</h3>
                        </div>
                    </div>
                    <div class="col-lg-6 text-end mb-20 d-flex gap-10 flex-wrap justify-content-end">
                        <a href="{{route('country_list_download')}}">
                            <button class="primary-btn tr-bg text-uppercase bord-rad">
                                {{__('common.Country List')}} {{__('common.Download')}}
                                <span class="pl ti-download"></span>
                            </button>
                        </a>
                        <a href="{{route('student_excel_download')}}">
                            <button class="primary-btn tr-bg text-uppercase bord-rad">
                                {{__('common.Sample Download')}}
                                <span class="pl ti-download"></span>
                            </button>
                        </a>
                    </div>

                </div>

                <form method="POST" action="{{ route('student_import_save') }}" class="form-horizontal"
                      enctype="multipart/form-data" id="student_form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">


                            <div>
                                <div class="">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="main-title">

                                            </div>
                                        </div>
                                    </div>
                                    <div>

                                        <ul class="ps-3">
                                            @if ($custom_field->show_gender==1)
                                                <li style="">
                                                    {{__('student.Use')}}
                                                    'male' {{__('common.For')}} {{__('common.Male')}}
                                                    ,'female' {{__('common.For')}} {{__('common.Female')}} &
                                                    'other' {{__('common.For')}} {{__('common.Other')}}
                                                </li>
                                            @endif
                                            @if ($custom_field->show_student_type!==1)
                                                <li>
                                                    {{__('student.Use')}}
                                                    'personal' {{__('common.For')}} {{__('student.Personal')}} {{__('student.Or')}}
                                                    'corporate' {{__('common.For')}}
                                                    {{__('student.Corporate')}}
                                                </li>
                                            @endif
                                            <li>
                                                {{__('student.Use')}}
                                                'mm-dd-yyyy' {{__('student.format')}} {{__('common.For')}} {{__('common.Date of Birth')}}
                                            </li>
                                            <liz
                                                `>
                                                {{__('student.Use')}} 'id' {{__('common.For')}} {{__('common.Country')}}
                                                . {{__("student.For getting country ID Download Country List")}}
                                            </liz>
                                        </ul>
                                    </div>

                                    <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                    <div class="row mt-30">


                                        <div class="col-lg-6">

                                            <label class="primary_input_label" for="course">{{__('courses.Course')}}
                                                <strong class="text-danger">*</strong> </label>
                                            <select class="primary_select" name="course" id="course">
                                                <option data-display="{{__('common.Select')}} {{__('courses.Course')}}"
                                                        value="">{{__('common.Select')}} {{__('courses.Course')}}</option>
                                                @foreach($courses as $course)
                                                    <option
                                                        value="{{$course->id}}">{{@$course->title}} </option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="col-lg-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Browse')}} CSV/Excel <strong
                                                        class="text-danger">*</strong> </label>
                                                <div class="">

                                                    <div class="primary_file_uploader">
                                                        <input class="primary-input" type="text"
                                                               id="placeholderFileOneName"
                                                               placeholder="{{__('setting.Browse file')}}" readonly="">
                                                        <button class="" type="button">
                                                            <label class="primary-btn small fix-gr-bg"
                                                                   for="document_file_1">{{ __('common.Browse') }}</label>
                                                            <input type="file" class="d-none" name="file"
                                                                   id="document_file_1">
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row  ">
                                        <div class="col-lg-12 d-flex justify-content-center align-content-center">
                                            <button type="submit" class="primary-btn fix-gr-bg">
                                                <i class="ti-check"></i>
                                                {{__('student.Import Student')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection

