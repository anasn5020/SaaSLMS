<div class="backend-top-nav">
    <nav class="navbar navbar-expand-lg mb-0">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="backendNavBarToggler">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    @if(isset($sections))
                        @foreach($sections as $key => $section)
                            @php
                                $count = $section->activeMenus->count();
                                if ($count == 0){
                                    continue;
                                }
                            @endphp
                            <li class="nav-item dropdown hoverable d-flex ">
                                <a class="nav-link dropdown-toggle " role="button" data-bs-toggle="dropdown"
                                   aria-expanded="false" href="#">
                                    <i class="{{$section->icon}}"></i>

                                    <span>
                                                                            {{!empty($section->name)?$section->name:' '}}

                                    </span>
                                </a>
                                @if($section->activeMenus->count())
                                    <ul class="dropdown-menu">

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
                                                    <li class="  @if($hasChild)has-submenu @endif"><a
                                                            class="dropdown-item"
                                                            href="@if(!$hasChild && validRouteUrl($menu->route)) {{validRouteUrl($menu->route)}} @else # @endif">
                                                            {{$menu->name}}
                                                            @if((env('APP_SYNC') || config('app.demo_mode'))&& !empty($menu->module))
                                                                <span class="demo_addons">Addon</span>
                                                            @endif
                                                        </a>
                                                        @if($hasChild)
                                                            <ul class="dropdown-menu submenu">
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
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                   href="@if(!empty(validRouteUrl($submenu->route)))
                                                                                        {{validRouteUrl($submenu->route)}}
                                                                                    @else
                                                                                        #
                                                                                    @endif">{{$submenu->name}}</a>
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
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    @endif

                </ul>
            </div>
        </div>
    </nav>
</div>
