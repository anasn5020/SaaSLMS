<!-- tutor listing item:start -->
<section class="section_padding tutor_listing">
    <div class="container">
        <div class="row ipad-colmun-reverse">
            <div class="col-xl-3 col-lg-3">

                <input type="hidden" class="class_route" name="class_route"
                       value="{{ route('appointment.instructors') }}">
                <x-appointment-tutor-finder-sidebar :categories="$categories" :levels="$levels" :genders="$genders"
                                                    :weekDays="$weekDays" :countries="$countries"
                                                    :categoriesIds="$categoriesIds" :levelIds="$levelIds"
                                                    :genderIds="$genderIds" :priceRange="$priceRange"
                                                    :ageRange="$ageRange" :days="$days" :country="$country"
                                                    :type="$type"
                />

            </div>
            <div class="col-xl-8 col-lg-9">
                <div class="tutor_listing_title d-flex align-item-center flex-wrap">
                    <p class="d-flex align-items-center">
                        <span class="mobile_filter p-0 mr_10 d-xl-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19.5" height="13" viewBox="0 0 19.5 13">
                                <g transform="translate(28)">
                                    <rect id="" data-name="Rectangle 1" width="19.5" height="2" rx="1"
                                          transform="translate(-28)" fill="var(--system_primery_color)"></rect>
                                    <rect id="" data-name="Rectangle 2" width="15.5" height="2" rx="1"
                                          transform="translate(-26 5.5)" fill="var(--system_primery_color)"></rect>
                                    <rect id="" data-name="Rectangle 3" width="5" height="2" rx="1"
                                          transform="translate(-20.75 11)" fill="var(--system_primery_color)"></rect>
                                </g>
                            </svg>
                        </span>
                        {{ count($instructors) }} {{ __('appointment.Teachers Available') }}
                    </p>
                    <select class='active_nice_select' id="order">
                        <option value=""> {{__('common.Type')}}</option>
                        <option
                            {{request('order')=='2'?'selected':''}} value="2">{{ __('appointment.In-Person') }}</option>
                        <option
                            {{request('order')=='3'?'selected':''}}  value="3">{{ __('appointment.Online') }}</option>
                        <option
                            {{request('order')=='4'?'selected':''}}  value="4">{{ __('appointment.Individual') }}</option>
                        <option {{request('order')=='5'?'selected':''}} value="5">{{ __('appointment.Group') }}</option>
                        <option
                            {{request('order')=='6'?'selected':''}} value="6">{{ __('appointment.Individual(Online)') }}</option>
                        <option
                            {{request('order')=='7'?'selected':''}}  value="7">{{ __('appointment.Group(Online)') }}</option>
                    </select>
                </div>
                @foreach ($instructors as $instructor)
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
                                        <a
                                            href="{{ route('appointment.instructor', [$instructor->slug ?? $instructor->id]) }}">
                                            {{ $instructor->name }} </a>
                                        <img
                                            src="{{ asset('Modules/Appointment/Resources/assets/frontend/') }}/img/all-icons/country/{{ strtolower($instructor->userCountry->iso2) }}.svg"
                                            alt="" width="21" height="15">

                                    </h4>
                                    <ul>
                                        @if($settings->review_option == 1)
                                            <li class='star'><i
                                                    class="fa fa-star"></i>({{ $instructor->instructor_reviews_count }}
                                                {{ __('appointment.Ratings') }})
                                            </li>
                                        @endif
                                        @if($settings->number_of_student == 1)
                                            <li><i class="fa fa-user-friends"></i>
                                                {{ count($instructor->bookStudents) }}
                                                {{ __('appointment.students') }}
                                            </li>
                                        @endif
                                        {{-- <li><i class="fas fa-globe"></i>English</li> --}}
                                    </ul>


                                    <p>{{ __('appointment.Speaks') }} :
                                        @foreach ($instructor->teachingLanguages as $language)
                                            {{ $language->language->name }} <span
                                                style="color:{{ $language->level->color }};background-color:{{ $language->level->background_color }} ">{{ $language->level->title }}</span>
                                        @endforeach
                                    </p>
                                </div>
                                <p> <?php echo $instructor->about; ?></p>

                            </div>
                            <div class="tutor_listing_item_info_price text-end">
                                <h3>{{ getPriceFormat($instructor->hour_rate) }} <small>/
                                        {{ __('appointment.Hr.') }}</small></h3>
                                @if ($settings->trail_lesson == 1)
                                    @if(!empty($trial_booked_instructors) && $trial_booked_instructors->where('instructor_id',$instructor->id)->first())
                                        <a href="#"
                                           class="theme_btn ">{{ __('appointment.Booked Trial Lesson') }}</a>
                                    @else
                                        <a href="{{ route('book-trail-lesson', [$instructor->slug ?? $instructor->id]) }}"
                                           class="theme_btn ">{{ __('appointment.Book Trial Lesson') }}</a>
                                    @endif

                                @endif
                                @if(!empty($wishlist_instructors) && $wishlist_instructors->where('instructor_id',$instructor->id)->first())
                                    <a href="#"
                                       class="theme_btn bg-transparent">
                                        {{ __('appointment.Added to Wishlist') }}
                                    </a>
                                @else
                                    <a href="{{ route('store.wishlist', [$instructor->slug ?? $instructor->id]) }}"
                                       class="theme_btn bg-transparent">
                                        {{ __('appointment.Add to Wishlist') }}
                                    </a>
                                @endif

                            </div>
                        </div>

                        <!-- listing popup -->

                    </div>
                @endforeach
                <!-- paginations -->
                @if (count($instructors) > 10)
                    <div class="text-center">
                        <nav class="page_pagination">
                            <ul>
                                <li><a href="#"><i class="fa fa-angle-left"></i>Prev</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#" current-page>3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#"><span>...</span></a></li>
                                <li><a href="#">8</a></li>
                                <li><a href="#">Next<i class="fa fa-angle-right"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- tutor listing item:end -->
