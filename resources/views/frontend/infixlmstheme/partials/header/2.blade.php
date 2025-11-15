<link rel="stylesheet" href="{{themeAsset('css/sections/homepage_v7.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/css/homepageV7/header-v7.css')}}">

<style>
    .heading-category-dropdown ul {
        max-height: calc(100vh - 100px);
        overflow: auto;
        padding-left: 0;
        padding-right: 0;
    }

    .heading-category-dropdown ul li {
        position: relative;
        padding-left: 25px;
        padding-right: 25px;
    }

    .heading-category-dropdown ul li ul {
        position: fixed;
        right: auto !important;
    }

    .mobile-search .heading-search-box {
        display: none;
    }

    div#mobileSearchToggle {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
    }

    @media (min-width: 992px) and (max-width: 1200px) {
        .position-md-relative {
            position: relative;
        }

        .mobile-search .heading-search-box.mobile-visible input {
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .mobile-search .heading-search-box {
            position: absolute;
            top: var(--header-height);
            width: 100%;
            left: 0;
            min-width: 300px;
        }
    }

    @media (max-width: 767px) {
        .mobile-search .heading-search-box {
            position: absolute;
            top: var(--header-height);
            width: 100%;
            left: 0;
            min-width: 300px;
        }

        .mobile-search .heading-search-box.mobile-visible input {
            background: #ffffff;
            border-radius: 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .mobile-search .heading-search-box.mobile-visible input:is(:focus, :active) {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2) !important;
        }
    }

    @media (min-width: 992px) and (max-width: 1200px) {
        .mobile-search .heading-search-box {
            left: auto;
            right: 100%;
            position: absolute;
            top: var(--header-height);
        }

        .mobile-search .heading-search-box.mobile-visible input {
            width: 300px;
        }
    }

</style>

<header class="heading" id="{{Settings('fixed_navbar_in_frontend')!='no'?'sticky-header':''}}">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{url('/')}}" class="heading-logo d-block">
                            <img src="{{getLogoImage(Settings('logo') )}}" class="home d-block" alt="{{ Settings('site_name')  }}">
                        </a>
                        @if(Settings('category_show'))
                            <div class="heading-category">
                                <div class="heading-category-inner d-flex align-items-center" id="showCateDrop">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5.216 0H0.58C0.426174 0 0.278649 0.061107 0.169878 0.169878C0.0611069 0.278649 0 0.426174 0 0.58V5.216C0 5.29217 0.0150021 5.36759 0.0441499 5.43796C0.0732976 5.50833 0.11602 5.57226 0.169878 5.62612C0.223736 5.67998 0.287675 5.7227 0.358044 5.75185C0.428412 5.781 0.503833 5.796 0.58 5.796H5.216C5.36983 5.796 5.51735 5.73489 5.62612 5.62612C5.73489 5.51735 5.796 5.36983 5.796 5.216V0.58C5.796 0.426174 5.73489 0.278649 5.62612 0.169878C5.51735 0.061107 5.36983 0 5.216 0Z"
                                            fill="url(#paint0_linear_2444_2023)"/>
                                        <path
                                            d="M12.1691 8.62148e-07H7.53313C7.3793 8.62148e-07 7.23177 0.0611078 7.123 0.169879C7.01423 0.27865 6.95312 0.426175 6.95312 0.580001V5.216C6.95313 5.29217 6.96812 5.36759 6.99727 5.43796C7.02642 5.50833 7.06914 5.57227 7.123 5.62612C7.17686 5.67998 7.2408 5.7227 7.31117 5.75185C7.38154 5.781 7.45696 5.796 7.53313 5.796H12.1701C12.2463 5.796 12.3217 5.781 12.3921 5.75185C12.4624 5.7227 12.5264 5.67998 12.5802 5.62612C12.6341 5.57227 12.6768 5.50833 12.706 5.43796C12.7351 5.36759 12.7501 5.29217 12.7501 5.216V0.580001C12.7501 0.50375 12.7351 0.428247 12.7059 0.357813C12.6767 0.287379 12.6339 0.223396 12.5799 0.169525C12.5259 0.115654 12.4619 0.0729522 12.3914 0.0438634C12.3209 0.0147745 12.2454 -0.000130605 12.1691 8.62148e-07Z"
                                            fill="url(#paint1_linear_2444_2023)"/>
                                        <path
                                            d="M5.216 6.95508H0.58C0.426174 6.95508 0.278649 7.01618 0.169878 7.12495C0.0611069 7.23373 0 7.38125 0 7.53508V12.1671C0 12.2433 0.0150021 12.3187 0.0441499 12.389C0.0732976 12.4594 0.11602 12.5233 0.169878 12.5772C0.223736 12.6311 0.287675 12.6738 0.358044 12.7029C0.428412 12.7321 0.503833 12.7471 0.58 12.7471H5.216C5.29217 12.7471 5.36759 12.7321 5.43796 12.7029C5.50833 12.6738 5.57226 12.6311 5.62612 12.5772C5.67998 12.5233 5.7227 12.4594 5.75185 12.389C5.781 12.3187 5.796 12.2433 5.796 12.1671V7.53008C5.79468 7.37712 5.73299 7.23088 5.62436 7.12318C5.51574 7.01549 5.36896 6.95507 5.216 6.95508Z"
                                            fill="url(#paint2_linear_2444_2023)"/>
                                        <path
                                            d="M12.1691 6.95508H7.53313C7.3793 6.95508 7.23177 7.01618 7.123 7.12496C7.01423 7.23373 6.95312 7.38126 6.95312 7.53508V12.1671C6.95313 12.2433 6.96812 12.3187 6.99727 12.389C7.02642 12.4594 7.06914 12.5233 7.123 12.5772C7.17686 12.6311 7.2408 12.6738 7.31117 12.7029C7.38154 12.7321 7.45696 12.7471 7.53313 12.7471H12.1701C12.2463 12.7471 12.3217 12.7321 12.3921 12.7029C12.4624 12.6738 12.5264 12.6311 12.5802 12.5772C12.6341 12.5233 12.6768 12.4594 12.706 12.389C12.7351 12.3187 12.7501 12.2433 12.7501 12.1671V7.53008C12.7488 7.37695 12.687 7.23055 12.5781 7.12283C12.4693 7.01511 12.3223 6.95481 12.1691 6.95508Z"
                                            fill="url(#paint3_linear_2444_2023)"/>
                                        <path
                                            d="M19.1233 0H14.4863C14.4101 0 14.3347 0.0150021 14.2643 0.0441499C14.1939 0.0732976 14.13 0.11602 14.0761 0.169878C14.0223 0.223736 13.9796 0.287675 13.9504 0.358044C13.9213 0.428412 13.9063 0.503833 13.9062 0.58V5.216C13.9062 5.29217 13.9213 5.36759 13.9504 5.43796C13.9796 5.50833 14.0223 5.57226 14.0761 5.62612C14.13 5.67998 14.1939 5.7227 14.2643 5.75185C14.3347 5.781 14.4101 5.796 14.4863 5.796H19.1233C19.1994 5.796 19.2748 5.781 19.3452 5.75185C19.4156 5.7227 19.4795 5.67998 19.5334 5.62612C19.5872 5.57226 19.63 5.50833 19.6591 5.43796C19.6883 5.36759 19.7032 5.29217 19.7032 5.216V0.58C19.7032 0.426174 19.6422 0.278649 19.5334 0.169878C19.4246 0.061107 19.2771 0 19.1233 0Z"
                                            fill="url(#paint4_linear_2444_2023)"/>
                                        <path
                                            d="M19.1233 6.95508H14.4863C14.4101 6.95508 14.3347 6.97008 14.2643 6.99923C14.1939 7.02838 14.13 7.0711 14.0761 7.12495C14.0223 7.17881 13.9796 7.24275 13.9504 7.31312C13.9213 7.38349 13.9063 7.45891 13.9062 7.53508V12.1671C13.9062 12.2433 13.9213 12.3187 13.9504 12.389C13.9796 12.4594 14.0223 12.5233 14.0761 12.5772C14.13 12.6311 14.1939 12.6738 14.2643 12.7029C14.3347 12.7321 14.4101 12.7471 14.4863 12.7471H19.1233C19.1994 12.7471 19.2748 12.7321 19.3452 12.7029C19.4156 12.6738 19.4795 12.6311 19.5334 12.5772C19.5872 12.5233 19.63 12.4594 19.6591 12.389C19.6883 12.3187 19.7032 12.2433 19.7032 12.1671V7.53008C19.7019 7.37712 19.6402 7.23088 19.5316 7.12318C19.423 7.01549 19.2762 6.95507 19.1233 6.95508Z"
                                            fill="url(#paint5_linear_2444_2023)"/>
                                        <path
                                            d="M5.216 14.2002H0.58C0.426174 14.2002 0.278649 14.2613 0.169878 14.3701C0.0611069 14.4789 0 14.6264 0 14.7802V19.4172C0 19.571 0.0611069 19.7186 0.169878 19.8273C0.278649 19.9361 0.426174 19.9972 0.58 19.9972H5.216C5.36983 19.9972 5.51735 19.9361 5.62612 19.8273C5.73489 19.7186 5.796 19.571 5.796 19.4172V14.7802C5.796 14.6264 5.73489 14.4789 5.62612 14.3701C5.51735 14.2613 5.36983 14.2002 5.216 14.2002Z"
                                            fill="url(#paint6_linear_2444_2023)"/>
                                        <path
                                            d="M12.1691 14.2002H7.53313C7.3793 14.2002 7.23177 14.2613 7.123 14.3701C7.01423 14.4789 6.95312 14.6264 6.95312 14.7802V19.4172C6.95312 19.571 7.01423 19.7186 7.123 19.8273C7.23177 19.9361 7.3793 19.9972 7.53313 19.9972H12.1701C12.3239 19.9972 12.4715 19.9361 12.5802 19.8273C12.689 19.7186 12.7501 19.571 12.7501 19.4172V14.7802C12.7501 14.7039 12.7351 14.6284 12.7059 14.558C12.6767 14.4876 12.6339 14.4236 12.5799 14.3697C12.5259 14.3159 12.4619 14.2731 12.3914 14.244C12.3209 14.215 12.2454 14.2001 12.1691 14.2002Z"
                                            fill="url(#paint7_linear_2444_2023)"/>
                                        <path
                                            d="M19.1233 14.2002H14.4863C14.4101 14.2002 14.3347 14.2152 14.2643 14.2444C14.1939 14.2735 14.13 14.3162 14.0761 14.3701C14.0223 14.4239 13.9796 14.4879 13.9504 14.5582C13.9213 14.6286 13.9063 14.704 13.9062 14.7802V19.4172C13.9062 19.4934 13.9213 19.5688 13.9504 19.6392C13.9796 19.7095 14.0223 19.7735 14.0761 19.8273C14.13 19.8812 14.1939 19.9239 14.2643 19.953C14.3347 19.9822 14.4101 19.9972 14.4863 19.9972H19.1233C19.2771 19.9972 19.4246 19.9361 19.5334 19.8273C19.6422 19.7186 19.7032 19.571 19.7032 19.4172V14.7802C19.7032 14.6264 19.6422 14.4789 19.5334 14.3701C19.4246 14.2613 19.2771 14.2002 19.1233 14.2002Z"
                                            fill="url(#paint8_linear_2444_2023)"/>
                                        <defs>
                                            <linearGradient id="paint0_linear_2444_2023" x1="0.524525" y1="3.89978"
                                                            x2="5.51755"
                                                            y2="2.76128" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="var(--system_primery_gredient1)"/>
                                                <stop offset="1" stop-color="var(--system_primery_gredient2)"/>
                                            </linearGradient>
                                            <linearGradient id="paint1_linear_2444_2023" x1="7.47774" y1="3.89978"
                                                            x2="12.4715"
                                                            y2="2.76091" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="var(--system_primery_gredient1)"/>
                                                <stop offset="1" stop-color="var(--system_primery_gredient2)"/>
                                            </linearGradient>
                                            <linearGradient id="paint2_linear_2444_2023" x1="0.524525" y1="10.8522"
                                                            x2="5.51721"
                                                            y2="9.71295" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="var(--system_primery_gredient1)"/>
                                                <stop offset="1" stop-color="var(--system_primery_gredient2)"/>
                                            </linearGradient>
                                            <linearGradient id="paint3_linear_2444_2023" x1="7.47774" y1="10.8522"
                                                            x2="12.4712"
                                                            y2="9.71258" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="var(--system_primery_gredient1)"/>
                                                <stop offset="1" stop-color="var(--system_primery_gredient2)"/>
                                            </linearGradient>
                                            <linearGradient id="paint4_linear_2444_2023" x1="14.4309" y1="3.89978"
                                                            x2="19.4247"
                                                            y2="2.76091" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="var(--system_primery_gredient1)"/>
                                                <stop offset="1" stop-color="var(--system_primery_gredient2)"/>
                                            </linearGradient>
                                            <linearGradient id="paint5_linear_2444_2023" x1="14.4309" y1="10.8522"
                                                            x2="19.4243"
                                                            y2="9.71258" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="var(--system_primery_gredient1)"/>
                                                <stop offset="1" stop-color="var(--system_primery_gredient2)"/>
                                            </linearGradient>
                                            <linearGradient id="paint6_linear_2444_2023" x1="0.524525" y1="18.1006"
                                                            x2="5.51763"
                                                            y2="16.9623" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="var(--system_primery_gredient1)"/>
                                                <stop offset="1" stop-color="var(--system_primery_gredient2)"/>
                                            </linearGradient>
                                            <linearGradient id="paint7_linear_2444_2023" x1="7.47774" y1="18.1006"
                                                            x2="12.4716"
                                                            y2="16.962" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="var(--system_primery_gredient1)"/>
                                                <stop offset="1" stop-color="var(--system_primery_gredient2)"/>
                                            </linearGradient>
                                            <linearGradient id="paint8_linear_2444_2023" x1="14.4309" y1="18.1006"
                                                            x2="19.4247"
                                                            y2="16.962" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="var(--system_primery_gredient1)"/>
                                                <stop offset="1" stop-color="var(--system_primery_gredient2)"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>

                                    <span>{{__('courses.Category')}}</span>
                                </div>
                                <div class="heading-category-dropdown" id="cateDropDown">
                                    <ul>
                                        @if(isset($categories))
                                            @foreach($categories as $category)
                                                <li>
                                                    <a href="{{route('courses')}}?category_id[]={{$category->id}}">
                                                        <span>{{$category->name}}</span>
                                                        @if(isset($category->activeSubcategories))
                                                            @if(count($category->activeSubcategories)!=0)
                                                                <i class="ti ti-angle-right"></i>
                                                            @endif
                                                        @endif
                                                    </a>
                                                    @if(isset($category->activeSubcategories))
                                                        @if(count($category->activeSubcategories)!=0)
                                                            <ul>
                                                                @if(isset($category->activeSubcategories))
                                                                    @foreach( $category->activeSubcategories as $subcategory)
                                                                        <li>
                                                                            <a href="{{route('courses')}}?category_id[]={{$subcategory->id}}">{{$subcategory->name}}</a>
                                                                        </li>
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                        @endif
                                                    @endif
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endif
                        @if(Settings('hide_menu_search_box')!=1)

                            <div class="heading-search-box">
                                <form action="{{route('search')}}">

                                    <div class="form-box">
                                        <label for="search" class="form-icon">
                                            <svg width="20" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M19.5304 17.4698C19.2375 17.1769 18.7626 17.1769 18.4697 17.4698C18.1768 17.7626 18.1768 18.2375 18.4697 18.5304L19.5304 17.4698ZM22.4696 22.5304C22.7625 22.8233 23.2374 22.8233 23.5303 22.5304C23.8232 22.2375 23.8232 21.7626 23.5303 21.4697L22.4696 22.5304ZM18.4697 18.5304L22.4696 22.5304L23.5303 21.4697L19.5304 17.4698L18.4697 18.5304ZM11 18.25C6.44365 18.25 2.75 14.5563 2.75 10H1.25C1.25 15.3848 5.61522 19.75 11 19.75V18.25ZM19.25 10C19.25 14.5563 15.5563 18.25 11 18.25V19.75C16.3848 19.75 20.75 15.3848 20.75 10H19.25ZM11 1.75C15.5563 1.75 19.25 5.44365 19.25 10H20.75C20.75 4.61522 16.3848 0.25 11 0.25V1.75ZM11 0.25C5.61522 0.25 1.25 4.61522 1.25 10H2.75C2.75 5.44365 6.44365 1.75 11 1.75V0.25Z" fill="#1F2B40"/>
                                            </svg>
                                        </label>
                                        <input type="text" name="query" id="search" class="form-control"
                                               placeholder="{{__('frontend.What are you looking for?')}}"
                                               required="">
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                    <div class="d-flex align-items-center gap-3 flex-grow-1 justify-content-end">
                        <nav class="d-none d-lg-block">
                            <ul class="heading-nav">


                                @if(isset($menus))
                                    @foreach($menus->where('parent_id',null) as $menu)
                                        @php
                                            if($menu->title=='Forum' && !isModuleActive('Forum')){
                                                continue;
                                            }
                                            if($menu->link == '/upcoming-courses'  && !isModuleActive('UpcomingCourse')){
                                            continue;
                                            }

                                            if ($menu->link=='/saas-signup') {
                                                if (auth()->check()) {
                                                continue;
                                                }elseif (SaasDomain() !='main')
                                                {
                                                    continue;
                                                }
                                            }
                                        @endphp
                                        <li class="heading-list @if($menu->mega_menu==1) position-static @else @if($menu->show==1) right_control_submenu @endif @endif">
                                            <a class="heading-links" @if($menu->is_newtab==1) target="_blank"
                                               @endif href="{{getMenuLink($menu)}}">{{$menu->title}}</a>
                                            @if(isset($menu->childs))
                                                @if(count($menu->childs)!=0)
                                                    @if(isset($menu->childs))
                                                        @if($menu->mega_menu==1)
                                                            <ul class="mega_menu submenu ">
                                                                <li class="container mx-auto">
                                                                    <div class="row">
                                                                        @foreach($menu->childs as $sub)
                                                                            <div
                                                                                class="col-lg-{{$menu->mega_menu_column}}">
                                                                                <h4>
                                                                                    {{$sub->title}}
                                                                                </h4>
                                                                                @if(isset($sub->childs))
                                                                                    @if(count($sub->childs)!=0)
                                                                                        <ul class="mega_menu_list">
                                                                                            @foreach( $sub->childs as $s)
                                                                                                <li class="@if($sub->show==1)  @endif">
                                                                                                    <a @if($s->is_newtab==1) target="_blank"
                                                                                                       @endif  href="{{getMenuLink($s)}}">{{$s->title}}</a>
                                                                                                </li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    @endif
                                                                                @endif

                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        @else
                                                            <ul class="submenu list">
                                                                @foreach($menu->childs as $sub)
                                                                    <li class=""><a
                                                                            @if($sub->is_newtab==1) target="_blank"
                                                                            @endif href="{{getMenuLink($sub)}}">{{$sub->title}}
                                                                            @if(isset($sub->childs) && count($sub->childs)!=0)
                                                                                <i class="ti-angle-right"></i>
                                                                            @endif
                                                                        </a>
                                                                        @if(isset($sub->childs))
                                                                            @if(count($sub->childs)!=0)
                                                                                <ul class="@if($sub->show==1)  leftcontrol_submenu @endif">
                                                                                    @foreach( $sub->childs as $s)
                                                                                        <li class="@if($sub->show==1)  @endif">
                                                                                            <a @if($s->is_newtab==1) target="_blank"
                                                                                               @endif  href="{{getMenuLink($s)}}">{{$s->title}}</a>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            @endif
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        </li>

                                    @endforeach
                                @endif

                            </ul>
                        </nav>
                        <div class="heading-end d-flex align-items-center justify-content-end gap-2 gap-lg-3">

                            @if(Settings('hide_menu_search_box')!=1)
                                <div class="position-md-relative mobile-search pe-3">
                                    <div class="mobile-search-box-toggler d-md-none d-lg-flex d-xl-none"
                                         id="mobileSearchToggle">
                                        <svg width="20" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19.5304 17.4698C19.2375 17.1769 18.7626 17.1769 18.4697 17.4698C18.1768 17.7626 18.1768 18.2375 18.4697 18.5304L19.5304 17.4698ZM22.4696 22.5304C22.7625 22.8233 23.2374 22.8233 23.5303 22.5304C23.8232 22.2375 23.8232 21.7626 23.5303 21.4697L22.4696 22.5304ZM18.4697 18.5304L22.4696 22.5304L23.5303 21.4697L19.5304 17.4698L18.4697 18.5304ZM11 18.25C6.44365 18.25 2.75 14.5563 2.75 10H1.25C1.25 15.3848 5.61522 19.75 11 19.75V18.25ZM19.25 10C19.25 14.5563 15.5563 18.25 11 18.25V19.75C16.3848 19.75 20.75 15.3848 20.75 10H19.25ZM11 1.75C15.5563 1.75 19.25 5.44365 19.25 10H20.75C20.75 4.61522 16.3848 0.25 11 0.25V1.75ZM11 0.25C5.61522 0.25 1.25 4.61522 1.25 10H2.75C2.75 5.44365 6.44365 1.75 11 1.75V0.25Z" fill="#1F2B40"/>
                                        </svg>
                                    </div>

                                    <div class="heading-search-box">
                                        <form action="{{route('search')}}">

                                            <div class="form-box">
                                                <label for="search" class="form-icon">
                                                    <svg width="20" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M19.5304 17.4698C19.2375 17.1769 18.7626 17.1769 18.4697 17.4698C18.1768 17.7626 18.1768 18.2375 18.4697 18.5304L19.5304 17.4698ZM22.4696 22.5304C22.7625 22.8233 23.2374 22.8233 23.5303 22.5304C23.8232 22.2375 23.8232 21.7626 23.5303 21.4697L22.4696 22.5304ZM18.4697 18.5304L22.4696 22.5304L23.5303 21.4697L19.5304 17.4698L18.4697 18.5304ZM11 18.25C6.44365 18.25 2.75 14.5563 2.75 10H1.25C1.25 15.3848 5.61522 19.75 11 19.75V18.25ZM19.25 10C19.25 14.5563 15.5563 18.25 11 18.25V19.75C16.3848 19.75 20.75 15.3848 20.75 10H19.25ZM11 1.75C15.5563 1.75 19.25 5.44365 19.25 10H20.75C20.75 4.61522 16.3848 0.25 11 0.25V1.75ZM11 0.25C5.61522 0.25 1.25 4.61522 1.25 10H2.75C2.75 5.44365 6.44365 1.75 11 1.75V0.25Z" fill="#1F2B40"/>
                                                    </svg>
                                                </label>
                                                <input type="text" name="query" id="search" class="form-control"
                                                       placeholder="{{__('frontend.What are you looking for?')}}"
                                                       required="">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif

                            @if(Settings('frontend_language_translation') == 1)
                                @php
                                    if (auth()->check()){
                                        $currentLang =auth()->user()->language_code;
                                    }else{
                                        $currentLang =app()->getLocale();
                                    }
                                    $langs =getLanguageList();
                                    $currentLangObj =$langs->where('code',$currentLang)->first();
                                @endphp
                                <div class="language dropdown">
                                    <button class="btn dropdown-toggle p-0 border-0" type="button"
                                            id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @if($currentLangObj && $currentLangObj->flag)
                                            <span class="language-img m-0">
                                                <img src="{{asset($currentLangObj->flag)}}"
                                                     alt="">
                                            </span>
                                        @endif
                                        <span>{{$currentLang}}</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach ($langs as $key => $language)
                                            <a class="dropdown-item" href="{{route('changeLanguage',$language->code)}}">
                                                <span>{{$language->native }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <!-- currency selector -->
                            @if(Settings('hide_multicurrency') == 1)
                                @php
                                    if (auth()->check()){
                                        $currency_id =auth()->user()->currency_id;
                                    }elseif(session('currency_id')){
                                    $currency_id = session('currency_id');
                                    }else{
                                        $currency_id =Settings('currency_id');
                                    }
                                @endphp
                                <select name="frontend_currency_id" id="frontend_currency_id"
                                        class="nice_Select currency_select"
                                        onchange="location = this.value;">
                                    @foreach (getCurrencyList() as $key => $currency)
                                        <option value="{{route('changeCurrency',$currency->id)}}"
                                                @if ($currency_id == $currency->id) selected @endif>{{$currency->code }}
                                            ({{$currency->symbol}})
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            @if(Settings('show_cart')==1)
                                <!-- cart start -->
                                <div class="heading-cart-icon cart_store ">
                                    <svg width="20" height="22" viewBox="0 0 20 22" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5.5 6.67001V5.70001C5.5 3.45001 7.31 1.24001 9.56 1.03001C12.24 0.770009 14.5 2.88001 14.5 5.51001V6.89001"
                                            stroke="#1F2B40" stroke-width="1.5" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round"/>
                                        <path
                                            d="M7.0008 21H13.0008C17.0208 21 17.7408 19.39 17.9508 17.43L18.7008 11.43C18.9708 8.99 18.2708 7 14.0008 7H6.0008C1.7308 7 1.0308 8.99 1.3008 11.43L2.0508 17.43C2.2608 19.39 2.9808 21 7.0008 21Z"
                                            stroke="#1F2B40" stroke-width="1.5" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M13.4945 11H13.5035" stroke="#1F2B40" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6.49451 11H6.50349" stroke="#1F2B40" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="heading-cart-items notify_count">{{@cartItem()}}</span>
                                </div>
                                <!-- cart end -->
                            @endif

                            <!-- <div class="position-relative heading-search-form d-lg-none">
                                <button class="p-0 rounded-circle heading-search">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M2.33341 8.1665C2.33341 4.94484 4.94509 2.33317 8.16675 2.33317C11.3884 2.33317 14.0001 4.94484 14.0001 8.1665C14.0001 9.73813 13.3786 11.1646 12.3679 12.2135C12.3394 12.2354 12.312 12.2595 12.2858 12.2856C12.2597 12.3117 12.2357 12.3391 12.2137 12.3677C11.1648 13.3783 9.73837 13.9998 8.16675 13.9998C4.94509 13.9998 2.33341 11.3882 2.33341 8.1665ZM12.8482 14.0264L12.2858 13.4641C11.9865 13.1648 11.9625 12.6944 12.2137 12.3677C12.2661 12.3172 12.3175 12.2658 12.3679 12.2135C12.6947 11.9622 13.165 11.9863 13.4643 12.2856L14.0267 12.8479C13.6787 13.283 13.2832 13.6784 12.8482 14.0264ZM12.8482 14.0264L15.9108 17.0891C16.2363 17.4145 16.7639 17.4145 17.0893 17.0891C17.4148 16.7637 17.4148 16.236 17.0893 15.9106L14.0267 12.8479C15.053 11.5649 15.6667 9.93735 15.6667 8.1665C15.6667 4.02437 12.3089 0.666504 8.16675 0.666504C4.02461 0.666504 0.666748 4.02437 0.666748 8.1665C0.666748 12.3086 4.02461 15.6665 8.16675 15.6665C9.93759 15.6665 11.5651 15.0528 12.8482 14.0264Z"
                                              fill="currentColor"></path>
                                        <path
                                            d="M12.2858 13.4641L12.8482 14.0264C13.2832 13.6784 13.6787 13.283 14.0267 12.8479L13.4643 12.2856C13.165 11.9863 12.6947 11.9622 12.3679 12.2135C12.3175 12.2658 12.2661 12.3172 12.2137 12.3677C11.9625 12.6944 11.9865 13.1648 12.2858 13.4641Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </button>
                                <div class="form-box mb-0 position-absolute">
                                    <input type="search" class="form-control" placeholder="Type here...">
                                </div>
                            </div> -->
                            @guest()
                                <a href="{{route('login')}}"
                                   class="secondary-btn border-0 fw-normal d-none d-lg-inline-block">
                                    {{__('common.Login')}}
                                </a>
                                @if(Settings('student_reg')==1 && saasPlanCheck('student')==false)
                                    <a href="{{route('register')}}"
                                       class="primary-btn border-0 fw-normal d-none d-lg-inline-block">
                                        {{__('common.Sign Up')}}
                                    </a>
                                @endif
                            @endguest
                            @auth()
                                <div class="header__right login_user">
                                    <div class="profile_info collaps_part">
                                        <div class="profile_img collaps_icon text-nowrap     d-flex align-items-center">
                                            <div class="studentProfileThumb"
                                                 style="background-image: url('{{getProfileImage(Auth::user()->image,Auth::user()->name)}}')"></div>

                                            <span class="">{{Auth::user()->name}}
                                                {{-- <br style="display: block"> --}}
                                            <small class="d-block">
                                                @if(showEcommerce())
                                                    @if(Auth::user()->role_id==3)
                                                        @if(Auth::user()->balance==0)
                                                            {{Settings('currency_symbol') ??'৳'}} 0
                                                        @else
                                                            {{getPriceFormat(Auth::user()->balance)}}
                                                        @endif
                                                    @endif
                                                @endif
                                            </small>
                                            </span>
                                        </div>
                                        <div class="profile_info_iner collaps_part_content">
                                            @if(Auth::user()->role_id==3)
                                                <a href="{{route('studentDashboard')}}">{{__('dashboard.Dashboard')}}</a>
                                                <a href="{{auth()->user()->username?route('profileUniqueUrl',auth()->user()->username):''}}">{{__('frontendmanage.My Profile')}}</a>
                                                <a href="{{route('users.settings')}}">{{__('frontend.Account Settings')}}</a>

                                                @if(isModuleActive('Affiliate') && auth()->user()->affiliate_request!=1)
                                                    <a href="{{routeIsExist('affiliate.users.request')?route('affiliate.users.request'):''}}">{{__('frontend.Join Affiliate Program')}}</a>
                                                @endif
                                            @else
                                                <a href="{{route('dashboard')}}">{{__('dashboard.Dashboard')}}</a>
                                                <a href="{{auth()->user()->username?route('profileUniqueUrl',auth()->user()->username):''}}">{{__('frontendmanage.My Profile')}}</a>

                                                <a href="{{route('users.settings')}}">{{__('frontend.Account Settings')}}</a>
                                            @endif
                                            @if(isModuleActive('UserType'))
                                                @foreach(auth()->user()->userRoles as $role)
                                                    @php
                                                        if ($role->id==auth()->user()->role_id){
                                                            continue;
                                                        }
                                                    @endphp
                                                    <a href="{{route('usertype.changePanel',$role->id)}}">
                                                        {{__('common.Switch to')}} {{$role->name}}
                                                    </a>
                                                @endforeach
                                            @endif
                                            <a href="{{route('logout')}}">{{__('frontend.Log Out')}}</a>
                                        </div>
                                    </div>
                                </div>
                            @endauth
                            <button class="theme-btn thum-bar d-lg-none bg-danger" type="button"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
                                <i class="fas fa-bars me-0"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="heading-clear"></div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
    <div class="offcanvas-header d-flex justify-content-between">
        <a href="{{url('/')}}" class="heading-logo d-block">
            <img src="{{getLogoImage(Settings('logo') )}}" alt="Infix LMS">
        </a>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="heading-nav">

            @if(isset($menus))
                @foreach($menus->where('parent_id',null) as $menu)
                    @php
                        if($menu->title=='Forum' && !isModuleActive('Forum')){
                            continue;
                        }
                        if($menu->link == '/upcoming-courses'  && !isModuleActive('UpcomingCourse')){
                           continue;
                        }

                        if ($menu->link=='/saas-signup') {
                            if (auth()->check()) {
                               continue;
                            }elseif (SaasDomain() !='main')
                            {
                                continue;
                            }
                        }
                    @endphp
                    <li class="heading-list @if($menu->mega_menu==1) position-static @else @if($menu->show==1) right_control_submenu @endif @endif">
                        <a class="heading-links" @if($menu->is_newtab==1) target="_blank"
                           @endif href="{{getMenuLink($menu)}}">
                            <span>{{$menu->title}}</span>
                            @if(isset($menu->childs))
                                @if(count($menu->childs)!=0)
                                    <i class="ti ti-angle-right"></i>
                                @endif
                            @endif
                        </a>
                        @if(isset($menu->childs))
                            @if(count($menu->childs)!=0)
                                @if(isset($menu->childs))
                                    @if($menu->mega_menu==1)
                                        <ul class="mega_menu submenu ">
                                            <li class="container mx-auto">
                                                <div class="row">
                                                    @foreach($menu->childs as $sub)
                                                        <div
                                                            class="col-lg-{{$menu->mega_menu_column}}">
                                                            <h4>
                                                                {{$sub->title}}
                                                            </h4>
                                                            @if(isset($sub->childs))
                                                                @if(count($sub->childs)!=0)
                                                                    <ul class="mega_menu_list">
                                                                        @foreach( $sub->childs as $s)
                                                                            <li class="@if($sub->show==1)  @endif">
                                                                                <a @if($s->is_newtab==1) target="_blank"
                                                                                   @endif  href="{{getMenuLink($s)}}">{{$s->title}}</a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            @endif

                                                        </div>
                                                    @endforeach
                                                </div>
                                            </li>
                                        </ul>
                                    @else
                                        <ul class="submenu list">
                                            @foreach($menu->childs as $sub)
                                                <li class=""><a
                                                        @if($sub->is_newtab==1) target="_blank"
                                                        @endif href="{{getMenuLink($sub)}}">{{$sub->title}}
                                                        @if(isset($sub->childs) && count($sub->childs)!=0)
                                                            <i class="ti-angle-right"></i>
                                                        @endif
                                                    </a>
                                                    @if(isset($sub->childs))
                                                        @if(count($sub->childs)!=0)
                                                            <ul class="@if($sub->show==1)  leftcontrol_submenu @endif">
                                                                @foreach( $sub->childs as $s)
                                                                    <li class="@if($sub->show==1)  @endif">
                                                                        <a @if($s->is_newtab==1) target="_blank"
                                                                           @endif  href="{{getMenuLink($s)}}">{{$s->title}}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endif
                            @endif
                        @endif
                    </li>

                @endforeach
            @endif
            @guest()
                <li class="mt-4 d-flex flex-wrap gap-3 align-items-center">
                    <a href="{{route('login')}}" class="secondary-btn border-0">
                        <svg width="17" height="20" viewBox="0 0 17 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M13.7531 11.9975C14.9954 11.9975 16.0023 13.0044 16.0023 14.2468V14.8223C16.0023 15.7167 15.6827 16.5817 15.1011 17.2612C13.5314 19.095 11.1439 20 7.99791 20C4.85146 20 2.46502 19.0947 0.898441 17.2601C0.318577 16.5811 0 15.7174 0 14.8245V14.2468C0 13.0044 1.00703 11.9975 2.24927 11.9975H13.7531ZM13.7531 13.4977H2.24927C1.83561 13.4977 1.50027 13.8331 1.50027 14.2468V14.8245C1.50027 15.3603 1.69141 15.8785 2.03933 16.2858C3.29286 17.7538 5.25909 18.4997 7.99791 18.4997C10.7367 18.4997 12.7047 17.7538 13.9614 16.2856C14.3103 15.8779 14.5021 15.3589 14.5021 14.8223V14.2468C14.5021 13.8331 14.1667 13.4977 13.7531 13.4977ZM7.99791 0C10.7598 0 12.9988 2.23898 12.9988 5.00089C12.9988 7.76282 10.7598 10.0018 7.99791 10.0018C5.23597 10.0018 2.997 7.76282 2.997 5.00089C2.997 2.23898 5.23597 0 7.99791 0ZM7.99791 1.50027C6.06457 1.50027 4.49726 3.06756 4.49726 5.00089C4.49726 6.93424 6.06457 8.50154 7.99791 8.50154C9.93126 8.50154 11.4985 6.93424 11.4985 5.00089C11.4985 3.06756 9.93126 1.50027 7.99791 1.50027Z"
                                fill="currentColor"></path>
                        </svg>
                        <span>{{__('frontend.Login')}}</span>
                    </a>
                    @if(Settings('student_reg')==1 && saasPlanCheck('student')==false)

                        <a href="{{route('register')}}" class="primary-btn border-0">
                            <svg width="17" height="20" viewBox="0 0 17 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.7531 11.9975C14.9954 11.9975 16.0023 13.0044 16.0023 14.2468V14.8223C16.0023 15.7167 15.6827 16.5817 15.1011 17.2612C13.5314 19.095 11.1439 20 7.99791 20C4.85146 20 2.46502 19.0947 0.898441 17.2601C0.318577 16.5811 0 15.7174 0 14.8245V14.2468C0 13.0044 1.00703 11.9975 2.24927 11.9975H13.7531ZM13.7531 13.4977H2.24927C1.83561 13.4977 1.50027 13.8331 1.50027 14.2468V14.8245C1.50027 15.3603 1.69141 15.8785 2.03933 16.2858C3.29286 17.7538 5.25909 18.4997 7.99791 18.4997C10.7367 18.4997 12.7047 17.7538 13.9614 16.2856C14.3103 15.8779 14.5021 15.3589 14.5021 14.8223V14.2468C14.5021 13.8331 14.1667 13.4977 13.7531 13.4977ZM7.99791 0C10.7598 0 12.9988 2.23898 12.9988 5.00089C12.9988 7.76282 10.7598 10.0018 7.99791 10.0018C5.23597 10.0018 2.997 7.76282 2.997 5.00089C2.997 2.23898 5.23597 0 7.99791 0ZM7.99791 1.50027C6.06457 1.50027 4.49726 3.06756 4.49726 5.00089C4.49726 6.93424 6.06457 8.50154 7.99791 8.50154C9.93126 8.50154 11.4985 6.93424 11.4985 5.00089C11.4985 3.06756 9.93126 1.50027 7.99791 1.50027Z"
                                    fill="currentColor"></path>
                            </svg>
                            <span>{{__('frontend.Sign Up')}}</span>
                        </a>
                    @endif
                </li>
            @endguest
        </ul>
    </div>
</div>

<div class="heading_icons">
    <ul class="d-flex align-items-center">
        <li class="flex-grow-1 text-center"><a href="{{route('studentDashboard')}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.415" height="24" viewBox="0 0 24.415 24">
                    <g id="home-1" transform="translate(-1.248 -1.425)">
                        <path id="Path_3931" data-name="Path 3931"
                              d="M19.816,25.425H7.1a4.442,4.442,0,0,1-4.292-3.634L1.3,12.752A4.706,4.706,0,0,1,2.863,8.642l7.869-6.3a4.5,4.5,0,0,1,5.451.011l7.87,6.291a4.767,4.767,0,0,1,1.567,4.111l-1.51,9.039A4.506,4.506,0,0,1,19.816,25.425Zm-6.37-22.28a2.673,2.673,0,0,0-1.647.534L3.93,9.982a3,3,0,0,0-.954,2.5l1.51,9.039a2.783,2.783,0,0,0,2.612,2.2H19.816a2.781,2.781,0,0,0,2.612-2.214l1.51-9.039a3.025,3.025,0,0,0-.954-2.5L15.115,3.679A2.739,2.739,0,0,0,13.446,3.145Z"
                              transform="translate(0)" fill="currentColor"></path>
                        <path id="Path_3932" data-name="Path 3932"
                              d="M12.442,17.133a3.692,3.692,0,1,1,3.692-3.692A3.7,3.7,0,0,1,12.442,17.133Zm0-5.679a1.988,1.988,0,1,0,1.988,1.988A2,2,0,0,0,12.442,11.454Z"
                              transform="translate(1.016 1.127)" fill="currentColor"></path>
                    </g>
                </svg>
            </a></li>
        <li class="flex-grow-1 text-center"><a href="{{route('myWishlists')}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="26.736" height="24" viewBox="0 0 26.736 24">
                    <path id="heart"
                          d="M14.618,26.351a3.219,3.219,0,0,1-1.069-.162C8.8,24.561,1.25,18.778,1.25,10.235A7.87,7.87,0,0,1,9.1,2.352,7.727,7.727,0,0,1,14.618,4.64a7.727,7.727,0,0,1,5.521-2.288,7.878,7.878,0,0,1,7.847,7.884c0,8.555-7.548,14.325-12.3,15.954a3.219,3.219,0,0,1-1.068.161ZM9.1,4.217a6.008,6.008,0,0,0-5.981,6.019c0,8.493,8.17,13.219,11.042,14.2a1.971,1.971,0,0,0,.933,0c2.86-.982,11.042-5.7,11.042-14.2a6.008,6.008,0,0,0-5.981-6.019A5.908,5.908,0,0,0,15.38,6.629a.963.963,0,0,1-1.492,0A5.932,5.932,0,0,0,9.1,4.217Z"
                          transform="translate(-1.25 -2.352)" fill="currentColor"></path>
                </svg>
            </a></li>
        <li class="flex-grow-1 text-center"><a href="{{route('myCart')}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.036" height="23.972" viewBox="0 0 24.036 23.972">
                    <g id="bag" transform="translate(-1.232 -1.285)">
                        <path id="Path_3940" data-name="Path 3940"
                              d="M5.278,6.979a.857.857,0,0,1-.592-.246.842.842,0,0,1,0-1.184L8.739,1.5A.837.837,0,0,1,9.923,2.68L5.87,6.734a.877.877,0,0,1-.592.245Z"
                              transform="translate(0.372)" fill="currentColor"></path>
                        <path id="Path_3941" data-name="Path 3941"
                              d="M19.32,6.979a.828.828,0,0,1-.592-.246L14.674,2.68A.837.837,0,0,1,15.858,1.5l4.053,4.05a.842.842,0,0,1,0,1.184A.857.857,0,0,1,19.32,6.979Z"
                              transform="translate(1.53)" fill="currentColor"></path>
                        <path id="Path_3942" data-name="Path 3942"
                              d="M22.415,11.243H4.32A3.006,3.006,0,0,1,2,10.606a3.246,3.246,0,0,1-.75-2.434C1.25,5.1,3.494,5.1,4.565,5.1h17.37c1.072,0,3.315,0,3.315,3.071A3.229,3.229,0,0,1,24.5,10.6,2.768,2.768,0,0,1,22.415,11.243ZM4.565,9.568H22.191c.5.011.971.011,1.127-.145.078-.078.246-.346.246-1.251,0-1.262-.313-1.4-1.641-1.4H4.565c-1.328,0-1.641.134-1.641,1.4,0,.9.179,1.172.246,1.251a2.246,2.246,0,0,0,1.13.145Z"
                              transform="translate(0 0.449)" fill="currentColor"></path>
                        <path id="Path_3943" data-name="Path 3943"
                              d="M9.847,18.889a.844.844,0,0,1-.837-.837V14.087a.837.837,0,1,1,1.675,0v3.964a.836.836,0,0,1-.838.838Z"
                              transform="translate(0.902 1.399)" fill="currentColor"></path>
                        <path id="Path_3944" data-name="Path 3944"
                              d="M14.447,18.889a.844.844,0,0,1-.837-.837V14.087a.838.838,0,1,1,1.675,0v3.964a.836.836,0,0,1-.838.838Z"
                              transform="translate(1.437 1.399)" fill="currentColor"></path>
                        <path id="Path_3945" data-name="Path 3945"
                              d="M16.3,24.325H9.571c-4,0-4.889-2.378-5.235-4.444L2.762,10.222a.837.837,0,1,1,1.652-.268L5.988,19.6c.324,1.976.993,3.048,3.583,3.048H16.3c2.869,0,3.192-1,3.561-2.948l1.875-9.77a.836.836,0,1,1,1.641.324L21.5,20.026C21.068,22.293,20.343,24.325,16.3,24.325Z"
                              transform="translate(0.175 0.932)" fill="currentColor"></path>
                    </g>
                </svg>
            </a></li>
        <li class="flex-grow-1 text-center"><a href="{{route('myProfile')}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <g id="profile-circle" transform="translate(-1.25 -1.25)">
                        <path id="Path_3931" data-name="Path 3931"
                              d="M12.6,14.466h-.19a4.454,4.454,0,1,1,.223,0Zm-.134-7.323a2.825,2.825,0,1,0-.112,5.648.938.938,0,0,1,.257,0,2.826,2.826,0,0,0-.145-5.648Z"
                              transform="translate(0.783 0.492)" fill="currentColor"></path>
                        <path id="Path_3932" data-name="Path 3932"
                              d="M12.872,23.687a11.956,11.956,0,0,1-8.093-3.148.843.843,0,0,1-.268-.7,4.921,4.921,0,0,1,2.344-3.483,11.748,11.748,0,0,1,12.033,0,4.942,4.942,0,0,1,2.344,3.483.8.8,0,0,1-.268.7,11.956,11.956,0,0,1-8.092,3.148ZM6.264,19.612a10.3,10.3,0,0,0,13.217,0,3.629,3.629,0,0,0-1.529-1.875,10.1,10.1,0,0,0-10.169,0,3.6,3.6,0,0,0-1.519,1.875Z"
                              transform="translate(0.379 1.563)" fill="currentColor"></path>
                        <path id="Path_3933" data-name="Path 3933"
                              d="M13.25,25.25a12,12,0,1,1,12-12A12,12,0,0,1,13.25,25.25Zm0-22.325A10.326,10.326,0,1,0,23.575,13.25,10.326,10.326,0,0,0,13.25,2.925Z"
                              fill="currentColor"></path>
                    </g>
                </svg>
            </a></li>
    </ul>
</div>


<script>
    (function () {
        'use strict';
        jQuery(document).ready(function () {
            $(document).on('click', '#showCateDrop', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $('#cateDropDown').fadeToggle('fast');
                $(this).find('i').toggleClass('ti-angle-down').toggleClass('ti-angle-up')
            })
            $(document).on('click', function (e) {
                if (!$(e.target).is('#cateDropDown *')) {
                    $('#cateDropDown').fadeOut('fast');
                    $('#showCateDrop').find('i').addClass('ti-angle-down').removeClass('ti-angle-up')
                }
            })
        })
    }());

    $(document).ready(function () {
        // Initially hide all submenus
        $(".heading-category-dropdown ul li ul").hide();

        $(".heading-category-dropdown ul li").hover(
            function () {
                const parentOffset = $(this).offset();
                const parentHeight = $(this).outerHeight();
                const parentWidth = $(this).outerWidth();
                const submenuWidth = $(this).find("ul").outerWidth(); // Get submenu width
                const scrollTop = $(window).scrollTop(); // Get the current scroll position
                const isRtl = $("html").attr("dir") === "rtl"; // Check if the document is in RTL

                // Display the submenu and position it correctly
                const submenu = $(this).find("ul");

                submenu.css({
                    display: "block",
                    top: parentOffset.top - scrollTop, // Adjust the top position based on scroll
                    left: isRtl
                        ? parentOffset.left - submenuWidth  // For RTL, position to the left of parent
                        : parentOffset.left + parentWidth, // For LTR, position to the right of parent
                });

                // Ensure submenu doesn't go out of bounds on the page (e.g., for RTL when menu is near left edge)
                if (isRtl) {
                    const rightEdge = $(window).width() - (parentOffset.left - submenuWidth);
                    if (rightEdge < submenuWidth) {
                        submenu.css({
                            left: parentOffset.left + parentWidth, // Switch to right if there's no space
                        });
                    }
                }
            },
            function () {
                // Hide the submenu when not hovered
                const $submenu = $(this).find("ul");
                if ($submenu.length) {
                    $submenu.css({
                        display: "none",
                        top: 0,
                        left: 0,
                    });
                }
            }
        );
    });

    function updateHeaderHeight() {
        let headerHeight = $(".heading").outerHeight();
        if ($(window).width() > 991 && $(window).width() < 1200) {
            headerHeight -= 30;
        }
        document.documentElement.style.setProperty('--header-height', `${headerHeight}px`);
    }

    $(document).ready(function () {
        updateHeaderHeight();
        $(window).resize(function () {
            updateHeaderHeight();
            if (!($(window).width() >= 991 && $(window).width() <= 1200) && $(window).width() >= 767) {
                $(".mobile-search .heading-search-box").removeClass("mobile-visible").hide();
            }


        });
    });

    $(document).on("click", "#mobileSearchToggle", function () {
        $(".mobile-search .heading-search-box").addClass("mobile-visible").fadeToggle('slow');
    });

    $(document).on("click", function (e) {
        if ($(".mobile-search .heading-search-box").hasClass("mobile-visible") && !$(e.target).closest(".heading-search-box, #mobileSearchToggle").length) {
            $(".mobile-search .heading-search-box").removeClass("mobile-visible").hide('slow');
        }
    });

</script>
