let header_token = $('#header_token').val();
$(document).on('click', '.editBtn', function (event) {
    if (!checkDemo()) {
        return false;
    }

    let form = $(this).closest("form");
    let data = form.serialize();
    // let id = $(this).closest("form").find('.id').val();
    // let type = $(this).closest("form").find('.type').val();
    // let title = $(this).closest("form").find($('input[name="title"]')).val();
    // let link = $(this).closest("form").find('.link').val();
    // let is_newtab = $(this).closest("form").find($('[name$="is_newtab"]:checked')).val();
    // let from_bank_name = $(this).closest("form").find($('[name$="from_bank_name"]:checked')).val();
    let url = $('#headermenu_edit_url').val();
    // let data = {
    //     'id': id,
    //     'type': type,
    //     'title': title,
    //     'link': link,
    //     'is_newtab': is_newtab,
    //     'from_bank_name': from_bank_name,
    //     '_token': header_token
    // }
    $.post(url, data, function (data) {
        if (data) {
            blankData();
            toastr.success(window.jsLang('data_operation_success'));
            reloadWithData(data);
        } else {
            toastr.error(window.jsLang('data_something_went_wrong'));
        }
    });


});


$(document).ready(function () {

    addMenu('Dynamic Page', '#add_page_btn', $('#menu_pagess'));
    addMenu('Static Page', '#add_static_page_btn', $('#menu_staticPagesInput'));
    addMenu('Category', '#add_category_page_btn', $('#menu_categoryInput'));
    addMenu('Sub Category', '#add_sub_category_page_btn', $('#menu_subCategoryInput'));
    addMenu('Course', '#add_course_page_btn', $('#menu_courseInput'));
    addMenu('Quiz', '#add_quiz_page_btn', $('#menu_quizInput'));
    addMenu('Class', '#add_class_page_btn', $('#menu_classInput'));

});
function addMenu(type, btn, input) {
    $(document).on('click', btn, function (event) {
        event.preventDefault(); // Prevent default behavior of the button click.

        if (!checkDemo()) {
            return false; // Stop if checkDemo returns false.
        }

        let dPages = input.val(); // Get selected values from the multiselect input.
        let url = $('#headermenu_add_url').val();

        // Ensure the input value is not empty or undefined.
        if (!dPages || dPages.length === 0) {
            toastr.error(window.jsLang('data_select_option'));
            return false;
        }

        // Prepare data to send in the POST request.
        let data = {
            type: type,
            element_id: dPages,
            _token: header_token,
        };

        // Send the POST request.
        $.post(url, data, function (response) {
            if (response) {
                blankData(); // Clear data or perform a reset.

                toastr.success(window.jsLang('data_operation_success'));

                // Reload data if necessary.
                reloadWithData(response);

                // Reset multiselect input.
                input.val([]);
                input.multiselect('uncheckAll'); // Clear all selected options.
                input.multiselect('refresh');   // Refresh the multiselect UI.

            } else {
                toastr.error(window.jsLang('data_something_went_wrong'));
            }
        }).fail(function (xhr, status, error) {
            // Handle errors from the POST request.
            toastr.error(window.jsLang('data_something_went_wrong'));
            console.error(`Error: ${error}`);
        });
    });
}



$(document).ready(function () {
    $(document).on('click', '#add_custom_link_btn', function (event) {
        if (!checkDemo()) {
            return false;
        }

        let tTitle = $('#tTitle').val();
        let tLink = $('#tLink').val();
        if (tTitle == '') {
            toastr.error($('#tTitle').data('error'));
            return false;
        }

        let url = $('#headermenu_add_url').val();
        let data = {
            'type': 'Custom Link', 'title': tTitle, 'link': tLink, '_token': header_token
        }

        $.post(url, data, function (data) {
            if (data) {
                blankData();
                toastr.success(window.jsLang('data_operation_success'));
                reloadWithData(data);
            } else {
                toastr.error(window.jsLang('data_something_went_wrong'));
            }
        });
    });

    $(document).on('click', '.mega_menu', function (event) {
        if (!checkDemo()) {
            return false;
        }
        let element = $(this);
        let status = element.val();
        if (status == 1) {
            element.closest('.accordion_card').find('.no-mega-menu').addClass('d-none')
            element.closest('.accordion_card').find('.yes-mega-menu').removeClass('d-none')
        } else {
            element.closest('.accordion_card').find('.yes-mega-menu').addClass('d-none')
            element.closest('.accordion_card').find('.no-mega-menu').removeClass('d-none')
        }


    });
});

$(document).ready(function () {
    let url = $('#headermenu_reordering_url').val();
    $(document).on('mouseover', 'body', function () {
        let demoMode = $('#demoMode').val();

        if (demoMode) {
            return false;
        }

        $('.dd').nestable({
            maxDepth: 3, callback: function (l, e) {
                let order = JSON.stringify($('.dd').nestable('serialize'));
                let data = {
                    'order': order, '_token': header_token
                }
                $.post(url, data, function (data) {
                    if (data != 1) {
                        toastr.error(window.jsLang('data_something_went_wrong'));
                    }
                });
            }
        });
    });
});

function elementDelete(id) {

    if (!checkDemo()) {
        return false;
    }

    $('#deleteSubmenuItem').modal('show');
    $('#item-delete').val(id);
}

$(document).on('click', '#delete-item', function (event) {
    event.preventDefault();
    if (!checkDemo()) {
        return false;
    }
    let url = $('#headermenu_delete_url').val();
    $('#deleteSubmenuItem').modal('hide');
    let id = $('#item-delete').val();
    let data = {
        'id': id, '_token': header_token,
    }
    $.post(url, data, function (data) {
        reloadWithData(data);
    });
});


function reloadWithData(response) {
    $('#menuList').empty();
    $('#menuList').html(response);
}

function blankData() {
    $('#tTitle').val('');
    $('#tLink').val('');
    $('#dNewsCategory').val('');
    $('#dNews').val('');
    $('#sPages').val('');
    $('#dPages').val('');
    $('.primary-input').removeClass('has-content');
    location.reload()
}

function checkDemo() {
    let demoMode = $('#demoMode').val();

    if (demoMode) {
        toastr.warning("For the demo version, you cannot change this", "Warning");
        return false;
    } else {
        return true;
    }
}
