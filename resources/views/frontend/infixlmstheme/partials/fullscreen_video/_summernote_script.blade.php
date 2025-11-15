
<script src="{{ asset('public/backend/js/summernote-bs5.min.js') }}"></script>
<script>
    function sendFile(files, editor = '#summernote', name) {
        let url = '{{url('/')}}';
        let formData = new FormData();
        $.each(files, function (i, v) {
            formData.append("files[" + i + "]", v);
        })

        $.ajax({
            url: url + '/summer-note-file-upload',
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                let $summernote;
                if (name) {
                    $summernote = $(editor + "[name='" + name + "']");
                } else {
                    $summernote = $(editor);
                }
                $.each(response, function (i, v) {
                    $summernote.summernote('insertImage', v);
                })
            },
            error: function (data) {
                if (data.status === 404) {
                    toastr.error("What you are looking is not found", 'Opps!');
                    return;
                } else if (data.status === 500) {
                    toastr.error('Something went wrong. If you are seeing this message multiple times, please contact administrator.', 'Opps');
                    return;
                } else if (data.status === 200) {
                    toastr.error('Something is not right', 'Error');
                    return;
                }
                let jsonValue = $.parseJSON(data.responseText);
                let errors = jsonValue.errors;
                if (errors) {
                    let i = 0;
                    $.each(errors, function (key, value) {
                        let first_item = Object.keys(errors)[i];
                        let error_el_id = $('#' + first_item);
                        if (error_el_id.length > 0) {
                            error_el_id.parsley().addError('ajax', {
                                message: value, updateClass: true
                            });
                        }
                        toastr.error(value, 'Validation Error');
                        i++;
                    });
                } else {
                    toastr.error(jsonValue.message, 'Opps!');
                }

            }
        });
    }

    if ($('.lms_summernote').length) {
        $('.lms_summernote').summernote({
            codeviewFilter: true,
            codeviewIframeFilter: true,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen']],
            ],
            placeholder: '',
            tabsize: 2,
            height: 188,
            callbacks: {
                onImageUpload: function (files) {
                    sendFile(files, '.lms_summernote', $(this).attr('name'))
                }
            },
            tooltip: false
        });
        $(document).ready(function () {
            $('.note-toolbar').find('[data-toggle]').each(function () {
                $(this).attr('data-bs-toggle', $(this).attr('data-toggle')).removeAttr('data-toggle');
            });
        });
        $(document).ready(function () {
            $('.note-modal').find('[data-dismiss]').each(function () {
                $(this).attr('data-bs-dismiss', $(this).attr('data-dismiss')).removeAttr('data-dismiss');
            });
        });
    }
    var app_debug = $('.app_debug').val();
    if (!app_debug) {
        $(document).bind("contextmenu", function (e) {
            e.preventDefault();
        });

        $(document).keydown(function (e) {
            if (e.which === 123) {
                return false;
            }
        });


        document.onkeydown = function (e) {
            if (event.keyCode == 123) {
                return false;
            }

            if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
                return false;
            }


            if (e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)) {
                return false;
            }

            if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
                return false;
            }
            if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
                return false;
            }
            if (e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)) {
                return false;
            }
            if (e.ctrlKey && e.keyCode == 'H'.charCodeAt(0)) {
                return false;
            }

            if (e.ctrlKey && e.keyCode == 'F'.charCodeAt(0)) {
                return false;
            }
            if (e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)) {
                return false;
            }
        }
    }
</script>
