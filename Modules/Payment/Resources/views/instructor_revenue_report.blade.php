@php use Illuminate\Support\Facades\Auth; @endphp
@extends('backend.master')
@php
    $table_name='course_enrolleds';
$role_id =Auth::user()->role_id;
@endphp
@section('table')
    {{$table_name}}
@stop
@section('mainContent')

    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row">
                <div class="col-lg-12">
                    <div class="white_box">
                        <div class="white_box_tittle list_header main-title mb-0">
                            <h3 class="mb-0">{{__('courses.Advanced Filter')}} </h3>
                        </div>
                        <form action="" method="GET">

                            <div class="row">
                                @if($role_id==1)

                                    <div class="col-lg-4 mt-20">

                                        <label class="primary_input_label"
                                               for="instructor">{{__('courses.Instructor')}}</label>
                                        <select class="primary_select" name="instructor" id="instructor">
                                            <option data-display="{{__('common.Select')}} {{__('courses.Instructor')}}"
                                                    value="">{{__('common.Select')}} {{__('courses.Instructor')}}</option>
                                            @foreach($instructors as $instructor)
                                                <option {{$search_instructor==$instructor->id?'selected':''}}
                                                        value="{{$instructor->id}}">{{@$instructor->name}} </option>
                                            @endforeach
                                        </select>

                                    </div>
                                @endif
                                <div class="col-lg-4 mt-20 ">
                                    <label class="primary_input_label" for="month">{{__('courses.Month')}}</label>
                                    <select class="primary_select" name="month" id="month">
                                        <option data-display="{{__('common.Select')}} {{__('courses.Month')}}"
                                                value="">{{__('common.Select')}} {{__('courses.Month')}}</option>
                                        @php
                                            $formattedMonthArray = array(
                              "1" => "January", "2" => "February", "3" => "March", "4" => "April",
                              "5" => "May", "6" => "June", "7" => "July", "8" => "August",
                              "9" => "September", "10" => "October", "11" => "November", "12" => "December",
                          );
                                        @endphp
                                        @foreach($formattedMonthArray as $key=>$month)

                                            <option
                                                {{$search_month==$key?'selected':''}} value="{{$key}}">{{trans('data.data_'.$month)}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-lg-4 mt-20">

                                    <label class="primary_input_label" for="year">{{__('courses.Year')}}</label>
                                    <select class="primary_select" name="year" id="year">

                                        @php
                                            $starting_year  =date('Y');
                                            $ending_year = date('Y', strtotime('-10 year'));
                                            $yearArray = range($starting_year,$ending_year);
                                            $current_year = date('Y');
                                            foreach ($yearArray as $year) {
                                            echo '<option value="'.$year.'"';
                                            if ($search_year==$year){
                                                    echo ' selected="selected"';
                                            }
                                            elseif( $year ==  $current_year ) {
                                            echo ' selected="selected"';
                                            }
                                            echo ' >'.translatedNumber($year).'</option>';
                                            }
                                        @endphp
                                    </select>

                                </div>

                                <div class="{{$role_id==1?"col-12 mt-20":'col-lg-4 float-end mt-40'}}">
                                    {{-- @if($role_id!=1)
                                        <label class="primary_input_label pt-4"
                                               style="    margin-top: 5px;"> </label>
                                    @endif --}}

                                    <div
                                        class="search_course_btn  @if($role_id==1) text-end @endif">

                                        <button type="submit"
                                                class="primary-btn radius_30px   fix-gr-bg">{{__('courses.Filter')}} </button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="white-box mt-30">
                <div class="row mb-25">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 g-0 ">
                                <div class="main-title">
                                    <h3 class="mb-20"
                                        id="page_title">{{__('courses.Instructor')}}  {{__('courses.Revenue')}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
                <div class="QA_section QA_section_heading_custom check_box_table mt-30">
                    <div class="QA_table ">
                        <table id="lms_table" class="table Crm_table_active3">
                            <thead>
                            <tr>
                                <th scope="col">{{__('report.Purchase ID')}}</th>
                                <th scope="col"><span class="m-2">{{__('courses.Course Title')}}</span></th>
                                <th scope="col">{{__('courses.Enrollment')}} {{__('certificate.Date')}}</th>
                                <th scope="col">{{__('courses.Instructor')}} </th>
                                <th scope="col">{{__('courses.Purchase')}} {{__('courses.By')}} </th>
                                <th scope="col">{{__('courses.Purchase')}} {{__('courses.Price')}}</th>
                                <th scope="col">{{__('courses.Instructor')}} {{__('courses.Revenue')}}</th>

                            </tr>
                            </thead>

                            <tbody>
                            @if(isModuleActive('Subscription'))
                                @foreach($subscriptions as $subscription)

                                    <tr>
                                        <td>S-{{@$subscription['checkout_id']+1000}}</td>
                                        <td>
                                            <span class="m-2">
                                                <strong>Subscription - </strong>
                                                {{@$subscription['plan']}}</span>
                                        </td>
                                        <td>
                                            {{ showDate(@$subscription['date'] ) }}
                                        </td>


                                        <td>{{@$subscription->instructor}}</td>

                                        <td></td>
                                        <td></td>
                                        <td>{{getPriceFormat($subscription['price'])}}</td>


                                    </tr>
                                @endforeach
                            @endif

                            @foreach($enrolls as $enroll)
                                <tr>
                                    <td>C-{{@$enroll->id+1000}}</td>
                                    <td>
                                        <span class="m-2"> {{@$enroll->course->title}}</span>
                                    </td>
                                    <td>
                                        {{ showDate(@$enroll->created_at ) }}
                                    </td>


                                    <td>{{@$enroll->course->user->name}}</td>

                                    <td>{{@$enroll->user->name}}</td>
                                    <td>{{getPriceFormat($enroll->purchase_price)}}</td>
                                    <td>{{getPriceFormat($enroll->reveune)}}</td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
@push('scripts')
    <script type="application/javascript">


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4, 5, 6]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>

@endpush
