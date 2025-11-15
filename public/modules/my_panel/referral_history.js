dataTableOptions.serverSide = true
dataTableOptions.processing = true
dataTableOptions.ajax = {
    url: $('#referral_history_route').val(),
    data: function (d) {
             d.f_date= $('.date_range_input').val()
     }
};

dataTableOptions.columns = [{data: 'DT_RowIndex', name: 'id'}, {data: 'date', name: 'date'}, {
    data: 'user',
    name: 'invite_accept_byF.name'
}, {data: 'bonus_amount', name: 'bonus_amount'},

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

function copyCurrentUrl() {
    var copyText = document.getElementById('referral_link').value;
    console.log(copyText);
    var dummy = $('<input>').val(copyText).appendTo('body').select()
    document.execCommand('copy');
    toastr.success('Referral Link Copied Successfully', 'Success Alert');
}
