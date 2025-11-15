@extends('backend.master')
@push('styles')
    <style>
        .image_preview {
            height: 100px;
            width: 100px;
        }
    </style>

@endpush

@section('mainContent')

    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">


        <div class="white_box mb_30  student-details header-menu">
            <div class="white_box_tittle list_header">
                <h4> {{ isset($gateway)?trans('setting.Edit Gateway'):trans('setting.Add New Gateway') }}</h4>
            </div>
            <div class="col-lg-12">

                <form
                    action="{{isset($gateway)?route('admin.sms_settings.update',$gateway->id):route('admin.sms_settings.store')}}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @isset($gateway)
                        @method('PUT')
                    @endisset

                    <div class="row">
                        <div class="col-xl-4">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="gateway_name">{{ __('setting.Gateway Name') }}
                                    <strong
                                        class="text-danger">*</strong></label>
                                <input name="gateway_name" class="primary_input_field"
                                       value="{{ isset($gateway)?$gateway->gateway_name:old('gateway_name') }}"
                                       placeholder="-" type="text" id="gateway_name">
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="gateway_url">{{ __('setting.Gateway URL') }}
                                    <strong
                                        class="text-danger">*</strong></label>
                                <input name="gateway_url" class="primary_input_field"
                                       value="{{ isset($gateway)?$gateway->gateway_url:old('gateway_url') }}"
                                       placeholder="-" type="text" id="gateway_url">
                            </div>
                        </div>

                        @php
                            $request_methods = ['GET','POST'];
                        @endphp

                        <div class="col-xl-4">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="request_method">{{ __('setting.Request Method') }}
                                    <strong
                                        class="text-danger">*</strong></label>
                                <select class="primary_select mb-25" name="request_method" id="request_method">
                                    <option value="">{{__('common.select_one')}}</option>
                                    @foreach($request_methods as $request_method)
                                        <option
                                            @if(isset($gateway) && $gateway->request_method == $request_method)
                                                selected
                                            @else
                                                @if(old('request_method') == $request_method) selected @endif
                                            @endif
                                            value="{{$request_method}}">{{$request_method}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="send_to_parameter_name">{{ __('setting.Send to Parameter') }} <strong
                                        class="text-danger">*</strong></label>
                                <input name="send_to_parameter_name" class="primary_input_field"
                                       value="{{ isset($gateway)?$gateway->send_to_parameter_name:old('send_to_parameter_name') }}"
                                       placeholder="-" type="text" id="send_to_parameter_name">
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="message_to_parameter_name">{{ __('setting.Message to Parameter') }} <strong
                                        class="text-danger">*</strong></label>
                                <input name="message_to_parameter_name" class="primary_input_field"
                                       value="{{ isset($gateway)?$gateway->message_to_parameter_name:old('message_to_parameter_name') }}"
                                       placeholder="-" type="text" id="message_to_parameter_name">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="primary_input mb-25">
                                <div class="row mb-25">
                                    <div class="col-md-12">
                                        <label class="primary_input_label"
                                               for=""> {{ __('setting.Set Authentication') }} <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mb-25">
                                        <label class="primary_checkbox d-flex mr-12 w-100">
                                            <input type="radio" id="type1"
                                                   name="set_auth"
                                                   value="header"
                                            @if(isset($gateway))
                                                {{ $gateway->set_auth == 'header' ?'checked':""}}
                                                @endif

                                            >
                                            <span class="checkmark me-2"></span>{{__('common.Header')}}
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mb-25 w-100">
                                        <label class="primary_checkbox d-flex mr-12">
                                            <input type="radio" id="type2"
                                                   name="set_auth"
                                                   value="url"
                                                   @if(isset($gateway))
                                                       {{ $gateway->set_auth == 'url' ?'checked':""}}
                                                   @else
                                                       checked
                                                @endif
                                            >
                                            <span class="checkmark me-2"></span>
                                            {{__('common.URL')}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="primary_input mb-25">
                                <div class="row mb-25">
                                    <div class="col-md-12">
                                        <label class="primary_input_label"
                                               for=""> {{ __('setting.Add plus(+) with phone number') }} <span
                                                class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 mb-25">
                                            <label class="primary_checkbox d-flex mr-12 w-100">
                                                <input type="radio" id="add_plus1"
                                                       name="add_plus"
                                                       value="1" {{ isset($gateway)?$gateway->add_plus ==1 ?'checked':"":''}} >
                                                <span class="checkmark me-2"></span>{{__('common.Yes')}}
                                            </label>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-25 w-100">
                                            <label class="primary_checkbox d-flex mr-12">
                                                <input type="radio" id="add_plus0"
                                                       name="add_plus"
                                                       value="0"
                                                    {{ isset($gateway)?$gateway->add_plus !=1 ?'checked':"":'checked'}}

                                                >
                                                <span class="checkmark me-2"></span>
                                                {{__('common.No')}}
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label"
                                       for="">{{__('common.Logo')}}</label>
                                <div class="primary_file_uploader">
                                    <input class="primary-input" type="text" id="placeholderLogoName"
                                           placeholder="" readonly="">
                                    <button class="primary-btn small fix-gr-bg" type="button">
                                        <label class="primary-btn small fix-gr-bg"
                                               for="gateway_logo">{{__('common.Browse')}} </label>
                                        <input type="file" class="d-none" name="gateway_logo" id="gateway_logo">
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <img id="logo_show" class="image_preview"
                                 src="{{isset($gateway)?showImage($gateway->gateway_logo): showImage()}}"
                                 alt="Logo">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h6{{__('setting.Gateway Parameters')}} </h4>
                        </div>
                        <div class="col-xl-12 mt-repeater no-extra-space">

                            <div data-repeater-list="parameters">
                                @if(isset($gateway_params))
                                    @foreach($gateway_params as $gateway_param)
                                        <div data-repeater-item class="mt-repeater-item">

                                            <div class="mt-repeater-row">

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for=""> {{__('setting.Key')}} </label>
                                                            <input value="{{$gateway_param->key}}" name="key"
                                                                   class="primary_input_field"
                                                                   placeholder="-" type="text">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for=""> {{__('setting.Value')}} </label>
                                                            <input value="{{$gateway_param->value}}" name="value"
                                                                   class="primary_input_field"
                                                                   placeholder="-" type="text">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-1">
                                                        <div class="position-relative form-group ">
                                                            <a href="javascript:void(0);" data-repeater-delete
                                                               class="primary-btn small icon-only fix-gr-bg mt-35  mt-repeater-delete">
                                                                <i class="fas fa-trash m-0"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                <div data-repeater-item class="mt-repeater-item">

                                    <div class="mt-repeater-row">

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for=""> {{__('setting.Key')}} </label>
                                                    <input name="key"
                                                           class="primary_input_field"
                                                           placeholder="-" type="text">
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for=""> {{__('setting.Value')}} </label>
                                                    <input name="value"
                                                           class="primary_input_field"
                                                           placeholder="-" type="text">
                                                </div>
                                            </div>

                                            <div class="col-lg-1">
                                                <div class="position-relative form-group ">
                                                    <a href="javascript:void(0);" data-repeater-delete
                                                       class="primary-btn small icon-only fix-gr-bg mt-35  mt-repeater-delete">
                                                        <i class="fas fa-trash m-0"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <a href="javascript:void(0);" data-repeater-create
                                       class="primary-btn radius_30px  fix-gr-bg mt-repeater-add w-fit"><i
                                            class="fa fa-plus"></i>{{__('common.Add More')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12 text-center pt_15">
                        <div class="d-flex justify-content-center">
                            <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"
                                    type="submit"><i
                                    class="ti-check"></i> {{__('common.Submit') }}
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </section>

@endsection

@push('scripts')
    <script src="{{asset('public/modules/profile/repeater/repeater.js')}}"></script>
    <script src="{{asset('public/modules/profile/repeater/indicator-repeater.js')}}"></script>
    <script>
        (function ($) {
            "use strict";
            let _token = $('meta[name=_token]').attr('content');
            $(document).ready(function () {

                $(document).on('change', '#gateway_logo', function (event) {
                    event.preventDefault();
                    showFileName($(this).val(), '#placeholderLogoName');
                    imageChangeWithFile($(this)[0], '#logo_show');
                });

                //onchange image show function
                function imageChangeWithFile(input, srcId) {

                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $(srcId)
                                .attr('src', e.target.result);
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                }

                function showFileName(value, placeholder) {
                    if (value) {
                        var startIndex = (value.indexOf('\\') >= 0 ? value.lastIndexOf('\\') : value.lastIndexOf('/'));
                        var filename = value.substring(startIndex);
                        if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                            filename = filename.substring(1);
                        }
                        $(placeholder).attr('placeholder', '');
                        $(placeholder).attr('placeholder', filename);

                    }
                }
            });

        })(jQuery);

    </script>

@endpush
