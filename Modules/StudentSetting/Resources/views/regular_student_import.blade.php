@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/student_list.css')}}"/>
@endpush


@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <form method="POST" action="{{ route('regular_student_import_save') }}" class="form-horizontal" enctype="multipart/form-data" id="student_form">
                @csrf
            <div class="row">
                <div class="col-lg-12">


                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="main-title">
                                    <h3>{{__('student.Import Student')}}</h3>
                                </div>
                            </div>
                            <div class="offset-lg-2 col-lg-4 text-end mb-20">

                                <a href="{{route('regular_student_excel_download')}}"
                                   class="primary-btn tr-bg text-uppercase bord-rad float-end">
                                    {{__('common.Download')}}
                                    <span class="pl ti-download"></span>
                                </a>
                            </div>

                        </div>

                        <div class="">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-title">

                                    </div>
                                </div>
                            </div>


                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                            <div class="row   mt-0">
                                <div class="col-lg-12">
                                    <div class="primary_input mb-3">
                                        <label class="primary_input_label"
                                               for="">{{__('common.Browse')}} {{__('common.Excel File')}} <strong
                                                class="text-danger">*</strong> </label>
                                        <div class="primary_file_uploader">
                                            <input class="primary-input filePlaceholder labelTitle" type="text"
                                                   id=""
                                                   placeholder="{{__('common.Browse')}} {{__('common.Excel File')}}"
                                                   readonly="">
                                            <div class="">
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg"
                                                           for="document_file_2">{{__('common.Browse') }}</label>
                                                    <input type="file" class="d-none fileUpload labelTitle"
                                                           name="file"
                                                           id="document_file_2">
                                                </button>

                                            </div>
                                        </div>

                                    </div>


                                </div>

                            </div>

                            <div class="row  ">
                                <div class="col-lg-12 d-flex justify-content-center align-items-center">
                                    <button type="submit" class="primary-btn fix-gr-bg">
                                        <i class="ti-check"></i>
                                        {{__('student.Import Student')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </section>

@endsection
