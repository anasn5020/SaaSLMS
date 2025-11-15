@if (in_array('hero-section', $hasDescription))
    @php
        $decription = \Modules\Appointment\Entities\AppointmentFrontendPage::description('hero-section', 'appointment_page');
    @endphp
        <?php echo $decription; ?>
@else
    @include(theme('snippets.components._appointment_hero_area'))
@endif

@if (count($categories) > 0)
    <section class='tutor_category'>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="tutor_category_inner">
                        <div class="tutor_category_grid">
                            @foreach ($categories as $category)
                                <a href='{{ route('category.tutor', [convertToSlug($category->name.'-'.$category->id)]) }}'
                                   class="tutor_category_item">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="27.954" height="29.996"
                                             viewBox="0 0 27.954 29.996">
                                            <path id="london-eye"
                                                  d="M25.315,12.476a1.489,1.489,0,0,0-.581.117,11.89,11.89,0,0,0-.91-3.385,1.479,1.479,0,0,0,.567-.177,1.5,1.5,0,1,0-1.943-2.2,12.107,12.107,0,0,0-2.471-2.471,1.5,1.5,0,1,0-2.388-1.381,11.882,11.882,0,0,0-3.374-.9,1.5,1.5,0,1,0-2.76,0,11.879,11.879,0,0,0-3.374.9A1.5,1.5,0,1,0,5.693,4.364,12.1,12.1,0,0,0,3.221,6.835a1.5,1.5,0,1,0-1.944,2.2,1.474,1.474,0,0,0,.568.177,11.889,11.889,0,0,0-.91,3.386,1.5,1.5,0,1,0,0,2.759,11.95,11.95,0,0,0,.895,3.377A1.5,1.5,0,1,0,3.22,21.119a11.938,11.938,0,0,0,2.473,2.468,1.5,1.5,0,0,0,.159,2.5,1.551,1.551,0,0,0,.2.08L5.29,27.895a1.476,1.476,0,0,0-.053,1.055H2.351a.5.5,0,1,0,0,1H6.309a1.331,1.331,0,0,0,.7,0H18.476a1.328,1.328,0,0,0,.7,0h4.143a.5.5,0,1,0,0-1H20.244a1.484,1.484,0,0,0-.05-1.054l-.733-1.668a1.516,1.516,0,0,0,.359-.15,1.478,1.478,0,0,0,.7-.91,1.494,1.494,0,0,0-.15-1.135,1.471,1.471,0,0,0-.4-.449,11.947,11.947,0,0,0,2.475-2.472,1.5,1.5,0,1,0,1.385-2.384,11.935,11.935,0,0,0,.9-3.375,1.5,1.5,0,1,0,.583-2.878ZM23.161,7.6a.5.5,0,1,1,.178.525.5.5,0,0,1-.178-.525ZM18.642,2.915a.5.5,0,1,1,.036.554.5.5,0,0,1-.036-.554Zm-12.3-.183a.5.5,0,1,1-.183.682.5.5,0,0,1,.183-.682ZM1.594,7.484a.5.5,0,1,1,0,.5.5.5,0,0,1,0-.5Zm.915,12.859a.5.5,0,1,1-.05-.379.5.5,0,0,1,.05.379Zm9.827-18.85a.5.5,0,1,1,.5.5A.5.5,0,0,1,12.335,1.493ZM.355,14.472a.5.5,0,1,1,.5-.5A.5.5,0,0,1,.355,14.472ZM16.887,5.958l-3.519,6.093-.034-.01V5a8.987,8.987,0,0,1,3.553.956ZM16.256,18.92a.5.5,0,0,0-.019-.05l-1.383-3.154,5.5,3.174a9.046,9.046,0,0,1-2.887,2.779Zm4.593-.894-6.091-3.52c0-.012.007-.023.01-.034h7.039a8.983,8.983,0,0,1-.957,3.554Zm-6.082-4.552a.135.135,0,0,0-.009-.034l6.09-3.519a8.986,8.986,0,0,1,.957,3.553Zm-.506-.9-.027-.027,3.517-6.09a9.057,9.057,0,0,1,2.6,2.6Zm-1.926-.532a.127.127,0,0,0-.033.009L8.782,5.958A8.984,8.984,0,0,1,12.335,5ZM7.919,6.458l3.517,6.09-.014.011-.012.014L5.319,9.057a9.052,9.052,0,0,1,2.6-2.6Zm-3.1,3.462,6.093,3.519c0,.012-.007.023-.01.034H3.864a8.988,8.988,0,0,1,.955-3.553ZM10.9,14.472l.009.034-6.093,3.52a8.987,8.987,0,0,1-.954-3.554Zm-.343,1.39-2.5,5.713A9.067,9.067,0,0,1,5.32,18.89ZM6.345,25.212a.5.5,0,0,1-.179-.681.487.487,0,0,1,.3-.231.5.5,0,0,1,.378.05l-.394.9a.55.55,0,0,1-.1-.036Zm6.989-5.732,1.358,3.282a8.888,8.888,0,0,1-1.358.18Zm-1-.192v3.651a8.921,8.921,0,0,1-1.51-.21Zm-1.917,4.366a9.754,9.754,0,0,0,4.669.04l.407.929a11.065,11.065,0,0,1-5.482-.041Zm2.916,2.8a.5.5,0,1,1-.5-.5A.5.5,0,0,1,13.334,26.454Zm-3.727-.949a11.759,11.759,0,0,0,1.851.364,1.5,1.5,0,1,0,2.755,0,11.9,11.9,0,0,0,1.687-.319l1.491,3.4h-9.3Zm9.019,3.445a.492.492,0,0,1-.255-.255l-2.534-5.777L13.3,16.777a.359.359,0,0,0-.031-.047.507.507,0,0,0-.052-.078c-.01-.011-.015-.026-.026-.037a.47.47,0,0,0-.05-.034.484.484,0,0,0-.038-.036c-.016-.01-.025-.007-.036-.014s-.022-.017-.035-.022a.584.584,0,0,0-.061-.013.472.472,0,0,0-.093-.019c-.013,0-.025-.006-.038-.006a.425.425,0,0,0-.05.01.461.461,0,0,0-.1.02c-.012,0-.024,0-.036.007s-.029.02-.045.029a.474.474,0,0,0-.081.055c-.011.009-.025.014-.036.025a.334.334,0,0,1-.07.088l-.09.145a.569.569,0,0,0-.033.063L7.115,28.7a.49.49,0,0,1-.254.253H6.452A.492.492,0,0,1,6.2,28.3l5.833-13.309a.478.478,0,0,0,.027-.123.188.188,0,0,1,0-.022.48.48,0,0,0-.007-.15c0-.018-.006-.037-.01-.055a.5.5,0,0,0-.044-.093.478.478,0,0,0-.033-.07,1,1,0,0,1,0-1.005.952.952,0,0,1,.361-.361,1.009,1.009,0,0,1,1.005,0,.956.956,0,0,1,.361.362,1,1,0,0,1,0,1.006.632.632,0,0,1-.09.125.5.5,0,0,0-.134.34v0a.492.492,0,0,0,.041.2v0l1.8,4.1c0,.013.009.025.014.037l1.453,3.31v0l.8,1.831.1.225,0,.01.523,1.191a.4.4,0,0,0,.017.042l1.052,2.4a.5.5,0,0,1-.255.658Zm.7-3.737a.488.488,0,0,1-.28.057l-.353-.8a.47.47,0,0,1,.133-.116.5.5,0,0,1,.382-.05.486.486,0,0,1,.3.23.5.5,0,0,1-.182.681Zm-1.055-1.7-.4-.914A9.994,9.994,0,1,0,7.651,22.5l-.4.92a10.975,10.975,0,1,1,15.117-3.987c-.008.011-.015.023-.022.034a10.976,10.976,0,0,1-4.073,4.04Zm5.244-3.774a.5.5,0,1,1-.3.233.5.5,0,0,1,.3-.233Zm1.8-5.261a.5.5,0,1,1,.5-.5A.5.5,0,0,1,25.315,14.472Zm0,0"
                                                  transform="translate(1.143 0.001)" fill="currentColor"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h5>{{ $category->name }} {{ __('appointment.Tutor') }}</h5>
                                        <p>

                                            {{ $category->category_instructor_count }}

                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class='tutor_category_inner_bottom'>
                            <a href="{{ asset('/appointment/tutor-finder') }}" class="theme_btn">
                                {{ __('appointment.View All Category') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif


@if (in_array('feature-01', $hasDescription))
    @php
        $decription = \Modules\Appointment\Entities\AppointmentFrontendPage::description('feature-01', 'appointment_page');
    @endphp
        <?php echo $decription; ?>
@else
    @include(theme('snippets.components._appointment_feature_01'))
@endif

@if (in_array('feature-02', $hasDescription))
    @php
        $decription = \Modules\Appointment\Entities\AppointmentFrontendPage::description('feature-02', 'appointment_page');
    @endphp
        <?php echo $decription; ?>
@else
    @include(theme('snippets.components._appointment_feature_02'))
@endif

@if (in_array('feature-03', $hasDescription))
    @php
        $decription = \Modules\Appointment\Entities\AppointmentFrontendPage::description('feature-03', 'appointment_page');
    @endphp
        <?php echo $decription; ?>
@else
    @include(theme('snippets.components._appointment_feature_03'))
@endif

@if (in_array('feature-04', $hasDescription))
    @php
        $decription = \Modules\Appointment\Entities\AppointmentFrontendPage::description('feature-04', 'appointment_page');
    @endphp
        <?php echo $decription; ?>
@else
    @include(theme('snippets.components._appointment_feature_04'))
@endif

@if (in_array('feature-05', $hasDescription))
    @php
        $decription = \Modules\Appointment\Entities\AppointmentFrontendPage::description('feature-05', 'appointment_page');
    @endphp
        <?php echo $decription; ?>
@else
    @include(theme('snippets.components._appointment_feature_05'))
@endif

@if (in_array('feature-06', $hasDescription))
    @php
        $decription = \Modules\Appointment\Entities\AppointmentFrontendPage::description('feature-06', 'appointment_page');
    @endphp
        <?php echo $decription; ?>
@else
    @include(theme('snippets.components._appointment_feature_06'))
@endif

@if (in_array('feature-07', $hasDescription))
    @php
        $decription = \Modules\Appointment\Entities\AppointmentFrontendPage::description('feature-07', 'appointment_page');
    @endphp
        <?php echo $decription; ?>
@else
    @include(theme('snippets.components._appointment_feature_07'))
@endif

@if ($partner)
    <section class="section_padding tutor sponsor">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center">
                @foreach ($sponsors as $sponsor)
                    <a href='#' class="sponsor_item">
                        <img src="{{ asset($sponsor->image) }}" alt="">
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif
