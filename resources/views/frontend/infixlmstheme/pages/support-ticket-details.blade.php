@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('ticket.support_ticket')}}
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/css/support.css')}}{{assetVersion()}}">
@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/support.js')}}"></script>

@endsection

@section('mainContent')
    <div class="main_content_iner main_content_padding">

        <div class="container-fluid g-0">

            <div class="p-4">
                <div class="support_main_card_title">
                    <h5> {{$SupportTicket->reference_no}} - {{$SupportTicket->subject}}</h5>
                    <div class="support_main_card_title_dropdown" aria-expanded='false'>
                                <span class="current text-uppercase"> {{__('common.Action')}}<i
                                        class='ti ti-arrow-down'></i></span>
                        <ul class='text-end'>
                            <li>
                                <a href="{{route('student.support-ticket.edit',$SupportTicket->id)}}">{{__('common.Edit')}}</a>
                            </li>
                            <li><a href="#" onclick="deleteTicket({{$SupportTicket->id}})"
                                   data-id="{{$SupportTicket->id}}">{{__('common.Delete')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="support_main_details">
                    <div class="row">
                        <div class="col-xxl-4 col-xl-4 col-lg-5">
                            <div class="support_main_details_sidebar">
                                <div class="support_main_details_sidebar_card">
                                    <h5>{{__('ticket.ticket_info')}}</h5>
                                    <table>
                                        <tr>
                                            <td>{{__('ticket.ticket_id')}}:</td>
                                            <td>  {{$SupportTicket->reference_no }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('ticket.subject')}}:</td>
                                            <td> {{$SupportTicket->subject}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('ticket.priority')}}:</td>
                                            <td> {{@$SupportTicket->priority->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('common.Category')}}:</td>
                                            <td>{{@$SupportTicket->category->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('common.Status')}}:</td>
                                            <td> {{@$SupportTicket->status->name}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-nowrap">{{__('common.Submit')}} {{__('common.Date')}}:</td>
                                            <td>  {{showDate($SupportTicket->created_at)}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('ticket.assign_to')}}:</td>
                                            <td> {{@$SupportTicket->assignUser->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('ticket.last_update')}}:</td>
                                            <td>{{$SupportTicket->updated_at->diffForHumans()}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="support_main_details_sidebar_card">
                                    <h5>{{__('ticket.attachment')}}</h5>
                                    <ul>
                                        @if ($SupportTicket->attachFiles->count() > 0)
                                            @foreach($SupportTicket->attachFiles as $key => $file)
                                                <li>
                                                    <a target="_blank" class="  pt-15"
                                                       href="{{route('ticket.attach_file_view','tf-'.encrypt($file->id))}}"> {{  $key+1 }}
                                                        .
                                                        {{ strlen($file->name) > 20 ? substr($file->name, 0,20) . '...' . $file->type : $file->name }}</a>

                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-8 col-xl-8 col-lg-7">
                            <div class="support_main_details_info">
                                <div class="support_main_details_info_list">
                                    <div class="support_main_details_info_list_owner d-flex align-items-center">
                                        <div id="user_img">
                                            <img
                                                src="{{getProfileImage($SupportTicket->user->image,$SupportTicket->user->name)}}"
                                                alt="">
                                        </div>
                                        <div id="user_content">
                                            <h6>{{@$SupportTicket->user->name}}</h6>
                                            <span>{{showDate($SupportTicket->created_at)}}</span>
                                        </div>
                                    </div>
                                    <p>{!! $SupportTicket->description !!}</p>
                                </div>
                                <div class="support_main_details_info_comments">
                                    @foreach($SupportTicket->messages as $key => $message)
                                        <div class="support_main_details_info_comments_tkr">
                                            <div class="d-flex mb_10">
                                                <div id="user_img">
                                                    <img
                                                        src="{{getProfileImage($message->user->image,$message->user->name)}}"
                                                        alt="">
                                                </div>
                                                <div id="user_content">
                                                    <h6 class='d-flex align-items-center'>{{ $message->user->name }}
                                                        <span>{{$message->created_at->diffForHumans()}}</span>
                                                    </h6>
                                                    <p>   {!! $message->text !!}</p>
                                                </div>
                                            </div>
                                            <div class="msg_attach_file_list d-block">
                                                <ul>

                                                    @if ($message->attachMsgFile->count() > 0)
                                                        @foreach($message->attachMsgFile as $key => $file)
                                                            <li>
                                                                <a target="_blank"
                                                                   href="{{route('ticket.attach_file_view','tmf-'.encrypt($file->id))}}">{{  $key+1 }}
                                                                    .
                                                                    {{ strlen($file->name) > 20 ? substr($file->name, 0,20) . '...' . $file->type : $file->name }}</a>
                                                            </li>
                                                        @endforeach
                                                    @endif

                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <form action="{{ route('student.ticket.message') }}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="ticket_id" value="{{$SupportTicket->id}}">
                                    <input type="hidden" name="type" value="1"/>
                                    <div class="support_main_details_info_textarea">
                                        <label for="" class="fw-bold">{{__('ticket.Reply')}} <span
                                                class=" text-danger"> * </span></label>
                                        <textarea class='primary_input editor' name="text" id="" cols="30"
                                                  rows="10"
                                                  placeholder='Add your replay'></textarea>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-xl-7 col-lg-12 col-md-7">
                                            <div class="all_attach">
                                                <div class="row attach-item support_main_file">
                                                    <div class="col-11">
                                                        <div class="support_main_card_content_item">
                                                            <label for="#"
                                                                   class='primary_label2'>{{ __('ticket.attach_file') }}</label>
                                                            <div
                                                                class="position-relative primary_file_uploader">
                                                                <input type="text"
                                                                       class="primary_input filePlaceholder"
                                                                       placeholder='{{ __('ticket.attach_file') }}'
                                                                       readonly>
                                                                <button type='button' class='theme_btn'
                                                                        id='file-upload'>
                                                                    <label
                                                                        for="ticket_file">{{__('common.Browse')}}</label>
                                                                    <input type="file" name="ticket_file[]"
                                                                           class='d-none fileUpload'
                                                                           id="ticket_file">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-1 text-end">
                                                        <button type="button" class="theme_btn action" id=''><i
                                                                class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="col-xl-5 col-lg-12 col-md-5 text-end mobile-center mt-md-5">
                                            <div class="support_main_details_info_actons">
                                                <button type="submit"
                                                        class="theme_btn">{{__('ticket.reply_ticket')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        <div class="modal fade " id="deleteItem" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <form name="bank_payment"
                          action="{{route('student.tickets.destroy')}}"
                          class="single_account-form" method="POST">
                        <input type="hidden" id="dataId" name="id">

                        <div class="modal-body">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="modal-header ps-0">
                                        <h5 class="modal-title" id="">{{__('common.Are you sure to delete ?')}} </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class=" theme_line_btn  btn-sm  small_btn2 "
                                    data-bs-dismiss="modal">@lang('common.Cancel')</button>
                            <button class="  theme_btn  btn-sm  small_btn2"
                                    type="submit">@lang('common.Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

@endsection
