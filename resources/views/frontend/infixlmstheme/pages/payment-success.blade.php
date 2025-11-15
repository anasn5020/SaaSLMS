@php use Modules\Store\Entities\ProductSku; @endphp
@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | @lang('frontend.Payment Success')
@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/lottie-player.min.js')}}"></script>
    <script>
    </script>
@endsection
@section('css')
    <style>
        .payment_success_message_section .content {
            margin: 100px 0;
            border: 0.5px solid #D1D1D1;
            padding: 30px 0;
        }

        .payment_success_message_section .content .success-image {
            aspect-ratio: 1/1;
            width: 184px;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        .payment_success_message_section .content .message {
            font-size: 20px;
            color: #1F2B40;
            line-height: 1.45;
            margin-bottom: 40px;
        }

        .payment_success_message_section .content .order-summery-head {
            margin-bottom: 30px;
        }

        .payment_success_message_section .content .order-summery-head h3 {
            font-size: 20px;
            line-height: 1.5;
            font-weight: 500;
            font-family: var(--fontFamily1, "Plus Jakarta Sans", sans-serif);
            color: #1F2B40;
        }

        .payment_success_message_section .content .product-image {
            height: 50px;
            width: 50px;
            border-radius: 2px;
        }

        .payment_success_message_section .content .product-title {
            color: #1F2B40;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 0;
        }

        .payment_success_message_section .content .summery-item {
            padding-top: 10px;
            padding-bottom: 10px;
            gap: 20px;
        }

        .payment_success_message_section .content .summery-item:not(:last-child) {
            border-bottom: 0.5px solid #D1D1D1;
        }

        .payment_success_message_section .content .summery-item .cost,
        .payment_success_message_section .content .summery-item .type {
            font-weight: 500;
            color: #1F2B40;
            font-size: 14px;
            line-height: 1.5;
        }

        .payment_success_message_section .content .summery-item .cost.total,
        .payment_success_message_section .content .summery-item .type.total {
            font-size: 16px;
        }

        .payment_success_message_section .content .summery-item .type.title {
            font-size: 18px;
            font-weight: 600;
        }

        .summery-footer {
            width: 100%;
            border-top: 0.5px solid #D1D1D1;
            margin-top: 30px;
            padding-top: 80px;
            padding-bottom: 80px;
        }
    </style>
    <link rel="stylesheet" href="{{themeAsset('css/sections/homepage_v7.css')}}">

@endsection
@section('mainContent')

    <div class="payment_success_message_section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="content">

                        <div class="text-center">
                            <div class="success-image">
                                <lottie-player
                                    src="{{asset('public/frontend/infixlmstheme/img/success-animation.json')}}"
                                    background="transparent" speed="1"
                                    direction="1" mode="normal" loop autoplay>
                                </lottie-player>
                            </div>
                            <p class="message">
                                {{__('frontend.Thank you for your purchase, You successfully place order')}}
                            </p>
                        </div>

                        <div class="order-summery w-50 mx-auto">
                            <div class="order-summery-head d-flex align-items-center justify-content-between">
                                <h3>{{__('frontend.Order Summary')}}</h3>
                                <h3>#INV-{{ $checkout->id + 1000 }}</h3>
                            </div>
                            @php
                                $total = 0;
                                $language_code = auth()->user()->language_code ?? 'en';
                                $sl = 1;

                            @endphp
                            @if(isModuleActive('Appointment') && $checkout->type=='appointment')
                                @foreach ($checkout->bookings as $key => $item)
                                    @php
                                        $price = $item->purchase_price;
                                         $total += $price;
                                    @endphp
                                    <div class="d-flex align-items-center justify-content-between summery-item">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{getProfileImage($item->userInfo->image,$item->userInfo->name)}}"
                                                 class="product-image"
                                                 alt="image">
                                            <h4 class="product-title">
                                                {{ @$item->userInfo->name }}
                                                - {{showDate($item->schedule->schedule_date)}}

                                            </h4>
                                        </div>
                                        <div class="cost">
                                            {{ getPriceFormat($price,false) }}
                                        </div>
                                    </div>

                                @endforeach
                            @else
                                @foreach ($checkout->courses as $key => $item)
                                    @php
                                        $item_title ='';
                                        $item_image ='';
                                            $price = $item->purchase_price;
//
//                                            if (isModuleActive('Store') && $item->is_store == 1) {
//                                                 $price1 = $item->course->discount_price != 0 ? $item->course->discount_price : $item->course->price;
//                                                  if (isModuleActive('Store') && $item->is_store && $item->product_sku_id) {
//                                                        $sku =ProductSku::find($item->product_sku_id);
//                                                                $price = $sku->price* $item->qty;
//                                                            }else{
//                                                               $price = $price1 * $item->qty;
//
//                                                            }
//
//                                            }

                                         $total += $price;
                                    @endphp
                                    <div class="d-flex align-items-center justify-content-between summery-item">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{getCourseImage($item->course->image)}}" class="product-image"
                                                 alt="image">
                                            <h4 class="product-title">
                                                {{ @$item->course->getTranslation('title', $language_code) }}

                                            </h4>
                                        </div>
                                        <div class="cost">
                                            {{ getPriceFormat($price,false) }}
                                        </div>
                                    </div>

                                @endforeach
                            @endif


                            <div class="d-flex align-items-center justify-content-between summery-item">
                                <div class="type">{{ __('student.Sub Total') }}:</div>
                                <div class="cost">
                                    {{ getPriceFormat($total,false) }}
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between summery-item">
                                <div class="type">{{ __('common.Discount') }}:</div>
                                <div class="cost">{{ getPriceFormat($checkout->purchase_price-$total,false) }}</div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between summery-item">
                                <div class="type total">{{ __('student.Total') }}:</div>
                                <div class="cost total">{{ getPriceFormat($checkout->purchase_price,false) }}</div>
                            </div>
                        </div>

                        <div class="summery-footer">
                            <div class="d-flex justify-content-center align-items-center gap-3">
                                {{--                            <a href="#" class="secondary-btn">Track Your Order</a>--}}
                                <a href="{{route('home')}}" class="primary-btn">{{__('frontend.Go to Dashboard')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
