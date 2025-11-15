@extends('backend.master')
@section('mainContent')

    {!! generateBreadcrumb() !!}
    <div class="white-box">

        <div class="row">
            <div class="col-md-12">
                <div class="box_header">
                    <div class="main-title d-flex justify-content-between w-100 flex-column flex-sm-row gap-3">
                        <h3 class="mb-0 ">  {{ __('quiz.Bulk Import') }}</h3>

                        <div class="">
                            <a href="{{route('coupons.common.import.sample')}}"
                               class="primary-btn small fix-gr-bg float-start float-sm-end">
                                <span class="ti-plus pe-2"></span>
                                {{__('quiz.Sample Download')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="mb-40 student-details">
            <div class="container-fluid p-0">
                <div class="row">

                    <div class="col-lg-12">


                        <form class="form-horizontal" action="{{route('coupons.common.import')}}" method="POST"
                              enctype="multipart/form-data">

                            @csrf


                            <div class="col-md-12 p-0">

                                <div class="row ">
                                    <div class="col-md-12">

                                        <div class="row">
                                            <div class="col-xl-12">

                                                <ul>
                                                    <li>
                                                       01. {{__('quiz.You need to import Excel File. For sample you can download by clicking')}}
                                                        <b>{{__('quiz.Sample Download')}}</b>
                                                    </li>
                                                    <li> 02. Coupon type will be <b>Fixed</b>, <b>Percentage</b></li>
                                                    <li>03. Start Date & End Date's date format <b>m/d/Y</b></li>
                                                    <li>04. Don't modify header row. use sample file for import</li>
                                                    <li>05. All files are required</li>
                                                    <li>06. Add limit for how many time can use same coupon code. 0 Means unlimited</li>
                                                </ul>

                                                <hr>
                                            </div>




                                            <div class="col-xl-12">

                                                <label class="primary_input_label"
                                                       for="groupInput">{{__('quiz.Excel File')}} *</label>
                                                <div class="primary_input ">
                                                    <div class="primary_file_uploader">

                                                        <label for="placeholderFileOneName" class="d-none"></label>
                                                        <input class="primary-input" type="text"
                                                               id="placeholderFileOneName"
                                                               placeholder="{{ __('quiz.Browse Excel File') }}"
                                                               readonly="">
                                                        <button class="" type="button">
                                                            <label class="primary-btn small fix-gr-bg"
                                                                   for="document_file_1">{{ __('common.Browse') }}</label>
                                                            <input type="file" class="d-none" name="excel_file"
                                                                   id="document_file_1"
                                                                   onchange="nameChange(this.value)">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-12 text-center d-flex justify-content-center">
                                    <button id="submitBtn" type="submit"
                                            class="primary-btn   fix-gr-bg"> {{ __('quiz.Bulk Import') }}</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
