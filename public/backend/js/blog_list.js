$(document).on('click', '.editBlog', function () {


    let blog = $(this).data('item');
    console.log(blog.tags)
    $('#BlogId').val(blog.id);
    $('.editTitle').val(blog.title);
    $('.editSlug').val(blog.slug);
    var tagInputEle = $('.editTag');

    tagInputEle.tagsinput();
    var tags = blog.tags;

    if (tags == null || tags == '') {
        //
    } else {
        tags = tags.split(',');


        for (var i = 0; i < tags.length; i++) {
            tagInputEle.tagsinput('add', tags[i]);
        }
    }


    $('#editCategory').val(blog.category_id);
    $('#editCategory').niceSelect('update')
    // $('.editPublishDate').val(blog.authored_date);
    $('#image').val(blog.image);
    $('#description').summernote("code", blog.description);
    $('.editPublishDate').val(blog.authored_date);
    // $('.editPublishDate').datepicker('setDate', blog.authored_date);
    // $('.editPublishDate').datepicker('minDate', blog.authored_date);

    // $('.editPublishDate').datepicker({
    //     setDate: blog.authored_date
    // })

    $("#editBlog").modal('show');
});


$(document).on('click', '.deleteBlog', function () {
    let id = $(this).data('id');
    $('#blogDeleteId').val(id);
    $("#deleteBlog").modal('show');
});

$(".editTitle").on('input', function () {
    let title = $(".editTitle").val();
    $(".editSlug").val(convertToSlug(title));
});

$(".addTitleActive").on('input', function () {
    let title = $(".addTitleActive").val();
    $(".addSlug").val(convertToSlug(title));
});

function convertToSlug(Text) {
    return Text
        .toLowerCase()
        .replace(/ /g, '-')
        .replace(/[^\w-]+/g, '')
        ;
}
