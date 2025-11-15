@push('scripts')
    <script>
        let _token = $('meta[name=_token]').attr('content');

        $(document).on('click', '.addWidget', function () {
            let demoMode = $('#demoMode').val();
            if (demoMode == 1) {
                toastr.warning("For the demo version, you cannot change this", "Warning");
                return false;
            }
            $('#CreateModal').modal('show');
            let a = $(this).data('type');
            $('#type').val(a);

        });


        function showEditModal(page) {
            let demoMode = $('#demoMode').val();
            if (demoMode == 1) {
                toastr.warning("For the demo version, you cannot change this", "Warning");
                return false;
            }
            $('#widgetEditId').val(page.id);
            $('#editTitle').val(page.title);
            $('#editPoint').val(page.point);
            let image = null;
            if (page.image != "" && page.image != null) {
                image = page.image.replace(/.*(\/|\\)/, '');
            }
            $('#editImage').val(image);
            $('#editModal').modal('show');


        }

        function showDeleteModal(route) {
            console.log($('#deleteItemModal'))
            $('#deleteItemModal').modal('show');
            $('#deleteBtn').attr('href', route)
        }

        function changeSection(type) {
            $('#type').val(type);
        }


    </script>
    <script type="application/javascript">


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2]);

        let table = $('.Crm_table_active3').DataTable(dataTableOptions);


    </script>
@endpush

