@php
    $LanguageList = getLanguageList();
@endphp

<div class="modal-dialog modal-dialog-centered student-details">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{__('common.Edit')}}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

            <form action="#" method="POST" id="menuEditForm">
                <input type="hidden" value="{{$menu->id}}" name="id" id="">
                <div class="row pt-0">
                    @if(isModuleActive('FrontendMultiLang') || isModuleActive('Org'))
                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                            role="tablist">
                            @foreach ($LanguageList as $key => $language)
                                <li class="nav-item">
                                    <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                       href="#element2{{$language->code}}"
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
                             id="element2{{$language->code}}">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="">{{ __('common.Label') }}

                                            <span
                                                class="textdanger">*</span></label>
                                        <input class="primary_input_field" placeholder="" type="text" id=""
                                               name="label[{{$language->code}}]"
                                               value="{{$menu->getTranslation('name',$language->code)}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if(request()->get('type')!='module')
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="">{{__('common.Icon')}}
                                </label>
                                <input class="primary_input_field" placeholder="" type="text" id="menuIcon"
                                       name="icon"
                                       value="{{$menu->icon}}">
                            </div>
                        </div>
                    </div>
                @endif

                <div class=" d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg"
                            data-bs-dismiss="modal">@lang('common.Cancel')</button>

                    <button class="primary-btn fix-gr-bg" id="menuUpdate"
                            type="button">@lang('common.Submit')</button>
                </div>
            </form>

        </div>
    </div>
    @if(request()->get('type')!='module')
        <script>
            $(document).on('mouseover', 'body', function () {
                $('#menuIcon').iconpicker({
                    animation: true,
                    hideOnSelect: true
                });
            });
        </script>
    @endif
</div>

