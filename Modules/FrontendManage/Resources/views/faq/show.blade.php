<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">{{__('frontend.Update FAQ')}}</h4>
        <button type="button" class="close " data-bs-dismiss="modal">
            <i class="ti-close "></i>
        </button>
    </div>

    <div class="modal-body student-details header-menu">
        <form action="{{route('frontend.faq.update')}}" method="POST"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{old('id',$faq->id)}}" id="faqId">

            <div class="row pt-0">
                @if(isModuleActive('FrontendMultiLang'))
                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                        role="tablist">
                        @foreach ($LanguageList as $key => $language)
                            <li class="nav-item">
                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                   href="#element{{'_edit_'.$language->code}}"
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
                         id="element{{'_edit_'.$language->code}}">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{__('frontend.Question')}} <strong
                                            class="text-danger">*</strong></label>
                                    <input class="primary_input_field "
                                           name="question[{{$language->code}}]" placeholder="-"
                                           type="text" id="editQuestion{{$language->code}}"
                                           value="{{ old('question.'.$language->code,$faq->getTranslation('question',$language->code)) }}" {{$errors->first('question') ? 'autofocus' : ''}}>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="primary_input mb-35">
                                    <label class="primary_input_label"
                                           for="">{{__('frontend.Answer')}} <strong
                                            class="text-danger">*</strong></label>
                                    <textarea class="lms_summernote"
                                              name="answer[{{$language->code}}]"
                                              id="editAnswer{{$language->code}}" cols="30"

                                              rows="10">{{ old('answer.'.$language->code,$faq->getTranslation('answer',$language->code)) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label"
                               for="">{{__('frontend.Order')}} </label>
                        <input class="primary_input_field" name="order" placeholder="-"

                               type="text" id="editOrder"
                               value="{{ old('order',$faq->order) }}" {{$errors->first('order') ? 'autofocus' : ''}}>
                    </div>
                </div>


            </div>
            <div class="col-lg-12 text-center pt_15">
                <div class="d-flex justify-content-center">
                    <button class="primary-btn semi_large2  fix-gr-bg"
                            id="save_button_parent" type="submit"><i
                            class="ti-check"></i> {{__('frontend.Update FAQ')}}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
