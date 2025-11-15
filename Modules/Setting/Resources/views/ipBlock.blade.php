@extends('setting::layouts.master')

@section('mainContent')
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor white-box">
        <div class="container-fluid p-0">

            <div class="row">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px" id="page_title">{{__('setting.IP Block')}}  {{__('courses.List')}}</h3>
                            <a class="primary-btn radius_30px   fix-gr-bg"
                               data-bs-toggle="modal"
                               data-bs-target="#add_new_ip" href="#">
                                <i class="ti-plus"></i>
                                {{ __('setting.Add IP') }}
                            </a>
                         </div>

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
                                    <th scope="col">{{__('common.SL')}} </th>
                                    <th scope="col"> {{__('common.Name')}} </th>
                                    <th scope="col">{{__('dashboard.Subjects')}}</th>
                                    {{--                                    <th scope="col">{{__('common.Status')}}</th>--}}
                                    <th scope="col">{{__('common.Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($ips as $key=> $ip)

                                    <tr>

                                        <th>{{$key+1}}</th>
                                        <td class="nowrap">{{@$ip->ip_address}}</td>
                                        <td class="nowrap">{{@$ip->reason}}</td>

                                        <td>


                                            <div class="dropdown CRM_dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenu2" data-bs-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false">
                                                    {{__('common.Action')}}
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                     aria-labelledby="dropdownMenu2">
                                                    <a class="dropdown-item delete_block_ip"
                                                       data-id="{{$ip->id}}"
                                                       type="button"
                                                       type="button">{{__('common.Delete')}} </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>


    <div class="modal fade admin-query" id="delete_block_ip">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.Delete')}}   </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('ipBlockDelete')}}" method="post">
                        @csrf

                        <div class="text-center">

                            <h4>{{__('common.Are you sure to delete ?')}} </h4>
                        </div>
                        <input type="hidden" name="id" value="" id="ipDeleteId">
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

    <div class="modal fade admin-query" id="add_new_ip">
        <div class="modal-dialog modal_1000px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('setting.Add IP')}}</h4>
                    <button type="button" class="close " data-bs-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="{{route('ipBlock.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{__('setting.IP Address')}} <strong
                                            class="text-danger">*</strong></label>
                                    <input class="primary_input_field" id="ipAddress"

                                           name="ip_address" placeholder="000.000.000.000"
                                           type="text" required
                                           value="{{ old('ip_address') }}" {{$errors->first('ip_address') ? 'autofocus' : ''}}>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{__('setting.Block Reason')}} </label>
                                    <input class="primary_input_field" name="reason"
                                           placeholder="Why You want to block this Ip?"
                                           type="text"
                                           value="{{ old('reason') }}" {{$errors->first('reason') ? 'autofocus' : ''}}>
                                </div>
                            </div>


                        </div>

                        <div class="col-lg-12 text-center pt_15">
                            <div class="d-flex justify-content-center">
                                <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"
                                        type="submit"><i
                                        class="ti-check"></i> {{__('common.Save')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).on('click', '.delete_block_ip', function () {

            let id = $(this).data('id');
            $('#ipDeleteId').val(id);
            $("#delete_block_ip").modal('show');
        })

        $('body').ready(function () {

            let btn = $('#save_button_parent');
            btn.attr('disabled', true);
            btn.css('opacity', .5);
            btn.css('cursor', 'not-allowed');


            $(document).on('change, input, keyup', '#ipAddress, .ipAdd', function () {
                ValidateIpAddress($('#ipAddress').val())
            });
        });

        function ValidateIpAddress(ipaddress) {
            let btn = $('#save_button_parent');
            if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ipaddress)) {
                btn.attr('disabled', false);
                btn.css('opacity', 1);
                btn.css('cursor', 'pointer');
                return true;
            }
            btn.attr('disabled', true);
            btn.css('opacity', .5);
            btn.css('cursor', 'not-allowed');
            return false
        }
    </script>
         <script type="application/javascript">


            dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2 ]);

            let table = $('#lms_table').DataTable(dataTableOptions);


        </script>
    @endpush
