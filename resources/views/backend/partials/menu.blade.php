@php
    $totalMessage =totalUnreadMessages();
    $user =\Illuminate\Support\Facades\Auth::user()
@endphp
<div class="container-fluid g-0" id="main-nav-for-chat">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div
                class="header_iner d-flex justify-content-end justify-content-lg-between align-items-center {{$user->sidebar==1 ? '' : 'full-width'}}">
                @php
                    $LanguageList = getLanguageList();
                    $path =asset(Settings('logo') );
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    try {
                        $data = file_get_contents($path);
                    }catch (\Exception $e){
                        $data='';
                    }
                @endphp
                <input type="hidden" id="logo_img" value="{{base64_encode($data)}}">
                <input type="hidden" id="logo_title" value="{{Settings('company_name')}}">
                <div class="small_logo_crm d-lg-none">
                    <a href="{{url('/')}}"> <img src="{{asset(Settings('logo'))}}" alt=""></a>
                </div>
                <div id="sidebarCollapse" class="sidebar_icon  d-lg-none">
                    <i class="ti-menu"></i>
                </div>

                <button class="navbar-toggler sidebar_icon top-fixed d-none d-lg-none" type="button"
                        data-bs-toggle="collapse" data-bs-target="#backendNavBarToggler"
                        aria-controls="backendNavBarToggler" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="ti-menu"></i>
                </button>

                @if($user->sidebar==1)
                    <div class="collaspe_icon open_miniSide">
                        <i class="ti-menu"></i>
                    </div>
                @endif

                <div class="d-flex align-items-center">
                    @if($user->sidebar!=1)
                        <a class="large_logo   header_logo_area" href="{{ url('/') }}">
                            <img src="{{ getLogoImage(Settings('logo')) }}" alt="">
                        </a>
                    @endif
                    <div class="serach_field-area ml-30">
                        <div class="search_inner">
                            <form action="#">
                                <div class="search_field">
                                    <input type="text" class="form-control primary-input input-left-icon"
                                           placeholder="{{__('common.Search')}}" id="search"
                                           onkeyup="showResult(this.value)">
                                </div>
                                <button type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                        <div id="livesearch" style="display: none;"></div>
                    </div>
                </div>

                {{-- <div class="header_middle d-none d-md-block">
                    <ul class="nav navbar-nav me-auto nav-buttons flex-sm-row">
                    </ul>
                </div> --}}

                <div class="header_right d-flex justify-content-between align-items-center">
                    @include('partials.timer')

                    @if(Settings('language_translation') == 1)
                        <div class="select_style d-flex">
                            <select name="code" id="language_code"
                                    class="nice_Select bgLess mb-0 menuLangChanger text-uppercase"
                                    onchange="location = this.value;">

                                @foreach ($LanguageList as $key => $language)
                                    <option value="{{route('changeLanguage',$language->code)}}"
                                            data-display="{{ $language->code }}"
                                            @if ($user->language_code == $language->code) selected @endif>{{ $language->native }}</option>

                                @endforeach
                            </select>
                        </div>
                    @endif

                    @if(isModuleActive("AIContent"))
                        @include('aicontent::inc.menu_btn')
                    @endif
                    <ul class="header_notification_warp d-flex align-items-center gap-25">

                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="{{__('common.Visit Website')}}"
                            data-bs-custom-class="tooltip-zindex">
                            <a target="_blank" class="visit_website_btn"
                               href="{{url('/')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path
                                        d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                    <path d="M7.99998 3H8.99998C7.04998 8.84 7.04998 15.16 8.99998 21H7.99998"
                                          stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                    <path d="M15 3C16.95 8.84 16.95 15.16 15 21" stroke="currentColor"
                                          stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3 16V15C8.84 16.95 15.16 16.95 21 15V16" stroke="currentColor"
                                          stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3 9.0001C8.84 7.0501 15.16 7.0501 21 9.0001" stroke="currentColor"
                                          stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </li>

                        <li class="d-flex" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="{{__('common.Toggle Sidebar')}}" data-bs-custom-class="tooltip-zindex">
                            <button class="nav-layout-toggler   p-0">
                                @if($user->sidebar!=1)
                                    <a href="{{route('changeMenuStyle','sidebar')}}">
                                        <svg class="sidebar" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path d="M10 2V22" stroke="currentColor" stroke-width="1.5"
                                                  stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M10 8.5H22" stroke="currentColor" stroke-width="1.5"
                                                  stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M10 15.5H22" stroke="currentColor" stroke-width="1.5"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                @else
                                    <a href="{{route('changeMenuStyle','topbar')}}">
                                        <svg class="top_nav_fixed" width="24" height="24" viewBox="0 0 24 24"
                                             fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path d="M22 10H2" stroke="currentColor" stroke-width="1.5"
                                                  stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M12 10V22" stroke="currentColor" stroke-width="1.5"
                                                  stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                @endif
                            </button>
                        </li>

                        <!-- Theme Toggler start -->
                        <li class="d-none d-sm-block" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="{{__('common.Toggle Theme')}}" data-bs-custom-class="tooltip-zindex">
                            <div class="theme-toggler" id="">
                                <div class="icons">
                                    @if($user->dark_mode==1)
                                        <a href="{{route('changeDarkMode','light')}}">
                                            <svg width="24" class="sun" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 18.5C15.5899 18.5 18.5 15.5899 18.5 12C18.5 8.41015 15.5899 5.5 12 5.5C8.41015 5.5 5.5 8.41015 5.5 12C5.5 15.5899 8.41015 18.5 12 18.5Z"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"/>
                                                <path
                                                    d="M19.14 19.14L19.01 19.01M19.01 4.99L19.14 4.86L19.01 4.99ZM4.86 19.14L4.99 19.01L4.86 19.14ZM12 2.08V2V2.08ZM12 22V21.92V22ZM2.08 12H2H2.08ZM22 12H21.92H22ZM4.99 4.99L4.86 4.86L4.99 4.99Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                    @else
                                        <a href="{{route('changeDarkMode','dark')}}">
                                            <svg width="24" class="moon" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M2.03009 12.4209C2.39009 17.5709 6.76009 21.7609 11.9901 21.9909C15.6801 22.1509 18.9801 20.4309 20.9601 17.7209C21.7801 16.6109 21.3401 15.8709 19.9701 16.1209C19.3001 16.2409 18.6101 16.2909 17.8901 16.2609C13.0001 16.0609 9.00009 11.9709 8.98009 7.14094C8.97009 5.84094 9.24009 4.61094 9.73009 3.49094C10.2701 2.25094 9.62009 1.66094 8.37009 2.19094C4.41009 3.86094 1.70009 7.85094 2.03009 12.4209Z"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                    @endif


                                </div>
                            </div>
                        </li>
                        {{-- Theme toggler end --}}
                        {{-- Start Notification --}}
                        <li class="scroll_notification_list" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="{{__('common.Notifications')}}" data-bs-custom-class="tooltip-zindex">
                            <a class="pulse theme_color bell_notification_clicker show_notifications" href="#">
                                <!-- bell   -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path
                                        d="M12.02 2.90991C8.70997 2.90991 6.01997 5.59991 6.01997 8.90991V11.7999C6.01997 12.4099 5.75997 13.3399 5.44997 13.8599L4.29997 15.7699C3.58997 16.9499 4.07997 18.2599 5.37997 18.6999C9.68997 20.1399 14.34 20.1399 18.65 18.6999C19.86 18.2999 20.39 16.8699 19.73 15.7699L18.58 13.8599C18.28 13.3399 18.02 12.4099 18.02 11.7999V8.90991C18.02 5.60991 15.32 2.90991 12.02 2.90991Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round"/>
                                    <path
                                        d="M13.87 3.19994C13.56 3.10994 13.24 3.03994 12.91 2.99994C11.95 2.87994 11.03 2.94994 10.17 3.19994C10.46 2.45994 11.18 1.93994 12.02 1.93994C12.86 1.93994 13.58 2.45994 13.87 3.19994Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                    <path
                                        d="M15.02 19.0601C15.02 20.7101 13.67 22.0601 12.02 22.0601C11.2 22.0601 10.44 21.7201 9.90002 21.1801C9.36002 20.6401 9.02002 19.8801 9.02002 19.0601"
                                        stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"/>
                                </svg>

                                <!--/ bell   -->
                                <span
                                    class="notificationCount notification_count">{{translatedNumber($user->unreadNotifications->count())}}</span>
                                <span class="pulse-ring notification_count_pulse"></span>
                            </a>
                            <!-- Menu_NOtification_Wrap  -->
                            <div class="Menu_NOtification_Wrap notifications_wrap">
                                <div class="notification_Header">
                                    <h4>{{__('common.Notifications')}}</h4>
                                </div>
                                <div class="Notification_body">
                                    <!-- single_notify  -->
                                    @forelse ($user->unreadNotifications as $notification)
                                        <div class="single_notify d-flex align-items-top"
                                             id="menu_notification_show_{{$notification->id}}">
                                            <div class="notify_thumb">
                                                <i class="fa fa-bell"></i>
                                            </div>
                                            <a href="#" class="unread_notification" title="Mark As Read"
                                               data-notification_id="{{$notification->id}}">
                                                <div class="notify_content">
                                                    <h5>{!!  strip_tags(\Illuminate\Support\Str::limit(@$notification->data['title'], 30, $end='...')) !!}</h5>
                                                    {{--                                                    <p>{!!  strip_tags(\Illuminate\Support\Str::limit(@$notification->data['body'], 70, $end='...')) !!}</p>--}}
                                                    <p>{{$notification->created_at->diffForHumans()}}</p>
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <span class="text-center">{{__('common.No Unread Notification')}}</span>
                                    @endforelse

                                </div>
                                <div class="nofity_footer">
                                    <div class="submit_button text-center pt_20">
                                        <a href="{{route('MyNotification')}}"
                                           class="primary-btn radius_30px text_white  fix-gr-bg">{{__('common.See More')}}</a>
                                        <a href="{{route('NotificationMakeAllRead')}}" id="mark_all_as_read"
                                           class="primary-btn radius_30px text_white  fix-gr-bg">{{__('common.Mark As Read')}}</a>
                                    </div>
                                    @if(permissionCheck('notification_setup_list'))
                                        <div class="submit_button text-center ">
                                            <a href="{{route('notification_setup_list')}}"
                                               class="pt-3" style="    color: #415094!important;">
                                                <i class="fas fa-cog"></i>
                                                {{__('setting.Notification')}} {{__('setting.Setup')}}</a>

                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!--/ Menu_NOtification_Wrap  -->
                        </li>
                        {{-- End Notification --}}
                        @if (permissionCheck('communication.PrivateMessage'))
                            <li class="scroll_notification_list" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                title="{{__('common.Message')}}" data-bs-custom-class="tooltip-zindex">
                                <a class="pulse theme_color"
                                   href="{{ route('communication.PrivateMessage') }}">
                                    <!-- bell   -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24"
                                         fill="none">
                                        <path
                                            d="M8.5 19H8C4 19 2 18 2 13V8C2 4 4 2 8 2H16C20 2 22 4 22 8V13C22 17 20 19 16 19H15.5C15.19 19 14.89 19.15 14.7 19.4L13.2 21.4C12.54 22.28 11.46 22.28 10.8 21.4L9.3 19.4C9.14 19.18 8.77 19 8.5 19Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7 8H17" stroke="currentColor" stroke-width="1.5"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7 13H13" stroke="currentColor" stroke-width="1.5"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="notification_count">{{translatedNumber($totalMessage)}}  </span>
                                    @if($totalMessage>0)
                                        <span class="pulse-ring notification_count_pulse"></span>
                                    @endif
                                </a>
                            </li>
                        @endif

                        @if(isModuleActive('Chat'))
                            <li class="scroll_notification_list">
                                @if(env('BROADCAST_DRIVER') == null)
                                    <jquery-notification-component
                                        :loaded_unreads="{{ json_encode($notifications_for_chat) }}"
                                        :user_id="{{ json_encode(auth()->id()) }}"
                                        :redirect_url="{{ json_encode(route('chat.index')) }}"
                                        :check_new_notification_url="{{ json_encode(route('chat.notification.check')) }}"
                                        :asset_type="{{ json_encode('/public') }}"
                                        :mark_all_as_read_url="{{ json_encode(route('chat.notification.allRead')) }}"
                                    ></jquery-notification-component>
                                @else
                                    <notification-component
                                        :loaded_unreads="{{ json_encode($notifications_for_chat) }}"
                                        :user_id="{{ json_encode(auth()->id()) }}"
                                        :redirect_url="{{ json_encode(route('chat.index')) }}"
                                        :asset_type="{{ json_encode('/public') }}"
                                        :mark_all_as_read_url="{{ json_encode(route('chat.notification.allRead')) }}"
                                    ></notification-component>
                                @endif
                            </li>
                        @endif

                    </ul>
                    <div class="profile_info">
                        <div class="profileThumb"
                             style="background-image: url('{{getProfileImage($user->image,$user->name)}}')"></div>

                        <div class="profile_info_iner">
                            <div class="use_info px-3 d-flex align-items-center">
                                <div class="thumb"
                                     style="background-image: url('{{getProfileImage($user->image,$user->name)}}')">

                                </div>
                                <div class="user_text">
                                    <p>{{__('common.Welcome')}}</p>
                                    <span>{{@$user->name}} </span>
                                </div>
                            </div>

                            <div class="profile_info_details">

                                <a href="{{auth()->user()->username?route('profileUniqueUrl',auth()->user()->username):''}}"
                                   class="px-4 py-2">
                                    <!-- <i class="ti-user"></i> -->
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                        <path
                                            d="M20.5899 22C20.5899 18.13 16.7399 15 11.9999 15C7.25991 15 3.40991 18.13 3.40991 22"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                    </svg>

                                    <span>{{ __('common.View Profile') }} </span>
                                </a>
                                <a href="{{route('users.settings')}}" class="px-4 py-2">
                                    <!-- <i class="ti-settings"></i>  -->
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round"/>
                                        <path
                                            d="M2 12.8799V11.1199C2 10.0799 2.85 9.21994 3.9 9.21994C5.71 9.21994 6.45 7.93994 5.54 6.36994C5.02 5.46994 5.33 4.29994 6.24 3.77994L7.97 2.78994C8.76 2.31994 9.78 2.59994 10.25 3.38994L10.36 3.57994C11.26 5.14994 12.74 5.14994 13.65 3.57994L13.76 3.38994C14.23 2.59994 15.25 2.31994 16.04 2.78994L17.77 3.77994C18.68 4.29994 18.99 5.46994 18.47 6.36994C17.56 7.93994 18.3 9.21994 20.11 9.21994C21.15 9.21994 22.01 10.0699 22.01 11.1199V12.8799C22.01 13.9199 21.16 14.7799 20.11 14.7799C18.3 14.7799 17.56 16.0599 18.47 17.6299C18.99 18.5399 18.68 19.6999 17.77 20.2199L16.04 21.2099C15.25 21.6799 14.23 21.3999 13.76 20.6099L13.65 20.4199C12.75 18.8499 11.27 18.8499 10.36 20.4199L10.25 20.6099C9.78 21.3999 8.76 21.6799 7.97 21.2099L6.24 20.2199C5.33 19.6999 5.02 18.5299 5.54 17.6299C6.45 16.0599 5.71 14.7799 3.9 14.7799C2.85 14.7799 2 13.9199 2 12.8799Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>

                                    <span>{{__('frontend.Account Settings')}} </span>
                                </a>


                                @if(isModuleActive('UserType'))
                                    @foreach(auth()->user()->userRoles as $role)
                                        @php
                                            if ($role->id==auth()->user()->role_id){
                                                continue;
                                            }
                                        @endphp
                                        <a href="{{route('usertype.changePanel',$role->id)}}" class="px-4 py-2">
                                            <!-- <i class="ti-link"></i> -->

                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M13.0601 10.9399C15.3101 13.1899 15.3101 16.8299 13.0601 19.0699C10.8101 21.3099 7.17009 21.3199 4.93009 19.0699C2.69009 16.8199 2.68009 13.1799 4.93009 10.9399"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"/>
                                                <path
                                                    d="M10.59 13.4099C8.24996 11.0699 8.24996 7.26988 10.59 4.91988C12.93 2.56988 16.73 2.57988 19.08 4.91988C21.43 7.25988 21.42 11.0599 19.08 13.4099"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"/>
                                            </svg>


                                            <span>{{__('common.Switch to')}} {{$role->name}}</span>
                                        </a>
                                    @endforeach
                                @endif
                                @if ((isModuleActive('LmsSaas') && $user->is_saas_admin==1) || isModuleActive('LmsSaasMD') && $user->is_saas_admin==1)
                                    <a href="{{ route('saas_panel') }}" class="px-4 py-2" onclick="event.preventDefault();
                                            document.getElementById('saas_panel').submit();">
                                        <!-- <i class="ti-user"></i> -->

                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path
                                                d="M20.5899 22C20.5899 18.13 16.7399 15 11.9999 15C7.25991 15 3.40991 18.13 3.40991 22"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                        </svg>

                                        <span>
                                                @if ($user->active_panel=='saas')
                                                {{__('common.Lms Panel')}}
                                            @else
                                                {{__('common.Saas Panel')}}
                                            @endif
                                                </span> </a>

                                    <form id="saas_panel" action="{{ route('saas_panel') }}" method="POST"
                                          class="d-none">
                                        @csrf
                                    </form>
                                @endif

                                @if(isModuleActive('Affiliate') && !isAffiliateUser())
                                    <a href="{{routeIsExist('affiliate.users.request')?route('affiliate.users.request'):''}}"
                                       class="px-4 py-2">
                                        <!-- <i class="ti-money"></i>  -->
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18.04 13.55C17.62 13.96 17.38 14.55 17.44 15.18C17.53 16.26 18.52 17.05 19.6 17.05H21.5V18.24C21.5 20.31 19.81 22 17.74 22H6.26C4.19 22 2.5 20.31 2.5 18.24V11.51C2.5 9.44001 4.19 7.75 6.26 7.75H17.74C19.81 7.75 21.5 9.44001 21.5 11.51V12.95H19.48C18.92 12.95 18.41 13.17 18.04 13.55Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path
                                                d="M2.5 12.4101V7.8401C2.5 6.6501 3.23 5.59006 4.34 5.17006L12.28 2.17006C13.52 1.70006 14.85 2.62009 14.85 3.95009V7.75008"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path
                                                d="M22.5588 13.9702V16.0302C22.5588 16.5802 22.1188 17.0302 21.5588 17.0502H19.5988C18.5188 17.0502 17.5288 16.2602 17.4388 15.1802C17.3788 14.5502 17.6188 13.9602 18.0388 13.5502C18.4088 13.1702 18.9188 12.9502 19.4788 12.9502H21.5588C22.1188 12.9702 22.5588 13.4202 22.5588 13.9702Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path d="M7 12H14" stroke="currentColor" stroke-width="1.5"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>

                                        <span>
                                            {{__('frontend.Join Affiliate Program')}}
                                        </span>
                                    </a>
                                @endif

                                <div class="log-out-link-container">
                                    <a href="{{ route('logout') }}" class="px-4 py-2 log-out-link" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                        <!-- <i class="ti-shift-left"></i>  -->
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M8.90002 7.55999C9.21002 3.95999 11.06 2.48999 15.11 2.48999H15.24C19.71 2.48999 21.5 4.27999 21.5 8.74999V15.27C21.5 19.74 19.71 21.53 15.24 21.53H15.11C11.09 21.53 9.24002 20.08 8.91002 16.54"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path d="M15 12H3.62" stroke="currentColor" stroke-width="1.5"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M5.85 8.6499L2.5 11.9999L5.85 15.3499" stroke="currentColor"
                                                  stroke-width="1.5" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                        </svg>

                                        <span>{{__('dashboard.Logout')}}</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($user->sidebar!=1)
                    @include('backend.partials.nav')
                @endif

            </div>
        </div>
    </div>
</div>


@push('js')
    <script>
        $(function () {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
