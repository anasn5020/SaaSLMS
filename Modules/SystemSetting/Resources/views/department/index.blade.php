@extends('backend.master')
@section('mainContent')

    {!! generateBreadcrumb() !!}


    <section class="admin-visitor-area up_st_admin_visitor">

        @include('systemsetting::department.components.create')
        @include('backend.partials._deleteModalForAjax',['item_name' => 'Department'])

        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px" id="page_title">{{ __('leave.Department') }} {{ __('common.List')  }}</h3>
                                <ul class="d-flex">
                                    <li>
                                        <button class="primary-btn radius_30px   fix-gr-bg"
                                                onclick="createModalShow()"><i
                                                class="ti-plus"></i>{{ __('common.Add New') }} {{ __('leave.Department') }}
                                        </button>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table">
                                <div class="" id="item_table">
                                    @include('systemsetting::department.components.list')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection


@push('scripts')

    <script>
        var baseUrl = $('#app_base_url').val();

        $(document).ready(function () {

            $('#item_create_form').on('submit', function (event) {
                event.preventDefault();
                let formData = new FormData(this);
                let url = '';

                if (formData.get('id') == '') {
                    url = "{{ route('hr.department.store')}}";
                } else {
                    url = "{{ route('hr.department.update')}}";
                }

                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: url,
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            resetAfterChange(response.TableData)
                            toastr.success(response.success)
                            $('#item_add').modal('hide');
                        } else {
                            toastr.error(response.error);
                        }
                    },
                    error: function (response) {
                        showValidationErrors('.item_create_form', response.responseJSON.errors);
                    }
                });
            });
            $('#deleteItemModal').on('submit', function (event) {
                event.preventDefault();
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#delete_item_id').val());
                $.ajax({
                    url: "{{ route('hr.department.delete')}}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            resetAfterChange(response.TableData);
                            toastr.success(response.success);
                            $('#deleteItemModal').modal('hide');
                        } else {
                            toastr.error(response.error);
                        }
                    },
                });
            });

        });

        function createModalShow() {
            $('#item_add').modal('show');
            $('.modal-title span').text('{{ trans('common.Add New') }}');
            resetForm();
        }

        function showValidationErrors(formType, errors) {
            $(formType + ' #name_error').text(errors.name);
        }

        function showDeleteModal(imteId) {
            $('#delete_item_id').val(imteId);
            $('#deleteItemModal').modal('show');
        }

        function editItem(item) {
            $('#item_add').modal('show');
            $('.modal-title span').text('{{ trans('common.Edit') }}');
            $('#item_id').val(item.id);
            $("#name").val(item.name);
            $("#details").val(item.details);
            if (item.status == 1) {
                $('#status_active').prop("checked", true);
                $('#status_inactive').prop("checked", false);
            } else {
                $('#status_active').prop("checked", false);
                $('#status_inactive').prop("checked", true);
            }
        }

        function resetForm() {
            $('#item_id').val('');

            $('form')[0].reset();
            $('#name_error').text('');
            $('#name').val('');
            $('#user_id').niceSelect('update')
            $('#user_id').val('');
            $('#details').val('');
            $('#status_active').prop("checked", true);
            $('button[type="submit"]').removeAttr('disabled');
            $('button[type="submit"]').find('i').removeClass('fa-spinner fa-spin')
        }

        function resetAfterChange(tableData) {
            $('#item_table').empty().html(tableData);
            datatableReload()
            resetForm();
        }


        function datatableReload() {
            dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3]);

            $('.Crm_table_active3').DataTable(dataTableOptions);

            $('.dataTables_length label select').niceSelect();
            $('.dataTables_length label .nice-select').addClass('dataTable_select');
        }
    </script>

@endpush
