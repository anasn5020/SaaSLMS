@extends('backend.master')

@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="mb-40 student-details">
        <div class="container-fluid p-0">
            <div class="row">

                <div class="col-lg-12">

                    @if (permissionCheck('vdocipher.settingUpdate'))
                        <form class="form-horizontal" action="{{route('vdocipher.settingUpdate')}}" method="POST">
                            @endif
                            @csrf
                            <div class="white-box">

                                <div class="col-md-12 p-0">

                                    <div class="row  ">
                                        <div class="col-md-12">

                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="">{{ __('setting.API Secret') }} *</label>
                                                        <input class="primary_input_field" placeholder="-" type="text"
                                                               name="api_secret"
                                                               value="{{saasEnv('VDOCIPHER_API_SECRET')}}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <code><a target="_blank"
                                                             href="https://www.vdocipher.com/dashboard/config/apikeys">{{__('setting.Click Here to Get VdoCipher Api Key')}}</a></code>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                @php
                                    $tooltip = "";
                                    if(!permissionCheck('vdocipher.settingUpdate')){
                                        $tooltip = "You have no permission to Update";
                                    }
                                @endphp
                                <div class="row">
                                    <div class="col-lg-12 d-flex align-items-center justify-content-center">
                                        <button type="submit" class="primary-btn fix-gr-bg" data-bs-toggle="tooltip"
                                                title="{{$tooltip}}">
                                            <i class="ti-check"></i>
                                            {{__('common.Update')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </section>

@endsection
