@extends('setting::layouts.master')

@section('mainContent')
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <h4 class="ps-4 mb-3">Missing Migration</h4>
            <div class="col-lg-12">
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table ">
                        <!-- table-responsive -->
                        <div class="">
                            <table id="lms_table" class="table Crm_table_active3">
                                <thead>
                                <tr>
                                    <th scope="col">{{__('common.SL')}} </th>
                                    <th scope="col"> File</th>

                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach($pendingMigrations as $key=>$migration)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$key}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
                    <div class="col-auto">
                        <div class="submit_btn text-center mt-4">
                            <button class="primary_btn_large confirmBtn" type="submit" data-bs-toggle="tooltip"
                                    id="general_info_sbmt_btn"><i class="ti-check"></i>
                                Migration All missing File
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>


    </section>


    <div class="modal fade admin-query" id="confirmModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.Confirm')}}   </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('setting.migration')}}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="title">{{__('common.Enter Password')}} <span
                                            class="text-danger">*</span></label>
                                    <input required type="password" id="password"
                                           class="primary_input_field" name="password" autocomplete="new-password"
                                           value="" placeholder="{{__('common.Enter Password')}} ">

                                </div>
                            </div>
                        </div>

                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                            <button class="primary-btn fix-gr-bg"
                                    type="submit">{{__('common.Confirm')}}</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).on('click', '.confirmBtn', function () {
            $("#confirmModal").modal('show');
        })
    </script>
@endpush
