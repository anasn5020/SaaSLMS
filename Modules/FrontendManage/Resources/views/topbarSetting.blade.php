@extends('backend.master')
@section('table')
    {{__('social_links')}}
@endsection
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <div class="white-box mb_30 ">
                        <form action="{{route('frontend.saveTopBarSettings')}}" method="post" id="coupon-form"
                              name="coupon-form" enctype="multipart/form-data">

                            @csrf

                            {{-- <input type="hidden" name="category" value="1"> --}}
                            <div class="row">
                                <div class="col-lg-4">

                                    <div class="col-xl-12 ">
                                        <div class="mb_25">
                                            <label class="switch_toggle "
                                                   for="left_side_text_show">
                                                <input type="checkbox" class="status_enable_disable"
                                                       name="left_side_text_show"
                                                       id="left_side_text_show"
                                                       @if (@$data->left_side_text_show == 1) checked
                                                       @endif value="1">
                                                <i class="slider round"></i>


                                            </label>
                                            {{__('frontendmanage.Show Left Side Text')}}
                                            {{-- <i class="ti-move  float-end"></i> --}}
                                        </div>
                                    </div>
                                    @push('js')
                                        <script>
                                            let left_side_text_show = $('#left_side_text_show');
                                            let left_side_section = $('#left_side_section');
                                            left_side_text_show.change(function () {
                                                if (left_side_text_show.is(':checked')) {
                                                    left_side_section.show();
                                                } else {
                                                    left_side_section.hide();
                                                }
                                            });
                                        </script>

                                    @endpush
                                    <div id="left_side_section"
                                         style="display:@if($data->left_side_text_show==1) block @else none @endif ">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('frontendmanage.Icon') }} </label>
                                                <select
                                                    class="primary_select mb-25  {{ @$errors->has('icon') ? ' is-invalid' : '' }}"
                                                    name="left_side_logo" id="icon">
                                                    <option value="none">{{__('frontendmanage.None')}}</option>
                                                    @if(isset($data))
                                                        <option value="{{@$data->left_side_logo}}"
                                                                selected>{{@$data->left_side_logo}}</option>
                                                    @endif
                                                    {!! returnList() !!}
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('frontendmanage.Left Side Text')}}
                                                </label>
                                                <input name="left_side_text" id="left_side_text"
                                                       class="primary_input_field name {{ @$errors->has('left_side_text') ? ' is-invalid' : '' }}"
                                                       placeholder="{{__('frontendmanage.Left Side Text')}}"
                                                       type="text"
                                                       value="{{isset($data)?$data->left_side_text:old('left_side_text')}}">
                                                @if ($errors->has('left_side_text'))
                                                    <span class="invalid-feedback d-block mb-10" role="alert">
                                                                        <strong>{{ @$errors->first('left_side_text') }}</strong>
                                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('frontendmanage.Left Side Text')}} {{__('frontendmanage.Link URL')}}
                                                </label>
                                                <input name="left_side_text_link" id="left_side_text_link"
                                                       class="primary_input_field name {{ @$errors->has('left_side_text_link') ? ' is-invalid' : '' }}"
                                                       placeholder="Enter {{__('frontendmanage.Left Side Text')}} {{__('frontendmanage.Link URL')}}"
                                                       type="text"
                                                       value="{{isset($data)?$data->left_side_text_link:old('left_side_text_link')}}">
                                                @if ($errors->has('left_side_text_link'))
                                                    <span class="invalid-feedback d-block mb-10" role="alert">
                                                                        <strong>{{ @$errors->first('left_side_text_link') }}</strong>
                                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Second --}}
                                <div class="col-lg-4">

                                    <div class="col-xl-12 ">
                                        <div class="mb_25">
                                            <label class="switch_toggle "
                                                   for="right_side_text_1_show">
                                                <input type="checkbox" class="status_enable_disable"
                                                       name="right_side_text_1_show"
                                                       id="right_side_text_1_show"
                                                       @if (@$data->right_side_text_1_show == 1) checked
                                                       @endif value="1">
                                                <i class="slider round"></i>


                                            </label>
                                            {{ __('frontendmanage.Right Side Text 1') }}
                                            {{-- <i class="ti-move  float-end"></i> --}}
                                        </div>
                                    </div>
                                    @push('js')
                                        <script>
                                            let right_side_text_1_show = $('#right_side_text_1_show');
                                            let right_side_section1 = $('#right_side_section1');
                                            right_side_text_1_show.change(function () {
                                                if (right_side_text_1_show.is(':checked')) {
                                                    right_side_section1.show();
                                                } else {
                                                    right_side_section1.hide();
                                                }
                                            });
                                        </script>

                                    @endpush
                                    <div id="right_side_section1"
                                         style="display:@if($data->right_side_text_1_show==1) block @else none @endif ">

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('frontendmanage.Icon') }} </label>
                                                <select
                                                    class="primary_select mb-25  {{ @$errors->has('reight_side_logo_1') ? ' is-invalid' : '' }}"
                                                    name="reight_side_logo_1" id="reight_side_logo_1">
                                                    <option value="none">{{__('frontendmanage.None')}}</option>
                                                    @if(isset($data))
                                                        <option value="{{@$data->reight_side_logo_1}}"
                                                                selected>{{@$data->reight_side_logo_1}}</option>
                                                    @endif
                                                    {!! returnList() !!}
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('frontendmanage.Right Side Text 1') }}
                                                </label>
                                                <input name="right_side_text_1" id="right_side_text_1"
                                                       class="primary_input_field name {{ @$errors->has('right_side_text_1') ? ' is-invalid' : '' }}"
                                                       placeholder="Right Side Text"
                                                       type="text"
                                                       value="{{isset($data)?$data->right_side_text_1:old('right_side_text_1')}}">
                                                @if ($errors->has('right_side_text_1'))
                                                    <span class="invalid-feedback d-block mb-10" role="alert">
                                                                    <strong>{{ @$errors->first('right_side_text_1') }}</strong>
                                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('frontendmanage.Right Side Text 1') }} {{ __('frontendmanage.Link URL') }}
                                                </label>
                                                <input name="right_side_text_1_link" id="right_side_text_1_link"
                                                       class="primary_input_field name {{ @$errors->has('right_side_text_1_link') ? ' is-invalid' : '' }}"
                                                       placeholder="{{ __('frontendmanage.Right Side Text 1') }} {{ __('frontendmanage.Link URL') }}"
                                                       type="text"
                                                       value="{{isset($data)?$data->right_side_text_1_link:old('right_side_text_1_link')}}">
                                                @if ($errors->has('right_side_text_1_link'))
                                                    <span class="invalid-feedback d-block mb-10" role="alert">
                                                                    <strong>{{ @$errors->first('right_side_text_1_link') }}</strong>
                                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- third --}}
                                <div class="col-lg-4">

                                    <div class="col-xl-12 ">
                                        <div class="mb_25">
                                            <label class="switch_toggle "
                                                   for="right_side_text_2_show">
                                                <input type="checkbox" class="status_enable_disable"
                                                       name="right_side_text_2_show"
                                                       id="right_side_text_2_show"
                                                       @if (@$data->right_side_text_2_show == 1) checked
                                                       @endif value="1">
                                                <i class="slider round"></i>


                                            </label>
                                            {{ __('frontendmanage.Right Side Text 1') }}
                                            {{-- <i class="ti-move  float-end"></i> --}}
                                        </div>
                                    </div>
                                    @push('js')
                                        <script>
                                            let right_side_text_2_show = $('#right_side_text_2_show');
                                            let right_side_section2 = $('#right_side_section2');
                                            right_side_text_2_show.change(function () {
                                                if (right_side_text_2_show.is(':checked')) {
                                                    right_side_section2.show();
                                                } else {
                                                    right_side_section2.hide();
                                                }
                                            });
                                        </script>

                                    @endpush
                                    <div id="right_side_section2"
                                         style="display:@if($data->right_side_text_2_show==1) block @else none @endif ">

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('frontendmanage.Icon') }} </label>
                                                <select
                                                    class="primary_select mb-25  {{ @$errors->has('reight_side_logo_2') ? ' is-invalid' : '' }}"
                                                    name="reight_side_logo_2" id="icon">
                                                    <option value="none">{{__('frontendmanage.None')}}</option>
                                                    @if(isset($data))
                                                        <option value="{{@$data->reight_side_logo_2}}"
                                                                selected>{{@$data->reight_side_logo_2}}</option>
                                                    @endif
                                                    {!! returnList() !!}
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('frontendmanage.Right Side Text 2') }}
                                                </label>
                                                <input name="right_side_text_2" id="right_side_text_2"
                                                       class="primary_input_field name {{ @$errors->has('right_side_text_2') ? ' is-invalid' : '' }}"
                                                       placeholder="{{ __('frontendmanage.Right Side Text 2') }}"
                                                       type="text"
                                                       value="{{isset($data)?$data->right_side_text_2:old('right_side_text_2')}}">
                                                @if ($errors->has('right_side_text_2'))
                                                    <span class="invalid-feedback d-block mb-10" role="alert">
                                                                    <strong>{{ @$errors->first('right_side_text_2') }}</strong>
                                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('frontendmanage.Right Side Text 2') }} {{ __('frontendmanage.Link URL') }}
                                                </label>
                                                <input name="right_side_text_2_link" id="right_side_text_2_link"
                                                       class="primary_input_field name {{ @$errors->has('right_side_text_2_link') ? ' is-invalid' : '' }}"
                                                       placeholder="{{ __('frontendmanage.Right Side Text 2') }} {{ __('frontendmanage.Link URL') }}"
                                                       type="text"
                                                       value="{{isset($data)?$data->right_side_text_2_link:old('right_side_text_2_link')}}">
                                                @if ($errors->has('right_side_text_2_link'))
                                                    <span class="invalid-feedback d-block mb-10" role="alert">
                                                                    <strong>{{ @$errors->first('right_side_text_2_link') }}</strong>
                                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-lg-12 text-center">
                                    <div class="d-flex justify-content-center pt_20">
                                        <button type="submit" class="primary-btn semi_large fix-gr-bg"
                                                data-bs-toggle="tooltip"
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

            </div>
        </div>
    </section>

    @include('backend.partials.delete_modal')
@endsection
@push('scripts')

@endpush
