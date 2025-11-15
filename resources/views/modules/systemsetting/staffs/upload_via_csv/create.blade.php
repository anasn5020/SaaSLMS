@extends('backend.master')
@push('css')
    <style>
        .red {
            color: red;
            font-size: 13px;
        }
    </style>
@endpush
@section('mainContent')
    <div id="add_product">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="white-box">

                            <div class="box_header d-block">
                                <div class="main-title d-flex flex-wrap">
                                    <h3 class="mb-0 mr-30 text-nowrap">{{ __('leave.Upload Staff Via CSV')}}</h3>
                                    <div class="d-flex justify-content-end align-items-center  flex-wrap flex-grow-1">
                                        <ul class="d-flex flex-wrap">
                                            <li><a download class="primary-btn radius_30px   fix-gr-bg"
                                                   href="{{ asset('public/uploads/staff.xlsx') }}"><i
                                                        class="ti-import"></i>Sample File Download</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <form action="{{route("staffs.csv_upload_store")}}" method="POST"
                                  enctype="multipart/form-data" class="csvForm">
                                @csrf
                                <div class="row form">
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="primary_input mb-15">
                                            <div class="primary_file_uploader">
                                                <input class="primary-input" type="text" id="placeholderFileOneName"
                                                       placeholder="{{__('setting.Browse file')}}" readonly="">
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg"
                                                           for="document_file_1">{{__("common.Browse")}} </label>
                                                    <input type="file" class="d-none" accept=".xlsx, .xls, .csv"
                                                           name="file" id="document_file_1">
                                                </button>
                                            </div>
                                            <span class="red">{{$errors->first('file')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label red" for="">Please download the sample
                                                file input your desire information then upload. Don't try to upload
                                                different file format and information</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="submit_btn text-center ">
                                        <button class="primary-btn semi_large2 fix-gr-bg csvFormBtn" type="submit"><i
                                                class="ti-check"></i>{{__('leave.Upload CSV')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push("scripts")
    <script type="text/javascript">
        $(document).ready(function () {
            $(".csvFormBtn").attr("disabled", false);
        });
        $(".csvFormBtn").on("click", function () {
            $(".csvForm").submit();
            $(".csvFormBtn").attr("disabled", true);
        });
    </script>
@endpush
