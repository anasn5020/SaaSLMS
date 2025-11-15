<div>
    <div class="main_content_iner main_content_padding">
        <div class="dashboard_lg_card">
            <div class="container-fluid g-0">
                <div class="row">
                    <div class="col-12">
                        <div class="section__title3">
                            <h3>{{__('frontend.Wishlist')}}</h3>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            @if(count($bookmarks)==0)
                                <div class="col-12">
                                    <div class="section__title3 margin_50">
                                        <p class="text-center">{{__('student.Empty')}}!</p>
                                    </div>
                                </div>
                            @else
                                <table class="table custom_table mb-0">
                                    <thead>
                                    <tr>
                                        <th>{{__('student.Product')}}</th>
                                        <th>{{__('student.Price')}}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($bookmarks))
                                        @foreach($bookmarks as $bookmark)

                                            <tr>
                                                <td>
                                                    <div class="product_name d-flex align-items-center">
                                                        <div class="p-3">
                                                            <a href="{{route('bookmarkSave',[$bookmark->course_id])}}">
                                                                <svg id="icon3" xmlns="http://www.w3.org/2000/svg"
                                                                     width="16"
                                                                     height="16" viewBox="0 0 16 16">
                                                                    <path data-name="Path 174" d="M0,0H16V16H0Z"
                                                                          fill="none"/>
                                                                    <path data-name="Path 175"
                                                                          d="M14.95,6l-1-1L9.975,8.973,6,5,5,6,8.973,9.975,5,13.948l1,1,3.973-3.973,3.973,3.973,1-1L10.977,9.975Z"
                                                                          transform="translate(-1.975 -1.975)"
                                                                          fill="var(--system_primery_color)"/>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                        <div class="thumb">
                                                            <img class="h-100"
                                                                 src="{{getCourseImage($bookmark->course->thumbnail)}}"
                                                                 alt="">
                                                        </div>
                                                        <span>{{@$bookmark->course->title}}</span>
                                                    </div>
                                                </td>
                                                <td class="f_w_400">
                                                @if (@$bookmark->course->discount_price!=null)
                                                    {{getPriceFormat($bookmark->course->discount_price)}}
                                                @else
                                                    {{getPriceFormat($bookmark->course->price)}}
                                                @endif


                                                <td class="f_w_600">
                                                    <a href="{{courseDetailsUrl($bookmark->course->id,$bookmark->course->type,$bookmark->course->slug)}}"
                                                       class="theme_btn small_btn4">{{__('student.View')}}</a>

                                                    @if(!onlySubscription()&& !$bookmark->course->isLoginUserEnrolled)
                                                        <a href="{{route('addToCart',[@$bookmark->course->id])}}"
                                                           class="theme_btn small_btn4">{{__('common.Add To Cart')}}</a>
                                                    @endif
                                                </td>


                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
