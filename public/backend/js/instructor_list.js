$(".toggle-password").click(function () {

    var input = $(this).closest('.input-group').find('input');

    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});
$(".imgBrowse").change(function (e) {
    e.preventDefault();
    var file = $(this).closest('.primary_file_uploader').find('.imgName');
    var filename = $(this).val().split('\\').pop();
    file.val(filename);
});

$(document).on('click', '.editInstructor', function () {
    let instructor_id = $(this).data('item-id');
    let url = $('#url').val();
    url = url + '/admin/get-user-data/' + instructor_id
    let token = $('.csrf_token').val();

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            '_token': token,
        },
        success: function (instructor) {
            $('#instructorId').val(instructor.id);
            $('#instructorName').val(instructor.name);
            $('#instructorAbout').summernote("code", instructor.about);
            $('#instructorDob').val(instructor.dob);
            $('#instructorPhone').val(instructor.phone);
            $('#instructorEmail').val(instructor.email);
            $('#instructorImage').val(instructor.image);
            $('#instructorFacebook').val(instructor.facebook);
            $('#instructorTwitter').val(instructor.twitter);
            $('#instructorLinkedin').val(instructor.linkedin);
            $('#instructorInstragram').val(instructor.instagram);
            $("#editInstructor").modal('show');
        },
        error: function (data) {
            toastr.error('Something Went Wrong', 'Error');
        }
    });


});


$(document).on('click', '.deleteInstructor', function () {
    let id = $(this).data('id');
    $('#instructorDeleteId').val(id);
    $("#deleteInstructor").modal('show');
})

$(document).on('click', '#add_instructor_btn', function () {
    $('#addName').val('');
    $('#addAbout').html('');
    $('#startDate').val('');
    $('#addPhone').val('');
    $('#addEmail').val('');
    $('#addPassword').val('');
    $('#addCpassword').val('');
    $('#addFacebook').val('');
    $('#addTwitter').val('');
    $('#addLinked').val('');
    $('#addInstagram').val('');
});
