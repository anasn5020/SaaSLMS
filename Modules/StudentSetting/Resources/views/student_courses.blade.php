@php use Carbon\Carbon; @endphp
@extends('backend.master')
@push('styles')
    <style>
        .progress-bar {
            background-color: #9734f2;
        }
    </style>
@endpush
@section('mainContent')
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center mt-15">

                <div class="col-lg-12">
                    <div class="white-box">
                        <input type="hidden" name="student_id" value="{{$user->id}}">
                        <div class="main-title">
                            <h3 class="mb-20" id="page_title">{{__('student.Enrolled Courses')}} - {{$user->name}}</h3>

                        </div>

                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="">
                                    <table id="lms_table" class="table Crm_table_active3 studentCourse">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{__('common.ID')}}</th>
                                            <th scope="col" style="width: 50%">{{__('common.Name')}}</th>
                                             <th scope="col">{{__('common.Instructor')}}</th>
                                            <th scope="col">{{__('common.Progress')}}</th>
                                            <th scope="col">{{__('student.Enroll Date')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($instance as $index => $enroll)

                                            <tr>
                                                <td scope="col">{{ translatedNumber(++$index) }}</td>
                                                <td scope="col" style="width: 50%">
                                                    <a href="{{route('course.enrolled_students',$enroll->course->id)}}">
                                                        {{ $enroll?->course?->title }}
                                                    </a>
                                                </td>
                                                 <td scope="col">{{ $enroll?->course?->user?->name }}</td>
                                                <td scope="col">


                                                    <div class='progress_percent flex-fill text-end'>
                                                        <div class='progress theme_progressBar '>
                                                            <div class='progress-bar' role='progressbar'
                                                                 style="width: {{round($enroll->course->userTotalPercentage($enroll->user_id,$enroll->course_id))}}%"
                                                                 aria-valuenow='25'
                                                                 aria-valuemin='0' aria-valuemax='100'></div>
                                                        </div>
                                                        <p class='font_14 f_w_400'>
                                                            {{round($enroll->course->userTotalPercentage($enroll->user_id,$enroll->course_id))}}% {{__('courses.Completed')}}</p>
                                                    </div>
                                                </td>
                                                <td scope="col">{{ translatedNumber(Carbon::parse($enroll->created_at)->translatedFormat('d M, Y')) }}</td>
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
    </section>
@endsection

@push('scripts')
    <script>
        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1,2, 3, 4]);

        let table = $('.studentCourse').DataTable(dataTableOptions);

    </script>
@endpush
