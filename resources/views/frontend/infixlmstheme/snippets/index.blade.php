@include(theme('snippets.components._row_12'))
@include(theme('snippets.components._row_6'))
@include(theme('snippets.components._row_6_1'))
@include(theme('snippets.components._row_4_4_4'))
@include(theme('snippets.components._row_3_6_3'))
@include(theme('snippets.components._row_3_3_3_3'))
@include(theme('snippets.components._articles_list'))
@include(theme('snippets.components._featured_article'))
@include(theme('snippets.components._thumbnail_panel'))
@include(theme('snippets.components._page_header'))
@include(theme('snippets.components._text'))
@include(theme('snippets.components._jumbotron'))
@include(theme('snippets.components._photo'))
@include(theme('snippets.components._audio'))
@include(theme('snippets.components._video'))
@include(theme('snippets.components._youtube'))
@include(theme('snippets.components._vimeo'))
@include(theme('snippets.components._googlemap'))
@include(theme('snippets.components._heading_1'))
@include(theme('snippets.components._heading_2'))
@include(theme('snippets.components._form'))
@include(theme('snippets.components._banner'))

{{--pages--}}
@if(isModuleActive('Affiliate'))
    @include(theme('snippets.pages.affiliate'))
@endif
@include(theme('snippets.pages.about-us'))
@include(theme('snippets.pages.become-instructor'))
{{--@include(theme('snippets.pages.blogs'))--}}
@include(theme('snippets.pages.home'))
@include(theme('snippets.pages.certificate-verification'))
@include(theme('snippets.pages.contact'))
@include(theme('snippets.pages.instructors'))

@include(theme('snippets.pages.courses'))
@include(theme('snippets.pages.quizzes'))
@include(theme('snippets.pages.classes'))
@include(theme('snippets.pages.free'))
@include(theme('snippets.pages.app'))

@if(isModuleActive('Appointment'))
    @include(theme('snippets.pages.appointment'))
@endif


@if(isModuleActive('UpcomingCourse'))
    @include(theme('snippets.pages.upcoming_courses'))
@endif

@if(isModuleActive('Store'))
    @include(theme('snippets.pages.store'))
@endif
