@extends('backend.master')

@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="mb-40 student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="row pt-0">
                    @if(isModuleActive('FrontendMultiLang'))
                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                            role="tablist">
                            @foreach (getLanguageList() as $key => $language)
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

                <div class="col-lg-12">


                    <form class="form-horizontal" action="{{route('setting.pushNotification')}}" method="POST"
                          enctype="multipart/form-data">

                        @csrf
                        <div class="white-box">
                            <div class="row pt-20">
                                <div class="main-title ps-3 pt-10">
                                    <h3 class="mb-30">{{__('setting.Push Notification')}} </h3>
                                </div>
                            </div>
                            <div class="col-md-12 p-0">


                                <div class="tab-content">
                                    @foreach (getLanguageList() as $key => $language)
                                        <div role="tabpanel"
                                             class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                             id="element{{$language->code}}">
                                            <div class="row mb-30">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{ __('common.Title') }}

                                                                    @if (auth()->user()->language_code == $language->code)
                                                                    <span class="text-danger">*</span>
                                                                    @endif
                                                                </label>
                                                                <input class="primary_input_field" placeholder="-"
                                                                       type="text"
                                                                       name="title[{{$language->code}}]"
                                                                       value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{ __('common.Details') }}
                                                                    @if (auth()->user()->language_code == $language->code)
                                                                        <span class="text-danger">*</span>
                                                                    @endif
                                                                </label>
                                                                <input class="primary_input_field" placeholder="-"
                                                                       type="text"
                                                                       name="details[{{$language->code}}]"
                                                                       value="">
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
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ml-0 ms-0 mb-25">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="">{{__('common.Institute Name')}} </label>
                                        <select class="primary_select"
                                                name="institute_id">
                                            <option
                                                data-display="{{__('common.All')}} {{__('student.Institute')}}"
                                                value="">{{__('common.All')}} {{__('student.Institute')}} </option>

                                            @foreach($institutes as $institute)
                                                <option
                                                    value="{{$institute->id}}">{{$institute->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if(isModuleActive('FrontendMultiLang'))
                                    <div class="col-md-4 ml-0 ms-0 mb-25">
                                        <label class="primary_checkbox d-flex mr-12 text-nowrap"
                                               for="language_based">
                                            <input type="checkbox"
                                                   class="common-radio "
                                                   id="language_based"
                                                   name="language_based"
                                                   value="1">
                                            <span
                                                class="checkmark me-2 mr-2"></span> {{__('setting.Based on')}} {{__('common.Language')}}
                                        </label>
                                    </div>
                                @endif
                            </div>
                            <div class="row  ">
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="primary-btn fix-gr-bg" data-toggle="tooltip"
                                    >
                                        <i class="ti-check"></i>
                                        {{__('common.Update')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')

@endpush
