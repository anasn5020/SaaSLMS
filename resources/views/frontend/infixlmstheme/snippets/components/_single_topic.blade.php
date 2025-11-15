@if(isset($result))
    @php
        $total =0;
        $courses =[];
        foreach ($result as $key => $value) {
            if ($value->discount_price!=null){
                $price=(int)$value->discount_price;
            }else{
                $price=(int)$value->price;
            }

            if ((request()->get('price')=='paid' && $price==0) || (request()->get('price')=='free' && $price!=0)){
                continue;
            }
            $total++;
            $courses[] = $value;
        }
    @endphp
    <div class="row row-gap-24">

        <div class="col-12">
            <div class="box_header d-flex flex-wrap align-items-center justify-content-between">
                <h5 class="font_16 f_w_500 mb-0">{{translatedNumber($total)}}
                    @if(Route::current()->getName() == 'courses')
                        {{__('frontend.Courses are found')}}
                    @elseif(Route::current()->getName() == 'quizzes')
                        {{__('frontend.Quizzes are found')}}
                    @elseif(Route::current()->getName() == 'classes')
                        {{__('frontend.Classes are found')}}
                    @else
                        {{__('frontend.Topics are found')}}
                    @endif
                </h5>
                <div class="box_header_right">
                    <div class="short_select d-flex align-items-center">
                        <div class="mobile_filter mr_10">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19.5" height="13"
                                 viewBox="0 0 19.5 13">
                                <g transform="translate(28)">
                                    <rect id="" data-name="Rectangle 1" width="19.5"
                                          height="2" rx="1"
                                          transform="translate(-28)"
                                          fill="var(--system_primery_color)"/>
                                    <rect id="" data-name="Rectangle 2" width="15.5"
                                          height="2" rx="1"
                                          transform="translate(-26 5.5)"
                                          fill="var(--system_primery_color)"/>
                                    <rect id="" data-name="Rectangle 3" width="5" height="2"
                                          rx="1"
                                          transform="translate(-20.75 11)"
                                          fill="var(--system_primery_color)"/>
                                </g>
                            </svg>
                        </div>
                        {{--                        <h5 class="mr_10 font_16 f_w_500 mb-0">{{__('frontend.Order By')}}:</h5>--}}
                        <select class="small_select" id="order">
                            <option value="" data-display="">{{__('frontend.None')}}</option>
                            <option
                                value="price" {{request('order')=="price"?'selected':''}}>{{__('frontend.Price')}}</option>
                            <option
                                value="created_at" {{request('order')=="created_at"?'selected':''}}>{{__('frontend.Date')}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        @forelse ($courses as $course)
            <div class="col-sm-6 col-xl-4">
                <div class="course-item">
                    <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                        <div class="course-item-img lazy">
                            <img src="{{ getCourseImage($course->thumbnail) }}" alt="">

                            @if($course->level)
                                <span class="course-tag">
                                <span>
                                    {{$course->courseLevel->title}}
                                </span>
                            </span>
                            @endif
                        </div>
                    </a>
                    <div class="course-item-info">
                        <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}" class="title"
                           title="{{$course->title}}">
                            {{$course->title}}
                        </a>
                        <div class="d-flex align-itemes-center justify-content-between meta">
                            <div class="rating">
                                <svg width="16" height="15" viewBox="0 0 16 15" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.9922 5.21624L10.2573 4.53056L8.1344 0.242104C8.09105 0.168678 8.02784 0.10754 7.9513 0.0649862C7.87476 0.0224321 7.78764 0 7.69892 0C7.6102 0 7.52308 0.0224321 7.44654 0.0649862C7.37 0.10754 7.3068 0.168678 7.26345 0.242104L5.14222 4.52977L0.40648 5.21624C0.31946 5.22916 0.237852 5.2645 0.170564 5.31841C0.103275 5.37231 0.0528901 5.44272 0.0249085 5.52194C-0.00307309 5.60116 -0.00757644 5.68614 0.01189 5.76762C0.0313563 5.8491 0.0740445 5.92394 0.135295 5.98398L3.57501 9.33111L2.76146 14.0591C2.74696 14.1436 2.75782 14.2304 2.79281 14.3094C2.8278 14.3883 2.88549 14.4564 2.95932 14.5058C3.03314 14.5551 3.12011 14.5838 3.2103 14.5886C3.30049 14.5933 3.39026 14.5739 3.46936 14.5325L7.6985 12.3153L11.9276 14.5333C12.0068 14.5746 12.0965 14.5941 12.1867 14.5893C12.2769 14.5846 12.3639 14.5559 12.4377 14.5066C12.5115 14.4572 12.5692 14.3891 12.6042 14.3101C12.6392 14.2311 12.6501 14.1444 12.6356 14.0599L11.822 9.3319L15.2634 5.98398C15.3253 5.92392 15.3685 5.84885 15.3883 5.76699C15.4082 5.68515 15.4039 5.59969 15.3758 5.52003C15.3478 5.44036 15.2972 5.36956 15.2295 5.31541C15.1618 5.26126 15.0797 5.22586 14.9922 5.21308V5.21624Z"
                                        fill="#FFC107"/>
                                </svg>
                                <span>{{translatedNumber($course->totalReview)}} ({{translatedNumber($course->total_reviews)}} {{__('common.Rating')}})</span>
                            </div>
                            <div class="enrolled-student">
                                @if(!Settings('hide_total_enrollment_count') == 1)
                                    <a href="#">
                                        <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.2508 3.87484L9.30078 1.0165C8.49245 0.549837 7.49245 0.549837 6.67578 1.0165L1.73411 3.87484C0.925781 4.3415 0.425781 5.20817 0.425781 6.14984V11.8498C0.425781 12.7832 0.925781 13.6498 1.73411 14.1248L6.68411 16.9832C7.49245 17.4498 8.49245 17.4498 9.30911 16.9832L14.2591 14.1248C15.0674 13.6582 15.5674 12.7915 15.5674 11.8498V6.14984C15.5591 5.20817 15.0591 4.34984 14.2508 3.87484ZM7.99245 5.1165C9.06745 5.1165 9.93411 5.98317 9.93411 7.05817C9.93411 8.13317 9.06745 8.99984 7.99245 8.99984C6.91745 8.99984 6.05078 8.13317 6.05078 7.05817C6.05078 5.9915 6.91745 5.1165 7.99245 5.1165ZM10.2258 12.8832H5.75911C5.08411 12.8832 4.69245 12.1332 5.06745 11.5748C5.63411 10.7332 6.73411 10.1665 7.99245 10.1665C9.25078 10.1665 10.3508 10.7332 10.9174 11.5748C11.2924 12.1248 10.8924 12.8832 10.2258 12.8832Z"
                                                fill="#292D32"/>
                                        </svg>
                                        {{translatedNumber($course->total_enrolled)}} {{__('frontend.Students')}}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="course-item-info-description">
                            {{ getLimitedText($course->about,120) }}
                        </div>

                        <div class="course-item-footer d-flex justify-content-between">
                            <x-price-tag :price="$course->price"
                                         :text="$course->price_text"
                                         :discount="$course->discount_price"/>

                            @if(!onlySubscription())
                                @auth()
                                    @if(!$course->isLoginUserEnrolled && !$course->isLoginUserCart)
                                        <a href="#" class="cart_store"
                                           data-id="{{$course->id}}">
                                            <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.16467 13.3359H18.8653C19.0059 13.3364 19.1428 13.2894 19.2551 13.202C19.3675 13.1146 19.4491 12.9917 19.4877 12.8519L22.0801 3.51851C22.1078 3.41929 22.1127 3.31476 22.0945 3.21323C22.0762 3.1117 22.0353 3.01597 21.975 2.93366C21.9143 2.85128 21.8361 2.78451 21.7464 2.73853C21.6566 2.69256 21.5579 2.66862 21.4577 2.6686H5.66957L5.20675 0.522304C5.17445 0.373931 5.09423 0.241358 4.97931 0.14642C4.86439 0.0514822 4.72163 -0.000159516 4.57453 3.70146e-07H0.645078C0.473992 3.70146e-07 0.309914 0.0702685 0.188939 0.195346C0.0679633 0.320424 0 0.490067 0 0.666954C0 0.843841 0.0679633 1.01348 0.188939 1.13856C0.309914 1.26364 0.473992 1.33391 0.645078 1.33391H4.05423L6.3933 12.1686C5.98505 12.3512 5.65023 12.6738 5.44536 13.082C5.24049 13.4902 5.17812 13.959 5.26877 14.4092C5.35942 14.8595 5.59754 15.2636 5.94294 15.5534C6.28834 15.8432 6.71986 16.0009 7.16467 15.9998H18.8653C19.0364 15.9998 19.2005 15.9296 19.3214 15.8045C19.4424 15.6794 19.5104 15.5098 19.5104 15.3329C19.5104 15.156 19.4424 14.9864 19.3214 14.8613C19.2005 14.7362 19.0364 14.6659 18.8653 14.6659H7.16467C6.99359 14.6659 6.82951 14.5957 6.70853 14.4706C6.58756 14.3455 6.51959 14.1759 6.51959 13.999C6.51959 13.8221 6.58756 13.6525 6.70853 13.5274C6.82951 13.4023 6.99359 13.332 7.16467 13.332V13.3359Z" fill="url(#paint0_linear_2677_3208)"/>
                                                <path d="M6.52262 18.0031C6.52322 18.3985 6.63716 18.7848 6.85005 19.1133C7.06294 19.4418 7.36524 19.6976 7.71872 19.8486C8.07221 19.9995 8.46104 20.0387 8.83607 19.9612C9.2111 19.8838 9.5555 19.6931 9.82577 19.4134C10.096 19.1336 10.28 18.7773 10.3545 18.3894C10.429 18.0016 10.3906 17.5996 10.2442 17.2343C10.0979 16.869 9.85003 16.5568 9.53207 16.3371C9.21411 16.1173 8.8403 16 8.45786 15.9998C7.94433 16.0003 7.45198 16.2115 7.08908 16.5872C6.72617 16.9628 6.52242 17.4721 6.52262 18.0031Z" fill="url(#paint1_linear_2677_3208)"/>
                                                <path d="M15.6513 18.0031C15.6519 18.3984 15.7657 18.7846 15.9785 19.113C16.1913 19.4415 16.4935 19.6974 16.8468 19.8484C17.2002 19.9993 17.5889 20.0387 17.9639 19.9614C18.3388 19.8841 18.6833 19.6937 18.9536 19.4142C19.224 19.1347 19.4082 18.7786 19.4829 18.3909C19.5576 18.0032 19.5196 17.6013 19.3735 17.236C19.2275 16.8706 18.98 16.5582 18.6623 16.3382C18.3447 16.1182 17.9711 16.0005 17.5888 15.9998C17.3343 15.9997 17.0823 16.0515 16.8472 16.1521C16.6121 16.2528 16.3984 16.4003 16.2185 16.5863C16.0386 16.7724 15.8959 16.9933 15.7985 17.2363C15.7012 17.4794 15.6512 17.74 15.6513 18.0031Z" fill="url(#paint2_linear_2677_3208)"/>
                                                <defs>
                                                    <linearGradient id="paint0_linear_2677_3208" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                    </linearGradient>
                                                    <linearGradient id="paint1_linear_2677_3208" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#660AFB"/>
                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                    </linearGradient>
                                                    <linearGradient id="paint2_linear_2677_3208" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#660AFB"/>
                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                    </linearGradient>
                                                </defs>
                                            </svg>

                                        </a>
                                    @endif
                                @endauth
                                @guest()
                                    @if(!$course->isGuestUserCart)
                                        <a href="#" class="cart_store"
                                           data-id="{{$course->id}}">
                                            <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.16467 13.3359H18.8653C19.0059 13.3364 19.1428 13.2894 19.2551 13.202C19.3675 13.1146 19.4491 12.9917 19.4877 12.8519L22.0801 3.51851C22.1078 3.41929 22.1127 3.31476 22.0945 3.21323C22.0762 3.1117 22.0353 3.01597 21.975 2.93366C21.9143 2.85128 21.8361 2.78451 21.7464 2.73853C21.6566 2.69256 21.5579 2.66862 21.4577 2.6686H5.66957L5.20675 0.522304C5.17445 0.373931 5.09423 0.241358 4.97931 0.14642C4.86439 0.0514822 4.72163 -0.000159516 4.57453 3.70146e-07H0.645078C0.473992 3.70146e-07 0.309914 0.0702685 0.188939 0.195346C0.0679633 0.320424 0 0.490067 0 0.666954C0 0.843841 0.0679633 1.01348 0.188939 1.13856C0.309914 1.26364 0.473992 1.33391 0.645078 1.33391H4.05423L6.3933 12.1686C5.98505 12.3512 5.65023 12.6738 5.44536 13.082C5.24049 13.4902 5.17812 13.959 5.26877 14.4092C5.35942 14.8595 5.59754 15.2636 5.94294 15.5534C6.28834 15.8432 6.71986 16.0009 7.16467 15.9998H18.8653C19.0364 15.9998 19.2005 15.9296 19.3214 15.8045C19.4424 15.6794 19.5104 15.5098 19.5104 15.3329C19.5104 15.156 19.4424 14.9864 19.3214 14.8613C19.2005 14.7362 19.0364 14.6659 18.8653 14.6659H7.16467C6.99359 14.6659 6.82951 14.5957 6.70853 14.4706C6.58756 14.3455 6.51959 14.1759 6.51959 13.999C6.51959 13.8221 6.58756 13.6525 6.70853 13.5274C6.82951 13.4023 6.99359 13.332 7.16467 13.332V13.3359Z" fill="url(#paint0_linear_2677_3208)"/>
                                                <path d="M6.52262 18.0031C6.52322 18.3985 6.63716 18.7848 6.85005 19.1133C7.06294 19.4418 7.36524 19.6976 7.71872 19.8486C8.07221 19.9995 8.46104 20.0387 8.83607 19.9612C9.2111 19.8838 9.5555 19.6931 9.82577 19.4134C10.096 19.1336 10.28 18.7773 10.3545 18.3894C10.429 18.0016 10.3906 17.5996 10.2442 17.2343C10.0979 16.869 9.85003 16.5568 9.53207 16.3371C9.21411 16.1173 8.8403 16 8.45786 15.9998C7.94433 16.0003 7.45198 16.2115 7.08908 16.5872C6.72617 16.9628 6.52242 17.4721 6.52262 18.0031Z" fill="url(#paint1_linear_2677_3208)"/>
                                                <path d="M15.6513 18.0031C15.6519 18.3984 15.7657 18.7846 15.9785 19.113C16.1913 19.4415 16.4935 19.6974 16.8468 19.8484C17.2002 19.9993 17.5889 20.0387 17.9639 19.9614C18.3388 19.8841 18.6833 19.6937 18.9536 19.4142C19.224 19.1347 19.4082 18.7786 19.4829 18.3909C19.5576 18.0032 19.5196 17.6013 19.3735 17.236C19.2275 16.8706 18.98 16.5582 18.6623 16.3382C18.3447 16.1182 17.9711 16.0005 17.5888 15.9998C17.3343 15.9997 17.0823 16.0515 16.8472 16.1521C16.6121 16.2528 16.3984 16.4003 16.2185 16.5863C16.0386 16.7724 15.8959 16.9933 15.7985 17.2363C15.7012 17.4794 15.6512 17.74 15.6513 18.0031Z" fill="url(#paint2_linear_2677_3208)"/>
                                                <defs>
                                                    <linearGradient id="paint0_linear_2677_3208" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                    </linearGradient>
                                                    <linearGradient id="paint1_linear_2677_3208" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#660AFB"/>
                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                    </linearGradient>
                                                    <linearGradient id="paint2_linear_2677_3208" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#660AFB"/>
                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                    </linearGradient>
                                                </defs>
                                            </svg>

                                        </a>
                                    @endif
                                @endguest
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-lg-12">
                <div
                    class="Nocouse_wizged text-center d-flex align-items-center justify-content-center">
                    <div class="thumb">
                        <img style="width: 50px"
                             src="{{ asset('public/frontend/infixlmstheme/img/not-found.png') }}"
                             alt="">
                    </div>

                    <h1>

                        @if(Route::currentRouteName() == 'courses')
                            {{__('frontend.No Course Found')}}
                        @elseif(Route::currentRouteName() == 'quizzes')
                            {{__('frontend.No Quiz Found')}}
                        @elseif(Route::currentRouteName() == 'classes')
                            {{__('frontend.No Class Found')}}
                        @else
                            {{__('frontend.No Topic Found')}}
                        @endif

                    </h1>
                </div>
            </div>
        @endforelse
        @if(isset($has_pagination))
            {{ $result->appends(Request::all())->links(theme('snippets.components._dynamic_pagination')) }}
        @endif

    </div>
    <script>
        if ($.isFunction($.fn.lazy)) {
            $('.lazy').lazy();
        }
    </script>
@endif
