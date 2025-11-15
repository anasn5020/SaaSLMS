@php
    $user =auth()->user();
@endphp
<div class="header_iner d-flex justify-content-between align-items-center gap-3">
    <div class="sidebar_icon d-lg-none">
        <i class="ti-menu"></i>
    </div>
    <div class="category_search d-flex category_box_iner">

        {{--        <div class="input-group-prepend2">--}}
        {{--            <a href="#" class="categories_menu">--}}
        {{--                <i class="fas fa-th"></i>--}}
        {{--                {{__('courses.Category')}}--}}
        {{--            </a>--}}

        {{--            <div class="menu_dropdown">--}}
        {{--                <ul>--}}
        {{--                    @if(isset($categories ))--}}
        {{--                        @foreach($categories  as $category)--}}
        {{--                            <li class="mega_menu_dropdown active_menu_item">--}}
        {{--                                <a href="{{route('categoryCourse',[$category->id,$category->slug])}}">{{$category->name}}</a>--}}
        {{--                                @if(isset($category->activeSubcategories))--}}
        {{--                                    @if(count($category->activeSubcategories)!=0)--}}
        {{--                                        <ul>--}}
        {{--                                            <li>--}}
        {{--                                                <div class="menu_dropdown_iner d-flex">--}}
        {{--                                                    <div class="single_menu_dropdown">--}}
        {{--                                                        <h4>{{__('courses.Sub Category')}}</h4>--}}
        {{--                                                        <ul>--}}
        {{--                                                            @if(isset($category->activeSubcategories))--}}
        {{--                                                                @foreach( $category->activeSubcategories as $subcategory)--}}
        {{--                                                                    <li>--}}
        {{--                                                                        <a href="{{route('subCategory.course',[$subcategory->id,$subcategory->slug])}}">{{$subcategory->name}}</a>--}}
        {{--                                                                    </li>--}}
        {{--                                                                @endforeach--}}
        {{--                                                            @endif--}}
        {{--                                                        </ul>--}}
        {{--                                                    </div>--}}

        {{--                                                </div>--}}
        {{--                                            </li>--}}
        {{--                                        </ul>--}}
        {{--                                    @endif--}}
        {{--                                @endif--}}
        {{--                            </li>--}}
        {{--                        @endforeach--}}
        {{--                    @endif--}}
        {{--                </ul>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <form action="{{route('search')}}">
            <div class="input-group theme_search_field ">
                <div class="input-group-prepend">
                    <button class="btn" type="button" id="button-addon1"><i
                            class="ti-search"></i>
                    </button>
                </div>

                <input type="text" class="form-control" name="query"
                       placeholder="{{__('frontend.Search for course, skills and Videos')}}"
                       onfocus="this.placeholder = ''"
                       onblur="this.placeholder = '{{__('frontend.Search for course, skills and Videos')}}'">

            </div>
        </form>
    </div>
    <div class="d-flex align-items-center">
        <div class="notification_wrapper" id="main-nav-for-chat">
            <ul>

                <li class="notification_open">
                    <a href="#" class="notify_icon">
                        <div class="notify_icon">
                            <img src="{{asset('/public/frontend/infixlmstheme/')}}/img/svg/bell.svg" alt="">
                            {{-- <i class="ti-bell"></i> --}}
                        </div>

                        <span class="notify_count @if($user->unreadNotifications->count()==0) d-none @endif"></span>
                    </a>
                    <div class="notification_area">
                        <div class="notification_body">
                            @foreach ($user->unreadNotifications as $notification)
                                <a href="{{$notification->data['actionURL']??'#'}}"
                                   class="single_nofy unread_notification"
                                   title="Mark As Read" data-notification_id="{{$notification->id}}">
                                    <div class="notyfy_content">
                                        <h4>  {!! strip_tags($notification->data['body']) !!}</h4>
                                        <p>{{$notification->created_at->diffForHumans()}}</p>
                                    </div>
                                </a>
                            @endforeach
                            @if($user->unreadNotifications->count()==0)
                                <a href="#" class="single_nofy align-items-center justify-content-center">
                                    <div class="notyfy_content ">
                                        <h4> {{__('frontend.No unread notification')}}</h4>
                                    </div>

                                </a>
                            @endif
                        </div>
                        <div class="notification_footer ">
                            <div class="d-flex align-items-center justify-content-between flex-wrap px-3">

                                <a href="{{route('myNotification')}}"
                                   class="readMore_text w-50  ">{{__('common.View All')}}</a>

                                <a href="{{route('NotificationMakeAllRead')}}"
                                   class="readMore_text  w-50">{{__('common.Mark As Read')}}</a>

                            </div>
                            @if (permissionCheck('myNotificationSetup'))
                                <div class="d-flex align-items-center justify-content-center flex-wrap px-3">
                                    <a href="{{route('myNotificationSetup')}}"
                                       class=" w-100  ">
                                        <i class="fas fa-cog"></i>
                                        {{__('setting.Notification')}} {{__('setting.Setup')}}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </li>
                <li>
                    <a href="{{route('myWishlists')}}">
                        <div class="notify_icon">
                            <img src="{{asset('/public/frontend/infixlmstheme/')}}/img/svg/heart.svg" alt="">
                        </div>
                        @if(totalWhiteList()!=0)
                            <span class="notify_count"></span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="#" class="cart_store">
                        <div class="notify_icon">
                            <img class="" src="{{asset('/public/frontend/infixlmstheme/')}}/img/svg/cart.svg" alt="">
                        </div>
                        @if(cartItem()!=0)
                            <span class="notify_count "></span>
                        @endif
                    </a>
                </li>

                @if(isModuleActive('Chat'))
                    <li class="scroll_notification_list">
                        @if(env('BROADCAST_DRIVER') == null)
                            <jquery-notification-component
                                :loaded_unreads="{{ json_encode($notifications_for_chat) }}"
                                :user_id="{{ json_encode(auth()->id()) }}"
                                :redirect_url="{{ json_encode(route('chat.index')) }}"
                                :check_new_notification_url="{{ json_encode(route('chat.notification.check')) }}"
                                :mark_all_as_read_url="{{ json_encode(route('chat.notification.allRead')) }}"
                                :asset_type="{{ json_encode('/public') }}"
                            ></jquery-notification-component>
                        @else
                            <notification-component
                                :loaded_unreads="{{ json_encode($notifications_for_chat) }}"
                                :user_id="{{ json_encode(auth()->id()) }}"
                                :redirect_url="{{ json_encode(route('chat.index')) }}"
                                :mark_all_as_read_url="{{ json_encode(route('chat.notification.allRead')) }}"
                                :asset_type="{{ json_encode('/public') }}"
                            ></notification-component>
                        @endif
                    </li>
                @endif
                @if(Settings('gamification_status') && Settings('gamification_leaderboard_status'))
                    <li class="">
                        <button title=" {{__('common.points')}}"
                                class="theme_btn small_btn point_btn gap-1 d-flex align-items-center">
                            <svg width="26" height="24" viewBox="0 0 18 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.70495 18.8625L4.76695 18.0076L4.76694 18.0076L4.70495 18.8625ZM13.3792 18.8625L13.3172 18.0076L13.3172 18.0076L13.3792 18.8625ZM16.9653 15.2749L17.8196 15.3444L17.8196 15.3442L16.9653 15.2749ZM16.9653 9.56532L16.1109 9.63471V9.63471L16.9653 9.56532ZM13.3792 5.97769L13.3172 6.83258L13.3172 6.83258L13.3792 5.97769ZM4.70495 5.97769L4.76695 6.83258L4.76696 6.83258L4.70495 5.97769ZM1.11898 9.56532L1.97331 9.63471L1.97331 9.63471L1.11898 9.56532ZM1.11898 15.2749L0.264652 15.3443L0.264652 15.3443L1.11898 15.2749ZM9.04202 5.81295L8.31398 6.26534C8.47038 6.51703 8.74569 6.67009 9.04202 6.67009C9.33835 6.67009 9.61366 6.51703 9.77006 6.26534L9.04202 5.81295ZM11.3245 2.13965L12.0526 2.59204L12.0526 2.59204L11.3245 2.13965ZM15.5194 2.27772L14.7629 2.68065L14.7629 2.68067L15.5194 2.27772ZM14.4419 5.55281L14.0686 4.78124L14.0685 4.78125L14.4419 5.55281ZM13.1704 5.21584C12.7443 5.42203 12.566 5.93463 12.7722 6.36075C12.9784 6.78687 13.491 6.96515 13.9171 6.75895L13.1704 5.21584ZM6.75952 2.13965L6.03148 2.59204L6.03148 2.59204L6.75952 2.13965ZM2.56453 2.27772L3.32106 2.68066L3.32106 2.68065L2.56453 2.27772ZM3.64208 5.55281L3.26875 6.32438L3.26876 6.32438L3.64208 5.55281ZM4.16693 6.75897C4.59306 6.96515 5.10565 6.78685 5.31183 6.36072C5.51801 5.9346 5.33971 5.42201 4.91358 5.21582L4.16693 6.75897ZM4.64294 19.7174C5.95759 19.8128 7.40943 19.8571 9.04208 19.8571V18.1429C7.43922 18.1429 6.03019 18.0993 4.76695 18.0076L4.64294 19.7174ZM9.04208 19.8571C10.6747 19.8571 12.1266 19.8128 13.4412 19.7174L13.3172 18.0076C12.054 18.0993 10.645 18.1429 9.04208 18.1429V19.8571ZM13.4412 19.7174C15.7971 19.5466 17.6298 17.6794 17.8196 15.3444L16.1109 15.2055C15.988 16.7171 14.8105 17.8994 13.3172 18.0076L13.4412 19.7174ZM17.8196 15.3442C17.8969 14.3906 17.9412 13.4168 17.9412 12.42H16.227C16.227 13.3658 16.1849 14.2932 16.1109 15.2057L17.8196 15.3442ZM17.9412 12.42C17.9412 11.4234 17.8971 10.4496 17.8196 9.49592L16.1109 9.63471C16.185 10.5469 16.227 11.4742 16.227 12.42H17.9412ZM17.8196 9.49593C17.6299 7.1608 15.7971 5.29365 13.4412 5.12279L13.3172 6.83258C14.8106 6.94089 15.9882 8.12318 16.1109 9.63471L17.8196 9.49593ZM13.4412 5.12279C12.1266 5.02742 10.6747 4.98312 9.04208 4.98312V6.69741C10.645 6.69741 12.054 6.74095 13.3172 6.83258L13.4412 5.12279ZM9.04208 4.98312C7.40945 4.98312 5.9576 5.02742 4.64293 5.12279L4.76696 6.83258C6.03018 6.74095 7.4392 6.69741 9.04208 6.69741V4.98312ZM4.64295 5.12279C2.28705 5.29365 0.454306 7.16083 0.264652 9.49593L1.97331 9.63471C2.09608 8.12315 3.2736 6.94089 4.76695 6.83258L4.64295 5.12279ZM0.264652 9.49592C0.187194 10.4495 0.142857 11.4234 0.142857 12.42H1.85714C1.85714 11.4743 1.89921 10.547 1.97331 9.63471L0.264652 9.49592ZM0.142857 12.42C0.142857 13.4168 0.187194 14.3906 0.264652 15.3443L1.97331 15.2056C1.89921 14.2932 1.85714 13.3658 1.85714 12.42H0.142857ZM0.264652 15.3443C0.454306 17.6794 2.28704 19.5466 4.64296 19.7174L4.76694 18.0076C3.27361 17.8994 2.09608 16.7171 1.97331 15.2056L0.264652 15.3443ZM1 11.815H17.0841V10.1007H1V11.815ZM9.89922 19V5.84026H8.18493V19H9.89922ZM9.77006 6.26534L12.0526 2.59204L10.5965 1.68727L8.31398 5.36057L9.77006 6.26534ZM12.0526 2.59204C12.6857 1.57304 14.2002 1.62413 14.7629 2.68065L16.276 1.87479C15.0914 -0.349321 11.9259 -0.45225 10.5965 1.68727L12.0526 2.59204ZM14.7629 2.68067C15.1702 3.44537 14.8617 4.39747 14.0686 4.78124L14.8152 6.32439C16.4767 5.52049 17.1445 3.50534 16.276 1.87477L14.7629 2.68067ZM14.0685 4.78125L13.1704 5.21584L13.9171 6.75895L14.8152 6.32437L14.0685 4.78125ZM9.77006 5.36057L7.48756 1.68727L6.03148 2.59204L8.31398 6.26534L9.77006 5.36057ZM7.48756 1.68727C6.15812 -0.452245 2.99255 -0.349329 1.80799 1.87479L3.32106 2.68065C3.88375 1.62414 5.3983 1.57303 6.03148 2.59204L7.48756 1.68727ZM1.808 1.87479C0.93955 3.50534 1.60731 5.52048 3.26875 6.32438L4.01541 4.78124C3.22229 4.39748 2.91376 3.44537 3.32106 2.68066L1.808 1.87479ZM3.26876 6.32438L4.16693 6.75897L4.91358 5.21582L4.01541 4.78124L3.26876 6.32438Z"
                                    fill="currentColor"></path>
                            </svg>


                            {{$user->gamification_total_points - $user->gamification_total_spent_points }} </button>
                    </li>
                @endif
            </ul>
        </div>
        <div class="profile_info collaps_part">
            <div class="profile_img collaps_icon  d-flex align-items-center">

                <div class="profile_info_icon collaps_icon">
                    <svg width="24" height="28" viewBox="0 0 24 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 12.7273C13.3185 12.7273 14.6075 12.3541 15.7038 11.6548C16.8001 10.9556 17.6546 9.9617 18.1592 8.7989C18.6638 7.63609 18.7958 6.35658 18.5386 5.12216C18.2813 3.88773 17.6464 2.75384 16.714 1.86387C15.7817 0.973898 14.5938 0.367821 13.3006 0.122278C12.0074 -0.123264 10.667 0.00275726 9.44878 0.484406C8.2306 0.966054 7.18941 1.7817 6.45687 2.82819C5.72433 3.87469 5.33333 5.10503 5.33333 6.36364C5.33545 8.05076 6.03851 9.6682 7.28829 10.8612C8.53808 12.0542 10.2325 12.7253 12 12.7273ZM12 2.54546C12.7911 2.54546 13.5645 2.76939 14.2223 3.18894C14.8801 3.60848 15.3928 4.2048 15.6955 4.90248C15.9983 5.60016 16.0775 6.36787 15.9231 7.10853C15.7688 7.84918 15.3878 8.52952 14.8284 9.0635C14.269 9.59748 13.5563 9.96113 12.7804 10.1085C12.0044 10.2558 11.2002 10.1802 10.4693 9.89118C9.73836 9.60219 9.11365 9.1128 8.67412 8.48491C8.2346 7.85701 8 7.1188 8 6.36364C8 5.35099 8.42143 4.37982 9.17157 3.66378C9.92172 2.94773 10.9391 2.54546 12 2.54546ZM1.33333 28H22.6667C23.0203 28 23.3594 27.8659 23.6095 27.6272C23.8595 27.3885 24 27.0648 24 26.7273C24 23.6893 22.7357 20.7758 20.4853 18.6277C18.2348 16.4795 15.1826 15.2727 12 15.2727C8.8174 15.2727 5.76515 16.4795 3.51472 18.6277C1.26428 20.7758 4.74244e-08 23.6893 0 26.7273C0 27.0648 0.140476 27.3885 0.390524 27.6272C0.640573 27.8659 0.979711 28 1.33333 28ZM12 17.8182C14.2437 17.8208 16.4115 18.5937 18.1077 19.9957C19.8038 21.3977 20.9151 23.3352 21.2387 25.4545H2.76133C3.08488 23.3352 4.19618 21.3977 5.89233 19.9957C7.58848 18.5937 9.75632 17.8208 12 17.8182Z"
                            fill="currentColor"/>
                    </svg>
                </div>


            </div>
            <div class="profile_info_iner collaps_part_content">
                <a href="{{url('/')}}">{{__('frontendmanage.Home')}}</a>
                <a href="{{auth()->user()->username?route('profileUniqueUrl',auth()->user()->username):''}}">{{__('frontendmanage.My Profile')}}</a>
                <a href="{{route('users.settings')}}">{{__('frontend.Account Settings')}}</a>
                @if(isModuleActive('Affiliate') && $user->affiliate_request!=1)
                    <a href="{{routeIsExist('affiliate.users.request')?route('affiliate.users.request'):''}}">{{__('frontend.Join Affiliate Program')}}</a>
                @endif
                @if(isModuleActive('UserType'))
                    @foreach($user->userRoles as $role)
                        @php
                            if ($role->id==$user->role_id){
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
</div>
