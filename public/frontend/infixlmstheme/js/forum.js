$(document).ready(function () {
    let search_filed = $('#forum_search_input').val();
    let suggestion_div = $('#forum_suggestion_list');
    if (search_filed == "") {
        suggestion_div.attr('style', 'display: none');
    } else {
        suggestion_div.attr('style', 'display: block');
    }
});

$('#course_list').on('change', function () {
    let course_id = $(this).val();
    let url = $('#forum_url').val();
    let new_url = url + '/course/' + course_id;
    window.location.replace(new_url);
});
$('#group_list').on('change', function () {
    let course_id = $(this).val();
    let url = $('#forum_url').val();
    let new_url = url + '/group/' + course_id;
    window.location.replace(new_url);
});
$('#category_list :checkbox').change(function () {
    let checkbox_value = [];
    if (this.checked) {
        $("input[name='category[]']:checked").each(function (index, obj) {
            checkbox_value.push($(this).val());
        });
    } else {
        $("input[name='category[]']:checked").each(function (index, obj) {
            checkbox_value.push($(this).val());
        });
    }
    let url = $('#forum_url').val();
    let new_url = url + '?category_id=' + checkbox_value;
    window.location.replace(new_url);
});
$('#type_list :checkbox').change(function () {
    let checkbox_value = [];
    if (this.checked) {
        $("input[name='type[]']:checked").each(function (index, obj) {
            checkbox_value.push($(this).val());
        });
    } else {
        $("input[name='type[]']:checked").each(function (index, obj) {
            checkbox_value.push($(this).val());
        });
    }
    let url = $('#forum_url').val();
    let new_url = url + '/group-type?type=' + checkbox_value;
    window.location.replace(new_url);
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#forum_search_input').keyup(function () {

    $('#forum_suggestion').css('display', 'block');
    let input_value = $(this).val();
    let forum_url = $('#forum_url').val();
    let loader_icon = $('#loader_icon').val();
    let forum_suggestion = $('#forum_suggestion');

    if (input_value == "") {
        $('#forum_suggestion_list').empty();
        $('#forum_suggestion_list').attr('style', 'display: none');
    }
    var items = [];

    $.ajax({
        type: 'GET',
        url: forum_url + "/suggestion/" + input_value,
        data: {input_value: input_value},
        beforeSend: function () {
            $("#forum_search_input").css("background", "#FFF url(" + loader_icon + ") no-repeat 165px");
        },
        success: function (data) {
            if (data.length === 0) {
                $('#forum_suggestion_list').empty();
                $('#forum_suggestion_list').attr('style', 'display: none');
            } else {
                $('#forum_suggestion_list').attr('style', 'display: block');
                $("#forum_search_input").css("background", "#FFF url(" + loader_icon + ") no-repeat 165px");
                $('#forum_suggestion_list').empty();

                $.each(data, function (i, item) {
                    $.each(item, function (i, forum) {
                        items.push(forum);
                    });

                }); // close each()
                $('#forum_suggestion_list').append(items.join(''));
            }
        }

    });

});

