<div>
    <style>
        #myHomepageCourse.owl-carousel .owl-stage-outer {
            overflow: hidden !important
        }
    </style>
    @php
        $total =\Illuminate\Support\Facades\Auth::user()->totalStudentCourses();



        $isGamification =Settings('gamification_status') && Settings('gamification_leaderboard_show_badges_status');

        if (count($noticeboards)==0 && !$isGamification){
            $col =12;
            $item =4;
        }else{
            $col=6;
             $item =6;
        }

    @endphp
    <div class="main_content_iner main_content_padding">

        <div class="container-fluid g-0">
            <!-- bootstrap 4 remove g-0 and add g-0 -->
            <div class="row">
                <div class="col-12">
                    <div class="dashboard_title">
                        <h3>{{@$wish_string}}, <span>{{Auth::user()->name}}</span></h3>
                        <p>{{@$date}}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-{{$col}} col-12">
                    <div class="row">
                        @if(showEcommerce())
                            <div class="col-lg-{{$item}} col-md-4 col-sm-{{$item}}">
                                <div class="dashboard_card text-center">
                                    <div class="icon mx-auto">
                                        <svg width="75" height="75" viewBox="0 0 75 75" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect width="75" height="75" rx="37.5" fill="url(#paint0_linear_634_265)"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M42.4439 37.667C42.168 36.887 41.6572 36.2117 40.9817 35.7341C40.3062 35.2565 39.4992 35 38.6719 35V34H36.6719V35C35.611 35 34.5936 35.4214 33.8434 36.1716C33.0933 36.9217 32.6719 37.9391 32.6719 39C32.6719 40.0609 33.0933 41.0783 33.8434 41.8284C34.5936 42.5786 35.611 43 36.6719 43V47C35.8019 47 35.0609 46.445 34.7849 45.667C34.7439 45.5397 34.6779 45.4219 34.5906 45.3206C34.5033 45.2193 34.3966 45.1365 34.2768 45.0772C34.157 45.0178 34.0265 44.9831 33.8931 44.9751C33.7596 44.967 33.6259 44.9858 33.4998 45.0304C33.3737 45.0749 33.2579 45.1443 33.1591 45.2344C33.0603 45.3245 32.9806 45.4335 32.9246 45.5549C32.8687 45.6764 32.8377 45.8078 32.8334 45.9415C32.8292 46.0751 32.8518 46.2082 32.8999 46.333C33.1757 47.113 33.6866 47.7883 34.3621 48.2659C35.0376 48.7435 35.8446 49 36.6719 49V50H38.6719V49C39.7327 49 40.7502 48.5786 41.5003 47.8284C42.2504 47.0783 42.6719 46.0609 42.6719 45C42.6719 43.9391 42.2504 42.9217 41.5003 42.1716C40.7502 41.4214 39.7327 41 38.6719 41V37C39.0855 36.9999 39.489 37.128 39.8267 37.3668C40.1645 37.6055 40.4199 37.9431 40.5579 38.333C40.6462 38.5831 40.8302 38.7879 41.0695 38.9023C41.188 38.9589 41.3165 38.9917 41.4477 38.9987C41.5788 39.0056 41.71 38.9867 41.8339 38.943C41.9577 38.8993 42.0717 38.8316 42.1694 38.7438C42.2671 38.656 42.3465 38.5498 42.4031 38.4313C42.4598 38.3128 42.4925 38.1844 42.4995 38.0532C42.5065 37.9221 42.4876 37.7908 42.4439 37.667ZM36.6719 37C36.1414 37 35.6327 37.2107 35.2577 37.5858C34.8826 37.9609 34.6719 38.4696 34.6719 39C34.6719 39.5304 34.8826 40.0391 35.2577 40.4142C35.6327 40.7893 36.1414 41 36.6719 41V37ZM38.6719 47C39.2023 47 39.711 46.7893 40.0861 46.4142C40.4612 46.0391 40.6719 45.5304 40.6719 45C40.6719 44.4696 40.4612 43.9609 40.0861 43.5858C39.711 43.2107 39.2023 43 38.6719 43V47Z"
                                                  fill="white"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M26.8249 21.621C29.2789 20.42 33.3049 19 37.7109 19C42.0249 19 45.9449 20.361 48.3859 21.546L48.5239 21.613C49.2599 21.977 49.8539 22.321 50.2719 22.6L46.5779 28C55.0939 36.706 61.6719 54.997 37.7109 54.997C13.7499 54.997 20.1509 37.038 28.7409 28L25.0709 22.6C25.3539 22.415 25.7129 22.2 26.1409 21.972C26.3529 21.858 26.5809 21.741 26.8249 21.622V21.621ZM44.2039 27.928L47.1609 23.605C44.4109 23.803 41.1389 24.449 37.9889 25.361C35.7389 26.011 33.2389 25.912 30.9239 25.485C30.3405 25.3768 29.7611 25.2481 29.1869 25.099L31.1069 27.926C35.2219 29.391 40.0879 29.391 44.2039 27.928ZM29.9519 29.63C34.7669 31.49 40.5539 31.49 45.3689 29.628C47.3787 31.7467 49.06 34.1544 50.3569 36.771C51.7089 39.529 52.4449 42.286 52.3249 44.662C52.2089 46.955 51.3069 48.914 49.2469 50.37C47.0999 51.887 43.4889 52.997 37.7099 52.997C31.9249 52.997 28.2969 51.906 26.1299 50.406C24.0549 48.968 23.1439 47.036 23.0149 44.774C22.8799 42.424 23.5999 39.681 24.9469 36.904C26.2319 34.256 28.0249 31.707 29.9519 29.63ZM28.8019 22.916C29.6019 23.154 30.4379 23.361 31.2859 23.518C33.4359 23.914 35.5919 23.972 37.4319 23.439C39.5761 22.8143 41.7569 22.3231 43.9619 21.968C42.1219 21.414 39.9699 21 37.7099 21C34.2649 21 31.0519 21.961 28.8019 22.916Z"
                                                  fill="white"/>
                                            <defs>
                                                <linearGradient id="paint0_linear_634_265" x1="0" y1="0" x2="75" y2="75"
                                                                gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#868CFF"/>
                                                    <stop offset="1" stop-color="#0066FF"/>
                                                </linearGradient>
                                            </defs>
                                        </svg>

                                    </div>
                                    <span>{{__('frontend.Balance')}}</span>
                                    <h4>
                                        @if(Auth::user()->balance==0)
                                            {{Settings('currency_symbol') ??'৳'}} 0
                                        @else
                                            {{getPriceFormat(Auth::user()->balance)}}
                                        @endif
                                    </h4>
                                </div>
                            </div>
                            <div class="col-lg-{{$item}} col-md-4 col-sm-{{$item}}">
                                <div class="dashboard_card text-center">
                                    <div class="icon mx-auto">
                                        <svg width="75" height="75" viewBox="0 0 75 75" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect width="75" height="75" rx="37.5" fill="url(#paint0_linear_634_285)"/>
                                            <path
                                                d="M21 34.6667V30.3333C21 29.1841 21.398 28.0819 22.1065 27.2692C22.815 26.4565 23.7758 26 24.7778 26H28.5556M21 34.6667C23.5179 34.6667 28.5556 32.9333 28.5556 26M21 34.6667V43.3333M55 34.6667V30.3333C55 29.1841 54.602 28.0819 53.8935 27.2692C53.185 26.4565 52.2242 26 51.2222 26H47.4444M55 34.6667C52.4821 34.6667 47.4444 32.9333 47.4444 26M55 34.6667V43.3333M28.5556 26H47.4444M21 43.3333V47.6667C21 48.8159 21.398 49.9181 22.1065 50.7308C22.815 51.5435 23.7758 52 24.7778 52H28.5556M21 43.3333C23.5179 43.3333 28.5556 45.0667 28.5556 52M28.5556 52H36.1111"
                                                stroke="white" stroke-width="2.5" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path
                                                d="M38.5013 43.3334C40.8945 43.3334 42.8346 41.3933 42.8346 39C42.8346 36.6068 40.8945 34.6667 38.5013 34.6667C36.1081 34.6667 34.168 36.6068 34.168 39C34.168 41.3933 36.1081 43.3334 38.5013 43.3334Z"
                                                stroke="white" stroke-width="2.5" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path d="M46 49H55" stroke="white" stroke-width="2.5" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <defs>
                                                <linearGradient id="paint0_linear_634_285" x1="6.5" y1="7.5" x2="63"
                                                                y2="62.5" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#BB0000"/>
                                                    <stop offset="1" stop-color="#FF6565"/>
                                                </linearGradient>
                                            </defs>
                                        </svg>

                                    </div>
                                    <span>{{__('frontend.Total Spent')}}</span>
                                    <h4>
                                        @if($total_spent!=0)
                                            {{getPriceFormat($total_spent)}}
                                        @else
                                            {{Settings('currency_symbol') ??'৳'}}  0
                                        @endif
                                    </h4>
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-{{$item}} col-md-4 col-sm-{{$item}}">
                            <div class="dashboard_card text-center">
                                <div class="icon mx-auto">
                                    <svg width="75" height="75" viewBox="0 0 75 75" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect width="75" height="75" rx="37.5" fill="url(#paint0_linear_634_276)"/>
                                        <path
                                            d="M42.2667 51.9333H41.2C41.2 52.1314 41.2552 52.3256 41.3593 52.4941C41.4634 52.6626 41.6125 52.7988 41.7896 52.8874C41.9668 52.976 42.1652 53.0135 42.3625 52.9957C42.5597 52.9779 42.7482 52.9055 42.9067 52.7867L42.2667 51.9333ZM46.5333 48.7333L47.1733 47.88C46.9887 47.7415 46.7641 47.6667 46.5333 47.6667C46.3025 47.6667 46.078 47.7415 45.8933 47.88L46.5333 48.7333ZM50.8 51.9333L50.16 52.7867C50.3185 52.9055 50.5069 52.9779 50.7042 52.9957C50.9015 53.0135 51.0998 52.976 51.277 52.8874C51.4542 52.7988 51.6032 52.6626 51.7074 52.4941C51.8115 52.3256 51.8667 52.1314 51.8667 51.9333H50.8ZM46.5333 44.4667C45.1188 44.4667 43.7623 43.9048 42.7621 42.9046C41.7619 41.9044 41.2 40.5478 41.2 39.1333H39.0667C39.0667 41.1136 39.8533 43.0128 41.2536 44.4131C42.6539 45.8133 44.553 46.6 46.5333 46.6V44.4667ZM51.8667 39.1333C51.8667 40.5478 51.3048 41.9044 50.3046 42.9046C49.3044 43.9048 47.9478 44.4667 46.5333 44.4667V46.6C48.5136 46.6 50.4128 45.8133 51.8131 44.4131C53.2133 43.0128 54 41.1136 54 39.1333H51.8667ZM46.5333 33.8C47.9478 33.8 49.3044 34.3619 50.3046 35.3621C51.3048 36.3623 51.8667 37.7188 51.8667 39.1333H54C54 37.153 53.2133 35.2539 51.8131 33.8536C50.4128 32.4533 48.5136 31.6667 46.5333 31.6667V33.8ZM46.5333 31.6667C44.553 31.6667 42.6539 32.4533 41.2536 33.8536C39.8533 35.2539 39.0667 37.153 39.0667 39.1333H41.2C41.2 37.7188 41.7619 36.3623 42.7621 35.3621C43.7623 34.3619 45.1188 33.8 46.5333 33.8V31.6667ZM41.2 43.4V51.9333H43.3333V43.4H41.2ZM42.9067 52.7867L47.1733 49.5867L45.8933 47.88L41.6267 51.08L42.9067 52.7867ZM45.8933 49.5867L50.16 52.7867L51.44 51.08L47.1733 47.88L45.8933 49.5867ZM51.8667 51.9333V43.4H49.7333V51.9333H51.8667ZM54 31.6667V24.2H51.8667V31.6667H54ZM50.8 21H25.2V23.1333H50.8V21ZM22 24.2V49.8H24.1333V24.2H22ZM25.2 53H39.0667V50.8667H25.2V53ZM22 49.8C22 50.6487 22.3371 51.4626 22.9373 52.0627C23.5374 52.6629 24.3513 53 25.2 53V50.8667C24.9171 50.8667 24.6458 50.7543 24.4458 50.5542C24.2457 50.3542 24.1333 50.0829 24.1333 49.8H22ZM25.2 21C24.3513 21 23.5374 21.3371 22.9373 21.9373C22.3371 22.5374 22 23.3513 22 24.2H24.1333C24.1333 23.9171 24.2457 23.6458 24.4458 23.4458C24.6458 23.2457 24.9171 23.1333 25.2 23.1333V21ZM54 24.2C54 23.3513 53.6629 22.5374 53.0627 21.9373C52.4626 21.3371 51.6487 21 50.8 21V23.1333C51.0829 23.1333 51.3542 23.2457 51.5542 23.4458C51.7543 23.6458 51.8667 23.9171 51.8667 24.2H54ZM28.4 31.6667H39.0667V29.5333H28.4V31.6667ZM28.4 38.0667H34.8V35.9333H28.4V38.0667Z"
                                            fill="white"/>
                                        <defs>
                                            <linearGradient id="paint0_linear_634_276" x1="14.4778" y1="-3.12711e-08"
                                                            x2="55.6045" y2="68.474" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#65FFB5"/>
                                                <stop offset="1" stop-color="#18AD77"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>

                                </div>
                                <span>{{__('frontend.Certificates')}}</span>
                                <h4> {{\Illuminate\Support\Facades\Auth::user()->totalCertificate()}}</h4>
                            </div>
                        </div>
                        <div class="col-lg-{{$item}} col-md-4 col-sm-{{$item}}">
                            <div class="dashboard_card text-center">
                                <div class="icon mx-auto">
                                    <svg width="75" height="75" viewBox="0 0 75 75" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect width="75" height="75" rx="37.5" fill="url(#paint0_linear_634_297)"/>
                                        <path
                                            d="M37.9993 20V23.4M46.4993 22.278L44.7993 25.2224M52.7213 28.5L49.7769 30.2M54.9993 37H51.5993M52.7213 45.5L49.7769 43.8M46.4993 51.722L44.7993 48.7776M37.9993 54V50.6M29.4993 51.722L31.1993 48.7776M23.2773 28.5L26.2217 30.2M29.4993 22.278L31.1993 25.2224"
                                            stroke="white" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                        <defs>
                                            <linearGradient id="paint0_linear_634_297" x1="0" y1="0" x2="75" y2="75"
                                                            gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#BB86FF"/>
                                                <stop offset="1" stop-color="#561BFF"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>

                                </div>
                                <span>{{__('frontend.Course In Progress')}}</span>
                                <h4> {{$total['process']}}</h4>
                            </div>
                        </div>
                        <div class="col-lg-{{$item}} col-md-4 col-sm-{{$item}}">
                            <div class="dashboard_card text-center">
                                <div class="icon mx-auto">
                                    <svg width="75" height="75" viewBox="0 0 75 75" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect y="3.05176e-05" width="75" height="75" rx="37.5"
                                              fill="url(#paint0_linear_634_306)"/>
                                        <path
                                            d="M25 24.25C25 23.504 25.1964 22.7712 25.5694 22.1251C25.9424 21.479 26.4789 20.9425 27.125 20.5695V49.75C27.125 50.3136 27.3489 50.8541 27.7474 51.2526C28.1459 51.6511 28.6864 51.875 29.25 51.875H46.25C46.8136 51.875 47.3541 51.6511 47.7526 51.2526C48.1511 50.8541 48.375 50.3136 48.375 49.75V24.25C48.375 23.6864 48.1511 23.1459 47.7526 22.7474C47.3541 22.3489 46.8136 22.125 46.25 22.125H42V20H46.25C47.3772 20 48.4582 20.4478 49.2552 21.2448C50.0522 22.0419 50.5 23.1229 50.5 24.25V49.75C50.5 50.8772 50.0522 51.9582 49.2552 52.7552C48.4582 53.5523 47.3772 54 46.25 54H29.25C28.1228 54 27.0418 53.5523 26.2448 52.7552C25.4478 51.9582 25 50.8772 25 49.75V24.25ZM29.25 20V33.8125C29.25 34.0098 29.3049 34.2033 29.4087 34.3711C29.5124 34.539 29.6608 34.6746 29.8373 34.7629C30.0138 34.8511 30.2114 34.8885 30.4079 34.8707C30.6044 34.853 30.7921 34.7809 30.95 34.6625L34.5625 31.9532L38.175 34.6625C38.3329 34.7809 38.5206 34.853 38.7171 34.8707C38.9136 34.8885 39.1112 34.8511 39.2877 34.7629C39.4642 34.6746 39.6126 34.539 39.7163 34.3711C39.8201 34.2033 39.875 34.0098 39.875 33.8125V20H29.25ZM31.375 31.6875V22.125H37.75V31.6875L35.2 29.775C35.0161 29.6371 34.7924 29.5625 34.5625 29.5625C34.3326 29.5625 34.1089 29.6371 33.925 29.775L31.375 31.6875Z"
                                            fill="white"/>
                                        <defs>
                                            <linearGradient id="paint0_linear_634_306" x1="37.5" y1="3.05176e-05"
                                                            x2="37.5" y2="75" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FF930F"/>
                                                <stop offset="1" stop-color="#FFDE2E"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>

                                </div>
                                <span>{{__('frontend.Course Purchased')}}</span>
                                <h4> {{$total['total']}}</h4>
                            </div>
                        </div>
                        <div class="col-lg-{{$item}} col-md-4 col-sm-{{$item}}">
                            <div class="dashboard_card text-center">
                                <div class="icon mx-auto">
                                    <svg width="75" height="75" viewBox="0 0 75 75" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect y="3.05176e-05" width="75" height="75" rx="37.5"
                                              fill="url(#paint0_linear_634_315)"/>
                                        <path
                                            d="M54.1007 26.1984L38.4094 21.0604C38.1432 20.9799 37.8584 20.9799 37.5922 21.0604L21.9173 26.1984H21.8846L21.7211 26.2787H21.7048L21.5413 26.375C21.5413 26.3911 21.525 26.3911 21.5086 26.4072L21.3779 26.5195L21.2635 26.648C21.2635 26.6641 21.2471 26.6641 21.2471 26.6801L21.1491 26.8246C21.1491 26.8407 21.1491 26.8407 21.1327 26.8567L21.0673 27.0012L21.0183 27.1779V27.226C21.0022 27.2889 20.9967 27.354 21.0019 27.4187V40.2638C21.0019 40.6044 21.1397 40.9312 21.3849 41.172C21.6302 41.4129 21.9628 41.5483 22.3096 41.5483C22.6564 41.5483 22.9889 41.4129 23.2342 41.172C23.4794 40.9312 23.6172 40.6044 23.6172 40.2638V29.201L29.1091 30.9993C28.0773 32.6216 27.5334 34.4974 27.54 36.4102C27.5406 38.15 27.9908 39.861 28.8484 41.3832C29.7061 42.9053 30.9431 44.1886 32.4435 45.1128C29.3255 46.2715 26.6636 48.3746 24.843 51.1178C24.6575 51.4061 24.5946 51.7544 24.668 52.0878C24.7413 52.4212 24.9451 52.7129 25.2353 52.9001C25.3777 52.9928 25.5375 53.0568 25.7053 53.0884C25.8731 53.12 26.0456 53.1186 26.2128 53.0843C26.38 53.0499 26.5387 52.9833 26.6795 52.8883C26.8203 52.7933 26.9406 52.6718 27.0333 52.5308C28.2201 50.7349 29.8452 49.2589 31.7606 48.2371C33.6761 47.2153 35.8212 46.6801 38.0008 46.6801C40.1805 46.6801 42.3256 47.2153 44.241 48.2371C46.1564 49.2589 47.7815 50.7349 48.9683 52.5308C49.0877 52.7089 49.2503 52.8549 49.4415 52.9558C49.6327 53.0568 49.8464 53.1093 50.0635 53.1088C50.314 53.1114 50.5592 53.0386 50.7663 52.9001C51.0565 52.7129 51.2603 52.4212 51.3336 52.0878C51.407 51.7544 51.3442 51.4061 51.1586 51.1178C49.338 48.3746 46.6761 46.2715 43.5581 45.1128C45.0585 44.1886 46.2955 42.9053 47.1532 41.3832C48.0108 39.861 48.461 38.15 48.4616 36.4102C48.4682 34.4974 47.9243 32.6216 46.8925 30.9993L54.1007 28.639C54.3623 28.5545 54.5901 28.3911 54.7516 28.1719C54.9131 27.9528 55 27.6892 55 27.4187C55 27.1482 54.9131 26.8846 54.7516 26.6655C54.5901 26.4463 54.3623 26.2829 54.1007 26.1984ZM45.8464 36.4102C45.8464 38.4543 45.0198 40.4146 43.5485 41.8599C42.0772 43.3053 40.0816 44.1173 38.0008 44.1173C35.92 44.1173 33.9245 43.3053 32.4531 41.8599C30.9818 40.4146 30.1552 38.4543 30.1552 36.4102C30.1583 34.7657 30.6904 33.1641 31.6753 31.8342L37.5922 33.777C37.8576 33.8628 38.144 33.8628 38.4094 33.777L44.3263 31.8342C45.3113 33.1641 45.8433 34.7657 45.8464 36.4102ZM44.3263 29.1367H44.31L38.0008 31.208L31.6916 29.1367H31.6753L26.4449 27.4187L38.0008 23.6294L49.5568 27.4187L44.3263 29.1367Z"
                                            fill="white"/>
                                        <defs>
                                            <linearGradient id="paint0_linear_634_315" x1="14.4778" y1="3.04863e-05"
                                                            x2="55.6045" y2="68.474" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#005CE6"/>
                                                <stop offset="1" stop-color="#81D9FF"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>

                                </div>
                                <span>{{__('frontend.Completed Courses')}}</span>
                                <h4>{{$total['complete']}}</h4>
                            </div>
                        </div>

                        <div class="col-12 ">
                            <div id="myHomepageCourse" class="owl-carousel">
                                @if($mycourse)
                                    @foreach($mycourse as $key=>$single_course)
                                        @if($key<5)
                                            @php
                                                $course =$single_course->course;
                                                   $percentage =round($course->loginUserTotalPercentage);
                                                   if ($percentage>=100){
                                                       continue;
                                                   }
                                            @endphp

                                            <div class="dashboard_card dashboard_banner ">
                                                <div class="thumb position-relative"
                                                     style="background-image: url('{{getCourseImage($course->image)}}')"
                                                >
                                                    <span class="badge ms-3 mt-2">{{$course->courseLevel->title}}</span>
                                                </div>
                                                <div class="banner_info">
                                                    <div class="course_qualification mb-2">
                                                        <a href="#"
                                                           class="banner_info_profile d-flex align-items-center">
                                                            <div class="img"><img
                                                                    src="{{getProfileImage($course->user->image,$course->user->name)}}"
                                                                    alt="">
                                                            </div>
                                                            <p>{{$course->user->name}}</p>
                                                        </a>
                                                        <div class="starts d-flex">

                                                            <div class="stars">
                                                                @php

                                                                    $main_stars=$course->total_rating;

                                                                    $stars=intval($course->total_rating);

                                                                @endphp
                                                                @for ($i = 0; $i <  $stars; $i++)
                                                                    <i class="fas fa-star"></i>
                                                                @endfor
                                                                @if ($main_stars>$stars)
                                                                    <i class="fas fa-star-half"></i>
                                                                @endif
                                                                @if($main_stars==0)
                                                                    @for ($i = 0; $i <  5; $i++)
                                                                        <i class="far fa-star"></i>
                                                                    @endfor
                                                                @endif
                                                            </div>
                                                            <p>
                                                        </div>
                                                    </div>
                                                    {{--                                                margin-left: calc(var(--width) * -1);--}}
                                                    @php

                                                        if ($percentage == 0){
                                                            $margin= 'margin-left: 0';
                                                        }elseif ($percentage == 100){
                                                          $margin= 'margin-left: calc(var(--width) * -1 - 20px)';
                                                        }else{
                                                            $margin= 'margin-left: calc(var(--width) * -1)';
                                                        }
                                                    @endphp
                                                    <a href="#" class="title">{{$course->title}}</a>
                                                    <div class="progress">
                                                        <div
                                                            class="progress-status"
                                                            style="--position:{{$percentage}}%;{{$margin}}"
                                                        >{{$percentage.'%'}}
                                                        </div>
                                                        <div class="progress-bar" role="progressbar"
                                                             aria-valuenow="{{$percentage}}"
                                                             aria-valuemin="0" aria-valuemax="100"
                                                             style="width: {{$percentage}}%"></div>
                                                    </div>
                                                    <a href="{{route('continueCourse',[$course->slug])}}"
                                                       class="theme_btn">{{__('frontend.Complete This Course')}}</a>
                                                </div>
                                            </div>

                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-12">
                    @if(isModuleActive('Noticeboard') && count($noticeboards)!=0)

                        <div class="dashboard_card">
                            <div class="head d-flex align-items-center justify-content-between mb-4">
                                <h4>{{__('frontend.Recent')}} {{__('noticeboard.Noticeboard')}}:</h4>
                                <a href="{{route('myNoticeboard')}}">{{__('frontend.See All')}}</a>
                            </div>
                            <div class="noticeboard-wrap">
                                @foreach($noticeboards as $noticeboard)
                                    <div class="noticeboard-card"
                                         style="--noticeboard_bg:{{$noticeboard->noticeType->color}}">
                                        <div class="noticeboard-card-left">
                                            <span
                                                class="d-block">{{showDate($noticeboard->created_at)}}</span>
                                            <a href="#">{{$noticeboard->title}}</a>
                                        </div>
                                        <div class="noticeboard-card-right">
                                            <a href="#" data-url="{{route('showNoticeboard',$noticeboard->id)}}"
                                               class="showNoticeboard theme-btn btn_sm">{{__('frontend.View Details')}}</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @endif
                    @if(Settings('gamification_status') && Settings('gamification_leaderboard_show_badges_status'))
                        <div class="dashboard_card dashboard_badge">
                            <div class="head mb-4">
                                <h4>{{__('frontend.Upcoming Badge')}}</h4>
                            </div>
                            <div class="dashboard_badge_carousel owl-carousel" id="badge_carousel">

                                @foreach($badges as $type)
                                    @foreach($type->take(1) as  $badge)
                                        <div class="dashboard_badge_item text-center">
                                            <p>{{$badge->title}} -
                                                <small>{{ucfirst($badge->type).' '.trans('setting.Badge')}}</small>
                                            </p>
                                            <div class="img"><img
                                                    src="{{asset($badge->image)}}"
                                                    alt=""></div>
                                            <span class="f_w_600">
                                        {{trans('common.Required')}}    {{$badge->point}}
                                                @if($badge->type=='activity')
                                                    {{__('setting.logins')}}
                                                @elseif($badge->type=='courses')
                                                    {{__('setting.completed courses')}}
                                                @elseif($badge->type=='registration')
                                                    {{__('setting.Days')}}
                                                @elseif($badge->type=='test')
                                                    {{__('setting.passed tests')}}
                                                @elseif($badge->type=='assignment')
                                                    {{__('setting.passed assignments')}}
                                                @elseif($badge->type=='survey')
                                                    {{__('setting.completed surveys')}}
                                                @elseif($badge->type=='communication')
                                                    {{__('setting.topics or comments')}}
                                                @elseif($badge->type=='certification')
                                                    {{__('setting.certificates')}}
                                                @elseif($badge->type=='perfectionism')
                                                    {{__('setting.tests or assignments with score 90%+')}}
                                                @endif
                                        </span>
                                        </div>
                                    @endforeach
                                @endforeach

                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
        @if(isModuleActive('CPD'))
            <div class="container-fluid g-0">
                <div class="dashboard_card ">
                    <x-cpd-graph/>
                </div>
            </div>
        @endif
    </div>
</div>
