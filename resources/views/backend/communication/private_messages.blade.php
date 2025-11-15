@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/communication.css')}}{{assetVersion()}}"/>
@endpush
@section('mainContent')

    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid plr_30">
            <div class="row justify-content-center">
                <div class="col-lg-12 p-0">
                    <div class="messages_box_area">
                        <div class="messages_list">
                            <div class="white_box ">
                                <div class="white_box_tittle list_header main-title mb-0">
                                    <h3 class="main-title">{{__('communication.Message List')}}</h3>
                                </div>
                                <div class="serach_field_2">
                                    <div class="search_inner">
                                        <form active="#">
                                            <div class="search_field">
                                                <input type="text" id="search_input" onkeyup="searchReceiver()"
                                                       placeholder="{{__('communication.Search content here')}}...">
                                            </div>
                                            <button type="submit"><i class="ti-search"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <ul id="receiver_list">
                                    @foreach ($users as $user)
                                        @php
                                            $sentMessage=       $user->sentLastMessages;
                                            $receivedMessage=       $user->receivedLastMessages;
                                            $last_msg=    collect([$sentMessage, $receivedMessage])->sortByDesc('created_at')->first();

                                        @endphp
                                        <li class="{{$user->sentLastMessages?$user->sentLastMessages->seen=='0'?'unseen':'':''}}">
                                            <a href="#" id="user{{$user->id}}" class="user_list"
                                               data-id="{{$user->id}}"
                                               onClick="getMessage({{$user->id}})">
                                                <div class="message_pre_left">
                                                    <div class="message_preview_thumb profile_info">
                                                        <div class="profileThumb"
                                                             style="background-image: url('{{getProfileImage($user->image,$user->name)}}')">

                                                        </div>
                                                    </div>
                                                    <div class="messges_info">
                                                        <h4 id="receiver_name{{$user->id}}">{{$user->name}}</h4>
                                                        <p id="last_mesg{{$user->id}}">{{@$last_msg->message}}</p>
                                                    </div>
                                                </div>
                                                <div class="messge_time">
                                                    <span> {{@$last_msg->messageFormat}} </span>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="messages_chat ">
                            <div class="white_box ">
                                <div class="message_box_heading"><h3
                                        id="receiver_name"></h3></div>
                                <div id="all_massages"></div>

                                <div class="message_send_field">
                                    @if (permissionCheck('communication.send'))
                                        <form action="{{route('communication.StorePrivateMessage')}}" name="submitForm"
                                              id="submitForm" method="POST" style="display: contents;">
                                            @endif
                                            @csrf
                                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                            <input type="hidden" name="reciever_id" id="reciever_id"
                                                   value="">
                                            <input type="text" name="message"
                                                   placeholder="{{__('communication.Write your message')}}" value=""
                                                   id="message">

                                            <button class="btn_1 submitMessageBtn" type="submit" id="submitMessage"
                                                    data-bs-toggle="tooltip"
                                            >{{__('common.Send')}}</button>
                                        </form>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" name="store_message" class="store_message"
           value="{{route('communication.StorePrivateMessage')}}">
    <input type="hidden" name="get_messages" class="get_messages"
           value="{{route('communication.getMessage')}}">

@endsection
@push('scripts')
    <script src="{{asset('public/backend/js/communication.js')}}{{assetVersion()}}"></script>
@endpush
