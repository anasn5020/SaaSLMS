@extends('backend.master')
@php
    $table_name='front_pages'
@endphp
@section('table')
    {{$table_name}}
@stop
@section('mainContent')
    {{generateBreadcrumb()}}

    @if(permissionCheck('frontend.page.setting'))

        <section class="admin-visitor-area up_st_admin_visitor white-box d-none">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3>{{ __('setting.Setting') }}</h3>

                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="">
                            <div class="row">

                                <div class="col-lg-12">
                                    <!-- tab-content  -->
                                    <div class="tab-content " id="myTabContent">
                                        <!-- General -->
                                        <div class="tab-pane fade show active" id="Activation"
                                             role="tabpanel"
                                             aria-labelledby="Activation-tab">
                                            <div class="main-title mb-25">


                                                <form
                                                    action="{{ route('frontend.page.setting') }}"
                                                    method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="single_system_wrap">
                                                        <div class="row">
                                                            <div class="col-xl-4">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('page-builder.Page Builder') }} {{ __('setting.Type') }}</label>
                                                                    <div class="row">
                                                                        <div class="col-md-4 mb-25">
                                                                            <label
                                                                                class="primary_checkbox d-flex mr-12 "
                                                                                for="btn_type11">
                                                                                <input type="radio"
                                                                                       class="common-radio "
                                                                                       id="btn_type11"
                                                                                       name="pagebuilder_type"
                                                                                       {{Settings('pagebuilder_type')!='new'?'checked':''}}
                                                                                       value="old">
                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('common.Old')}}
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-md-4 mb-25">
                                                                            <label
                                                                                class="primary_checkbox d-flex mr-12 "
                                                                                for="btn_type12">
                                                                                <input type="radio"
                                                                                       class="common-radio"
                                                                                       id="btn_type12"
                                                                                       name="pagebuilder_type"
                                                                                       {{Settings('pagebuilder_type')=='new'?'checked':''}}
                                                                                       value="new">
                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('common.New')}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 text-center">
                                                        <div class="d-flex justify-content-center ">
                                                            <button type="submit"
                                                                    class="primary-btn   fix-gr-bg"
                                                                    id="save_button_parent"><i
                                                                    class="ti-check"></i>{{ __('common.Save') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>


                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @endif
    <section class="admin-visitor-area up_st_admin_visitor mt-4">
        <div class="container-fluid p-0">

            <div class="white-box">
                <div class="col-lg-12">
                    <span class="d-none" id="page_title">{{__('frontendmanage.Pages')}}</span>
                    @if(permissionCheck('frontend.page.create'))
                        <a href="{{ route('frontend.page.create') }}"
                           class="primary-btn small fix-gr-bg mb-4 w-fit float-end">
                            <span class="ti-plus me-2"></span>
                            {{__('common.Add')}} {{__('frontendmanage.Pages')}}
                        </a>
                    @endif
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>

                                    <tr>
                                        <th width="15%">{{__('common.SL')}}</th>
                                        <th width="15%">{{__('frontendmanage.Title')}}</th>
                                        <th width="15%">{{__('frontendmanage.Slug')}}</th>
                                        {{--                                    <th width="15%">{{__('common.Type')}}</th>--}}
                                        <th width="15%">{{__('common.Status')}}</th>
                                        <th width="15%">{{__('common.Action')}}</th>
                                    </tr>
                                    </thead>


                                    <tbody>
                                    @foreach($frontPages as $key=>$value)

                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td> {{$value->title}} {{$value->homepage==1?'('.trans('common.Current').' ' .trans('common.Homepage').')':''}} </td>
                                            <td> {{ Str::limit($value->slug,30) }}</td>
                                            <td>
                                                @if($value->is_static!='1')
                                                    <x-backend.status :id="$value->id" :status="$value->status"
                                                                      :route="'frontend.page.change-status'"></x-backend.status>
                                                @endif
                                            </td>
                                            <td>


                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle"
                                                            type="button"
                                                            id="dropdownMenu2" data-bs-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                        {{ __('common.Select') }}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenu2">
                                                        <a class="dropdown-item" target="_blank"
                                                           href="{{ $value->is_static!=1?url('pages/'.$value->slug):url($value->slug)}}"> {{__('common.View')}}</a>
                                                        @if(permissionCheck('frontend.page.edit'))
                                                            <a class="dropdown-item"
                                                               href="{{ route('frontend.page.edit',$value->id)}}"> {{__('common.Edit')}}</a>
                                                            @if(hasDynamicPage())
                                                                <a class="dropdown-item" target="_blank"
                                                                   href="{{ route('frontend.page.show',$value->id)}}"> {{__('common.Design')}}</a>
                                                            @endif
                                                        @endif
                                                        @if(permissionCheck('frontend.page.delete'))
                                                            @if($value->is_static!=1)
                                                                <a class="dropdown-item deleteBtn"
                                                                   data-bs-toggle="modal"
                                                                   data-url="{{ route('frontend.page.destroy',$value->id)}}"
                                                                   data-bs-target="#deleteItem">{{__('common.Delete')}}</a>
                                                            @endif
                                                        @endif

                                                        @if(permissionCheck('frontend.page.changeHomepage'))
                                                            @if($value->homepage!=1)
                                                                <a href="{{route('frontend.page.changeHomepage',$value->id)}}"
                                                                   class="dropdown-item ">{{__('frontendmanage.Make It Homepage')}}</a>
                                                            @endif
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
    </section>
    <div class="modal fade admin-query" id="deleteItem">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.Delete')}} {{__('frontendmanage.Page')}}</h4>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal" style="color: #000">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h4>{{__('footer.Are you sure')}}?</h4>
                    </div>
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg"
                                data-bs-dismiss="modal">{{__('footer.Cancel')}}
                        </button>
                        <form action=""
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="primary-btn fix-gr-bg"
                                   value="Delete"/>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script>
        $(document).on("click", ".deleteBtn", function (e) {
            e.preventDefault();
            let url = $(this).data('url');
            console.log(url);
            $('#deleteItem').find('form').attr('action', url);
        });

    </script>


    <script type="application/javascript">


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>
@endpush
