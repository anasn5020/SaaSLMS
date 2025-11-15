(function($) {
    "use strict";
    let _token = $('meta[name=_token]').attr('content') ;
    $(document).ready(function(){
        $(document).on('submit', '#create_form', function(event){
            event.preventDefault();
            let formElement = $(this).serializeArray()
            let formData = new FormData();
            formElement.forEach(element => {
                formData.append(element.name,element.value);
            });
            formData.append('_token',_token);
            resetValidationError();
            $.ajax({
                url: $('#store_url').val(),
                type:"POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success:function(response){
                    create_form_reset();
                    $('#add_new_modal').modal('hide');
                    toastr.success('Group Added Successfully','Success');
                    resetAfterChange(response.TableData);
                },
                error:function(response) {
                    $('#add_new_modal').modal('show');
                    showValidationErrors('#create_form',response.responseJSON.errors);
                }
            });
        });

        $(document).on('click', '.show_row', function(event){
            event.preventDefault();
            let id = $(this).data('id');
            let url =  $('#show_url').val();
            url = url.replace(':id',id);
            $.get(url, function(response){
                if(response){
                    $('#append_html').html(response);
                    $('#show_modal').modal('show');
                }
            });
        });

        $(document).on('click', '.edit_row', function(event){
            event.preventDefault();
            let id = $(this).data('id');
            let url =  $('#edit_url').val();
            url = url.replace(':id',id);
            $.get(url, function(response){
                if(response){
                    $('#append_html').html(response);
                    $('.primary_select').niceSelect();
                    $('.date').datepicker();
                    $('#edit_modal').modal('show');
                }
            });
        });

        $(document).on('submit', '#update_form', function(event){
            event.preventDefault();
            let formElement = $(this).serializeArray()
            let formData = new FormData();
            formElement.forEach(element => {
                formData.append(element.name,element.value);
            });
            formData.append('_token',_token);
            let id = $('#rowId').val();
            let url = $('#update_url').val();
            url = url.replace(':id',id);
            resetValidationError();
            $.ajax({
                url: url,
                type:"POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success:function(response){
                    $('#edit_modal').modal('hide');
                    resetAfterChange(response.TableData);
                    toastr.success('Group Update Successfully');
                },
                error:function(response) {
                    $('#edit_modal').modal('show');
                    showValidationErrors('#update_form',response.responseJSON.errors);
                }
            });
        });

        $(document).on('click','.delete_row',function (event){
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
                url:  $('#delete_url').val(),
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    if(response.parent_msg){
                        toastr.warning(response.parent_msg);

                    }
                    else{
                        resetAfterChange(response.TableData);
                        toastr.success("Deleted Successfully");
                    }
                },
                error: function(response) {
                    toastr.error("Something Went Wrong");
                }
            });
        });

        $(document).on('change', '.status_change', function(event){
            event.preventDefault();
            let status = 0;
            if($(this).prop('checked')){
                status = 1;
            }
            else{
                status = 0;
            }
            let id = $(this).data('id');
            let formData = new FormData();
            formData.append('_token', _token);
            formData.append('id', id);
            formData.append('status', status);
            $.ajax({
                url: $('#status_change_url').val(),
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    resetAfterChange(response.TableData);
                    toastr.success("Status Changed successfully");
                },
                error: function(response) {
                    toastr.error("Something went wrong");
                }
            });
        });


        function resetAfterChange(TableData){
            $('#lms_data_table').html(TableData);
            CRMTableThreeReactive();
        }
        function create_form_reset(){
            $(".primary_select").niceSelect('update');
            $('#create_form')[0].reset();
        }
        function showValidationErrors(formType, errors){
            $(formType +' #error_name').text(errors.name);
            $(formType +' #error_course_id').text(errors.course_id);
            $(formType +' #error_date_it_is_taught').text(errors.date_it_is_taught);
            $(formType +' #error_end_date').text(errors.end_date);
            $(formType +' #error_minimum_enroll').text(errors.minimum_enroll);
            $(formType +' #error_maximum_enroll').text(errors.maximum_enroll);
            $(formType +' #error_type').text(errors.type);
            $(formType +' #error_company_code').text(errors.company_code);
            $(formType +' #error_content_validity').text(errors.content_validity);
            $(formType +' #error_days_to_cancel').text(errors.days_to_cancel);
            $(formType +' #error_webinar_link').text(errors.webinar_link);
        }
        function resetValidationError(){
            $('#error_name').html('');
            $('#error_course_id').html('');
            $('#error_date_it_is_taught').html('');
            $('#error_end_date').html('');
            $('#error_minimum_enroll').html('');
            $('#error_maximum_enroll').html('');
            $('#error_type').html('');
            $('#error_company_code').html('');
            $('#error_content_validity').html('');
            $('#error_days_to_cancel').html('');
            $('#error_webinar_link').html('');
        }
    });
})(jQuery);
