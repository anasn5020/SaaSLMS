<div class="modal-dialog modal-dialog-centered student-details">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">
                @if($edit)
                    {{__('common.Edit')}}
                @else
                    {{__('common.Add')}}
                @endif
                {{__('quiz.Chapter')}}
            </h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

            @if($edit)
                <form class="form-horizontal" method="POST" action="{{ route('updateChapter') }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="chapter"
                           value="{{$edit->id}}">
                    @else
                        <form class="form-horizontal" method="POST" action="{{ route('saveChapter') }}"
                              enctype="multipart/form-data">
                            @csrf
                            @endif

                            <input type="hidden" id="url" value="{{url('/')}}">
                            <input type="hidden" name="course_id" value="{{@$course_id}}">
                            <input type="hidden" name="input_type" value="1">
                            <input type="hidden" name="is_lock" value="1">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="input-effect mt-2 pt-1 mb-20">
                                        <label
                                            class="primary_input_label mt-1">{{__('quiz.Chapter')}} {{__('common.Name')}}
                                            <span class="required_mark">*</span></label>
                                        <input
                                            class="primary_input_field name{{ $errors->has('chapter_name') ? ' is-invalid' : '' }}"
                                            type="text" name="chapter_name" placeholder="{{ __('common.Title') }}"
                                            autocomplete="off"
                                            value="{{$edit?$edit->name:''}}">
                                        <span class="focus-border"></span>
                                        @if ($errors->has('chapter_name'))
                                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('chapter_name') }}</strong>
                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class=" d-flex justify-content-between">
                                <button type="button" class="primary-btn tr-bg"
                                        data-bs-dismiss="modal">@lang('common.Cancel')</button>

                                <button class="primary-btn fix-gr-bg"
                                        type="submit">
                                    <i class="ti-check"></i>
                                    @lang('common.Submit')</button>
                            </div>
                        </form>

        </div>
    </div>

</div>

