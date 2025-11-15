@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} |  {{$course->title}}
@endsection
@section('og_image')
    {{getCourseImage($course->image)}}
@endsection
{{--@section('meta_title')--}}
{{--    {{$course->meta_keywords}}--}}
{{--@endsection--}}
{{--@section('meta_description')--}}
{{--    {{$course->meta_description}}--}}
{{--@endsection--}}
@section('css')
    <style>
        .course__details .video_screen {
            background-image: url('{{getCourseImage(@$course->image)}}');
        }

        iframe {
            position: relative !important;
        }
    </style>
    <link href="{{asset('public/frontend/infixlmstheme/css/videopopup.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/frontend/infixlmstheme/css/video.popup.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/frontend/infixlmstheme/css/class_details.css')}}" rel="stylesheet"/>

    <link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/css/jquery.nice-number.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme/css/store_style.css') }}">

    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme/css/slicknav.css')}}">
    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme/js/vendor/calender_js/core/main.css')}}">
    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme/js/vendor/calender_js/daygrid/main.css')}}">
    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme/js/vendor/calender_js/timegrid/main.css')}}">
    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme/js/vendor/calender_js/list/main.css')}}">
    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme/css/jquery.ez-plus.css')}}">

@endsection


@section('mainContent')

        <x-breadcrumb :banner="$frontendContent->course_page_banner"
                      title="Product Details"
                      :subTitle="$course->title"/>



    <x-product-deatils-page-section :course="$course" :request="$request" :isEnrolled="$isEnrolled"/>
    @include(theme('partials._delete_model'))

@endsection

@section('js')

    <script src="{{asset('public/frontend/infixlmstheme/js/class_details.js')}}"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/videopopup.js')}}"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/video.popup.js')}}"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/jquery.nice-number.min.js')}}"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/jquery.ez-plus.js') }}"></script>

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

        var SITEURL = "{{courseDetailsUrl($course->id,$course->type,$course->slug)}}";
        var page = 1;
        load_more(page);
        $(window).scroll(function () { //detect page scroll
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 400) {
                page++;
                load_more(page);
            }


        });

        function load_more(page) {
            $.ajax({
                url: SITEURL + "?page=" + page,
                type: "get",
                datatype: "html",
                data: {'type': 'comment'},
                beforeSend: function () {
                    $('.ajax-loading').show();
                }
            })
                .done(function (data) {
                    if (data.length == 0) {

                        //notify user if nothing to load
                        $('.ajax-loading').html("");
                        return;
                    }
                    $('.ajax-loading').hide(); //hide loading animation once data is received
                    $("#conversition_box").append(data); //append data into #results element


                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('No response from server');
                });

        }


        load_more_review(page);


        $(window).scroll(function () { //detect page scroll
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 400) {
                page++;
                load_more_review(page);
            }


        });

        function load_more_review(page) {
            $.ajax({
                url: SITEURL + "?page=" + page,
                type: "get",
                datatype: "html",
                data: {'type': 'review'},
                beforeSend: function () {
                    $('.ajax-loading').show();
                }
            })
                .done(function (data) {
                    if (data.length == 0) {

                        //notify user if nothing to load
                        $('.ajax-loading').html("");
                        return;
                    }
                    $('.ajax-loading').hide(); //hide loading animation once data is received
                    $("#customers_reviews").append(data); //append data into #results element


                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('No response from server');
                });

        }

        $(document).ready(function () {
            (function () {
                "use strict";
                jQuery(document).ready(function () {
                    $(".shop-details-product-count").niceNumber();
                });
            })();
        });

    </script>

@endsection
