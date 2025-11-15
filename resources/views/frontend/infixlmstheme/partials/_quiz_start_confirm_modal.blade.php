<div class="modal cs_modal fade admin-query" id="StartConfirmModal" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('frontend.Start Quiz') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                        class="ti-close "></i></button>
            </div>


            <div class="modal-body">
                @csrf
                {{__('frontend.Are you ready for quiz?')}}
            </div>
            <div class="modal-footer justify-content-center">
                <div class="mt-40">
                    <button type="button" class="theme_line_btn me-2 small_btn2"
                            data-url="{{courseDetailsUrl($course->id,$course->type, $course->slug)}}"
                            id="QuizCancelBtn">{{ __('common.No') }}
                    </button>
                    <button class="theme_btn  small_btn2"
                            type="button" id="QuizStartBtn">{{ __('common.Yes') }}</button>
                </div>
            </div>


        </div>
    </div>
</div>
