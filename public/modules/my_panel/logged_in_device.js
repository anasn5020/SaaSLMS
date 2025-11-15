const MyClassModule = $("#MyClassModule").val();
const InvoiceModule = $("#InvoiceModule").val();

dataTableOptions.serverSide = true
dataTableOptions.processing = true
dataTableOptions.ajax = {
    url: $('#logged_in_device_route').val(),
    data: function () {
        return {
            f_date: $('.date_range_input').val()
        };
    }
};

dataTableOptions.columns = [
    {data: 'DT_RowIndex', name: 'id'},
    {data: 'login_at', name: 'login_at'},
    {data: 'os', name: 'os'},
    {data: 'browser', name: 'browser'},
    {data: 'logout_at', name: 'logout_at'},
    {data: 'action', name: 'action', orderable: false, searchable: false},
]
let table = $('#lms_table').DataTable(dataTableOptions);
(function ($) {
    "use strict";
    $(document).ready(function () {


        $(document).on('click', '.logout_device', function (event) {
            event.preventDefault();
            let id = $(this).data('id');
            $('#rowId').val(id);
            $('#logOutModal').modal('show');
        });


        $(document).on('click', '.reset_btn', function (event) {
            event.preventDefault();
            $('.date_range_input').val('');
            resetAfterChange();
        });

        function resetAfterChange() {
            let table = $('#lms_table').DataTable();
            table.ajax.reload();
        }

    });

})(jQuery);
