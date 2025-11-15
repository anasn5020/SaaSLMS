@extends('backend.master')

@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="mb-40 student-details">
        <div class="container-fluid p-0">
            <div class="row">

                <div class="col-lg-12">

                    @if (permissionCheck('gdrive.setting.update'))
                        <form class="form-horizontal" action="{{route('gdrive.setting.update')}}" method="POST"
                              enctype="multipart/form-data">
                            @endif
                            @csrf
                            <div class="white-box">

                                <div class="row   mb-3 pb-3">
                                    <div class="col-lg-12 text-end d-flex gap-10 justify-content-end flex-wrap mb-3">
                                        @if(auth()->user()->role_id==1)
                                            <a class="primary-btn radius_30px   fix-gr-bg"
                                               href="{{ url('public/backend/img/google_drive.pdf') }}"
                                               download="google_drive.pdf"><i
                                                    class="ti-file"></i>{{__('setting.Documentation')}}</a>
                                        @endif
                                        @if (auth()->user()->googleToken)
                                            <div class="dropdown CRM_dropdown ml-10">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false">
                                                    {{ auth()->user()->googleToken->google_email }}
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                     aria-labelledby="dropdownMenu2">
                                                    <a href="{{ route('setting.google.login') }}"
                                                       class="dropdown-item">{{__('setting.Switch Account')}}</a>
                                                    <a href="{{ route('setting.google.logout') }}"
                                                       class="dropdown-item">{{__('common.Logout')}}</a>
                                                </div>
                                            </div>
                                        @else
                                            <a href="{{ route('setting.google.login') }}"
                                               class="primary-btn radius_30px   fix-gr-bg"><i
                                                    class="ti-google"></i> {{ trans('common.Login') }}
                                            </a>
                                        @endif
                                    </div>


                                    @if(auth()->user()->role_id==1)

                                        @includeIf('setting::storage.partials._gdrive_form')

                                        <div class=" ">
                                            <div class="col-lg-12 d-flex align-items-center justify-content-center">
                                                <button type="submit" class="primary-btn fix-gr-bg"
                                                        data-bs-toggle="tooltip">
                                                    <i class="ti-check"></i>
                                                    {{__('common.Update')}}
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <table class="">


                                            <tbody>
                                            <tr>
                                                <th>{{__('common.Status')}} :</th>
                                                <td>
                                                    @if (auth()->user()->googleToken)
                                                        {{trans('common.Connected')}}
                                                    @else
                                                        {{trans('setting.Google Drive login is required')}}
                                                    @endif
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                </div>


                            </div>
                        </form>
                </div>
            </div>
        </div>
    </section>

@endsection
