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
                                    <h3 class="mb-0">   {{__('newsletter.Acelle API Setting')}} </h3>
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <form action="{{route('newsletter.acelle.settingStore')}}"
                                      method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <table class="display school-table school-table-style" cellspacing="0" width="100%">


                                        <tbody>
                                        <tr>
                                            <td>{{__('newsletter.Status')}}</td>
                                            <td>
                                                @if($connected)
                                                    <img
                                                        src="{{asset('Modules/Newsletter/Resources/assets/green.png')}}"
                                                        width="10px" alt="">
                                                    {{__('newsletter.Connected')}}
                                                @else
                                                    <img src="{{asset('Modules/Newsletter/Resources/assets/red.png')}}"
                                                         width="10px" alt="">
                                                    {{__('newsletter.Not Connected')}}
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>{{__('newsletter.API Endpoint')}}</td>
                                            <td>

                                                <div class="primary_input">
                                                    <div class="primary_file_uploader">
                                                        <input
                                                            class="primary-input filePlaceholder" type="text" id=""
                                                            name="acelle_url" value="{{saasEnv('ACELLE_API_URL')}}"
                                                            placeholder="{{__('newsletter.API Endpoint')}}">

                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{__('newsletter.API Key')}}</td>
                                            <td>

                                                <div class="primary_input">
                                                    <div class="primary_file_uploader">
                                                        <input
                                                            class="primary-input filePlaceholder" type="text" id=""
                                                            name="acelle_api" value="{{env('ACELLE_API_TOKEN')}}"
                                                            placeholder="{{__('newsletter.Your Acelle API key')}}">

                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td></td>
                                            <td>{{__('newsletter.The API key for connecting with your GetResponse account')}}.
                                                <a
                                                    href="https://app.getresponse.com/api" target="_blank">
                                                    {{__('newsletter.Get your API key here')}}.</a></td>
                                        </tr> --}}
                                        <tr>

                                            <td colspan="2" class="text-center">
                                                <div class="d-flex justify-content-center align-items-center">

                                                    <button class="primary-btn semi_large2  fix-gr-bg"
                                                            id="save_button_parent" type="submit"><i
                                                            class="ti-check"></i> {{__('common.Save')}}
                                                    </button>
                                                </div>
                                            </td>


                                        </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        @if($connected)
                            <div class="row pt-3">
                                <div class="col-lg-12">
                                    <div class="main-title sm_mb_20 sm2_mb_20 md_mb_20 mb-30 mt_30">
                                        <h3 class="mb-0">   {{__('newsletter.Your Acelle Account')}} </h3>
                                    </div>

                                    <table class="display school-table school-table-style w-100">
                                        <thead>
                                        <tr>
                                            <th>{{__('newsletter.ID')}}</th>
                                            <th>{{__('newsletter.UID')}}</th>
                                            <th>{{__('newsletter.List Name')}}</th>
                                            <th>{{__('newsletter.Subscriber')}}</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @if(count($lists)==0)
                                            <tr>
                                                <td class="text-center"
                                                    colspan="4">{{__('newsletter.No List Found')}}</td>

                                            </tr>
                                        @endif

                                        @foreach($lists as $key=>$list)

                                            <tr>
                                                <td>{{$list['id']}}</td>
                                                <td>{{$list['uid']}}</td>
                                                <td>{{$list['name']}}</td>
                                                <td>{{$list['subscriber_count']}}</td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')

@endpush
