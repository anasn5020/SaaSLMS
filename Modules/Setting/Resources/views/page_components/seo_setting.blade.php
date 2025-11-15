@if (permissionCheck('setting.seo_setting_update'))
    <form class="" action="{{ route('seo_setup') }}" method="post">
        @endif
        @csrf
        <div class="main-title mb-20">
            <h3 class="mb-0"> {{__('setting.Homepage SEO Setup')}}</h3>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('setting.Meta Keywords') }} *</label>
                    <input class="primary_input_field" placeholder="-" type="text" name="meta_keywords"
                           value="{{Settings('meta_keywords')}}">
                </div>
            </div>
            <div class="col-xl-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{__('setting.Meta Description')}} *</label>
                    <textarea class="primary_textarea" placeholder="{{__('setting.Meta Description')}}" cols="30"
                              rows="10" name="meta_description">{{Settings('meta_description')}}</textarea>
                </div>
            </div>

        </div>

        <div id="TexttoLocal_Settings" class="sms_ption">
            <!-- content  -->
            @php
                $tooltip = "";
                if(!permissionCheck('setting.seo_setting_update')){
                    $tooltip = "You have no permission to add";
                }
            @endphp
            <div class="submit_btn text-center d-flex justify-content-center align-items-center  ">
                <button class="primary-btn fix-gr-bg" data-bs-toggle="tooltip" title="{{$tooltip}}" type="submit"><i
                        class="ti-check"></i> {{ __('common.Save') }}</button>
            </div>
            <!-- content  -->
        </div>
    </form>
