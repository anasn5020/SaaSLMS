@extends(theme('layouts.dashboard_master'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'Infix LMS' }} | {{ _trans('gift.My Gifts') }}
@endsection
@section('css')
    <style>
        .modal-dialog {
            max-width: 500px !important;
        }
    </style>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.view_gift_message', function (e) {
                console.log('clicked');
                e.preventDefault();
                var message = $(this).data('message');
                $('#messageModal').modal('show');
                $('#messageModal .modal-body').html(message);
            });
        });
    </script>
@endsection

@section('mainContent')
    <div class="main_content_iner main_content_padding">
        <div class="dashboard_lg_card">
            <div class="container-fluid g-0">
                <div class="row">
                    <div class="col-12">
                        <div class="p-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section__title3 mb_40">
                                        <h3 class="mb-0">{{ _trans('gift.Gift history') }}</h3>
                                        <h4></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table custom_table3">
                                            <thead>
                                            <tr>
                                                <td>
                                                    {{ _trans('common.SL') }}
                                                </td>
                                                <td width="30%">
                                                    {{ _trans('gift.Product') }}
                                                </td>
                                                <td>
                                                    {{ _trans('gift.Gift At') }}
                                                </td>
                                                <td>
                                                    {{ _trans('gift.Gift From') }}
                                                </td>
                                                <td>
                                                    {{ _trans('gift.Gift To') }}
                                                </td>

                                                <td>
                                                    {{ _trans('gift.Gift Status') }}
                                                </td>
                                                <td>
                                                    {{ _trans('gift.Gift Message') }}
                                                </td>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse ($gift_records as $gift_record)
                                                @php
                                                    if(Auth::user()->id == $gift_record->gift_receiver_id && $gift_record->gift_status != 4){
                                                        continue;
                                                    }
                                                @endphp

                                                <tr>
                                                    <td>
                                                        {{ @$loop->iteration }}
                                                    </td>
                                                    <td>
                                                        <a target="_blank"
                                                           href="{{ route('courseDetailsView', [$gift_record->course->slug]) }}">{{ @$gift_record->course->title }}</a>

                                                    </td>
                                                    <td>
                                                        {{date('D d M, h:i a',strtotime($gift_record->gift_send_time))}}

                                                    </td>
                                                    <td>
                                                        {{ @$gift_record->sender->name }}
                                                    </td>
                                                    <td>
                                                        {{ @$gift_record->receiver->name }}

                                                    </td>


                                                    <td>
                                                        {{ @$gift_record->status }}
                                                    </td>
                                                    <td>
                                                        <button class="view_gift_message theme_btn small_btn3"
                                                                data-message="{{ @$gift_record->gift_message }}">{{ _trans('common.View') }}
                                                        </button>
                                                    </td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-center" colspan="7">
                                                        {{__('common.No data available in the table')}}
                                                    </td>
                                                </tr>
                                            @endforelse

                                            </tbody>
                                        </table>
                                        <div class="mt-4">
                                            {{ @$gift_records->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade admin-query admin_view_modal" id="messageModal">
        <div class="modal-dialog modal_1000px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4> {{ _trans('gift.View Gift Message') }}</h4>
                    <button type="button" class="close " data-bs-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
