(function ($) {
    "use strict";
    $(document).ready(function () {
        var selector = ".date_range_input"
        $(selector).on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            resetAfterChange();
        });
        // window.jsLang('data_view_tablet'),
        $(selector).daterangepicker({
            autoUpdateInput: false,
            opens: rtl == "rtl" ? "left" : "right",
            locale: {
                "applyLabel": window.jsLang('data_apply'),
                "cancelLabel": window.jsLang('data_cancel'),
                "fromLabel": window.jsLang('data_from'),
                "toLabel": window.jsLang('data_to'),
                "customRangeLabel": window.jsLang('data_custom'),
                "daysOfWeek": [window.jsLang('data_Sun'), window.jsLang('data_Mon'), window.jsLang('data_Tue'), window.jsLang('data_Wed'), window.jsLang('data_Thu'), window.jsLang('data_Fri'), window.jsLang('data_Sat'),],
                "monthNames": [window.jsLang('data_January'), window.jsLang('data_February'), window.jsLang('data_March'), window.jsLang('data_April'), window.jsLang('data_May'), window.jsLang('data_June'), window.jsLang('data_July'), window.jsLang('data_August'), window.jsLang('data_September'), window.jsLang('data_October'), window.jsLang('data_November'), window.jsLang('data_December')],
            }, ranges: {
                [window.jsLang('data_today')]: [moment(), moment()],
                [window.jsLang('data_yesterday')]: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                [window.jsLang('data_last_7_days')]: [moment().subtract(6, 'days'), moment()],
                [window.jsLang('data_last_30_days')]: [moment().subtract(29, 'days'), moment()],
                [window.jsLang('data_this_month')]: [moment().startOf('month'), moment().endOf('month')],
                [window.jsLang('data_last_month')]: [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                [window.jsLang('data_this_year')]: [moment().startOf('year'), moment().endOf('year')],
                [window.jsLang('data_last_year')]: [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
            }


        }, function (start, end, label) {

        });


        function resetAfterChange() {
            let table = $('#lms_table').DataTable();
            table.ajax.reload();
        }


    });

})(jQuery);
