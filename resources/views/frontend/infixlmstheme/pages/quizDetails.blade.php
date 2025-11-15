@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} |  {{$course->title}}
@endsection

@section('css')
    <style>
        iframe {
            position: relative !important;
        }
    </style>
    {{-- <link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/css/class_details.css')}}{{assetVersion()}}"/> --}}
    {{-- <link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/css/quiz_details.css')}}{{assetVersion()}}"/> --}}
    @if(isModuleActive('WaitList'))
        <link href="{{asset('public/frontend/infixlmstheme/css/select2.min.css')}}{{assetVersion()}}" rel="stylesheet"/>
    @endif
@endsection
@section('meta_title')
    {{$course->meta_keywords}}
@endsection
@section('meta_description')
    {{$course->meta_description}}
@endsection
@section('og_image')
    {{getCourseImage($course->image)}}
@endsection
@section('mainContent')

    <x-breadcrumb :banner="$frontendContent->quiz_page_banner"
                  :title="$course->title"
                  :subTitle="trans('frontend.Quiz Details')"/>

    <x-quiz-details-page-section :course="$course" :request="$request" :isEnrolled="$isEnrolled"/>

@endsection

@section('js')
    <script src="{{ asset('public/frontend/infixlmstheme') }}/js/html2pdf.bundle.js{{assetVersion()}}"></script>
    <script src="{{ asset('public/frontend/infixlmstheme/js/quiz_details.js') }}{{assetVersion()}}"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/class_details.js')}}{{assetVersion()}}"></script>
    @if(isModuleActive('WaitList'))
        <script src="{{asset('public/frontend/infixlmstheme/js/city.js')}}{{assetVersion()}}"></script>
        <script src="{{asset('public/frontend/infixlmstheme/js/select2.min.js')}}{{assetVersion()}}"></script>
    @endif
    <script>
        "use strict";
        $(window).on("scroll", function () {
            const scrollTopPosition = $(window).scrollTop();
            if (scrollTopPosition > 200) {
                $(".course_sidebar .quiz_details_thumb").slideUp(400);
            } else {
                $(".course_sidebar .quiz_details_thumb").slideDown(400);
            }
        });

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
