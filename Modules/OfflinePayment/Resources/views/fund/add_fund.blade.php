@extends('backend.master')
@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-between">
                <div class="col-md-12">

                    <div class="row student-details student-details_tab mt_0_sm m-0">

                        <!-- Start Sms Details -->
                        <div class="col-lg-12 p-0">
                            <div class="box_header common_table_header  d-none">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px" id="page_title">{{__('payment.Offline Payment') }}</h3>
                                </div>
                            </div>

                            <ul class="nav nav-tabs no-bottom-border mt_0_sm mb-20 m-0 justify-content-start"
                                role="tablist">
                                <li class="nav-item mb-0">
                                    <a class="nav-link
                                    @if(Session::has('isStudent'))
                                    @if(!Session::get('isStudent'))
                                        active
                                        @endif
                                    @else
                                        active
                                    @endif
                                        " href="#group_email_sms" selectTab="G" role="tab"
                                       data-bs-toggle="tab">{{__('quiz.Instructor')}}  </a>
                                </li>
                                <li class="nav-item mb-0">
                                    <a class="nav-link
 @if(Session::has('isStudent'))
                                    @if(Session::get('isStudent'))
                                        active
                                        @endif
                                    @endif
                                        " selectTab="I" href="#indivitual_email_sms" role="tab"
                                       data-bs-toggle="tab">{{__('quiz.Student')}}</a>
                                </li>


                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content white-box mt-20">
                                <input type="hidden" name="selectTab" id="selectTab">
                                <div role="tabpanel" class="tab-pane fade   @if(Session::has('isStudent'))
                                @if(!Session::get('isStudent'))
                                    show    active
@endif
                                @else
                                    show   active
@endif" id="group_email_sms">

                                    <div class="QA_section QA_section_heading_custom check_box_table mt-20">
                                        <div class="QA_table ">
                                            <table id="instructorList" class="table Crm_table_active3 instructorList">
                                                <thead>
                                                <tr>
                                                    <th>{{__('common.SL')}}</th>
                                                    <th>{{__('common.Name')}}</th>
                                                    <th>{{__('common.Email')}}</th>
                                                    <th>{{__('payment.Wallet')}}</th>
                                                    <th>{{__('common.Image')}}</th>
                                                    <th>{{__('common.Action')}}</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @php
                                                $instructorIndex = 0;
                                                @endphp
                                                @foreach($instructor as $key=>$value)
                                                    <tr id="{{ @$value->id}}">
                                                        <td>{{++$instructorIndex}}</td>
                                                        <td>{{@$value->name}}</td>
                                                        <td>{{@$value->email}}</td>
                                                        <td>{{getPriceFormat($value->balance,false)}}</td>

                                                        <td valign="top">
                                                            <div class="profile_info">

                                                                <img
                                                                    alt="{{@$value->name}}"
                                                                    src="{{getProfileImage($value->image,$value->name) }}"

                                                                    class="add_fund_profile_img">
                                                            </div>
                                                        </td>
                                                        <td>

                                                            <div class="dropdown CRM_dropdown">
                                                                <button class="btn btn-secondary dropdown-toggle"
                                                                        type="button" id="dropdownMenu2{{ @$value->id}}"
                                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                    {{__('common.Action')}}
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    @if (permissionCheck('offlinePayment.add'))
                                                                        <a class="dropdown-item showAddFund"
                                                                           data-id="{{@$value->id}}"
                                                                           href="#">{{__('common.Add')}}  {{__('payment.Fund')}}</a>
                                                                    @endif
                                                                    @if (permissionCheck('offlinePayment.deduct'))
                                                                        <a class="dropdown-item showDeductFund"
                                                                           data-id="{{@$value->id}}"
                                                                           data-bs-target="#DeductFund"
                                                                           href="#">{{__('payment.Deduct')}} {{__('payment.Fund')}}</a>
                                                                    @endif
                                                                    @if (permissionCheck('offlinePayment.fund-history'))
                                                                        <a class="dropdown-item"
                                                                           href="{{ route('offlinePayment.fund-history',@$value->id)}}"> {{__('payment.Fund History')}} </a>
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

                                <div role="tabpanel" class="tab-pane fade
 @if(Session::has('isStudent'))
                                @if(Session::get('isStudent'))
                                    show   active
@endif
                                @endif
                                    " id="indivitual_email_sms">

                                    <div class="QA_section QA_section_heading_custom check_box_table mt-20">
                                        <div class="QA_table ">
                                            <!-- table-responsive -->
                                            <table id="studentList" class="table Crm_table_active3">
                                                <thead>
                                                <tr>
                                                    <th>{{__('common.SL')}}</th>
                                                    <th>{{__('common.Name')}}</th>
                                                    <th>{{__('common.Email')}}</th>
                                                    <th>{{__('payment.Wallet')}}</th>
                                                    <th>{{__('common.Image')}}</th>
                                                    <th>{{__('common.Action')}}</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @php
                                                $studentIndex = 0;
                                                @endphp
                                                @foreach($student as $key2=>$value)
                                                    <tr id="{{ @$value->id}}">
                                                        <td>{{++$studentIndex}}</td>
                                                        <td>{{@$value->name}}</td>
                                                        <td>{{@$value->email}}</td>
                                                        <td>{{getPriceFormat($value->balance,false)}}</td>

                                                        <td valign="top">
                                                            <div class="profile_info">

                                                                <img
                                                                    src="{{getProfileImage($value->image,$value->name) }}"
                                                                    class="add_fund_profile_img">
                                                            </div>
                                                        </td>

                                                        <td>

                                                            <div class="dropdown CRM_dropdown">
                                                                <button class="btn btn-secondary dropdown-toggle"
                                                                        type="button" id="dropdownMenu2{{ @$value->id}}"
                                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                    {{__('common.Action')}}
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    @if (permissionCheck('offlinePayment.add'))
                                                                        <a class="dropdown-item showAddFund"
                                                                           data-id="{{@$value->id}}"
                                                                           href="#">{{__('common.Add')}}  {{__('payment.Fund')}}</a>
                                                                    @endif
                                                                    @if (permissionCheck('offlinePayment.deduct'))
                                                                        <a class="dropdown-item showDeductFund"
                                                                           data-id="{{@$value->id}}"
                                                                           data-bs-target="#DeductFund"
                                                                           href="#">{{__('payment.Deduct')}} {{__('payment.Fund')}}</a>
                                                                    @endif
                                                                    @if (permissionCheck('offlinePayment.fund-history'))
                                                                        <a class="dropdown-item"
                                                                           href="{{ route('offlinePayment.fund-history',@$value->id)}}"> {{__('payment.Fund History')}} </a>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade admin-query" id="AddFund">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.Add')}} {{__('payment.Fund')}}</h4>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('addBalance')}}"
                          method="post">
                        @csrf
                        <div class="row g-0  input-right-icon">
                            <div class="col">
                                <div class="input-effect">
                                    <label class="primary_input_label mt-1">{{__('payment.Amount')}}
                                        <span class="required_mark">*</span></label>
                                    <input class="primary_input_field"
                                           id="fund_amount" min="0"
                                           type="number"
                                           placeholder="{{__('payment.Amount')}} {{Settings('currency_symbol')}} "
                                           name="amount" value="">
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="user_id" id="AddFundId"
                               value="">
                        <div
                            class="mt-40 d-flex justify-content-between">
                            <button type="button"
                                    class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                            <button type="submit" class="primary-btn fix-gr-bg"
                                    id="_submit_btn_admission">
                                <i class="ti-check"></i>
                                {{__('common.Add')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade admin-query" id="DeductFund">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('payment.Deduct')}} {{__('payment.Fund')}}</h4>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('deductBalance')}}"
                          method="post">
                        @csrf
                        <div class="row g-0  input-right-icon">
                            <div class="col">
                                <div class="input-effect">
                                    <label class="primary_input_label mt-1">{{__('payment.Amount')}}
                                        <span class="required_mark">*</span></label>
                                    <input class="primary_input_field"
                                           id="fund_amount" min="0"
                                           type="number"
                                           placeholder="{{__('payment.Amount')}} {{Settings('currency_symbol')}} "
                                           name="amount" value="">
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="user_id" id="DeductUserId"
                               value="">


                        <div
                            class="mt-40 d-flex justify-content-between">
                            <button type="button"
                                    class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                            <button type="submit" class="primary-btn fix-gr-bg"
                                    id="">
                                <i class="ti-check"></i>
                                {{__('payment.Deduct')}}
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
        $(document).on('click', '.showAddFund', function () {
            $('#AddFundId').val($(this).data('id'))
            $('#AddFund').modal('show');
        });
        $(document).on('click', '.showDeductFund', function () {
            $('#DeductUserId').val($(this).data('id'))
            $('#DeductFund').modal('show');
        });


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2,3]);

         $('#instructorList').DataTable(dataTableOptions);
         $('#studentList').DataTable(dataTableOptions);


    </script>

@endpush

