(function ($) {
    "use strict";
    $(document).ready(function () {

        $(document).on('click', '.add_experience_btn', function (event) {

            $.ajax({
                url: $('#experience_create_route').val(),
                type: "GET",
                success: function (response) {
                    $('#append_html').html(response);
                    if ($('.date').length > 0) {
                        $('.date').datepicker({
                            autoclose: true
                        });
                    }
                    if ($('#end_date').length > 0) {
                        $('#end_date').datepicker();
                    }
                    if ($('#start_date').length > 0) {
                        $('#start_date').datepicker();
                    }
                    endDateToggle();
                    $('#experience_form_modal').modal('show');
                },
                error: function (response) {
                    toastr.error(response.responseJSON.error);
                }
            });

        });

        $(document).on('submit', '#user_experience_form', function (event) {

            event.preventDefault();
            let formElement = $(this).serializeArray()
            let formData = new FormData();
            formElement.forEach(element => {
                formData.append(element.name, element.value);
            });
            resetValidationError();
            $.ajax({
                url: $('#experience_store_route').val(),
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    create_form_reset();
                    summitBtnEnable();
                    $('#experience_form_modal').modal('hide');
                    toastr.success(response.msg, 'Success');
                    resetAfterChange(response.response);
                },
                error: function (response) {
                    summitBtnEnable();
                    showValidationErrors('#user_experience_form', response.responseJSON.errors);
                }
            });
        });

        $(document).on('click', '.edit_experience_btn', function (event) {
            event.preventDefault();
            let id = $(this).data('id');
            let url = $('#experience_edit_route').val();
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {
                    $('#append_html').html(response);
                    if ($('.date').length > 0) {
                        $('.date').datepicker({
                            autoclose: true
                        });
                    }
                    if ($('#end_date').length > 0) {
                        $('#end_date').datepicker();
                    }
                    if ($('#start_date').length > 0) {
                        $('#start_date').datepicker();
                    }
                    endDateToggle();
                    $('#experience_form_modal').modal('show');
                },
                error: function (response) {
                    toastr.error(response.responseJSON.error);
                }
            });

        });

        $(document).on('submit', '#user_experience_update_form', function (event) {

            event.preventDefault();
            let formElement = $(this).serializeArray()
            let formData = new FormData();
            formElement.forEach(element => {
                formData.append(element.name, element.value);
            });
            let id = $('#rowId').val();
            let url = $('#experience_update_route').val();
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
                    $('#experience_form_modal').modal('hide');
                    toastr.success(response.msg, 'Success');
                    resetAfterChange(response.response);
                },
                error: function (response) {
                    summitBtnEnable();
                    showValidationErrors('#user_experience_update_form', response.responseJSON.errors);
                }
            });
        });

        $(document).on('change', '#is_currently_working', function (event) {
            endDateToggle();
        });


        function resetAfterChange(TableData) {
            $('#experience_list').html(TableData);
        }

        function create_form_reset() {
            $('#user_experience_form')[0].reset();
        }

        function showValidationErrors(formType, errors) {
            $(formType + ' #error_title').text(errors.title);
            $(formType + ' #error_company_name').text(errors.company_name);
            $(formType + ' #error_start_date').text(errors.start_date);
            $(formType + ' #error_end_date').text(errors.end_date);
            $('button').find('i').removeClass('fa fa-spinner fa-spin fa-lg');
            $('button').find('i').addClass('ti-check');
        }

        function resetValidationError() {
            $('#error_title').html('');
            $('#error_company_name').html('');
            $('#error_start_date').html('');
            $('#error_end_date').html('');
        }

        function summitBtnEnable() {
            $('button[type=submit]').prop('disabled', false);
        }


        function endDateToggle() {
            if ($('#is_currently_working').is(':checked')) {
                $('.end_date_div').addClass('d-none');
            } else {
                $('.end_date_div').removeClass('d-none');
            }
        }
    });

})(jQuery);
