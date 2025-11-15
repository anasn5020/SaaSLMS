<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Traits\GoogleAnalytics4;
use App\Traits\SendNotification;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\Auth;
use Modules\Appointment\Entities\Schedule;
use Modules\BundleSubscription\Entities\BundleCoursePlan;
use Modules\CourseSetting\Entities\Course;
use Modules\Payment\Entities\Cart;
use Modules\Store\Entities\ProductAttributeValue;
use Modules\Store\Entities\ProductSku;
use Modules\UpcomingCourse\Entities\UpcomingCourseBooking;
use Modules\UpcomingCourse\Entities\UpcomingCourseBookingPayment;
use function request;

class CartController extends Controller{
    use GoogleAnalytics4, SendNotification;

    public function addToCart($id, $qty = null)
    {
        try {
            $course = Course::with('class', 'user')->find($id);

            if (!$course) {
                Toastr::error(trans('frontend.Item not found'), trans('common.Failed'));
                return redirect()->back();
            }

            $is_store = $this->isStoreCourse($course);


            if ($this->isEnrollmentLimitReached($course)) {
                Toastr::error(trans('virtual-class.Enrollment limit for this course has been reached'), trans('common.Failed'));
                return redirect()->back();
            }

            if (!Auth::check()) {
                $cart = session()->get('cart', []);
                if (isset($cart[$course->id])) {
                    Toastr::error(trans('frontend.Item already added in your cart'), trans('common.Failed'));
                    return redirect()->back();
                }

                $this->addToSessionCart($course, $qty, $is_store);
                Toastr::success(trans('frontend.Item Added to your cart'), trans('common.Success'));
                return redirect()->back();

            }

            $user = Auth::user();
             if ($user->role_id == 1) {
                 Toastr::error(trans('frontend.You logged in as admin so can not add cart'), trans('common.Failed'));
                 return redirect()->back();
             }


            $cart = $this->findOrCreateCart($course, $qty, $is_store, $user);
              if (!$cart) {
                 Toastr::error(trans('frontend.Item already added in your cart'), trans('common.Failed'));
                 return redirect()->back();
             }

            $this->postCartEvent($cart);

            if ($cart->price == 0) {
                $this->processFreeCart($cart);
                Toastr::success(trans('frontend.Free Item Enrolled Successfully'), trans('common.Success'));
                return redirect()->back();
            }
            Toastr::success(trans('frontend.Item Added to your cart'), trans('common.Success'));
            return redirect()->back();

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    private function isStoreCourse($course)
    {
        return isModuleActive('Store') && $course->type == 5;
    }

    private function isEnrollmentLimitReached($course)
    {
        return $course->type == 3 && $course->class->capacity && $course->total_enrolled >= $course->class->capacity;
    }


    private function addToSessionCart($course, $qty, $is_store)
    {


        $price = $this->getPrice($course);
        $attributes_values = $is_store ? request('attribute_values') : '';
        $product_sku_id = $is_store ? request('sku_id') : '';
        $product_sku_label = $is_store ? implode(' - ', ProductAttributeValue::whereIn('id', explode(',', request('attribute_values')))->pluck('value')->toArray()) : '';

        $cart[$course->id] = [
            'id' => $course->id,
            'course_id' => $course->id,
            'instructor_id' => $course->user_id,
            'instructor_name' => $course->user->name,
            'title' => $course->title,
            'image' => $course->image,
            'slug' => $course->slug,
            'type' => $course->type,
            'price' => $price,
            'qty' => $qty>0?$qty:1,
            'is_store' => $is_store,
            'attributes_values' => $attributes_values,
            'product_sku_id' => $product_sku_id,
            'product_sku_label' => $product_sku_label,
        ];

        session()->put('cart', $cart);
        $this->postCartEvent((object) $cart[$course->id]);


    }

    private function getPrice($course)
    {
        $price = $course->discount_price > 0 ? $course->discount_price : $course->price;
        return hasCouponApply($course->id) ? getCouponPrice($course->id) : $price;
    }

    private function postCartEvent($cart)
    {
        $this->postEvent([
            'name' => 'add_to_cart',
            'params' => [
                'items' => [
                    [
                        'item_id' => $cart->course_id,
                        'item_name' => isset($cart->title)?$cart->title:$cart->course->title,
                        'price' => $cart->price,
                    ],
                ],
            ],
        ]);
    }





    private function findOrCreateCart($course, $qty, $is_store, $user)
    {
        $cart = Cart::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($cart) {
            return false;
        }

        return $this->createCart($course, $qty, $is_store, $user);
    }

    private function createCart($course, $qty, $is_store, $user)
    {
        $userHaveCart = Cart::where('user_id', $user->id)->first();
        if ($userHaveCart) {
            $tracking =$userHaveCart->tracking;
        }else{
            $tracking = getTrx();
        }
        $cart = new Cart();
        $cart->user_id = $user->id;
        $cart->instructor_id = $course->user_id;
        $cart->course_id = $course->id;
        $cart->tracking = $tracking;

        $cart->price = $this->getPrice($course);
         if (isModuleActive('EarlyBird')) {
            $early_bird_price = verifyEarlybirdOffer($course, $user->id);
             $cart->price = $early_bird_price['price'];
            $cart->is_earlybird_offer = $early_bird_price['price_plan_id']?1:0;
            $cart->price_plan_id = $early_bird_price['price_plan_id'];
        }

        if (isModuleActive('Store') && $is_store) {
            $this->setStoreAttributes($cart, $qty);
        }else{
            $this->applyDiscounts($cart, $user, $course);

        }

        $cart->save();

        return $cart;
    }

    private function setStoreAttributes($cart, $qty)
    {
        $sku = ProductSku::find(request()->sku_id);
        $cart->qty = $qty>0?$qty:1;
        $cart->is_store = true;
        if ($sku){
            $cart->price = $sku->price ?? 0;
            $cart->attributes_values = request('attribute_values');
            $cart->product_sku_id = request('sku_id');
            $attributes_values = ProductAttributeValue::whereIn('id', explode(',', request('attribute_values')))->pluck('value')->toArray();
            $cart->product_sku_label = implode(' - ', $attributes_values);
        }

    }

    private function applyDiscounts($cart, $user, $course)
    {
        if (isModuleActive('UpcomingCourse') && $course->is_upcoming_course && $course->is_allow_prebooking) {
            $pre_booking = UpcomingCourseBooking::where('course_id', $course->id)
                ->where('user_id', $user->id)
                ->first();
            if ($pre_booking) {
                $pre_booking_amount = UpcomingCourseBookingPayment::where('booking_id', $pre_booking->id)->sum('amount');
                $cart->pre_booking_amount = $pre_booking_amount;
            }
        }

        if (isModuleActive('UserGroup') && $user->userGroup && $user->userGroup->group->status && $user->userGroup->group->discount) {
            $cart->group_discount = number_format(($cart->price * $user->userGroup->group->discount) / 100, 2);
        }

        if (hasCouponApply($course->id)) {
            $cart->price = getCouponPrice($course->id);
        }
    }

    private function processFreeCart($cart)
    {
        $paymentController = new PaymentController();
        if ($cart->course->type == 5) {
            if ($cart->course->product->type != 2) {
                $paymentController->directProductEnroll($cart, $cart->tracking);
            }
        } else {
            $paymentController->directEnroll($cart->course_id, $cart->tracking);
        }
    }


    public function getItemList()
    {
        $carts = [];

        if (Auth::check()) {
            $items = $this->getAuthenticatedUserCartItems();
             foreach ($items as $key => $cart) {
                 $item =$this->formatCartItem($cart);
                 if ($item){
                     $carts[$key] = $item;
                 }else{
                     $cart->delete();
                 }
            }
        } else {
            $items = session()->get('cart', []);
            foreach ($items as $key => $cart) {
                $item =$this->formatCartItem((object)$cart);
                if ($item){
                    $carts[$key] = $item;
                }else{
                    unset($items[$key]);
                }
            }
        }
        $this->postEvent([
            'name' => 'view_cart',
            'params' => ['items' => $carts],
        ]);

        return $this->prepareResponse($carts);
    }

    private function getAuthenticatedUserCartItems()
    {
        return Cart::where('user_id', Auth::id())
            ->with('course', 'course.user')
            ->when(isModuleActive('Invoice'), function ($query) {
                $query->whereNull('type');
            })->get();
    }

    private function formatCartItem($cart)
    {
         $course = Course::find($cart->course_id);
        $formattedCart = [
            'id' => $cart->id,
            'course_id' => @$course->id,
            'instructor_id' => @$course->user_id,
            'title' => @$course->title,
            'instructor_name' => @$course->user?->name,
            'image' => getCourseImage(@$course->thumbnail),
        ];

        if (isModuleActive('BundleSubscription') && !empty($cart->bundle_course_id)) {
            $bundle = BundleCoursePlan::find($cart->bundle_course_id);
            if ($bundle) {
                $formattedCart['title'] = $bundle->title;
                $formattedCart['image'] = getCourseImage($bundle->icon);
                $formattedCart['price'] = getPriceFormat($bundle->price);
                return $formattedCart;
            }
        }
        if (isModuleActive('Appointment') && !empty($cart->schedule_id)) {
            $schedule = Schedule::find($cart->schedule_id);
            if ($schedule) {
                $formattedCart['title'] = $schedule->schedule_date;
                $formattedCart['price'] = $cart->price;

                return $formattedCart;
            }
        }


        $formattedCart['price'] = $this->getCartItemPrice($cart, $course);

        return $formattedCart;
    }

    private function getCartItemPrice($cart, $course)
    {
        // Convert $cart to an object if it's an array
        if (is_array($cart)) {
            $cart = (object) $cart;
        }

         if (isModuleActive('Installment') && !empty($cart->is_installment) && $cart->is_installment == 1) {
            return getPriceFormat(installmentProductPrice(
                $cart->course_id,
                $cart->plan_id,
                $course->discount_price ?: $course->price
            ));
        }

        // Check for Early Bird module
        if (isModuleActive('EarlyBird') && !empty($cart->is_earlybird_offer) && $cart->is_earlybird_offer == 1) {
            return getPriceFormat(verifyEarlybirdOffer($course, Auth::id(), $cart)['price']);
        }

        // Check for Store module
        if (isModuleActive('Store') && !empty($cart->is_store) && $cart->is_store == 1) {
            return $this->getStoreItemPrice($cart);
        }


        if (hasCouponApply($course->id)) {
            return getPriceFormat(getCouponPrice($course->id));
        }

        return getPriceFormat($course->discount_price ?: $course->price);

    }

    private function getStoreItemPrice($cart)
    {
        if (isset($cart['price'])){
            $price = $cart['price'];
            $qty = $cart['qty'] ?? 1;
            $qty=$qty>0?$qty:1;
        }else{
            $price = $cart->price;
            $qty = $cart->qty ?? 1;
            $qty=$qty>0?$qty:1;
        }
        return "{$qty} x " . getPriceFormat($price) . " = " . getPriceFormat($price * $qty);
    }

    private function prepareResponse($carts)
    {
        if (request('responseType') === 'view') {
            return view(theme('partials._cart'), compact('carts'))->render();
        }
        return response()->json($carts);
    }



}
