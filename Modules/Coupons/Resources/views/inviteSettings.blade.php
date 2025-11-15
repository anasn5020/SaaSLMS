@extends('backend.master')
@php
    $table_name = 'user_wise_coupon_settings';
@endphp
@section('table')
    {{ $table_name }}
@stop
@section('mainContent')
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                @if(isset($edit))
                    <div class="col-lg-3">
                        <div class="white-box ">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="box_header common_table_header">
                                        <div class="main-title d-md-flex">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px"> @if(isset($edit))
                                                    {{__('common.Update')}}
                                                @endif</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (permissionCheck('coupons.inviteSettings.store'))
                                <form action="{{route('coupons.inviteSettingStore') }}" method="POST" id="coupon-form"
                                      name="coupon-form" enctype="multipart/form-data">
                                    @endif
                                    @csrf
                                    <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                    @if(isset($edit))
                                        <input type="hidden" name="id" value="{{$edit->id}}">
                                    @endif
                                    <input type="hidden" name="category" value="2">
                                    <div class="row">


                                        {{-- input title  --}}
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="max_limit">{{ __('coupons.Maximum Limit') }} *</label>
                                                <input name="max_limit" id="max_limit"
                                                       {{ $errors->has('max_limit') ? ' autofocus' : '' }}
                                                       class="primary_input_field name {{ @$errors->has('max_limit') ? ' is-invalid' : '' }}"
                                                       placeholder="{{ __('coupons.Maximum Limit') }}" type="number"
                                                       step="any" min="0"
                                                       value="{{isset($edit)?$edit->max_limit:old('max_limit')}}">
                                                @if ($errors->has('max_limit'))
                                                    <span class="invalid-feedback d-block mb-10" role="alert">
                                            <strong>{{ @$errors->first('max_limit') }}</strong>
                                        </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- input title  --}}
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="amount">{{ __('coupons.Amount') }}
                                                    *</label>
                                                <input name="amount" id="amount"
                                                       {{ $errors->has('amount') ? ' autofocus' : '' }}
                                                       class="primary_input_field name {{ @$errors->has('amount') ? ' is-invalid' : '' }}"
                                                       placeholder="{{ __('coupons.Amount') }}" type="number" step="any"
                                                       min="0" value="{{isset($edit)?$edit->amount:old('amount')}}">
                                                @if ($errors->has('amount'))
                                                    <span class="invalid-feedback d-block mb-10" role="alert">
                                            <strong>{{ @$errors->first('amount') }}</strong>
                                        </span>
                                                @endif
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
                                                        value="0" {{isset($edit)?($edit->type==2?'selected':''):''}}>{{__('coupons.Percentage') }}</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="status">{{ __('coupons.Status') }}</label>
                                                <select
                                                    class="primary_select mb-25  {{ @$errors->has('status') ? ' is-invalid' : '' }}"
                                                    name="status" id="status">
                                                    <option value="1"
                                                            selected {{isset($edit)?($edit->status==1?'selected':''):''}}>{{__('common.Active') }}</option>
                                                    <option
                                                        value="0" {{isset($edit)?($edit->status==0?'selected':''):''}}>{{__('common.Inactive') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        @php
                                            $tooltip = "";
                                              if (permissionCheck('coupons.inviteSettings.store')){
                                                  $tooltip = "";
                                              }else{
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
                @endif
                <div class="@if(isset($edit))col-lg-9 @else col-lg-12  @endif">
                    <div class="white-box">
                        <div class="main-title">
                            <h3 class="mb-20" id="page_title">{{__('coupons.Referral Setting')}}</h3>
                        </div>

                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="">
                                    <table id="lms_table" class="table Crm_table_active3">
                                        <thead>
                                        <tr>

                                            <th scope="col"><span class="m-3">{{ __('common.SL') }}</span></th>
                                            {{--                                        <th scope="col">{{ __('role.Role') }}</th>--}}
                                            <th scope="col">{{ __('coupons.Amount') }}</th>
                                            <th scope="col">{{ __('coupons.Type') }}</th>
                                            <th scope="col">{{ __('coupons.Maximum Limit') }}</th>
{{--                                            <th scope="col">{{ __('common.Date') }}</th>--}}
                                            <th scope="col">{{ __('common.Status') }}</th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($inviteSettings as $key => $s)
                                            <tr>
                                                <th><span class="m-3">{{ translatedNumber($key+1) }}</span></th>
                                                {{--                                            <td>{{@$s->role->name }}</td>--}}
                                                <td>{{getPriceFormat(@$s->amount) }}</td>
                                                <td>{{@$s->type==1?trans('coupons.Fixed'):trans('coupons.Percentage') }}</td>
                                                <td>{{getPriceFormat($s->max_limit,false) }}</td>
{{--                                                <td>{{ showDate($s->created_at) }}</td>--}}
                                                <td>
                                                    <x-backend.status :id="$s->id" :status="$s->status"
                                                                      :route="'coupons.inviteSettings.status_update'">
                                                    </x-backend.status>
                                                </td>
                                                <td>
                                                    <!-- shortby  -->
                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                id="dropdownMenu2{{@$s->id }}" data-bs-toggle="dropdown"
                                                                aria-haspopup="true"
                                                                aria-expanded="false">
                                                            {{ __('common.Select') }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                             aria-labelledby="dropdownMenu2{{@$s->id }}">
                                                            @if (permissionCheck('coupons.inviteSettings.edit'))
                                                                <a class="dropdown-item edit_brand"
                                                                   href="{{route('coupons.inviteSettingEdit',$s->id)}}">{{__('common.Edit')}}</a>
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

@endsection
@push('scripts')
    <script type="application/javascript">


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>
@endpush
