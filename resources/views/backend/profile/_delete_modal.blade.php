<div class="modal fade admin-query" id="deleteModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('common.Delete')}}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                        class="ti-close "></i></button>
            </div>

            <div class="modal-body">
                <div class="text-center">

                    <h4>{{__('common.Are you sure to delete ?')}} </h4>
                </div>
                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg"
                            data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                    <a href="#" class="primary-btn fix-gr-bg" id="delete_confirm_btn"
                       type="button">{{__('common.Delete')}}</a>

                </div>
            </div>

        </div>
    </div>
</div>
