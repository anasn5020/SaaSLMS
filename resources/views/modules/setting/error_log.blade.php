@extends('backend.master')

@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px" id="page_title">{{__('setting.Error Log')}}</h3>

                                <ul class="d-flex">
                                    <li><a class="primary-btn radius_30px fix-gr-bg" href="#" data-bs-toggle="modal"
                                           id="emptyTable"
                                           data-bs-target="#emptyTableModel"><i
                                                class="ti-trash"></i>{{__('setting.Empty Table')}}</a></li>
                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="">
                                    <table id="lms_table" class="table Crm_table_active3">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{__('common.SL')}}</th>
                                            <th scope="col">{{__('common.Description')}}</th>
                                            <th scope="col">{{__('common.URL')}}</th>
                                            <th scope="col">{{__('setting.IP')}}</th>
                                            <th scope="col">{{__('setting.Agent')}}</th>
                                            <th scope="col">{{__('setting.Attempted At')}}</th>
                                            <th scope="col">{{__('setting.User')}}</th>
                                            <th scope="col">{{__('common.Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade admin-query" id="deleteError_log">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">{{__('common.Delete')}} {{__('setting.Error Log')}} </h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                            class="ti-close "></i></button>
                                </div>

                                <div class="modal-body">
                                    <form action="{{route('setting.error_log.delete')}}" method="post">
                                        @csrf

                                        <div class="text-center">

                                            <h4>{{__('common.Are you sure to delete ?')}} </h4>
                                        </div>
                                        <input type="hidden" name="id" value="" id="error_logDeleteId">
                                        <div class="mt-40 d-flex justify-content-between">
                                            <button type="button" class="primary-btn tr-bg"
                                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                                            <button class="primary-btn fix-gr-bg"
                                                    type="submit">{{__('common.Delete')}}</button>

                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>



    <div class="modal fade admin-query" id="emptyTableModel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">  {{__('setting.Empty Table')}} </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('setting.error_log.empty')}}" method="post">
                        @csrf

                        <div class="text-center">

                            <h4>{{__('common.Are you sure to delete ?')}} </h4>
                        </div>

                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                            <button class="primary-btn fix-gr-bg"
                                    type="submit">{{__('setting.Empty')}}</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')

    @if ($errors->any())
        <script>
            @if(Session::has('type'))
            @if(Session::get('type')=="store")
            $('#add_error_log').modal('show');
            @else
            $('#editError_log').modal('show');
            @endif
            @endif
        </script>
    @endif


    @php
        $url = route('setting.getAllErrorLogData');
    @endphp

    <script>
        dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        dataTableOptions.ajax = {
            url: '{!! $url !!}',
            data: function (d) {
                d.bonus_for = $("#bonus_for").val();
                d.start_date = $("#start_date").val();
                d.end_date = $("#end_date").val();

            }
        };

        dataTableOptions.columns = [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'subject', name: 'subject'},
            {data: 'url', name: 'url'},
            {data: 'ip', name: 'ip'},
            {data: 'agent', name: 'agent'},
            {data: 'created_at', name: 'created_at'},
            {data: 'user', name: 'user.name'},
            {data: 'action', name: 'action'},
        ]
        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4, 5, 6 ]);

        let table = $('#lms_table').DataTable(dataTableOptions);


        $(document).on('click', '.deleteError_log', function () {
            let id = $(this).data('id');
            $('#error_logDeleteId').val(id);
            $("#deleteError_log").modal('show');
        });

    </script>

@endpush
