dataTableOptions.serverSide = true
dataTableOptions.processing = true
// dataTableOptions.ajax = $('#deposit_history_route').val();
// dataTableOptions.ajax.data = function (d) {
//    d.f_date = $('.date_range_input').val();
// };

dataTableOptions.ajax = {
    url:$('#deposit_history_route').val(),
    data: function (d) {
        d.f_date =$('.date_range_input').val();
    },
}
dataTableOptions.columns = [
    {data: 'DT_RowIndex', name: 'id'},
    {data: 'created_at', name: 'created_at'},
    {data: 'amount', name: 'amount'},
    {data: 'method', name: 'method'},
]
dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3,  ]);

let table = $('#lms_table').DataTable(dataTableOptions);
