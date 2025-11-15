<div>


    @if ($modal)

        <style>
            .newsletter_form_wrapper .newsletter_form_inner .newsletter_form_thumb {
                height: 100%;
                background-image: url("{{ asset($popup->image) }}");
                background-size: cover;
                background-position: center center !important;
                background-repeat: no-repeat;
            }

            .newsletter_form_inner {
                max-width: 800px;
            }

            @media (max-width: 767.98px) {
                .newsletter_form_wrapper .newsletter_form_inner .newsletter_form_thumb {
                    height: 180px;
                }
            }

            #popupContentDiv .newsletter_form_wrapper {
                z-index: 9999999;
            }

            #popupContentModal .newsletter_form_inner {
                grid-template-columns: 350px auto;
            }

            .newsletter_active {
                opacity: 1;
                visibility: visible;
            }

            .newsletter_form_inner .newsletter_form h3 {
                font-size: 24px;
                font-weight: 700;
            }

            #popupContentModal .newsletter_form_inner .newsletter_form p {
                text-align: left !important;
                color: #393A3C;
                font-size: 15px;
                font-weight: 400;
            }

            html[dir="rtl"]#popupContentModal .newsletter_form_inner .newsletter_form p {
                text-align: right !important;
            }

            .newsletter_form_inner .newsletter_form {
                padding: 32px;
            }

            div#popupContentDiv .theme_btn {
                padding-top: 13.2px;
                padding-bottom: 13.2px;
            }

            @media (max-width: 991px) {
                .newsletter_form_wrapper .newsletter_form_inner .newsletter_form {
                    padding: 24px;
                }
            }
        </style>

        <div class="d-none" id="popupContentDiv">
            <div class="newsletter_form_wrapper newsletter_active" id="popupContentModal">
                <div class="newsletter_form_inner">
                    <div class="close_modal" onclick="closePopUpModel()">
                        <i class="fa fa-times"></i>
                    </div>
                    <div class="newsletter_form_thumb">
                    </div>
                    <div class="newsletter_form">
                        <h3 class="text-left">{{$popup->title}}</h3>
                        <p class="text-start">
                            {!! $popup->message !!}
                        </p>

                        <div class="row">
                            <div class="col-12 mt-10">
                                <a href="{{$popup->link}}"
                                   class="theme_btn text-center"> {{$popup->btn_txt}}</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <script>
            setTimeout(function () {
                $("#popupContentDiv").removeClass('d-none');
            }, 3000);

            function closePopUpModel() {
                $("#popupContentDiv").addClass('d-none');
            }
        </script>
    @endif


</div>
