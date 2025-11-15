<div>
    @if($cookie)
        <style>
            .remove_cart {
                margin-left: -22px;
                margin-right: 8px;
                cursor: pointer;
            }

            .theme_cookies {
                background: {{@$cookie->bg_color}};
            }

            .theme_cookies .cookie_btn {
                background: {{$cookie->text_color}};
            }

            .cookie-setting-details {
                transition: all 0.4s ease-in-out;
                max-width: 100% !important;
            }

            .height-none {
                height: 0;
                overflow: hidden;
            }

            .theme_btn_outline {
                background: transparent;
                border-radius: 5px;
                font-family: Source Sans Pro, sans-serif;
                font-size: 16px;
                color: var(--system_primery_color);
                font-weight: 600;
                padding: 21px 28px;
                text-transform: capitalize;
                display: inline-block;
                line-height: 1;
                border: 1px solid var(--system_primery_color);
            }

            .theme_btn_outline:hover {
                background: var(--system_primery_color);
                color: #ffffff
            }

            @media (min-width: 576px) {
                .modal-dialog {
                    max-width: 500px;
                }
            }

            @media (min-width: 1080px) {
                .modal-dialog {
                    max-width: 800px;
                }
            }
        </style>

        <div class="theme_cookies" style="display: none">
            <div class="theme_cookies_info flex-fill">
                <div class="icon">
                    <img src="{{asset(@$cookie->image)}}" alt="">
                </div>
                <p>{!! @$cookie->details !!}
                </p>
                <button type="button" class="cookie_btn" onclick="setCookies(1);">{{@$cookie->btn_text}}</button>
                <button type="button" class="cookie_btn cookeSettingModalBtn"
                >{{@$cookie->customize_btn_text}}</button>

                <!-- Modal -->
                <div class="modal fade" id="cookieSettingsModal" tabindex="-1" aria-labelledby="cookieModal"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalToggleLabel">{{__('setting.GDPR')}}</h5>
                                {{--                                <button type="button" class="btn-close" data-bs-dismiss="modal"--}}
                                {{--                                        aria-label="Close"></button>--}}
                            </div>
                            <div class="modal-body">
                                {!! @$cookie->gdpr_details !!}

                                <ul class="mt-3 cookie-setting-list">
                                    <li>
                                        <div class="d-flex align-items-center mb-2">
                                            <label class="primary_checkbox d-flex mb-0">
                                                <input type="checkbox" class="cookie_type" value="strictly" disabled
                                                       checked/>
                                                <span class="checkmark mr_15"></span>
                                                <span class="label_name">{{__('setting.Strictly Necessary')}}</span>
                                            </label>
                                            <i class="far fa-question-circle ms-2" style="cursor: pointer"
                                               onclick="displayCookieSettingDetails(this)"></i>
                                        </div>
                                        <p class="height-none cookie-setting-details my-3">
                                            {!! @$cookie->gdpr_strictly !!}
                                        </p>
                                    </li>

                                    <li>
                                        <div class="d-flex align-items-center mb-2">
                                            <label class="primary_checkbox d-flex mb-0">
                                                <input type="checkbox" class="cookie_type" value="performance"/>
                                                <span class="checkmark mr_15"></span>
                                                <span class="label_name">{{__('setting.Performance Cookies')}}</span>
                                            </label>
                                            <i class="far fa-question-circle ms-2" style="cursor: pointer"
                                               onclick="displayCookieSettingDetails(this)"></i>
                                        </div>
                                        <p class="height-none cookie-setting-details my-3">
                                            {!! @$cookie->gdpr_performance !!}
                                        </p>
                                    </li>

                                    <li>
                                        <div class="d-flex align-items-center mb-2">
                                            <label class="primary_checkbox d-flex mb-0">
                                                <input type="checkbox" class="cookie_type" value="functional"/>
                                                <span class="checkmark mr_15"></span>
                                                <span class="label_name">{{__('setting.Functional Cookies')}}</span>
                                            </label>
                                            <i class="far fa-question-circle ms-2" style="cursor: pointer"
                                               onclick="displayCookieSettingDetails(this)"></i>
                                        </div>
                                        <p class="height-none cookie-setting-details my-3">
                                            {!! @$cookie->gdpr_functional !!}
                                        </p>
                                    </li>

                                    <li>
                                        <div class="d-flex align-items-center mb-2">
                                            <label class="primary_checkbox d-flex mb-0">
                                                <input type="checkbox" class="cookie_type" value="targeting"/>
                                                <span class="checkmark mr_15"></span>
                                                <span class="label_name">{{__('setting.Targeting Cookies')}}</span>
                                            </label>
                                            <i class="far fa-question-circle ms-2" style="cursor: pointer"
                                               onclick="displayCookieSettingDetails(this)"></i>
                                        </div>
                                        <p class="height-none cookie-setting-details my-3">
                                            {!! @$cookie->gdpr_targeting !!}
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="setCookies();"
                                        class="theme_btn">{{@$cookie->gdpr_confirm_choice_btn_text}}
                                </button>
                                <button type="button"
                                        class="theme_btn_outline"
                                        onclick="setCookies(1);">{{@$cookie->gdpr_accept_all_btn_text}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    @endif

    <script>

        $('#cookieSettingsModal').on('hidden.bs.modal', function () {
            $(this).attr('aria-hidden', 'true');
        });

        $(document).ready(function () {
            @if($cookie->allow)
            checkCookie();
            @endif
        });
        $(document).on('click', '.cookeSettingModalBtn', function () {
            $('#cookieSettingsModal').modal('show');
        });


        function setCookies(type = 0) {
            $('.theme_cookies').hide(500);
            let d = new Date();

            let items;
            if (type === 1) {
                items = $('.cookie_type');
            } else {
                items = $(".cookie_type:checked");
            }
            // set type of cookie allow
            items.each(function () {
                document.cookie = $(this).val() + "_allow=1; expires=Thu, 21 Dec " + (d.getFullYear() + 1) + " 12:00:00 UTC";

            });
            //set allow cookie
            document.cookie = "allow=1; expires=Thu, 21 Dec " + (d.getFullYear() + 1) + " 12:00:00 UTC";

            //hide modal if open modal
            $('#cookieSettingsModal').modal('hide');
        }

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function checkCookie() {
            var check = getCookie("allow");
            if (check != "") {
                $('.theme_cookies').hide();
            } else {
                $('.theme_cookies').show();
            }
        }

        // function to show hide cookie setting details

        function displayCookieSettingDetails(element) {
            let cookieSettingElement = element.parentElement;
            let detailsElement = cookieSettingElement.parentElement.querySelector(".cookie-setting-details");
            detailsElement.classList.toggle("height-none")
        }
    </script>
</div>
