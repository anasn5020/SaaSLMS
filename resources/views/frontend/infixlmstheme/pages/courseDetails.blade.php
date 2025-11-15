@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} |  {{$course->title}}
@endsection
@section('og_image')
    {{getCourseImage($course->image)}}
@endsection
@section('meta_title')
    {{$course->meta_keywords}}
@endsection
@section('meta_description')
    {{$course->meta_description}}
@endsection
@section('css')
    <style>
        .course__details .video_screen {
            background-image: url('{{getCourseImage(@$course->image)}}');
        }

        iframe {
            position: relative !important;
        }
    </style>
    <link href="{{asset('public/frontend/infixlmstheme/css/videopopup.css')}}{{assetVersion()}}" rel="stylesheet"/>
    <link href="{{asset('public/frontend/infixlmstheme/css/video.popup.css')}}{{assetVersion()}}" rel="stylesheet"/>
    @if(isModuleActive('WaitList'))
        <link href="{{asset('public/frontend/infixlmstheme/css/select2.min.css')}}{{assetVersion()}}" rel="stylesheet"/>
    @endif
@endsection


@section('mainContent')

    {{--    <x-breadcrumb :banner="$frontendContent->course_page_banner"--}}
    {{--                  :title="trans('frontend.Course Details')"--}}
    {{--                  :subTitle="$course->title"--}}
    {{--    />--}}



    <x-course-deatils-page-section :course="$course" :request="$request" :isEnrolled="$isEnrolled"/>


    @if ($course->host=='VdoCipher')

        @include(theme('partials._player_modal'))
    @endif

@endsection

@section('js')

    <script src="{{asset('public/frontend/infixlmstheme/js/class_details.js')}}"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/videopopup.js')}}"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/video.popup.js')}}"></script>
    @if(isModuleActive('WaitList'))
        <script src="{{asset('public/frontend/infixlmstheme/js/city.js')}}"></script>
        <script src="{{asset('public/frontend/infixlmstheme/js/select2.min.js')}}"></script>
    @endif
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                //active tab state
                $('a[data-bs-toggle="tab"]').on('show.bs.tab', function (e) {
                    localStorage.setItem('activeCourseTab', $(e.target).attr('href'));
                });
                let activeCourseTab = localStorage.getItem('activeCourseTab');

                if (activeCourseTab) {
                    $('a[href="' + activeCourseTab + '"]').tab('show');
                }
            });
        })(jQuery);


        $("#formSubmitBtn").on("click", function (e) {
            e.preventDefault();

            var form = $('#deleteCommentForm');
            var url = form.attr('action');
            var element = form.data('element');
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function (data) {
                    location.reload();
                }
            });
            var el = '#' + element;
            $(el).hide('slow');
            $('#deleteComment').modal('hide');

        });
    </script>

    <script>
        function deleteCommnet(item, element) {
            let form = $('#deleteCommentForm')
            form.attr('action', item);
            form.attr('data-element', element);
        }


    </script>


    <script>
        const SITEURL = "{{courseDetailsUrl($course->id, $course->type, $course->slug)}}";
        let commentPage = 1;
        let reviewPage = 1;
        let hasComment = true;
        let hasReview = true;
        let hasCommentComplete = true;
        let hasReviewComplete = true;

        function loadMoreContent(page, type, completeFlag, hasMoreFlag, appendToSelector) {
            if (page ? 1 : $(`#${type === 'comment' ? 'QA' : 'Reviews'}-tab`).hasClass('active')) {
                if (completeFlag && hasMoreFlag) {
                    completeFlag = false;
                    $.ajax({
                        url: `${SITEURL}?page=${page}`,
                        type: "get",
                        datatype: "html",
                        data: { type },
                    }).done(function (data) {
                        if (data === "") {
                            hasMoreFlag = false;
                        } else {
                            $(appendToSelector).append(data);
                        }
                        completeFlag = true;
                    });
                }
            }
            return { completeFlag, hasMoreFlag };
        }

        function load_more(page) {
            ({ completeFlag: hasCommentComplete, hasMoreFlag: hasComment } = loadMoreContent(page, 'comment', hasCommentComplete, hasComment, "#conversition_box"));
        }

        function load_more_review(page) {
            ({ completeFlag: hasReviewComplete, hasMoreFlag: hasReview } = loadMoreContent(page, 'review', hasReviewComplete, hasReview, "#customers_reviews"));
        }

        function onScroll() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 400) {
                if (hasComment) {
                    commentPage++;
                    load_more(commentPage);
                }
                if (hasReview) {
                    reviewPage++;
                    load_more_review(reviewPage);
                }
            }
        }

        $(window).on('scroll', onScroll);

        $(function () {
            function updateHeaderSize() {
                let headerSize = $('header').outerHeight() + 'px';
                $(':root').css('--header-size', headerSize);
            }

            updateHeaderSize();
            $(window).on('resize', updateHeaderSize);
        });

        // Initial load
        load_more(commentPage);
        load_more_review(reviewPage);
    </script>

@endsection
