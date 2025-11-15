$(document).ready(function () {
    $('#add_currency_modal').hide();
});

function open_add_currency_modal(el) {
    $('#currency_add').modal('show');
}

function edit_currency_modal(el) {
    let url = $('.currency_edit').val();
    let token = $('.csrf_token').val();
    $.post(url, {_token: token, id: el}, function (data) {
        $('#Item_Edit').html(data);
        $('#Item_Edit').modal('show');
    });
}
