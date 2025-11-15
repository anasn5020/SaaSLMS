dataTableOptions.serverSide = true
dataTableOptions.processing = true
dataTableOptions.ajax = {
    url: $('#my_refund_route').val(),
    data: function (d) {
            d.f_date= $('.date_range_input').val()
        }
};
dataTableOptions.columns = [
    {data: 'DT_RowIndex', name: 'id'},
    {data: 'created_at', name: 'created_at'},
    {data: 'course', name: 'course.title'},
    {data: 'purchase_price', name: 'purchase_price'},
    {data: 'request_from', name: 'request_from'},
    {data: 'type', name: 'type', orderable: false, searchable: false},
    {data: 'status', name: 'status', orderable: false, searchable: false},
    {data: 'action', name: 'action', orderable: false, searchable: false},
]
let table = $('#lms_table').DataTable(dataTableOptions);
(function ($) {
    "use strict";
    $(document).ready(function () {

        $(document).on('click', '.reset_btn', function (event) {
            event.preventDefault();
            $('.date_range_input').val('');
            resetAfterChange();
        });


        $(document).on('click', '.show_reason', function (event) {
            event.preventDefault();
            let reason = $(this).data('reason');
            let heading = $(this).data('heading');
            $('#reason_body').html(reason);
            $('#reason_heading').html(heading);
            $("#reasonShowModal").modal('show');
        });

        function resetAfterChange() {
            let table = $('#lms_table').DataTable();
            table.ajax.reload();
        }

    });

})(jQuery);
