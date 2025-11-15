@extends('backend.master')
@php
    $table_name='coupons';
@endphp
@section('table')
    {{$table_name}}
@stop
@section('mainContent')
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row row-gap-24">
                <div class="col-xxl-3">

                <div class="white-box ">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="box_header common_table_header">
                                    <div class="main-title d-md-flex">
                                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px"> @if(!isset($edit))
                                                {{__('coupons.Add New Coupons') }}
                                            @else
                                                {{__('common.Update')}}
                                            @endif</h3>
                                        @if(isset($edit))
                                            @if (permissionCheck('coupons.single.store'))
                                                <a href="{{route('coupons.manage')}}"
                                                   class="primary-btn small fix-gr-bg"
                                                    title="{{__('coupons.Add')}}">+ </a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (isset($edit))
                            <form action="{{route('coupons.update')}}" method="POST" id="coupon-form" name="coupon-form"
                                  enctype="multipart/form-data">
                                @else
                                    @if (permissionCheck('coupons.single.store'))
                                        <form action="{{route('coupons.store') }}" method="POST" id="coupon-form"
                                              name="coupon-form" enctype="multipart/form-data">
                                            @endif
                                            @endif
                                            @csrf
                                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                            @if(isset($edit))
                                                <input type="hidden" name="id"
                                                       value="{{$edit->id}}">
                                            @endif
                                            <input type="hidden" name="category" value="2">
                                            <div class="row">


                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="category_id">{{ __('coupons.Select A Category') }}
                                                            <span
                                                                class="text-danger">*</span></label>
                                                        <select {{$errors->has('category_id') ? 'autofocus' : ''}}
                                                                class="primary_select mb-25  {{ @$errors->has('category_id') ? ' is-invalid' : '' }}"
                                                                name="category_id" id="category_id">
                                                            <option data-display="{{ __('coupons.Select A Category') }}"
                                                                    value="">{{ __('coupons.Select A Category') }}</option>
                                                            @if(@$categories->count()>0)
                                                                @foreach ($categories as $category)
                                                                    <option
                                                                        value="{{@$category->id}}" {{isset($edit)?($edit->type==$category->id?'selected':''):''}}>{{@$category->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>

                                                    </div>
                                                </div>


                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25" id="subCategoryDiv">
                                                        <label class="primary_input_label"
                                                               for="subcategory_id">{{ __('coupons.Select A Subcategory') }} </label>
                                                        <select
                                                            class="primary_select mb-25  {{ @$errors->has('subcategory_id') ? ' is-invalid' : '' }}"
                                                            name="subcategory_id" id="subcategory_id">
                                                            <option
                                                                data-display="{{ __('coupons.Select A Subcategory') }}"
                                                                value="">{{ __('coupons.Select A Subcategory') }}</option>
                                                            @if(isset($edit))
                                                                @foreach($edit->subcategories as $subcategory)
                                                                    <option
                                                                        value="{{$subcategory->id}}" {{$subcategory->id==$edit->subcategory_id ? "selected":"" }}>{{$subcategory->name}}</option>
                                                                @endforeach
                                                            @endif

                                                        </select>

                                                    </div>
                                                </div>


                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25" id="CourseDiv">
                                                        <label class="primary_input_label"
                                                               for="course_id">{{ __('coupons.Select A Course') }}
                                                            <span
                                                                class="text-danger">*</span>
                                                        </label>
                                                        <select
                                                            class="primary_select mb-25  {{ @$errors->has('course_id') ? ' is-invalid' : '' }}"
                                                            name="course_id" id="course_id">
                                                            <option
                                                                data-display="{{ __('coupons.Select A Course') }}"
                                                                value="">{{ __('coupons.Select A Course') }}</option>
                                                            @if(isset($edit))
                                                                @foreach($edit->courses as $course)
                                                                    <option
                                                                        value="{{$course->id}}" {{$course->id==$edit->course_id ? "selected":"" }}>{{$course->title}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>

                                                    </div>
                                                </div>


                                                {{-- input title  --}}
                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="title">{{ __('coupons.Coupon Title') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input name="title" id="title"
                                                               class="primary_input_field name {{ @$errors->has('title') ? ' is-invalid' : '' }}"
                                                               placeholder="{{ __('coupons.Coupon Title') }}"
                                                               type="text" {{$errors->has('title') ? 'autofocus' : ''}}
                                                               value="{{isset($edit)?$edit->title:old('title')}}">

                                                    </div>
                                                </div>

                                                {{-- input Code  --}}
                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="code">{{ __('coupons.Coupon Code') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input name="code" id="code"
                                                               {{$errors->has('code') ? 'autofocus' : ''}}
                                                               class="primary_input_field name {{ @$errors->has('code') ? ' is-invalid' : '' }}"
                                                               placeholder="{{ __('coupons.Coupon Code') }}" type="text"
                                                               value="{{isset($edit)?$edit->code:old('code')}}">

                                                    </div>
                                                </div>


                                                {{-- input min_purchase  --}}
                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="number">{{ __('coupons.Minimum Purchase') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input name="min_purchase"
                                                               {{$errors->has('min_purchase') ? 'autofocus' : ''}}
                                                               class="primary_input_field name {{ @$errors->has('min_purchase') ? ' is-invalid' : '' }}"
                                                               placeholder="{{ __('coupons.Minimum Purchase') }}"
                                                               type="number" id="number" min="0" step="any"
                                                               value="{{isset($edit)?$edit->min_purchase:old('min_purchase')}}">

                                                    </div>
                                                </div>

                                                {{-- input Amount  --}}
                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="number2">{{ __('coupons.Maximum Discount') }}
                                                            <span
                                                                class="text-danger">*</span></label>
                                                        <input name="max_discount"
                                                               {{$errors->has('max_discount') ? 'autofocus' : ''}}
                                                               class="primary_input_field name {{ @$errors->has('code') ? ' is-invalid' : '' }}"
                                                               placeholder="{{ __('coupons.Maximum Discount') }}"
                                                               type="number" id="number2" min="0" step="any"
                                                               value="{{isset($edit)?$edit->max_discount:old('max_discount')}}">

                                                    </div>
                                                </div>


                                                {{-- input Amount  --}}
                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="number3">{{ __('coupons.Amount') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input name="value" {{$errors->has('value') ? 'autofocus' : ''}}
                                                        class="primary_input_field name {{ @$errors->has('code') ? ' is-invalid' : '' }}"
                                                               placeholder="{{ __('coupons.Amount') }}" type="number"
                                                               id="number3" min="0" step="any"
                                                               value="{{isset($edit)?$edit->value:old('value')}}">

                                                    </div>
                                                </div>


                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="type">{{ __('coupons.Type') }}</label>
                                                        <select
                                                            class="primary_select mb-25  {{ @$errors->has('type') ? ' is-invalid' : '' }}"
                                                            name="type" id="type">
                                                            <option
                                                                value="1" {{isset($edit)?($edit->type==1?'selected':''):''}}>{{__('coupons.Fixed') }}</option>
                                                            <option
                                                                value="0" {{isset($edit)?($edit->type==0?'selected':''):''}}>{{__('coupons.Percentage') }}
                                                                (%)
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                {{-- Start Date Input --}}
                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label"
                                                               for="start_date">{{ __('coupons.Start Date') }}
                                                            <span
                                                                class="text-danger">*</span>
                                                        </label>
                                                        <div class="primary_datepicker_input">
                                                            <div class="g-0  input-right-icon">
                                                                <div class="col">
                                                                    <div class="">
                                                                        <input placeholder="{{__('common.Date')}}"
                                                                               class="primary_input_field primary-input date form-control  {{ @$errors->has('start_date') ? ' is-invalid' : '' }}"
                                                                               id="start_date" type="text"
                                                                               name="start_date"
                                                                               value="{{isset($edit)?  date('m/d/Y', strtotime(@$edit->start_date)) : date('m/d/Y')}}"
                                                                               autocomplete="off" required>
                                                                    </div>
                                                                </div>
                                                                <button class="" type="button">
                                                                    <i class="ti-calendar"></i>
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- End Date Input --}}
                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label"
                                                               for="end_date">{{ __('coupons.End Date') }}
                                                            <span
                                                                class="text-danger">*</span>
                                                        </label>
                                                        <div class="primary_datepicker_input">
                                                            <div class="g-0  input-right-icon">
                                                                <div class="col">
                                                                    <div class="">
                                                                        <input placeholder="{{__('common.Date')}}"
                                                                               class="primary_input_field primary-input date form-control  "
                                                                               id="end_date"
                                                                               type="text" name="end_date"
                                                                               value="{{isset($edit)?  date('m/d/Y', strtotime(@$edit->end_date)) : date('m/d/Y')}}"
                                                                               autocomplete="off" required>
                                                                    </div>
                                                                </div>
                                                                <button class="" type="button">
                                                                    <i class="ti-calendar" id="start-date-icon"></i>
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="number4">{{ __('coupons.Limit') }} <span
                                                                class="text-danger">*</span>
                                                            <small>({{ __('coupons.0 means unlimited') }}
                                                                )</small></label>
                                                        <input name="limit" required
                                                               {{ $errors->has('limit') ? ' autofocus' : '' }}
                                                               class="primary_input_field name {{ @$errors->has('limit') ? ' is-invalid' : '' }}"
                                                               placeholder="{{ __('coupons.Limit') }}" type="number"
                                                               id="number4" min="0" step="any"
                                                               value="{{isset($edit)?$edit->limit:old('limit',0)}}">

                                                    </div>
                                                </div>
                                                @php
                                                    $tooltip = "";
                                                      if (!permissionCheck('coupons.single.store')){
                                                         $tooltip = "You have no permission to add";
                                                      }
                                                @endphp
                                                <div class="col-lg-12 text-center">
                                                    <div class="d-flex justify-content-center pt_20">
                                                        <button type="submit" class="primary-btn semi_large fix-gr-bg"
                                                                data-bs-toggle="tooltip" title="{{$tooltip}}"
                                                        >
                                                            <i class="ti-check"></i>
                                                            @if(!isset($edit))
                                                                {{ __('common.Save') }}
                                                            @else
                                                                {{ __('common.Update') }}
                                                            @endif
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                    </div>
                </div>
                <div class="col-xxl-9  mt-5 mt-lg-0  ">
                    <div class="white-box">
                        <div class="main-title">
                            <h3 class="mb-20" id="page_title">{{__('coupons.Single Coupons List')}}</h3>
                        </div>

                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="">
                                    <table id="lms_table" class="table table-data">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('common.SL') }}</th>
                                            <th scope="col">{{ __('coupons.Category') }}</th>
                                            <th scope="col">{{ __('coupons.Course') }}</th>
                                            <th scope="col">{{ __('coupons.Title') }}</th>
                                            <th scope="col">{{ __('coupons.Code') }}</th>
                                            <th scope="col">{{ __('coupons.Amount') }}</th>
                                            <th scope="col">{{ __('coupons.Type') }}</th>
                                            <th scope="col">{{ __('coupons.Minimum Purchase') }}</th>
                                            <th scope="col">{{ __('coupons.Maximum Discount') }}</th>
                                            <th scope="col">{{ __('coupons.Start Date') }}</th>
                                            <th scope="col">{{ __('coupons.End Date') }}</th>
                                            <th scope="col">{{ __('common.Total') }} {{ __('common.Used') }}</th>
                                            <th scope="col">{{ __('coupons.Limit') }} ({{__('coupons.Per User')}})</th>
                                            <th scope="col">{{ __('common.Status') }}</th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($coupons as $key => $coupon)
                                            <tr>
                                                <th>{{ translatedNumber($key+1) }}</th>

                                                <td>
                                                    {{@$coupon->getCategory->name }}
                                                    @if($coupon->getSubCategory)
                                                    / {{$coupon->getSubCategory->name}}
                                                    @endif
                                                </td>
                                                <td>{{@$coupon->course->title }}</td>
                                                <td>{{@$coupon->title }}</td>
                                                <td>{{@$coupon->code }}</td>
                                                <td>{{ $coupon->type==1?getPriceFormat($coupon->value):($coupon->value.'%')  }}</td>
                                                <td>{{@$coupon->type==1?trans('coupons.Fixed'):trans('coupons.Percentage')}}</td>

                                                <td>{{ getPriceFormat($coupon->min_purchase) }}</td>
                                                <td>{{getPriceFormat($coupon->max_discount )}}</td>
                                                <td>{{ showDate($coupon->start_date) }}</td>
                                                <td>{{ showDate($coupon->end_date) }}</td>

                                                <td>{{ @translatedNumber($coupon->totalUsed->count()) }}</td>
                                                <td>{{ @translatedNumber($coupon->limit) }}</td>
                                                <td>

                                                    <x-backend.status :id="$coupon->id" :status="$coupon->status"
                                                                      :route="'coupons.single.status_update'"></x-backend.status>


                                                </td>
                                                <td>
                                                    <!-- shortby  -->
                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                id="dropdownMenu2{{@$coupon->id }}"
                                                                data-bs-toggle="dropdown"
                                                                aria-haspopup="true"
                                                                aria-expanded="false">
                                                            {{ __('common.Select') }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                             aria-labelledby="dropdownMenu2{{@$coupon->id }}">
                                                            @if (permissionCheck('coupons.single.edit'))
                                                                <a class="dropdown-item edit_brand"
                                                                   href="{{route('coupons.single')}}?id={{$coupon->id}}">{{__('common.Edit')}}</a>
                                                            @endif
                                                            @if (permissionCheck('coupons.single.delete'))
                                                                <a onclick="confirm_modal('{{route('coupons.delete', $coupon->id)}}');"
                                                                   class="dropdown-item edit_brand">{{__('common.Delete')}}</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <!-- shortby  -->
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
        </div>
    </section>
    <div id="edit_form">

    </div>
    <div id="view_details">

    </div>

    @include('backend.partials.delete_modal')
@endsection
@push('scripts')
    <script type="application/javascript">


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,11,12]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>
    <script src="{{url('Modules/Coupons/Resources/assets/js/app.js')}}{{assetVersion()}}"></script>
@endpush
