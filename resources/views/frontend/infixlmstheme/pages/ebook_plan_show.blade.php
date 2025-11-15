@extends(theme('layouts.master'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'Infix LMS' }} | {{ __('membership.Ebook Plan') }}
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme/css/class_details.css') }}{{assetVersion()}}"/>
@endsection


@section('mainContent')
    <x-breadcrumb :banner="$frontendContent->course_page_banner" :title="trans('frontend.All About Your Selected Ebook')"
                  :subTitle="trans('frontend.Ebook')"/>

    <div class="pricing_area section_padding">
        <div class="container">

            <div class="row">
                <div class="col-xl-9 offset-xl-1">

                    <div class="lms_pricing_box mb_25">
                        <div class="lms_pricing_head">
                            <h3>{{ $ebookPlan->title }}</h3>

                            @if ($ebookPlan->ebooks->count() > 0)
                                <div class="show-button d-flex">
                                    <div class="package_widget">
                                        <div class="package_footer">
                                            <div class="prise_tag">
                                                <h4> {{ getPriceFormat((int) $ebookPlan->price) }} </h4>
                                            </div>
                                        </div>
                                    </div>
                                    @if (!auth()->user() || !$ebookPlan->checkout)
                                        <form action="{{ route('ebookPlanCheckout') }}">
                                            <input type="hidden" name="plan" value="{{ $ebookPlan->id }}">
                                            <button type="submit" class="theme_btn small_btn2 payment-link">
                                                {{ __('common.Buy Now') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif

                        </div>
                        <div class="lms_pricing_body">


                            @if ($ebookPlan->ebooks->count() > 0)
                                @foreach ($ebookPlan->ebooks as $key => $ebook)
                                    <div class="single_list">
                                        <p>{{ ++$key }}. {{ $ebook->ebook->name }}</p>
                                        <a href="" class="theme_line_btn small_btn3">View Details</a>
                                    </div>
                                @endforeach
                            @else
                                <div class="card">
                                    <div class="card-header">
                                        <div class="dd-handle">
                                            <div class="text-center text-danger">
                                                {{ __('bundleSubscription.No course found') }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <a href="#" class="white_btn2">{{ __('Ebook Duration') }}
                        {{ $ebookPlan->days !== '' && $ebookPlan->days != 0 ? $ebookPlan->days . ' ' . trans('Days') : 'Life Time' }}
                    </a>

                    @if ($ebookPlan->about)
                        <br><br><br>
                        <h4 class="font_22 f_w_700">{{ __('membership.Ebook Plan Description') }}</h4>
                        <hr>
                        <p>{{ $ebookPlan->about }}</p>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="ti-close "></i></button>
                </div>

                <form action="{{ route('submit.bundle.review') }}" method="Post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="bundle_id" id="rating_course_id" value="">
                        <input type="hidden" name="rating" id="rating_value" value="">

                        <div class="text-center">
                            <textarea class="lms_summernote" name="review" name="" id=""
                                      placeholder="{{ __('frontend.Write your review') }}" cols="30"
                                      rows="10">{{ old('review') }}</textarea>
                            <span class="text-danger" role="alert">{{ $errors->first('review') }}</span>
                        </div>


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

    <div class="modal cs_modal fade admin-query" id="deleteReview" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('common.Delete Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="ti-close "></i></button>
                </div>

                <form action="" id="deleteReviewForm" method="Post">
                    <div class="modal-body">
                        @csrf
                        {{ __('common.Are you sure to delete ?') }}
                    </div>
                    <div class="modal-footer justify-content-center">
                        <div class="mt-40">
                            <button type="button" class="theme_line_btn me-2 small_btn2"
                                    data-bs-dismiss="modal">{{ __('common.Cancel') }}
                            </button>
                            <a class="theme_btn  small_btn2" href="#"
                               id="formSubmitBtn">{{ __('common.Submit') }}</a>
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
    <script src="{{ asset('public/frontend/infixlmstheme/js/class_details.js') }}"></script>
@endsection
