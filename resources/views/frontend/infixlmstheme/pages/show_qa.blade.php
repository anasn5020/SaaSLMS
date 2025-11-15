@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('frontend.Question')}}
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/css/support.css')}}{{assetVersion()}}">

    <link href="{{asset('public/backend/css/summernote-bs5.min.css/')}}{{assetVersion()}}" rel="stylesheet">

@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <script src="{{asset('public/backend/js/summernote-bs5.min.js')}}{{assetVersion()}}"></script>
    <script>
        $(document).ready(function () {
            $('.lms_summernote').summernote({

                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen']],
                ],
                placeholder: 'Answer',
                tabsize: 2,
                height: 188,
                tooltip: false,
                callbacks: {
                    onImageUpload: function (files) {
                        sendFile(files, '.lms_summernote', $(this).attr('name'))
                    }
                }
            });


        });
        $(document).ready(function () {
            $('.note-toolbar').find('[data-toggle]').each(function () {
                $(this).attr('data-bs-toggle', $(this).attr('data-toggle')).removeAttr('data-toggle');
            });
        });
        $(document).ready(function () {
            $('.note-modal').find('[data-dismiss]').each(function () {
                $(this).attr('data-bs-dismiss', $(this).attr('data-dismiss')).removeAttr('data-dismiss');
            });
        });

        function sendFile(files, editor = '#summernote', name) {
            let url = '{{url('/')}}';
            let formData = new FormData();
            $.each(files, function (i, v) {
                formData.append("files[" + i + "]", v);
            })

            $.ajax({
                url: url + '/summer-note-file-upload',
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function (response) {
                    let $summernote;
                    if (name) {
                        $summernote = $(editor + "[name='" + name + "']");
                    } else {
                        $summernote = $(editor);
                    }
                    $.each(response, function (i, v) {
                        $summernote.summernote('insertImage', v);
                    })
                },
                error: function (data) {
                    if (data.status === 404) {
                        toastr.error("What you are looking is not found", 'Opps!');
                        return;
                    } else if (data.status === 500) {
                        toastr.error('Something went wrong. If you are seeing this message multiple times, please contact administrator.', 'Opps');
                        return;
                    } else if (data.status === 200) {
                        toastr.error('Something is not right', 'Error');
                        return;
                    }
                    let jsonValue = $.parseJSON(data.responseText);
                    let errors = jsonValue.errors;
                    if (errors) {
                        let i = 0;
                        $.each(errors, function (key, value) {
                            let first_item = Object.keys(errors)[i];
                            let error_el_id = $('#' + first_item);
                            if (error_el_id.length > 0) {
                                error_el_id.parsley().addError('ajax', {
                                    message: value, updateClass: true
                                });
                            }
                            toastr.error(value, 'Validation Error');
                            i++;
                        });
                    } else {
                        toastr.error(jsonValue.message, 'Opps!');
                    }

                }
            });
        }

    </script>
    <script src="{{asset('public/js/pusher.min.js')}}"></script>
    <script>
        Pusher.logToConsole = false;
        let pusher = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {
            cluster: '{{config('broadcasting.connections.pusher.options.cluster')}}'
        });


        let channel = pusher.subscribe('question-answer-channel');
        channel.bind('new-question-answer{{$question->id}}', function (data) {


            let single = `      <div class="support_main_details_info_comments_tkr">
                                        <div class="d-flex mb_10">
                                            <div id="user_img">
                                                <img
                                                    src="${data.question.img}"
                                                    alt="">
                                            </div>
                                            <div id="user_content">
                                                <h6 class='d-flex align-items-center gap-3'>${data.question.name}
            <span>${data.question.date}</span>
                                                </h6>
                                                <p>  ${data.question.text}</p>
                                            </div>
                                        </div>

                                    </div>`;

            $('#new_answer').append(single)

        });

        let channel2 = pusher.subscribe('new-notification-channel');

        channel2.bind('new-notification', function (data) {
            $.ajax({
                url: '{{route('getNotificationUpdate')}}',
                method: 'GET',
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    console.log(response.notification_body);
                    $('.notify_count').removeClass('d-none')
                    $('.notification_body').html(response.notification_body);
                },
                error: function (response) {
                }
            });

        });

    </script>
@endsection

@section('mainContent')
    <div class="main_content_iner main_content_padding">
        <div class="dashboard_lg_card">
            <div class="container-fluid g-0">
                <div class="my_courses_wrapper">


                    <div class="row mb-5">
                        <div class="support_main_details_info">
                            <div class="support_main_details_info_list">
                                <div class="support_main_details_info_list_owner d-flex align-items-center">
                                    <div id="user_img">
                                        <img
                                            src="{{getProfileImage($question->user->image,$question->user->name)}}"
                                            alt="">
                                    </div>
                                    <div id="user_content">
                                        <h6>{{@$question->user->name}}</h6>
                                        <span>{{showDate($question->created_at)}}</span>
                                    </div>
                                </div>
                                <p>{!! $question->text !!}</p>
                            </div>
                            <div class="support_main_details_info_comments">
                                @foreach($question->child as $key => $message)
                                    <div class="support_main_details_info_comments_tkr">
                                        <div class="d-flex mb_10">
                                            <div id="user_img">
                                                <img
                                                    src="{{getProfileImage($message->user->image,$message->user->name)}}"
                                                    alt="">
                                            </div>
                                            <div id="user_content">
                                                <h6 class='d-flex align-items-center flex-wrap column-gap-3 row-gap-1 mb-3'>{{ $message->user->name }}
                                                    <span>{{$message->created_at->diffForHumans()}}</span>
                                                </h6>
                                                <p>   {!! $message->text !!}</p>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                                <div id="new_answer">

                                </div>
                            </div>
                            <form action="{{ route('myQA.store') }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{$question->id}}">
                                <input type="hidden" name="course_id" value="{{$question->course_id}}">
                                <input type="hidden" name="lesson_id" value="{{$question->lesson_id}}">
                                <div class="support_main_details_info_textarea">
                                    <label for="" class="fw-bold">{{__('ticket.Reply')}} <span
                                            class=" text-danger"> * </span></label>
                                    <textarea class='primary_input editor lms_summernote' name="text" id=""
                                              cols="30"
                                              rows="10"
                                              placeholder='Add your replay'></textarea>
                                </div>
                                <div
                                    class="col-xl-12 mt-5">
                                    <div class="support_main_details_info_actons">
                                        <button type="submit"
                                                class="theme_btn">{{__('ticket.Reply')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
