$(document).ready(function () {
    $('.lms_summernote').summernote({
        codeviewFilter: true,
        codeviewIframeFilter: true,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen']],
        ],
        placeholder: 'Answer',
        tabsize: 2,
        height: 188,
        tooltip: true
    });

    $(document).on('input', "#blog_title", function () {
        let str = $(this).val();
        const slugify = str
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');

        $("#slug").val(slugify);
    });
});
