@extends('backend.master')

@section('mainContent')

    {!! generateBreadcrumb() !!}
    <div class="row justify-content-center">

        <div class="col-lg-12">
            <div class="white-box">
                <form method="POST" action="{{ route('appearance.themes-font.store') }}">
                    @csrf
                    <div class="row row-gap-24 form">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <div class="">
                            <a href="{{route('api.setting')}}"
                                   class="primary-btn small fix-gr-bg w-fit text-nowrap">
                                    <span class="ti-plus pe-2"></span>
                                    {{__('setting.Api Settings')}}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">{{_trans('setting.Use Google Font')}} *</label>
                            <select class="primary_select mb-15 theme" name="google_font_is_active"
                                    id="google_font_is_active">
                                <option
                                    value="1" {{Settings('google_font_is_active')==1?'selected':''}}>{{__('common.Yes')}}</option>
                                <option
                                    value="0" {{Settings('google_font_is_active')!=1?'selected':''}}>{{__('common.No')}}</option>
                            </select>

                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">{{_trans('setting.Font')}} 1 *</label>
                            <select class="primary_select mb-15 theme" name="google_font_family1"
                                    id="google_font_family1">
                                @foreach ($fonts as $font)
                                    <option
                                        value="{{ $font }}" {{Settings('google_font_family1')==$font?'selected':''}}>{{ $font }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">{{_trans('setting.Font')}} 2 *</label>
                            <select class="primary_select mb-15 theme" name="google_font_family2"
                                    id="google_font_family2">
                                @foreach ($fonts as $font)
                                    <option
                                        value="{{ $font }}" {{Settings('google_font_family2')==$font?'selected':''}}>{{ $font }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>


                <div class="row form">


                    <div class="col-12">
                        <div class="submit_btn d-flex justify-content-center align-items-center ">

                            <button class="primary-btn semi_large2 fix-gr-bg" type="submit"><i
                                    class="ti-check"></i>{{__('common.Save')}}
                            </button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')


@endpush
