<h4>{{__('common.Menu List')}}</h4>
<div class="">


    @push('styles')
        <link href="{{asset('public/backend/vendors/nestable/jquery.nestable.min.css')}}" rel="stylesheet">
        <link href="{{asset('Modules/SidebarManager/Resources/assets/css/sidebar.css')}}" rel="stylesheet">

    @endpush


    <div class="row">
        <div class="col-xl-12 menu_item_div" id="itemDiv">
            @if(isset($sections))
                @foreach($sections as $section)

                    <div class="closed_section" data-id="{{$section->id}}">
                        <div id="accordion" class="dd">
                            <div class="section_nav">
                                <h5>{{$section->name}}</h5>
                                <div class="setting_icons">
                                     <span class="edit-btn">
                                                             <a class=" btn-modal"
                                                                data-container="#commonModal" type="button"
                                                                href="{{route('sidebar-manager.section-edit-form',$section->id)}}"
                                                             >
                                                           <i class="ti-pencil-alt"></i>
                                                        </a>

                                                        </span>
                                    <i class="ti-close delete_section" data-id="{{$section->id}}"></i>
                                    <i class="ti-angle-up toggle_up_down"></i>
                                </div>
                            </div>
                        </div>
                        @if($section->activeMenus->count())
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="accordion" class="dd menu-list used_menu"
                                                 data-section="{{$section->id}}">
                                                <ol class="dd-list">

                                                    @foreach($section->activeMenus as $menu)
                                                        @if(!$menu->module ||  isModuleActive($menu->module))
                                                            @php
                                                                $submenus =$section->activeSubmenus->where('parent_route',$menu->route)->where('parent_route','!=','dashboard');
                                                                   if ($menu->theme && $menu->theme!=currentTheme()){
                                                                    continue;
                                                                }
                                                            @endphp
                                                            <li class="dd-item" data-id="{{$menu->id}}"
                                                                data-section_id="{{$menu->section_id}}"
                                                                data-parent_route="{{$menu->parent_route}}"
                                                            >
                                                                <div class="card accordion_card"
                                                                     id="accordion_{{$menu->id}}">
                                                                    <div class="card-header item_header"
                                                                         id="heading_{{$menu->id}}">
                                                                        <div class="dd-handle">
                                                                            <div class="float-start">
                                                                                {{$menu->name}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="float-end btn_div">
                                                                            <div class="edit_icon">
                           <span class="edit-btn">
                                <a class=" btn-modal"
                                   data-container="#commonModal" type="button"
                                   href="{{route('sidebar-manager.menu-edit-form',$menu->id)}}"
                                >
                                                           <i class="ti-pencil-alt"></i>
                                                        </a>

                                                   </span>

                                                                                <i class="ti-close remove_menu"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <ol class="dd-list">
                                                                    @if($menu->route!='dashboard')
                                                                        @foreach($submenus as $submenu)
                                                                            @if(!$submenu->module ||  isModuleActive($submenu->module))
                                                                                @php
                                                                                    if ($submenu->theme && $submenu->theme!=currentTheme()){
                                                                                          continue;
                                                                                      }
                                                                                @endphp
                                                                                <li class="dd-item"
                                                                                    data-id="{{$submenu->id}}">
                                                                                    <div class="card accordion_card"
                                                                                         id="accordion_{{$submenu->id}}">
                                                                                        <div
                                                                                            class="card-header item_header"
                                                                                            id="heading_{{$submenu->id}}">
                                                                                            <div class="dd-handle">
                                                                                                <div
                                                                                                    class="float-start">
                                                                                                    {{$submenu->name}}

                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="float-end btn_div">
                                                                                                <div
                                                                                                    class="float-end btn_div">
                                                                                                    <div
                                                                                                        class="edit_icon">
                           <span class="edit-btn">
                                <a class=" btn-modal"
                                   data-container="#commonModal" type="button"
                                   href="{{route('sidebar-manager.menu-edit-form',$submenu->id)}}"
                                >
                                                           <i class="ti-pencil-alt"></i>
                                                        </a>

                                                   </span>

                                                                                                        <i class="ti-close remove_menu"></i>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </ol>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="accordion2" class="dd menu-list used_menu"
                                                 data-section="{{$section->id}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>


    @push('scripts')
        <script src="{{asset('public/backend/vendors/nestable/jquery.nestable.min.js')}}"></script>
        <script src="{{asset('Modules/SidebarManager/Resources/assets/js/sidebar.js')}}"></script>
    @endpush


</div>
