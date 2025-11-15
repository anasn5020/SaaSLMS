@extends('backend.master')
@php
    $table_name='categories';
@endphp
@section('table')
    {{$table_name}}
@endsection

<style>
    .unread_notification {
        font-weight: bold;
    }

    .notifi_par {
        font-weight: bold;
    }

    .notify_normal {
        color: var(--system_secendory_color);
    }
</style>
@section('mainContent')

    {!! generateBreadcrumb() !!}
    <section class="mt-20 admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">

                    <div class="  QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->


                            <div class="">
                                <table class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th>{{__('frontendmanage.Notification')}}</th>
                                        <th>{{__('common.Date')}}</th>
                                        <th>{{__('common.Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach(Auth::user()->notifications as $notification)
                                        <tr>
                                            <td>
                                                @if ($notification->read_at==null)
                                                    <a href="#" class="unread_notification" id="{{$notification->id}}"
                                                       title="Mark As Read"
                                                       data-notification_id="{{$notification->id}}">
                                                        <h4 class="notifi_par notify_{{$notification->id}}">
                                                            {{@$notification->data['title']}}
                                                        </h4>
                                                        <p class="notifi_par notify_{{$notification->id}}">
                                                            {!! @$notification->data['body']!!}
                                                        </p>
                                                    </a>
                                                @else
                                                    <b>{{@$notification->data['title']}}</b>
                                                    <p>{!! @$notification->data['body']!!}</p>
                                                @endif


                                            </td>
                                            <td>
                                                {{showDate($notification->created_at)}}
                                            </td>
                                            <td>
                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu1{{@$notification->id}}"
                                                            data-bs-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        {{ __('common.Select') }}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenu1{{@$notification->id}}">
                                                        @if(!empty($notification->data['actionText']??''))
                                                            <a class="dropdown-item edit_brand"
                                                               href="{{@$notification->data['actionURL']??''}}">{{@$notification->data['actionText']??''}}</a>
                                                        @endif

                                                        <a onclick="confirm_modal('{{routeIsExist('notificationDelete')?route('notificationDelete', $notification->id):''}}');"
                                                           class="dropdown-item edit_brand">{{__('common.Delete')}}</a>

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
        </div>
    </section>


    <input type="hidden" name="status_route" class="status_route" value="{{ route('course.category.status_update') }}">
    @include('backend.partials.delete_modal')
@endsection
@push('scripts')
    <script src="{{asset('public/backend/js/category.js')}}"></script>
@endpush
