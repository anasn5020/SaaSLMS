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
                                            @if (permissionCheck('coupons.personalized.store'))
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
                                    @if (permissionCheck('coupons.personalized.store'))
                                        <form action="{{route('coupons.store') }}" method="POST" id="coupon-form"
                                              name="coupon-form" enctype="multipart/form-data">
                                            @endif
                                            @endif
                                            @csrf
                                            @if(isset($edit))
                                                <input type="hidden" name="id"
                                                       value="{{$edit->id}}">
                                            @endif
                                            <input type="hidden" name="category" value="3">
                                            <div class="row">

                                                {{-- input title  --}}
                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="title">{{ __('coupons.Coupon Title') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input name="title" id="title"
                                                               {{ $errors->has('title') ? ' autofocus' : '' }}
                                                               class="primary_input_field name {{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                               placeholder="{{ __('coupons.Coupon Title') }}"
                                                               type="text"
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
                                                               {{ $errors->has('code') ? ' autofocus' : '' }}
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
                                                               {{ $errors->has('min_purchase') ? ' autofocus' : '' }}
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
                                                               {{ $errors->has('max_discount') ? ' autofocus' : '' }}
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
                                                        <input name="value"
                                                               {{ $errors->has('value') ? ' autofocus' : '' }}
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


                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="coupon_user_id">{{ __('coupons.Coupon For') }}</label>
                                                        <select
                                                            class="primary_select mb-25  {{ @$errors->has('coupon_user_id') ? ' is-invalid' : '' }}"
                                                            name="coupon_user_id" id="coupon_user_id">
                                                            @forelse($users as $user)
                                                                <option
                                                                    value="{{$user->id}}" {{isset($edit)?($edit->coupon_user_id==$user->id?'selected':''):''}}>{{$user->name}}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Start Date Input --}}
                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label"
                                                               for="start_date">{{ __('coupons.Start Date') }} <span
                                                                class="text-danger">*</span></label>
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
                                                               for="end_date">{{ __('coupons.End Date') }} <span
                                                                class="text-danger">*</span></label>
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
                                                      if (!permissionCheck('coupons.personalized.store')){
                                                         $tooltip = "You have no permission to add";
                                                      }
                                                @endphp
                                                <div class="col-lg-12 text-center">
                                                    <div class="d-flex justify-content-center pt_20">
                                                        <button type="submit" class="primary-btn semi_large fix-gr-bg"
                                                                data-bs-toggle="tooltip" title="{{$tooltip}}"
                                                                id="save_button_parent">
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
                            <h3 class="mb-20" id="page_title">{{__('coupons.Personalized Coupons List')}}</h3>
                        </div>

                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="">
                                    <table id="lms_table" class="table table-data">
                                        <thead>
                                        <tr>
                                            <th scope="col"><span class="m-3">{{ __('common.SL') }}</span></th>
                                            <th scope="col">{{ __('coupons.Title') }}</th>
                                            <th scope="col">{{ __('coupons.Code') }}</th>
                                            <th scope="col">{{ __('coupons.Amount') }}</th>
                                            <th scope="col">{{ __('coupons.Type') }}</th>
                                            <th scope="col">{{ __('coupons.Minimum Purchase') }}</th>
                                            <th scope="col">{{ __('coupons.Maximum Discount') }}</th>
                                            <th scope="col">{{ __('coupons.Start Date') }}</th>
                                            <th scope="col">{{ __('coupons.End Date') }}</th>
                                            <th scope="col">{{ __('coupons.Coupon For') }}</th>
                                            <th scope="col">{{ __('common.Total') }} {{ __('common.Used') }}</th>
                                            <th scope="col">{{ __('coupons.Limit') }} ({{__('coupons.Per User')}})</th>
                                            <th scope="col">{{ __('common.Status') }}</th>

                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($coupons as $key => $coupon)
                                            <tr>
                                                <th><span class="m-3">{{ translatedNumber($key+1) }}</span></th>
                                                <td>{{@$coupon->title }}</td>
                                                <td>{{@$coupon->code }}</td>
                                                <td>{{ $coupon->type==1?getPriceFormat($coupon->value):($coupon->value.'%')  }}</td>
                                                <td>{{@$coupon->type==1?trans('coupons.Fixed'):trans('coupons.Percentage')}}</td>

                                                <td>{{getPriceFormat($coupon->min_purchase) }}</td>
                                                <td>{{getPriceFormat($coupon->max_discount) }}</td>
                                                <td>{{ showDate($coupon->start_date) }}</td>
                                                <td>{{ showDate($coupon->end_date) }}</td>
                                                <td>{{@$coupon->coupon_user->name }}</td>


                                                <td>{{ @translatedNumber($coupon->totalUsed->count()) }}</td>
                                                <td>{{ @translatedNumber($coupon->limit) }}</td>
                                                <td>

                                                    <x-backend.status :id="$coupon->id" :status="$coupon->status"
                                                                      :route="'coupons.personalized.status_update'"></x-backend.status>
                                                </td>
                                                <td>

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
                                                            @if (permissionCheck('coupons.personalized.edit'))
                                                                <a class="dropdown-item edit_brand"
                                                                   href="{{route('coupons.personalized')}}?id={{$coupon->id}}">{{__('common.Edit')}}</a>
                                                            @endif
                                                            @if (permissionCheck('coupons.personalized.delete'))
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
    <input type="hidden" name="status_route" class="status_route" value="{{ route('coupons.status_update') }}">

    @include('backend.partials.delete_modal')
@endsection
@push('scripts')
    <script type="application/javascript">


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,11]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>@endpush
