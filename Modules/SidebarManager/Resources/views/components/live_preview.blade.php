<h4>{{__('common.Live Preview')}}</h4>
<div class="mt_30">

    <nav class="preview_menu_wrapper">
        <ul id="previewMenu">


            @if(isset($sections))
                @foreach($sections as $section)
                    @php
                        $count = $section->permissions->count();
                        if ($count == 0){
                            continue;
                        }
                    @endphp
                    <li class="preview_section">
                        {{$section->name}}
                    </li>
                    @if($section->activeMenus->count())
                        @foreach($section->activeMenus as $menu)
                            @if(!$menu->module ||  isModuleActive($menu->module))
                                @php
                                    $submenus =$section->activeSubmenus->where('parent_route',$menu->route)->where('parent_route','!=','dashboard');
                                     if ($menu->theme && $menu->theme!=currentTheme()){
                                                    continue;
                                                }

                                @endphp

                                <li class="">
                                    <a href="#"
                                       class="@if($submenus->count()) has-arrow @endif">
                                        <div class="nav_icon_small">
                                            <span
                                                class="{{$menu->icon??'fas fa-th'}}"></span>
                                        </div>
                                        <div class="nav_title">
                                            <span>{{$menu->name}}</span>
                                        </div>
                                    </a>
                                    @if($submenus->count())
                                        <ul>
                                            @foreach($submenus as $submenu)

                                                @if(!$submenu->module ||  isModuleActive($submenu->module))
                                                    @php
                                                        if ($submenu->theme && $submenu->theme!=currentTheme()){
                                                              continue;
                                                          }
                                                    @endphp
                                                    <li>
                                                        <a href="#">
                                                            {{$submenu->name}}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>

                                    @endif
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endif
        </ul>
    </nav>
</div>
