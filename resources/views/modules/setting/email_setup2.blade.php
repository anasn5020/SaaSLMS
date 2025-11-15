@extends('backend.master')
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-12 ">
                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-20" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#indivitual_email_sms" role="tab"
                               data-bs-toggle="tab">{{__('setting.SMTP')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#file_list" role="tab"
                               data-bs-toggle="tab">{{__('setting.Send Grid')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#group_email_sms" role="tab"
                               data-bs-toggle="tab">{{__('setting.Php Mail')}}  </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-12 ">
                    <div class="white-box">
                        <div class="row  mt_0_sm">

                            <!-- Start Sms Details -->
                            <div class="col-lg-12">


                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <input type="hidden" name="selectTab" id="selectTab">
                                    <div role="tabpanel" class="tab-pane fade show active" id="indivitual_email_sms">
                                        @include('setting::page_components.smtp_mail_setup')


                                    </div>
                                    <!-- End Individual Tab -->
                                    <div role="tabpanel" class="tab-pane fade" id="file_list">

                                        @include('setting::page_components.send_grid_mail_setup')

                                    </div>
                                    <div role="tabpanel" class="tab-pane fade " id="group_email_sms">

                                        @include('setting::page_components.send_mail_setup')

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
    <br>
    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            <div class="row">

                <div class="col-md-12 ">
                    <div class="white-box">
                        <div class="row  mt_0_sm">

                            <!-- Start Sms Details -->
                            <div class="col-lg-12">
                                @if(permissionCheck('setting.send_test_mail'))
                                    <form class="" action="{{ route('sendTestMail') }}" method="post">
                                        @endif
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="">{{ __('setting.To Mail') }}*</label>
                                                    <input class="primary_input_field"
                                                           {{ $errors->has('testMailAddress') ? ' autofocus' : '' }} placeholder=""
                                                           type="email" required
                                                           name="testMailAddress" value="{{old('testMailAddress')}}">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="primary_input">
                                                    <label class="primary_input_label"
                                                           for="">{{ __('setting.Email Engine Type') }}</label>
                                                    <select name="type" class="primary_select mb-25">
                                                        @foreach($emailSettings as $emailSetting)
                                                            <option value="{{$emailSetting->id}}"
                                                                    @if ($emailSetting->active_status == 1) selected @endif>{{$emailSetting->email_engine_type}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <button class="primary-btn fix-gr-bg" data-bs-toggle="tooltip"
                                                        type="submit">{{ __('setting.Send Test Mail') }}</button>
                                            </div>
                                        </div>

                                    </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
@endsection
@push('scripts')

@endpush
