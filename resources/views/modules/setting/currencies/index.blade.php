@extends('backend.master')
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor white-box">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3>{{ __('setting.Currency') }}</h3>

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
                                            <form action="{{ route('currencies.update_settings') }}" method="POST"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="single_system_wrap">
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{ __('setting.System Default Currency') }}</label>
                                                                <select class="primary_select mb-25" name="currency_id"
                                                                        id="currency_id">
                                                                    @foreach ($select_currencies as $key => $currency)
                                                                        <option value="{{ $currency->id }}"
                                                                                @if (Settings('currency_id') == $currency->id) selected @endif>
                                                                            {{ $currency->name }}
                                                                            - {{ $currency->code }}
                                                                            ({{ $currency->symbol }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="currency_show">{{ __('setting.Currency Show At') }}</label>
                                                                <select class="primary_select mb-25"
                                                                        name="currency_show"
                                                                        id="currency_show">

                                                                    <option value="1"
                                                                            @if (Settings('currency_show') == 1) selected @endif>
                                                                        {{ __('setting.Left') }}
                                                                    </option>

                                                                    <option value="2"
                                                                            @if (Settings('currency_show') == 2) selected @endif>
                                                                        {{ __('setting.Left With Space') }}
                                                                    </option>

                                                                    <option value="3"
                                                                            @if (Settings('currency_show') == 3) selected @endif>
                                                                        {{ __('setting.Right') }}
                                                                    </option>

                                                                    <option value="4"
                                                                            @if (Settings('currency_show') == 4) selected @endif>
                                                                        {{ __('setting.Right With Space') }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="currency_seperator">{{ __('setting.Currency Separator') }}</label>
                                                                <select class="primary_select mb-25"
                                                                        name="currency_seperator"
                                                                        id="currency_seperator">

                                                                    <option value="1"
                                                                            @if (Settings('currency_seperator') == 1) selected @endif>
                                                                        {{ __('setting.Dot') }}
                                                                    </option>

                                                                    <option value="2"
                                                                            @if (Settings('currency_seperator') == 2) selected @endif>
                                                                        {{ __('setting.Comma') }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="currency_decimal">{{ __('setting.Currency Decimal') }}
                                                                </label>
                                                                <input class="primary_input_field" placeholder="-"
                                                                       type="number" id="currency_decimal"
                                                                       name="currency_decimal"
                                                                       max="5"
                                                                       value="{{ Settings('currency_decimal') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="currency_api_cache_time">{{ __('setting.API Cache Time (In minutes)') }}
                                                                </label>
                                                                <input class="primary_input_field" placeholder="-"
                                                                       type="number" id="currency_api_cache_time"
                                                                       name="currency_api_cache_time"
                                                                       min="0"
                                                                       step="any"
                                                                       value="{{ Settings('currency_api_cache_time')?Settings('currency_api_cache_time'):1440 }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="hide_multicurrency">{{ __('setting.Multi Currency') }}
                                                                </label>
                                                                <select class="primary_select mb-25"
                                                                        name="hide_multicurrency"
                                                                        id="hide_multicurrency">
                                                                    <option value="1"
                                                                            @if (Settings('hide_multicurrency') == 1) selected @endif>
                                                                        {{ __('common.Show') }}
                                                                    </option>

                                                                    <option value="0"
                                                                            @if (Settings('hide_multicurrency') == 0) selected @endif>
                                                                        {{ __('common.Hide') }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="currency_conversion">{{ __('setting.Currency Conversion') }}</label>
                                                                <select class="primary_select mb-25"
                                                                        name="currency_conversion"
                                                                        id="currency_conversion">
                                                                    <option value="Manual"
                                                                            @if (Settings('currency_conversion') == 'Manual') selected @endif>
                                                                        {{__('setting.Manual')}}
                                                                    </option>
                                                                    <option value="Fixer"
                                                                            @if (Settings('currency_conversion') == 'Fixer') selected @endif>
                                                                        {{__('setting.Fixer')}}
                                                                    </option>
                                                                    <option value="Exchangerate"
                                                                            @if (Settings('currency_conversion') == 'Exchangerate') selected @endif>
                                                                        Exchangerate
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 text-center">
                                                    <div class="d-flex justify-content-center pt_20">
                                                        <button type="submit" class="primary-btn semi_large2  fix-gr-bg"
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


    <section class="admin-visitor-area up_st_admin_visitor mt-4">
        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="row">
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px"> {{ __('setting.Currency List') }}</h3>
                                @if (permissionCheck('currency.store'))
                                    <ul class="d-flex">
                                        <li><a class="primary-btn radius_30px   fix-gr-bg "
                                               href="#" onclick="open_add_currency_modal()"><i
                                                    class="ti-plus"></i>{{ __('common.Add New') }}
                                                {{ __('common.Currency') }}
                                            </a>
                                        </li>
                                    </ul>
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="">
                                    <table id="lms_table" class="table Crm_table_active3">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('common.SL') }}</th>
                                            <th scope="col">{{ __('common.Name') }}</th>
                                            <th scope="col">{{ __('setting.Code') }}</th>
                                            <th scope="col">{{ __('setting.Symbol') }}</th>
                                            <th scope="col">{{ __('setting.Status') }}</th>
                                            <th scope="col">{{ __('setting.Conversion Rate') }}
                                                {{translatedNumber(1)}} {{$select_currencies->where('id', Settings('currency_id'))?->first()?->code}}
                                                = ?
                                            </th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $table_name='currencies';
                                        @endphp
                                        @section('table')
                                            {{$table_name}}
                                        @endsection
                                        @foreach ($currencies as $key => $currency)
                                            <tr>
                                                <th>{{ translatedNumber($key + 1) }}</th>
                                                <td>{{ $currency->name }}</td>
                                                <td>{{ $currency->code }}</td>
                                                <td>{{ $currency->symbol }}</td>
                                                <td>
                                                    <x-backend.status :id="$currency->id"
                                                                      :status="$currency->status"
                                                                      :route="'currencies.status'"></x-backend.status>
                                                </td>
                                                <td>{{ translatedNumber($currency->conversion_rate) }} {{ $currency->symbol }}</td>
                                                <td>
                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                id="dropdownMenu2" data-bs-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                            {{ __('common.Select') }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                             aria-labelledby="dropdownMenu2">
                                                            @if (permissionCheck('currencies.edit_modal'))
                                                                <a href="#"
                                                                   class="dropdown-item edit_brand"
                                                                   onclick="edit_currency_modal({{ $currency->id }})">{{ __('common.Edit') }}</a>
                                                            @endif
                                                            @if (permissionCheck('currencies.destroy'))
                                                                <a onclick="confirm_modal('{{ route('currencies.destroy', $currency->id) }}');"
                                                                   class="dropdown-item edit_brand">{{ __('common.Delete') }}</a>
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
        </div>
    </section>
    <div class="modal fade admin-query" id="Item_Edit">

    </div>
    <div class="modal fade admin-query" id="currency_add">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.Add New') }} {{ __('common.Currency') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('currencies.store') }}" method="POST" id="currency_addForm">
                        @csrf
                        <div class="row">

                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Name') }} <strong
                                            class="text-danger">*</strong></label>
                                    <input name="name" class="primary_input_field name" placeholder="Dollar"
                                           type="text" required>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('setting.Code') }}
                                        <strong class="text-danger">*</strong></label>
                                    <input name="code" class="primary_input_field name" placeholder="USD"
                                           type="text" required>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('setting.Symbol') }}
                                        <strong class="text-danger">*</strong></label>
                                    <input name="symbol" class="primary_input_field name" placeholder="$"
                                           type="text" required>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{ __('setting.Conversion Rate') }}
                                        <strong class="text-danger">*</strong></label>
                                    <input name="conversion_rate" class="primary_input_field name" placeholder="1"
                                           type="text" value="1">
                                </div>
                            </div>

                            <div class="col-lg-12 text-center">
                                <div class="d-flex justify-content-center pt_20">
                                    <button type="submit" class="primary-btn semi_large2  fix-gr-bg"
                                            id="save_button_parent"><i class="ti-check"></i>{{ __('common.Save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <input type="hidden" name="currency_edit" class="currency_edit" value="{{ route('currencies.edit_modal') }}">

    @include('backend.partials.delete_modal')
@endsection
@push('scripts')
    <script src="{{ asset('public/backend/js/currency.js') }}"></script>
@endpush
