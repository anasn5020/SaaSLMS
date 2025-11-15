$(document).ready(function () {
    $('#add_timezone_modal').hide();
});

function open_add_timezone_modal(el) {
    $('#timezone_add').modal('show');
}

function edit_timezone_modal(el) {
    let url = $('.timezone_edit').val();
    let token = $('.csrf_token').val();
    $.post(url, {_token: token, id: el}, function (data) {
        $('#edit_form').html(data);
        $('#Item_Edit').modal('show');
        $('#code2').niceSelect();

    });
}
