@extends('backend.master')
@php
    $table_name='badges';
@endphp
@section('table')
    {{$table_name}}
@endsection
@section('mainContent')
    <style>
        .badgePage .addWidget.small {
            position: initial;
            width: fit-content;
        }

        .student-details .nav-tabs .nav-link {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            line-clamp: 1;
            -webkit-box-orient: vertical;
            line-height: 25px !important;
        }
    </style>
    @php
        if(session('type')){
            $typeTab = session('type');
        }else{
            $typeTab = 'activity';
        }
    @endphp
    {!! generateBreadcrumb() !!}
    <section class="mb-40 student-details up_st_admin_visitor badge-section white-box">
        <div class="container-fluid p-0">
            <div class="row ">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs no-bottom-border justify-content-start mt-sm-md-20 ms-0 mb-4"
                        role="tablist">

                        @foreach($types as $key=>$type)
                            <li class="nav-item">
                                <a class="nav-link {{ $typeTab == $key ? 'active' : '' }} show" href="#{{ $key }}Badge"
                                   role="tab" onclick="changeSection('{{ $key }}')" data-bs-toggle="tab"
                                   id="{{ $key }}" aria-selected="true">
                                    {{ $type }}

                                </a>
                            </li>
                        @endforeach


                    </ul>
                    <div class="col-lg-12" id="lms_table">

                        <!-- Tab panes -->
                        <div class="tab-content mt-0">
                            @foreach ($types as $key => $type)
                                <div role="tabpanel"
                                     class="tab-pane {{ $typeTab == $key ? 'active show' : '' }} fade badgePage"
                                     id="{{ $key }}Badge">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            @if (permissionCheck('gamification.badges.store'))
                                                <a href="#" data-type="{{ $key }}"
                                                   class="primary-btn addWidget small fix-gr-bg mb-4 float-end  mt-3 add_btn_with_page_length"><i
                                                        class="ti-plus"></i> {{ __('common.Add New') }}</a>

                                            @endif
                                            <div class="QA_section QA_section_heading_custom check_box_table">
                                                <div class="QA_table ">
                                                    <!-- table-responsive -->
                                                    <div class="pt-0">
                                                        <table class="table Crm_table_active3">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">{{ __('common.SL') }}</th>
                                                                <th scope="col">{{ __('common.Title') }}</th>
                                                                <th scope="col">{{ __('common.Condition') }}</th>
                                                                <th scope="col">{{ __('common.Image') }}</th>
                                                                <th scope="col">{{ __('common.Status') }}</th>
                                                                <th scope="col">{{ __('common.Action') }}</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php
                                                                $i =0;
                                                            @endphp
                                                            @foreach($badges->where('type',$key) as $index=>$badge)
                                                                <tr>
                                                                    <td>{{translatedNumber(++$i)}}</td>
                                                                    <td>{{$badge->title}}</td>
                                                                    <td>{{translatedNumber($badge->point)}}</td>
                                                                    <td>
                                                                        <div>
                                                                            @if($badge->image)
                                                                                <img style="width: 70px !important;"
                                                                                     src="{{url($badge->image)}}" alt=""
                                                                                     class="img img-responsive m-2">
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                    <td>

                                                                        <x-backend.status :id="$badge->id"
                                                                                          :status="$badge->status"
                                                                                          :route="'gamification.badges.status'"></x-backend.status>
                                                                    </td>


                                                                    <td>
                                                                        <div class="dropdown CRM_dropdown">
                                                                            <button
                                                                                class="btn btn-secondary dropdown-toggle"
                                                                                type="button"
                                                                                id="dropdownMenu1{{@$badge->id}}"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                {{ __('common.Select') }}
                                                                            </button>
                                                                            <div
                                                                                class="dropdown-menu dropdown-menu-right"
                                                                                aria-labelledby="dropdownMenu1{{@$badge->id}}">
                                                                                @if (permissionCheck('gamification.badges.update'))
                                                                                    <a class="dropdown-item btn-modal"
                                                                                       type="button"
                                                                                       data-container="#commonModal"
                                                                                       href="{{route('gamification.badges.edit', $badge->id)}}"> {{__('common.Edit')}}</a>
                                                                                @endif
                                                                                @if (permissionCheck('gamification.badges.delete'))
                                                                                    <a onclick="showDeleteModal('{{route('gamification.badges.delete', $badge->id)}}');"
                                                                                       class="dropdown-item  ">{{__('common.Delete')}}</a>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('setting::badges.components.widget_create')
        {{--        @include('setting::badges.components.widget_edit')--}}
        @include('setting::badges.components.delete')
    </section>

    @if ($errors->any())
        <script>
            @if (Session::has('request_type'))
            @if (Session::get('request_type') == 'store')
            $('#CreateModal').modal('show');
            @endif
            @if (Session::get('request_type') == 'edit')
            $('#editModal').modal('show');
            @endif
            @endif
        </script>
    @endif

@endsection

@include('setting::badges.components.scripts')
