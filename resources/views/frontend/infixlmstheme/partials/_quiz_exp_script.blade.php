<input type="hidden" id="quiz_test_id" value="0">

<script>
    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
    });

    $(document).on('click', '.submit_q_btn', function (e) {
        e.preventDefault();
        $('#quiz_test_id').val($(this).data('quiz_test_id'))
        $('.question_list').removeClass('d-none');
        UpdateResult();
    });
    $(document).on('click', '.hide_show_btn', function (e) {
        e.preventDefault();
        var type = $(this).data('type');
        var id = $(this).data('id');
        if (type == 'check') {
            $('.answer' + id).removeClass('d-none');
        } else {
            $('.answer' + id).addClass('d-none')
        }
    });

    function UpdateResult() {
        let list_option = $('.list-option');
        list_option.removeClass('border-success');
        list_option.removeClass('border-danger');
        list_option.find('label').removeClass('error_ans');
        list_option.find('.text-danger').addClass('d-none');
        list_option.find('.text-success').addClass('d-none');
        $('input:checkbox').removeAttr('checked');

        let quiz_test_id = $('#quiz_test_id').val();
        if (quiz_test_id != 0) {
            jQuery.ajax({
                url: '{{url('quizResultPreviewApi')}}/' + quiz_test_id,
                type: 'GET',
                success: function (data) {

                    $.each(data, function (index, value) {
                        $.each(value.option, function (index2, value2) {
                            let list_option = $('#list_option' + value2.id)
                            let option = $('#option' + value2.id);
                            if (value2.wrong) {
                                list_option.addClass('border-danger');
                                list_option.removeClass('border-success');
                                list_option.find('label').addClass('error_ans');
                                list_option.find('.text-danger').removeClass('d-none');
                                list_option.find('.text-success').addClass('d-none');
                                option.prop('checked', true);
                            }
                            if (value2.right) {
                                list_option.find('label').removeClass('error_ans');
                                list_option.addClass('border-success');
                                list_option.removeClass('border-danger');
                                list_option.find('.text-danger').addClass('d-none');
                                list_option.find('.text-success').removeClass('d-none');
                                option.prop('checked', true);
                            }
                            if (!value.isSubmit) {
                                list_option.find('label').removeClass('error_ans');
                                list_option.removeClass('border-success');
                                list_option.removeClass('border-danger');
                                list_option.find('.text-success').addClass('d-none');
                                list_option.find('.text-danger').addClass('d-none');
                                option.prop('checked', false);
                            }
                        });
                    });
                }
            });
        }
    }


</script>
