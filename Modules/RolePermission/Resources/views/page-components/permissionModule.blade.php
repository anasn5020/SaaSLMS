@php 

         use Modules\Quiz\Entities\QuizeSetup;$subMenus =$permissions->where('parent_route',$Module->route);

        if (isModuleActive('AdvanceQuiz')){
            $ignoreDynamicPage=[];
            $setup =QuizeSetup::getData();
            if ($setup->advance_test_mode_status!=1){
                $ignoreDynamicPage[] ='quiz.test-list';
                $ignoreDynamicPage[] ='quiz.mark-test';
                $ignoreDynamicPage[] ='quiz.supervisor';
            }
            $subMenus = $subMenus->whereNotIn('route',$ignoreDynamicPage);
        }


@endphp

<div class="single_role_blocks">
    <div class="single_permission" id="{{ $Module->id }}">
        <div class="permission_header d-flex align-items-center justify-content-between">
            <div>
                <input type="checkbox" name="module_id[]" value="{{ $Module->id }}" id="Main_Module_{{ $Module->id }}"
                       class="common-radio permission-checkAll main_module_id_{{ $Module->id }}" {{ $role->permissions->contains('id',$Module->id) ? 'checked' : '' }} >
                <label for="Main_Module_{{ $Module->id }}">{{ $Module->name }}


                    <a class=" btn-modal ms-2"
                       data-container="#commonModal" type="button"
                       href="{{route('sidebar-manager.menu-edit-form',$Module->id)}}?type=module">
                        <i class="ti-pencil-alt"></i>
                    </a>

                </label>
            </div>
            @if(count($subMenus)!=0)
                <div class="arrow collapsed" data-bs-toggle="collapse" data-bs-target="#Role{{ $Module->id }}"></div>
            @endif
        </div>

        <div id="Role{{ $Module->id }}" class="collapse">
            <div class="permission_body">
                <ul>
                    @foreach ($subMenus->where('menu_status',1) as $SubMenu)

                        @if(!$SubMenu->module ||  isModuleActive($SubMenu->module))

                            @php

                                if ($SubMenu->theme && $SubMenu->theme!=currentTheme()){
                                    continue;
                                }
                            @endphp
                            <li>
                                <div class="submodule">
                                    <input id="Sub_Module_{{ $SubMenu->id }}" name="module_id[]"
                                           value="{{ $SubMenu->id }}"
                                           class="infix_csk common-radio  module_id_{{ $Module->id }} module_link"
                                           {{ $role->permissions->contains('id',$SubMenu->id) ? 'checked' : '' }}  type="checkbox">

                                    <label
                                        for="Sub_Module_{{ $SubMenu->id }}">{{$SubMenu->name}}

                                        <a class=" btn-modal ms-2"
                                           data-container="#commonModal" type="button"
                                           href="{{route('sidebar-manager.menu-edit-form',$SubMenu->id)}}?type=module">
                                            <i class="ti-pencil-alt"></i>
                                        </a>

                                    </label>
                                    <br>
                                </div>

                                <ul class="option">
                                    @php
                                        $SubMenu->actionList =$permissions->where('parent_route',$SubMenu->route)
                                    @endphp
                                    @foreach ($SubMenu->actionList as $action)
                                        @if(!$action->module ||  isModuleActive($action->module))
                                            @php
                                                if ($action->theme && $action->theme!=currentTheme()){
                                                      continue;
                                                  }
                                            @endphp
                                            <li>
                                                <div class="module_link_option_div" id="{{ $SubMenu->id }}">
                                                    <input id="Option_{{  $action->id }}" name="module_id[]"
                                                           value="{{  $action->id }}"
                                                           class="infix_csk common-radio module_id_{{ $Module->id }} module_option_{{ $Module->id }}_{{ $SubMenu->id }} module_link_option"
                                                           {{ $role->permissions->contains('id',$action->id) ? 'checked' : ''  }}  type="checkbox">
                                                    <label
                                                        for="Option_{{  $action->id }}">{{ $action->name}}

                                                        <a class=" btn-modal ms-2"
                                                           data-container="#commonModal" type="button"
                                                           href="{{route('sidebar-manager.menu-edit-form',$action->id)}}?type=module">
                                                            <i class="ti-pencil-alt"></i>
                                                        </a>
                                                    </label>
                                                    <br>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
