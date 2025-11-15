(function ($) {
    "use strict";
    $(document).ready(function () {

        shorDescriptionCharacterCount();
        offlineMessageCharacterCount();

        $(document).on('keyup keydown', '.short_description_field', function (event) {
            shorDescriptionCharacterCount();

        });

        $(document).on('keyup keydown', '.offline_message_input', function (event) {
            offlineMessageCharacterCount();

        });

        $(document).on('change', '.offline_status_change', function (event) {

            $.ajax({
                url: $('#profile_offline_status_change_route').val(),
                type: "GET",
                success: function (response) {
                    toastr.success(response.msg);
                    if (response.status) {
                        $('#offline_message_modal').modal('show');
                    }
                },
                error: function (response) {
                    toastr.error('Something went wrong');
                }
            });

        });

        function shorDescriptionCharacterCount() {
            let maxLength = 100;
            let input = $('.short_description_field');
            let length = parseInt(input.val().length);
            if (length > maxLength) {
                input.val(input.val().substring(0, maxLength));
                length = maxLength;
            }
            $('.short_description_character_count').html(length + ' ' + window.jsLang('data_characters_count'))
        }

        function offlineMessageCharacterCount() {
            let maxLength = 500;
            let input = $('.offline_message_input');
            let length = parseInt(input.val().length);
            if (length > maxLength) {
                input.val(input.val().substring(0, maxLength));
                length = maxLength;
            }
            $('.offline_message_input_character_count').html(length + ' ' + window.jsLang('data_characters_count'))
        }

    });

})(jQuery);
