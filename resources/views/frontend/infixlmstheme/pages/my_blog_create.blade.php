@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('blog.Add Post')}}
@endsection
@section('css')
    <link href="{{asset('public/backend/css/summernote-bs5.min.css')}}{{assetVersion()}}" rel="stylesheet">
    <link rel="stylesheet"
          href="{{asset('Modules/Blog/Resources/views/assets/taginput/tagsinput.css')}}{{assetVersion()}}"/>
    <link rel="stylesheet" href="{{asset('Modules/Blog/Resources/views/assets/frontend.css')}}{{assetVersion()}}"/>
    <style>

        input[type="date"]::-webkit-calendar-picker-indicator, input[type="time"]::-webkit-calendar-picker-indicator {
            background: transparent;
            bottom: 0;
            color: transparent;
            cursor: pointer;
            height: auto;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            width: auto;
        }
    </style>
@endsection
@section('js')
    <script>
        window._locale = '{{ app()->getLocale() }}';
        window._translations = {!! $jsonLang??''!!};
        window.jsLang = function (key, replace) {
            let output = '';

            if (key.includes('.')) {
                const parts = key.split('.');
                key = parts[1];
            }

            if (window._translations.hasOwnProperty(key)) {
                output = window._translations[key];
            } else {
                output = key;
            }
            return output;

        }

        function localizeNumbers(text) {
            let numberMap = {
                '0': '{{translatedNumber(0)}}',
                '1': '{{translatedNumber(1)}}',
                '2': '{{translatedNumber(2)}}',
                '3': '{{translatedNumber(3)}}',
                '4': '{{translatedNumber(4)}}',
                '5': '{{translatedNumber(5)}}',
                '6': '{{translatedNumber(6)}}',
                '7': '{{translatedNumber(7)}}',
                '8': '{{translatedNumber(8)}}',
                '9': '{{translatedNumber(9)}}',
            };
            text = text.toString();
            return text.replace(/[0-9]/g, function (match) {
                return numberMap[match];
            });
        }

        window.translatedNumber = function (data) {

            var parsedValue = parseFloat(data);

            if (!isNaN(parsedValue) && isFinite(parsedValue)) {
                return localizeNumbers(data);
            } else {
                return data;
            }

        }

    </script>
    <script src="{{asset('public/backend/js/summernote-bs5.min.js')}}{{assetVersion()}}"></script>
    <script src="{{asset('Modules/Blog/Resources/views/assets/taginput/tagsinput.js')}}{{assetVersion()}}"></script>
    <script src="{{asset('Modules/Blog/Resources/views/assets/frontend.js')}}{{assetVersion()}}"></script>
    <script src="{{asset('public/js/wordcut.min.js')}}"></script>
    <script src="{{asset('public/backend/js/summernote-word-count.js')}}{{assetVersion()}}"></script>

@endsection

@section('mainContent')
    <div class="main_content_iner main_content_padding">
        <div class="dashboard_lg_card">
            <div class="container-fluid g-0">
                <div class="my_courses_wrapper">
                    <div class="row">
                        <div class="col-12">
                            <div class="section__title3 mb-4">
                                <h5>
                                    {{ __("blog.Add Post") }}
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-12">
                            <form enctype="multipart/form-data" action='{{ route('users.blogs.store') }}' method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-12 pb-3">
                                        <div class="form-group">
                                            <label class='primary_label2'>{{ __("blog.Title") }} *</label>
                                            <input type="text" class="primary_input" name='title[en]' id="blog_title"
                                                   placeholder="Enter Blog Title">
                                        </div>
                                    </div>

                                    <div class="col-12 pb-3">
                                        <div class="form-group">
                                            <label class='primary_label2'>{{ __("blog.Description") }}</label>
                                            <textarea class="lms_summernote" name="description[en]"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-12 pb-3">
                                        <div class="form-group">
                                            <label class='primary_label2'>{{ __("blog.Slug") }} *</label>
                                            <input type="text" class="primary_input" name='slug' id="slug">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 pb-3">
                                        <div class="form-group">
                                            <label class='primary_label2 '>{{ __("blog.Category") }} *</label>
                                            <select name="category" class="theme_select my-course-select w-100">
                                                <option value="" data-display="{{ __('blog.Category') }}">
                                                    {{ __('blog.Category') }}</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 pb-3">
                                        <div class="form-group">
                                            <label class='primary_label2'>{{ __("blog.Tags") }}</label>
                                            <input type="text" data-role="tagsinput" name="tags" class="primary_input">
                                        </div>
                                    </div>
                                </div>


                                <div class="row mt-0 row-gap-24">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label class='primary_label2'>{{__('blog.Thumbnail')}}</label>
                                            <input type="file" name="image">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label class='primary_label2'>{{__("blog.Publish Date")}}</label>
                                            <input type="date" id="publish_date" name="publish_date"
                                                   class="primary_input date">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label class='primary_label2'>{{__("blog.Publish Time")}}</label>
                                            <input type="time" id="start_time" name="publish_time"
                                                   class="primary_input time">
                                        </div>
                                    </div>

                                </div>

                                <div class="row mt-4 row-gap-24">
                                    <div class="col-lg-12">
                                        <button class="theme_btn mt-3 text-center">{{__('common.Save')}}</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
