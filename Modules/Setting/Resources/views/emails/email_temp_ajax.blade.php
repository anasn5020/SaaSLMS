@php
    $LanguageList = getLanguageList();
@endphp


@if($type=='email')
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('common.Update')}} {{__('setting.Email Template')}}</h4>
                <button type="button" class="close " data-bs-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-xl-12 ">
                        @php
                            $codes= json_decode($template->shortcodes,true);
                        @endphp


                        <div class="row">
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for=""><strong>{{__('communication.Field Name')}}</strong></label>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for=""><strong>{{__('communication.Short Code')}}</strong></label>
                                </div>
                            </div>
                            <hr>
                            @if(is_array($codes))

                                @foreach ($codes as $key=> $code)

                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="">{{$code}}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   style="text-transform: lowercase;"
                                                   for="">{{"{{".$key}}}}</label>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <hr>

                    </div>
                    <form class="student-details" action="{{route('updateEmailTemp')}}" method="post">
                        @csrf
                        <input type="hidden" name="id"
                               value="{{@$template->id}}">

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
                        <div class="tab-content">
                            @foreach ($LanguageList as $key => $language)
                                <div role="tabpanel"
                                     class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                     id="element{{$language->code}}">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('setting.Subject')}}</label>
                                                <input class="primary_input_field"
                                                       value="{{ $template->getTranslation('subj', $language->code) }}"
                                                       name="subj[{{$language->code}}]"
                                                       placeholder="-" type="text">
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="">{{__('setting.Email Body')}} </label>
                                                <textarea class="lms_summernote"
                                                          name="email_body[{{$language->code}}]" id="" cols="30"
                                                          rows="20">{{ $template->getTranslation('email_body', $language->code) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-lg-12 text-center pt_15">
                            <div class="d-flex justify-content-center">
                                <button
                                    class="primary-btn semi_large  fix-gr-bg"
                                    type="submit"><i
                                        class="ti-check"></i> {{__('common.Update')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@elseif($type == 'sms')

    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('common.Update')}} {{__('setting.Sms Message')}}</h4>
                <button type="button" class="close " data-bs-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-xl-12">
                        @php
                            $codes= json_decode($template->shortcodes,true);
                        @endphp


                        <div class="row">
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for=""><strong>{{__('communication.Field Name')}}</strong></label>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for=""><strong>{{__('communication.Short Code')}}</strong></label>
                                </div>
                            </div>
                            <hr>
                            @if(is_array($codes))

                                @foreach ($codes as $key=> $code)

                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="">{{$code}}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   style="text-transform: lowercase;"
                                                   for="">{{"{{".$key}}}}</label>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <hr>

                    </div>
                    <div class="col-lg-12">
                        <form class="student-details" action="{{route('updateSmsMessage')}}" method="post">
                            @csrf
                            <input type="hidden" name="id"
                                   value="{{@$template->id}}">
                            <div class="row">


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
                                <div class="tab-content">
                                    @foreach ($LanguageList as $key => $language)
                                        <div role="tabpanel"
                                             class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                             id="element{{$language->code}}">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-35">
                                                    <label class="primary_input_label"
                                                           for="">{{__('setting.Sms Message')}} </label>
                                                    <textarea id="my-textarea"
                                                              class="primary_input_field lms_summernote"

                                                              name="sms_message[{{$language->code}}]" cols="30"
                                                              rows="20">{{ $template->getTranslation('sms_message', $language->code) }}</textarea>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-lg-12 text-center pt_15">
                                    <div class="d-flex justify-content-center">
                                        <button
                                            class="primary-btn semi_large  fix-gr-bg"
                                            type="submit"><i
                                                class="ti-check"></i> {{__('common.Update')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@else

    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('common.Update')}} {{__('setting.Browser Message')}}</h4>
                <button type="button" class="close " data-bs-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-xl-12">
                        @php
                            $codes= json_decode($template->shortcodes,true);
                        @endphp


                        <div class="row">
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for=""><strong>{{__('communication.Field Name')}}</strong></label>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for=""><strong>{{__('communication.Short Code')}}</strong></label>
                                </div>
                            </div>
                            <hr>
                            @if(is_array($codes))

                                @foreach ($codes as $key=> $code)

                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="">{{$code}}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   style="text-transform: lowercase;"
                                                   for="">{{"{{".$key}}}}</label>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <hr>

                    </div>
                    <form class="student-details" action="{{route('updateBrowserMessage')}}" method="post">
                        @csrf
                        <input type="hidden" name="id"
                               value="{{@$template->id}}">


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
                        <div class="tab-content">
                            @foreach ($LanguageList as $key => $language)
                                <div role="tabpanel"
                                     class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                     id="element{{$language->code}}">

                                    <div class="col-xl-12">
                                        <div class="primary_input mb-35">
                                            <label class="primary_input_label"
                                                   for="">{{__('setting.Browser Message')}} </label>
                                            <textarea class="lms_summernote"
                                                      name="browser_message[{{ $language->code }}]"
                                                      id="" cols="30"
                                                      rows="20">{{ $template->getTranslation('browser_message', $language->code) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-lg-12 text-center pt_15">
                            <div class="d-flex justify-content-center">
                                <button
                                    class="primary-btn semi_large  fix-gr-bg"
                                    type="submit"><i
                                        class="ti-check"></i> {{__('common.Update')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endif
<script>
    $('.lms_summernote').summernote({
        tabsize: 2,
        height: 250,
        tooltip: false,
        callbacks: {
            onImageUpload: function (files) {
                sendFile(files, '.lms_summernote', $(this).attr('name'))
            }
        }
    });
    $('.note-toolbar').find('[data-toggle]').each(function () {
        $(this).attr('data-bs-toggle', $(this).attr('data-toggle')).removeAttr('data-toggle');
    });
</script>
