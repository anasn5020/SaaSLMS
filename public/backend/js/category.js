function update_active_status(el) {
    let url = $('.status_route').val();
    let token = $('.csrf_token').val();
    if (el.checked) {
        let status = 1;
    } else {
        let status = 0;
    }
    $.post(url, {
            _token: token,
            id: el.value,
            status: status
        },
        function (data) {
            if (data.message == "success") {
                toastr.success('Success', 'Status has been changed');
            } else {
                toastr.error('Error', 'Ops, Something went wrong');
            }
        });
}

if ($('#table_id_table').length) {
    $('#table_id_table').DataTable(dataTableOptions);
}

if ($('#table_id_table_one').length) {
    $('#table_id_table_one').DataTable(dataTableOptions);
}

if ($('#table_id, .table-data').length) {
    $('#table_id, .table-data').DataTable(dataTableOptions);
}
