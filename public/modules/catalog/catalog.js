(function ($) {
    "use strict";
    let _token = $('meta[name=_token]').attr('content');
    $(document).ready(function () {
        $(document).on('click', '.delete_row', function (event) {
            event.preventDefault();
            let id = $(this).data('id');
            $('#delete_item_id').val(id);
            $('#deleteItemModal').modal('show');
        });

        $(document).on('submit', '#item_delete_form', function (event) {
            event.preventDefault();
            $('#deleteItemModal').modal('hide');
            var formData = new FormData();
            formData.append('_token', _token);
            formData.append('id', $('#delete_item_id').val());
            $.ajax({
                url: $('#delete_url').val(),
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    location.reload();
                    toastr.success(window.jsLang('data_operation_success'));
                },
                error: function (response) {
                    toastr.error(window.jsLang('data_something_went_wrong'));
                }
            });
        });

        $(document).on('change', '.status_change', function (event) {
            event.preventDefault();
            let status = 0;
            if ($(this).prop('checked')) {
                status = 1;
            } else {
                status = 0;
            }
            let id = $(this).data('id');
            let formData = new FormData();
            formData.append('_token', _token);
            formData.append('id', id);
            formData.append('is_active', status);
            $.ajax({
                url: $('#status_change_url').val(),
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    location.reload();
                    toastr.success(window.jsLang('data_operation_success'));
                },
                error: function (response) {
                    toastr.error(window.jsLang('data_something_went_wrong'));
                }
            });
        });
    });
})(jQuery);
