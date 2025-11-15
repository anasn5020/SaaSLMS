@extends('backend.master')
@section('mainContent')
    <input type="text" hidden value="{{ @$clas->class_name }}" id="cls">
    <input type="text" hidden value="{{ @$sec->section_name }}" id="sec">
    {!! generateBreadcrumb() !!}

    <div class="row">
        <div class="col-lg-12">
            <div class="white-box mb-30">
                <form method="GET" action="" class="form-horizontal" id="search_student">
                    <div class="row">

                        <div class="col-lg-4 mt-30-md md_mb_20">
                            <label class="primary_input_label" for="category_id">{{__('common.Type')}}</label>
                            <select class="primary_select "
                                    id="category_id" name="type">
                                <option data-display=" {{__('common.Select')}}" value=""> {{__('common.Type')}}
                                </option>
                                <option value="Course" {{$type=='Course'?'selected':''}}>Course</option>
                                <option value="Quiz" {{$type=='Quiz'?'selected':''}}>Quiz</option>
                            </select>

                        </div>


                        <div class="col-lg-4 mt-100-md md_mb_20">
                            <label class="primary_input_label" for="" style="    height: 30px;"></label>
                            <button type="submit" class="primary-btn small fix-gr-bg">
                                <span class="ti-search pe-2"></span>
                                {{__('quiz.Search')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section class="mt-20 admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="row">

                    <div class="col-lg-6 col-md-6">
                        <div class="box_header">
                            <div class="main-title mb_xs_20px">
                                <h3 class="mb-0 mb_xs_20px"
                                    id="page_title">{{__('quiz.Result')}} {{__('common.View')}} </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table ">

                        <table id="lms_table" class="table Crm_table_active3">
                            <thead>
                            <tr>
                                <th>{{__('common.SL')}} </th>
                                <th> {{__('common.Date')}} </th>
                                <th> {{__('quiz.Student')}} </th>
                                @if(isModuleActive('Org'))
                                    <th> {{__('org.Branch')}} </th>
                                @endif
                                <th> {{__('quiz.Status')}} </th>
                                <th> {{__('quiz.Result')}} </th>
                                <th> {{__('quiz.Duration')}} </th>
                                <th> {{__('quiz.Focus lost')}} </th>

                                <th> {{__('quiz.Obtain Marks')}} </th>
                                <th> {{__('common.Action')}} </th>
                            </tr>
                            </thead>
                            <tbody>


                            @foreach($student_details as $key=>$student)
                                <tr>
                                    @php
                                        if (($student['status']==1)){
            $totalQus = totalQuizQus($student['quiz_id']);
                                                      $totalAns = count($student['quizDetails']);
                                                      $totalScore = totalQuizMarks($student['quiz_id']);
                                                      $score = 0;
                                                      if ($totalAns != 0) {
                                                          foreach ($student['quizDetails'] as $test) {
                                                               if ($test->status == 1) {
                                                                      $score += $test->mark ?? 1;
                                                                  }

                                                          }
                                                      }
        }else{
            $score='--';
        }


                                    @endphp
                                    <td> {{++$key}} </td>
                                    <td> {{$student['date']}} </td>
                                    <td> {{$student['name']}} </td>
                                    @if(isModuleActive('Org'))
                                        <td> {{$student['branch_name']??''}} </td>
                                    @endif
                                    <td> {{$student['status']==1?'Publish':'Pending'}} </td>
                                    <td>
                                        @if($student['status']==1)
                                            {{$student['pass']==1?'Pass':'Fail'}}
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td> {{$student['duration']}} {{__('quiz.Min')}}</td>

                                    <td> {{@$student['focus_lost']??0}} </td>
                                    <td> {{@$score}} </td>


                                    <td>

                                        <div class="dropdown CRM_dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenu2" data-bs-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false">
                                                {{ __('common.Select') }}
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                 aria-labelledby="dropdownMenu2">
                                                @if(permissionCheck('set-quiz.mark-register'))
                                                    <a class="dropdown-item edit_brand"
                                                       href="{{route('set-quiz.mark-register', [$student['test_id']])}}">
                                                        {{__('quiz.View Marking Script')}}
                                                    </a>
                                                @endif
                                                @if(permissionCheck('quizReTest'))
                                                    <a class="dropdown-item edit_brand quiz-re-test"
                                                       href="#"
                                                       data-url="{{route('quizReTest', [$student['test_id']])}}">
                                                        {{__('quiz.Re-Test')}}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>


                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade admin-query" id="reTestConfirmModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.Confirm')}}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">   {{__('frontend.Are you sure?')}}</h3>

                    <div class="col-lg-12 text-center">
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                            <a id="reTestConfirm" href="#"
                               class="primary-btn semi_large2 fix-gr-bg">{{ __('quiz.Re-Test') }}</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script src="{{asset('/Modules/Quiz/Resources/assets/js/quiz.js')}}{{assetVersion()}}"></script>
@endpush
