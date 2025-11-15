@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('frontend.Bundle')}}
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/css/class_details.css')}}{{assetVersion()}}"/>
    <style>

        .lms_pricing_box .lms_pricing_head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            grid-gap: 15px;
            padding: 25.5px 25px 26.5px 40px;
            border-bottom: 1px solid #ebebeb;
            flex-wrap: wrap
        }

        .lms_pricing_box .lms_pricing_head h3 {
            font-size: 30px;
            font-weight: 900
        }

        .lms_pricing_box .lms_pricing_body .single_list {
            display: flex;
            justify-content: space-between;
            align-items: center;
            grid-gap: 15px;
            padding: 15px 25px;
            flex-wrap: wrap
        }

        .lms_pricing_box .lms_pricing_body .single_list:not(:last-child) {
            border-bottom: 1px solid #ebebeb
        }

        .lms_pricing_box .lms_pricing_head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            grid-gap: 15px;
            padding: 25.5px 25px 26.5px 40px;
            border-bottom: 1px solid #ebebeb;
            flex-wrap: wrap
        }

        .lms_pricing_box .lms_pricing_head h3 {
            font-size: 30px;
            font-weight: 900
        }

        .package_widget .package_footer {
            padding: 15px 25px 15px
        }

        .package_widget .package_footer .theme_btn.small_btn2 {
            padding: 13.5px 22px
        }

        .package_widget .package_footer .prise_tag h4 {
            font-size: 18px;
            font-weight: 900;
            color: var(--system_primery_color);
            margin-bottom: 0;
            line-height: 1;
            text-align: right
        }

        .package_widget .package_footer .prise_tag h4 span {
            text-decoration: line-through;
            color: #687083
        }

        .package_widget .package_footer .prise_tag p {
            font-size: 14px;
            font-weight: 600;
            font-family: var(--font_family1), sans-serif;
            color: #687083;
            margin-bottom: 5px
        }

        .gray-bg,
        .lms_pricing_box .lms_pricing_body {
            background: #fafafa
        }

        .lms_pricing_box {
            border: 1px solid #ebebeb;
        }

        .white_btn2 {
            background: rgba(251, 17, 89, .1);
            border-radius: 5px;
            font-family: var(--font_family2), sans-serif;
            font-size: 16px;
            color: var(--system_primery_color);
            font-weight: 600;
            padding: 13.5px 26px;
            border: 1px solid transparent;
            text-transform: capitalize;
            display: inline-block;
            line-height: 1;
        }
    </style>

@endsection


@section('mainContent')

    <x-breadcrumb :banner="trans('common.N/A')"
                  :title="trans('frontend.Explore Our Course Bundles')"
                  :subTitle="trans('frontend.Bundle Details')"/>

    <div class="pricing_area section_padding">
        <div class="container">

            <div class="row">
                <div class="col-xl-9 offset-xl-1">

                    <div class="lms_pricing_box mb_25">
                        <div class="lms_pricing_head">
                            <h3>{{$course->title }}</h3>

                            @if($course->course->count() > 0)

                                @php
                                    $enroll = \Modules\CourseSetting\Entities\CourseEnrolled::where('user_id',Auth::id())->where('bundle_course_id',$course->id)->first()
                                @endphp

                                <div class="show-button d-flex">
                                    <div class="package_widget">
                                        <div class="package_footer">
                                            <div class="prise_tag">
                                                <h4> {{getPriceFormat((int)$course->price)}} </h4>
                                            </div>
                                        </div>
                                    </div>

                                    @if(!$enroll)
                                        <a href="{{route('bundle.cart',['bundle_id'=>$course->id])}}"
                                           class="theme_btn small_btn5">{{ __('common.Buy Now') }}</a>
                                    @else
                                        <a href="{{route('student.dashboard')}}"
                                           class="theme_btn small_btn5">{{ __('common.Continue Watch') }}</a>
                                    @endif
                                </div>

                            @endif

                        </div>
                        <div class="lms_pricing_body">


                            @if($course->course->count() > 0)
                                @foreach($course->course as $key => $bundleCourse)

                                    <div class="single_list">
                                        <p>{{ ++$key }}. {{ $bundleCourse->course->title }}</p>
                                        <a href="{{ route('courseDetailsView', [$bundleCourse->course->slug] )}}"
                                           class="theme_line_btn small_btn3">{{__('bundleSubscription.View Details')}}</a>
                                    </div>
                                @endforeach
                            @else
                                <div class="card">
                                    <div class="card-header">
                                        <div class="dd-handle">
                                            <div
                                                class="text-center text-danger"> {{ __('bundleSubscription.No course found') }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                        </div>
                    </div>
                    <a href="#"
                       class="white_btn2">{{ __('bundleSubscription.Course Duration') }} {{$course->days !== '' && $course->days!=0 ? $course->days.' '.trans('Days') : trans('bundleSubscription.Life Time')}} </a>

                    @if($course->about)
                        <br><br><br>
                        <h4 class="font_22 f_w_700">{{__('bundleSubscription.Bundle Description')}}</h4>
                        <hr>
                        <p>{{$course->about}}</p>
                    @endif
                    @if(Settings('show_review_for_bundle_subscription'))
                        <br> <br> <br> <br> <br> <br>
                        <div class="row justify-content-center">
                            <div class="col-xl-8 col-lg-8">
                                <div class="course_review_wrapper">
                                    <div class="details_title">
                                        <h4 class="font_22 f_w_700">{{__('frontend.Student Feedback')}}</h4>
                                        <p class="font_16 f_w_400">{{$course->title}}</p>
                                    </div>

                                    <div class="course_feedback">
                                        <div class="course_feedback_left">
                                            <h2>{{$course->reviews->sum('star')}}</h2>
                                            <div class="feedmak_stars">
                                                @php

                                                    $main_stars=$course->reviews->avg('star');

                                                    $stars=intval($course->reviews->sum('star'));

                                                @endphp
                                                @for ($i = 0; $i <  $stars; $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                                @if ($main_stars>$stars)
                                                    <i class="fas fa-star-half"></i>
                                                @endif
                                                @if($main_stars==0)
                                                    @for ($i = 0; $i <  5; $i++)
                                                        <i class="far fa-star"></i>
                                                    @endfor
                                                @endif
                                            </div>
                                            <span>{{__('frontend.Course Rating')}}</span>
                                        </div>

                                        <div class="feedbark_progressbar">
                                            <div class="single_progrssbar">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar"
                                                         style="width: {{getPercentageRating($course->starWiseReview,5)}}%"
                                                         aria-valuenow="{{getPercentageRating($course->starWiseReview,5)}}"
                                                         aria-valuemin="0" aria-valuemax="100">


                                                    </div>
                                                </div>
                                                <div class="rating_percent d-flex align-items-center">
                                                    <div class="feedmak_stars d-flex align-items-center">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                    <span>{{getPercentageRating($course->starWiseReview,5)}}%</span>
                                                </div>
                                            </div>
                                            <div class="single_progrssbar">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar"
                                                         style="width: {{getPercentageRating($course->starWiseReview,4)}}%"
                                                         aria-valuenow="{{getPercentageRating($course->starWiseReview,4)}}"
                                                         aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <div class="rating_percent d-flex align-items-center">
                                                    <div class="feedmak_stars d-flex align-items-center">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <span>{{getPercentageRating($course->starWiseReview,4)}}%</span>
                                                </div>
                                            </div>
                                            <div class="single_progrssbar">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar"
                                                         style="width: {{getPercentageRating($course->starWiseReview,3)}}%"
                                                         aria-valuenow="{{getPercentageRating($course->starWiseReview,3)}}"
                                                         aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <div class="rating_percent d-flex align-items-center">
                                                    <div class="feedmak_stars d-flex align-items-center">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                        <i class="far fa-star"></i>

                                                    </div>
                                                    <span>{{getPercentageRating($course->starWiseReview,3)}}%</span>
                                                </div>
                                            </div>
                                            <div class="single_progrssbar">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar"
                                                         style="width: {{getPercentageRating($course->starWiseReview,2)}}%"
                                                         aria-valuenow="{{getPercentageRating($course->starWiseReview,2)}}"
                                                         aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <div class="rating_percent d-flex align-items-center">
                                                    <div class="feedmak_stars d-flex align-items-center">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <span>{{getPercentageRating($course->starWiseReview,2)}}%</span>
                                                </div>
                                            </div>
                                            <div class="single_progrssbar">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar"
                                                         style="width: {{getPercentageRating($course->starWiseReview,1)}}%"
                                                         aria-valuenow="{{getPercentageRating($course->starWiseReview,1)}}"
                                                         aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <div class="rating_percent d-flex align-items-center">
                                                    <div class="feedmak_stars d-flex align-items-center">
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <span>{{getPercentageRating($course->starWiseReview,1)}}%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="course_review_header mb_20">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <div class="review_poients">
                                                    @if ($course->reviews->count()<1)
                                                        @if (Auth::check() && $isEnrolled)
                                                            <p class="theme_color font_16 mb-0">{{ __('frontend.Be the first reviewer') }}</p>
                                                        @else

                                                            <p class="theme_color font_16 mb-0">{{ __('frontend.No Review found') }}</p>
                                                        @endif

                                                    @else

                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="rating_star text-end">

                                                    @php
                                                        $PickId=$course->id
                                                    @endphp
                                                    @if (Auth::check())
                                                        @if(Auth::user()->role_id==3)
                                                            @if (!in_array(Auth::user()->id,$reviewer_user_ids) && $isEnrolled)

                                                                <div
                                                                    class="star_icon d-flex align-items-center justify-content-end">
                                                                    <a class="rating">
                                                                        <input type="radio" id="star5" name="rating"
                                                                               value="5"
                                                                               class="rating"/><label
                                                                            class="full" for="star5" id="star5"
                                                                            title="Awesome - 5 stars"
                                                                            onclick="Rates(5, {{@$PickId }})"></label>

                                                                        <input type="radio" id="star4" name="rating"
                                                                               value="4"
                                                                               class="rating"/><label
                                                                            class="full" for="star4"
                                                                            title="Pretty good - 4 stars"
                                                                            onclick="Rates(4, {{@$PickId }})"></label>

                                                                        <input type="radio" id="star3" name="rating"
                                                                               value="3"
                                                                               class="rating"/><label
                                                                            class="full" for="star3"
                                                                            title="Meh - 3 stars"
                                                                            onclick="Rates(3, {{@$PickId }})"></label>

                                                                        <input type="radio" id="star2" name="rating"
                                                                               value="2"
                                                                               class="rating"/><label
                                                                            class="full" for="star2"
                                                                            title="Kinda bad - 2 stars"
                                                                            onclick="Rates(2, {{@$PickId }})"></label>

                                                                        <input type="radio" id="star1" name="rating"
                                                                               value="1"
                                                                               class="rating"/><label
                                                                            class="full" for="star1"
                                                                            title="Bad  - 1 star"
                                                                            onclick="Rates(1,{{@$PickId }})"></label>

                                                                    </a>
                                                                </div>

                                                            @endif
                                                        @endif

                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="course_cutomer_reviews">
                                        <div class="details_title">
                                            <h4 class="font_22 f_w_700">{{__('frontend.Reviews')}}</h4>

                                        </div>

                                        @foreach($course->reviews as $review)

                                            <div class="customers_reviews">
                                                <div class="customers_reviews">
                                                    <div class="single_reviews">


                                                        @if(reviewCanDelete($review->user_id,$course->user_id))
                                                            <div class="thumb link">
                                                                {{substr($review->user->name, 0, 1)}}
                                                                <a class="deleteBtn pe-0"
                                                                   href="{{ route('delete.bundle.review',$review->id)}}">
                                                                    <svg class="delete_svg_icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M21 5.98047C17.67 5.65047 14.32 5.48047 10.98 5.48047C9 5.48047 7.02 5.58047 5.04 5.78047L3 5.98047" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                        <path d="M8.5 4.97L8.72 3.66C8.88 2.71 9 2 10.69 2H13.31C15 2 15.13 2.75 15.28 3.67L15.5 4.97" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                        <path d="M18.8484 9.13965L18.1984 19.2096C18.0884 20.7796 17.9984 21.9996 15.2084 21.9996H8.78844C5.99844 21.9996 5.90844 20.7796 5.79844 19.2096L5.14844 9.13965" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                        <path d="M10.3281 16.5H13.6581" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                        <path d="M9.5 12.5H14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                        @endif


                                                        <div class="review_content"><h4
                                                                class="f_w_700">{{$review->user->name}}</h4>
                                                            <div class="rated_customer d-flex align-items-center">
                                                                <div class="feedmak_stars">
                                                                    @for($x = 0; $x < $review->star; $x++ )
                                                                        <i class="fas fa-star"></i>
                                                                    @endfor

                                                                </div>
                                                                <span>{{ $review->updated_at->diffForHumans() }}</span>
                                                            </div>
                                                            <p class="text-start"> {{$review->comment}} </p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div class="modal cs_modal fade admin-query" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('bundleSubscription.Bundle Review') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <form action="{{route('submit.bundle.review')}}" method="Post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="bundle_id" id="rating_course_id"
                               value="">
                        <input type="hidden" name="rating" id="rating_value" value="">

                        <div class="text-center">
                                                                <textarea class="lms_summernote" name="review" name=""
                                                                          id=""
                                                                          placeholder="{{__('frontend.Write your review') }}"
                                                                          cols="30"
                                                                          rows="10">{{old('review')}}</textarea>
                            <span class="text-danger" role="alert">{{$errors->first('review')}}</span>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-center">
                        <div class="mt-40">
                            <button type="button" class="theme_line_btn me-2"
                                    data-bs-dismiss="modal">{{ __('common.Cancel') }}
                            </button>
                            <button class="theme_btn "
                                    type="submit">{{ __('common.Submit') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal cs_modal fade admin-query" id="deleteReview" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('common.Delete Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <form action="" id="deleteReviewForm" method="Post">
                    <div class="modal-body">
                        @csrf
                        {{__('common.Are you sure to delete ?')}}
                    </div>
                    <div class="modal-footer justify-content-center">
                        <div class="mt-40">
                            <button type="button" class="theme_line_btn me-2 small_btn2"
                                    data-bs-dismiss="modal">{{ __('common.Cancel') }}
                            </button>
                            <a class="theme_btn  small_btn2"
                               href="#" id="formSubmitBtn">{{ __('common.Submit') }}</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection


@section('js')

    <script>
        $(".deleteBtn").click(function (e) {
            e.preventDefault();
            var url = $(".deleteBtn").attr('href');
            $('#deleteReview').modal('show')
            $('#formSubmitBtn').attr('href', url)
        });
    </script>
    <script src="{{asset('public/frontend/infixlmstheme/js/class_details.js')}}"></script>

@endsection


