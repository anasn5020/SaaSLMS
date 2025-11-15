
<div class="modal fade admin-query" id="deleteClass">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('common.Delete') }} </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="ti-close "></i></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('virtual-class.destroy') }}" method="post">
                    @csrf

                    <div class="text-center">

                        <h4>{{ __('common.Are you sure to delete ?') }} </h4>
                    </div>
                    <input type="hidden" name="id" value="" id="classDeleteId">
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg"
                                data-bs-dismiss="modal">{{ __('common.Cancel') }}</button>

                        <button class="primary-btn fix-gr-bg" type="submit">{{ __('common.Delete') }}</button>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
