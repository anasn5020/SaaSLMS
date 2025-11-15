<style>
    .header_area .main_menu ul li ul.leftcontrol_submenu {
        left: auto !important;
        right: 100% !important;
    }
    @media (max-width: 991px){
        .header__right.login_user {
            margin-right: 40px;
        }

        html[dir="rtl"] .header__right.login_user {
            margin-left: 40px;
            margin-right: 0;
        }
    }

    /* drop down menu index issue */


    @media (max-width: 768px) {
        .header__right.login_user .profile_info_iner {
            top: 40px;
        }
    }

    @media (max-width: 576px) {
        .header__right.login_user .profile_info_iner {
            top: 70px;
        }
    }
    .menu_dropdown > ul {
        height: calc(100vh - 150px);
        overflow: auto;
        padding-left: 0;
        padding-right: 0;
    }

    .menu_dropdown > ul li {
        position: relative;
    }

    .menu_dropdown > ul li > ul {
        position: fixed;
        right: auto!important;
    }

    .menu_dropdown_iner{
        padding-left: 0;
    }

    /* Search */

    .mobile-search .mobile-search-popup{
        display: none;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
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

    @media (max-width: 1299px){
        .theme_search_field{
            width: 300px;
        }
    }

    @media (min-width: 767px){

        .position-md-relative {
            position: relative;
        }
    }
    .mobile-search .mobile-search-popup {
        position: absolute;
        top: var(--header-height);
        left: auto;
        right: 100%;
        width: 300px;
    }

    .mobile-search{
        display: none
    }
    @media (min-width: 1300px) and (max-width: 1750px){
        .theme_search_field{
            width: 250px;
        }

        .categories_menu span{
            display: none;
        }

        .categories_menu{
            margin: 0!important;
        }
    }

    @media (max-width: 1300px){
        .mobile-search{
            display: block;
        }

        .header__left .theme_search_field{
            display: none;
        }
        .header__right .theme_btn.small_btn2 {
            padding: 12px 16px;
        }
    }

    @media (min-width: 767px) and (max-width: 991px){
        .mobile-search{
            display: none
        }
        .header__left .theme_search_field{
            display: block;
        }
        .header__left .theme_search_field input{
            width: 100%;
        }
    }

    @media (max-width: 767px){
        .mobile-search .mobile-search-popup {
            width: 100%;
            left: 0;
            right: auto
        }

        .mobile-search .theme_search_field {
            width: 100%;
            border-radius: 0
        }
    }



</style>

<!-- HEADER::START -->

<header>
    <div id="{{Settings('fixed_navbar_in_frontend')!='no'?'sticky-header':''}}" class="header_area ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="header__wrapper">
                        <!-- header__left__start  -->
                        <div class="header__left d-flex align-items-center gap-20 ">
                            <div class="">
                                <a class="logo_img" href="{{url('/')}}">
                                    <img class="p-2" src="{{getLogoImage(Settings('logo') )}}" width="150"
                                         alt="{{ Settings('site_name')  }}">
                                </a>
                            </div>
                            <div class="me-3 translator-switch">

                                @if(Settings('frontend_language_translation') == 1)
                                    @php
                                        if (auth()->check()){
                                            $currentLang =auth()->user()->language_code;
                                        }else{
                                            $currentLang =app()->getLocale();
                                        }
                                    @endphp
                                    <select name="code" id="language_code" class="nice_Select"
                                            onchange="location = this.value;">
                                        @foreach (getLanguageList() as $key => $language)
                                            <option value="{{route('changeLanguage',$language->code)}}"
                                                    @if ($currentLang == $language->code) selected @endif>{{$language->native }}
                                            </option>
                                        @endforeach
                                    </select>

                                @endif

                            </div>

                            <div class="category_search d-flex category_box_iner">
                                @if(Settings('category_show'))
                                    <div class="input-group-prepend2">
                                        <a href="#" class="categories_menu">
                                            <i class="fas fa-th"></i>
                                            <span>{{__('courses.Category')}}</span>
                                        </a>
                                        <div class="menu_dropdown">
                                            <ul>
                                                @if(isset($categories))
                                                    @foreach($categories as $category)

                                                        @include(theme('partials._category'),['category'=>$category,'level'=>1])

                                                    @endforeach
                                                @endif
                                            </ul>

                                        </div>
                                    </div>
                                @endif
                                @if(Settings('hide_menu_search_box')!=1)
                                    <form action="{{route('search')}}">
                                        <div class="input-group theme_search_field">
                                            <div class="input-group-prepend">
                                                <button class="btn" type="button" id="button-addon1">
                                                    <svg width="20" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M19.5304 17.4698C19.2375 17.1769 18.7626 17.1769 18.4697 17.4698C18.1768 17.7626 18.1768 18.2375 18.4697 18.5304L19.5304 17.4698ZM22.4696 22.5304C22.7625 22.8233 23.2374 22.8233 23.5303 22.5304C23.8232 22.2375 23.8232 21.7626 23.5303 21.4697L22.4696 22.5304ZM18.4697 18.5304L22.4696 22.5304L23.5303 21.4697L19.5304 17.4698L18.4697 18.5304ZM11 18.25C6.44365 18.25 2.75 14.5563 2.75 10H1.25C1.25 15.3848 5.61522 19.75 11 19.75V18.25ZM19.25 10C19.25 14.5563 15.5563 18.25 11 18.25V19.75C16.3848 19.75 20.75 15.3848 20.75 10H19.25ZM11 1.75C15.5563 1.75 19.25 5.44365 19.25 10H20.75C20.75 4.61522 16.3848 0.25 11 0.25V1.75ZM11 0.25C5.61522 0.25 1.25 4.61522 1.25 10H2.75C2.75 5.44365 6.44365 1.75 11 1.75V0.25Z" fill="#1F2B40"/>
                                                    </svg>
                                                </button>
                                            </div>

                                            <input type="text" class="form-control" name="query"
                                                   placeholder="{{__('frontend.Search for course, skills and Videos')}}"
                                                   onfocus="this.placeholder = ''"
                                                   onblur="this.placeholder = '{{__('frontend.Search for course, skills and Videos')}}'">

                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <!-- header__left__start  -->

                        <!-- main_menu_start  -->
                        <div class="main_menu text-end d-none d-lg-block category_box_iner">
                            <nav>
                                <div class="menu_dropdown">
                                    <ul>
                                        @if(isset($categories))
                                            @foreach($categories as $category)
                                                <li class="mega_menu_dropdown active_menu_item">
                                                    <a href="{{route('courses')}}?category={{$category->id}}">{{$category->name}}</a>
                                                    @if(isset($category->activeSubcategories))
                                                        @if(count($category->activeSubcategories)!=0)
                                                            <ul>
                                                                <li>
                                                                    <div class="menu_dropdown_iner d-flex">
                                                                        <div class="single_menu_dropdown">
                                                                            <h4>{{__('courses.Sub Category')}}</h4>
                                                                            <ul>
                                                                                @if(isset($category->activeSubcategories))
                                                                                    @foreach( $category->activeSubcategories as $subcategory)
                                                                                        <li>
                                                                                            <a href="{{route('courses')}}?category={{$category->id}}">{{$subcategory->name}}</a>
                                                                                        </li>
                                                                                    @endforeach
                                                                                @endif
                                                                            </ul>
                                                                        </div>

                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        @endif
                                                    @endif
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>


                                <ul id="mobile-menu">


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
                                                    if (Auth::check()) {
                                                       continue;
                                                    }elseif (SaasDomain() !='main')
                                                    {
                                                        continue;
                                                    }
                                                }
                                            @endphp
                                            <li class="@if($menu->mega_menu==1) position-static @else @if($menu->show==1) right_control_submenu @endif @endif">
                                                <a @if($menu->is_newtab==1) target="_blank"
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
                                    @else

                                    @endif
                                    <li><a href="#"></a></li>


                                </ul>


                            </nav>
                        </div>
                        <!-- main_menu_start  -->


                        <div class="me-3 translator-switch">

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
                                <select name="frontend_currency_id" id="frontend_currency_id" class="nice_Select"
                                        onchange="location = this.value;">
                                    @foreach (getCurrencyList() as $key => $currency)
                                        <option value="{{route('changeCurrency',$currency->id)}}"
                                                @if ($currency_id == $currency->id) selected @endif>{{$currency->code }}
                                            ({{$currency->symbol}})
                                        </option>
                                    @endforeach
                                </select>
                            @endif

                        </div>
                        <!-- header__right_start  -->
                        @auth()
                            <div class="header__right d-flex align-items-center gap-3 login_user">
                                {{-- Search --}}
                                @if(Settings('hide_menu_search_box')!=1)
                                    <div class="position-md-relative mobile-search">
                                        <div class="mobile-search-box-toggler" id="mobileSearchToggle">
                                            <svg width="20" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M19.5304 17.4698C19.2375 17.1769 18.7626 17.1769 18.4697 17.4698C18.1768 17.7626 18.1768 18.2375 18.4697 18.5304L19.5304 17.4698ZM22.4696 22.5304C22.7625 22.8233 23.2374 22.8233 23.5303 22.5304C23.8232 22.2375 23.8232 21.7626 23.5303 21.4697L22.4696 22.5304ZM18.4697 18.5304L22.4696 22.5304L23.5303 21.4697L19.5304 17.4698L18.4697 18.5304ZM11 18.25C6.44365 18.25 2.75 14.5563 2.75 10H1.25C1.25 15.3848 5.61522 19.75 11 19.75V18.25ZM19.25 10C19.25 14.5563 15.5563 18.25 11 18.25V19.75C16.3848 19.75 20.75 15.3848 20.75 10H19.25ZM11 1.75C15.5563 1.75 19.25 5.44365 19.25 10H20.75C20.75 4.61522 16.3848 0.25 11 0.25V1.75ZM11 0.25C5.61522 0.25 1.25 4.61522 1.25 10H2.75C2.75 5.44365 6.44365 1.75 11 1.75V0.25Z" fill="#1F2B40"/>
                                            </svg>
                                        </div>
                                        <form class="mobile-search-popup" action="{{route('search')}}">
                                            <div class="input-group theme_search_field">
                                                <div class="input-group-prepend">
                                                    <button class="btn" type="button" id="button-addon1">
                                                        <svg width="20" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M19.5304 17.4698C19.2375 17.1769 18.7626 17.1769 18.4697 17.4698C18.1768 17.7626 18.1768 18.2375 18.4697 18.5304L19.5304 17.4698ZM22.4696 22.5304C22.7625 22.8233 23.2374 22.8233 23.5303 22.5304C23.8232 22.2375 23.8232 21.7626 23.5303 21.4697L22.4696 22.5304ZM18.4697 18.5304L22.4696 22.5304L23.5303 21.4697L19.5304 17.4698L18.4697 18.5304ZM11 18.25C6.44365 18.25 2.75 14.5563 2.75 10H1.25C1.25 15.3848 5.61522 19.75 11 19.75V18.25ZM19.25 10C19.25 14.5563 15.5563 18.25 11 18.25V19.75C16.3848 19.75 20.75 15.3848 20.75 10H19.25ZM11 1.75C15.5563 1.75 19.25 5.44365 19.25 10H20.75C20.75 4.61522 16.3848 0.25 11 0.25V1.75ZM11 0.25C5.61522 0.25 1.25 4.61522 1.25 10H2.75C2.75 5.44365 6.44365 1.75 11 1.75V0.25Z" fill="#1F2B40"/>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <input type="text" class="form-control" name="query"
                                                       placeholder="{{__('frontend.Search for course, skills and Videos')}}"
                                                       onfocus="this.placeholder = ''"
                                                       onblur="this.placeholder = '{{__('frontend.Search for course, skills and Videos')}}'">

                                            </div>
                                        </form>
                                    </div>
                                @endif
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
                        @guest()
                            <div class="header__right d-flex align-items-center gap-3">
                                {{-- Search --}}
                                @if(Settings('hide_menu_search_box')!=1)
                                    <div class="position-md-relative mobile-search">
                                        <div class="mobile-search-box-toggler" id="mobileSearchToggle">
                                            <svg width="20" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M19.5304 17.4698C19.2375 17.1769 18.7626 17.1769 18.4697 17.4698C18.1768 17.7626 18.1768 18.2375 18.4697 18.5304L19.5304 17.4698ZM22.4696 22.5304C22.7625 22.8233 23.2374 22.8233 23.5303 22.5304C23.8232 22.2375 23.8232 21.7626 23.5303 21.4697L22.4696 22.5304ZM18.4697 18.5304L22.4696 22.5304L23.5303 21.4697L19.5304 17.4698L18.4697 18.5304ZM11 18.25C6.44365 18.25 2.75 14.5563 2.75 10H1.25C1.25 15.3848 5.61522 19.75 11 19.75V18.25ZM19.25 10C19.25 14.5563 15.5563 18.25 11 18.25V19.75C16.3848 19.75 20.75 15.3848 20.75 10H19.25ZM11 1.75C15.5563 1.75 19.25 5.44365 19.25 10H20.75C20.75 4.61522 16.3848 0.25 11 0.25V1.75ZM11 0.25C5.61522 0.25 1.25 4.61522 1.25 10H2.75C2.75 5.44365 6.44365 1.75 11 1.75V0.25Z" fill="#1F2B40"/>
                                            </svg>
                                        </div>
                                        <form class="mobile-search-popup" action="{{route('search')}}">
                                            <div class="input-group theme_search_field">
                                                <div class="input-group-prepend">
                                                    <button class="btn" type="button" id="button-addon1">
                                                        <svg width="20" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M19.5304 17.4698C19.2375 17.1769 18.7626 17.1769 18.4697 17.4698C18.1768 17.7626 18.1768 18.2375 18.4697 18.5304L19.5304 17.4698ZM22.4696 22.5304C22.7625 22.8233 23.2374 22.8233 23.5303 22.5304C23.8232 22.2375 23.8232 21.7626 23.5303 21.4697L22.4696 22.5304ZM18.4697 18.5304L22.4696 22.5304L23.5303 21.4697L19.5304 17.4698L18.4697 18.5304ZM11 18.25C6.44365 18.25 2.75 14.5563 2.75 10H1.25C1.25 15.3848 5.61522 19.75 11 19.75V18.25ZM19.25 10C19.25 14.5563 15.5563 18.25 11 18.25V19.75C16.3848 19.75 20.75 15.3848 20.75 10H19.25ZM11 1.75C15.5563 1.75 19.25 5.44365 19.25 10H20.75C20.75 4.61522 16.3848 0.25 11 0.25V1.75ZM11 0.25C5.61522 0.25 1.25 4.61522 1.25 10H2.75C2.75 5.44365 6.44365 1.75 11 1.75V0.25Z" fill="#1F2B40"/>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <input type="text" class="form-control" name="query"
                                                       placeholder="{{__('frontend.Search for course, skills and Videos')}}"
                                                       onfocus="this.placeholder = ''"
                                                       onblur="this.placeholder = '{{__('frontend.Search for course, skills and Videos')}}'">

                                            </div>
                                        </form>
                                    </div>
                                @endif
                                <div class="contact_wrap d-flex align-items-center">
                                    <div class="contact_btn">
                                        <a href="{{url('login')}}"
                                           class="theme_btn small_btn2">{{__('frontend.Sign In')}} </a>
                                    </div>
                                </div>
                            </div>
                        @endguest
                        <!-- header__right_end  -->
                    </div>
                </div>
                <div class="col-12">
                    <div class="mobile_menu d-block d-lg-none"></div>
                </div>
            </div>
        </div>
    </div>
</header>

@if(Settings('category_show'))
    <div class="side_cate">
        <div class="side_cate_close"><i class="ti ti-close"></i></div>
        <div class="side_cate_wrap">
            <ul class="side_cate_wrap_menu">

                @if(isset($categories))
                    @foreach($categories as $category)

                        @include(theme('partials._mobile_category'),['category'=>$category,'level'=>1])

                    @endforeach
                @endif
            </ul>
        </div>
    </div>
@endif
@if(Settings('show_cart')==1)
    <a href="#" class="float notification_wrapper cart_icon">
        <div class="notify_icon cart_store" style="padding-top: 7px">
            <img style="max-width: 30px;" src="{{asset('/public/frontend/infixlmstheme/')}}/img/svg/cart_white.svg"
                 alt="">
        </div>
        <span class="notify_count">{{@cartItem()}}</span>
    </a>
@endif
<script>
    (function () {
        'use strict';
        jQuery(document).ready(function () {
             // Initially hide all submenus
            $(".menu_dropdown > ul li > ul").hide();

            // Handle hover for menu and submenu
            $(".menu_dropdown > ul li").hover(
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




            // Search
            function updateHeaderHeight() {
                let headerHeight = $(".header_area").outerHeight();
                if ($(window).width() > 767) {
                    headerHeight -= 25;
                }
                document.documentElement.style.setProperty('--header-height', `${headerHeight}px`);
            }

            $(document).ready(function () {
                updateHeaderHeight();
                $(window).resize(function () {
                    updateHeaderHeight();
                });
            });

            $(document).on("click", "#mobileSearchToggle", function () {
                $(".mobile-search .mobile-search-popup").addClass("mobile-visible").fadeToggle('slow');
            });

            $(document).on("click", function (e) {
                if ($(".mobile-search .mobile-search-popup").hasClass("mobile-visible") &&
                    !$(e.target).closest(".mobile-search-popup, #mobileSearchToggle").length) {
                    $(".mobile-search .mobile-search-popup").removeClass("mobile-visible").hide('slow');
                }
            });

        });
    }());
</script>
