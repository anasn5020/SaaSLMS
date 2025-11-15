@php use Illuminate\Support\Facades\Auth;use Modules\Payment\Entities\Cart; @endphp
    <!-- Product Details:Start -->
<style>
    div#preview-img-ZoomContainer {
        pointer-events: none;
    }

    P {
        color: #9F8EA9;
    }

    .gap-10 {
        gap: 10px;
    }

    .radio-btn-selector {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
    }

    .radio-btn-selector li {
        position: relative;
    }

    .radio-btn-selector label,
    .radio-btn-selector input {
        display: block;
    }

    .radio-btn-selector input {
        position: absolute;
    }

    .radio-btn-selector input[type="radio"] {
        opacity: 0;
        z-index: 100;
    }

    .radio-btn-selector input[type="radio"]:checked + label,
    .Checked + label {
        background: var(--system_primery_color);
        color: var(--white);
    }

    .radio-btn-selector label {
        padding: 5px 10px;
        cursor: pointer;
        z-index: 90;
        background: #F3F3F3;
        border-radius: 8px;
    }

    .radio-btn-selector label:hover {
        background: #DDD;
    }
</style>
<section class="shop_details section-padding-lg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="shop-details bg-white">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="shop-details-preview">
                                <img src="{{ getCourseImage($course->product?->thumbnail) }}" class="w-100"
                                     alt="" id="preview-img">
                                @if (isset($course->product?->pdf))
                                    <a href="{{ route('readSomePartOfBooks', $course->id) }}"
                                       class="read-some-pages-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20"
                                             viewBox="0 0 24 20" fill="none">
                                            <path
                                                d="M2.36184 3.65403C3.56707 3.14578 5.29525 2.59771 6.97576 2.42738C8.78701 2.24331 10.3232 2.51391 11.2138 3.46034V16.8477C9.94049 16.1197 8.32671 16.0194 6.83822 16.1705C5.23124 16.3354 3.61065 16.8038 2.36184 17.2845V3.65403ZM12.5757 3.46034C13.4663 2.51391 15.0025 2.24331 16.8137 2.42738C18.4942 2.59771 20.2224 3.14578 21.4276 3.65403V17.2845C20.1775 16.8038 18.5582 16.334 16.9513 16.1719C15.4614 16.0194 13.849 16.1183 12.5757 16.8477V3.46034ZM11.8947 2.21858C10.5533 1.05512 8.60861 0.882045 6.83822 1.06062C4.77639 1.27078 2.69549 1.98369 1.39902 2.57847C1.28006 2.63305 1.17918 2.72099 1.10843 2.83182C1.03768 2.94264 1.00004 3.07166 1 3.20348V18.3134C1.00003 18.4283 1.02865 18.5414 1.08323 18.6422C1.13781 18.7431 1.21662 18.8285 1.31242 18.8907C1.40823 18.9529 1.51797 18.9899 1.6316 18.9982C1.74523 19.0065 1.85911 18.986 1.96282 18.9384C3.16397 18.3889 5.09914 17.7282 6.9744 17.5373C8.89324 17.3422 10.5016 17.6568 11.3636 18.7419C11.4274 18.8222 11.5083 18.8869 11.6002 18.9314C11.6921 18.9759 11.7928 18.999 11.8947 18.999C11.9967 18.999 12.0974 18.9759 12.1893 18.9314C12.2812 18.8869 12.3621 18.8222 12.4259 18.7419C13.2879 17.6568 14.8962 17.3422 16.8137 17.5373C18.6903 17.7282 20.6269 18.3889 21.8267 18.9384C21.9304 18.986 22.0442 19.0065 22.1579 18.9982C22.2715 18.9899 22.3812 18.9529 22.4771 18.8907C22.5729 18.8285 22.6517 18.7431 22.7062 18.6422C22.7608 18.5414 22.7894 18.4283 22.7895 18.3134V3.20348C22.7894 3.07166 22.7518 2.94264 22.681 2.83182C22.6103 2.72099 22.5094 2.63305 22.3905 2.57847C21.094 1.98369 19.0131 1.27078 16.9513 1.06062C15.1809 0.880671 13.2362 1.05512 11.8947 2.21858Z"
                                                fill="white" stroke="white"/>
                                        </svg>
                                        {{ __('product.Read Some Pages') }}
                                    </a>
                                @endif
                            </div>
                            @if (isset($course->product?->product_image))
                                @foreach ($course->product?->product_image as $image)
                                    <div class="shop-details-nav mt-20" id="shop-gallery">
                                        <a href="#"
                                           class="shop-details-nav-list {{ $loop->first ? 'zoomGalleryActive' : '' }}"
                                           data-image="{{ getCourseImage($image->thumbnail) }}">
                                    <span><img src="{{ getCourseImage($image->thumbnail) }}"
                                               alt=""></span>
                                        </a>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                        <div class="col-lg-7">
                            <div class="shop-details-content">
                                <div class="shop-details-rating d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-pill">
                                        {{ @$course->product?->category->title }}</div>
                                    <div class="bg-heading rounded-pill">
                                        <div class="star text-secondary fs-12">
                                            @php
                                                $main_stars = $course->total_rating;
                                                $stars = intval($main_stars);
                                            @endphp
                                            @for ($i = 0; $i < $stars; $i++)
                                                <i class="fa fa-star"></i>
                                            @endfor
                                            @if ($main_stars > $stars)
                                                <i class="fa fa-star-half-alt"></i>
                                            @endif
                                            @if ($main_stars == 0)
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="fa fa-star"></i>
                                                @endfor
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <h4 class="fw-fw-semibold">{{ @$course->title }}</h4>
                                <div class="d-flex gap-10 align-items-end price">
                                    <strong class="text-primary fw-bold priceTag">
                                        @php
                                            if($course->product->has_variant != 1){
                                                echo storeProductPrice(@$course->product?->discount_type, $course->product?->discount, $course->product?->price);
                                            }
                                        @endphp
                                    </strong>
                                    <del class="fw-500 text-secondary d-block">
                                        @if ($course->product?->discount > 0)
                                            {{ getPriceFormat(@$course->product?->price) }}
                                        @endif
                                    </del>
                                    @if ($course->product->stock_manage == 1 && $course->product->stock_quantity == 0)
                                        <strong class="d-block">
                                            <p class="text-warning"> {{ __('product.Out of Stock') }}</p>
                                        </strong>
                                    @endif
                                </div>
                                <div class="product-short-info">
                                    {!! \Illuminate\Support\Str::limit(strip_tags($course->product?->description), 200) !!}
                                </div>
                                @if($course->product->has_variant == 1)
                                    @php
                                        $product =$course->product;
                                        $attributes = $product->variant_details;
                                    @endphp
                                    @foreach($attributes as $key => $attribute)
                                        <input type="hidden" id="attribute">
                                        <div class="product-radio-selector">
                                            <h6>{{$attribute->name}}</h6>
                                            <ul class="radio-btn-selector">
                                                @foreach($attribute->value as $key2 =>$attribute_value)
                                                    <li>
                                                        <input type="radio"
                                                               class="selectedAttributeValue"
                                                               id="attributeValue_option{{$key}}{{$attribute->attr_val_id[$key2]??0}}"
                                                               name="attributeValue[{{$attribute->attr_val_id[$key]??0}}]"
                                                               {{$key2 == 0 ? 'checked' : ''}}
                                                               value="{{$attribute->attr_val_id[$key2]??0}}"/>
                                                        <label
                                                            for="attributeValue_option{{$key}}{{$attribute->attr_val_id[$key2]??0}}">{{$attribute_value}}</label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach

                                @endif
                                <div class="product-count">
                                    <div class="nice-number">
                                        @if ($course->product_type == 2)
                                            <button type="button" class="qtyMinus"><i class="ti-minus"></i></button>

                                        @php
                                            $totalQty =1;
                                            if (Auth::check()){
                                                $exit =Cart::where('course_id',$course->id)->where('user_id',auth()->id())->first();
                                                if ($exit){
                                                    $totalQty = $exit->qty;
                                                }
                                             }
                                        @endphp
                                        <input type="number" id="total_qty" min="1" readonly=""
                                               value="{{$totalQty}}" style="width: 2ch;">
                                             <button class="qtyPlus" type="button"><i class="ti-plus"></i></button>
                                        @endif
                                    </div>
                                </div>
                                <div class="shop-details-actions">
                                    @if (($course->product->stock_manage == 1 && $course->product->stock_quantity > 0) || $course->product->stock_manage == 0)
                                        @if (Auth::check())
                                            @if ($isEnrolled)
                                                @if ($course->product?->type == 1)
                                                    <a href="@if (isset($course->product?->soft_file)) {{ route('downloadVirtualFile', [$course->slug]) }} @else javascript:void(0) @endif"
                                                       class="theme-btn bg-btn-secondary">
                                                        <svg width="31" height="32" viewBox="0 0 31 32" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M0.898438 2.27486C0.898438 1.56242 1.47412 0.984863 2.18424 0.984863H3.14132C4.7708 0.984863 5.74645 2.08393 6.30436 3.10561C6.67623 3.78664 6.94526 4.57653 7.15568 5.29166C7.21267 5.28717 7.27041 5.28486 7.3288 5.28486H28.7541C30.1774 5.28486 31.2052 6.65127 30.815 8.02448L27.6814 19.0481C27.104 21.08 25.2535 22.4811 23.1477 22.4811H12.9503C10.827 22.4811 8.96571 21.0571 8.40378 19.0029L7.1 14.2366L4.94226 6.92881L4.93876 6.91601C4.67183 5.93934 4.4213 5.02695 4.04904 4.34523C3.68752 3.6832 3.39935 3.56486 3.14132 3.56486H2.18424C1.47412 3.56486 0.898438 2.98731 0.898438 2.27486ZM9.59529 13.6102L10.8837 18.3201C11.1391 19.2538 11.9851 19.9011 12.9503 19.9011H23.1477C24.1049 19.9011 24.946 19.2642 25.2086 18.3407L28.1862 7.86487H7.90259L9.57168 13.5182C9.58073 13.5488 9.58858 13.5794 9.59529 13.6102ZM15.4708 27.6449C15.4708 29.5448 13.9357 31.0849 12.042 31.0849C10.1484 31.0849 8.61323 29.5448 8.61323 27.6449C8.61323 25.745 10.1484 24.2049 12.042 24.2049C13.9357 24.2049 15.4708 25.745 15.4708 27.6449ZM12.8992 27.6449C12.8992 27.17 12.5154 26.7849 12.042 26.7849C11.5686 26.7849 11.1848 27.17 11.1848 27.6449C11.1848 28.1198 11.5686 28.5049 12.042 28.5049C12.5154 28.5049 12.8992 28.1198 12.8992 27.6449ZM27.4716 27.6449C27.4716 29.5448 25.9365 31.0849 24.0428 31.0849C22.1491 31.0849 20.614 29.5448 20.614 27.6449C20.614 25.745 22.1491 24.2049 24.0428 24.2049C25.9365 24.2049 27.4716 25.745 27.4716 27.6449ZM24.9 27.6449C24.9 27.17 24.5162 26.7849 24.0428 26.7849C23.5695 26.7849 23.1856 27.17 23.1856 27.6449C23.1856 28.1198 23.5695 28.5049 24.0428 28.5049C24.5162 28.5049 24.9 28.1198 24.9 27.6449Z"
                                                                fill="currentColor"/>
                                                        </svg>
                                                        {{ __('common.Download') }}
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0)" class="theme-btn bg-btn-secondary">
                                                        <svg width="31" height="32" viewBox="0 0 31 32" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M0.898438 2.27486C0.898438 1.56242 1.47412 0.984863 2.18424 0.984863H3.14132C4.7708 0.984863 5.74645 2.08393 6.30436 3.10561C6.67623 3.78664 6.94526 4.57653 7.15568 5.29166C7.21267 5.28717 7.27041 5.28486 7.3288 5.28486H28.7541C30.1774 5.28486 31.2052 6.65127 30.815 8.02448L27.6814 19.0481C27.104 21.08 25.2535 22.4811 23.1477 22.4811H12.9503C10.827 22.4811 8.96571 21.0571 8.40378 19.0029L7.1 14.2366L4.94226 6.92881L4.93876 6.91601C4.67183 5.93934 4.4213 5.02695 4.04904 4.34523C3.68752 3.6832 3.39935 3.56486 3.14132 3.56486H2.18424C1.47412 3.56486 0.898438 2.98731 0.898438 2.27486ZM9.59529 13.6102L10.8837 18.3201C11.1391 19.2538 11.9851 19.9011 12.9503 19.9011H23.1477C24.1049 19.9011 24.946 19.2642 25.2086 18.3407L28.1862 7.86487H7.90259L9.57168 13.5182C9.58073 13.5488 9.58858 13.5794 9.59529 13.6102ZM15.4708 27.6449C15.4708 29.5448 13.9357 31.0849 12.042 31.0849C10.1484 31.0849 8.61323 29.5448 8.61323 27.6449C8.61323 25.745 10.1484 24.2049 12.042 24.2049C13.9357 24.2049 15.4708 25.745 15.4708 27.6449ZM12.8992 27.6449C12.8992 27.17 12.5154 26.7849 12.042 26.7849C11.5686 26.7849 11.1848 27.17 11.1848 27.6449C11.1848 28.1198 11.5686 28.5049 12.042 28.5049C12.5154 28.5049 12.8992 28.1198 12.8992 27.6449ZM27.4716 27.6449C27.4716 29.5448 25.9365 31.0849 24.0428 31.0849C22.1491 31.0849 20.614 29.5448 20.614 27.6449C20.614 25.745 22.1491 24.2049 24.0428 24.2049C25.9365 24.2049 27.4716 25.745 27.4716 27.6449ZM24.9 27.6449C24.9 27.17 24.5162 26.7849 24.0428 26.7849C23.5695 26.7849 23.1856 27.17 23.1856 27.6449C23.1856 28.1198 23.5695 28.5049 24.0428 28.5049C24.5162 28.5049 24.9 28.1198 24.9 27.6449Z"
                                                                fill="currentColor"/>
                                                        </svg>
                                                        {{ __('common.Enrolled') }}
                                                    </a>
                                                @endif
                                            @else
                                                <a href="javascript:void(0)" class="theme-btn addToCart"
                                                   id="courseCartBtn{{ $course->id }}">
                                                    <i data-feather="shopping-bag"></i>
                                                    {{ __('frontend.Add To Cart') }}
                                                </a>
                                            @endif
                                        @else
                                            <a href="javascript:void(0)" class="theme-btn addToCart"
                                               id="courseCartBtn{{ $course->id }}">
                                                <i data-feather="shopping-bag"></i>
                                                {{ __('frontend.Add To Cart') }}
                                            </a>
                                        @endif
                                    @else
                                        <a href="javascript:void(0)" class="theme-btn"
                                           id="courseCartBtn{{ $course->id }}">
                                            <i data-feather="shopping-bag"></i>
                                            {{ __('frontend.Out of Stock') }}
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="shop-info">
                    <div class="course-details-info bg-white mb-0">
                        <ul class="nav nav-pills rounded-0">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#overview"
                                        type="button" aria-selected="true"
                                        aria-controls="overview">{{ __('product.Description') }}</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#curriculum" type="button"
                                        aria-selected="false"
                                        aria-controls="curriculum">{{ __('frontend.Additional Information') }}</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" href="#instructor" type="button"
                                        aria-selected="false"
                                        aria-controls="instructor">{{ __('frontend.Reviews') }}</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" role="tabpanel" id="overview">
                                <div class="shop-info-card">
                                    <p>{!! $course->product?->description !!}</p>
                                </div>
                                @if (!Settings('hide_social_share_btn') == '1')
                                    <div class="social_btns">
                                        <a target="_blank"
                                           href="https://www.facebook.com/sharer/sharer.php?u={{ URL::current() }}"
                                           class="social_btn fb_bg"> <i class="fab fa-facebook-f"></i>
                                            {{ __('frontend.Facebook') }} </a>
                                        <a target="_blank"
                                           href="https://twitter.com/intent/tweet?text={{ $course->title }}&amp;url={{ URL::current() }}"
                                           class="social_btn Twitter_bg"> <i class="fab fa-twitter"></i>
                                            {{ __('frontend.Twitter') }}</a>
                                        <a target="_blank"
                                           href="https://pinterest.com/pin/create/link/?url={{ URL::current() }}&amp;description={{ $course->title }}"
                                           class="social_btn Pinterest_bg"> <i class="fab fa-pinterest-p"></i>
                                            {{ __('frontend.Pinterest') }}
                                        </a>
                                        <a target="_blank"
                                           href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{ URL::current() }}&amp;title={{ $course->title }}&amp;summary={{ $course->title }}"
                                           class="social_btn Linkedin_bg"> <i class="fab fa-linkedin-in"></i>
                                            {{ __('frontend.Linkedin') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" role="tabpanel" id="curriculum">
                                <div class="shop-info-card w-50">
                                    <p>{!! @$course->product?->specification !!}</p>
                                </div>
                                <div class="shop-info-card w-50">
                                    <p>{!! @$course->product?->faq !!}</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="instructor" role="tabpanel">
                                <div class="shop-info-card course-rating mb-0">
                                    <h3>{{ __('product.Product Rating') }}</h3>
                                    <div class="d-flex align-items-center flex-wrap">
                                        <div class="course-rating-count text-center">
                                            <h4 class="text-primary mb-1 lh-1">{{ $course->total_rating }}</h4>
                                            <div class="star text-orange">
                                                @php
                                                    $main_stars = $course->total_rating;
                                                    $stars = intval($main_stars);
                                                @endphp
                                                @for ($i = 0; $i < $stars; $i++)
                                                    <i class="fa fa-star"></i>
                                                @endfor
                                                @if ($main_stars > $stars)
                                                    <i class="fa fa-star-half-alt"></i>
                                                @endif
                                                @if ($main_stars == 0)
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <i class="fa fa-star"></i>
                                                    @endfor
                                                @endif


                                            </div>
                                            <p class="fw-500">{{ __('product.Product Rating') }}</p>
                                        </div>
                                        <div class="right flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar"
                                                         aria-valuenow="{{ getPercentageRating($course->starWiseReview, 5) }}"
                                                         aria-valuemin="0" aria-valuemax="100"
                                                         style="width: {{ getPercentageRating($course->starWiseReview, 5) }}%;">
                                                    </div>
                                                </div>
                                                <div
                                                    class="star me-auto d-flex align-items-center justify-content-between">
                                                    <span class="rating fs-14 text-orange d-flex">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                    </span>
                                                    <span
                                                        class="fs-14">({{ getPercentageRating($course->starWiseReview, 5) }}%)</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar"
                                                         aria-valuenow="{{ getPercentageRating($course->starWiseReview, 4) }}"
                                                         aria-valuemin="0" aria-valuemax="100"
                                                         style="width: {{ getPercentageRating($course->starWiseReview, 4) }}%;">
                                                    </div>
                                                </div>
                                                <div
                                                    class="star me-auto d-flex align-items-center justify-content-between">
                                                    <span class="rating four fs-14 text-orange d-flex">
                                                                <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star empty"></i>
                                                    </span>
                                                    <span
                                                        class="fs-14">({{ getPercentageRating($course->starWiseReview, 4) }}%)</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar"
                                                         aria-valuenow="{{ getPercentageRating($course->starWiseReview, 3) }}"
                                                         aria-valuemin="0" aria-valuemax="100"
                                                         style="width: {{ getPercentageRating($course->starWiseReview, 3) }}%;">
                                                    </div>
                                                </div>
                                                <div
                                                    class="star me-auto d-flex align-items-center justify-content-between">
                                                    <span class="rating three fs-14 text-orange d-flex">
                                                             <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star empty"></i>
                                                                    <i class="fas fa-star empty"></i>
                                                    </span>
                                                    <span
                                                        class="fs-14">({{ getPercentageRating($course->starWiseReview, 3) }}%)</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar"
                                                         aria-valuenow="{{ getPercentageRating($course->starWiseReview, 2) }}"
                                                         aria-valuemin="0" aria-valuemax="100"
                                                         style="width: {{ getPercentageRating($course->starWiseReview, 2) }}%;">
                                                    </div>
                                                </div>
                                                <div
                                                    class="star me-auto d-flex align-items-center justify-content-between">
                                                    <span class="rating two fs-14 text-orange d-flex">
                                                             <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star empty"></i>
                                                                    <i class="fas fa-star empty"></i>
                                                                    <i class="fas fa-star empty"></i>
                                                    </span>
                                                    <span
                                                        class="fs-14">({{ getPercentageRating($course->starWiseReview, 2) }}%)</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar"
                                                         aria-valuenow="{{ getPercentageRating($course->starWiseReview, 1) }}"
                                                         aria-valuemin="0" aria-valuemax="100"
                                                         style="width: {{ getPercentageRating($course->starWiseReview, 1) }}%;">
                                                    </div>
                                                </div>
                                                <div
                                                    class="star me-auto d-flex align-items-center justify-content-between">
                                                    <span class="rating two fs-14 text-orange d-flex">
                                                   <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star empty"></i>
                                                                    <i class="fas fa-star empty"></i>
                                                                    <i class="fas fa-star empty"></i>
                                                                    <i class="fas fa-star empty"></i>
                                                    </span>
                                                    <span
                                                        class="fs-14">({{ getPercentageRating($course->starWiseReview, 1) }}%)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="course_review_header mb_20">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <div class="review_poients">
                                                    @if ($course->reviews->count() < 1)
                                                        @if (Auth::check() && $isEnrolled)
                                                            <p class="theme_color font_16 mb-0">
                                                                {{ __('frontend.Be the first reviewer') }}</p>
                                                        @else
                                                            <p class="theme_color font_16 mb-0">
                                                                {{ __('frontend.No Review found') }}</p>
                                                        @endif
                                                    @else
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="rating_star text-end">

                                                    @php
                                                        $PickId = $course->id;
                                                    @endphp
                                                     @if (Auth::check() && Auth::user()->role_id == 3)
                                                        @if ((!in_array(Auth::user()->id, $reviewer_user_ids) && $reviewPermission > 0))
                                                            <div
                                                                class="star_icon d-flex align-items-center justify-content-end">
                                                                <a class="rating">
                                                                    <input type="radio" id="star5"
                                                                           name="rating" value="5"
                                                                           class="rating"/><label class="full"
                                                                                                  for="star5" id="star5"
                                                                                                  title="Awesome - 5 stars"
                                                                                                  onclick="Rates(5, {{ @$PickId }})"></label>

                                                                    <input type="radio" id="star4"
                                                                           name="rating" value="4"
                                                                           class="rating"/><label class="full"
                                                                                                  for="star4"
                                                                                                  title="Pretty good - 4 stars"
                                                                                                  onclick="Rates(4, {{ @$PickId }})"></label>

                                                                    <input type="radio" id="star3"
                                                                           name="rating" value="3"
                                                                           class="rating"/><label class="full"
                                                                                                  for="star3"
                                                                                                  title="Meh - 3 stars"
                                                                                                  onclick="Rates(3, {{ @$PickId }})"></label>

                                                                    <input type="radio" id="star2"
                                                                           name="rating" value="2"
                                                                           class="rating"/><label class="full"
                                                                                                  for="star2"
                                                                                                  title="Kinda bad - 2 stars"
                                                                                                  onclick="Rates(2, {{ @$PickId }})"></label>

                                                                    <input type="radio" id="star1"
                                                                           name="rating" value="1"
                                                                           class="rating"/><label class="full"
                                                                                                  for="star1"
                                                                                                  title="Bad  - 1 star"
                                                                                                  onclick="Rates(1,{{ @$PickId }})"></label>

                                                                </a>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <p class="font_14 f_w_400 mt-0"><a href="{{ url('login') }}"
                                                                                           class="theme_color2">{{ __('frontend.Sign In') }}</a>
                                                            {{ __('frontend.or') }} <a class="theme_color2"
                                                                                       href="{{ url('register') }}">{{ __('frontend.Sign Up') }}</a>
                                                            {{ __('frontend.as student to post a review') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="course_cutomer_reviews">
                                        <div class="details_title">
                                            <h3>
                                                {{__('frontend.Student Feedback')}}
                                            </h3>

                                        </div>
                                        <div class="customers_reviews" id="customers_reviews">

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal cs_modal fade admin-query" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('frontend.Review') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="ti-close "></i></button>
                </div>

                <form action="{{ route('submitReview') }}" method="Post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="course_id" id="rating_course_id" value="">
                        <input type="hidden" name="rating" id="rating_value" value="">


                        <textarea class="w-100" name="review" name="" id=""
                                  placeholder="{{ __('frontend.Write your review') }}" cols="30"
                                  rows="10">{{ old('review') }}</textarea>
                        <span class="text-danger" role="alert">{{ $errors->first('review') }}</span>


                    </div>
                    <div class="modal-footer justify-content-center">
                        <div class="mt-40">
                            <button type="button" class="theme_line_btn me-2"
                                    data-bs-dismiss="modal">{{ __('common.Cancel') }}
                            </button>
                            <button class="theme_btn " type="submit">{{ __('common.Submit') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

</section>
<!-- Product Details:End -->
<input type="hidden" id="stock_manage" value="{{ $course->stock_manage }}">
<input type="hidden" id="stock_quantity" value="{{ $course->stock_quantity }}">
<input type="hidden" id="selected_attribute_values" value="">
<input type="hidden" id="selected_sku_id" value="">

<script>
    (function () {
        'use strict'

        function loadPrice() {
            let selectAttributeValues = $('.selectedAttributeValue:checked').map(function () {
                return $(this).val();
            }).get();
            $('#selected_attribute_values').val(selectAttributeValues);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('get_product_sku_wise_price') }}",
                data: {
                    product_id: "{{ $course->product->id }}",
                    attribute_values: selectAttributeValues
                },
                success: function (data) {
                    $('.priceTag').html(data.price);
                    $('#selected_sku_id').val(data.sku_id);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });

        }

        jQuery(document).ready(function () {
            let url = $('#baseUrl').val();

            @if($course->product->has_variant)
            loadPrice();
            @endif

            function updateCart() {
                let total = $('#total_qty').val();
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "{{ route('update_product_qty_in_cart') }}",
                    data: {
                        course_id: "{{ $course->id }}",
                        total: total
                    },
                    success: function (data) {
                        if (data.success) {
                            toastr.success("{{__('store.Cart updated successfully')}}");
                        }
                    },
                    error: function (data) {
                        {{--                        toastr.info("{{__('store.Cart updated successfully')}}");--}}
                    }
                });
            }

            $(document).on('click', '.qtyPlus', function (event) {
                event.preventDefault();
                const value = $("#total_qty").val();
                const stock_manage = $("#stock_manage").val();
                const stock_quantity = $("#stock_quantity").val();
                if (stock_manage == 1) {
                    if (stock_quantity > parseInt(value)) {
                        $('#total_qty').val(parseInt(value) + 1);
                    } else {
                        toastr.error("{{__('store.Out of Stock')}}");
                    }
                } else {
                    $('#total_qty').val(parseInt(value) + 1);
                    updateCart();
                }

            });

            $(document).on('click', '.selectedAttributeValue', function () {
                loadPrice();
            });
            $(document).on('click', '.qtyMinus', function (event) {
                event.preventDefault();
                const value = $("#total_qty").val();
                if (value <= 1) {
                    toastr.error("{{__('store.Minimum Quantity Limit is 1')}}");
                } else {
                    $('#total_qty').val(parseInt(value) - 1);
                    updateCart();

                }
            });
            $(document).on('click', '.addToCart', function () {
                var qty = $('#total_qty').val();
                window.location = url + '/addToCart/{{ @$course->id }}/' + qty + '?attribute_values=' + $('#selected_attribute_values').val() + '&sku_id=' + $('#selected_sku_id').val();
            });
            $(document).on('click', '.buyNow', function () {
                var qty = $('#total_qty').val();
                window.location = url + '/buyNow/{{ @$course->id }}/' + qty + '?attribute_values=' + $('#selected_attribute_values').val() + '&sku_id=' + $('#selected_sku_id').val();
            });
            $('#preview-img').ezPlus({
                zoomWindowFadeIn: 500,
                zoomLensFadeIn: 500,
                gallery: 'shop-gallery',
                imageCrossfade: false,
                zoomWindowOffsetX: 10,
                scrollZoom: false,
                cursor: 'pointer',
            });

            function Rates(val, id) {
                document.getElementById('rating_course_id').value = id;
                document.getElementById('rating_value').value = val;
                $("#myModal").modal();
            }

        })
    })();
</script>
