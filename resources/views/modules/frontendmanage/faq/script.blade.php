<script>
    (function ($) {
        "use strict";

        $('tbody').sortable({
            cursor: "move",
            update: function (event, ui) {
                let ids = $(this).sortable('toArray', {attribute: 'data-item'});
                console.log(ids);
                if (ids.length > 0) {
                    let data = {
                        '_token': '{{ csrf_token() }}',
                        'ids': ids,
                    }
                    $.post("{{route('frontend.changeHomePageFaqPosition')}}", data, function (data) {

                    });
                }
            }
        });


        $(document).on('click', '.editfaq', function () {
            let url = '{{route('frontend.faq.show')}}';
            let id = $(this).data('id');
            $.get(url, {
                'id': id
            }, function (data) {
                $('#editFaqBody').html(data);

                $('.lms_summernote').summernote({
                    tabsize: 2, height: 360, tooltip: false, toolbar: [

                        ['para', ['style', 'ul', 'ol', 'paragraph']],
                        ['font', ['bold', 'underline', 'clear']], ['fontname', ['fontname']], ['color', ['color']], ['para', ['ul', 'ol', 'paragraph']], ['table', ['table']], ['style', ['bold', 'italic', 'underline', 'clear']], ['font', ['strikethrough', 'superscript', 'subscript']], ['fontsize', ['fontsize']], ['color', ['color']], ['height', ['height']], ['insert', ['link', 'picture', 'video', 'math', 'hr']], ['view', ['fullscreen', 'codeview']],]

                })
                $("#editfaq").modal('show');
            });
        });


        $(document).on('click', '.deletefaq', function () {
            let id = $(this).data('id');
            $('#faqDeleteId').val(id);
            $("#deletefaq").modal('show');
        });


        $(document).on('click', '#add_faq_btn', function () {
            $('#addQuestion').val('');
            $('#addAnswer').html('');
        });
    })(jQuery);
</script>



@if ($errors->any())
    <script>
        @if(Session::has('type'))
        @if(Session::get('type')=="store")
        $('#add_faq').modal('show');
        @else
        $('#editfaq').modal('show');
        @endif
        @endif
    </script>
@endif
<script type="application/javascript">


    dataTableOptions = updateColumnExportOption(dataTableOptions, [ 1, 2    ]);

    let table = $('#lms_table').DataTable(dataTableOptions);


</script>
