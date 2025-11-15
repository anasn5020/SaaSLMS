@extends('backend.master')
@section('mainContent')
    @php
        $table_name='packages';
    @endphp
    @section('table')
        {{$table_name}}
    @stop

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-30">@if(isset($packge))
                                        {{__('common.Edit')}}
                                    @else
                                        {{__('common.Add')}}
                                    @endif
                                    {{__('package.Package')}}
                                </h3>
                            </div>
                            @if(isset($packge))
                                <form class="form-horizontal" method="POST" action="{{ route('updatePackage') }}" enctype="multipart/form-data">
                                    @csrf
                                    @else
                                        @if (permissionCheck('package_add'))
                                            <form class="form-horizontal" method="POST" action="{{ route('savePackage') }}" enctype="multipart/form-data">
                                                @csrf
                                                @endif
                                                @endif

                                                <div class="white-box">
                                <div class="add-visitor">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            @if(session()->has('message-success'))
                                                <div class="alert alert-success">
                                                    {{ session()->get('message-success') }}
                                                </div>
                                            @elseif(session()->has('message-danger'))
                                                <div class="alert alert-danger">
                                                    {{ session()->get('message-danger') }}
                                                </div>
                                            @endif
                                            <div class="input-effect">
                                                <label class="primary_input_label mt-1">{{__('common.Name')}} <span
                                                        class="required_mark">*</span></label>
                                                <input
                                                    class="primary_input_field{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                    type="text" name="name" autocomplete="off"
                                                    value="{{isset($packge)? $packge->name:''}}">
                                                <input type="hidden" name="id"
                                                       value="{{isset($packge)? $packge->id: ''}}">
                                                <span class="focus-border"></span>
                                                @if ($errors->has('name'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                            <div class="input-effect mt-20">
                                                <label class="primary_input_label mt-1">{{ __('package.Package Type') }}<span
                                                        class="required_mark">*</span></label>
                                                <select class="primary_select" name="type" onchange="changeType(this)">
                                                    <option data-display="Select Course"
                                                            value="">{{__('common.Select')}} {{__('quiz.Category')}} </option>
                                                    <option
                                                        value="1" {{isset($packge)? ($packge->type==1?'selected':''): ''}}>
                                                        Subscription
                                                    </option>
                                                    <option
                                                        value="0" {{isset($packge)? ($packge->type==0?'selected':''): ''}}>
                                                        Combo Packages
                                                    </option>
                                                </select>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('type'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('type') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                            @php
                                                if(isset($packge) && $packge->type==1){
                                                    $validity='block';
                                                    $course='none';
                                                }else{
                                                     $validity='none';
                                                    $course='block';
                                                }
                                            @endphp
                                            <div class="input-effect mt-20" style="display: {{$validity}}}"
                                                 id="show_validity">
                                                <label class="primary_input_label mt-1">{{ __('package.Package Validity') }}<span
                                                        class="required_mark">*</span></label>
                                                <select class="primary_select" name="validity">
                                                    <option
                                                        data-display="{{__('common.Select')}} {{__('package.Validity')}}"
                                                        value="">{{__('common.Select')}} {{__('package.Validity')}} </option>
                                                    <option
                                                        value="monthly" {{isset($packge)? ($packge->validity=='monthly'?'selected':''): ''}}>
                                                        Monthly Subscribe
                                                    </option>
                                                    <option
                                                        value="yearly" {{isset($packge)? ($packge->validity=='yearly'?'selected':''): ''}}>
                                                        Yearly Subscribe
                                                    </option>
                                                </select>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('validity'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('validity') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                            <div class="input-effect mt-20" style="display: {{$course}}"
                                                 id="show_course">
                                                <label class="primary_input_label mt-1">{{__('courses.Courses')}}<span
                                                        class="required_mark">*</span></label>

                                                <select multiple id="selectStaffss" name="courses" style="width:300px">
                                                    @foreach ($courses as $course)
                                                        <option
                                                            value="{{$course->id}}" {{isset($packge)? ($packge->courses==$course->id?'selected':''): ''}}>{{$course->title}}</option>
                                                    @endforeach

                                                </select>
                                                <div class="">
                                                    <input type="checkbox" id="checkbox" class="common-checkbox">
                                                    <label for="checkbox" class="mt-3">Select All </label>
                                                </div>
                                                @if ($errors->has('courses'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('courses') }}</strong>
                                            </span>
                                                @endif
                                            </div>

                                            <div class="input-effect mt-20">
                                                <label class="primary_input_label mt-1">{{__('courses.Price')}} <span
                                                        class="required_mark">*</span></label>
                                                <input
                                                    class="primary_input_field{{ $errors->has('price') ? ' is-invalid' : '' }}"
                                                    type="text" name="price" autocomplete="off"
                                                    value="{{isset($packge)? $packge->price:''}}">
                                                <span class="focus-border"></span>
                                                @if ($errors->has('price'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('price') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                            <div class="input-effect mt-20">
                                                <label class="primary_input_label mt-1">{{__('package.Button Label')}} <span
                                                        class="required_mark">*</span></label>
                                                <input
                                                    class="primary_input_field{{ $errors->has('label') ? ' is-invalid' : '' }}"
                                                    type="text" name="label" autocomplete="off"
                                                    value="{{isset($packge)? $packge->label:''}}">
                                                <span class="focus-border"></span>
                                                @if ($errors->has('label'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('label') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                            <div class="input-effect mt-20">
                                                <label class="primary_input_label mt-1">{{ __('common.Active Status') }}<span
                                                        class="required_mark">*</span></label>
                                                <select class="primary_select" name="status">
                                                    <option
                                                        data-display="{{__('common.Select')}} {{__('common.Status')}}"
                                                        value="">{{__('common.Select')}} {{__('common.Status')}} </option>
                                                    <option
                                                        value="1" {{isset($packge)? ($packge->status==1?'selected':''): ''}}>
                                                        Active
                                                    </option>
                                                    <option
                                                        value="0" {{isset($packge)? ($packge->status==0?'selected':''): ''}}>
                                                        Deactive
                                                    </option>
                                                </select>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('status'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('status') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                            <div class="input-effect mt-20">
                                                <label class="primary_input_label mt-1">{{__('package.Description')}} <span
                                                        class="required_mark">*</span></label>
                                                <textarea
                                                    class="primary_input_field name{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                                    cols="0" rows="4"
                                                    name="description">{{isset($packge)? $packge->description: old('description')}}</textarea>
                                                <span class="focus-border textarea"></span>
                                                @if($errors->has('description'))
                                                    <span
                                                        class="error text-danger"><strong>{{ $errors->first('description') }}</strong></span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                    @php
                                        $tooltip = "";
                                        if(permissionCheck('package_add')){
                                              $tooltip = "";
                                          }else{
                                              $tooltip = "You have no permission to add";
                                          }
                                    @endphp
                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            <button type="submit" class="primary-btn fix-gr-bg" data-bs-toggle="tooltip"
                                                    title="{{@$tooltip}}">
                                                <i class="ti-check"></i>
                                                @if(isset($packge))
                                                    {{__('common.Update')}}
                                                @else
                                                    {{__('common.Save')}}
                                                @endif
                                                {{__('package.Package')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-4 g-0 ">
                            <div class="main-title">
                                <h3 class="mb-20">{{__('package.Package List')}}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.Name') }}</th>
                                        <th scope="col">{{ __('package.Package Type') }}</th>
                                        <th scope="col">{{ __('courses.Price') }}</th>
                                        <th scope="col">{{ __('package.Button') }}</th>
                                        <th scope="col">{{ __('common.Status') }}</th>
                                        <th scope="col">{{ __('common.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($packges as $key => $packge)
                                        <tr>
                                            <td>{{@$packge->name }}</td>
                                            <td>

                                                @if (@$packge->type==0)
                                                    {{-- {{@$packge->courses->count()}} --}}
                                                @else
                                                    {{@$packge->typeName }} {{@$packge->validity }}
                                                @endif
                                            </td>
                                            <td>
                                                {{getPriceFormat($packge->price)}}
                                            </td>
                                            <td>{{@$packge->label }}</td>
                                            <td>
                                                <label class="switch_toggle">
                                                    <input type="checkbox"
                                                           class="@if (permissionCheck('package_change_status')) status_enable_disable @endif "
                                                           @if (@$packge->status == 1) checked
                                                           @endif value="{{@$packge->id }}">
                                                    <i class="slider round"></i>
                                                </label>
                                            </td>
                                            <td>
                                                <!-- shortby  -->
                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-bs-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        {{ __('common.Select') }}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenu2">
                                                        @if (permissionCheck('package_edit'))
                                                            <a class="dropdown-item edit_brand"
                                                               href="{{route('editPackages',$packge->id)}}">{{__('common.Edit')}}</a>
                                                        @endif

                                                        @if (permissionCheck('package_delete'))
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                               data-bs-target="#deleteQuestionGroupModal{{$packge->id}}"
                                                               href="#">{{__('common.Delete')}}</a>
                                                        @endif

                                                    </div>
                                                </div>
                                                <!-- shortby  -->
                                            </td>
                                        </tr>


                                        <div class="modal fade admin-query"
                                             id="deleteQuestionGroupModal{{$packge->id}}">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">{{__('common.Delete')}} {{__('package.Package')}}</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                            <i
                                                                class="ti-close "></i></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <h4> {{__('common.Are you sure to delete ?')}}</h4>
                                                        </div>

                                                        <div class="mt-40 d-flex justify-content-between">
                                                            <button type="button" class="primary-btn tr-bg"
                                                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                                                            <form method="GET" action="{{ route('destroyPackage', $packge->id) }}" enctype="multipart/form-data">
                                                                @csrf
                                                                <button class="primary-btn fix-gr-bg"
                                                                    type="submit">{{__('common.Delete')}}</button>
                                                            </form>>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
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
    <div id="edit_form">

    </div>
    <div id="view_details">

    </div>

    {{-- @include('coupons::create') --}}
    @include('backend.partials.delete_modal')
@endsection
@push('scripts')
    <script src="{{asset('/')}}/Modules/CourseSetting/Resources/assets/js/course.js"></script>
@endpush
