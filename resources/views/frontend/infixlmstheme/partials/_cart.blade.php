<div>
    @forelse($carts as $key => $cart)
        <div class="single_cart">
            <div data-id="{{$cart['id']}}" class="remove_cart">
                <svg id="icon3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <path data-name="Path 174" d="M0,0H16V16H0Z" fill="none"></path>
                    <path data-name="Path 175"
                          d="M14.95,6l-1-1L9.975,8.973,6,5,5,6,8.973,9.975,5,13.948l1,1,3.973-3.973,3.973,3.973,1-1L10.977,9.975Z"
                          transform="translate(-1.975 -1.975)" fill="var(--system_primery_color)"></path>
                </svg>
            </div>
            <div class="thumb" style="background-image: url('{{$cart['image']}}')">

            </div>
            <div class="cart_content"><h5>{{$cart['title']}}</h5>
                <p><span class="prise">{{$cart['price']}}</span></p>
            </div>
        </div>

    @empty
        <div class="single_cart"><h4>{{__('frontend.No Item into cart')}}</h4></div>
    @endforelse
    @if(count($carts)>0)
        <div class="view_checkout_btn d-flex justify-content-end gap_10 flex-wrap">
            <a href="{{url('my-cart')}}"
               class="theme_btn small_btn3 flex-fill text-center">{{__('frontend.View cart')}}</a>
            <a href="{{route('myCart',['checkout'=>true])}}"
               class="theme_btn small_btn3 flex-fill text-center">{{__('frontend.Checkout')}}</a>
        </div>
@endif
