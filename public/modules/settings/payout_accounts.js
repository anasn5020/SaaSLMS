(function ($) {
    "use strict";
    let _token = $('meta[name=_token]').attr('content');
    $(document).ready(function () {

        $(document).on('change', '#logo', function (event) {
            event.preventDefault();
            showFileName($(this).val(), '#placeholderLogoName');
            imageChangeWithFile($(this)[0], '#logo_show');
        });


        $(document).on('click', '#add_new_btn', function (event) {
            event.preventDefault();
            let url = $('#payout_account_create_route').val();
            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {
                    $('#append_html').html(response);
                    $('#payout_account_modal').modal('show');
                },
                error: function (response) {
                    toastr.error(response.responseJSON.error);
                }
            });

        });

        $(document).on('submit', '#create_payout_form', function (event) {

            event.preventDefault();
            let formElement = $(this).serializeArray()
            let formData = new FormData();
            formElement.forEach(element => {
                formData.append(element.name, element.value);
            });
            // let logo = $('#logo')[0].files[0];

            formData.append('_token', _token);
            resetValidationError();
            $.ajax({
                url: $('#payout_account_store_route').val(),
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    create_form_reset();
                    summitBtnEnable();
                    $('#payout_account_modal').modal('hide');
                    toastr.success(response.msg, 'Success');
                    resetAfterChange(response.response);
                },
                error: function (response) {
                    summitBtnEnable();
                    $("#create_payout_form button.primary-btn i").removeClass().addClass('ti-check');
                    toastr.error(response.responseJSON.message);

                }
            });
        });

        $(document).on('click', '.edit_payout_item', function (event) {
            event.preventDefault();
            let id = $(this).data('id');
            let url = $('#payout_account_edit_route').val();
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {
                    $('#append_html').html(response);
                    Amaz.uploader.previewGenerate();
                    $('#payout_account_modal').modal('show');
                },
                error: function (response) {
                    toastr.error(response.responseJSON.error);
                }
            });

        });

        $(document).on('click', '.show_payout_item', function (event) {
            event.preventDefault();
            let id = $(this).data('id');
            let url = $('#payout_account_show_route').val();
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {
                    $('#append_html').html(response);
                    $('#payout_account_modal').modal('show');
                },
                error: function (response) {
                    toastr.error(response.responseJSON.error);
                }
            });

        });

        $(document).on('click', '.user_payout_account', function (event) {
            event.preventDefault();
            let id = $(this).data('id');
            let url = $('#payout_account_show_route').val();
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {
                    $('#append_html').html(response);
                    $('#payout_account_modal').modal('show');
                },
                error: function (response) {
                    toastr.error(response.responseJSON.error);
                }
            });

        });


        $(document).on('submit', '#update_payout_form', function (event) {

            event.preventDefault();
            let formElement = $(this).serializeArray()
            let formData = new FormData();
            formElement.forEach(element => {
                formData.append(element.name, element.value);
            });


            formData.append('_token', _token);
            let id = $('#rowId').val();
            let url = $('#payout_account_update_route').val();
            url = url.replace(':id', id);
            resetValidationError();
            $.ajax({
                url: url,
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    summitBtnEnable();
                    $('#payout_account_modal').modal('hide');
                    toastr.success(response.msg, 'Success');
                    resetAfterChange(response.response);
                },
                error: function (response) {
                    summitBtnEnable();
                    showValidationErrors('#update_payout_form', response.responseJSON.errors);
                }
            });
        });


        function resetAfterChange(TableData) {
            $('#table_list').html(TableData);
            dataTableOptions = updateColumnExportOption(dataTableOptions, [0,   2, 3]);

            $('.Crm_table_active3').DataTable(dataTableOptions);
            $('.dataTables_length label select').niceSelect();
            $('.dataTables_length label .nice-select').addClass('dataTable_select');
        }

        function create_form_reset() {
            $('#create_payout_form')[0].reset();
            $('#logo').val('');
        }

        function showValidationErrors(formType, errors) {
            $(formType + ' #error_title').text(errors.title);
            $(formType + ' #error_logo').text(errors.logo);
            $(formType + ' .error_specification').text(errors.specification);
        }

        function resetValidationError() {
            $('#error_title').html('');
            $('#error_logo').html('');
            $('.error_specification').html('');
        }

        function summitBtnEnable() {
            $('button[type=submit]').prop('disabled', false);
        }

        //onchange image show function
        function imageChangeWithFile(input, srcId) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(srcId)
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function showFileName(value, placeholder) {
            if (value) {
                var startIndex = (value.indexOf('\\') >= 0 ? value.lastIndexOf('\\') : value.lastIndexOf('/'));
                var filename = value.substring(startIndex);
                if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                    filename = filename.substring(1);
                }
                $(placeholder).attr('placeholder', '');
                $(placeholder).attr('placeholder', filename);

            }
        }


    });

})(jQuery);
