<div class="main_content_iner main_content_padding">

    <div class="dashboard_lg_card">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-12">
                    <div class="section__title3 mb_40">
                        <h3 class="mb-0">
                            {{ __('appointment.My WishList') }}
                        </h3>
                    </div>
                </div>
                <div class="col-xl-12 col-md-12">
                    <div class="tutor_listing_title">

                        <p> {{ isset($wishlists) ? count($wishlists) : 0}} {{ __('appointment.saved tutors') }}</p>
                    </div>
                    @isset($wishlists)
                        @foreach ($wishlists as $list)
                            @php
                                $instructor=   $list->instructor;
                            @endphp
                            <div class="tutor_listing_item">
                                <div class="tutor_listing_item_left">
                                    <div class="tutor_listing_item_profile_img">
                                        <img src="{{ getProfileImage($instructor->image,$instructor->name) }}" alt="">
                                    </div>
                                </div>
                                <div class="tutor_listing_item_right">
                                    <div class="tutor_listing_item_info">
                                        <div class="tutor_listing_item_info_profile">
                                            <h4>
                                                <a href="{{ route('appointment.instructor',[$instructor->slug]) }}">{{ $instructor->name }}
                                                    <img
                                                        src="{{ asset('Modules/Appointment/Resources/assets/frontend/') }}/img/all-icons/country/{{ strtolower($instructor->userCountry->iso2) }}.svg"
                                                        alt="" width="21" height="15">
                                                    </span><span>
                                         </span>
                                            </h4>
                                            <ul>
                                                <li class='star'><i
                                                        class="fa fa-star"></i>({{ $instructor->instructor_reviews_count }} {{ __('appointment.Ratings') }}
                                                    )
                                                </li>
                                                <li><i class="fa fa-user-friends"></i>
                                                    {{ $instructor->bookStudents ? count($instructor->bookStudents) : 0 }} {{ __('appointment.students') }}
                                                </li>
                                                {{-- <li><i class="fas fa-globe"></i>English</li> --}}
                                            </ul>


                                            <p>{{ __('appointment.Speaks') }} :
                                                @foreach ($instructor->teachingLanguages as $language)
                                                    {{ $language->language->name }} <span
                                                        style="color:{{ $language->level->color }};background-color:{{ $language->level->background_color }} ">{{ $language->level->title }}</span>
                                                @endforeach
                                            </p>
                                        </div>
                                        <p> <?php echo $instructor->about ?></p>

                                    </div>
                                    <div class="tutor_listing_item_info_price text-end">
                                        <h3 class="mb-0">{{ getPriceFormat($instructor->hour_rate) }}
                                            <small>/ {{ __('appointment.Hr.') }}</small></h3>

                                    </div>
                                </div>

                            </div>
                        @endforeach
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>

