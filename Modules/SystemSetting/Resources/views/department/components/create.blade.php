<div id="add_item_modal">
    <div class="modal fade" id="item_add">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <span>{{ __('common.Add New') }}</span>
                        {{ __('leave.Department') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body item_create_form">
                    {{-- form --}}
                    @include('systemsetting::department.components.form',['form_id' => 'item_create_form', 'button_level_name' => __('common.Save') ])
                </div>
            </div>
        </div>
    </div>
</div>
