<div id="show_item_modal">
    <div class="modal fade" id="item_show">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ __('common.File Detail Info') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body item_edit_form">
                    <h5>{{__('common.Name')}}: <p class="d-inline" id="show_name"></p></h5>
                    <h5>{{__('common.Slug')}}: <p class="d-inline" id="show_path"></p></h5>
                    <h5>{{__('common.Extension')}}: <p class="d-inline" id="show_extension"></p></h5>
                    <h5>{{__('common.Size')}}: <p class="d-inline" id="show_size"></p></h5>
                    <h5>{{__('common.Storage Type')}}: <p class="d-inline" id="show_storage"></p></h5>

                    <div class="row" id="single_image_div">
                        <div class="col-12">
                            <div class="show_img_div">
                                <img id="view_image"/>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
