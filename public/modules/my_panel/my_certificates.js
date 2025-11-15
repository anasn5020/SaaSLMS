const MyClassModule = $("#MyClassModule").val();
const InvoiceModule = $("#InvoiceModule").val();

dataTableOptions.serverSide = true
dataTableOptions.processing = true
dataTableOptions.ajax = $('#my_certificate_route').val();
dataTableOptions.columns = [
    {data: 'DT_RowIndex', name: 'id'},
    {data: 'created_at', name: 'created_at'},
    {data: 'course', name: 'course.title'},
    {data: 'certificate_id', name: 'certificate_id'},
    {data: 'my_class', name: 'my_class', visible: MyClassModule, orderable: false, searchable: false},
    {data: 'invoice', name: 'invoice', visible: InvoiceModule, orderable: false, searchable: false},
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

        function resetAfterChange() {
            let table = $('#lms_table').DataTable();
            table.ajax.reload();
        }

    });

})(jQuery);

