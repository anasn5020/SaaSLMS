@extends('backend.master')

@section('mainContent')
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            @if(isset($editData))
                <div class="row">
                    <div class="offset-lg-10 col-lg-2 text-end col-md-12 mb-20"><a target="_blank"
                                                                                   href="{{route('frontPage',$editData->slug)}}"
                                                                                   class="primary-btn small fix-gr-bg"> <span
                                class="ti-eye pe-2"></span> {{__('student.Preview')}} </a></div>
                </div>
            @endif


            <div class="row">
                <div class="col-lg-12">

                    <div class="white-box  student-details header-menu">
                        @if(isset($editData))
                            <form class="form-horizontal" method="POST" action="{{ route('frontend.page.update', $editData->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @else
                                    <form class="form-horizontal" method="POST" action="{{ route('frontend.page.store') }}" enctype="multipart/form-data" id="search_studentA">
                                        @csrf
                                        @endif

                                        <div class="row">
                                            <div class="col-lg-12">
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
                                                                <div class="col-lg-12  ">
                                                                    <div class="primary_input mb-25">
                                                                        <label
                                                                            class="'primary_input_label mb-2">{{__('frontendmanage.Title')}}
                                                                            <span class="required_mark">*</span> </label>
                                                                        <input
                                                                            class="primary_input_field form-control{{ $errors->has('title') ? ' is-invalid' : '' }}  @if (auth()->user()->language_code == $language->code) addTitleActive @endif"
                                                                            type="text" name="title[{{$language->code}}]"
                                                                            autocomplete="off"
                                                                            value="{{isset($editData)? $editData->getTranslation('title',$language->code) : '' }}">

                                                                        <span class="focus-border"></span>
                                                                        @if ($errors->has('title'))
                                                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('title') }}</strong>
                                                        </span>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-12 ">
                                                                    <div class="primary_input mb-25">
                                                                        <label
                                                                            class="'primary_input_label mb-2">{{__('frontendmanage.Sub Title')}} </label>
                                                                        <input
                                                                            class="primary_input_field form-control{{ $errors->has('sub_title') ? ' is-invalid' : '' }}"
                                                                            type="text" name="sub_title[{{$language->code}}]"
                                                                            autocomplete="off"
                                                                            value="{{isset($editData)? $editData->getTranslation('sub_title',$language->code) : '' }}">

                                                                        <span class="focus-border"></span>
                                                                        @if ($errors->has('sub_title'))
                                                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('sub_title') }}</strong>
                                                        </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                @if(!hasDynamicPage())
                                                                    <div class="col-lg-12 ">
                                                                        <div class="primary_input mb-25">
                                                                            <label
                                                                                class="'primary_input_label mb-2">{{__('frontendmanage.Details')}}
                                                                                <span class="required_mark">*</span> </label>
                                                                            <textarea
                                                                                class="form-control lms_summernote {{ $errors->has('details') ? ' is-invalid' : '' }}"
                                                                                rows="5" name="details[{{$language->code}}]" cols="50"
                                                                                style="display: none;">{{isset($editData)? $editData->getTranslation('details',$language->code) : '' }}</textarea>

                                                                            <span class="focus-border"></span>
                                                                            @if ($errors->has('details'))
                                                                                <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('details') }}</strong>
                                                        </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="row">
                                                    @if(!isset($editData) ||  (isset($editData) && $editData->is_static!=1))

                                                        <div class="col-lg-12 ">
                                                            <div class="primary_input mb-25">
                                                                <label
                                                                    class="'primary_input_label mb-2">{{__('frontendmanage.Slug')}} </label>
                                                                <input
                                                                    class="primary_input_field form-control{{ $errors->has('slug') ? ' is-invalid' : '' }} addSlug"
                                                                    type="text" name="slug" autocomplete="off"
                                                                    value="{{isset($editData)? $editData->slug : '' }}">

                                                                <span class="focus-border"></span>
                                                                @if ($errors->has('sub_title'))
                                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('slug') }}</strong>
                                                        </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if(!hasDynamicPage())
                                                        <div class="col-xl-8  ">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">
                                                                </label>
                                                                <div class="primary_file_uploader">
                                                                    <input
                                                                        class="primary_input_field  filePlaceholder {{ @$errors->has('banner') ? ' is-invalid' : '' }}"
                                                                        type="text" id=""
                                                                        placeholder="{{__('setting.Browse file')}}"
                                                                        readonly="" {{ $errors->has('instructor_banner') ? ' autofocus' : '' }}>
                                                                    <button class="" type="button">
                                                                        <label class="primary-btn small fix-gr-bg"
                                                                               for="file1">{{ __('frontendmanage.Banner') }}</label>
                                                                        <input type="file" class="d-none fileUpload imgInput1"
                                                                               name="banner" id="file1">
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4  ">
                                                            <div class="primary_input mb-25">
                                                                <img height="70" class=" imagePreview1" style="max-width: 100%"
                                                                     src="@if(isset($editData)){{ asset('/'.$editData->banner)}}@endif"
                                                                     alt="">
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            @if(isset($editData))
                                                <div class="col-lg-12 mt-40 text-center tooltip-wrapper">
                                                    <button class="primary-btn fix-gr-bg tooltip-wrapper ">
                                                        <i class="ti-check"></i>
                                                        {{__('common.Update')}}
                                                    </button>
                                                </div>

                                            @else

                                                <div class="col-lg-12 mt-40 text-center tooltip-wrapper">
                                                    <button class="primary-btn fix-gr-bg tooltip-wrapper " type="submit">
                                                        <i class="ti-check"></i>
                                                        {{__('common.Add')}}
                                                    </button>
                                                </div>

                                            @endif

                                        </div>
                                    </form>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
@push('scripts')
    <script>

        $('.popover').css("display", "none");

        function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview1").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput1").change(function () {
            readURL1(this);
        });

        $(".addTitleActive").on('input', function () {
            let title = $(".addTitleActive").val();
            $(".addSlug").val(convertToSlug(title));
        });

        function convertToSlug(Text) {
            return Text
                .toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '')
                ;
        }
    </script>
@endpush
