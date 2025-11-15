<form id="formData" action="{{route('popup-content.update')}}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="id" value="{{ $popup->id }}">
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
                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ __('common.Title') }}  </label>
                            <input name="title[{{$language->code}}]" class="primary_input_field" placeholder="-"
                                   type="text"
                                   value="{{  old('title.'.$language->code,$popup->getTranslation('title',$language->code)) }}">
                        </div>
                        <span class="text-danger" id="title_error"></span>
                    </div>

                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ __('common.Button Text') }} </label>
                            <input name="btn_txt[{{$language->code}}]" class="primary_input_field" placeholder="-"
                                   type="text"
                                   value="{{  old('btn_txt.'.$language->code, $popup->getTranslation('btn_txt',$language->code))}}">
                        </div>
                        <span class="text-danger" id="btn_txt_error"></span>
                    </div>

                    <div class="col-xl-12">
                        <div class="primary_input mb-35">
                            <label class="primary_input_label"
                                   for="">{{ __('common.Details') }} </label>
                            <textarea name="message[{{$language->code}}]" id="message"
                                      class="lms_summernote">{{ $popup->getTranslation('message',$language->code)}}</textarea>
                        </div>
                        <span class="text-danger" id="message_error"></span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-xl-6 ">
            <div class="primary_input mb-25">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="primary_input_label"
                               for="    "> {{__('frontendmanage.Show In Frontend')}}</label>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 mb-25">
                                <label class="primary_checkbox d-flex mr-12"
                                       for="yes">
                                    <input type="radio"
                                           class="common-radio "
                                           id="yes"
                                           name="status"
                                           {{$popup->status==1?'checked':''}}
                                           value="1">
                                    <span class="checkmark me-2"></span> {{__('common.Yes')}}</label>
                            </div>
                            <div class="col-md-4 mb-25">
                                <label class="primary_checkbox d-flex mr-12"
                                       for="no">
                                    <input type="radio"
                                           class="common-radio "
                                           id="no"
                                           name="status"
                                           value="0" {{$popup->status==0?'checked':''}}>
                                    <span class="checkmark me-2"></span> {{__('common.No')}}</label>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('common.Link') }} </label>
                <input name="link" class="primary_input_field" placeholder="-" type="url"
                       value="{{ old('link') ? old('link') : $popup->link }}">
            </div>
            <span class="text-danger" id="btn_txt_error"></span>
        </div>

        <div class="col-xl-6">
            <div class=" mb-25">

                <x-upload-file
                    name="image"
                    type="image"
                    media_id="{{isset($popup)?$popup->image_media?->media_id:''}}"
                    label="{{ __('common.Image') }}"
                    note="{{__('student.Recommended size')}} (327x446)"
                />


            </div>
        </div>


        @if (permissionCheck('popup-content.index'))
            <div class="col-lg-12 text-center">
                <div class="d-flex justify-content-center">
                    <button class="primary-btn semi_large2  fix-gr-bg me-1" id="save_button_parent"
                            type="submit"><i
                            class="ti-check"></i>{{ __('common.Update') }}</button>
                </div>
            </div>
        @endif
    </div>
</form>
