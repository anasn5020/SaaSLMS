<li>
    <a href="#" class="has-arrow" aria-expanded="false">
        <div class="nav_icon_small"><span class="fa fa-desktop"></span></div>
        <div class="nav_title"><span>{{__('frontendmanage.Frontend CMS')}}</span></div>
    </a>
    <ul>
        @if (Settings('frontend_active_theme')=='compact')
            <li>
                <a href="{{route('frontend.showTopBarSettings')}}">{{__('frontendmanage.Top Bar Setting')}}</a>
            </li>
        @endif

        @if(permissionCheck('frontend.headermenu'))
            <li>
                <a href="{{route('frontend.headermenu')}}">{{ __('setting.Header Menu') }}</a>
            </li>
        @endif
        @if(permissionCheck('frontend.menusetting'))
            <li>
                <a href="{{route('frontend.menusetting')}}">{{ __('setting.Menu Setting') }}</a>
            </li>
        @endif
        @if (permissionCheck('frontend.sliders'))
            <li><a href="{{ route('frontend.sliders.index') }}"> {{ __('frontendmanage.Slider') }}</a></li>
        @endif

        @if (permissionCheck('frontend.sliders.setting'))
            <li>
                <a href="{{ Route::has('frontend.sliders.setting')?route('frontend.sliders.setting'):'' }}"> {{ __('frontendmanage.Slider Setting') }}</a>
            </li>
        @endif

        @if (Settings('frontend_active_theme') == 'tvt' && permissionCheck('frontend.why.index'))
            <li><a href="{{ route('frontend.why.index') }}"> {{ __('frontendmanage.Why Choose') }}</a></li>
        @endif
        @if (permissionCheck('frontend.homeContent'))
            <li><a href="{{ route('frontend.homeContent') }}"> {{ __('frontendmanage.Home Content') }}</a></li>
        @endif

        @if (permissionCheck('frontend.pageContent'))
            <li><a href="{{ route('frontend.pageContent') }}"> {{ __('frontendmanage.Page Content') }}</a></li>
        @endif

        @if (permissionCheck('frontend.privacy_policy'))
            <li><a href="{{ route('frontend.privacy_policy') }}"> {{ __('frontendmanage.Privacy Policy') }}</a></li>
        @endif
        @if (permissionCheck('frontend.testimonials'))
            <li><a href="{{ route('frontend.testimonials') }}"> {{ __('frontendmanage.Testimonials') }}</a></li>
        @endif
        {{--        @if (permissionCheck('frontend.sectionSetting'))--}}
        {{--            <li><a href="{{ route('frontend.sectionSetting') }}"> {{ __('frontendmanage.Section Setting') }}</a></li>--}}
        {{--        @endif--}}
        @if (permissionCheck('frontend.socialSetting'))
            <li><a href="{{ route('frontend.socialSetting') }}"> {{ __('frontendmanage.Social Setting') }}</a></li>
        @endif
        @if (permissionCheck('frontend.AboutPage'))
            <li><a href="{{ route('frontend.AboutPage') }}"> {{ __('frontendmanage.About') }}</a></li>
        @endif


        @if (permissionCheck('frontend.ContactPageContent'))
            <li><a href="{{ route('frontend.ContactPageContent') }}"> {{ __('frontendmanage.Contact Us') }}</a></li>
        @endif
        @if (permissionCheck('frontend.page.index'))
            <li><a href="{{ route('frontend.page.index') }}"> {{ __('frontendmanage.Pages') }}</a></li>
        @endif
        @if (permissionCheck('frontend.becomeInstructor'))
            <li><a href="{{ route('frontend.becomeInstructor') }}"> {{ __('frontendmanage.Become Instructor') }}</a>
            </li>
        @endif
        @if (permissionCheck('frontend.sponsors.index'))
            <li><a href="{{ route('frontend.sponsors.index') }}"> {{ __('sponsor.Sponsors') }}</a></li>
        @endif


        @if(permissionCheck('popup-content.index'))
            <li>
                <a href="{{route('popup-content.index')}}">{{ __('frontendmanage.Popup Content') }}</a>
            </li>
        @endif

        @if(permissionCheck('footerSetting.footer.index'))
            <li>
                <a href="{{route('footerSetting.footer.index')}}">{{ __('setting.Footer Setting') }}</a>
            </li>
        @endif


        @if(permissionCheck('loginpage.index'))
            <li>
                <a href="{{route('frontend.loginpage.index')}}">{{ __('frontendmanage.Login & Registration') }}</a>
            </li>
        @endif

        @if (permissionCheck('frontend.faq.index'))
            <li><a href="{{ route('frontend.faq.index') }}">   {{ __('subscription.FAQ') }}</a></li>
        @endif
    </ul>
</li>
