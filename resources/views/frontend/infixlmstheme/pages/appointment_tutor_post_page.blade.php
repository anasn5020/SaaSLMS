<!-- hero area:start -->
@extends(theme('layouts.master'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'Infix LMS' }} | {{ __('appointment.Post Request') }}
@endsection
@section('css')

    <link rel="stylesheet"
          href="{{ asset('Modules\Appointment\Resources\assets\frontend\css\jquery-ui.min.css') }}{{assetVersion()}}"/>
    <style>
        .tutor_post .primary_checkbox {
            align-items: flex-start !important;
        }
    </style>
    <link rel="stylesheet"
          href="{{ asset('Modules\Appointment\Resources\assets\frontend\css\appointment.css') }}{{assetVersion()}}"/>
@endsection
@section('mainContent')

    <main class="tutor_post">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                    <div class="tutor_post_inner">
                        <h4>{{ __('appointment.Post a Request') }}</h4>
                        <form method="POST" action="{{ route('appointment.post.store') }}">
                            @csrf
                             <div class="input-control clearfix">
                                <label for="#"
                                       class="input-control-label">{{ __('appointment.Tutoring Category') }}</label>
                                <select class="input-control-input active_nice_select" name="teaching_category">
                                    <option value="">{{ __('appointment.Select Category') }}</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}" {{ isset($request) ? $request[0]['teaching_category'] == $item->id?'selected':'':'' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-control">
                                <label for="#" class="input-control-label">{{ __('appointment.Headline') }}</label>
                                <input type="text" name="headline" class="input-control-input"
                                       placeholder='Type headline here'
                                       value="{{ isset($request) ? $request[0]['headline'] : '' }}">
                            </div>
                            <div class="input-control">
                                <label for="#" class="input-control-label">{{ __('appointment.Requirements') }}</label>
                                <textarea class="input-control-input" name="requirement"
                                          placeholder='Specify additional details'>{{ isset($request) ? $request[0]['requirement'] : '' }}</textarea>
                            </div>
                            <div class="input-control">
                                <label for="#" class="input-control-label">{{ __('appointment.Price Range') }}</label>
                                <div class="price_range">
                                    <div class='price_range_width'>
                                        <div class="price_range_inner">
                                            <input type="text" class="input-control-input d-inline-block" id='min_price'
                                                   value="{{ isset($request) ? $request[0]['min_price'] : 100 }}"
                                                   name="min_price">
                                            <span>–</span>
                                            <input type="text" name="max_price"
                                                   class="input-control-input d-inline-block"
                                                   id='max_price'
                                                   value="{{ isset($request) ? $request[0]['max_price'] : 300 }}">
                                            <span>USD</span>
                                        </div>
                                        <div id="price-range"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="input-control">
                                <label for="#" class="input-control-label">{{ __('common.Name') }}</label>
                                <input type="text" class="input-control-input" name="name"
                                       value="{{ isset($request) ? $request[0]['name'] : '' }}"
                                       placeholder='Enter Name'>
                            </div>
                            <div class="input-control">
                                <label for="#"
                                       class="input-control-label">{{ __('appointment.E-mail Address') }}</label>
                                <input type="email" class="input-control-input" name="email"
                                       value="{{ isset($request) ? $request[0]['email'] : '' }}"
                                       placeholder='Type e-mail address here'>
                            </div>
                            <div class="input-control">
                                <input type="submit" value="Save and Continue" class="input-control-input w-auto">
                            </div>
                            <div class="input-control">
                                <label class="primary_checkbox d-flex m-0">
                                    <input type="checkbox" checked>
                                    <span class="checkmark mr_15"></span>
                                    <span class="label_name">{{ __('appointment.By clicking Save and continue, you agree to Mastery’s') }} <a
                                                href="{{ url('/pages/terms') }}">{{ __('appointment.Terms of Service') }}</a>
                                            {{ __('appointment.And') }} <a href="{{ url('/pages/terms') }}">
                                                {{ __('appointment.Privacy Policy') }}</a></span>
                                </label>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

