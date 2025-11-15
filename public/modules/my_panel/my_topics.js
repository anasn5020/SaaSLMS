dataTableOptions.serverSide = true
dataTableOptions.processing = true

dataTableOptions.ajax = {
    url: $('#my_topics_route').val(), // URL for fetching data
    data: function (d) {
        d.f_type = $('#f_type').val(); // Additional parameters
        d.f_category = $('#f_category').val();
        d.f_date = $('.date_range_input').val();
    }
};
dataTableOptions.columns = [
    {data: 'DT_RowIndex', name: 'id'},
    {data: 'topic_title', name: 'course.title'},
    {data: 'topic_type', name: 'course.type'},
    {data: 'curriculum', name: 'curriculum', orderable: false, searchable: false},
    {data: 'created_at', name: 'created_at'},
    {data: 'action', name: 'action', orderable: false, searchable: false},
]
let table = $('#lms_table').DataTable(dataTableOptions);

(function ($) {
    "use strict";
    $(document).ready(function () {


        $(document).on('change', '#f_type, #f_category', function (event) {
            event.preventDefault();
            resetAfterChange();
        });

        $(document).on('click', '.reset_btn', function (event) {
            event.preventDefault();
            $('#f_type').val('').niceSelect('update');
            $('#f_category').val('').niceSelect('update');
            $('.date_range_input').val('');
            resetAfterChange();
        });


        function resetAfterChange() {
            let table = $('#lms_table').DataTable();
            table.ajax.reload();
        }


    });

})(jQuery);
