<div class="modal cs_modal fade admin-query" id="submitConfirmModal" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('frontend.Submit Quiz') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                        class="ti-close quizSubmitClose"></i></button>
            </div>


            <div class="modal-body">
                @csrf
                {{__('frontend.Are you sure?')}}
            </div>
            <div class="modal-footer justify-content-center">
                <div class="mt-40">
                    <button type="button" class="theme_line_btn me-2 small_btn2 quizSubmitClose"
                            data-bs-dismiss="modal">{{ __('common.Cancel') }}
                    </button>
                    <button class="theme_btn  small_btn2"
                            type="button" id="QuizSubmitBtn">{{ __('common.Submit') }}</button>
                </div>
            </div>


        </div>
    </div>
</div>
