$(document).ready(function () {
    let baseUrl = $('#baseUrl').val();
    $('#country').select2();
    $('.cityList').select2({
        ajax: {
            url: baseUrl + '/ajaxCounterCity',
            type: "GET",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                    page: params.page || 1,
                    id: $('#state').find(':selected').val(),
                }
            },
            cache: false
        }
    });
    $('.stateList').select2({
        ajax: {
            url: baseUrl + '/ajaxCounterState',
            type: "GET",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                    page: params.page || 1,
                    id: $('#country').find(':selected').val(),
                }
            },
            cache: false
        }
    });
    $('.select2').css('width', '100%');
});
