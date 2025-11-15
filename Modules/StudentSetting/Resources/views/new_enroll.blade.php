@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('public/backend/css/student_list.css') }}"/>
@endpush
@php
    $table_name='users';
@endphp
@section('table')
    {{ $table_name }}
@endsection

@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('student.New Enroll')}}</h3>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="">
                                    <form class="form-horizontal" action="{{route('student.new_enroll_submit')}}"
                                          method="POST"
                                          enctype="multipart/form-data">

                                        @csrf
                                        <div>

                                            <div class="col-md-12 p-0">

                                                <div class="row ">
                                                    <div class="col-md-12">

                                                        <div class="row">
                                                            <div class="col-xl-6">


                                                                <label class="primary_input_label"
                                                                       for="staticPagesInput"> {{__('student.Student')}}
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <div class="primary_input mb-15">
                                                                    <select name="student[]" id="userInput"
                                                                            class="multypol_check_select active mb-15 e1"
                                                                            multiple>

                                                                        @foreach ($students as $student)
                                                                            <option
                                                                                value="{{$student->id}}">{{$student->name}}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">

                                                                <label class="primary_input_label"
                                                                       for="staticPagesInput"> {{__('courses.Course')}}
                                                                    <span class="text-danger">*</span>
                                                                </label>

                                                                <select name="course[]" id=" "
                                                                        class="multypol_check_select active mb-15 e1"
                                                                        multiple>

                                                                    @foreach ($courses as $course)
                                                                        @php
                                                                            if ($course->type == 1) {
                                                                                $type = trans('courses.Courses');
                                                                            } elseif ($course->type == 2) {
                                                                                $type = trans('quiz.Quiz');
                                                                            } elseif ($course->type == 3) {
                                                                                $type = trans('virtual-class.Class');
                                                                            } else {
                                                                                $type = '';
                                                                            }

                                                                        @endphp
                                                                        <option value="{{ $course->id }}">
                                                                            {{ $course->title }} ({{ $type }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>

                                            <div class="row  ">
                                                <div class="col-lg-12 d-flex justify-content-center align-items-center text-center">
                                                    <button class="primary-btn fix-gr-bg" type="submit"
                                                            data-bs-toggle="tooltip">
                                                        <i class="ti-check"></i>
                                                        {{ __('student.Enroll Now') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection
@push('scripts')
@endpush
