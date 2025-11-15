@push('scripts')
    <script>
        $(document).on('click', '.addWidget', function () {
            // let demoMode = $('#demoMode').val();
            // if (demoMode == 1) {
            //     toastr.warning("For the demo version, you cannot change this", "Warning");
            //     return false;
            // }
            $('#CreateModal').modal('show');
            let a = $(this).data('type');
            $('#category').val(a);

        });


        @if ($errors->any())

        @endif

        $(document).ready(function () {

            $('#copyright_form').on('submit', function (event) {
                event.preventDefault();

                // let demoMode = $('#demoMode').val();
                // if (demoMode == 1) {
                //     toastr.warning("For the demo version, you cannot change this", "Warning");
                //     return false;
                // }
                @if(!permissionCheck('footerSetting.footer.content-update'))
                toastr.warning("{{__('common.Permission denied')}}", "{{__('common.Warning')}}");
                return false;
                @endif

                $("#copyrightBtn").prop('disabled', true);
                $('#copyrightBtn').text('Updating');
                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('footerSetting.footer.content-update') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        toastr.success('{{trans('common.Operation successful')}}')
                        $('#copyrightBtn').text('{{__('common.Update')}}');
                        $("#copyrightBtn").prop('disabled', false);
                    },
                    error: function (response) {
                        toastr.error('{{trans('common.Something Went Wrong')}}')
                        $('#copyrightBtn').text('{{__('common.Update')}}');
                        $("#copyrightBtn").prop('disabled', false);
                    }
                });
            });

            $('#aboutForm').on('submit', function (event) {
                event.preventDefault();
                let demoMode = $('#demoMode').val();
                if (demoMode == 1) {
                    toastr.warning("For the demo version, you cannot change this", "Warning");
                    return false;
                }
                @if(!permissionCheck('footerSetting.footer.content-update'))
                toastr.warning("{{__('common.Permission denied')}}", "{{__('common.Warning')}}");
                return false;
                @endif
                $("#aboutSectionBtn").prop('disabled', true);
                $('#aboutSectionBtn').text('Updating');
                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('footerSetting.footer.content-update') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        toastr.success('{{trans('common.Operation successful')}}')
                        $('#aboutSectionBtn').text('{{__('common.Update')}}');
                        $("#aboutSectionBtn").prop('disabled', false);
                    },
                    error: function (error) {
                        if (error.status == 422) {
                            toastr.error(error.responseJSON.message)
                        } else {
                            toastr.error('{{trans('common.Something Went Wrong')}}')
                        }
                        $('#aboutSectionBtn').text('{{__('common.Update')}}');
                        $("#aboutSectionBtn").prop('disabled', false);
                    }
                });
            });

            $('#aboutDescriptionForm').on('submit', function (event) {
                event.preventDefault();
                let demoMode = $('#demoMode').val();
                if (demoMode == 1) {
                    toastr.warning("For the demo version, you cannot change this", "Warning");
                    return false;
                }
                @if(!permissionCheck('footerSetting.footer.content-update'))
                toastr.warning("{{__('common.Permission denied')}}", "{{__('common.Warning')}}");
                return false;
                @endif
                $("#aboutDescriptionBtn").prop('disabled', true);
                $('#aboutDescriptionBtn').text('Updating');
                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('footerSetting.footer.content-update') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        toastr.success('{{trans('common.Operation successful')}}')
                        $('#aboutDescriptionBtn').text('{{__('common.Update')}}');
                        $("#aboutDescriptionBtn").prop('disabled', false);
                    },
                    error: function (response) {
                        toastr.error('{{trans('common.Something Went Wrong')}}')
                        $('#aboutDescriptionBtn').text('{{__('common.Update')}}');
                        $("#aboutDescriptionBtn").prop('disabled', false);
                    }
                });
            });

            $('#companyForm').on('submit', function (event) {
                event.preventDefault();
                let demoMode = $('#demoMode').val();
                if (demoMode == 1) {
                    toastr.warning("For the demo version, you cannot change this", "Warning");
                    return false;
                }
                @if(!permissionCheck('footerSetting.footer.content-update'))
                toastr.warning("{{__('common.Permission denied')}}", "{{__('common.Warning')}}");
                return false;
                @endif
                $("#companyBtn").prop('disabled', true);
                $('#companyBtn').text('Updateing');
                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('footerSetting.footer.content-update') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        toastr.success('{{trans('common.Operation successful')}}')
                        $('#companyBtn').text('{{__('common.Update')}}');
                        $("#companyBtn").prop('disabled', false);
                    },
                    error: function (response) {
                        toastr.error('{{trans('common.Something Went Wrong')}}')
                        $('#companyBtn').text('{{__('common.Update')}}');
                        $("#companyBtn").prop('disabled', false);
                    }
                });
            });

            $('#accountForm').on('submit', function (event) {
                event.preventDefault();
                let demoMode = $('#demoMode').val();
                if (demoMode == 1) {
                    toastr.warning("For the demo version, you cannot change this", "Warning");
                    return false;
                }
                @if(!permissionCheck('footerSetting.footer.content-update'))
                toastr.warning("{{__('common.Permission denied')}}", "{{__('common.Warning')}}");
                return false;
                @endif
                $("#accountBtn").prop('disabled', true);
                $('#accountBtn').text('Updating');
                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('footerSetting.footer.content-update') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        toastr.success('{{trans('common.Operation successful')}}')
                        $('#accountBtn').text('{{__('common.Update')}}');
                        $("#accountBtn").prop('disabled', false);
                    },
                    error: function (response) {
                        toastr.error('{{trans('common.Something Went Wrong')}}')

                        $('#accountBtn').text('{{__('common.Update')}}');
                        $("#accountBtn").prop('disabled', false);
                    }
                });
            });

            $('#serviceForm').on('submit', function (event) {
                event.preventDefault();
                let demoMode = $('#demoMode').val();
                if (demoMode == 1) {
                    toastr.warning("For the demo version, you cannot change this", "Warning");
                    return false;
                }
                @if(!permissionCheck('footerSetting.footer.content-update'))
                toastr.warning("{{__('common.Permission denied')}}", "{{__('common.Warning')}}");
                return false;
                @endif
                $("#serviceBtn").prop('disabled', true);
                $('#serviceBtn').text('Updating');
                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('footerSetting.footer.content-update') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        toastr.success('{{trans('common.Operation successful')}}')
                        $('#serviceBtn').text('{{__('common.Update')}}');
                        $("#serviceBtn").prop('disabled', false);
                    },
                    error: function (response) {
                        toastr.error('{{trans('common.Something Went Wrong')}}')

                        $('#serviceBtn').text('{{__('common.Update')}}');
                        $("#serviceBtn").prop('disabled', false);
                    }
                });
            });


        });

        function sectionControl(id) {

            $('#page_title').text($("#"+id).text())
            let url = "/footer/footer-setting/tab/" + id;
            $.ajax({
                url: url,
                type: "GET",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {

                },
                error: function (response) {

                }
            });
        }


        function statusChange(id, status) {
            let demoMode = $('#demoMode').val();
            if (demoMode == 1) {
                toastr.warning("For the demo version, you cannot change this", "Warning");
                return false;
            }
            var formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('id', id);
            formData.append('status', status);
            $.ajax({
                url: "{{ route('footerSetting.footer.widget-status') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    toastr.success('{{trans('common.Operation successful')}}')
                },
                error: function (response) {
                    toastr.error('{{trans('common.Something Went Wrong')}}')

                }
            });
        }

        function showEditModal(page) {
            let demoMode = $('#demoMode').val();
            if (demoMode == 1) {
                toastr.warning("For the demo version, you cannot change this", "Warning");
                return false;
            }
            $('#editModal').modal('show');
            @foreach ($LanguageList as $key => $language)
            $('#widget_name_edit_{{$language->code}}').val(page.name.{{$language->code}}).addClass('has-content');
            @endforeach
            $("#widget_description").summernote("code", page.description);
            $('#widgetEditId').val(page.id);
            $("#editCategory").val(page.category);
            $("#editPage").val(page.slug);
            $("#custom_link").val(page.custom_link);
            $('#editCategory').niceSelect('update');
            $('#editPage').niceSelect('update');


            if (page.is_static == 1) {
                // $('#editPageFieldDiv').css("display", "none");
                $('#editCategoryFieldDiv').removeClass("col-lg-12").addClass("col-lg-12");
            } else {
                // $('#editPageFieldDiv').css("display", "inherit");
                $('#editCategoryFieldDiv').removeClass("col-lg-12").addClass("col-lg-12");
            }
            if (page.custom == 1) {
                $(".editCustom[value=" + 1 + "]").prop('checked', true);
                $(".editCustom[value=" + 0 + "]").prop('checked', false);
                $('#editPageFieldDiv').css('display', 'none');
                $('#editCustomFieldDiv').css('display', 'block');
            } else {
                $(".editCustom[value=" + 1 + "]").prop('checked', false);
                $(".editCustom[value=" + 0 + "]").prop('checked', true);
                $('#editPageFieldDiv').css('display', 'block');
                $('#editCustomFieldDiv').css('display', 'none');

            }

        }

        function showDeleteModal(id) {
            let demoMode = $('#demoMode').val();
            if (demoMode == 1) {
                toastr.warning("For the demo version, you cannot change this", "Warning");
                return false;
            }
            $('#deleteItemModal').modal('show');
            let route = '{{url('/')}}/footer/footer-widget-delete/' + id
            $('#deleteBtn').attr('href', route)
        }

        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1,]);

        let table = $('.Crm_table_active3').DataTable(dataTableOptions);

    </script>
@endpush

