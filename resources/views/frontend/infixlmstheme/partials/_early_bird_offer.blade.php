@php
    $total_enrolled = $course->enrollUsers->count();

    if (@$course->discount_price != null) {
        $course_price = $course->discount_price;
    } else {
        $course_price = $course->price;
    }
@endphp
<style>
    .offer_title {
        font-size: 16px;
        font-weight: 500;
        color: #373737;
        margin-bottom: 0;
    }

    #price-container {
        position: relative;
    }

    .price_loader {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7);
        z-index: 9999;
    }

    .price_loader::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: 4px solid #f3f3f3;
        border-top: 4px solid var(--system_primery_color);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: translate(-50%, -50%) rotate(0deg);
        }

        100% {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }
</style>
<div class="early_bird_offers">
    @foreach ($price_plans as $price_plan)
        @php
            $offer_price = $course_price - ($course_price * $price_plan->discount_amount) / 100;
            if ($offer_price < 0) {
                $offer_price = 0;
            }

            $is_eligible = true;
            $current_date = date('Y-m-d');
            //check current date is between start and end date
            if ($current_date >= $price_plan->start_date && $current_date <= $price_plan->end_date) {
                $is_eligible = true;
            } else {
                $is_eligible = false;
            }
            //check capacity is available or not
            if ($price_plan->capacity != null) {
                if ($total_enrolled >= $price_plan->capacity) {
                    $is_eligible = false;
                }
            }
            // $is_eligible = true;
        @endphp
        @if ($is_eligible)
            <div class="pb-3 ">

                <label class="primary_bulet_checkbox d-flex  ">
                    <input class="select_price_plan" name="price_plan"
                           data-discount-price="{{ getPriceFormat(@$offer_price) }}" value="{{ $price_plan->id }}"
                           type="radio">

                    <span class="checkmark mr_10"></span>
                    <div class=" d-flex flex-column">
                        <span class="label_name">
                            {{ @$price_plan->getTranslation('title', auth()->user()->language_code ?? 'en') }}
                            ({{ @$price_plan->discount_amount }}% {{ _trans('price_plan.Off') }})
                        </span>
                        <span class="font-14 text-gray">
                            @php
                                if ($price_plan->capacity != null) {
                                    $capacity = _trans('price_plan.For first').' ';
                                    $capacity .= $price_plan->capacity;
                                    $capacity .= ' '._trans('price_plan.students');
                                } else {
                                    $capacity = '';
                                }
                            @endphp
                            {{ $capacity }} {{ _trans('price_plan.until') }} {{ showDate($price_plan->end_date) }}
                        </span>
                    </div>

                </label>
            </div>
        @endif
    @endforeach
</div>
@push('js')
    <script>
        function showLoader() {
            $('.price_loader').show();
        }

        function hideLoader() {
            $('.price_loader').hide();
        }

        $('.select_price_plan').on('change', function () {
            var discount_price = $(this).data('discount-price');
            var price_show_tag = $('#price_show_tag');
            var current_price = $('#price_show_tag').text();
            showLoader();

            var price_plan_id = $(this).val();
            var course_id = {{ $course->id }};
            var url = "{{ route('earlybird.plan.setOfferToSession') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    offer_id: price_plan_id,
                    course_id: course_id,
                    _token: "{{ csrf_token() }}",
                },
                success: function (response) {
                    if (response.success) {
                        price_show_tag.html(discount_price);
                        hideLoader();
                    } else {
                        price_show_tag.html(current_price);
                        hideLoader();
                    }
                },
                error: function (response) {
                    console.log(response);
                    price_show_tag.html(current_price);
                    hideLoader();
                }
            });
        });
    </script>
@endpush
