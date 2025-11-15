<div class="main_content_iner main_content_padding">

    <div class="dashboard_lg_card">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-12">
                    <div class="section__title3 mb_40">
                        <h3 class="mb-0">
                            {{__('coupons.My Cart')}}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="new_cart_wrapper">

                        @if(count($carts)==0)
                            <div class="col-lg-12">
                                <h3 class="text-center text-secondary"> {{__('common.No Item found')}} <i
                                        class="fa fa-shopping-cart" aria-hidden="true"></i>
                                </h3>
                            </div>
                        @else

                            @php $totalSum=0; @endphp

                            @if(isset($carts))
                                @foreach ($carts as $key=>$cart)
                                    @php

                                        if (isset($cart->bundle_course_id) && $cart->bundle_course_id!=0){
                                         $thumbnail=$cart?->bundle?->thumbnail;
                                          $price=$cart?->bundle?->price;
                                          $link=route('bundle.show').'?id='.$cart->bundle_course_id;
                                           $title =$cart?->bundle?->title;
                                        }else{
                                            $thumbnail =$cart?->course?->thumbnail;
                                            if ($cart?->course){
                                            $link =route('courseDetailsView',$cart?->course?->slug);
                                            }else{
                                                $link='#';
                                            }
                                            $title =$cart?->course?->title;
                                            if (isModuleActive('Installment') && $cart->is_installment == 1) {
                                                $price=installmentProductPrice($cart->course_id, $cart->plan_id,$cart->course->discount_price?$cart->course->discount_price:$cart->course->price);
                                            }else{
                                                 if (isModuleActive('Store') && $cart->is_store == 1) {
                                                    $price = $cart->price * $cart->qty;
                                                }else{
                                                    $price =$cart->price;
                                                 }

                                            }


                                        }

                                       $totalSum =  $totalSum + @$price;

                                    @endphp

                                    <div class="single_cart">
                                        <div class="product_name d-flex align-items-center">
                                            <a href="{{route('removeItem',[$cart->id])}}">
                                                <div class="">

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         viewBox="0 0 16 16">
                                                        <path data-name="Path 174" d="M0,0H16V16H0Z" fill="none"/>
                                                        <path data-name="Path 175"
                                                              d="M14.95,6l-1-1L9.975,8.973,6,5,5,6,8.973,9.975,5,13.948l1,1,3.973-3.973,3.973,3.973,1-1L10.977,9.975Z"
                                                              transform="translate(-1.975 -1.975)"
                                                              fill="var(--system_primery_color)"/>
                                                    </svg>
                                                </div>
                                            </a>
                                            <div class="thumb">
                                                <img src="{{asset($thumbnail)}}" alt="">
                                            </div>
                                            <span>
                                            <a href="{{$link}}">
                                            <h5>
                                                 @if ($cart->product_sku_label)
                                                    {{  $cart->course->title . ' ('. $cart['product_sku_label'].')'}}
                                                @else
                                                    {{$title}}
                                                @endif
                                            </h5></a>
                                        </span>
                                        </div>

                                        <div class="f_w_400">
                                            @if (isModuleActive('Store') && $cart->is_store == 1)
                                                {{ $cart->qty . ' x ' . getPriceFormat($cart->price) . ' = ' . getPriceFormat($price) }}
                                            @else
                                                {{ getPriceFormat($price) }}
                                            @endif

                                        </div>

                                    </div>
                                @endforeach
                            @endif

                        @endif
                    </div>
                    <div class="cart_table_wrapper mb-0">
                        @if(count($carts)!=0)
                            <div class="row mt_30">
                                <div class="col-12 text-end">
                                    <a href="{{route('CheckOut')}}"
                                       class="theme_btn">{{__('student.Proceed to checkout')}}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
