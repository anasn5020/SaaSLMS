@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('frontendmanage.Home')}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')
    @if(!empty($blocks))
        @foreach($blocks as $block)
            @if($block->id==1)
                <x-home-page-banner :homeContent="$homeContent"/>
            @elseif($block->id==3)
                @if($homeContent->show_category_section==1)
                    <x-home-page-category-section :homeContent="$homeContent" :categories="$categories"/>
                @endif
            @elseif($block->id==4)
                @if($homeContent->show_instructor_section==1)
                    <x-home-page-instructor-section :homeContent="$homeContent"/>
                @endif
            @elseif($block->id==5)
                @if($homeContent->show_course_section==1)
                    <x-home-page-course-section :homeContent="$homeContent"/>
                @endif
            @elseif($block->id==6)
                @if($homeContent->show_best_category_section==1)
                    <x-home-page-best-category-section :homeContent="$homeContent" :categories="$categories"/>
                @endif
            @elseif($block->id==7)
                @if($homeContent->show_quiz_section==1)
                    <x-home-page-quiz-section :homeContent="$homeContent"/>
                @endif
            @elseif($block->id==8)
                @if($homeContent->show_testimonial_section==1)
                    <x-home-page-testimonial-section :homeContent="$homeContent"/>
                @endif
            @elseif($block->id==9)
                @if($homeContent->show_sponsor_section==1)
                    <x-home-page-brand-section :homeContent="$homeContent"/>
                @endif
            @elseif($block->id==10)
                @if($homeContent->show_article_section==1)
                    <x-home-page-blog-section :homeContent="$homeContent"/>
                @endif
            @elseif($block->id==11)
                @if($homeContent->show_become_instructor_section==1)
                    @if(@Settings('instructor_reg') )
                        <x-home-page-become-instructor-section :homeContent="$homeContent"/>
                    @endif
                @endif
            @elseif($block->id==16)
                @if($homeContent->show_how_to_buy==1)
                    <x-home-page-how-to-buy :homeContent="$homeContent"/>
                @endif
            @elseif($block->id==17)
                @if($homeContent->show_home_page_faq==1)
                    <x-home-page-faq :homeContent="$homeContent"/>
                @endif
            @endif
        @endforeach
    @endif
@endsection
