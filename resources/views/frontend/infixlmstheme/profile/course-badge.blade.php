@section('title', __('frontend.Badge Unlocked') . ' | ' . Settings('site_title'))
@section('meta_title', __('frontend.I earned the') . ' ' . $courseBadge->course->title . ' ' . __('frontend.badge on') . ' ' . Settings('site_title'))
@section('meta_description', __('frontend.I’m unlocking badges and developing my skills on new technologies, tools and frameworks. Cheer me on'))
@section('og_image', getCourseImage($courseBadge->course->image))



@include(theme('partials._header'))
@include(theme('partials._menu'))


<style>
    .single_course_badge_content{
        padding: 60px 20px;
    }

    .single_course_badge_title{
        font-size: 20px;
        font-weight: 500;
        margin-top: 30px;
    }

    .badge_student_info{
        margin: 0 auto;
        width: fit-content;
        margin-top: 50px;
        text-align: center;
        background: var(--footer_background_color, #1F2B40) !important;
        padding: 20px;
        border-radius: 10px;
        min-width: 360px;
        max-width: 100%;
        position: relative;
        padding-top: 30px;
    }

    .badge_student_info .title{
        text-align: center;
        position: absolute;
        top: -20px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--system_primery_color);
        background-size: 200%;
        padding: 8px 16px;
        border-radius: 50px;
        color: #ffffff;
        white-space: nowrap;
    }

    .badge_student_info .photo img{
        text-align: center;
        height: 60px;
        width: 60px;
        border-radius: 50%;
        object-fit: cover;
        object-position: center;
        margin: 0 auto;
        display: block;
        margin-bottom: 8px;
    }

    .badge_student_info .name{
        text-align: center;
        font-size: 28px;
        margin-bottom: 0px;
        font-weight: 500;
        color: #ffffff;
    }

    .badge_student_info .date{
        text-align: center;
        color: #ffffff;
        font-size: 16px;
    }

    .single_course_badge_content .img-thumbnail img{
        width: 300px;
        height: auto;
    }

    @media (max-width: 579px){
        .single_course_badge_content .img-thumbnail img{
            width: 260px;
        }

        .badge_student_info .name{
            font-size: 22px;
        }

        .badge_student_info .date{
            font-size: 14px;
        }
        .badge_student_info{
            min-width: 100%;
        }
    }
</style>


<div class="container single_course_badge_content">
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="text-center">
                <div class="img img-thumbnail border-0">
                    <img
                        src="{{asset($courseBadge->course->course_badge)}}"
                        alt="">
                </div>

                <p class="single_course_badge_title">{{ __('frontend.I earned the') . ' ' . $courseBadge->course->title . ' ' . __('frontend.badge on') . ' ' . Settings('site_title')}}
                </p>
            </div>

            <div class="badge_student_info">
                <div class="title">
                    {{__('frontend.Badge earned by')}}
                </div>

                <div class="photo">
                    <img src="{{asset($courseBadge->user->avatar)}}" alt="{{asset($courseBadge->user->name)}}">

                    <p class="name">
                        {{ $courseBadge->user->name }}
                    </p>

                    <p class="date">
                        {{ showDate(Carbon\Carbon::parse($courseBadge->created_at)) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@include(theme('partials._footer'))

