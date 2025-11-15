@php
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Modules\FooterSetting\Entities\FooterWidget;
    use Modules\SystemSetting\Entities\SocialLink;
@endphp

<link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/css/homepageV7/footer-v7.css')}}">
@php
    $newsletterSetting = Cache::rememberForever('newsletterSetting_' . SaasDomain(), function () {
            return DB::table('newsletter_settings')
                ->select('home_status', 'home_service', 'home_list_id', 'student_status', 'student_service', 'student_list_id', 'instructor_status',
                    'instructor_status', 'instructor_service', 'instructor_list_id')
                ->first();
        });
     $social_links = Cache::rememberForever('social_links_'.SaasDomain(), function () {
                return SocialLink::select('link', 'icon', 'name')
                    ->where('status', '=', 1)
                    ->get();
            });

     $payment_methods = Cache::rememberForever('payment_methods_'.SaasDomain(), function () {
            return DB::table('payment_methods')
                ->select('method', 'logo','active_status', 'module_status')
                ->where('active_status', 1)
                ->where('module_status', 1)
                ->get();
     });

        $sectionWidgetsData = Cache::rememberForever('sectionWidgets_' . app()->getLocale() . SaasDomain(), function () {
            return FooterWidget::where('status', 1)
                ->with('frontpage')
                ->get();
        });

        $sectionWidgets['one'] = $sectionWidgetsData->where('section', '1');
        $sectionWidgets['two'] = $sectionWidgetsData->where('section', '2');
        $sectionWidgets['three'] = $sectionWidgetsData->where('section', '3');
@endphp
<footer
    class="footer footer2 {{Settings('footer_show')==0?'d-none d-sm-none d-md-block d-lg-block d-xl-block':''}} position-relative overflow-hidden section-margin">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-md-8">
                <div class="pe-md-5">
                    <div class="footer-item">
                        <h5>
                            {{ function_exists('footerSettings')?footerSettings('footer_about_title'):''  }}

                        </h5>
                        <p>
                            {{ function_exists('footerSettings')?footerSettings('footer_about_description'):''  }}
                        </p>
                    </div>
                    @if($newsletterSetting->home_status==1)

                        <div class="footer-subscribe">
                            <h5>{{__('frontend.Never Miss A Post!')}}</h5>
                            <p>{{__('frontend.Choose the most powerful courses and always be on demand')}}</p>
                            <form action="{{route('subscribe')}}"
                                  method="POST" class="subscription relative">@csrf
                                <div class="form-box d-flex flex-wrap align-items-center gap-2">

                                    <input name="email" class="form-control"
                                           placeholder="{{__('frontend.Enter e-mail Address')}}"
                                           required="" type="email" value="{{old('email')}}">

                                    <input type="submit" class="form-control text-uppercase"
                                           value="{{__('frontend.Subscribe')}}">
                                    <div class="info">
                                        @if(isset($errors) && $errors->any())
                                            <span class="text-danger" role="alert">{{$errors->first('email')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            @if(isset($sectionWidgets))
                @if(count($sectionWidgets['one'])!=0)
                    <div class="col-xl-3 col-md-4 col-sm-6">
                        <div class="footer-item">
                            <h5>{{function_exists('footerSettings')?footerSettings('footer_section_one_title'):''}}</h5>
                            <ul>
                                @foreach($sectionWidgets['one'] as $page)
                                    @if(isset($page->frontpage->id))
                                        @php
                                            $route = $page->is_static == 0 ? route('frontPage',$page->frontpage->slug) : url($page->frontpage->slug);
                                        @endphp
                                        <li><a href="{{ $route }}">{{$page->name}} </a></li>
                                    @elseif($page->custom==1)
                                        <li><a href="{{$page->custom_link}}">{{$page->name}} </a></li>
                                    @else
                                        <li><a href="#">{{$page->name}} </a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @if(count($sectionWidgets['two'])!=0)
                    <div class="col-xl-3 col-md-4 col-sm-6">
                        <div class="footer-item">
                            <h5>{{function_exists('footerSettings')?footerSettings('footer_section_two_title'):''}}</h5>
                            <ul>
                                @foreach($sectionWidgets['two'] as $key=> $page)
                                    @if(isset($page->frontpage->id))
                                        @php
                                            $route = $page->is_static == 0 ? route('frontPage',$page->frontpage->slug) : url($page->frontpage->slug)
                                        @endphp
                                        <li><a href="{{ $route }}">{{$page->name}} </a></li>
                                    @elseif($page->custom==1)
                                        <li><a href="{{$page->custom_link}}">{{$page->name}} </a></li>
                                    @else
                                        <li><a href="#">{{$page->name}} </a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @if(count($sectionWidgets['three'])!=0)
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="footer-item">
                            <h5>{{function_exists('footerSettings')?footerSettings('footer_section_three_title'):''}}</h5>
                            <ul>
                                @foreach($sectionWidgets['three'] as $page)
                                    @if(isset($page->frontpage->id))
                                        @php
                                            $route = $page->is_static == 0 ? route('frontPage',$page->frontpage->slug) : url($page->frontpage->slug)
                                        @endphp
                                        <li><a href="{{ $route }}">{{$page->name}} </a></li>
                                    @elseif($page->custom==1)
                                        <li><a href="{{$page->custom_link}}">{{$page->name}} </a></li>
                                    @else
                                        <li><a href="#">{{$page->name}} </a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            @endif
        </div>
        <div class="row">
            <div class="col-12">
                <div class="footer-wraper">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-sm-6">
                            <div class="contact d-flex align-items-center">
                                <div class="icon">
                                    <svg width="44" height="56" viewBox="0 0 44 56" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M43.1697 45.0882C41.9387 41.4252 37.0337 39.1322 33.5357 37.5952C32.1657 36.9952 28.3727 35.9772 27.9167 34.2522C27.766 33.6725 27.7636 33.0641 27.9097 32.4832C27.6969 32.525 27.4806 32.5464 27.2637 32.5472H24.9847C24.5382 32.5692 24.0919 32.5003 23.6729 32.3446C23.2538 32.1888 22.8708 31.9496 22.547 31.6414C22.2232 31.3332 21.9654 30.9624 21.7893 30.5515C21.6131 30.1406 21.5223 29.6982 21.5223 29.2512C21.5223 28.8042 21.6131 28.3618 21.7893 27.9509C21.9654 27.54 22.2232 27.1692 22.547 26.861C22.8708 26.5528 23.2538 26.3136 23.6729 26.1579C24.0919 26.0021 24.5382 25.9332 24.9847 25.9552H27.2637C28.0048 25.9546 28.7244 26.2044 29.3057 26.6642C30.1248 26.5563 30.9334 26.3793 31.7227 26.1352C32.756 24.0206 33.4164 21.7435 33.6747 19.4042C34.4147 10.2042 28.7747 4.8252 20.6937 5.7552C14.8167 6.4322 11.3057 10.8142 10.9267 16.4552C10.6264 21.1686 12.0529 25.8301 14.9397 29.5682C15.9317 30.9302 16.9737 31.8062 16.8137 33.4472C16.6277 35.3882 14.5527 35.9292 13.0677 36.5252C11.5079 37.1942 9.98928 37.9552 8.51971 38.8042C5.43771 40.5042 2.05571 42.5562 1.29471 45.3592C-0.389285 51.5732 5.29471 53.4592 9.99471 54.3242C14.0657 54.951 18.1839 55.2187 22.3017 55.1242C29.0597 55.1242 41.2127 54.8532 43.1727 49.7732C43.6133 48.2433 43.6133 46.6201 43.1727 45.0902L43.1697 45.0882Z"
                                            fill="currentColor"/>
                                        <path
                                            d="M28.7061 28.3221C28.55 28.0819 28.3365 27.8844 28.0849 27.7475C27.8333 27.6106 27.5515 27.5386 27.2651 27.5381H24.9871C24.7582 27.5326 24.5305 27.5729 24.3174 27.6567C24.1043 27.7405 23.9101 27.866 23.7463 28.0259C23.5824 28.1859 23.4522 28.377 23.3633 28.588C23.2744 28.799 23.2286 29.0256 23.2286 29.2546C23.2286 29.4836 23.2744 29.7102 23.3633 29.9212C23.4522 30.1322 23.5824 30.3233 23.7463 30.4833C23.9101 30.6432 24.1043 30.7688 24.3174 30.8525C24.5305 30.9363 24.7582 30.9766 24.9871 30.9711H27.2651C27.5786 30.9712 27.8861 30.8845 28.1534 30.7208C28.4208 30.557 28.6377 30.3225 28.7801 30.0431C31.6002 29.8975 34.3261 28.9797 36.6601 27.3901C37.119 27.6875 37.6542 27.8455 38.2011 27.8451H38.3441C38.7206 27.8452 39.0934 27.7711 39.4413 27.627C39.7892 27.4829 40.1052 27.2716 40.3713 27.0052C40.6374 26.7388 40.8484 26.4226 40.9921 26.0746C41.1359 25.7266 41.2096 25.3536 41.2091 24.9771V19.2501C41.2091 18.7094 41.0556 18.1799 40.7666 17.723C40.4775 17.2661 40.0647 16.9006 39.5761 16.6691C39.3701 12.2123 37.4546 8.00635 34.2278 4.92527C31.001 1.84419 26.7111 0.125 22.2496 0.125C17.788 0.125 13.4981 1.84419 10.2713 4.92527C7.04451 8.00635 5.12907 12.2123 4.92306 16.6691C4.43414 16.9003 4.02097 17.2656 3.73168 17.7226C3.44239 18.1795 3.28889 18.7093 3.28907 19.2501V24.9751C3.28854 25.3514 3.36216 25.7241 3.50573 26.0719C3.6493 26.4197 3.86 26.7358 4.12579 27.0021C4.39158 27.2685 4.70724 27.4798 5.05475 27.6241C5.40226 27.7684 5.77479 27.8428 6.15106 27.8431H6.29607C6.67247 27.843 7.04516 27.7687 7.39284 27.6245C7.74052 27.4802 8.05637 27.2689 8.32234 27.0026C8.58831 26.7362 8.7992 26.4201 8.94294 26.0722C9.08668 25.7243 9.16046 25.3515 9.16006 24.9751V19.2501C9.15982 18.7169 9.01041 18.1944 8.72872 17.7416C8.44704 17.2889 8.04431 16.9239 7.56606 16.6881C7.7552 12.9218 9.38453 9.37224 12.1171 6.77343C14.8497 4.17463 18.4765 2.72538 22.2476 2.72538C26.0186 2.72538 29.6454 4.17463 32.378 6.77343C35.1106 9.37224 36.7399 12.9218 36.9291 16.6881C36.4513 16.9244 36.0491 17.2895 35.7679 17.7422C35.4866 18.1949 35.3374 18.7171 35.3371 19.2501V24.9751C35.3357 25.3396 35.4036 25.701 35.5371 26.0401C33.4974 27.3822 31.1428 28.1688 28.7061 28.3221Z"
                                            fill="currentColor"/>
                                    </svg>
                                </div>
                                <div class="content">
                                    <span
                                        class="fw-bold fs-14 text-uppercase d-block">{{__('frontend.Call Us 24/7')}}</span>
                                    <a href="tel:{{Settings('phone')}}" class="currentColor">{{Settings('phone')}}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <span class="d-block fs-14 fw-500">{{Settings('address')}}</span>
                            <a href="mailto:{{Settings('email')}}" class="currentColor fs-20">{{Settings('email')}}</a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="ps-lg-5">
                                <h4 class="text-uppercase currentColor">{{__('frontend.Follow Us')}}</h4>
                                <ul class="social-list">
                                    @if(isset($social_links))
                                        @foreach($social_links as $social)
                                            <li><a target="_blank" href="{{$social->link}}" class=""
                                                   title="{{$social->name}}"><i
                                                        class="{{$social->icon}}"></i></a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <h4 class="text-uppercase currentColor">{{__('frontend.Payment Method')}}</h4>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                @foreach($payment_methods as $method)
                                    @php
                                        if(empty($method->logo)){
                                            continue;
                                        }
                                    @endphp
                                    <img src="{{asset($method->logo)}}" class="payment-methods"
                                         alt="{{$method->method}}">

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p>{!! function_exists('footerSettings')?footerSettings('footer_copy_right'):''  !!}</p>
                </div>
            </div>
        </div>
</footer>
