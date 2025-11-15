@php
    $user =\Illuminate\Support\Facades\Auth::user();
@endphp
    <!-- sidebar part here -->
<nav id="sidebar" class="sidebar  {{$user->sidebar!=1?'d-none':''}}">

    <div class="sidebar-header update_sidebar">
        <a class="large_logo" href="{{ url('/') }}">
            <img src="{{ getLogoImage(Settings('logo')) }}" alt="">
        </a>
        <a class="mini_logo" href="{{ url('/') }}">
            <img src="{{ getLogoImage(Settings('logo')) }}" alt="">
        </a>
        <a id="close_sidebar" class="d-lg-none">
            <i class="ti-close"></i>
        </a>
    </div>
    @if($user->role_id!=1)
        <div class="sidebar-user text-center">
            <div class="sidebar-profile mx-auto">
                <img src="{{getProfileImage($user->image,Auth::user()->name)}}"
                     alt="">
            </div>
            <h4>{{$user->name}} </h4>
            @if(isModuleActive('UserGroup') && $user->userGroup  && $user->userGroup->group->status)
                <p class="text-nowrap mb-2">{{$user->userGroup->group->title}}</p>
            @endif

            <div class="sidebar-badge">
                @php
                    $already=[];
                @endphp
                @foreach($user->userLatestBadges as $badge)
                    @php
                        $b =$badge->badge;

                        if (in_array($b->type,$already)){
                            continue;
                        }else{
                            $already[]=$b->type;
                        }
                    @endphp
                    <div class="sidebar-badge-list"
                         data-bs-toggle="tooltip" data-placement="top"
                         title="{{$b->title}} {{ucfirst($b->type)}} {{trans('setting.Badge')}}">
                        <img
                            src="{{asset($b->image)}}" alt=""></div>
                @endforeach

            </div>
        </div>
    @endif
    <ul id="sidebar_menu">

        @if ((isModuleActive('LmsSaas') || isModuleActive('LmsSaasMD')) && SaasDomain() != 'main' && !hasActiveSaasPlan())
            <li>
                <a href="#" class="has-arrow" aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-university"></span>
                    </div>
                    <div class="nav_title">
                        <span>{{ __('saas.Saas Management') }}</span>
                    </div>
                </a>

                <ul>
                    <li>
                        <a href="{{ route('saas.myPlan') }}">{{ __('saas.My Plan') }}</a>
                    </li>
                </ul>
            </li>
        @else

            @if ((isModuleActive('LmsSaas') || isModuleActive('LmsSaasMD')) && SaasDomain() != 'main' && hasActiveSaasPlan())
                <li>
                    <a href="#" class="has-arrow" aria-expanded="false">
                        <div class="nav_icon_small">
                            <span class="fas fa-university"></span>
                        </div>
                        <div class="nav_title">
                            <span>{{ __('saas.Saas Management') }}</span>
                        </div>
                    </a>

                    <ul>
                        <li>
                            <a href="{{ route('saas.myPlan') }}">{{ __('saas.My Plan') }}</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if(isset($sections))
                @foreach($sections as $key => $section)
                    @php
                        $count = $section->activeMenus->count();
                        if ($count == 0){
                            continue;
                        }
                    @endphp
                    @if(!empty($section->name))
                        <span class="menu_seperator">
                    {{$section->name}}
                </span>
                    @endif
                    @if($section->activeMenus->count())
                        @foreach($section->activeMenus as  $menu)
                            @php
                                if (isModuleActive('LmsSaas')){
                                    if ($menu->power==1){
                                        continue;
                                    }
                                }
                                    $ignoreDynamicPage=[];
                                        $submenus =$section->activeSubmenus->where('parent_route',$menu->route)->where('parent_route','!=','dashboard');
                                        if(hasDynamicPage()){
                                            $ignoreDynamicPage=[
        //                                        'frontend.homeContent',
                                                'frontend.privacy_policy',
                                                'frontend.privacy_policy',
                                                'frontend.AboutPage',
                                                'frontend.ContactPageContent',
        //                                        'frontend.pageContent'
                                        ];

                                        }
                                           if (isModuleActive('AdvanceQuiz')){
                                                $setup =\Modules\Quiz\Entities\QuizeSetup::getData();
                                                if ($setup->advance_test_mode_status!=1){
                                                    $ignoreDynamicPage[] ='quiz.test-list';
                                                    $ignoreDynamicPage[] ='quiz.mark-test';
                                                    $ignoreDynamicPage[] ='quiz.supervisor';
                                                }
                                            }
                                           $submenus =   $submenus->whereNotIn('route',$ignoreDynamicPage);
                            @endphp

                            @if(auth()->user()->role_id==1)
                                @if($menu->route == 'users.my_panel.index')
                                    @continue
                                @endif
                            @endif

                            @if(permissionCheck($menu->route))

                                @if(!$menu->module ||  isModuleActive($menu->module))
                                    @php
                                        $hasChild =$submenus->count();

                                        if ($menu->theme && $menu->theme!=currentTheme()){
                                            $hasChild--;
                                            continue;
                                        }
                                    @endphp
                                    <li class="{{spn_active_link(childrenRoute($menu))}}">
                                        <a href="@if(!$hasChild && validRouteUrl($menu->route)) {{validRouteUrl($menu->route)}} @else # @endif"
                                           class=" @if($hasChild) has-arrow @endif"
                                           aria-expanded="false">
                                            <div class="nav_icon_small">
                                                <span class="{{@$menu->icon??'fas fa-th'}}"></span>
                                            </div>
                                            <div class="nav_title">
                                                <span>{{$menu->name}}</span>
                                                @if((env('APP_SYNC') || config('app.demo_mode'))&& !empty($menu->module))
                                                    <span class="demo_addons">Addon</span>
                                                @endif
                                            </div>
                                        </a>
                                        @if($hasChild)
                                            <ul>
                                                @foreach($submenus as $submenu)

                                                    @php
                                                        if (isModuleActive('LmsSaas')){
                                                           if ($submenu->power==1){
                                                               continue;
                                                           }
                                                       }
                                                    @endphp
                                                    @if(permissionCheck($submenu->route))
                                                        @if(!$submenu->module ||  isModuleActive($submenu->module))
                                                            @php
                                                                if ($submenu->theme && $submenu->theme!=currentTheme()){
                                                                      continue;
                                                                  }
                                                            @endphp
                                                            <li class="{{spn_active_link(childrenRoute($submenu))}}">
                                                                <a href="@if(!empty(validRouteUrl($submenu->route))) {{validRouteUrl($submenu->route)}} @else # @endif"> {{$submenu->name}}</a>
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endif
                            @endif

                        @endforeach
                    @endif
                @endforeach
            @endif
        @endif
    </ul>

</nav>

