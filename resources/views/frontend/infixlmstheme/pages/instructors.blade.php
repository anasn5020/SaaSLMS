@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('frontend.Instructor')}}
@endsection
@section('css')
    <style>


    </style>
@endsection
@section('js')
    <script>

        var SITEURL = "{{route('instructors')}}";
        var page = 1;
        load_more(page);
        $(window).scroll(function () {
            console.log($(window).scrollTop());
            console.log($(window).height());
            console.log($("#results").height());
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 600) {
                page++;
                load_more(page);
            }


        });

        function load_more(page) {
            $.ajax({
                url: SITEURL + "?page=" + page,
                type: "get",
                datatype: "html",
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
                    $("#results").append(data); //append data into #results element


                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('No response from server');
                });

        }
    </script>

@endsection

@section('mainContent')

    <x-breadcrumb :banner="$frontendContent->instructor_page_banner"
                  :title="trans('frontend.Start your education Career with us')"
                  :subTitle="$frontendCtrans('frontend.Instructors')"/>


    <x-instructors-page-populer-section :instructors="$instructors"/>
    <x-instructors-page-section :instructors="$instructors"/>

    <x-instructors-page-become-instructor-section/>

@endsection
