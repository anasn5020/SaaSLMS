$('.support_main_card_title_dropdown').on('click', function (e) {
    e.stopPropagation();
    $(this).find('ul').fadeToggle();
})
$(document).on('click', function (e) {
    if (!$(e.target).is('.support_main_card_title_dropdown ul *')) {
        $('.support_main_card_title_dropdown ul').fadeOut();
    }
})

function addNewFileAddItem(index) {


    var result = `
              <div class="row support_main_file attach-item">
                                <div class="col-11">
                                    <div class="support_main_card_content_item">
                                        <label for="#" class='primary_label2'>Attach File</label>
                                        <div class="position-relative primary_file_uploader">
                                            <input type="text" class="primary_input filePlaceholder"
                                                   placeholder='Attach File' readonly>
                                            <button type='button' class='theme_btn' id='file-upload'>
                                                <label for="ticket_file_${index}">Browse</label>
                                                <input type="file" name="ticket_file[]"  class='d-none fileUpload' id="ticket_file_${index}">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 text-end">
                                    <button type="button" class="theme_btn delete-ticket-message-attach sub-action"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                            `;

    $('.all_attach').append(result);
}

var index = 0;
$(document).on('click', '.action', function (e) {
    index = $('.attach-item').length
    addNewFileAddItem(index)
});

$(document).on('click', '.delete-ticket-message-attach', function (e) {
    $(this).closest(".support_main_file").remove();
    // $(this).parent().parent().remove();
});


$(document).on('change', '.fileUpload', function () {
    let placeholder = $(this).closest(".primary_file_uploader").find(".filePlaceholder");
    let fileInput = event.srcElement;
    placeholder.val(fileInput.files[0].name);

});

$('.editor').summernote({
    placeholder: 'Write here',
    tabsize: 2,
    height: 188,
    tooltip: false
});


function deleteTicket(id) {
    $('#dataId').val(id)
    $('#deleteItem').modal('show')
}

courseDiv();
$(document).on('change', '#category_id', function (event) {
    courseDiv();
});

function courseDiv() {
    let category = $("#category_id").find('option:selected').data('slug');
    let course_div = $(".course_div");
    if (category === 'course') {
        course_div.show();
    } else {
        course_div.hide();
    }
}
