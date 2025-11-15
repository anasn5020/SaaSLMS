@php
    $LanguageList = getLanguageList();
@endphp
<div class="modal fade admin-query" id="CreateModal" x-data="{custom:false}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('footer.Add Link')}}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="ti-close "></i></button>
            </div>
            <form method="POST" action="{{ route('footerSetting.footer.widget-store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row pt-0">
                        @if(isModuleActive('FrontendMultiLang'))
                            <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                role="tablist">
                                @foreach ($LanguageList as $key => $language)
                                    <li class="nav-item">
                                        <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                           href="#element_add{{$language->code}}"
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
                                 id="element_add{{$language->code}}">
                                <div class="row">
                                    <div class="col-md-12 mt-30">
                                        <div class="input-effect">
                                            <label class="primary_input_label mt-1">{{__('footer.Page Name')}} <span class="required_mark">*</span>
                                            </label>
                                            <input class="primary_input_field name form-control" type="text"
                                                   name="name[{{$language->code}}]"
                                                   autocomplete="off" value="">

                                            <span class="focus-border"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">


                        <div class=" ">
                            <div class="input-effect">
                                <input type="hidden" name="category" id="category">
                                {{--                                <select class="niceSelect w-100 bb category form-control">--}}
                                {{--                                    <option data-display="{{__('footer.Widget Title')}}*" value="">--{{__('footer.Widget Title')}}--</option>--}}
                                {{--                                    <option value="1">{{ $FooterContent->footer_section_one_title }}</option>--}}
                                {{--                                    <option value="2">{{ $FooterContent->footer_section_two_title }}</option>--}}
                                {{--                                    <option value="3">{{ $FooterContent->footer_section_three_title }}</option>--}}
                                {{--                                </select>--}}
                                <span class="focus-border"></span>
                            </div>
                            @error('category')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-lg-12 mt-30">
                            <div class="primary_input ">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="primary_input_label"
                                               for="    "> {{__('setting.Custom Link')}}</label>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-4 ">
                                                <label class="primary_checkbox d-flex mr-12"
                                                       for="yes">
                                                    <input type="radio"
                                                           class="common-radio "
                                                           id="yes"
                                                           x-on:click="custom = true"
                                                           name="custom"

                                                           value="1">
                                                    <span
                                                        class="checkmark me-2"></span> {{__('common.Yes')}}
                                                </label>
                                            </div>
                                            <div class="col-4">
                                                <label class="primary_checkbox d-flex mr-12"
                                                       for="no">
                                                    <input type="radio"
                                                           class="common-radio "
                                                           id="no"
                                                           name="custom"
                                                           x-on:click="custom = false"
                                                           checked
                                                           value="0">
                                                    <span
                                                        class="checkmark me-2"></span> {{__('common.No')}}
                                                </label>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-lg-12 mt-30 " x-show="!custom">
                            <div class="input-effect">
                                <label class="primary_input_label mt-1">{{__('footer.Select Page')}}
                                </label>
                                <select class="primary_select "
                                        name="page" id="page">
                                    <option data-display="{{__('footer.Select Page')}} " value="">
                                        --{{__('footer.Select Page')}}--
                                    </option>

                                    @foreach ($staticPageList as $page)
                                        <option
                                            value="{{ $page->slug }}">{{ $page->title }}</option>
                                    @endforeach
                                </select>
                                <span class="focus-border"></span>
                            </div>
                            @error('page')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-12 mt-30 " x-show="custom">
                            <div class="input-effect">
                                <label class="primary_input_label mt-1">{{__('footer.Custom Link')}}
                                </label>
                                <input class="primary_input_field name form-control" type="url"
                                       name="custom_link"
                                       placeholder="https://google.com"
                                       autocomplete="off" value="">

                                <span class="focus-border"></span>
                            </div>
                            @error('page')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mt-40 d-flex gap-3 w-100 justify-content-center">
                            <button type="button" class="primary-btn tr-bg  "
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                            <div class="tooltip-wrapper" data-title="" data-original-title="" title="">
                                <button type="submit" class="primary-btn fix-gr-bg tooltip-wrapper "
                                        data-original-title="" title="">
                                    <i class="ti-check"></i>
                                    {{__('common.Save')}} </button>
                            </div>

                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>
