(function($) {
    "use strict";
    $(document).ready(function(){

        $(document).on('click','.add_skills_btn',function (event){
            $.ajax({
                url: $('#skill_create_route').val(),
                type: "GET",
                success: function(response) {
                    $('#append_html').html(response);
                    $('#skills').tagsinput({
                        maxTags: 10
                    });
                    $('#skill_form_modal').modal('show');
                },
                error: function(response) {
                    toastr.error(response.responseJSON.error);
                }
            });

        });

        $(document).on('change','.hide_show_tab',function (event){
            event.preventDefault();
            let filed = $(this).data('filed');
            let value = $(this).val();
            $.ajax({
                url: $('#profile_data_toggle_route').val(),
                type: "POST",
                data: {
                    "field":filed,
                    "value":value
                },
                success: function(response) {
                    toastr.success(response.msg, 'Success');
                    location.reload();

                },
                error: function(response) {
                    toastr.error(response.responseJSON.error);
                }
            });

        });


    });

})(jQuery);
