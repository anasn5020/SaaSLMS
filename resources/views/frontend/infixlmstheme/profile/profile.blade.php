@extends(theme('layouts.master'))

@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('profile.profile')}}
@endsection

@section('css')
    <style>
        .profile-info ul li a i.fa-linkedin-in {
            color: #0078b6;
            transition: inherit;
        }

        .profile-info ul li a:hover i.fa-linkedin-in {
            color: #ffffff;
        }

        .profile-info .badges {
            display: block;
        }

        .profile-left {
            border: none;
            padding: 0;
        }


        .profile-info .badges li img {
            width: var(--width);
            height: var(--width)
        }

        .badgesSlider {
            width: 50%
        }

        @media (min-width: 992px) and (max-width: 1279px) {
            .badgesSlider {
                width: 42%;
            }
        }

        @media (max-width: 767px) {
            .profile-info .social_media {
                grid-template-columns: repeat(5, minmax(var(--width), 1fr));
                margin-bottom: 15px;
                width: 100%;
            }

            .badgesSlider {
                width: 100%;
                margin-bottom: 15px;
            }
        }

        .badgesSlider img {
            width: var(--width) !important;
            height: var(--width) !important;
            object-fit: contain;
        }

        .profile-wrapper {
            padding: 26px;
            background-color: #fff;
            box-shadow: -12px 16px 40px 0px rgba(0, 0, 0, 0.1);
        }

        .profile-img .img {
            border: 1px solid #c5c5c5;
        }

        .profile-right {
            background: var(--system_primery_color);
            background-size: 200% auto;
            padding: 35px 30px;
            border-radius: 10px;
        }

        .mr-20 {
            margin-right: 20px !important;
        }

        .profile-img {
            position: relative;
            z-index: 1;
        }

        .profile-badge {
            --width: 44px;
            width: var(--width);
            height: var(--width);
            border-radius: 100%;
            background-color: #25d978;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            right: -10px;
            bottom: 100%;
            z-index: 2;
            margin-bottom: calc(var(--width) / 2 * -1);
        }

        .profile-wrapper {
            padding: 26px;
        }

        .unverify {
            background-color: #F63743;
        }

        .profile-img {
            position: relative;
            z-index: 1;
        }

        .profile-badge {
            --width: 44px;
            width: var(--width);
            height: var(--width);
            border-radius: 100%;
            background-color: #25d978;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            right: -10px;
            bottom: 100%;
            z-index: 2;
            margin-bottom: calc(var(--width) / 2 * -1);
        }

        .unverify {
            background-color: #F63743;
        }

        .profile-info .gap-20 {
            gap: 20px
        }

        @media (max-width: 576px) {
            .profile .nav-link {
                font-size: 14px;
                line-height: 14px;
                padding: 10px 12px !important;
                min-width: 60px;
            }
        }


        @media only screen and (min-width: 1440px) and (max-width: 1580px) {
            .course_badge_section .dashboard_badge_carousel {
                min-height: initial;
            }
        }

        .profile .tab-pane.course_badge_section .row {
            margin-bottom: 0px;
        }

        .course_badge_section .dashboard_badge_carousel{
            min-height: initial;
        }

        @media (max-width: 767.98px) {
            .course_badge_section .blog_page_wrapper {
                padding-bottom: 0!important;
            }
        }

    </style>
@endsection

@section('js')
    <script>
        $(".badgesSlider").owlCarousel({
            loop: false,
            margin: 14,
            autoplay: false,
            items: 5,
            navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>',
            ],
            nav: false,
            dots: false,
            autoplayHoverPause: true,
            autoplayTimeout: $('#slider_transition_time').val() * 1000,
            autoplaySpeed: 800,
            autoWidth: true,
            // responsive: {
            //     0: {
            //         items: 1,
            //     },
            //     767: {
            //         items: 6,
            //     },
            //     992: {
            //         items: 4,
            //     },
            //     1400: {
            //         items: 5,
            //     },
            // },
        });

    </script>


    <script>
        "use strict";
        $(document).ready(function () {
            $("#course_badge_carousel").owlCarousel({
                loop: false,
                margin: 10,
                nav: false,
                dots: false,
                items: 5,
                center: true,
                responsive: {
                    0: {
                        items: 3
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 5
                    },
                    1300: {
                        items: 7
                    }
                }
            });
        });
    </script>

@endsection

@section('mainContent')

    <!-- profile cover photo -->
    <div class="profile-cover">
        <img
            src="{{(@$user->userInfo && @$user->userInfo->cover_photo)? showImage(@$user->userInfo->cover_photo):showImage(null,'cover_photo')}}"
            alt="cover photo">
    </div>
    <!-- profile cover photo -->
    @php
        $already_count=[];
    @endphp
    @foreach(@$user->userLatestBadges as $badge)
        @php
            $b =$badge->badge;

            if (in_array($b->type,$already_count)){
                continue;
            }else{
                $already_count[]=$b->type;
            }
        @endphp

    @endforeach

    <!-- profile info -->
    <div class="profile">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="profile-wrapper d-flex flex-wrap align-items-center">
                        <div class="profile-left d-flex flex-wrap align-items-center">
                            <div class="profile-img text-center">
                                <div class="profile-img-container">

                                    @if(@$user->userInfo->offline_status)

                                        <div class="profile-badge unverify">

                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22Z"
                                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                                    stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M18.8999 5L4.8999 19" stroke="currentColor" stroke-width="1.5"
                                                      stroke-miterlimit="10" stroke-linecap="round"
                                                      stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="profile-badge">

                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"/>
                                                <path d="M7.75 11.9999L10.58 14.8299L16.25 9.16992"
                                                      stroke="currentColor"
                                                      stroke-width="1.5" stroke-linecap="round"
                                                      stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="img"><img src="{{getProfileImage(@$user->image,$user->name)}}"
                                                          alt="Profile Photo">
                                    </div>
                                </div>
                                <a href="{{$follow_btn_route}}" class="theme_btn rounded-pill">{{$follow_btn_text}}</a>
                                <p class="f_w_500">{{$total_followers}} {{__('profile.follower')}}
                                    | {{$total_following}} {{__('profile.following')}}</p>
                            </div>
                            <div class="profile-info">
                                <h4>{{@$user->name}}</h4>
                                @if($section_review)
                                    <blockquote class="d-block"><span><i class="fa fa-star"></i> {{$user->total_rating}}</span>
                                    </blockquote>
                                @endif
                                @if( @$user->userInfo && @$user->userInfo->short_description)
                                    <p>{{@$user->userInfo->short_description}} </p>
                                @endif

                                <div class="d-flex align-items-enter flex-wrap row-gap-24">

                                    @if($section_badge && @$user->userLatestBadges->count() > 0)
                                        <ul class="{{count($already_count) > 5 ? 'badgesSlider owl-carousel': "badges d-flex align-items-center"}}">
                                            @php
                                                $already=[];
                                            @endphp
                                            @foreach(@$user->userLatestBadges as $badge)
                                                @php
                                                    $b =$badge->badge;

                                                    if (in_array($b->type,$already)){
                                                        continue;
                                                    }else{
                                                        $already[]=$b->type;
                                                    }
                                                @endphp
                                                <li><img src="{{asset($b->image)}}"
                                                         data-bs-toggle="tooltip" data-placement="top"
                                                         title="{{$b->title}} {{ucfirst($b->type)}} {{trans('setting.Badge')}}"
                                                         alt="{{$b->title}} {{ucfirst($b->type)}} {{trans('setting.Badge')}}">
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <ul class="social_media">
                                        <li><a href="{{@$user->facebook??"javascript:void(0)"}}"><i
                                                    class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="{{@$user->twitter??"javascript:void(0)"}}"><i
                                                    class="fab fa-twitter"></i></a></li>
                                        <li><a href="{{@$user->linkedin??"javascript:void(0)"}}"><i
                                                    class="fab fa-linkedin-in"></i></a></li>
                                        <li><a href="{{@$user->instagram??"javascript:void(0)"}}"><i
                                                    class="fab fa-instagram"></i></a></li>
                                        @if(isModuleActive('Chat'))

                                            @if(Settings('chat_invitation_requirement') == 'none')
                                                <form action="{{ route('chat.invitation.open') }}"
                                                      method="post">
                                                    @csrf
                                                    <input type="hidden" value="{{ $user->id }}" name="to">
                                                    <a
                                                        onclick="$(this).closest('form').submit();" href="#">
                                                        <i class="far fa-comment-dots"></i>
                                                    </a>
                                                </form>
                                            @else
                                                @if(!$user->connectedWithLoggedInUser())
                                                    <form action="{{ route('chat.invitation.create') }}"
                                                          method="post">
                                                        @csrf
                                                        <input type="hidden" value="{{ $user->id }}"
                                                               name="to">
                                                        <li>
                                                            <a href="#"
                                                               onclick="$(this).closest('form').submit();">
                                                                <span class="ti-plus"></span>
                                                            </a>
                                                        </li>
                                                    </form>
                                                @else
                                                    @if($user->connectionPending())
                                                        <li class="connection-status d-flex align-items-center justify-content-center">
                                                            <span class="ti-timer status"></span>
                                                        </li>
                                                    @elseif($user->connectionSuccess())
                                                        <li class="connection-status d-flex align-items-center justify-content-center">
                                                            <span class="ti-check status"></span>
                                                        </li>
                                                    @else
                                                        <li class="connection-status d-flex align-items-center justify-content-center">
                                                            <span class="ti-check status"></span>
                                                        </li>
                                                    @endif
                                                @endif
                                            @endif
                                        @endif

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="profile-right">
                            <ul>
                                @if($section_total_instructor)
                                    <li>
                                        <svg width="29" height="26" viewBox="0 0 29 26" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M19.2578 13.2603C21.902 13.2603 24.0456 11.1167 24.0456 8.47247C24.0456 6.42701 22.7629 4.68115 20.958 3.99536"
                                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path
                                                d="M11.2055 12.3114C14.0718 12.3114 16.3954 9.98784 16.3954 7.12155C16.3954 4.25524 14.0718 1.93164 11.2055 1.93164C8.33922 1.93164 6.01562 4.25524 6.01562 7.12155C6.01562 9.98784 8.33922 12.3114 11.2055 12.3114Z"
                                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path
                                                d="M19.1506 19.6029C21.6893 21.2937 19.975 24.5548 16.9249 24.5548H5.47059C2.42043 24.5548 0.706214 21.2937 3.24485 19.6029C5.52196 18.0863 8.25663 17.2025 11.1977 17.2025C14.1389 17.2025 16.8735 18.0863 19.1506 19.6029Z"
                                                stroke="currentColor" stroke-width="2.5"/>
                                            <path
                                                d="M16.4844 24.5543H23.7443C26.5583 24.5543 28.1396 21.546 25.7976 19.986C25.151 19.5553 24.4642 19.18 23.7443 18.8667"
                                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                                        </svg>
                                        {{$total_instructors}} {{trans('profile.instructors')}}
                                    </li>
                                @endif

                                @if($section_total_review)
                                    <li>
                                        <svg width="27" height="26" viewBox="0 0 27 26" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.0066 3.01965C11.8925 0.875304 14.8612 0.805786 15.7513 2.94836C16.3677 4.43186 16.8379 5.9595 17.3116 7.95552C19.4048 7.93418 21.041 7.97944 22.6924 8.12785C25.0142 8.3365 25.9512 11.1597 24.1437 12.6318C23.1221 13.4639 22.025 14.2335 20.6499 15.0965C20.2629 15.3394 20.0887 15.8147 20.2291 16.2496C20.8708 18.2395 21.3042 19.8546 21.6413 21.5492C22.09 23.8027 19.716 25.522 17.7866 24.2741C16.3072 23.3176 14.9635 22.2165 13.3096 20.6456C11.6707 22.1544 10.3335 23.225 8.87114 24.1755C6.93055 25.4374 4.50552 23.7365 4.95605 21.466C5.28169 19.825 5.71584 18.2288 6.37658 16.259C6.52379 15.8201 6.34962 15.3364 5.95684 15.0914C4.53994 14.2076 3.41466 13.4203 2.35891 12.5527C0.580534 11.0911 1.48841 8.30536 3.78054 8.09356C5.45806 7.93854 7.13307 7.90567 9.30755 7.95552C9.8801 6.00796 10.3941 4.50223 11.0066 3.01965Z"
                                                stroke="currentColor" stroke-width="2.5" stroke-linejoin="round"/>
                                        </svg>
                                        {{$total_review}} {{__('profile.reviews')}}
                                    </li>
                                @endif
                                @if($section_total_student)
                                    <li>
                                        <svg width="29" height="26" viewBox="0 0 29 26" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M19.2578 13.2603C21.902 13.2603 24.0456 11.1167 24.0456 8.47247C24.0456 6.42701 22.7629 4.68115 20.958 3.99536"
                                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path
                                                d="M11.2055 12.3114C14.0718 12.3114 16.3954 9.98784 16.3954 7.12155C16.3954 4.25524 14.0718 1.93164 11.2055 1.93164C8.33922 1.93164 6.01562 4.25524 6.01562 7.12155C6.01562 9.98784 8.33922 12.3114 11.2055 12.3114Z"
                                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path
                                                d="M19.1506 19.6029C21.6893 21.2937 19.975 24.5548 16.9249 24.5548H5.47059C2.42043 24.5548 0.706214 21.2937 3.24485 19.6029C5.52196 18.0863 8.25663 17.2025 11.1977 17.2025C14.1389 17.2025 16.8735 18.0863 19.1506 19.6029Z"
                                                stroke="currentColor" stroke-width="2.5"/>
                                            <path
                                                d="M16.4844 24.5543H23.7443C26.5583 24.5543 28.1396 21.546 25.7976 19.986C25.151 19.5553 24.4642 19.18 23.7443 18.8667"
                                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                                        </svg>
                                        {{$total_students}} {{trans('profile.students')}}
                                    </li>
                                @endif
                                @if($section_total_course)
                                    <li>
                                        <svg width="29" height="27" viewBox="0 0 29 27" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M2.70034 17.3814C2.85209 18.3963 3.73155 19.1535 4.75726 19.1228C7.90038 19.0288 11.1024 18.9078 14.4581 18.9078C17.8006 18.9078 21.0032 18.9836 24.1281 19.0999C25.1668 19.1385 26.0666 18.3781 26.2205 17.3503C26.5422 15.202 26.9161 12.9637 26.9161 10.664C26.9161 8.37225 26.5448 6.14157 26.2239 4.00014C26.0684 2.96301 25.1539 2.20042 24.1062 2.24443C21.0168 2.37417 17.7849 2.42016 14.4581 2.42016C11.1177 2.42016 7.88551 2.32964 4.77851 2.22097C3.74385 2.18477 2.85036 2.94419 2.69711 3.96807C2.37514 6.11931 2 8.3608 2 10.664C2 12.9748 2.37765 15.2236 2.70034 17.3814Z"
                                                stroke="currentColor" stroke-width="2.5"/>
                                            <path d="M9.49219 25H19.4254" stroke="currentColor" stroke-width="2.5"
                                                  stroke-linecap="round"/>
                                            <path d="M14.4531 18.9126V24.9994" stroke="currentColor" stroke-width="2.5"
                                                  stroke-linecap="round"/>
                                        </svg>
                                        {{$total_courses}}

                                        {{__('profile.courses')}}
                                    </li>
                                @endif
                                @if($section_blog_tab)
                                    <li>


                                        <svg width="29" height="29" viewBox="0 0 29 29" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M25.375 8.45841V20.5417C25.375 24.1667 23.5625 26.5834 19.3333 26.5834H9.66667C5.4375 26.5834 3.625 24.1667 3.625 20.5417V8.45841C3.625 4.83341 5.4375 2.41675 9.66667 2.41675H19.3333C23.5625 2.41675 25.375 4.83341 25.375 8.45841Z"
                                                stroke="currentColor" stroke-width="2.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                d="M17.5208 5.4375V7.85417C17.5208 9.18333 18.6083 10.2708 19.9374 10.2708H22.3541"
                                                stroke="currentColor" stroke-width="2.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M9.66675 15.7083H14.5001" stroke="currentColor" stroke-width="2.5"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M9.66675 20.5417H19.3334" stroke="currentColor" stroke-width="2.5"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                        </svg>


                                        {{$total_blogs}}  {{__('profile.blogs')}}
                                    </li>
                                @endif
                                @if($section_certificate_tab)
                                    <li>
                                        <svg width="29" height="29" viewBox="0 0 17 20" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15.4307 18.2183C15.3801 18.9256 14.5305 19.2561 14.0153 18.7691L9.39537 14.4015C8.80981 13.848 7.89387 13.848 7.30831 14.4015L2.68845 18.7691C2.17324 19.2561 1.32357 18.9256 1.27306 18.2183C0.929826 13.4131 0.91535 8.59416 1.20047 3.78824C1.29405 2.21097 2.61479 1 4.19482 1H12.5089C14.0889 1 15.4096 2.21097 15.5031 3.78824C15.7884 8.59416 15.7738 13.4131 15.4307 18.2183Z"
                                                stroke="currentColor" stroke-width="1.71429" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                        </svg>
                                        {{$total_certificates}}  {{__('profile.certificates')}}
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="col-12">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item mb-0" role="presentation">
                            <button class="nav-link {{request('tab')=='' || request('tag')=='about'?'active':''}}"
                                    id="pills-about-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-about" type="button" role="tab" aria-controls="pills-about"
                                    aria-selected="true">{{__('common.About')}}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{request('tab')=='blogs'?'active':''}}" id="pills-blog-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#pills-blog" type="button" role="tab" aria-controls="pills-blog"
                                    aria-selected="true">{{__('blog.My Blogs')}}
                            </button>
                        </li>
                        @if($section_course_badge_tab)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{request('tab')=='course_badges'?'active':''}}"
                                        id="pills-blog-tab"
                                        data-bs-toggle="pill"
                                        data-bs-target="#pills-course-badges" type="button" role="tab"
                                        aria-controls="pills-blog"
                                        aria-selected="true">{{__('frontend.Course Badges')}}
                                </button>
                            </li>
                        @endif
                        @if($section_course_tab)
                            <li class="nav-item mb-0" role="presentation">
                                <button class="nav-link" id="pills-course-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-course" type="button" role="tab"
                                        aria-controls="pills-course"
                                        aria-selected="false">{{__('profile.courses')}}
                                </button>
                            </li>
                        @endif

                        @if($section_instructor_tab)
                            <li class="nav-item mb-0" role="presentation">
                                <button class="nav-link" id="pills-instructor-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-instructor" type="button" role="tab"
                                        aria-controls="pills-instructor"
                                        aria-selected="false"> {{trans('profile.instructors')}}
                                </button>
                            </li>
                        @endif
                        @if($section_education_tab)
                            <li class="nav-item mb-0" role="presentation">
                                <button class="nav-link" id="pills-education-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-education" type="button" role="tab"
                                        aria-controls="pills-education"
                                        aria-selected="false">{{__('profile.education')}}
                                </button>
                            </li>
                        @endif
                        @if($section_experience_tab)
                            <li class="nav-item mb-0" role="presentation">
                                <button class="nav-link" id="pills-experience-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-experience" type="button" role="tab"
                                        aria-controls="pills-experience"
                                        aria-selected="false">{{__('profile.experience')}}
                                </button>
                            </li>
                        @endif
                    </ul>


                    <div class="tab-content" id="pills-tabContent">
                        {{--about tab--}}
                        <div class="tab-pane fade {{request('tab')=='' || request('tab')=='about'?'show active':''}}"
                             id="pills-about" role="tabpanel"
                             aria-labelledby="pills-about-tab">
                            <div class="about">
                                @if(@$user->userInfo->offline_status)

                                    <div class="card mb-3" style="background-color: #fee7ee">

                                        <div class="card-body">
                                            <h4>{{@$user->name}} is temporarily unavailable.</h4>
                                            <p>{{@$user->userInfo->offline_message}}</p>
                                        </div>
                                    </div>

                                @endif

                                <h3 class="h2">{{__('common.About')}}</h3>
                                <div>
                                    {!!  @$user->about !!}
                                </div>
                                {{--                                <div class="profile-info p-0 d-flex align-items-center flex-wrap">--}}
                                {{--                                    <strong class="f_w_600 mb-0 me-1">Contact Us:</strong>--}}
                                {{--                                    <ul class="bg-transparent p-0 m-0">--}}
                                {{--                                        <li><a href="#"><i class="fab fa-skype"></i></a></li>--}}
                                {{--                                        <li><a href="#"><i class="fab fa-discord"></i></a></li>--}}
                                {{--                                        <li><a href="#"><i class="fab fa-facebook-messenger"></i></a></li>--}}
                                {{--                                    </ul>--}}
                                {{--                                </div>--}}
                                @if($user->userSkill && $user->userSkill->skills)
                                    <div class="skiils flex-wrap">
                                        <strong class="f_w_600 mb-0">{{__('profile.skills')}}: </strong>
                                        <ul>
                                            @foreach(explode(',',$user->userSkill->skills) as $skill)
                                                <li>{{$skill}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class="tab-pane fade {{request('tab')=='blogs'?'show active':''}}"
                             id="pills-blog" role="tabpanel"
                             aria-labelledby="pills-blog-tab">
                            <div class="blog_page_wrapper pt-0">
                                <div class="container p-0">
                                    <div class="row row-gap-24">
                                        @foreach($user->blogs as $blog)
                                            <div class="col-lg-4">
                                                <div class="single_blog" data-category="{{$blog->category->title}}">
                                                    <a href="{{route('blogDetails',[$blog->slug])}}">
                                                        <div class="thumb">

                                                            <div class="thumb_inner lazy"
                                                                 data-src="{{getBlogImage($blog->thumbnail)}}">
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <div class="blog_meta">
                                                        <span>{{$blog->user->name}} . {{ showDate(@$blog->authored_date ) }} {{ @$blog->authored_time }}</span>

                                                        <a href="{{route('blogDetails',[$blog->slug])}}">
                                                            <h4>{{$blog->title}}</h4>
                                                        </a>

                                                        <div
                                                            class="d-flex align-items-end blog_item_footer">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center gap-4 flex-wrap">
                                                                <a href="{{route('blogDetails',[$blog->slug])}}"
                                                                   class="blog_read_more text-nowrap">{{__('common.Read More')}}</a>
                                                                @if($blog->minutes)
                                                                    <p class="blog_length text-nowrap">{{MinuteFormat($blog->minutes)}} {{__('frontend.To Read')}}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        @if(count($user->blogs)==0)
                                            <div class="col-lg-12">
                                                <div
                                                    class="Nocouse_wizged text-center d-flex align-items-center justify-content-center">
                                                    <div class="thumb">
                                                        <img style="width: 50px"
                                                             src="{{ asset('public/frontend/infixlmstheme/img/not-found.png') }}"
                                                             alt="">
                                                    </div>
                                                    <h1>
                                                        {{__('frontend.No Post Found')}}
                                                    </h1>
                                                </div>
                                            </div>
                                        @endif

                                    </div>

                                </div>
                            </div>
                        </div>

                        @if($section_course_badge_tab)
                            <div
                                class="tab-pane course_badge_section fade {{request('tab')=='course_badges'?'show active':''}}"
                                id="pills-course-badges" role="tabpanel"
                                aria-labelledby="pills-blog-tab">
                                <div class="blog_page_wrapper pt-0">
                                    <div class="container p-0">
                                        <div class="row row-gap-24">
                                            <div class="dashboard_badge_carousel owl-carousel" id="course_badge_carousel">
                                                @foreach($badges as $badge)
                                                    @if($badge->course->course_badge)
                                                    <div class="dashboard_badge_item text-center">
                                                        <div class="img"><img
                                                                src="{{asset($badge->course->course_badge)}}"
                                                                alt=""></div>

                                                    </div>
                                                    @endif

                                                @endforeach
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($section_course_tab)
                            {{--course tab--}}
                            <div class="tab-pane fade" id="pills-course" role="tabpanel"
                                 aria-labelledby="pills-profile-tab">
                                @if($courses->count() > 0)
                                    <div class="courses_area m-0 p-0">
                                        <div class="row row-gap-24">
                                            @foreach ($courses as $course)
                                                <div class="col-xl-4 col-md-6">
                                                    <div class="course-item">
                                                        <div class="course-item-img">
                                                            <img src="{{ getCourseImage($course->thumbnail) }}"
                                                                 alt="course image">
                                                            @if($course->level)
                                                                <span class="course-tag">
                                                                <span>
                                                                    {{$course->courseLevel->title}}
                                                                </span>
                                                            </span>
                                                            @endif
                                                        </div>

                                                        <div class="course-item-info">
                                                            <a class="title"
                                                               href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                                                                {{$course->title}}
                                                            </a>

                                                            <div
                                                                class="d-flex align-itemes-center justify-content-between meta">
                                                                <div class="rating">
                                                                    <svg width="16" height="15" viewBox="0 0 16 15"
                                                                         fill="none"
                                                                         xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M14.9922 5.21624L10.2573 4.53056L8.1344 0.242104C8.09105 0.168678 8.02784 0.10754 7.9513 0.0649862C7.87476 0.0224321 7.78764 0 7.69892 0C7.6102 0 7.52308 0.0224321 7.44654 0.0649862C7.37 0.10754 7.3068 0.168678 7.26345 0.242104L5.14222 4.52977L0.40648 5.21624C0.31946 5.22916 0.237852 5.2645 0.170564 5.31841C0.103275 5.37231 0.0528901 5.44272 0.0249085 5.52194C-0.00307309 5.60116 -0.00757644 5.68614 0.01189 5.76762C0.0313563 5.8491 0.0740445 5.92394 0.135295 5.98398L3.57501 9.33111L2.76146 14.0591C2.74696 14.1436 2.75782 14.2304 2.79281 14.3094C2.8278 14.3883 2.88549 14.4564 2.95932 14.5058C3.03314 14.5551 3.12011 14.5838 3.2103 14.5886C3.30049 14.5933 3.39026 14.5739 3.46936 14.5325L7.6985 12.3153L11.9276 14.5333C12.0068 14.5746 12.0965 14.5941 12.1867 14.5893C12.2769 14.5846 12.3639 14.5559 12.4377 14.5066C12.5115 14.4572 12.5692 14.3891 12.6042 14.3101C12.6392 14.2311 12.6501 14.1444 12.6356 14.0599L11.822 9.3319L15.2634 5.98398C15.3253 5.92392 15.3685 5.84885 15.3883 5.76699C15.4082 5.68515 15.4039 5.59969 15.3758 5.52003C15.3478 5.44036 15.2972 5.36956 15.2295 5.31541C15.1618 5.26126 15.0797 5.22586 14.9922 5.21308V5.21624Z"
                                                                            fill="#FFC107"/>
                                                                    </svg>
                                                                    <span>{{translatedNumber($course->totalReview)}} ({{translatedNumber($course->total_reviews)}} {{__('common.Rating')}})</span>

                                                                </div>
                                                                <div class="enrolled-student">
                                                                    @if(!Settings('hide_total_enrollment_count') == 1)
                                                                        <a href="#">
                                                                            <svg width="16" height="18"
                                                                                 viewBox="0 0 16 18" fill="none"
                                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                                <path
                                                                                    d="M14.2508 3.87484L9.30078 1.0165C8.49245 0.549837 7.49245 0.549837 6.67578 1.0165L1.73411 3.87484C0.925781 4.3415 0.425781 5.20817 0.425781 6.14984V11.8498C0.425781 12.7832 0.925781 13.6498 1.73411 14.1248L6.68411 16.9832C7.49245 17.4498 8.49245 17.4498 9.30911 16.9832L14.2591 14.1248C15.0674 13.6582 15.5674 12.7915 15.5674 11.8498V6.14984C15.5591 5.20817 15.0591 4.34984 14.2508 3.87484ZM7.99245 5.1165C9.06745 5.1165 9.93411 5.98317 9.93411 7.05817C9.93411 8.13317 9.06745 8.99984 7.99245 8.99984C6.91745 8.99984 6.05078 8.13317 6.05078 7.05817C6.05078 5.9915 6.91745 5.1165 7.99245 5.1165ZM10.2258 12.8832H5.75911C5.08411 12.8832 4.69245 12.1332 5.06745 11.5748C5.63411 10.7332 6.73411 10.1665 7.99245 10.1665C9.25078 10.1665 10.3508 10.7332 10.9174 11.5748C11.2924 12.1248 10.8924 12.8832 10.2258 12.8832Z"
                                                                                    fill="#292D32"/>
                                                                            </svg>
                                                                            {{translatedNumber($course->total_enrolled)}} {{__('frontend.Students')}}
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="course-item-info-description">
                                                                {{ getLimitedText($course->about,120) }}
                                                            </div>

                                                            <div
                                                                class="course-item-footer d-flex justify-content-between">
                                                                <x-price-tag :price="$course->price"
                                                                             :text="$course->price_text"
                                                                             :discount="$course->discount_price"/>

                                                                @if(!onlySubscription())
                                                                    @auth()
                                                                        @if(!$course->isLoginUserEnrolled && !$course->isLoginUserCart)
                                                                            <a href="#" class="cart_store"
                                                                               data-id="{{$course->id}}">
                                                                                <svg width="23" height="20"
                                                                                     viewBox="0 0 23 20" fill="none"
                                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                                    <path
                                                                                        d="M7.16467 13.3359H18.8653C19.0059 13.3364 19.1428 13.2894 19.2551 13.202C19.3675 13.1146 19.4491 12.9917 19.4877 12.8519L22.0801 3.51851C22.1078 3.41929 22.1127 3.31476 22.0945 3.21323C22.0762 3.1117 22.0353 3.01597 21.975 2.93366C21.9143 2.85128 21.8361 2.78451 21.7464 2.73853C21.6566 2.69256 21.5579 2.66862 21.4577 2.6686H5.66957L5.20675 0.522304C5.17445 0.373931 5.09423 0.241358 4.97931 0.14642C4.86439 0.0514822 4.72163 -0.000159516 4.57453 3.70146e-07H0.645078C0.473992 3.70146e-07 0.309914 0.0702685 0.188939 0.195346C0.0679633 0.320424 0 0.490067 0 0.666954C0 0.843841 0.0679633 1.01348 0.188939 1.13856C0.309914 1.26364 0.473992 1.33391 0.645078 1.33391H4.05423L6.3933 12.1686C5.98505 12.3512 5.65023 12.6738 5.44536 13.082C5.24049 13.4902 5.17812 13.959 5.26877 14.4092C5.35942 14.8595 5.59754 15.2636 5.94294 15.5534C6.28834 15.8432 6.71986 16.0009 7.16467 15.9998H18.8653C19.0364 15.9998 19.2005 15.9296 19.3214 15.8045C19.4424 15.6794 19.5104 15.5098 19.5104 15.3329C19.5104 15.156 19.4424 14.9864 19.3214 14.8613C19.2005 14.7362 19.0364 14.6659 18.8653 14.6659H7.16467C6.99359 14.6659 6.82951 14.5957 6.70853 14.4706C6.58756 14.3455 6.51959 14.1759 6.51959 13.999C6.51959 13.8221 6.58756 13.6525 6.70853 13.5274C6.82951 13.4023 6.99359 13.332 7.16467 13.332V13.3359Z"
                                                                                        fill="url(#paint0_linear_2677_3208a5)"/>
                                                                                    <path
                                                                                        d="M6.52262 18.0031C6.52322 18.3985 6.63716 18.7848 6.85005 19.1133C7.06294 19.4418 7.36524 19.6976 7.71872 19.8486C8.07221 19.9995 8.46104 20.0387 8.83607 19.9612C9.2111 19.8838 9.5555 19.6931 9.82577 19.4134C10.096 19.1336 10.28 18.7773 10.3545 18.3894C10.429 18.0016 10.3906 17.5996 10.2442 17.2343C10.0979 16.869 9.85003 16.5568 9.53207 16.3371C9.21411 16.1173 8.8403 16 8.45786 15.9998C7.94433 16.0003 7.45198 16.2115 7.08908 16.5872C6.72617 16.9628 6.52242 17.4721 6.52262 18.0031Z"
                                                                                        fill="url(#paint1_linear_2677_3208a10)"/>
                                                                                    <path
                                                                                        d="M15.6513 18.0031C15.6519 18.3984 15.7657 18.7846 15.9785 19.113C16.1913 19.4415 16.4935 19.6974 16.8468 19.8484C17.2002 19.9993 17.5889 20.0387 17.9639 19.9614C18.3388 19.8841 18.6833 19.6937 18.9536 19.4142C19.224 19.1347 19.4082 18.7786 19.4829 18.3909C19.5576 18.0032 19.5196 17.6013 19.3735 17.236C19.2275 16.8706 18.98 16.5582 18.6623 16.3382C18.3447 16.1182 17.9711 16.0005 17.5888 15.9998C17.3343 15.9997 17.0823 16.0515 16.8472 16.1521C16.6121 16.2528 16.3984 16.4003 16.2185 16.5863C16.0386 16.7724 15.8959 16.9933 15.7985 17.2363C15.7012 17.4794 15.6512 17.74 15.6513 18.0031Z"
                                                                                        fill="url(#paint2_linear_2677_3208a30)"/>
                                                                                    <defs>
                                                                                        <linearGradient
                                                                                            id="paint0_linear_2677_3208a5"
                                                                                            x1="2.00048" y1="13.4568"
                                                                                            x2="20.837" y2="8.70962"
                                                                                            gradientUnits="userSpaceOnUse">
                                                                                            <stop
                                                                                                stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                                            <stop offset="1"
                                                                                                  stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                        </linearGradient>
                                                                                        <linearGradient
                                                                                            id="paint1_linear_2677_3208a10"
                                                                                            x1="2.00048" y1="13.4568"
                                                                                            x2="20.837" y2="8.70962"
                                                                                            gradientUnits="userSpaceOnUse">
                                                                                            <stop stop-color="#660AFB"/>
                                                                                            <stop offset="1"
                                                                                                  stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                        </linearGradient>
                                                                                        <linearGradient
                                                                                            id="paint2_linear_2677_3208a30"
                                                                                            x1="2.00048" y1="13.4568"
                                                                                            x2="20.837" y2="8.70962"
                                                                                            gradientUnits="userSpaceOnUse">
                                                                                            <stop stop-color="#660AFB"/>
                                                                                            <stop offset="1"
                                                                                                  stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                        </linearGradient>
                                                                                    </defs>
                                                                                </svg>

                                                                            </a>
                                                                        @endif
                                                                    @endauth
                                                                    @guest()
                                                                        @if(!$course->isGuestUserCart)
                                                                            <a href="#" class="cart_store"
                                                                               data-id="{{$course->id}}">
                                                                                <svg width="23" height="20"
                                                                                     viewBox="0 0 23 20" fill="none"
                                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                                    <path
                                                                                        d="M7.16467 13.3359H18.8653C19.0059 13.3364 19.1428 13.2894 19.2551 13.202C19.3675 13.1146 19.4491 12.9917 19.4877 12.8519L22.0801 3.51851C22.1078 3.41929 22.1127 3.31476 22.0945 3.21323C22.0762 3.1117 22.0353 3.01597 21.975 2.93366C21.9143 2.85128 21.8361 2.78451 21.7464 2.73853C21.6566 2.69256 21.5579 2.66862 21.4577 2.6686H5.66957L5.20675 0.522304C5.17445 0.373931 5.09423 0.241358 4.97931 0.14642C4.86439 0.0514822 4.72163 -0.000159516 4.57453 3.70146e-07H0.645078C0.473992 3.70146e-07 0.309914 0.0702685 0.188939 0.195346C0.0679633 0.320424 0 0.490067 0 0.666954C0 0.843841 0.0679633 1.01348 0.188939 1.13856C0.309914 1.26364 0.473992 1.33391 0.645078 1.33391H4.05423L6.3933 12.1686C5.98505 12.3512 5.65023 12.6738 5.44536 13.082C5.24049 13.4902 5.17812 13.959 5.26877 14.4092C5.35942 14.8595 5.59754 15.2636 5.94294 15.5534C6.28834 15.8432 6.71986 16.0009 7.16467 15.9998H18.8653C19.0364 15.9998 19.2005 15.9296 19.3214 15.8045C19.4424 15.6794 19.5104 15.5098 19.5104 15.3329C19.5104 15.156 19.4424 14.9864 19.3214 14.8613C19.2005 14.7362 19.0364 14.6659 18.8653 14.6659H7.16467C6.99359 14.6659 6.82951 14.5957 6.70853 14.4706C6.58756 14.3455 6.51959 14.1759 6.51959 13.999C6.51959 13.8221 6.58756 13.6525 6.70853 13.5274C6.82951 13.4023 6.99359 13.332 7.16467 13.332V13.3359Z"
                                                                                        fill="url(#paint0_linear_2677_3208e55)"/>
                                                                                    <path
                                                                                        d="M6.52262 18.0031C6.52322 18.3985 6.63716 18.7848 6.85005 19.1133C7.06294 19.4418 7.36524 19.6976 7.71872 19.8486C8.07221 19.9995 8.46104 20.0387 8.83607 19.9612C9.2111 19.8838 9.5555 19.6931 9.82577 19.4134C10.096 19.1336 10.28 18.7773 10.3545 18.3894C10.429 18.0016 10.3906 17.5996 10.2442 17.2343C10.0979 16.869 9.85003 16.5568 9.53207 16.3371C9.21411 16.1173 8.8403 16 8.45786 15.9998C7.94433 16.0003 7.45198 16.2115 7.08908 16.5872C6.72617 16.9628 6.52242 17.4721 6.52262 18.0031Z"
                                                                                        fill="url(#paint1_linear_2677_3208a87)"/>
                                                                                    <path
                                                                                        d="M15.6513 18.0031C15.6519 18.3984 15.7657 18.7846 15.9785 19.113C16.1913 19.4415 16.4935 19.6974 16.8468 19.8484C17.2002 19.9993 17.5889 20.0387 17.9639 19.9614C18.3388 19.8841 18.6833 19.6937 18.9536 19.4142C19.224 19.1347 19.4082 18.7786 19.4829 18.3909C19.5576 18.0032 19.5196 17.6013 19.3735 17.236C19.2275 16.8706 18.98 16.5582 18.6623 16.3382C18.3447 16.1182 17.9711 16.0005 17.5888 15.9998C17.3343 15.9997 17.0823 16.0515 16.8472 16.1521C16.6121 16.2528 16.3984 16.4003 16.2185 16.5863C16.0386 16.7724 15.8959 16.9933 15.7985 17.2363C15.7012 17.4794 15.6512 17.74 15.6513 18.0031Z"
                                                                                        fill="url(#paint2_linear_2677_3208c85)"/>
                                                                                    <defs>
                                                                                        <linearGradient
                                                                                            id="paint0_linear_2677_3208e55"
                                                                                            x1="2.00048" y1="13.4568"
                                                                                            x2="20.837" y2="8.70962"
                                                                                            gradientUnits="userSpaceOnUse">
                                                                                            <stop
                                                                                                stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                                            <stop offset="1"
                                                                                                  stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                        </linearGradient>
                                                                                        <linearGradient
                                                                                            id="paint1_linear_2677_3208a87"
                                                                                            x1="2.00048" y1="13.4568"
                                                                                            x2="20.837" y2="8.70962"
                                                                                            gradientUnits="userSpaceOnUse">
                                                                                            <stop stop-color="#660AFB"/>
                                                                                            <stop offset="1"
                                                                                                  stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                        </linearGradient>
                                                                                        <linearGradient
                                                                                            id="paint2_linear_2677_3208c85"
                                                                                            x1="2.00048" y1="13.4568"
                                                                                            x2="20.837" y2="8.70962"
                                                                                            gradientUnits="userSpaceOnUse">
                                                                                            <stop stop-color="#660AFB"/>
                                                                                            <stop offset="1"
                                                                                                  stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                        </linearGradient>
                                                                                    </defs>
                                                                                </svg>

                                                                            </a>
                                                                        @endif
                                                                    @endguest
                                                                @endif
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                @else
                                    @include(theme('profile._no_data'))
                                @endif
                            </div>
                        @endif
                        @if($section_instructor_tab)
                            {{--instructor tab--}}
                            <div class="tab-pane fade" id="pills-instructor" role="tabpanel"
                                 aria-labelledby="pills-contact-tab">
                                <div class="instractors_wrapper p-0 m-0">
                                    @if($instructors->count() > 0)
                                        <div class="row">
                                            @foreach($instructors as $instructor)
                                                <div class="col-md-6 col-lg-4 col-xl-3">
                                                    <div class="single_instractor mb_30">
                                                        <a href="{{route('users.profile',$instructor->id)}}"
                                                           class="thumb">
                                                            <img
                                                                src="{{getProfileImage(@$instructor->image,$instructor->name)}}"
                                                                alt="">
                                                        </a>
                                                        <a href="{{route('users.profile',$instructor->id)}}">
                                                            <h4>{{$instructor->name}}</h4></a>
                                                        @if($instructor->job_title)
                                                            <span>{{@$instructor->job_title}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        @include(theme('profile._no_data'))
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if($section_education_tab)
                            <div class="tab-pane fade" id="pills-education" role="tabpanel"
                                 aria-labelledby="pills-contact-tab">
                                @if($user->userEducations->count() > 0)
                                    <ul class="list-group list-group-flush">
                                        @foreach($user->userEducations as $education )
                                            <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                                <div>
                                                    <h4 class="mb-1 f_w_600">{{$education->institution}}</h4>
                                                    <p class="text-muted f_w_500">{{$education->degree}}</p>
                                                    <small
                                                        class="text-muted">{{showDate($education->start_date)}} @if($education->end_date)
                                                            -
                                                        @endif {{showDate($education->end_date)}}</small>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    @include(theme('profile._no_data'))
                                @endif
                            </div>
                        @endif
                        @if($section_experience_tab)
                            <div class="tab-pane fade" id="pills-experience" role="tabpanel"
                                 aria-labelledby="pills-contact-tab">
                                @if($user->userExperiences->count() > 0)
                                    <ul class="list-group list-group-flush">

                                        @foreach($user->userExperiences as $experience )
                                            <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                                <div>
                                                    <h4 class="mb-1 f_w_600">{{$experience->title}}</h4>
                                                    <p class="text-muted f_w_500">{{$experience->company_name}}</p>
                                                    @if($experience->duration())
                                                        <small class="text-muted">{{showDate($experience->start_date)}}
                                                            - {{$experience->currently_working?'Present':showDate($experience->end_date)}}
                                                            [ {{$experience->duration()}} ]</small>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach


                                    </ul>
                                @else
                                    @include(theme('profile._no_data'))
                                @endif
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- profile info -->
@endsection
