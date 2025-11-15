@if (isset($result))
    <div class="row">


        @foreach ($result as $course)
            <div class="col-xl-4 col-sm-6 d-flex mb-4">
                <div class="shop-item bg-white w-100">
                    <div class="text-center position-relative">
                        <div class="shop-item-rating">

                            @php

                                $main_stars= $course->total_rating;

                                $stars=intval($main_stars);

                            @endphp
                            @for ($i = 0; $i <  $stars; $i++)
                                <i class="fas fa-star text-primary"></i>
                            @endfor
                            @if ($main_stars>$stars)
                                <i class="fas fa-star-half text-primary"></i>
                            @endif
                            @if($main_stars==0)
                                @for ($i = 0; $i <  5; $i++)
                                    <i class="far fa-star text-primary"></i>
                                @endfor
                            @endif
                        </div>
                        <a href="{{ courseDetailsUrl(@$course->id, @$course->type, @$course->slug) }}"
                           class="shop-item-img d-block">
                            <img class="img-fluid" src="{{ getCourseImage($course->product?->thumbnail) }}"
                                 alt="">
                        </a>
                    </div>
                    <div class="shop-item-content">
                        <span>{{ @$course->product_category->title }}</span>
                        <h4><a href="{{ courseDetailsUrl(@$course->id, @$course->type, @$course->slug) }}"
                               class="currentColor">{{ $course->title }}</a>
                        </h4>
                        <div class="d-flex align-items-end justify-content-between">
                            <div>
                                <del class="d-block fw-500">
                                    @if ($course->product?->discount > 0)
                                        {{ getPriceFormat(@$course->product->price) }}
                                    @endif
                                </del>
                                <strong class="fw-bold d-block">
                                    @php
                                        if (@$course->product->discount_type == 1) {
                                            $price = $course->product->price - $course->product?->discount;
                                        } elseif (@$course->product->discount_type == 2) {
                                            $price = $course->product->price - ($course->product->price * $course->product?->discount) / 100;
                                        } else {
                                            $price = $course->product?->price;
                                        }
                                    @endphp
                                    {{ getPriceFormat($price) }}
                                </strong>
                            </div>
                            <div>
                                <a href="{{route('buyNow',[@$course->id])}}"
                                   class="theme-btn buyNow"><i
                                        class="fa fa-shopping-cart"></i>{{ __('common.Buy Now') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach

    </div>

    <input type="hidden" value="{{asset('/')}}" id="baseUrl">

    <script>
        $(document).ready(function () {
            // select js
            $(".search-hide").select2({
                minimumResultsForSearch: Infinity,
            });
        });

        if ($.isFunction($.fn.lazy)) {
            $('.lazy').lazy();
        }
    </script>
@endif
