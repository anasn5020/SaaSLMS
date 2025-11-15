@push('scripts')

    <script>

        (function ($) {
            "use strict";
            $(document).ready(function () {
                $(document).on('change', '#document_file_1', function () {
                    getFileName($(this).val(), '#placeholderFileOneName');
                    imageChangeWithFile($(this)[0], '#blogImgShow');
                });

                //onchange image show function
                function imageChangeWithFile(input,srcId) {

                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $(srcId)
                                .attr('src', e.target.result);
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                }

            });
        })(jQuery);

    </script>

@endpush
