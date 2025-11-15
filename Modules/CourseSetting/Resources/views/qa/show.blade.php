@php use Illuminate\Support\Facades\Auth; @endphp
@extends('backend.master')

@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row justify-content-center mt-0">

                <div class="col-lg-12">
                    <div class="white_box_30px">
                        <div class="row">
                            <div class="col-12">
                                <div class="tickets_view_lists mb-20">
                                    <div class="single_tks_view_list ">
                                        <div class="tkt_owner d-flex align-items-center mb-20 justify-content-between">
                                            <div>
                                                <div class="thumb mb-3">
                                                    <img
                                                        src="{{getProfileImage($question->user->image,$question->user->name)}}"
                                                        alt="">
                                                </div>
                                                <div class="tkt_owner_name">
                                                    <h4>{{@$question->user->name}}</h4>
                                                    <p>{{showDate($question->created_at)}}</p>
                                                </div>
                                            </div>
                                            <div class="table_btn_wrap">
                                                <ul>
                                                    <li>
                                                        <div class="dropdown CRM_dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle"
                                                                    type="button"
                                                                    id="dropdownMenu2"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                {{__('common.Action')}}
                                                            </button>
                                                            <div
                                                                class="dropdown-menu dropdown-menu-right action_dropdown_right"
                                                                aria-labelledby="dropdownMenu2"
                                                                x-placement="bottom-end">
                                                                @if(permissionCheck('qa.questions.edit'))
                                                                    <a class="dropdown-item"
                                                                       href="{{ route('qa.questions.edit',$question->id)}}">{{__('common.Edit')}}</a>
                                                                @endif
                                                                @if(permissionCheck('qa.questions.delete'))
                                                                    <a class="dropdown-item  "
                                                                       href="{{ route('qa.questions.delete',$question->id)}}">{{__('common.Delete')}}</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        {!! $question->text !!}

                                    </div>


                                    <div class="comments_checklisted ">
                                        @foreach($question->child as $key => $message)

                                            <div class="">
                                                <div class="single_list  ">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <div class="thumb list_name">
                                                                <a href="#"><img
                                                                        src="{{getProfileImage($message->user->image,$message->user->name)}}"
                                                                        alt=""></a>
                                                            </div>
                                                            <div class="list_name">
                                                                <h4><a href="#">{{ $message->user->name }} </a>
                                                                    <span>{{$message->created_at->diffForHumans()}}</span>
                                                                </h4>

                                                            </div>
                                                        </div>

                                                        <div class="table_btn_wrap">
                                                            <ul>
                                                                <li>
                                                                    <div class="dropdown CRM_dropdown">
                                                                        <button
                                                                            class="btn btn-secondary dropdown-toggle"
                                                                            type="button"
                                                                            id="dropdownMenu2"
                                                                            data-bs-toggle="dropdown"
                                                                            aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            {{__('common.Action')}}
                                                                        </button>
                                                                        <div
                                                                            class="dropdown-menu dropdown-menu-right action_dropdown_right"
                                                                            aria-labelledby="dropdownMenu2"
                                                                            x-placement="bottom-end">
                                                                            @if(permissionCheck('qa.questions.edit'))
                                                                                <a class="dropdown-item"
                                                                                   href="{{ route('qa.questions.edit',$message->id)}}">{{__('common.Edit')}}</a>
                                                                            @endif
                                                                            @if(permissionCheck('qa.questions.delete'))
                                                                                <a class="dropdown-item  "
                                                                                   href="{{ route('qa.questions.delete',$message->id)}}">{{__('common.Delete')}}</a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <div class="list_name">
                                                        {!! $message->text !!}
                                                    </div>
                                                </div>

                                            </div>

                                        @endforeach

                                        <div id="new_answer">

                                        </div>


                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                @if($typing)
                                    <div id="user_list text-center" class="">
                                        <h3 class="text-center">{{$typing->name}} is typing</h3>
                                    </div>
                                @else
                                    <div id="replyForm" class="">
                                        <form action="{{ route('qa.questions.reply',$question->id) }}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12  mb-30">
                                                    <label class="primary_input_label"
                                                           for="">{{ __('courses.Text') }}*</label>
                                                    <textarea name="text" id=""
                                                              class="lms_summernote">{{ old('text') }}</textarea>
                                                </div>


                                                <div class="col-12 text-center">
                                                    <div class="submit_button mt-25">
                                                        <button type="submit" id="submitReply"
                                                                class="primary-btn semi_large2  fix-gr-bg "
                                                                type="button">{{__('courses.Reply')}}</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>

                            </div>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                </div>

            </div>


        </div>
    </section>
    {{--    @include('backend.partials.delete_modal')--}}
@endsection
@push('scripts')

    <input type="hidden" class="notification_channel" value="question-answer-channel">
    <script src="{{asset('public/js/pusher.min.js')}}"></script>
    <script>

        // Pusher.logToConsole = true;
        let typing = {{$typing?1:0}};
        let pusher = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {
            cluster: '{{config('broadcasting.connections.pusher.options.cluster')}}'
        });
        let channel = pusher.subscribe('question-answer-channel');
        channel.bind('new-question-answer{{$question->id}}', function (data) {

            let single = `  <div class="single_list d-flex">
                                <div class="thumb">
                                    <a href="#"><img src="${data.question.img}"  alt=""></a>
                                </div>
                                <div class="list_name">
                                    <h4>
                                        <a href="#">${data.question.name} </a>
                                        <span>${data.question.date}</span>
                                    </h4>
                                        ${data.question.text}
                            </div>
                        </div>`;

            $('#new_answer').append(single)


        });


        channel.bind('pusher:subscription_succeeded', function (data) {
            console.log('ok');
            // console.log(data)

        });

        function makeOnline() {
            if (typing != 1) {
                $.ajax({
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: "{{Auth::id()}}",
                        question_id: "{{$question->id}}",
                    },
                    url: "{{route('qa.checkOnline')}}",
                    success: function (data) {
                        typing = 1;
                    }
                });
            }
        }

        $(document).ready(function () {
            // exitByAjax();
            // $('.lms_summernote').on('summernote.keydown', function () {
            makeOnline();

            // });

            $('.lms_summernote').on('summernote.keydown', function () {
                makeOnline();
            });

        });


        //document on click
        $(document).on('click', '#submitReply, .dropdown-item', function () {
            typing = 0;
        });

        // $(document).ready(function () {
        //     $('.lms_summernote').on('summernote.init', function () {
        //         $(this).summernote('focus');
        //     });
        //
        // });

        $(document).ready(function () {
            $('.lms_summernote').summernote('focus');
        });


        // $(window).on("pagehide", function () {
        //     exitByAjax();
        // });
        //
        // // Fallback to beforeunload
        // $(window).on("beforeunload", function () {
        //     exitByAjax();
        // });

        $(window).on("unload", function () {
            exitByAjax();
        });

        function exitByAjax() {
            if (typing != 1) {
                return;
            }
            let user_id = "{{ \auth()->id() }}";
            let question_id = "{{ $question->id }}";
            const csrfToken = "{{ csrf_token() }}"; // Get CSRF token

            const url = `{{ route('qa.exitOnline') }}?user_id=${user_id}&question_id=${question_id}`;
            console.log(url)
            if (navigator.sendBeacon) {
                 navigator.sendBeacon(url);
                console.log("Beacon sent successfully.");
            } else {
                // Fallback to synchronous AJAX (POST request)
                $.ajax({
                    url: url,
                    type: "POST",
                    async: false, // Ensures the request completes before the page unloads
                    data: {
                        user_id: user_id,
                        question_id: question_id,
                        _token: csrfToken // CSRF token for Laravel
                    },
                    success: function () {
                        console.log("Synchronous AJAX POST request sent.");
                    },
                    error: function () {
                        console.error("Error with synchronous AJAX POST request.");
                    },
                });
            }
        }




    </script>

@endpush
