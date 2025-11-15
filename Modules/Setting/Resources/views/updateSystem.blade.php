@php use Illuminate\Support\Facades\Auth; @endphp
@extends('backend.master')
@section('mainContent')
    <style>
        .school-table-style {
            padding: 0px;
        }

        @media (max-width: 576px) {
            .primary-btn.fix-gr-bg {
                font-size: 10px;
                line-height: 25px;
                padding: 0px 10px
            }
        }


    </style>
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_admin_visitor empty_table_tab">
        <div class="container-fluid p-0">


            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12">
                            @if(!config('app.demo_mode'))
                                @if (permissionCheck('setting.updateSystem.submit'))
                                    <form method="POST" action="{{ route('setting.updateSystem.submit') }}"
                                          class="form-horizontal" enctype="multipart/form-data">
                                        @csrf
                                        @endif
                                        @endif
                                        <div class="white-box mb-20">
                                            <div class="main-title">
                                                <h3 class="mb-20">@lang('setting.Upload From Local Directory')</h3>
                                            </div>
                                            <div class="add-visitor">

                                                <div class="row g-0  input-right-icon mb-20">
                                                    <div class="col">
                                                        <div class="input-effect">
                                                            <input
                                                                class="primary-input form-control {{ $errors->has('content_file') ? ' is-invalid' : '' }}"
                                                                readonly="true" type="text"
                                                                placeholder="{{isset($editData->file) && @$editData->file != ""? getFilePath3(@$editData->file):trans('common.Browse')}} "
                                                                id="placeholderUploadContent" name="content_file">
                                                            <span class="focus-border"></span>
                                                            @if ($errors->has('content_file'))
                                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('content_file') }}</strong>
                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button class="primary-btn-small-input" type="button">
                                                            <label class="primary-btn small fix-gr-bg"
                                                                   for="upload_content_file">@lang('common.Browse')</label>
                                                            <input type="file" class="d-none form-control"
                                                                   name="updateFile"
                                                                   required
                                                                   id="upload_content_file">
                                                        </button>

                                                    </div>
                                                </div>
                                                @php
                                                    $tooltip = "";

                                            if (permissionCheck('setting.updateSystem.submit')){
                                                            $tooltip = "";
                                                        }else{
                                                            $tooltip = "You have no permission to add";
                                                        }
                                            if(config('app.demo_mode')){
                                                $tooltip =trans('common.For the demo version, you cannot change this');
                                            }
                                                @endphp
                                                <div class="row  ">
                                                    <div class="col-lg-12 text-center">
                                                        <button class="primary-btn fix-gr-bg" data-bs-toggle="tooltip"
                                                                type="submit"
                                                                title="{{@$tooltip}}">
                                                            <i class="ti-check"></i>
                                                            @if(isset($session))
                                                                @lang('common.Update')
                                                            @else
                                                                @lang('common.Save')
                                                            @endif

                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box">
                                <div class="main-title">
                                    <h3 class="mb-20">{{__('setting.About System')}}</h3>
                                </div>
                                <div class="add-visitor">
                                    <table style="width:100%; box-shadow: none;"
                                           class="display school-table school-table-style">

                                        <tr>
                                            <td>{{__('setting.Software Version')}}</td>
                                            <td>
                                                {{translatedNumber(Storage::has('.version')?Storage::get('.version'):Settings('system_version'))}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{__('setting.Check update')}}</td>
                                            <td><a href="https://codecanyon.net/user/codethemes/portfolio"
                                                   target="_blank"> <i
                                                        class="ti-new-window"> </i> {{__('setting.Update')}} </a></td>
                                        </tr>
                                        <tr>
                                            <td> {{__('setting.PHP Version')}}</td>
                                            <td>{{translatedNumber(phpversion()) }}</td>
                                        </tr>
                                        <tr>
                                            <td> {{__('setting.Laravel Version')}}</td>
                                            <td>{{translatedNumber(app()->version() )}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('setting.Curl Enable')}}</td>
                                            <td>@php
                                                    if  (in_array  ('curl', get_loaded_extensions())) {
                                                        echo trans('common.Enable');
                                                    }
                                                    else {
                                                        echo  trans('common.Disable');
                                                    }
                                                @endphp</td>
                                        </tr>


                                        <tr>
                                            <td>{{__('setting.Purchase code')}}</td>
                                            <td class="text-nowrap">
                                                {{__('setting.Verified')}}

                                                @if(Auth::user()->role_id==1)
                                                    @if(!config('app.demo_mode'))
                                                        @includeIf('service::license.revoke')
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>{{__('setting.Install Domain')}}</td>
                                            <td>{{Settings('system_domain')}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{__('setting.System Activated Date')}}</td>
                                            <td>{{Settings('system_activated_date')}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{__('setting.Last Update at')}}</td>
                                            <td>
                                                @if($last_update)
                                                    {{$last_update->created_at}}

                                                @else
                                                    {{Settings('system_activated_date')}}
                                                @endif
                                            </td>
                                        </tr>

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




