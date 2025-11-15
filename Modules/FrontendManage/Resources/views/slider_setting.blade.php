@extends('backend.master')

@section('table')
    @php
        $currentTheme = currentTheme();
        if($currentTheme=='wetech'){
                $currentTheme='infixlmstheme';
            }
            $table_name='sliders';
    @endphp
    {{$table_name}}
@stop
@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12 ">


                    <div class="">
                        <div class="row">

                            <div class="col-lg-12">
                                <!-- tab-content  -->
                                <div class="tab-content " id="myTabContent">
                                    <!-- General -->
                                    <div class="tab-pane fade white-box show active" id="Activation"
                                         role="tabpanel" aria-labelledby="Activation-tab">
                                        <div class="main-title mb-25">


                                            <form action="{{route('frontend.sliders.setting')}}" id="" method="POST"
                                                  enctype="multipart/form-data">

                                                @csrf
                                                <div class="single_system_wrap">


                                                    @if(hasDynamicPage())
                                                        <div class="row">

                                                            <div class="col-xl-12">
                                                                <div class="mb-25">
                                                                    <x-upload-file
                                                                        name="slider_banner"
                                                                        type="image"
                                                                        media_id="{{isset($setting)?$setting->value_media?->media_id:''}}"
                                                                        label="{{ __('Homepage Banner') }}"
                                                                        note="{{__('student.Recommended size')}} (330x400)"
                                                                    />

                                                                </div>

                                                            </div>


                                                            @if($currentTheme=="infixlmstheme")
                                                                <div class="col-xl-3">

                                                                    <div class="mb_25">
                                                                        <label
                                                                            class="switch_toggle "
                                                                            for="show_banner_search_box">
                                                                            <input
                                                                                type="checkbox"
                                                                                class="status_enable_disable"
                                                                                name="show_banner_search_box"
                                                                                id="show_banner_search_box"
                                                                                @if (@getRawHomeContents($home_content,'show_banner_search_box','en') == 1) checked
                                                                                @endif value="1">
                                                                            <i class="slider round"></i>


                                                                        </label>
                                                                        {{__('frontendmanage.Show Banner Search Box')}}

                                                                    </div>
                                                                </div>
                                                            @endif


                                                        </div>

                                                        <hr>
                                                    @endif

                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12 mb-3">
                                                                        <label class="primary_input_label"
                                                                               for="">  {{__('frontendmanage.Slider')}} {{__('common.Transition time')}}</label>
                                                                    </div>
                                                                    <div class="col-md-6 ">
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{__('common.Transition time')}}"
                                                                               type="number"
                                                                               name="slider_transition_time"
                                                                               min="1"
                                                                               value="{{Settings('slider_transition_time')?Settings('slider_transition_time'):5}}">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="submit_btn d-flex justify-content-center align-items-center">
                                                    <button class="primary-btn   fix-gr-bg" type="submit"
                                                            data-bs-toggle="tooltip" title=""
                                                            id="general_info_sbmt_btn"><i
                                                            class="ti-check"></i> {{__('common.Save')}}
                                                    </button>
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



    @include('backend.partials.delete_modal')
@endsection
@push('scripts')

@endpush
