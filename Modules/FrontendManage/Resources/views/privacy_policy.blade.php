@extends('backend.master')
@section('table')
    {{__('privacy_policies')}}
@endsection
@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="mb-20 student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="offset-lg-10 col-lg-2 text-end col-md-12 mb-20"><a target="_blank"
                                                                               href="{{route('privacy')}}"
                                                                               class="primary-btn small fix-gr-bg"> <span
                            class="ti-eye pe-2"></span> {{__('student.Preview')}} </a></div>
                <div class="col-lg-12">


                    @if (permissionCheck('null'))
                        <form class="form-horizontal" action="{{route('frontend.privacy_policy_Update')}}" method="POST"
                              enctype="multipart/form-data">
                            @endif
                            @csrf
                            <div class="white-box  student-details header-menu">

                                <div class="col-md-12 ">
                                    <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                    <input type="hidden" name="id" value="{{@$privacy_policy->id}}">
                                    <div class="row mb-30">
                                        <div class="col-md-12 p-0">
                                            @php
                                                $LanguageList = getLanguageList();
                                            @endphp
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
                                                                <div class="row">
                                                                    @if(currentTheme()!='tvt')
                                                                        <div class="col-xl-6">
                                                                            <div class="primary_input mb-25">
                                                                                <label class="primary_input_label"
                                                                                       for="">{{ __('frontendmanage.Page Title') }}
                                                                                </label>
                                                                                <input class="primary_input_field"
                                                                                       placeholder="{{ __('frontendmanage.Page Title') }}"
                                                                                       type="text"
                                                                                       name="page_banner_title[{{$language->code}}]"
                                                                                       {{ $errors->has('course_page_title') ? ' autofocus' : '' }}
                                                                                       value="{{isset($privacy_policy)? $privacy_policy->getTranslation('page_banner_title',$language->code) : ''}}">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-xl-6">
                                                                            <div class="primary_input mb-25">
                                                                                <label class="primary_input_label"
                                                                                       for="">{{ __('frontendmanage.Page Sub Title') }}</label>
                                                                                <input class="primary_input_field"
                                                                                       placeholder="{{ __('frontendmanage.Page Sub Title') }}"
                                                                                       type="text"
                                                                                       name="page_banner_sub_title[{{$language->code}}]"
                                                                                       {{ $errors->has('page_sub_title') ? ' autofocus' : '' }}
                                                                                       value="{{isset($privacy_policy)? $privacy_policy->getTranslation('page_banner_sub_title',$language->code) : ''}}">
                                                                            </div>
                                                                        </div>
                                                                    @endif

                                                                    <div class="col-xl-12">
                                                                        <div class="primary_input mb-25">
                                                                            <label class="primary_input_label"
                                                                                   for="">{{__('frontendmanage.Privacy Policy')}}</label>
                                                                            <textarea
                                                                                name="details[{{$language->code}}]"
                                                                                {{ $errors->has('details') ? ' autofocus' : '' }} class="lms_summernote"
                                                                                cols="30" rows="10"
                                                                                placeholder="{{__('frontendmanage.Privacy Policy')}}"
                                                                                class="textArea {{ @$errors->has('details') ? ' is-invalid' : '' }}">{{isset($privacy_policy)?$privacy_policy->getTranslation('details',$language->code):''}}</textarea>
                                                                            @if ($errors->has('details'))
                                                                                <span
                                                                                    class="invalid-feedback d-block mb-10"
                                                                                    role="alert">
                                                                <strong>{{ @$errors->first('details') }}</strong>
                                                            </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="row">


                                                    <div class="col-xl-2">
                                                        <div class="primary_input mb-25">
                                                            <img height="70" class="w-100 imagePreview1"
                                                                 src="{{ asset('/'.$privacy_policy->page_banner)}}"
                                                                 alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('frontendmanage.Page Banner') }}
                                                                <small>({{__('common.Recommended Size')}}
                                                                    1920x500)</small>
                                                            </label>
                                                            <div class="primary_file_uploader">
                                                                <input
                                                                    class="primary-input  filePlaceholder {{ @$errors->has('page_banner') ? ' is-invalid' : '' }}"
                                                                    type="text" id=""
                                                                    placeholder="{{__('setting.Browse file')}}"
                                                                    readonly="" {{ $errors->has('page_banner') ? ' autofocus' : '' }}>
                                                                <button class="" type="button">
                                                                    <label
                                                                        class="primary-btn small fix-gr-bg"
                                                                        for="file1">{{ __('common.Browse') }}</label>
                                                                    <input type="file"
                                                                           class="d-none fileUpload imgInput1"
                                                                           name="page_banner"
                                                                           id="file1">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if(currentTheme()!='wetech' && currentTheme()!='infixlmstheme')
                                                        <div class="col-xl-6">
                                                            <div class="row">
                                                                <div class="col-md-12 pb-2">
                                                                    <label
                                                                        for="">{{__('frontendmanage.Page Banner Show')}}</label>
                                                                </div>


                                                                <div class="col-md-1 mb-25">

                                                                    <label
                                                                        class="primary_checkbox d-flex mr-12">
                                                                        <input type="radio"
                                                                               class="common-radio "

                                                                               name="page_banner_status"
                                                                               value="0" {{@$privacy_policy->page_banner_status==0?"checked":""}}>
                                                                        <span
                                                                            class="checkmark me-2"></span> {{__('common.No')}}
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-1 mb-25">
                                                                    <label
                                                                        class="primary_checkbox d-flex mr-12">
                                                                        <input type="radio"
                                                                               class="common-radio"
                                                                               name="page_banner_status"

                                                                               value="1" {{@$privacy_policy->page_banner_status==1?"checked":""}}>

                                                                        <span
                                                                            class="checkmark me-2"></span> {{__('common.Yes')}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                @php
                                    if(permissionCheck('null')){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to Update";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                        <button class="primary-btn fix-gr-bg" data-bs-toggle="tooltip"
                                                title="{{$tooltip}}">
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
    <script>
        function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview1").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".imgInput1").change(function () {

            readURL1(this);
        });
    </script>
@endpush
