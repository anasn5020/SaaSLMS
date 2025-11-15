@extends('backend.master')
@section('mainContent')
    @php
        $table_name='withdraws';
    @endphp
    @section('table')
        {{$table_name}}
    @stop
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            <div class="row mt-40 mb-25">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 g-0 ">
                            <div class="main-title">
                                <h3 class="mb-0">{{@$user->name}}</h3>
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
                            <th scope="col"> {{__('quiz.Instructor')}} </th>
                            <th scope="col">{{__('payment.Amount')}}</th>
                            <th scope="col">{{__('payment.Invoice Date')}}</th>
                            <th scope="col">{{__('payment.Method')}}</th>
                            <th scope="col">{{__('common.Issue Date')}}</th>
                            <th scope="col">{{__('common.Status')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($logs as $log)
                            <tr>

                                <td>{{@$log->user->name}}</td>
                                <td>{{getPriceFormat($log->amount)}}</td>
                                <td>{{ @$log->invoiceDate}}</td>
                                <td><strong> {{@$log->method}}</strong></td>
                                <td>
                                    @if ($log->issueDate!='')
                                        {{date('jS M, Y', strtotime(@$log->issueDate))}}
                                    @else
                                        {{__('common.Waiting')}}
                                    @endif

                                </td>
                                <td>
                                    <label class="switch_toggle">
                                        <input type="checkbox" class="status_enable_disable"
                                               @if (@$log->status == 1) checked @endif value="{{@$log->id }}">
                                        <i class="slider round"></i>
                                    </label>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

@endsection
