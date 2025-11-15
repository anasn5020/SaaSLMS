@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('survey.Survey')}}
@endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')
    <style>
        .pb_50 {
            padding-bottom: 50px;
        }

        .cs_modal .modal-body input, .cs_modal .modal-body .nice_Select {
            height: 60px;
            line-height: 50px;
            padding: 0px 22px;
            border: 1px solid #F1F3F5;
            color: #707070;
            font-size: 14px;
            font-weight: 500;
            background-color: #fff;
            width: 100%;
        }

        .modal_1000px {
            max-width: 1000px;
        }
    </style>
    <div class="main_content_iner main_content_padding">

        <div class="dashboard_lg_card">
            <div class="container-fluid g-0">
                <div class="row">
                    <div class="col-12">
                        <div class="p-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section__title3 mb_40">
                                        <h3 class="mb-0">{{__('survey.Survey')}}</h3>
                                        <h4></h4>
                                    </div>
                                </div>
                            </div>
                            @if(count($surveys)==0)
                                <div class="col-12">
                                    <div class="section__title3 margin_50">
                                        <p class="text-center">{{__('survey.Survey Not Assigned')}}</p>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="table-responsive">
                                            <table class="table custom_table3 mb-0">
                                                <thead>
                                                <tr>
                                                    <th scope="col">{{__('common.SL')}}</th>
                                                    <th scope="col">{{__('common.Name')}}</th>
                                                    <th scope="col">{{ __('courses.Course') }}</th>
                                                    <th scope="col">{{__('common.Type')}}</th>
                                                    <th scope="col">{{__('common.Action')}}</th>
                                                </tr>
                                                <tbody>
                                                @php
                                                    $i =1;
                                                @endphp

                                                @foreach($surveys as $index => $survey)

                                                    @php
                                                        if ($survey->set_time && !empty($survey->publish_date)){
                                                            $startTime = \Carbon\Carbon::createFromFormat('m/d/Y' . ' g:i A', $survey->publish_date . ' ' . $survey->publish_time);
                                                              $isStart = now()->gt($startTime);

                                                              if (!$isStart){
                                                                  continue;
                                                              }
                                                        }
                                                    @endphp
                                                    @if($survey->survey_type!=1)
                                                        @php
                                                            try {
 $expireTime = \Carbon\Carbon::createFromFormat('m/d/Y' . ' g:i A', $survey->deadline_date . ' ' . $survey->deadline_time);
                                                             $isExpire = now()->gt($expireTime);

 }catch (\Exception $exception){
$isExpire =true;
 }
                                                              if ($isExpire){
                                                                  continue;
                                                              }
                                                        @endphp
                                                    @endif

                                                    <tr>
                                                        <td scope="col">{{ $i }}</td>
                                                        <td scope="col">{{ $survey->title }}</td>
                                                        <td scope="col">{{ $survey->course->title }}</td>
                                                        <td scope="col">
                                                            @if($survey->survey_type==1)
                                                                {{__('survey.Course survey')}}
                                                            @else
                                                                {{__('survey.Independence')}}
                                                            @endif
                                                        </td>
                                                        <td scope="col">
                                                            <a href="{{ route('survey.student_survey_participate', $survey->id) }}"
                                                               class=" link_value theme_btn small_btn4"
                                                               type="button">
                                                                {{$survey->loginUserParticipant()?trans('common.Edit'):trans('survey.Participate')}}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach


                                                </tbody>
                                            </table>
                                            {{ $surveys->links() }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
