@php
    $banner = $frontendContent->breadcrumb_image ?? 'public/frontend/infixlmstheme/img/new_bread_crumb_bg.png';
 @endphp
<div>
     <div class="breadcrumb_area"
         style="background-image: url('{{asset($banner)}}')">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcam_wrap">
                        <h3>
                            {{@$title}}
                        </h3>
                         <p>
                            {{__('frontend.Home')}} / {{$sub_title}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
