@extends(theme('layouts.full_screen_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{ $course->title}}
@endsection
@section('css')
    <link href="{{asset('public/frontend/infixlmstheme/css/full_screen.css')}}{{assetVersion()}}" rel="stylesheet"/>

    <style>
        .default-font {
            font-family: "Jost", sans-serif;
            font-weight: normal;
            font-style: normal;
            font-weight: 400;
        }

        .primary_checkbox {
            z-index: 99;
        }

        @media (max-width: 767.98px) {
            .contact_btn {
                margin: 0 !important;
                justify-content: space-between;
            }

            #video-placeholder {
                height: 300px;
            }
        }

        .course__play_warp.courseListPlayer:before {
            background-color: transparent;
        }

        @media (max-width: 991.98px) {
            .mobile-min-height {
                height: 330px !important;
            }
        }

        #ExternalHeaderViewerChromeTopBars {
            display: none !important;
        }

        .quiz_questions_wrapper {
            height: 100%;
        }

        .question_number_lists {
            max-height: 320px;
            overflow: auto;
        }

        .logo_img {
            height: 50px !important;
        }

        @media (max-width: 991.98px) {
            .header_area .header__wrapper .header__left .logo_img img {
                padding: .5rem !important
            }
        }

        .inline-YTPlayer {
            height: auto !important;
        }

        .quiz_score_wrapper .quiz_test_body .score_view_wrapper {
            justify-content: space-around;
        }

        .course_fullview_wrapper {
            width: 100%;
            padding-left: 0;
            padding-right: 0;
        }
        .floating-title{
            display: block;
        }

        .course_fullview_wrapper .course__play_warp{
            height: calc(100vh - 50px);
        }
        .agora-chat.d-flex.flex-column.h-100 {
            overflow: auto;
        }

    </style>
    <style>
        .agora-stream-loading {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: hsla(0, 0%, 100%, .8);
            color: #343434;
            z-index: 20
        }

        .agora-stream-loading img {
            width: 80px;
            height: 80px
        }

        .agora-chat {
            height: 100%
        }

        .agora-chat .agora-chat-box {
            height: calc(100vh - 243px);
            overflow-y: auto
        }

        @media (max-width: 991px) {
            .agora-chat .agora-chat-box {
                height: 60vh
            }
        }

        .agora-chat .send-message-btn {
            width: 34px !important;
            height: 34px !important
        }

        .agora-users {
            height: calc(100vh - 137px);
            overflow-y: auto
        }

        .user-card .avatar, .user-card .avatar img {
            width: 40px;
            height: 40px
        }

        .agora-stream .player {
            width: 100%;
            height: calc(100vh - 175px);
            background-color: #f1f1f1;
            border-radius: 10px;
            padding: 15px 20px;
        }

        .agora-stream .player > div {
            border-radius: 10px;
            background-color: transparent
        }

        .agora-stream .player video {
            border-radius: 10px
        }

        @media (max-width: 991px) {
            .agora-stream .player {
                height: 60vh
            }
        }

        .agora-stream .time-item {
            width: 24px
        }

        .agora-stream .stream-player.screen-shared {
            position: absolute !important;
            width: 250px;
            height: 150px;
            left: 0;
            z-index: 5
        }

        @media (max-width: 991px) {
            .agora-stream .stream-footer {
                flex-wrap: wrap
            }

            .agora-stream .stream-footer .stream-bottom-actions {
                flex: 1 1 90px
            }
        }

        html {
            overflow: hidden
        }

        @media (max-width: 991px) {
            html {
                overflow: auto
            }
        }

        body {
            height: 100vh
        }

        @media (max-width: 991px) {
            body {
                overflow: auto
            }
        }

        .agora-page .agora-tabs {
            width: 70px;
            height: 100vh;
            transition: all .3s ease
        }

        .agora-page .agora-tabs .agora-tabs-icons {
            width: 20px;
            height: 20px
        }

        .agora-page .agora-tabs .agora-tabs-icons svg {
            width: 100%;
            height: 100%
        }

        .agora-page .agora-tabs .agora-tabs-link-text, .agora-page .agora-tabs .tab-content {
            display: none;
            transition: all .4s ease
        }

        .agora-page .agora-tabs.show {
            width: 373px
        }

        .agora-page .agora-tabs.show .agora-tabs-link-text, .agora-page .agora-tabs.show .tab-content {
            display: block
        }

        .agora-page .agora-tabs:not(.show) .nav-tabs {
            flex-direction: column
        }

        .agora-page .agora-tabs:not(.show) .nav-tabs .nav-item {
            margin-top: 20px
        }

        .agora-page .agora-tabs:not(.show) .nav-tabs .nav-item:first-child {
            margin-top: 0
        }

        .agora-page .agora-tabs:not(.show) .nav-tabs .nav-item a:after {
            display: none
        }

        @media (max-width: 991px) {
            .agora-page .agora-tabs {
                height: auto
            }

            .agora-page .agora-tabs .nav-tabs {
                padding-top: 15px
            }
        }


        .stream-btn .icon {
            --width: 63px;
            width: var(--width);
            height: var(--width);
            display: flex;
            align-items: center;
            justify-content: center;
            background: #FFFFFF;
            box-shadow: 4px 4px 20px rgba(0, 0, 0, 0.05);
            border-radius: 15px;
            margin: 0 auto;
            margin-bottom: 10px;
        }

        .stream-btn span {
            font-size: 16px;
            line-height: 17px;
            font-weight: 400;
            color: #64727E;
        }

        .stream-btn {
            text-align: center;
            cursor: pointer;
        }

        .stream-footer {
            margin-top: 30px;
            gap: 50px;
        }

        .stream-btn.end .icon {
            background-color: #FF5038;
            color: #fff;
        }

        .session-title {
            padding: 15px 20px;
        }

        .session-title h4 {
            font-size: 20px;
            font-weight: 700;
            text-transform: capitalize;
        }

        .agora-tabs {
            border-left: 1px solid #ced4da;
            padding: 0px 20px;
        }

        .agora-page .agora-tabs {
            height: 100vh;
            position: relative;
        }

        .stream-footer {
            margin-top: 0;
            padding: 30px 0px;
        }

        .agora-stream .player {
            height: calc(100vh - 205px);
        }

        .agora-page .agora-tabs .h-100 {
            height: auto !important;
        }

        .agora-chat-footer textarea {
            border: none !important;
            resize: none;
            background-color: #D7D7D7 !important;
            box-shadow: 0 0 0 !important;
            height: 80px;
            border-radius: 6px;
        }

        .agora-tabs {
            padding: 0;
        }

        .agora-page .agora-tabs .nav-tabs {
            padding: 0px 20px;
        }

        .agora-chat .agora-chat-box {
            padding: 0px 20px;
            height: calc(100vh - 243px);
        }

        .agora-chat-footer {
            position: relative;
            padding: 20px;
        }

        .agora-chat-footer button {
            position: absolute;
            right: 30px;
        }

        .stream-footer {
            background-color: #F9FBFC !important;
        }

        .agora-stream .player {
            border-radius: 0 !important;
        }

        .stream-btn.active .icon {
            background-color: #2295FF;
            color: white;
        }

        .stream-btn.active .icon ~ span {
            color: #2295FF !important;
        }


        #collapseBtn {
            --btn-width: 44px;
            width: calc(var(--btn-width) + 20px);
            height: var(--btn-width);
            background-color: #2295FF;
            border-radius: 14px;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-size: 14px;
            position: absolute;
            top: 18px;
            left: -65px;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            text-transform: uppercase;
            transition: all .3s ease-in-out;
        }

        .agora-page .agora-tabs {
            border-color: rgba(0, 0, 0, 0.1);
            width: 0;
        }

        .host-img {
            width: var(--img-width);
            height: var(--img-width);
            overflow: hidden;
            position: relative;
            border-radius: 100%;
            background-color: #F1F1F1;
        }

        .host-user {
            --img-width: 75px;
            border-bottom: 1px solid rgba(180, 171, 171, 0.30);
            padding-bottom: 20px;
        }

        .host-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .host-user > div {
            flex: 0 0 auto;
        }

        .host-content {
            width: calc(100% - var(--img-width));
            padding-left: 24px;
        }

        .host-content h4 {
            font-weight: 600;
            font-size: 20px;
            line-height: 23px;
            margin-bottom: 8px;
            color: #303030;
        }

        .host-content p {
            font-weight: 400;
            font-size: 16px;
            line-height: 19px;
            color: #303030;
        }

        .agora-page .agora-tabs.show {
            width: 500px;
            padding: 30px !important;
        }

        .agora-chat-box {
            padding: 20px 0 !important;
        }

        .user-card .avatar {
            width: var(--card-img);
            height: var(--card-img);
            border-radius: 100%;
            overflow: hidden;
        }

        .user-card {
            --card-img: 40px;
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .user-card-content {
            width: calc(100% - var(--card-img));
            padding-left: 8px;
        }

        .user-send-date, .send-message span {
            font-weight: 400;
            font-size: 14px;
            line-height: 16px;
            letter-spacing: 0.05em;
            color: rgba(0, 0, 0, 0.3);
            display: block;
            margin-top: 8px;
        }

        .user-card-wraper span {
            font-weight: 400;
            font-size: 12px;
            line-height: 12px;
            text-transform: uppercase;
            color: #2295FF;
        }

        .user-card-wraper p {
            font-weight: 400;
            font-size: 16px;
            line-height: 21px;
            letter-spacing: 0.05em;
            color: rgba(0, 0, 0, 0.55);
            margin-top: 9px;
        }

        .user-card-wraper {
            background-color: #EBF0F6;
            border-radius: 8px;
            width: max-content;
            padding: 11px 19px;
        }

        .send-message .receiver {
            margin-left: auto;
        }

        .send-message .sender {
            margin-right: auto;
        }

        .send-message {
            max-width: max-content;
            margin-left: auto;
            margin-bottom: 30px;
        }

        .send-message-wrap {
            background: #2295FF;
            border-radius: 8px;
            text-align: right;
            color: #fff;
            padding: 12px 15px;
        }

        .send-message-wrap p {
            color: currentColor;
            font-weight: 400;
            font-size: 18px;
            line-height: 21px;
            text-align: right;
            letter-spacing: 0.05em;
        }

        .agora-chat-footer {
            padding: 0;
            border: none !important;
        }

        .agora-chat-footer textarea {
            background-color: #EBF0F6 !important;
            border-radius: 10px;
            padding: 20px 25px;
            min-height: 80px !important;
        }

        .agora-chat .send-message-btn {
            width: auto !important;
            height: 0 !important;
            padding: 26px 16px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px !important;
            right: 18px;
            background: var(--system_primery_color);;
            border: var(--system_primery_color);;
        }

        .stream-footer div:hover span {
            color: #2295FF;
        }

        .stream-footer div span {
            transition: all .3s ease-in-out;
        }

        #collapseBtn span:last-child {
            margin-left: 2px;
        }

        #collapseBtn span:first-child {
            transform: scaleX(-1);
            font-size: 12px;
        }

        .agora-page .agora-tabs.show #collapseBtn span:last-child {
            display: none;
        }

        .agora-page .agora-tabs.show #collapseBtn {
            width: var(--btn-width);
            left: -22px;
            border-top-right-radius: 14px;
            border-bottom-right-radius: 14px;
        }

        .agora-page .agora-tabs.show #collapseBtn span:first-child {
            transform: scaleX(1);
            transition: all .3s ease-in-out;
        }

        #collapseBtn {
            z-index: 9;
        }

        @media only screen and (min-width: 1440px) and (max-width: 1580px) {
            .agora-page .agora-tabs.show {
                width: 400px;
            }
        }

        @media only screen and (min-width: 1200px) and (max-width: 1439px) {
            .agora-page .agora-tabs.show {
                width: 350px;
                padding: 20px !important;
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1199px) {
            .agora-page .agora-tabs.show {
                width: 300px;
                padding: 20px !important;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .host-user {
                --img-width: 60px;
            }
        }

        @media only screen and (max-width: 991px) {
            .agora-page .agora-tabs {
                position: absolute;
                top: 0;
                right: 0;
                background: #fff;
                padding: 0 !important;
                z-index: 99;
            }

            .agora-page .agora-tabs.show {
                width: 350px;
                padding: 20px !important;
            }

            .host-user {
                display: none !important;
            }

            .agora-page .agora-tabs.show .host-user {
                display: flex !important;
            }
        }

        @media only screen and (max-width: 767px) {
            .stream-btn .icon {
                --width: 50px;
            }

            .agora-stream .stream-footer {
                gap: 1.5rem;
                padding: 20px 0px;
            }

            .agora-stream .player {
                height: calc(100vh - 172px);
            }
        }

        @media only screen and (max-width: 479px) {
            .agora-page .agora-tabs.show {
                width: 300px;
            }

            .host-user {
                --img-width: 55px;
            }
        }


        #leaveModal .modal-content {
            border: none;
            border-radius: 24px;
            padding: 40px 20px;
            text-align: center;
        }

        #leaveModal .modal-content p {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 24px;
        }

        #leaveModal .modal-content button {
            font-size: 18px;
            font-weight: 500;
            line-height: 1.5;
            color: white;
            padding: 9px 36px;
            border-radius: 100px;
            background-color: transparent;
        }

        #leaveModal .modal-content .yes {
            background-color: #4277FF;
            border-color: #4277FF;
        }

        #leaveModal .modal-content .no {
            background-color: #36D98B;
            color: #fff;
            margin-left: 10px;
            border-color: #36D98B;
        }

        #leaveModal .modal-content .yes:hover {
            background-color: transparent;
            color: #4277FF;
        }

        #leaveModal .modal-content .no:hover {
            background-color: transparent;
            color: #36D98B;
        }

        #leaveModal .modal-body {
            padding: 0;
        }

        .agora-stream .site_logo {
            height: 50px;
            width: auto;
            margin-right: 30px;
        }

        .agora-stream .site_logo a {
            /*display: block;*/
        }

        .agora-stream .site_logo img {
            width: 100%;
            height: 100%;
        }

        .session-title {
            width: 100%;
            justify-content: flex-start !important;
        }

        .stream-footer {
            padding: 20px 0px;
        }

        .stream-btn .icon {
            --width: 58px;
        }

        .agora-chat {
            padding: 0 15px;
        }

        .agora-chat .send-message-btn {
            padding: 16.25px 10px !important;
        }

        button#sendMessage svg {
            width: 14px;
            height: auto;
        }

        .agora-chat-footer textarea {
            padding: 10px;
            height: 60px;
            margin-top: 10px;
            margin-bottom: 10px !important;
            padding-right: 60px !important;
        }

        .user-card-wraper p {
            white-space: break-spaces;
            width: 100%;
            overflow: hidden;
            display: block;
        }
    </style>
@endsection

@section('mainContent')

    <header>
        <div id="sticky-header" class="header_area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="header__wrapper flex-wrap">
                            <!-- header__left__start  -->
                            <div class="header__left d-flex align-items-center">
                                <div class="">
                                    <a class="logo_img" href="{{url('/')}}">
                                        <img class="p-2" src="{{getLogoImage(Settings('logo') )}}" width="150"
                                             alt="{{ Settings('site_name')  }}">
                                    </a>
                                </div>
                                <div class="category_search d-none d-lg-flex category_box_iner">
                                    <div class="input-group-prepend2 ps-3 ">
                                        <a class="headerTitle"
                                           href="{{ courseDetailsUrl($course->id, $course->type, $course->slug) }}">
                                            <h4 class="headerTitle">{{ $course->title }}</h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <div class="course_fullview_wrapper active">


        @if ($class->host == 'Youtube')
            @php
                if (Str::contains($class->link, '&')) {
                    $video_id = explode('=', $class->link);
                    $youtube_url = youtubeVideo($video_id[1]);
                } else {
                    $youtube_url = getVideoId(showPicName(@$class->link));
                }

            @endphp
            @if (Settings('youtube_default_player'))
                <div style="" id="video-placeholder"></div>
                <input class="d-none" type="text" id="progress-bar">
                <input type="hidden" name="" id="youtube_video_id" value="{{ $youtube_url }}">

                @push('js')
                    <script src="https://www.youtube.com/iframe_api"></script>
                    <script>
                        var source_video_id = $('#youtube_video_id').val();
                        var player;

                        // val youtube_video_id=$('#youtube_video_id').val();
                        function onYouTubeIframeAPIReady() {
                            console.log('yt api');
                            player = new YT.Player('video-placeholder', {
                                videoId: source_video_id,
                                height: '100%',
                                width: '100%',
                                host: '{{ request()->secure() ? 'https' : 'http' }}://www.youtube-nocookie.com',
                                playerVars: {
                                    color: 'white',
                                    controls: {{ Settings('show_seek_bar') ? 1 : 0 }},
                                    showinfo: 0,
                                    // rel: 0,
                                    modestbranding: 1,
                                    enablejsapi: 1,
                                    iv_load_policy: 3,
                                    html5: 1,
                                    fs: 1,
                                    cc_load_policy: 1,
                                    start: 0,
                                    origin: window.location.host
                                },
                                events: {
                                    onReady: initialize

                                }
                            });

                        }

                        function initialize() {
                            updateTimerDisplay();
                            updateProgressBar();

                            player.playVideo();
                            console.log('play');
                            time_update_interval = setInterval(function () {
                                updateTimerDisplay();
                                updateProgressBar();
                            }, 1000)

                        }

                        // player.addEventListener("onStateChange", function(state){
                        //     if(state === 0){
                        //         console.log('video complete');
                        //         classAutoComplete(course_id,{{ showPicName(Request::url()) }});
                        //     }
                        // });
                        function updateProgressBar() {
                            $('#progress-bar').val((player.getCurrentTime() / player.getDuration()) * 100);
                        }

                        function updateTimerDisplay() {
                            $('#currentTime').text(formatTime(player.getCurrentTime()));
                            $('#totalTime').text(formatTime(player.getDuration()));
                            if (player.getCurrentTime() >= player.getDuration()) {
                                if (!completeRequest) {
                                    classAutoComplete(course_id, {{ showPicName(Request::url()) }});
                                    completeRequest = true;
                                }

                            }
                        }


                        function formatTime(time) {
                            time = Math.round(time);
                            var minutes = Math.floor(time / 60),
                                seconds = time - minutes * 60;
                            seconds = seconds < 10 ? '0' + seconds : seconds;
                            return minutes + ":" + seconds;
                        }

                        $('#progress-bar').on('mouseup touchend', function (e) {
                            var newTime = player.getDuration() * (e.target.value / 100);
                            player.seekTo(newTime);
                        });

                        function updateProgressBar() {
                            $('#progress-bar').val((player.getCurrentTime() / player.getDuration()) * 100);
                        }
                    </script>
                @endpush
            @else
                <link href="{{ asset('public/frontend/infixlmstheme/plugins/css/jquery.mb.YTPlayer.min.css') }}"
                      media="all" rel="stylesheet" type="text/css">

                <script src="{{ asset('public/frontend/infixlmstheme/plugins/jquery.mb.YTPlayer.js') }}"></script>

                <div class="video_iframe" id="video-id"
                     data-property="{videoURL:'http://youtu.be/{{ $youtube_url }}',containment:'self',   mute:false, startAt:0, loop:false, opacity:1,seekbar:{{ Settings('show_seek_bar') ? 'true' : 'false' }}}">
                    Loading...
                </div>
                <script>
                    jQuery(function () {
                        $("#video-id").YTPlayer();

                        $("#video-id").on("YTPEnd", function (e) {
                            if (!completeRequest) {
                                classAutoComplete(course_id, {{ showPicName(Request::url()) }});
                                completeRequest = true;
                            }
                        });
                    });
                </script>
            @endif
        @endif
        {{-- End Youtube --}}

        @if ($class->host == 'Vimeo')
            <div class="video_wrapper">
                <iframe class="video_iframe" id="video-id"
                        src="https://player.vimeo.com/video/{{ getVideoId(showPicName(@$class->link)) }}?autoplay=1&"
                        frameborder="0" controls="1" allowfullscreen></iframe>
            </div>
            <script src="https://f.vimeocdn.com/js/froogaloop2.min.js"></script>

            @push('js')
                <script src='https://player.vimeo.com/api/player.js'></script>
                <script>
                    $(function () {
                        var iframe = $('#video-id')[0];
                        var player = new Vimeo.Player(iframe);
                        var status = $('.status');


                        player.on('pause', function () {
                            console.log('paused');
                        });

                        player.on('ended', function () {
                            console.log('ended');
                            console.log(completeRequest)
                            if (!completeRequest) {
                                classAutoComplete(course_id, {{ showPicName(Request::url()) }});
                                completeRequest = true;
                            }
                            status.text('End');


                        });

                        player.on('timeupdate', function (data) {
                            console.log(data.seconds + 's played');
                        });

                    });
                </script>
            @endpush
        @endif




        @if ($class->host == 'Self')
            <video class="" id="video-id" controls autoplay>
                <source src="{{ asset($class->link) }}" type="video/mp4"/>
                <source src="{{ asset($class->link) }}" type="video/ogg">
            </video>
        @endif



        @if ($class->host == 'URL')
            <video class="" id="video-id" controls autoplay
                   onended="classAutoComplete(course_id, {{ showPicName(Request::url()) }})">
                <source src="{{ $class->link }}" type="video/mp4">
                <source src="{{ $class->link }}" type="video/ogg">
                Your browser does not support the video.
            </video>
        @endif

        {{--        sidebar start--}}


        <div class="floating-title position-fixed">
            <p class="font_16 d-flex align-items-center">
                <span class="header__common_btn me-2 play_toggle_btn"><i
                        class="ti-menu-alt"></i></span> {{ __('chat.chat') }}
            </p>
        </div>
            <div class="course__play_warp courseListPlayer active">
            <div class="play_warp_header d-flex justify-content-between">
                <h3 class="font_16 mb-0 lesson_count default-font d-flex align-items-center">
                    <span class="play_toggle_btn header__common_btn me-2 d-none d-lg-flex">
                        <i class="fas fa-expand"></i>
                    </span>

                    <span>
                        <span class="d-block">
                            {{ __('chat.chat') }}
                        </span>
                    </span>
                </h3>


            </div>
            <div class="agora-chat d-flex flex-column h-100">

                <div id="chatView" class="agora-chat-box pb-30">
                    @foreach($messages as $message)
                        <div class="user-card">
                            <div class="avatar">
                                <img src="{{getProfileImage($message->user->image, $message->user->name)}}" alt=""
                                     class="img-cover rounded-circle">
                            </div>
                            <div class="user-card-content">
                                <div class="user-card-wraper">
                                    <span>{{$message->user->name}}</span>
                                    <p class="mb-0">{{$message->msg}}</p>
                                </div>
                                <div class="user-send-date">{{$message->created_at->format('Y-m-d H:i:s')}}</div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div
                    class="agora-chat-footer mt-15 py-15 px-15 border-top border-gray200 d-flex align-items-center ">

                    <div class="flex-grow-1">
            <textarea name="message" id="messageInput" class="form-control " rows="3"
                      placeholder="{{ trans('common.Type Your Message') }}"></textarea>
                    </div>


                    <button type="submit" id="sendMessage"
                            class="send-message-btn btn btn-primary p-0 rounded-circle ml-15">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1.00001 8.23874C1.00001 6.30847 19.5691 -0.903676 21.9511 1.47647C24.3281 3.85165 17.0188 22.4279 15.1021 22.4279C12.868 22.4279 11.5555 13.9178 11.0264 12.3929C9.50714 11.8561 1.00001 10.4811 1.00001 8.23874Z"
                                stroke="currentColor" stroke-width="1.71429" stroke-linecap="round"
                                stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>


        </div>

    </div>

@endsection
@push('js')

    <script>
        $(document).ready(function () {
            if ($('.active').length) {
                let active = $('.active');
                let parent = active.parents('.collapse').first();
                parent.addClass('show');
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {


            if (window.outerWidth < 425) {
                $('.courseListPlayer').toggleClass("active");
                $('.course_fullview_wrapper').toggleClass("active");
            }


        });
    </script>

    @if ($class->host == 'Self' || $class->host == 'AmazonS3' || $class->host == 'URL')
        <script>
            let myFP = fluidPlayer(
                'video-id', {
                    "layoutControls": {
                        "controlBar": {
                            "autoHideTimeout": 3,
                            "animated": true,
                            "autoHide": true
                        },
                        "htmlOnPauseBlock": {
                            "html": null,
                            "height": null,
                            "width": null
                        },
                        "autoPlay": true,
                        "mute": false,
                        "hideWithControls": false,
                        "allowTheatre": false,
                        "playPauseAnimation": true,
                        "playbackRateEnabled": false,
                        "allowDownload": false,
                        "playButtonShowing": true,
                        "fillToContainer": true,
                        "posterImage": ""
                    },
                    "vastOptions": {
                        "adList": [],
                        "adCTAText": false,
                        "adCTATextPosition": ""
                    }
                });
        </script>

        @if (!Settings('show_seek_bar'))
            <style>
                div#video-id_fluid_controls_progress_container {
                    display: none;
                }
            </style>
            <script>
                if ($('#video-id').length) {
                    var video = document.getElementById('video-id');
                    var supposedCurrentTime = 0;
                    video.addEventListener('timeupdate', function () {
                        if (!video.seeking) {
                            supposedCurrentTime = video.currentTime;
                        }
                    });
                    // prevent user from seeking
                    video.addEventListener('seeking', function () {
                        // guard agains infinite recursion:
                        // user seeks, seeking is fired, currentTime is modified, seeking is fired, current time is modified, ....
                        var delta = video.currentTime - supposedCurrentTime;
                        if (Math.abs(delta) > 0.01) {
                            console.log("Seeking is disabled");
                            video.currentTime = supposedCurrentTime;
                        }
                    });
                    // delete the following event handler if rewind is not required
                    video.addEventListener('ended', function () {
                        // reset state in order to allow for rewind

                    });
                }
            </script>
        @endif
    @endif

    <script src="{{ asset('public/frontend/infixlmstheme/js/class_details.js') }}"></script>
    <script src="{{ asset('public/frontend/infixlmstheme/js/full_screen_video.js') }}"></script>

    <script src="{{asset('public/js/pusher.min.js')}}"></script>
    <script>

        Pusher.logToConsole = false;
        let pusher = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {
            cluster: '{{config('broadcasting.connections.pusher.options.cluster')}}'
        });


        let channel = pusher.subscribe('custom-class-message-channel');
        channel.bind('new-class-message-{{$class->id}}', function (data) {


            let single = `

          <div class="user-card">
                        <div class="avatar">
                            <img src="${data.message.img}" alt=""
                                 class="img-cover rounded-circle">
                        </div>
                        <div class="user-card-content">
                            <div class="user-card-wraper">
                                <span>${data.message.name}</span>
                                <p class="mb-0">${data.message.text}</p>
                            </div>
                            <div class="user-send-date">${data.message.date}</div>
                        </div>
                    </div>
                    `;

            $('#chatView').append(single)
            $('#chatView').scrollTop($('#chatView')[0].scrollHeight);

        });


        $('#chatView').scrollTop($('#chatView')[0].scrollHeight);
        $(document).on("click", "#sendMessage", function (e) {
            e.preventDefault();
            let msgInput = $('#messageInput');
            let msg = msgInput.val();
            if (msg == '') {
                return false
            }
            msgInput.val('');

            $.ajax({
                url: "{{url('custom/send-custom-class-message/' . $class->id)}}",
                type: "POST",
                data: {
                    'message': msg
                },
                // dataType: "html",
                success: function (response) {
                    $('#chatView').scrollTop($('#chatView')[0].scrollHeight);

                },
                error: function (err) {
                    console.log(err)
                    // check the err for error details
                }
            });
        });

    </script>
@endpush
