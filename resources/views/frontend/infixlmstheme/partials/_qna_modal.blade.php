<link href="{{asset('public/backend/css/summernote-bs5.min.css')}}{{assetVersion()}}" rel="stylesheet">
<style>
    .cs_modal .modal-body p {
        text-align: unset;
    }
</style>
<div class="modal cs_modala fade" id="qnamodal" tabindex="-1" aria-labelledby="qnamodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qnamodalLabel">{{__('frontend.Question and Answer')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="ti-close "></i></button>
            </div>
            <div class="modal-body">
                <div class="conversition_box" id="qnaList">
                    @foreach($lesson_questions as $qna)
                        @include(theme('partials._single_qna'),['qna'=>$qna])
                    @endforeach
                </div>

                @if ($isEnrolled)
                    <div class="row">
                        <div class="col-lg-12" id="mainComment">
                            <form action="#" method="post">
                                @csrf
                                <input type="hidden" id="qaStoreID" value="{{route('myQA.store')}}">
                                <input type="hidden" id="qa_course_id" value="{{$course->id}}">
                                <input type="hidden" id="qa_lesson_id" value="{{$lesson->id}}">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="section_title3 mb_20">
                                            <h3>{{__('frontend.Leave a question/comment') }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="single_input mb_25">
                                        <textarea
                                            class="lms_summernote"
                                            id="qna_editor" cols="30"
                                            rows="20"
                                            placeholder="{{__('frontend.Leave a question/comment') }}"
                                            name="text"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb_30">
                                        <button type="button" class="theme_btn height_50" id="QuestionSubmit">
                                            <i class="fas fa-comments"></i>
                                            {{__('frontend.Question') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="plz_write_qus" value="{{__('frontend.Please write your question')}}">
<input type="hidden" id="operation_success" value="{{__('common.Operation successful')}}">
<input type="hidden" id="success_msg" value="{{__('common.Success')}}">
@if (Settings('real_time_qa_update') == 1)

    <script src="{{asset('public/js/pusher.min.js')}}"></script>

    <script>

        let pusher = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {
            cluster: '{{config('broadcasting.connections.pusher.options.cluster')}}'
        });


        let channel = pusher.subscribe('new-notification-channel');

        channel.bind('new-notification', function (data) {
            if (data.user == {{auth()->check()?auth()->user()->id:0}}) {
                loadQna();
                if (data.login_user_id != '{{auth()->check()?auth()->user()->id:0}}') {
                    toastr.success("{{__('frontend.New notification')}}");
                }

            }
        });


        function loadQna() {
            let list = $("#qnaList");
            list.html('')
            list.load("{{route('myQA.loadQna',[$course->id,$lesson->id])}}");

        }

    </script>
@endif
