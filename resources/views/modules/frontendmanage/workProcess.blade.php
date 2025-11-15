@extends('backend.master')
@section('table')
    @php
        $table_name='work_processes';
         $LanguageList = getLanguageList();
    @endphp
    {{$table_name}}
@stop
@section('mainContent')

    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center mt-50">

                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">  {{__('quiz.Topic')}} {{__('courses.List')}}</h3>

                            <ul class="d-flex">
                                <li><a class="primary-btn radius_30px   fix-gr-bg" data-bs-toggle="modal"
                                       data-bs-target="#add_topic" href="#"><i
                                            class="ti-plus"></i>{{__('common.Add')}} {{__('quiz.Topic')}}</a></li>
                            </ul>

                        </div>

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.SL') }}</th>
                                        <th scope="col">{{__('common.Title')}}</th>
                                        <th scope="col">{{__('common.Description')}}</th>
                                        <th scope="col">{{ __('common.Status') }}</th>
                                        <th scope="col">{{ __('common.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($works as $key => $work)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{$work->title}}</td>
                                            <td>{!! $work->description !!}</td>
                                            <td>
                                                <label class="switch_toggle">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           @if (@$work->status == 1) checked
                                                           @endif value="{{@$work->id }}">
                                                    <i class="slider round"></i>
                                                </label>

                                            </td>
                                            <td>
                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-bs-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        {{__('common.Action')}}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenu2">
                                                        <a href="#" data-bs-toggle="modal"
                                                           data-bs-target="#editSetting{{@$work->id}}"
                                                           class="dropdown-item" type="button">{{__('common.Edit')}}</a>


                                                    </div>
                                                </div>

                                            </td>
                                        </tr>

                                        <div class="modal fade admin-query" id="editSetting{{@$work->id}}">
                                            <div class="modal-dialog modal_1000px modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">{{__('common.Edit')}}  </h4>
                                                        <button type="button" class="close " data-bs-dismiss="modal">
                                                            <i class="ti-close "></i>
                                                        </button>
                                                    </div>
                                                    {{-- <input type="hidden" id="url" value="{{url('/')}}"> --}}
                                                    <div class="modal-body  student-details header-menu">
                                                        <form action="{{route('frontend.workProcessUpdate')}}"
                                                              method="POST"
                                                              enctype="multipart/form-data">

                                                            @csrf
                                                            <input name="id"
                                                                   value="{{@$work->id}}"

                                                                   type="hidden">
                                                            <div class="row pt-0">
                                                                @if(isModuleActive('FrontendMultiLang'))
                                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                        role="tablist">
                                                                        @foreach ($LanguageList as $key => $language)
                                                                            <li class="nav-item">
                                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                   href="#element{{@$work->id}}{{$language->code}}"
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
                                                                         id="element{{@$work->id}}{{$language->code}}">

                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="primary_input mb-25">
                                                                                    <label class="primary_input_label"
                                                                                           for=""> {{__('common.Title')}}
                                                                                        *</label>
                                                                                    <input class="primary_input_field"
                                                                                           name="title[{{$language->code}}]"
                                                                                           value="{{@$work->getTranslation('title',$language->code)}}"
                                                                                           placeholder="-"
                                                                                           type="text">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-xl-12">
                                                                                <div class="primary_input mb-25">
                                                                                    <label class="primary_input_label"
                                                                                           for=""> {{__('common.Description')}}
                                                                                        * </label>
                                                                                    <input class="primary_input_field"
                                                                                           name="description[{{$language->code}}]"
                                                                                           value="{{@$work->getTranslation('description',$language->code)}}"
                                                                                           placeholder="-"
                                                                                           type="text">
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            <div class="col-lg-12 text-center pt_15">
                                                                <div class="d-flex justify-content-center">
                                                                    <button class="primary-btn semi_large2  fix-gr-bg"
                                                                            id="save_button_parent" type="submit"><i
                                                                            class="ti-check"></i> {{__('common.Update')}}
                                                                    </button>
                                                                </div>
                                                            </div>


                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade admin-query" id="add_topic">
                    <div class="modal-dialog modal_1000px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{__('common.Add New')}} {{__('quiz.Topic')}}</h4>
                                <button type="button" class="close " data-bs-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>
                            <input type="hidden" id="url" value="{{url('/')}}">
                            <div class="modal-body  student-details header-menu">
                                <form action="{{route('frontend.workProcessStore')}}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row pt-0">
                                        @if(isModuleActive('FrontendMultiLang'))
                                            <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                role="tablist">
                                                @foreach ($LanguageList as $key => $language)
                                                    <li class="nav-item">
                                                        <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                           href="#element{{$language->code}}"
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
                                                 id="element{{$language->code}}">

                                                <div class="row">

                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{__('quiz.Topic')}} {{__('common.Title')}}
                                                                *</label>
                                                            <input class="primary_input_field"
                                                                   name="title[{{$language->code}}]"
                                                                   placeholder="-"
                                                                   type="text"
                                                                   value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <label class="primary_input_label"
                                                               for="">{{__('quiz.Topic')}} {{__('common.Description')}}
                                                            *</label>
                                                        <input class="primary_input_field"
                                                               name="description[{{$language->code}}]"
                                                               value=""
                                                               placeholder="-"
                                                               type="text">
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-lg-12 text-center pt_15">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"
                                                    type="submit"><i
                                                    class="ti-check"></i> {{__('common.Add') }}
                                            </button>
                                        </div>
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

