(function($) {
    "use strict";
    let _token = $('meta[name=_token]').attr('content') ;
    $(document).ready(function(){
        let instructorRoleDiv = $('.instructor_role_div');
        instructorRoleDiv.hide();
        $(document).on('change', '#user_id', function(event){
            let userRole = $(this).find(':selected').data('role');
            if(userRole === 2){
                instructorRoleDiv.show();
                let hiddenInput = `<input type="hidden" name="instructor" id="instructor" value="1">`
                $(".append_hidden_input").html(hiddenInput);
            }else {
                instructorRoleDiv.hide();
                let hiddenInput = `<input type="hidden" name="student" id="student" value="1">`
                $(".append_hidden_input").html(hiddenInput);
            }
        });

        $(document).on('click','.delete_user_from_group',function (event){
            event.preventDefault();
            let id = $(this).data('id');
            $('#delete_item_id').val(id);
            $('#deleteItemModal').modal('show');
        });

        $(document).on('submit', '#item_delete_form', function(event) {
            event.preventDefault();
            $('#deleteItemModal').modal('hide');
            var formData = new FormData();
            formData.append('_token', _token);
            formData.append('id', $('#delete_item_id').val());
            $.ajax({
                url:  $('#group_member_delete_url').val(),
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    if(response.status){
                        location.reload();
                        toastr.success("Deleted Successfully");
                    }

                },
                error: function(response) {
                    toastr.error("Something Went Wrong");
                }
            });
        });

    });
})(jQuery);
