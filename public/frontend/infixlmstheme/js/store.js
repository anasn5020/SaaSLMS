$(document).on('change keyup paste', '#custom_pagination, .price, .product_category, .instructor, .sort_by', function (e) {
    ApplyFilter();
});

function ApplyFilter() {
    var custom_pagination = $('#custom_pagination').find(":selected").val();
    let url = $('.class_route').val();
    let search = $('.search').val();
    var type = [];

    $('.price:checked').each(function (i) {
        type[i] = $(this).val();
    });
    url += '/?price=' + type.toString();

    $('.product_category:checked').each(function (i) {
        url += '&product_category[]=' + $(this).val();
    });
    $('.instructor:checked').each(function (i) {
        url += '&user_id[]=' + $(this).val();
    });
    $('.sort_by:checked').each(function (i) {
        url += '&sort_by[]=' + $(this).val();
    });

    url += '&custom_pagination=' + custom_pagination.toString();


    if (search != "" && search != undefined) {
        url += '&search=' + search;
    }
    window.location.href = url;

}
