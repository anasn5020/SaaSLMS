@php
    $LanguageList = getLanguageList();
@endphp
@if(count(@$menus)>0)
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div id="accordion" class="dd">
                        <ol class="dd-list">

                            @foreach($menus as $key => $element)
                                @php
                                    $mega_menu=$element->mega_menu;
                                    $level=1;
                                @endphp
                                <li class="dd-item" data-id="{{$element->id}}">
                                    <div class="card accordion_card" id="accordion_{{$element->id}}">
                                        <div class="card-header item_header" id="heading_{{$element->id}}">
                                            <div class="dd-handle">
                                                <div class="float-start">
                                                    {{$element->title}} ( {{$element->type}} )
                                                </div>
                                            </div>
                                            <div class="float-end btn_div">
                                                <a href="javascript:void(0);" onclick="" data-bs-toggle="collapse"
                                                   data-bs-target="#collapse_{{$element->id}}" aria-expanded="false"
                                                   aria-controls="collapse_{{$element->id}}"
                                                   class="primary-btn small fix-gr-bg text-center button panel-title">
                                                    <i class="ti-settings settingBtn"></i>
                                                    <span class="collapge_arrow_normal"></span>
                                                </a>
                                                <a href="javascript:void(0);" onclick="elementDelete({{$element->id}})"
                                                   class="primary-btn small fix-gr-bg text-center button">
                                                    <i class="ti-close"></i>
                                                </a>
                                            </div>
                                        </div>
                                        @include('frontendmanage::headermenu.menu_edit_form')
                                    </div>

                                    <ol class="dd-list">
                                        @foreach($element->childs as $key => $element)
                                            @php
                                                $level=2;
                                            @endphp
                                            <li class="dd-item" data-id="{{$element->id}}">
                                                <div class="card accordion_card" id="accordion_{{$element->id}}">
                                                    <div class="card-header item_header" id="heading_{{$element->id}}">
                                                        <div class="dd-handle">
                                                            <div class="float-start">
                                                                {{$element->title}} ( {{$element->type}} )
                                                            </div>
                                                        </div>
                                                        <div class="float-end btn_div">
                                                            <a href="javascript:void(0);" onclick=""
                                                               data-bs-toggle="collapse"
                                                               data-bs-target="#collapse_{{$element->id}}"
                                                               aria-expanded="false"
                                                               aria-controls="collapse_{{$element->id}}"
                                                               class="primary-btn small fix-gr-bg text-center button panel-title ">
                                                                <i class="ti-settings settingBtn"></i>
                                                                <span
                                                                    class="collapge_arrow_normal"></span></a>
                                                            <a href="javascript:void(0);"
                                                               onclick="elementDelete({{$element->id}})"
                                                               class="primary-btn small fix-gr-bg text-center button"><i
                                                                    class="ti-close"></i></a>
                                                        </div>
                                                    </div>
                                                    @include('frontendmanage::headermenu.menu_edit_form')
                                                </div>
                                            </li>
                                            <ol class="dd-list">
                                                @foreach($element->childs as $key => $element)
                                                    @php
                                                        $level=3;
                                                    @endphp
                                                    <li class="dd-item" data-id="{{$element->id}}">
                                                        <div class="card accordion_card"
                                                             id="accordion_{{$element->id}}">
                                                            <div class="card-header item_header"
                                                                 id="heading_{{$element->id}}">
                                                                <div class="dd-handle">
                                                                    <div class="float-start">
                                                                        {{$element->title}} ( {{$element->type}} )
                                                                    </div>
                                                                </div>
                                                                <div class="float-end btn_div">
                                                                    <a href="javascript:void(0);" onclick=""
                                                                       data-bs-toggle="collapse"
                                                                       data-bs-target="#collapse_{{$element->id}}"
                                                                       aria-expanded="false"
                                                                       aria-controls="collapse_{{$element->id}}"
                                                                       class="primary-btn small fix-gr-bg text-center button panel-title">
                                                                        <i class="ti-settings settingBtn"></i>
                                                                        <span
                                                                            class="collapge_arrow_normal"></span></a>
                                                                    <a href="javascript:void(0);"
                                                                       onclick="elementDelete({{$element->id}})"
                                                                       class="primary-btn small fix-gr-bg text-center button"><i
                                                                            class="ti-close"></i></a>
                                                                </div>
                                                            </div>
                                                            @include('frontendmanage::headermenu.menu_edit_form')
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ol>
                                        @endforeach

                                    </ol>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body text-center">
            @lang('frontendmanage.Not Found Data')
        </div>
    </div>
@endif
