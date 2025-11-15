@extends('backend.master')

@section('table')
    @php
        $table_name='withdraws';
    @endphp
    {{$table_name}}
@endsection
@section('mainContent')

    {!! generateBreadcrumb() !!}

    @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="white_box mb_30">
                    <div class="white_box_tittle list_header main-title mb-0">
                        <h3 class="mb-0">{{__('courses.Advanced Filter')}} </h3>
                    </div>
                    <form action="{{route('admin.instructor.payout')}}" method="GET">

                        <div class="row align-items-end">

                            <div class="col-lg-3 mt-20">

                                <label class="primary_input_label" for="month">{{__('courses.Month')}}</label>
                                <select name="month" size="1" class="primary_select" id="month">
                                    <option value="">{{ __('common.Select') }} {{ __('courses.Month') }}</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        @php
                                            $label = date('F', mktime(0, 0, 0, $i, 1));
                                        @endphp
                                        <option value="{{ $i }}"
                                            {{ request()->get('month') == $i ? 'selected' : '' }}>
                                            {{ __('data.data_' . $label) }}
                                        </option>
                                    @endfor
                                </select>


                            </div>
                            <div class="col-lg-3 mt-20">

                                <label class="primary_input_label" for="year">{{__('courses.Year')}}</label>
                                <select name="year" size='1' class="primary_select" id="year">
                                    <option data-display="{{__('common.Select')}} {{__('courses.Year')}}"
                                            value="">{{__('common.Select')}} {{__('courses.Year')}}</option>
                                    @php
                                        for ($i = date('Y'); $i > 2010; $i--) {
                                    @endphp
                                    <option value="{{$i}}"
                                    @if(isset($_GET['year']))
                                        {{$_GET['year']==$i?'selected':''}}
                                        @endif>{{translatedNumber($i)}}</option>


                                    @php            }
                                    @endphp
                                </select>

                            </div>
                            <div class="col-lg-3 mt-20">

                                <label class="primary_input_label"
                                       for="instructor">{{__('courses.Instructor')}}</label>
                                <select class="primary_select" name="instructor" id="instructor">
                                    <option data-display="{{__('common.Select')}} {{__('courses.Instructor')}}"
                                            value="">{{__('common.Select')}} {{__('courses.Instructor')}}</option>
                                    @foreach(@$instructors as $instructor)
                                        <option
                                            value="{{$instructor->id}}"
                                        @if(isset($_GET['instructor']))
                                            {{$_GET['instructor']==$instructor->id?'selected':''}}
                                            @endif
                                        >{{@$instructor->name}} </option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-lg-3 mt-20">


                                <div class="search_course_btn">
                                    <button type="submit"
                                            class="primary-btn radius_30px   fix-gr-bg">{{__('courses.Filter')}} </button>
                                </div>

                            </div>


                            <div class="col-12 mt-20">

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="row row-gap-24 mb-4">
            <div class="col-md-4">
                <div class="white-box p-3 h-100">
                    <h1>{{__('payment.Balance')}} </h1>
                    <p class="mt-30">{{__('withdraw.You Currently Have')}}
                        @if(Auth::user()->balance==0)
                            {{Settings('currency_symbol')??'৳'}} 0
                        @else
                            {{getPriceFormat(Auth::user()->balance)}}
                        @endif
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="white-box p-3 h-100">
                    <h1>{{__('withdraw.Next Payout')}}</h1>
                    <p class="mt-10">{{__('withdraw.You Currently Have')}} {{$remaining!=0?getPriceFormat($remaining):0 }} {{__('withdraw.in earnings for next months payout') }}</p>

                    @if($remaining!=0)
                        <button type="button" data-bs-toggle="modal" data-bs-target="#requestForm"
                                class="primary-btn fix-gr-bg mt-40">{{__('withdraw.Payment Request')}}</button>
                    @endif

                </div>
            </div>

            <div class="col-md-4">
                <div class="white-box p-3 h-100">
                    <h1>{{__('withdraw.Payout Account')}}</h1>
                    <div class="row">
                        <div class="col-md-12">
                            @if(auth()->user()->payout=="Bank Payment")
                                {{--                        <b class="pt-3  ">{{auth()->user()->payout}}</b>--}}
                                <p class="pb-20">
                                    <b>{{__('setting.Bank Name')}}</b>: {{auth()->user()->bank_name}} <br>
                                    <b>{{__('setting.Branch Name')}}</b>: {{auth()->user()->branch_name}} <br>
                                    <b>{{__('setting.Account Number')}}</b>: {{auth()->user()->bank_account_number}}
                                    <br>
                                    <b>{{__('setting.Account Holder')}}</b>: {{auth()->user()->account_holder_name}}
                                    <br>
                                </p>
                            @else
                                <img src="{{asset(auth()->user()->payout_icon)}}" width="100px"
                                     alt="{{auth()->user()->payout_icon}}">
                                <p class="pt-3 pb-3">{{auth()->user()->payout_email}}</p>
                            @endif

                            <a href="{{route('set.payout')}}" class="primary-btn btn-fit fix-gr-bg ps-2 pe-2"
                               style="    width: 150px;"
                            >{{__('withdraw.Set Account')}}</a>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="row mt-0 mb-25">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="main-title">
                                    <h3 class="mb-0" id="page_title">{{__('withdraw.Instructor Payment')}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
                <div class="QA_section QA_section_heading_custom check_box_table mt-30">
                    <div class="QA_table ">
                        <!-- table-responsive -->
                        <table id="lms_table" class="table Crm_table_active3">
                            <thead>
                            <tr>
                                <th scope="col">{{__('common.SL')}}</th>
                                <th scope="col">{{__('withdraw.Instructor')}}</th>
                                <th scope="col">{{__('withdraw.Amount')}}</th>
                                <th scope="col">{{__('withdraw.Request Date')}}</th>
                                <th scope="col">{{__('payment.Payment Method')}}</th>
                                <th scope="col">{{__('withdraw.Payment Status')}}</th>
                                @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
                                    <th scope="col">{{__('common.Action')}}</th>
                                @endif
                            </tr>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <div class="modal fade admin-query" id="requestForm">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('withdraw.Request for payment')}}? </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('admin.instructor.instructorRequestPayout')}}" method="post">
                        @csrf


                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="nameInput">{{ __('common.Amount') }} <strong
                                    class="text-danger">*</strong></label>
                            <input class="primary_input_field" name="amount" type="number" min="0"
                                   value="{{$remaining}}"
                                   max="{{$remaining}}" required step="any">

                        </div>

                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>


                            <button type="submit" class="primary-btn fix-gr-bg"
                                    data-bs-toggle="tooltip"
                                    title="">
                                <i class="ti-check"></i>
                                {{ __('withdraw.Confirm') }}
                            </button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade admin-query" id="makeAsPay">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('withdraw.Confirm')}}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('admin.instructor.instructorCompletePayout')}}" method="post">
                        @csrf

                        <div class="text-center">
                            <input type="hidden" value="" name="withdraw_id" id="withdraw_id">
                            <input type="hidden" value="" name="instructor_id" id="instructor_id">
                            <h4>{{__('withdraw.Are you Sure, You want to mark as payment?')}} </h4>
                        </div>
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                            <button type="submit" class="primary-btn fix-gr-bg"
                                    data-bs-toggle="tooltip"
                                    title="">
                                <i class="ti-check"></i>
                                {{ __('withdraw.Confirm') }}
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).on('click', '.makeAsPaid', function () {
            let instructor_id = $(this).data('instructor_id');
            let id = $(this).data('withdraw_id');
            $("#instructor_id").val(instructor_id);
            $("#withdraw_id").val(id);
            $("#makeAsPay").modal('show');

        });
    </script>
@endpush


@push('scripts')

    @php
        if (isset($_GET['instructor'])){
        $instructor =$_GET['instructor'];
    }else{
        $instructor ='';
    }

    if (isset($_GET['month'])){
        $month =$_GET['month'];
    }else{
        $month ='';
    }

    if (isset($_GET['year'])){
        $year =$_GET['year'];
    }else{
        $year ='';
    }


            $url =route('admin.getPayoutData').'?instructor='.$instructor.'&month='.$month.'&year='.$year;
    @endphp


    <script>
        dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        dataTableOptions.ajax = '{!! $url !!}';
        dataTableOptions.columns = [
            {data: 'DT_RowIndex', name: 'id',orderable: false},
            {data: 'user.name', name: 'user.name',orderable: false},
            {data: 'amount', name: 'amount',orderable: false},
            {data: 'requested_date', name: 'requested_date',orderable: false},
            {data: 'method', name: 'method', orderable: false},
            {data: 'status', name: 'status', orderable: false},
                @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
            {
                data: 'action', name: 'action', orderable: false
            },
            @endif

        ];

        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4,5]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>
@endpush

