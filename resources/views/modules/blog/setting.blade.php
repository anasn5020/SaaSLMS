@extends('backend.master')

@php
    $table_name='blogs';
@endphp
@section('table')
    {{$table_name}}
@endsection
@section('mainContent')
    <link rel="stylesheet"
          href="{{asset('Modules/Blog/Resources/views/assets/taginput/tagsinput.css')}}{{assetVersion()}}"/>

    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="white_box mb_30">
                <div class="white_box_tittle list_header main-title mb-20">
                    <h3 class="mb-0"> {{__('blog.Blog Setting')}}</h3>
                </div>

                <div class="col-lg-12 p-0">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <form action="" id="form_data_id" method="post">
                                @csrf

                                <div class="row row-gap-4">
                                    <div class="col-lg-4">
                                        <label class="primary_input_label w-100 mb-2">
                                            {{ __('blog.Auto Approval') }}
                                        </label>
                                        <div class="row g-0">
                                            <div class="col-6">
                                                <div class="input-effect">
                                                    <div class="">
                                                        <div class="text-start float-start">
                                                            <label
                                                                class="primary_checkbox d-flex"
                                                                for="auto_approval_yes">
                                                                <input type="radio" class="d-none"
                                                                       {{ Settings('blog_auto_approval') == 1 ? 'checked':'' }}
                                                                       name="blog_auto_approval"

                                                                       id="auto_approval_yes"
                                                                       value="1"
                                                                       class="common-radio relationButton read-only-input">
                                                                <span
                                                                    class="checkmark me-2"></span> {{__('common.Yes')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-effect">
                                                    <div class="">
                                                        <div class="text-start float-start">
                                                            <label
                                                                class="primary_checkbox d-flex"
                                                                for="auto_approval_no">
                                                                <input type="radio" class="d-none"
                                                                       {{ Settings('blog_auto_approval') == 0 ? 'checked':'' }}
                                                                       name="blog_auto_approval"
                                                                       id="auto_approval_no"

                                                                       value="0"
                                                                       class="common-radio relationButton read-only-input">

                                                                <span
                                                                    class="checkmark me-2"></span> {{__('common.No')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-6">
                                        <label class="primary_input_label w-100 mb-2">
                                            {{ __('blog.Blog Bonus') }}
                                        </label>
                                        <div class="row row-gap-4 g-0">
                                            <div class="col-sm-5 col-md-6">
                                                <div class="input-effect">
                                                    <div class="">
                                                        <div class="text-start float-start">
                                                            <label
                                                                class="primary_checkbox d-flex text-nowrap"
                                                                for="blog_credit_conversion_status">
                                                                <input type="checkbox"
                                                                       {{ Settings('blog_credit_conversion_status') == 1 ? 'checked':'' }}
                                                                       name="blog_credit_conversion_status"

                                                                       id="blog_credit_conversion_status"
                                                                       value="1"
                                                                       class="common-radio relationButton read-only-input d-none">
                                                                <span
                                                                    class="checkmark me-2"></span> {{__('blog.Credit Conversion')}}
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-7 col-md-6">
                                                <div class="input-effect">
                                                    <div class="">
                                                        <div
                                                            class="text-start float-start d-flex justify-content-start align-items-center"
                                                            style=" position: relative;top: -12px;">
                                                            <input name="blog_credit_conversion_point"
                                                                   style="width: 50%; max-width: 100px"
                                                                   class="primary_input_field text-center px-3 name"
                                                                   placeholder="0"
                                                                   type="number"
                                                                   min="0"
                                                                   value="{{Settings('blog_credit_conversion_point')}}">
                                                            <label
                                                                class="primary_checkbox d-flex text-nowrap ms-3"
                                                                for=" ">
                                                                {{__('blog.words = 1 Credit')}}
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="row  ">
                                    <div class="col d-flex justify-content-center">
                                        <button   id="general_info_sbmt_btn" class="primary-btn fix-gr-bg"><i
                                                class="ti-check"></i> {{__('common.Save')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        $(document).ready(function () {

            var submit_btn = $('#general_info_sbmt_btn');

            $('#form_data_id').on('submit', function (event) {
                event.preventDefault();
                submit_btn.html('Saving...');
                $.ajax({
                    url: "{{ route('company_information_update') }}",
                    method: "POST",
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if (data == 1) {
                            toastr.success("Operation Done Successfully", 'Success');
                            location.reload();

                        } else if (data == 2) {
                            toastr.success("For demo version,Update only time zone & currency ", 'Success');
                            location.reload();

                        } else {
                            toastr.error(
                                "Something went wrong", "Warning"
                            );
                        }
                        submit_btn.html('<i class="ti-check"></i> Save');

                    }
                })
            });

        });

    </script>
@endpush
