@extends('backend.master')
@section('mainContent')
    @push('styles')

    @endpush


    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">

                <div class="col-12">
                    <div class="">
                        <div class="row">

                            <div class="col-lg-12">
                                <!-- tab-content  -->
                                <div class="tab-content " id="myTabContent">
                                    <!-- General -->
                                    <div class="tab-pane fade white-box show active" id="Activation"
                                         role="tabpanel" aria-labelledby="Activation-tab">
                                        <div class="main-title mb-25">


                                            <form action="{{route('frontend.menusetting')}}" id="" method="POST"
                                                  enctype="multipart/form-data">

                                                @csrf

                                                <div class="single_system_wrap">
                                                    <div class="row">


                                                        <div class="col-lg-3">
                                                            <div class="primary_input mb-15">
                                                                <label class="primary_input_label"
                                                                       for=" ">{{__('frontendmanage.Menu Background')}}</label>
                                                                <input type="color" name="menu_bg"
                                                                       value="{{Settings('menu_bg')}}"
                                                                       class="primary_input_field color_field"
                                                                       required>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="primary_input mb-15">
                                                                <label class="primary_input_label"
                                                                       for=" ">{{__('frontendmanage.Menu Text Color')}}</label>
                                                                <input type="color" name="menu_text"
                                                                       value="{{Settings('menu_text')}}"
                                                                       class="primary_input_field color_field"
                                                                       required>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="primary_input mb-15">
                                                                <label class="primary_input_label"
                                                                       for=" ">{{__('frontendmanage.Menu Text Hover Color')}}</label>
                                                                <input type="color" name="menu_hover_text"
                                                                       value="{{Settings('menu_hover_text')}}"
                                                                       class="primary_input_field color_field"
                                                                       required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="primary_input mb-15">
                                                                <label class="primary_input_label"
                                                                       for=" ">{{__('frontendmanage.Menu Title Text Color')}}</label>
                                                                <input type="color" name="menu_title_text"
                                                                       value="{{Settings('menu_title_text')}}"
                                                                       class="primary_input_field color_field"
                                                                       required>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
<small class="text-muted">
    <i class="fa fa-question-circle"></i> {{__('frontendmanage.Its will be applied on mega menu')}}</small>

                                                <div class="submit_btn text-center d-flex align-items-center justify-content-center">
                                                    <button class="primary-btn semi_large fix-gr-bg" type="submit"
                                                            data-bs-toggle="tooltip" title=""
                                                            id="general_info_sbmt_btn"><i
                                                            class="ti-check"></i> {{ __('common.Save') }}</button>
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

        {{-- Delete Modal End --}}
    </section>
    @push('scripts')

    @endpush
@endsection
