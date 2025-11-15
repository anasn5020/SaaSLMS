<style>
    .contact_info {
        background: white;
        border-radius: 61px;
        padding: 60px 85px;
        box-shadow: 6px 34px 55px 0px #3C41551A;
        position: relative;
    }

    .contact_info_container {
        position: absolute;
        z-index: 2;
        top: 80px;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
    }

    .contact_info::before {
        content: '';
        position: absolute;
        width: calc(100% - 2px);
        height: calc(100% + 10px);
        left: 50%;
        top: 50%;
        transform: translateX(-50%) translateY(-50%);
        background: linear-gradient(77.16deg, #660AFB 13.44%, #BF37FF 87.24%);
        z-index: -1;
        border-radius: 61px;
    }

    .contact_info svg {
        width: 40px;
        aspect-ratio: 1/1;
        object-fit: contain;
        object-position: center;
        margin-bottom: 30px
    }

    .contact_info .address_info h4 {
        font-size: 24px;
        font-weight: 500;
        margin-bottom: 20px;
        margin-top: 20px;

    }

    .contact_info .address_info p {
        color: #656A7B;
        font-size: 18px;
    }

    .contact_info .address_info p .value {
        color: #1F2B40;
    }

    .contact_map {
        padding-top: 250px;
    }

    #contact-map {
        border-radius: 47px;
        overflow: hidden;
    }

    @media (max-width: 1200px) {
        .contact_info_container {
            position: initial;
            transform: none;
            margin-top: 80px;
        }

        .contact_map {
            padding-top: 10px;
        }
    }

    @media (max-width: 767px) {
        .contact_info {
            padding: 30px;
        }

        .contact-form select {
            height: 40px;
            font-size: 14px;
        }

        .contact-form input {
            height: 40px;
            font-size: 14px;
        }
    }
</style>


<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/googlemap.png')}}"
     data-aoraeditor-title="Contact Page Map" data-aoraeditor-categories="Contact Page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 position-relative">
                <div class="contact_info_container">
                    <div class="contact_info mb_30">

                        <div class="address_lines row">
                            <div class="single_address_line d-flex col-md-6 col-lg-4">
                                <div class="address_info">
                                    <img src="{{asset('public/frontend/infixlmstheme/img/svg/location.svg')}}" alt="">

                                    <h4>{{__('frontend.Contact Us')}}</h4>

                                    <p>{{__('frontend.Mobile')}}: <span class="value">{!!Settings('phone') !!}</span>
                                    </p>
                                    <p>{{__('frontend.Email')}}: <span class="value">{!!Settings('email') !!}</span></p>
                                </div>
                            </div>


                            <div class="single_address_line d-flex col-md-6 col-lg-4">
                                <div class="address_info">
                                    <img src="{{asset('public/frontend/infixlmstheme/img/svg/support_new.svg')}}"
                                         alt="">

                                    <h4>{{__('frontend.Support Hour')}}</h4>
                                    <p>
                                        Monday - Friday: 09:00 - 17:00
                                    </p>
                                </div>
                            </div>

                            <div class="single_address_line d-flex col-md-6 col-lg-4">
                                <div class="address_info">

                                    <img src="{{asset('public/frontend/infixlmstheme/img/svg/address.svg')}}" alt="">

                                    <h4>{{__('frontend.Address')}}</h4>

                                    <p> {!!Settings('address')  ? Settings('address')  : 'Al Khuwair, Muscat, Oman' !!}</p>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="contact_map">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div id="contact-map"></div>
                </div>
            </div>
        </div>
    </div>
</div>
