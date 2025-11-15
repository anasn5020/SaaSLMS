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

$(document).on('click', '.editOrganization', function () {
    let organization_id = $(this).data('item-id');
    let url = $('#url').val();
    url = url + '/admin/get-user-data/' + organization_id
    let token = $('.csrf_token').val();

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            '_token': token,
        },
        success: function (organization) {
            $('#organizationId').val(organization.id);
            $('#organizationName').val(organization.name);
            $('#organizationAbout').summernote("code", organization.about);
            $('#organizationDob').val(organization.dob);
            $('#organizationPhone').val(organization.phone);
            $('#organizationEmail').val(organization.email);
            $('#organizationImage').val(organization.image);
            $('#organizationFacebook').val(organization.facebook);
            $('#organizationTwitter').val(organization.twitter);
            $('#organizationLinkedin').val(organization.linkedin);
            $('#organizationInstragram').val(organization.instagram);
            $("#editOrganization").modal('show');
        },
        error: function (data) {
            toastr.error('Something Went Wrong', 'Error');
        }
    });


});


$(document).on('click', '.deleteOrganization', function () {
    let id = $(this).data('id');
    $('#organizationDeleteId').val(id);
    $("#deleteOrganization").modal('show');
})

$(document).on('click', '#add_organization_btn', function () {
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
dataTableOptions.serverSide = true
dataTableOptions.processing = true
dataTableOptions.ajax = $('#getAllOrganizationData').val();
dataTableOptions.columns = [
    {data: 'DT_RowIndex', name: 'id'},
    {data: 'name', name: 'name'},
    {data: 'students', name: 'students'},
    {data: 'instructors', name: 'instructors'},
    {data: 'courses', name: 'courses'},
    {data: 'quizzes', name: 'quizzes'},
    {data: 'classes', name: 'classes'},
    {data: 'created_at', name: 'created_at'},
    {data: 'status', name: 'status', orderable: false},
    {data: 'action', name: 'action', orderable: false},
]

dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4, 5, 6, 7]);

let table = $('#lms_table').DataTable(dataTableOptions);
