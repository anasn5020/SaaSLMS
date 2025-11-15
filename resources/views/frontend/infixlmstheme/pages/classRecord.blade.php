@extends(theme('layouts.full_screen_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{ $course->title}}
@endsection
@section('css')
    @if(isRtl())
        <link href="{{asset('public/frontend/infixlmstheme/css/full_screen_rtl.css')}}{{assetVersion()}}"
              rel="stylesheet"/>
    @else
        <link href="{{asset('public/frontend/infixlmstheme/css/full_screen.css')}}{{assetVersion()}}" rel="stylesheet"/>
    @endif
    {{-- <link href="{{asset('public/frontend/infixlmstheme/css/class_details.css')}}{{assetVersion()}}" rel="stylesheet"/> --}}
    <link href="{{asset('public/backend/css/summernote-bs5.min.css')}}{{assetVersion()}}" rel="stylesheet">
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

        html[dir=rtl] .fa-angle-left,
        html[dir=rtl] .fa-angle-right {
            transform: scaleX(-1)
        }

        @media (max-width: 991px) {
            .course_fullview_wrapper .video_iframe {
                position: initial !important;
                height: 400px;
                width: 100%;
            }
        }

        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 550px;
            }
        }

        @media (min-width: 1080px) {
            .modal-dialog {
                max-width: 800px;
            }
        }

        .conversition_box .single_comment_box .comment_box_inner .comment_box_info .comment_box_text span {
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 10px;
            margin-top: 2px;
            display: block;
            color: #7b7887;
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

    <div class="course_fullview_wrapper">

        @if ($currentRecord->host== 'self')
            <video class="" id="video-id" controls autoplay>
                <source src="{{ asset($currentRecord->url) }}" type="video/mp4"/>
            </video>
            <script>
                fluidPlayer(
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
        @elseif ($currentRecord->host== 'iframe')
            @if (!empty($currentRecord->url))
                <iframe class="video_iframe" id="video-id" allow="fullscreen"
                        src="{{ $currentRecord->url}}"></iframe>

            @endif
        @endif


        <input type="hidden" id="url" value="{{ url('/') }}">
{{--        <div class="floating-title position-fixed">--}}
{{--            <p class="font_16 d-flex align-items-center">--}}
{{--                <span class="header__common_btn me-2 play_toggle_btn"><i--}}
{{--                        class="ti-menu-alt"></i></span> {{ @$total }} {{ __('common.Lessons') }}--}}
{{--            </p>--}}
{{--        </div>--}}
        <div class="course__play_warp courseListPlayer ">
            <div class="play_warp_header d-flex justify-content-between">
                <h3 class="font_16 mb-0 lesson_count default-font d-flex align-items-center">
                    <span class="play_toggle_btn header__common_btn me-2 d-none d-lg-flex">
                        <i class="fas fa-expand"></i>
                    </span>
                    <span>
                        <strong class="d-block d-lg-none">{{ $course->title }}</strong>
                        <span class="d-block">
                            {{ count($records) }} {{ __('virtual-class.Records') }}
                        </span>
                    </span>
                </h3>


            </div>
            <div class="course__play_list">
                @php
                    $i = 1;
                @endphp
                <div class="theme_according mb_30 accordion" id="accordion1">
                    @foreach ($meetings as $k => $meeting)
                        <div class="accordion-item">
                            <div class="accordion-header" id="heading{{ $meeting->id }}">
                                <h5 class="mb-0">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $meeting->id }}" aria-expanded="false"
                                            aria-controls="collapse{{ $meeting->id }}">
                                        {{ $meeting->topic }} <br>
                                        <span class="course_length nowrap">
                                              {{ count($meeting->records) }}
                                            {{ __('virtual-class.Records') }}
                                        </span>
                                    </button>
                                </h5>
                            </div>
                            <div class="collapse" id="collapse{{ $meeting->id }}"
                                 aria-labelledby="heading{{ $meeting->id }}" data-bs-parent="#accordion1">
                                <div class="accordion-body">
                                    <div class="curriculam_list">
                                        @foreach ($records as $key => $record)
                                            @if($record->meeting_id == $meeting->id)
                                                <div class="single_play_list {{showpicName(Request::url()) == $record->id?'active_single_play':''}}"
                                                     id="single_lesson_{{ $record->id }}">
                                                    <a class="@if (showPicName(Request::url()) == $record->id) active @endif"
                                                       href="#">


                                                        <div class="course_play_name">
                                                                <span data-link="{{route('classRecordView',[$record->class_id,$record->id])}}"
                                                                class="recordLink"
                                                                >
                                                                    {{ $i }}.
                                                                    {{ $record->title }}
                                                                </span>

                                                        </div>
                                                    </a>
                                                </div>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endif
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

    </div>

@endsection
@push('js')
    <script>
        $(document).on('click','.recordLink',function(){
            window.location.href = $(this).data('link')
        });

        $('.active_single_play').closest('.accordion-item').find('.collapse').addClass('show')
        $('.active_single_play').closest('.accordion-item').find('.accordion-button').removeClass('collapsed')
    </script>
@endpush
