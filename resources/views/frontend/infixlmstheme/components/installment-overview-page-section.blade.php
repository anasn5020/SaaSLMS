<link rel="stylesheet" href="{{ asset('Modules/Installment/Resources/assets/css/installment_verification.css') }}">

<div class="installment">
    <div class="container">
        <form action="{{ route('installment.submit_request') }}" id="installment_checkout_form" method="post"
              enctype="multipart/form-data">
            @csrf

            <input type="text" hidden name="topic_id" value="{{ $installmentData['topic']->id }}">
            <input type="text" hidden name="plan_id" value="{{ $installmentData['plan']->id }}">
            <div class="row">
                <div class="col-12">
                    <div class="installment-card">
                        <div class="overview d-flex flex-wrap">
                            <div class="overview-left">
                                <div class="img"><img src="{{ asset($installmentData['plan']->banner) }}"
                                                      alt=""></div>
                            </div>
                            <div class="overview-right">
                                <h3>{{ _trans('installment.Installment Overview') }}</h3>
                                <strong>
                                    {{ @$installmentData['plan']->getTranslation('title', auth()->user()->language_code ?? 'en') }}
                                </strong>
                                <p>{!! @$installmentData['plan']->getTranslation('description', auth()->user()->language_code ?? 'en') !!}</p>

                                <div class="d-flex align-items-center flex-wrap">
                                    <span class="d-inline-block theme_btn">
                                        <svg width="29" height="30" viewBox="0 0 29 30" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.38281 12.8311H26.3554" stroke="white" stroke-width="2"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path
                                                d="M13.8182 25.4164H7.69327C3.43815 25.4164 2.35938 24.3616 2.35938 20.1545V10.3017C2.35938 6.49011 3.24639 5.26752 6.59056 5.07574C6.92617 5.06375 7.29773 5.05176 7.69327 5.05176H21.01C25.2651 5.05176 26.3439 6.10655 26.3439 10.3137V15.5997"
                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path d="M7.19531 20.0225H11.9898" stroke="white" stroke-width="2"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path
                                                d="M26.3546 22.421C26.3546 23.3199 26.1029 24.171 25.6594 24.8901C24.8324 26.2805 23.3101 27.2155 21.5601 27.2155C19.8101 27.2155 18.2879 26.2805 17.4608 24.8901C17.0174 24.171 16.7656 23.3199 16.7656 22.421C16.7656 19.772 18.9112 17.6265 21.5601 17.6265C24.2091 17.6265 26.3546 19.772 26.3546 22.421Z"
                                                stroke="white" stroke-width="2" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M19.6875 22.4193L20.8741 23.6059L23.4272 21.2446" stroke="white"
                                                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>{{ @$installmentData['installment_overview']['upfront'] }}
                                        {{ _trans('installment.Upfront') }}
                                    </span>
                                    <span class="d-inline-block theme_btn">
                                        <svg width="31" height="31" viewBox="0 0 31 31" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.6875 16.0029H24.2628" stroke="white" stroke-width="2"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path
                                                d="M24.2628 13.0459V22.1202C24.2247 25.7372 23.2347 26.651 19.4654 26.651H7.48486C3.65208 26.651 2.6875 25.6991 2.6875 21.9171V13.0459C2.6875 9.61922 3.48705 8.51507 6.4949 8.33739C6.79949 8.3247 7.12951 8.31201 7.48486 8.31201H19.4654C23.2982 8.31201 24.2628 9.26386 24.2628 13.0459Z"
                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path
                                                d="M28.0675 8.54051V17.4118C28.0675 20.8384 27.2679 21.9426 24.2601 22.1202V13.0459C24.2601 9.26391 23.2955 8.31206 19.4627 8.31206H7.48215C7.12679 8.31206 6.79678 8.32476 6.49219 8.33745C6.53026 4.72042 7.52022 3.80664 11.2896 3.80664H23.2701C27.1029 3.80664 28.0675 4.75849 28.0675 8.54051Z"
                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path d="M6.8125 22.6025H8.99537" stroke="white" stroke-width="2"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M11.7109 22.6025H16.0768" stroke="white" stroke-width="2"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                        </svg>{{ @$installmentData['installment_overview']['total_installment_count'] }}
                                        {{ _trans('installment.Installments') }}
                                        ({{ @$installmentData['installment_overview']['total_installment_amount'] }})
                                    </span>
                                    <span class="d-inline-block theme_btn">
                                        <svg width="29" height="28" viewBox="0 0 29 28" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.1562 17.1857C10.1562 18.8229 11.4127 20.1428 12.9737 20.1428H16.1593C17.5172 20.1428 18.6214 18.9879 18.6214 17.5664C18.6214 16.0181 17.9487 15.4724 16.9461 15.117L11.8315 13.3402C10.8289 12.9849 10.1562 12.4391 10.1562 10.8908C10.1562 9.46936 11.2604 8.31445 12.6184 8.31445H15.8039C17.3649 8.31445 18.6214 9.63435 18.6214 11.2715"
                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path d="M14.375 6.61377V21.8434" stroke="white" stroke-width="2"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                d="M18.1862 26.9198H10.5714C4.22577 26.9198 1.6875 24.3815 1.6875 18.0358V10.421C1.6875 4.07538 4.22577 1.53711 10.5714 1.53711H18.1862C24.5319 1.53711 27.0702 4.07538 27.0702 10.421V18.0358C27.0702 24.3815 24.5319 26.9198 18.1862 26.9198Z"
                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                        </svg>{{ @$installmentData['installment_overview']['total_payable_amount'] }}
                                        {{ _trans('installment.Total Amount') }}
                                    </span>
                                    <span class="d-inline-block theme_btn">
                                        <svg width="26" height="28" viewBox="0 0 26 28" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.3125 1.5376V5.345" stroke="white" stroke-width="2"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M18.4688 1.5376V5.345" stroke="white" stroke-width="2"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M2.60156 10.5356H24.1768" stroke="white" stroke-width="2"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path
                                                d="M24.8132 9.78707V20.5747C24.8132 24.3821 22.9095 26.9204 18.4675 26.9204H8.31442C3.87245 26.9204 1.96875 24.3821 1.96875 20.5747V9.78707C1.96875 5.97967 3.87245 3.44141 8.31442 3.44141H18.4675C22.9095 3.44141 24.8132 5.97967 24.8132 9.78707Z"
                                                stroke="white" stroke-width="2" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M18.0807 16.3865H18.0921" stroke="white" stroke-width="3"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M18.0807 20.1941H18.0921" stroke="white" stroke-width="3"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M13.3854 16.3865H13.3968" stroke="white" stroke-width="3"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M13.3854 20.1941H13.3968" stroke="white" stroke-width="3"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M8.6901 16.3865H8.7015" stroke="white" stroke-width="3"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M8.6901 20.1941H8.7015" stroke="white" stroke-width="3"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>{{ @$installmentData['installment_overview']['installment_duration'] }}
                                        {{ _trans('installment.Days Duration') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($installmentData['plan']->verification_required == 1)
                        <div class="installment-card">
                            <div class="installment-card-title">
                                <h4>{{ _trans('installment.Verify Installments') }}</h4>
                                <p>
                                    {!! $installmentData['plan']->verification_description !!}
                                </p>
                            </div>
                            @if ($installmentData['plan']->verification_banner)
                                <div class="installment-card-img">
                                    <img class="verification_banner_img"
                                         src="{{asset($installmentData['plan']->verification_banner)}}" alt=""
                                         width="100%" height="auto">
                                </div>
                            @else
                                <div
                                    class="installment-step d-flex align-items-center flex-wrap justify-content-between">
                                    <div class="installment-step-card selected">
                                        <div class="icon"><img
                                                src="{{ asset('Modules/Installment/Resources/assets/images/1.png') }}"
                                                alt=""></div>
                                        <h5>{{ _trans('installment.Select A Plan') }}</h5>
                                    </div>
                                    <div class="installment-step-card">
                                        <div class="icon"><img
                                                src="{{ asset('Modules/Installment/Resources/assets/images/2.png') }}"
                                                alt=""></div>
                                        <h5>{{ _trans('installment.Upload Proof') }}</h5>
                                    </div>
                                    <div class="installment-step-card">
                                        <div class="icon"><img
                                                src="{{ asset('Modules/Installment/Resources/assets/images/3.png') }}"
                                                alt=""></div>
                                        <h5>{{ _trans('installment.Send Proof') }}</h5>
                                    </div>
                                    <div class="installment-step-card">
                                        <div class="icon"><img
                                                src="{{ asset('Modules/Installment/Resources/assets/images/4.png') }}"
                                                alt=""></div>
                                        <h5>{{ _trans('installment.Get Verified') }}</h5>
                                    </div>
                                </div>
                            @endif
                            <style>
                                .installment-card-video {
                                    width: 100%;
                                    padding-bottom: 50%;
                                    height: auto;
                                    border-radius: 20px;
                                    overflow: hidden;
                                    position: relative;
                                }

                                .video {
                                    position: absolute;
                                    left: 0;
                                    top: 0;
                                    opacity: 1;
                                    width: 100%;
                                    height: 100%;
                                    object-fit: cover;
                                }

                                .text-primary {
                                    color: var(--system_primery_color) !important;
                                }
                            </style>
                            @if($installmentData['plan']->verification_video != null)
                                <div class="installment-card-video mt_30">
                                    <video class="video" controls>
                                        <source src="{{asset($installmentData['plan']->verification_video)}}"
                                                type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>

                            @endif


                            {{-- <img src="{{asset($installmentData['plan']->verification_banner)}}" alt=""> --}}
                        </div>
                    @endif
                    @if ($installmentData['plan']->request_uploads == 1 && ($installmentData['plan']->bypass_verification_for_verified_users != 1 || auth()->user()->installment_verified != 1))
                        <div class="installment-card">
                            <div class="installment-card-title">
                                <h4>{{ _trans('installment.Attachments') }}</h4>
                                <p>{{ _trans('installment.Attach your documents and send them to admin') }}</p>
                            </div>
                            <div class="attachments-box">
                                <div class="form-box mb_30">
                                    <label for="#"
                                           class="primary_label2">{{ _trans('installment.Title') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="primary_input rounded-pill sub_attach_title"
                                           name="title[]"
                                           placeholder="{{ _trans('installment.Title') }} ">
                                </div>
                                <div class="form-box">
                                    <label for="#"
                                           class="primary_label2">{{ _trans('installment.Attach a file') }} <span
                                            class="text-danger">*</span></label>
                                    <label for="uploadImg" class="form-uploader">
                                        <input type="file" name="file[]" class="d-none file_upload sub_attach_file"
                                               id="uploadImg">
                                        <span class="show_file_name">{{ _trans('installment.Browse File') }}</span>
                                        <a class="theme_btn rounded-pill">{{ _trans('installment.Browse') }}</a>
                                    </label>
                                </div>
                            </div>

                            <div id="appendAttchBox"></div>
                            <div class="action d-flex align-items-center justify-content-end flex-wrap mt_30">
                                {{-- <button class="theme_btn rounded-pill">Send</button> --}}
                                <a href="#" class="theme_btn rounded-pill" id="appendMore"><i
                                        class="fa fa-plus-circle"></i>
                                    {{ _trans('installment.Add More Attachment') }}</a>
                            </div>
                        </div>
                    @endif
                    <div class="installment-card">
                        <h4 class="text-uppercase text-primary f_w_700">{{ _trans('installment.Installment Terms & Rules') }}
                        </h4>
                        {!! Settings('installment_terms_policy') != '0' ? Settings('installment_terms_policy') : '' !!}

                        <div class="action d-flex align-items-center justify-content-end flex-wrap mt_30">
                            <button class="theme_btn rounded-pill" id="installment_checkout"
                                    type="button">{{ _trans('installment.Checkout') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $(document).on('click', '#appendMore', function (e) {
        e.preventDefault();
        var random_num = Math.floor(Math.random() * 1000000000);
        $('#appendAttchBox').append(
            `<div class="attachments-box">
                <button class="attachments-remove"><i class="fa fa-trash-alt"></i></button>
                <div class="form-box mb_30">
                    <label for="#" class="primary_label2">{{ _trans('installment.Title') }}</label>
                    <input type="text" name="title[]" class="primary_input rounded-pill sub_attach_title" placeholder="{{ _trans('installment.Title') }} ">
                </div>
                <div class="form-box">
                    <label for="#" class="primary_label2">{{ _trans('installment.Attach a file') }}</label>
                    <label for="uploadImg_${random_num}" class="form-uploader">
                        <input type="file" name="file[]" class="d-none file_upload sub_attach_file" id="uploadImg_${random_num}">
                        <span>{{ _trans('installment.Browse File') }}</span>
                        <a class="theme_btn rounded-pill">Browse</a>
                    </label>
                </div>
            </div>`
        )
        $(document).on('click', '.attachments-remove', function (e) {
            $(this).parent().remove();
        })

    })
    $(document).on('click', '#installment_checkout', function (e) {
        e.preventDefault();
        var form = $('#installment_checkout_form');

        var sub_attach_file = $('.sub_attach_file');
        var sub_attach_title = $('.sub_attach_title');

        var file_selected = true;
        $.each(sub_attach_file, function (index, value) {
            if ($(value).val() == '') {
                file_selected = false;
            }
        })
        var title_selected = true;
        $.each(sub_attach_title, function (index, value) {
            if ($(value).val() == '') {
                title_selected = false;
            }
        })
        if (file_selected == true && title_selected == true) {
            form.submit();
            return;
        } else {
            toastr.warning("Please upload verification file with title", "Warning");
            return;
        }
        form.submit();

    })

    $(document).on('change', '.file_upload', function (e) {
        $(this).parent().find('span').text($(this).val().split('\\').pop());
    })
</script>
