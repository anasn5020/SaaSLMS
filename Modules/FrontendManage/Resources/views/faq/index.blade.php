@extends('backend.master')

@php
    $table_name='home_page_faqs';
@endphp
@section('table')
    {{$table_name}}
@endsection

@section('mainContent')
    @php
        $LanguageList = getLanguageList();
    @endphp
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-12">
                                <div class="box_header common_table_header">
                                    <div class="main-title d-md-flex">
                                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px" id="page_title">{{__('frontend.FAQ List')}}</h3>

                                        <ul class="d-flex">
                                            <li><a class="primary-btn radius_30px   fix-gr-bg"
                                                   data-bs-toggle="modal"
                                                   id="add_faq_btn"
                                                   data-bs-target="#add_faq" href="#"><i
                                                        class="ti-plus"></i>{{__('frontend.Add FAQ')}}</a></li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="QA_section QA_section_heading_custom check_box_table">
                                    <div class="QA_table ">
                                        <!-- table-responsive -->
                                        <div class="">
                                            <table id="lms_table" class="table Crm_table_active3 ">
                                                <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">{{__('frontend.Question')}}</th>
                                                    <th scope="col">{{__('frontend.Answer')}}</th>
                                                    <th scope="col">{{__('common.Status')}}</th>
                                                    <th scope="col">{{__('common.Action')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($faqs as $key => $faq)
                                                    <tr data-item="{{$faq->id}}">
                                                        <td>
                                                            <i class="ti-menu"></i>
                                                        </td>
                                                        <td>{{@$faq->question}}</td>
                                                        <td>{!! @$faq->answer !!}</td>
                                                        <td class="nowrap">
                                                            <label class="switch_toggle">
                                                                <input type="checkbox"
                                                                       class="status_enable_disable"
                                                                       @if (@$faq->status == 1) checked
                                                                       @endif value="{{@$faq->id }}">
                                                                <i class="slider round"></i>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <div class="dropdown CRM_dropdown">
                                                                <button class="btn btn-secondary dropdown-toggle"
                                                                        type="button"
                                                                        id="dropdownMenu2" data-bs-toggle="dropdown"
                                                                        aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                    {{__('common.Action')}}
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right"
                                                                     aria-labelledby="dropdownMenu2">

                                                                    <button
                                                                        data-id="{{$faq->id}}"
                                                                        class="dropdown-item editfaq"
                                                                        type="button">{{__('common.Edit')}}</button>


                                                                    <button class="dropdown-item deletefaq"
                                                                            data-id="{{$faq->id}}"
                                                                            type="button">{{__('common.Delete')}}</button>

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

                <div class="modal fade admin-query" id="add_faq">
                    <div class="modal-dialog modal_1000px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{__('frontend.Add FAQ')}}</h4>
                                <button type="button" class="close " data-bs-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body student-details header-menu">
                                <form action="{{route('frontend.faq.store')}}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf


                                    <div class="row pt-0">
                                        @if(isModuleActive('FrontendMultiLang'))
                                            <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                role="tablist">
                                                @foreach ($LanguageList as $key => $language)
                                                    <li class="nav-item">
                                                        <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                           href="#element{{'_add_'.$language->code}}"
                                                           role="tab"
                                                           data-bs-toggle="tab">{{ $language->native }}  </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="tab-content">
                                        @foreach ($LanguageList as $key => $language)
                                            <div role="tabpanel"
                                                 class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                 id="element{{'_add_'.$language->code}}">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{__('frontend.Question')}} <strong
                                                                    class="text-danger">*</strong></label>
                                                            <input class="primary_input_field"
                                                                   name="question[{{$language->code}}]"
                                                                   placeholder="-"
                                                                   type="text" id="addQuestion"
                                                                   value="{{ old('question.'.$language->code) }}" {{$errors->first('question') ? 'autofocus' : ''}}>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-35">
                                                            <label class="primary_input_label"
                                                                   for="">{{__('frontend.Answer')}} <strong
                                                                    class="text-danger">*</strong></label>
                                                            @includeIf('aicontent::inc.button' , ['selected_template' => 9,'slug'=>'faq'])

                                                            <textarea class="lms_summernote"
                                                                      name="answer[{{$language->code}}]"
                                                                      id="addAnswer" cols="30"
                                                                      rows="10">{{ old('answer.'.$language->code) }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="col-lg-12 text-center pt_15">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"
                                                    type="submit"><i
                                                    class="ti-check"></i> {{__('common.Save')}} {{__('frontend.FAQ')}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade admin-query" id="editfaq">
                    <div class="modal-dialog modal_1000px modal-dialog-centered" id="editFaqBody">
                    </div>
                </div>
                <div class="modal fade admin-query" id="deletefaq">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{__('common.Delete')}} {{__('frontend.FAQ')}} </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                        class="ti-close "></i></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{route('frontend.faq.destroy')}}" method="post">
                                    @csrf

                                    <div class="text-center">

                                        <h4>{{__('common.Are you sure to delete ?')}} </h4>
                                    </div>
                                    <input type="hidden" name="id" value="" id="faqDeleteId">
                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                                data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                                        <button class="primary-btn fix-gr-bg"
                                                type="submit">{{__('common.Delete')}}</button>

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
@push('scripts')
    @include('frontendmanage::faq.script')
@endpush

