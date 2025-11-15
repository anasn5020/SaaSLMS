@extends('backend.master')

@section('mainContent')

    {!! generateBreadcrumb() !!}
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('setting.Color Theme')}}</h3>

                    <ul class="d-flex">
                        <li><a class="primary-btn radius_30px   fix-gr-bg"
                               href="{{ route('appearance.themes-customize.index') }}"><i
                                    class="ti-list"></i>{{__('setting.Color Theme List')}}</a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="white-box">
                <form method="POST" action="{{ route('appearance.themes-customize.update', $editData->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                <div class="row form">
                    <div class="col-lg-2">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label" for="title">{{__('setting.Theme Title')}} *</label>
                            <input type="text" name="title" class="primary_input_field" id="title" required
                                   maxlength="191" autofocus value="{{ $editData->name }}">
                            <span class="text-danger">{{$errors->first('title')}}</span>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">{{__('setting.Themes')}} *</label>
                            <select class="primary_select mb-15 theme" name="theme" id="theme">
                                @foreach($themes as $theme)
                                    <option
                                        value="{{$theme->name}}" {{$theme->name==$editData->theme_name?'selected':''}}>{{$theme->title}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{$errors->first('theme')}}</span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <label class="primary_input_label" for="">{{__('frontend.Gradient Color')}} *</label>
                        <select class="primary_select mb-15 theme" name="is_gradient" id="is_gradient">
                            <option {{$editData->is_gradient==1?'selected':''}} value="1">{{__('common.Yes')}}</option>
                            <option {{$editData->is_gradient!=1?'selected':''}} value="0">{{__('common.No')}}</option>
                        </select>

                    </div>
                    <div class="col-lg-2">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label"
                                   for=" ">{{__('setting.Primary Color')}}</label>
                            <input type="color" name="p_color" value="{{ $editData->primary_color }}"
                                   class="primary_input_field color_field"
                                   required
                            >
                            <span class="text-danger">{{$errors->first('p_color')}}</span>
                        </div>
                    </div>
                    <div class="col-lg-2" id="gradient_color">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label"
                                   for=" ">{{__('setting.Primary Color')}}(2)</label>
                            <input type="color" name="g_color" value="{{ $editData->gradient_color }}"
                                   class="primary_input_field color_field"
                                   required
                            >
                            <span class="text-danger">{{$errors->first('g_color')}}</span>
                        </div>
                    </div>


                    <div class="col-lg-2">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label"
                                   for=" ">{{__('setting.Secondary Color')}}</label>
                            <input type="color" name="s_color" value="{{ $editData->secondary_color }}"
                                   class="primary_input_field color_field"
                                   required>
                            <span class="text-danger">{{$errors->first('s_color')}}</span>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <hr>
                    </div>
                    <div class="col-lg-2">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label"
                                   for=" ">{{__('setting.Footer Background Color')}}</label>
                            <input type="color" name="footer_background_color"
                                   value="{{ $editData->footer_background_color }}"
                                   class="primary_input_field color_field"
                                   required>
                            <span class="text-danger">{{$errors->first('footer_background_color')}}</span>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label"
                                   for=" ">{{__('setting.Footer Headline Color')}}</label>
                            <input type="color" name="footer_headline_color"
                                   value="{{ $editData->footer_headline_color }}"
                                   class="primary_input_field color_field"
                                   required>
                            <span class="text-danger">{{$errors->first('footer_headline_color')}}</span>
                        </div>
                    </div>


                    <div class="col-lg-2">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label"
                                   for=" ">{{__('setting.Footer Text Color')}}</label>
                            <input type="color" name="footer_text_color" value="{{ $editData->footer_text_color }}"
                                   class="primary_input_field color_field"
                                   required>
                            <span class="text-danger">{{$errors->first('footer_text_color')}}</span>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label"
                                   for=" ">{{__('setting.Footer Text Hover Color')}}</label>
                            <input type="color" name="footer_text_hover_color"
                                   value="{{ $editData->footer_text_hover_color }}"
                                   class="primary_input_field color_field"
                                   required>
                            <span class="text-danger">{{$errors->first('footer_text_hover_color')}}</span>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label"
                                   for=" ">{{__('setting.Background Color')}}</label>
                            <input type="color" name="bg_color"
                                   class="primary_input_field color_field"
                                   value="{{ $editData->bg_color }}"
                                   required>
                            <span class="text-danger">{{$errors->first('bg_color')}}</span>
                        </div>
                    </div>
                </div>

                <div class="row form">


                    <div class="col-12">
                        <div class="submit_btn text-center d-flex flex-wrap gap-3">

                            <button class="primary-btn semi_large2 fix-gr-bg" type="submit"><i
                                    class="ti-check"></i>{{__('common.Save')}}
                            </button>

                            <button class="primary-btn semi_large2 fix-gr-bg" id="reset_to_default" type="button"><i
                                    class="ti-reload"></i>{{__('setting.Reset To Default')}}
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

    <script>
        //document on ready function
        $(document).ready(function () {
            $('#is_gradient').trigger('change');
        })
        $(document).on('click', '#reset_to_default', function () {
            document.location.reload(true);
        });
        $(document).on('change', '#is_gradient', function () {
            if ($(this).val() == 1) {
                $('#gradient_color').removeClass('d-none');
            } else {
                $('#gradient_color').addClass('d-none');
            }
        });
    </script>

@endpush
