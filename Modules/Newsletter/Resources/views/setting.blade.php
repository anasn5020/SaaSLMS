@extends('backend.master')
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row m-0">
                            <div class="col-lg-10 col-xs-6 col-md-6 col-6 g-0 ">
                                <div class="main-title sm_mb_20 sm2_mb_20 md_mb_20 mb-20 ">
                                    <h3 class="mb-0">   {{__('newsletter.Setting')}} </h3>
                                </div>
                            </div>
                        </div>
                        <div class="admin-visitor-area up_st_admin_visitor  school-table-style">

                            <form action="{{route('newsletter.setting.update')}}"
                                  method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb_30">
                                    <div class="col-xl-1">
                                        <label class="primary_input_label mb-3" for="">
                                            {{__('newsletter.Status')}}

                                        </label>
                                        <label class="switch_toggle">
                                            <input type="checkbox" name="home_status"
                                                   class=" "
                                                   @if(isset($setting))@if($setting->home_status=="1") checked
                                                   @endif @endif value="1">
                                            <i class="slider round"></i>
                                        </label>
                                    </div>
                                    <div class="col-xl-5 homeServiceBox">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">
                                                {{__('newsletter.Select Service For Homepage')}}
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <select class="primary_select" name="home_service" id="service_home">

                                                <option
                                                    value="Local"
                                                    @if(isset($setting))@if($setting->home_service=="Local") selected @endif @endif>{{__('newsletter.System Subscriber')}}</option>

                                                <option
                                                    value="Mailchimp"
                                                    @if(isset($setting))@if($setting->home_service=="Mailchimp") selected @endif @endif>{{__('newsletter.Mailchimp')}}</option>

                                                <option
                                                    value="GetResponse"
                                                    @if(isset($setting))@if($setting->home_service=="GetResponse") selected @endif @endif>{{__('newsletter.GetResponse')}}</option>
                                                <option
                                                    value="Acelle"
                                                    @if(isset($setting))@if($setting->home_service=="Acelle") selected @endif @endif>{{__('newsletter.Acelle')}}</option>


                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 getMailListHome">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">
                                                {{__('newsletter.Select List For Homepage Newsletter Subscription')}}
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <select class="primary_select" name="home_list">
                                                <option data-display="{{__('newsletter.Select List')}}"
                                                        value=""> {{__('newsletter.Select List')}}</option>
                                                @foreach($lists as $list)
                                                    <option value="{{$list['id']}}"
                                                            @if(isset($setting))@if($setting->home_list_id==$list['id']) selected @endif @endif>{{$list['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 getResponseListBoxHome">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">
                                                {{__('newsletter.Select List For Homepage Newsletter Subscription')}}
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <select class="primary_select" name="home_get_response_list">
                                                <option data-display="{{__('newsletter.Select List')}}"
                                                        value=""> {{__('newsletter.Select List')}}</option>
                                                @foreach($responsive_lists as $get_list)
                                                    <option value="{{$get_list->campaignId}}"
                                                            @if(isset($setting))@if($setting->home_list_id==$get_list->campaignId) selected @endif @endif>{{$get_list->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 acelleListBoxHome">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">
                                                {{__('newsletter.Select List For Homepage Newsletter Subscription')}}
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <select class="primary_select" name="home_acelle_list">
                                                <option data-display="{{__('newsletter.Select List')}}"
                                                        value=""> {{__('newsletter.Select List')}}</option>
                                                @foreach($acelle_lists as $get_list)

                                                    <option value="{{$get_list['uid']}}"
                                                            @if(isset($setting))@if($setting->home_list_id==$get_list['uid']) selected @endif @endif>{{$get_list['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>


                                <div class="row mb_30">
                                    <div class="col-xl-1">
                                        <label class="primary_input_label mb-3" for="">
                                            {{__('newsletter.Status')}}

                                        </label>
                                        <label class="switch_toggle">
                                            <input type="checkbox" name="student_status"
                                                   class=" "
                                                   @if(isset($setting))@if($setting->student_status=="1") checked
                                                   @endif @endif value="1">
                                            <i class="slider round"></i>
                                        </label>
                                    </div>
                                    <div class="col-xl-5 serviceServiceBox">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">
                                                {{__('newsletter.Select Service For Students')}}
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <select class="primary_select" name="student_service" id="service_student">
                                                <option
                                                    value="Local"
                                                    @if(isset($setting))@if($setting->student_service=="Local") selected @endif @endif>{{__('newsletter.System Subscriber')}}</option>

                                                <option
                                                    value="Mailchimp"
                                                    @if(isset($setting))@if($setting->student_service=="Mailchimp") selected @endif @endif>{{__('newsletter.Mailchimp')}}</option>

                                                <option
                                                    value="GetResponse"
                                                    @if(isset($setting))@if($setting->student_service=="GetResponse") selected @endif @endif>{{__('newsletter.GetResponse')}}</option>

                                                <option
                                                    value="Acelle"
                                                    @if(isset($setting))@if($setting->student_service=="Acelle") selected @endif @endif>{{__('newsletter.Acelle')}}</option>


                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 getMailListStudents">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">
                                                {{__('newsletter.Select List For Student Subscription After Registration')}}
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <select class="primary_select" name="student_list">
                                                <option data-display="{{__('newsletter.Select List')}}"
                                                        value=""> {{__('newsletter.Select List')}}</option>
                                                @foreach($lists as $list)
                                                    <option value="{{$list['id']}}"
                                                            @if(isset($setting))@if($setting->student_list_id==$list['id']) selected @endif @endif>{{$list['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 getResponseListBoxStudents">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">
                                                {{__('newsletter.Select List For Student Subscription After Registration')}}
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <select class="primary_select" name="student_get_response_list" id="list">
                                                <option data-display="{{__('newsletter.Select List')}}"
                                                        value=""> {{__('newsletter.Select List')}}</option>
                                                @foreach($responsive_lists as $get_list)
                                                    <option value="{{$get_list->campaignId}}"
                                                            @if(isset($setting))@if($setting->student_list_id==$get_list->campaignId) selected @endif @endif>{{$get_list->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 acelleListBoxStudents">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">
                                                {{__('newsletter.Select List For Student Subscription After Registration')}}
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <select class="primary_select" name="student_acelle_list">
                                                <option data-display="{{__('newsletter.Select List')}}"
                                                        value=""> {{__('newsletter.Select List')}}</option>
                                                @foreach($acelle_lists as $get_list)

                                                    <option value="{{$get_list['uid']}}"
                                                            @if(isset($setting))@if($setting->student_list_id==$get_list['uid']) selected @endif @endif>{{$get_list['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mb_30">
                                    <div class="col-xl-1">
                                        <label class="primary_input_label mb-3" for="">
                                            {{__('newsletter.Status')}}

                                        </label>
                                        <label class="switch_toggle">
                                            <input type="checkbox"
                                                   class="" name="instructor_status"
                                                   @if(isset($setting))@if($setting->instructor_status=="1") checked
                                                   @endif @endif value="1">
                                            <i class="slider round"></i>
                                        </label>
                                    </div>
                                    <div class="col-xl-5 instractorServiceBox">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">
                                                {{__('newsletter.Select Service For Instructors')}}
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <select class="primary_select" name="instructor_service"
                                                    id="service_instructors">

                                                <option
                                                    value="Local"
                                                    @if(isset($setting))@if($setting->instructor_service=="Local") selected @endif @endif>{{__('newsletter.System Subscriber')}}</option>

                                                <option
                                                    value="Mailchimp"
                                                    @if(isset($setting))@if($setting->instructor_service=="Mailchimp") selected @endif @endif>{{__('newsletter.Mailchimp')}}</option>

                                                <option
                                                    value="GetResponse"
                                                    @if(isset($setting))@if($setting->instructor_service=="GetResponse") selected @endif @endif>{{__('newsletter.GetResponse')}}</option>

                                                <option
                                                    value="Acelle"
                                                    @if(isset($setting))@if($setting->instructor_service=="Acelle") selected @endif @endif>{{__('newsletter.Acelle')}}</option>


                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 getMailListInstructors">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">
                                                {{__('newsletter.Select List For Instructor Subscription After Registration')}}
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <select class="primary_select" name="instructor_list" id="">
                                                <option data-display="{{__('newsletter.Select List')}}"
                                                        value=""> {{__('newsletter.Select List')}}</option>
                                                @foreach($lists as $list)
                                                    <option value="{{$list['id']}}"
                                                            @if(isset($setting))@if($setting->instructor_list_id==$list['id']) selected @endif @endif>{{$list['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 getResponseListBoxInstructors">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">
                                                {{__('newsletter.Select List For Instructor Subscription After Registration')}}
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <select class="primary_select" name="instructor_get_response_list">
                                                <option data-display="{{__('newsletter.Select List')}}"
                                                        value=""> {{__('newsletter.Select List')}}</option>
                                                @foreach($responsive_lists as $get_list)
                                                    <option value="{{$get_list->campaignId}}"
                                                            @if(isset($setting))@if($setting->instructor_list_id==$get_list->campaignId) selected @endif @endif>{{$get_list->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 acelleListBoxInstructors">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">
                                                {{__('newsletter.Select List For Instructor Subscription After Registration')}}
                                                <strong class="text-danger">*</strong>
                                            </label>
                                            <select class="primary_select" name="instructor_acelle_list">
                                                <option data-display="{{__('newsletter.Select List')}}"
                                                        value=""> {{__('newsletter.Select List')}}</option>
                                                @foreach($acelle_lists as $get_list)

                                                    <option value="{{$get_list['uid']}}"
                                                            @if(isset($setting))@if($setting->instructor_list_id==$get_list['uid']) selected @endif @endif>{{$get_list['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 text-center d-flex justify-content-center align-items-center mt-3 ">
                                        <button class="primary-btn semi_large2   fix-gr-bg"
                                                id="save_button_parent" type="submit"><i
                                                class="ti-check"></i> {{__('common.Save')}}
                                        </button>
                                    </div>
                                </div>
                            </form>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        $('#service_home').change(function () {

            let select = $('#service_home').find(":selected").val();
            if (select == "GetResponse") {
                $('.getResponseListBoxHome').show();
                $('.getMailListHome').hide();
                $('.acelleListBoxHome').hide();
                $('#homeServiceBox').removeClass('col-xl-11')

            } else if (select == "Mailchimp") {
                $('.getMailListHome').show();
                $('.getResponseListBoxHome').hide();
                $('.acelleListBoxHome').hide();
                $('#homeServiceBox').removeClass('col-xl-11')
            } else if (select == "Acelle") {
                $('.acelleListBoxHome').show();
                $('.getMailListHome').hide();
                $('.getResponseListBoxHome').hide();
                $('#homeServiceBox').removeClass('col-xl-11')
            } else {
                $('.getMailListHome').hide();
                $('.acelleListBoxHome').hide();
                $('.getResponseListBoxHome').hide();
                $('#homeServiceBox').addClass('col-xl-11')
            }
        });
        $("#service_home").trigger('change');


        $('#service_student').change(function () {

            let select = $('#service_student').find(":selected").val();
            if (select == "GetResponse") {
                $('.getResponseListBoxStudents').show();
                $('.getMailListStudents').hide();
                $('.acelleListBoxStudents').hide();
            } else if (select == "Mailchimp") {
                $('.getMailListStudents').show();
                $('.getResponseListBoxStudents').hide();
                $('.acelleListBoxStudents').hide();
            } else if (select == "Acelle") {
                $('.acelleListBoxStudents').show();
                $('.getMailListStudents').hide();
                $('.getResponseListBoxStudents').hide();

            } else {
                $('.getMailListStudents').hide();
                $('.getResponseListBoxStudents').hide();
                $('.acelleListBoxStudents').hide();
            }
        });
        $("#service_student").trigger('change');


        $('#service_instructors').change(function () {

            let select = $('#service_instructors').find(":selected").val();
            if (select == "GetResponse") {
                $('.getResponseListBoxInstructors').show();
                $('.getMailListInstructors').hide();
                $('.acelleListBoxInstructors').hide();
            } else if (select == "Mailchimp") {
                $('.getMailListInstructors').show();
                $('.getResponseListBoxInstructors').hide();
                $('.acelleListBoxInstructors').hide();
            } else if (select == "Acelle") {
                $('.acelleListBoxInstructors').show();
                $('.getMailListInstructors').hide();
                $('.getResponseListBoxInstructors').hide();

            } else {
                $('.getMailListInstructors').hide();
                $('.getResponseListBoxInstructors').hide();
                $('.acelleListBoxInstructors').hide();
            }
        });
        $("#service_instructors").trigger('change');

    </script>
@endpush
