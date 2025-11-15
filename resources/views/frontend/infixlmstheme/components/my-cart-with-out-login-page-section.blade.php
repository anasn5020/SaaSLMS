<style>
    .single_cart .thumb img {
        height: 100px;
        width: 100px;
        object-fit: cover;
        object-position: center;
    }

    .cart-table table thead th {
        font-size: 14px;
        font-weight: 500;
        vertical-align: middle;
    }

    .cart-table table thead tr {
        border: 0.5px solid #D1D1D1;
    }

    .cart-table table tbody tr {
        border: 0.5px solid #D1D1D1;
    }

    .cart-table table tbody td {
        font-size: 16px;
        font-weight: 400;
        vertical-align: middle;
    }

    .cart-table table tfoot td {
        border: 0.5px solid #D1D1D1;
    }

    .cart-table table tfoot td a {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 45px;
        padding: 6px 32px;
        color: #656A7B;
    }

    .cart-table table tfoot td a.type1 {
        background: #ffffff;
        border: 0.5px solid #D1D1D1
    }

    .cart-table table tfoot td a.type1:hover {
        background: #E6E6E6;
    }

    .cart-table table tfoot td a.type2 {
        background: #f2f2f2;
        border: 0.5px solid #D1D1D1
    }

    .cart-table table tfoot td a.type2:hover {
        background: #E6E6E6;
    }

    .cart-item-remove {
        border: 0.5px solid #D1D1D1;
        border-radius: 100%;
        height: 22px;
        width: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cart-item-remove:hover {
        border: 1px solid #666666;
    }

    .cart-quantity {
        border: 0.5px solid #D1D1D1;
        padding: 6px;
        width: fit-content;
        gap: 4px;
        border-radius: 2px;
    }

    .cart-quantity button {
        height: 34px;
        width: 34px;
        background: #F2F2F2;
        border: 0;
        border-radius: 2px;
        font-size: 18px;
    }

    .cart-quantity button:hover {
        background: #D3D3D3;
    }

    .cart-quantity input {
        width: 34px;
        text-align: center;
        border: 0;
        border-radius: 2px;
        max-width: fit-content;
    }

    .cart-summery {
        border: 0.5px solid #D1D1D1;
        padding: 22px;
    }

    .cart-summery h4 {
        font-size: 20px;
        font-weight: 500;
        color: #1F2B40;
        margin-bottom: 0;
    }

    .theme_btn.checkout {
        width: 100%;
        border-radius: 2px;
    }

    .cart-summery .summery-type {
        font-size: 14px;
        font-weight: 400;
        color: #4D4D4D;
    }

    .cart-summery .summery-value {
        font-size: 14px;
        font-weight: 500;
        color: #1A1A1A;
    }

    .cart-summery .summery-value.total {
        font-size: 16px;
        font-weight: 600;
        color: #1A1A1A;
    }

    .cart-summery-item {
        padding-top: 18px;
        padding-bottom: 18px;
        border-bottom: 0.5px solid #D1D1D1;
    }
</style>

<div>
    <div class="cart_wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="cart-table">
                        <!-- New Cart Design:Start -->
                        <div class="row">
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="text-uppercase">
                                        <tr>
                                            <th>
                                                {{__('courses.Course')}} @if(isModuleActive('Store'))
                                                    / {{__('product.Product')}}
                                                @endif
                                            </th>
                                            <th>{{__('frontend.Price')}}</th>
                                            {{--                                            <th>{{__('frontend.Subtotal')}}</th>--}}
                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @php

                                            $totalSum=0;
                                            if (!auth()->check()) {
                                            $carts=[];
                                            if (session()->has('cart')){
                                                    foreach (session()->get('cart') as $key => $cart) {
                                                $carts[]=$cart;
                                            }
                                            }

                                            }

                                        @endphp


                                        @if(count($carts)!=0)

                                            @foreach($carts as $key=>$cart)
                                                @php
                                                    if (isModuleActive('Store') && ($cart['is_store']??0) == 1) {
                                                        $price = $cart['price'] * ($cart['qty']*1);
                                                    }else{
                                                        $price = $cart['price'];
                                                    }

                                                    $totalSum =  $totalSum + @$price;

                                                @endphp
                                                <tr class="single_cart">
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="thumb">
                                                                <img src="{{asset($cart['image'])}}" alt="">
                                                            </div>
                                                            <span>
                                                            <a href="{{route('courseDetailsView',@$cart['slug'])}}">
                                                            <p>{{@$cart['title']}}</p></a>
                                                        </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="f_w_400">
                                                            @if (isModuleActive('Store') && ($cart->is_store??0) == 1)
                                                                {{ $cart['qty'] . ' x ' . getPriceFormat($cart['price']) . ' = ' . getPriceFormat($price) }}
                                                            @else
                                                                {{ getPriceFormat($price) }}
                                                            @endif

                                                        </div>
                                                    </td>


                                                    <td>
                                                        <a href="{{route('removeItem',[$cart['id']])}}"
                                                           class="cart-item-remove">
                                                            <div>

                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                     height="16"
                                                                     viewBox="0 0 16 16">
                                                                    <path data-name="Path 174" d="M0,0H16V16H0Z"
                                                                          fill="none"/>
                                                                    <path data-name="Path 175"
                                                                          d="M14.95,6l-1-1L9.975,8.973,6,5,5,6,8.973,9.975,5,13.948l1,1,3.973-3.973,3.973,3.973,1-1L10.977,9.975Z"
                                                                          transform="translate(-1.975 -1.975)"
                                                                          fill="#666666"/>
                                                                </svg>
                                                            </div>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        @else
                                            <tr>
                                                <td colspan="5"
                                                    class="text-center text-secondary"> {{__('common.No Item found')}}
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <a href="{{url('/')}}"
                                                       class="type1">{{__('frontend.Return to home')}}</a>
                                                    <a href="{{route('emptyCart')}}"
                                                       class="type2">{{__('frontend.Empty Cart')}}</a>
                                                </div>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="cart-summery">
                                    <h4>Cart Total</h4>



                                    <div
                                        class="cart-summery-item border-0 d-flex align-items-center justify-content-between">
                                        <span class="summery-type">Total:</span>
                                        <span class="summery-value total">{{getPriceFormat($totalSum)}}</span>
                                    </div>

                                    @if(count($carts)!=0)
                                        <div class="row mt_30">
                                            <div class="col-12 text-center">
                                                <a href="{{route('CheckOut')}}"
                                                   class="theme_btn checkout">{{__('student.Proceed to checkout')}}</a>
                                            </div>
                                        </div>
                                    @endif
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
