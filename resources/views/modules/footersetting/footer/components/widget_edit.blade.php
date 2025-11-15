<div class="modal fade admin-query" id="editModal" x-data="{custom:false}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('footer.Edit Link')}}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="ti-close "></i></button>
            </div>
            <form method="POST" action="{{route('footerSetting.footer.widget-update')}}">
                @csrf
                @method('POST')
                <input type="hidden" name="id" id="widgetEditId">
                <div class="modal-body">
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
                                    <div class="col-md-12 mt-30">
                                        <div class="input-effect">
                                            <label class="primary_input_label mt-1">{{__('footer.Page Name')}} <span class="required_mark">*</span>
                                            </label>
                                            <input class="primary_input_field name form-control" type="text"
                                                   name="name[{{$language->code}}]"
                                                   id="widget_name_edit_{{$language->code}}"
                                                   autocomplete="off" value="">


                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">


                        <div id="editCategoryFieldDiv" class="col-lg-12 mt-30">
                            <div class="input-effect">
                                <select class="primary_select" name="category"
                                        id="editCategory">
                                    <option data-display="{{__('footer.Widget Title')}}- *" value="">
                                        --{{__('footer.Widget Title')}}--
                                    </option>
                                    <option value="1">{{ Settings('footer_section_one_title') }}</option>
                                    <option value="2">{{ Settings('footer_section_two_title') }}</option>
                                    <option value="3">{{ Settings('footer_section_three_title') }}</option>
                                    @if(Settings('frontend_active_theme')=='tvt')
                                        <option value="4">{{ Settings('footer_section_four_title') }}</option>
                                    @endif
                                </select>
                                <span class="focus-border"></span>
                            </div>
                            @error('category')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{--  <div class="col-md-12">
                              <textarea name="description" class="lms_summernote" id="widget_description"></textarea>
                          </div>
                          --}}


                        <div class="col-lg-12 mt-30">
                            <div class="primary_input ">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="primary_input_label"
                                               for="    "> {{__('setting.Custom Link')}}</label>
                                    </div>

                                    <div class="col-md-6 ps-0">
                                        <div class="row">
                                            <div class="col-4 ">
                                                <label class="primary_checkbox d-flex mr-12"
                                                       for="edit_yes">
                                                    <input type="radio"
                                                           class="common-radio editCustom"
                                                           id="edit_yes"
                                                           x-on:change="custom = true"
                                                           name="custom"

                                                           value="1">
                                                    <span
                                                        class="checkmark me-2"></span> {{__('common.Yes')}}
                                                </label>
                                            </div>
                                            <div class="col-4">
                                                <label class="primary_checkbox d-flex mr-12"
                                                       for="edit_no">
                                                    <input type="radio"
                                                           class="common-radio editCustom "
                                                           id="edit_no"
                                                           name="custom"
                                                           x-on:change="custom = false"
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

                        <div class="col-lg-12 mt-30 " id="editPageFieldDiv" x-show="!custom">
                            <div class="input-effect">
                                <label class="primary_input_label mt-1">{{__('footer.Select Page')}} <span class="required_mark">*</span>
                                </label>
                                <select class="primary_select "
                                        name="page" id="editPage">
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

                        <div id="editCustomFieldDiv" class="col-lg-12 mt-30" x-show="custom">
                            <div class="input-effect">
                                <label class="primary_input_label mt-1">{{__('footer.Custom Link')}} <span class="required_mark">*</span>
                                </label>
                                <input class="primary_input_field name form-control" type="url"
                                       name="custom_link"
                                       id="custom_link"
                                       placeholder="https://google.com"
                                       autocomplete="off" value="">

                                <span class="focus-border"></span>
                            </div>
                            @error('page')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mt-40 w-100 d-flex justify-content-center">
                            <button type="button" class="primary-btn tr-bg  me-3"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                            <div class="tooltip-wrapper" data-title="" data-original-title="" title="">
                                <button type="submit" class="primary-btn fix-gr-bg tooltip-wrapper "
                                        data-original-title="" title="">
                                    <i class="ti-check"></i>
                                    {{__('common.Update')}} </button>
                            </div>

                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>
