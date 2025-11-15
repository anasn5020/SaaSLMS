@extends('backend.master')
@section('mainContent')

    {!! generateBreadcrumb() !!}

    <div class="white-box">
        <div class="row">
            <div class="col-md-12">
                <div class="box_header mb-0">
                    <div class="main-title d-flex justify-content-between w-100">
                        <h3 class="mb-20 ">  {{ __('quiz.Bulk Import') }}</h3>

                        <div class="">
                            <a href="{{route('download-sample')}}" class="primary-btn small fix-gr-bg float-end ms-2">
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


                        <form class="form-horizontal" action="{{route('question-bank-bulk-submit')}}" method="POST"
                              enctype="multipart/form-data">

                            @csrf
                            <div>

                                <div class="col-md-12 p-0">

                                    <div class="row mb-30">
                                        <div class="col-md-12">

                                            <div class="row">
                                                <div class="col-xl-12">

                                                    <ul>
                                                        <li>
                                                            01. {{__('quiz.You need to import Excel File. For sample you can download by clicking')}}
                                                            <b>{{__('quiz.Sample Download')}}</b></li>
                                                        <li>
                                                            02. {{__('quiz.Make sure input correct answer in right column')}}
                                                        </li>
                                                        <li>
                                                            03. {{__('quiz.Each question start if No, Type, Question group is not empty')}}
                                                        </li>
                                                        <li>
                                                            04.{{__('quiz.The question is continue until finding new No')}}
                                                        </li>
                                                        <li>
                                                            05.
                                                            (1){{__('quiz.is the indicator to detect the correct answer')}}
                                                            . {{__('quiz.Blank means not correct')}}
                                                        </li>
                                                        <li>
                                                            06. {{__('quiz.Matching type Answer will be in matching Answer field')}} {{__('quiz.Each ans separate by')}}
                                                            "|"
                                                        </li>
                                                    </ul>

                                                    <hr>
                                                </div>


                                                <div class="col-xl-12">

                                                    <label class="primary_input_label"
                                                           for="groupInput">{{__('quiz.Excel File')}} <span
                                                            class="required_mark">*</span></label>
                                                    <div class="primary_input mb-35">
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

                                        <div class="col-md-7">
                                            <div class="row justify-content-center">

                                                @if(session()->has('message-success'))
                                                    <p class=" text-success">
                                                        {{ session()->get('message-success') }}
                                                    </p>
                                                @elseif(session()->has('message-danger'))
                                                    <p class=" text-danger">
                                                        {{ session()->get('message-danger') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-0">
                                    <div class="col-lg-12 text-center">
                                        <button id="submitBtn" type="submit" disabled
                                                class="btn primary-btn small fix-gr-bg">{{ __('quiz.Bulk Import') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
@push('scripts')
    <script src="{{asset('Modules/Appearance/Resources/assets/js/script.js')}}"></script>
    <script src="{{asset('Modules/Quiz/Resources/assets/js/quiz.js')}}"></script>
@endpush
