$(document).ready(function () {
    $(".category").on('change keyup paste', function (e) {
        ApplyFilter();
    });
});

function deleteCommnet(item, element) {
    let form = $('#deleteCommentForm')
    form.attr('action', item);
    form.attr('data-element', element);
}

function ApplyFilter() {
    let url = $('.blog_route').val();
    let search = $('.search').val();

    var category = [];
    $('.category:checked').each(function (i) {
        category[i] = $(this).val();
    });
    url += '?type=' + '';
    url += '&category=' + category.toString();

    if (search != "") {
        url += '&query=' + search;
    }
    window.location.href = url;

}


$("body").on("click", ".reply_btn", function (e) {
    e.preventDefault();


    let reply_btn = $(this);
    let reply = reply_btn.data('comment');
    let reply_form = $('.reply_form_' + reply);
    if (reply_form.is(':visible')) {
        reply_form.addClass('d-none');
        reply_btn.html('Reply <i class="fas fa-chevron-right"></i> ');
    } else {
        hideOtherForm();
        reply_form.removeClass('d-none');

        reply_btn.html('Cancel Reply <i class="fas fa-chevron-right"></i>');

    }
    showMainForm();
});

function hideOtherForm() {
    let inputForm = $('.inputForm');
    inputForm.addClass('d-none');

}

function showMainForm() {
    // if ($(".blogComment").hasClass("d-none")) {
    //     $('.reply2_btn').html('Reply <i class="fas fa-chevron-right"></i> ');
    //     $('.reply_btn').html('Reply <i class="fas fa-chevron-right"></i> ');
    // }

    let totalVisible = $('.inputForm:visible').length;
    if (totalVisible == 0) {
        $('.blogComment').removeClass('d-none');
    } else {
        $('.blogComment').addClass('d-none');

    }
}

if ($(".blogComment").hasClass("d-none")) {
    $('.reply2_btn').html('Reply <i class="fas fa-chevron-right"></i> ');
    $('.reply_btn').html('Reply <i class="fas fa-chevron-right"></i> ');
}

$("body").on("click", ".reply2_btn", function (e) {
    e.preventDefault();


    let reply_btn = $(this);
    let reply = reply_btn.data('reply');

    let reply_form = $('.reply2_form_' + reply);

    if (reply_form.is(':visible')) {
        reply_form.addClass('d-none');
        reply_btn.html('Reply <i class="fas fa-chevron-right"></i> ');
    } else {
        hideOtherForm();
        reply_form.removeClass('d-none');
        reply_btn.html('Cancel Reply <i class="fas fa-chevron-right"></i>');
    }
    showMainForm();
});
