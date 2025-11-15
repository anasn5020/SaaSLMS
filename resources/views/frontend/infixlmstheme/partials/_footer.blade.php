@php use Illuminate\Support\Facades\Auth; @endphp
<div class="aoraeditor-skip aoraeditor-footer">


    <x-popup-content/>


    @include(theme('partials.footer.'.$footer_style))


    <div class="shoping_wrapper">
        <div class="dark_overlay"></div>
        <div class="shoping_cart">
            <div class="shoping_cart_inner">
                <div class="cart_header d-flex justify-content-between">
                    <h4>{{__('frontend.Shopping Cart')}}</h4>
                    <div class="chart_close">
                        <i class="ti-close"></i>
                    </div>
                </div>
                <div id="cartView">
                    <div class="single_cart">
                        Loading...
                    </div>
                </div>


            </div>

        </div>
    </div>
    <!-- shoping_cart::end  -->

    <!-- UP_ICON  -->
    <div id="back-top" style="display: none;">
        <a title="Go to Top" href="#">
            <i class="fa fa-angle-up"></i>
        </a>
    </div>

    <input type="hidden" name="item_list" class="item_list" value="{{url('getItemList')}}">
    <input type="hidden" name="enroll_cart" class="enroll_cart" value="{{url('enrollOrCart')}}">
    <input type="hidden" name="csrf_token" class="csrf_token" value="{{csrf_token()}}">
    <!--/ UP_ICON -->

    <x-footer-cookie/>

    <div class="modal fade leaderboard-boarder" id="myLeaderBoard" tabindex="-1" role="dialog"
         aria-labelledby="myLeaderBoard"
         aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="">{{__('common.Leaderboard')}}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="reward-leader">
                        <ul class="nav nav-tabs border-bottom-0 m-0" id="myTab" role="tablist">
                            @if(Settings('gamification_leaderboard_show_point_status'))
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link  nav-point type-point" id="point-tab" data-bs-toggle="tab"
                                            data-bs-target="#point"
                                            data-type="point"
                                            type="button" role="tab" aria-controls="point"
                                            aria-selected="true">{{__('setting.Points')}}
                                    </button>
                                </li>
                            @endif
                            @if(Settings('gamification_leaderboard_show_level_status'))

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link nav-point type-level" id="level-tab" data-bs-toggle="tab"
                                            data-bs-target="#level"
                                            data-type="level"
                                            type="button" role="tab" aria-controls="level"
                                            aria-selected="true">{{__('setting.Levels')}}
                                    </button>
                                </li>
                            @endif
                            @if(Settings('gamification_leaderboard_show_badges_status'))

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link nav-point type-badge" id="badge-tab" data-bs-toggle="tab"
                                            data-bs-target="#badge"
                                            data-type="badge"
                                            type="button" role="tab" aria-controls="badge"
                                            aria-selected="true">{{__('setting.Badges')}}
                                    </button>
                                </li>
                            @endif
                            @if(Settings('gamification_leaderboard_show_courses_status'))

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link nav-point type-courses" id="courses-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#courses"
                                            data-type="courses"
                                            type="button" role="tab" aria-controls="courses"
                                            aria-selected="true">{{__('courses.Courses')}}
                                    </button>
                                </li>
                            @endif
                            @if(Settings('gamification_leaderboard_show_certificate_status'))

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link nav-point type-certificate" id="certificate-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#certificate"
                                            data-type="certificate"
                                            type="button" role="tab" aria-controls="certificate"
                                            aria-selected="true">{{__('setting.certificates')}}
                                    </button>
                                </li>
                            @endif
                        </ul>
                        <div id="leaderboardBody" class="leaderboardBody"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade noticeboard-modal" id="myNoticeboard" tabindex="-1" role="dialog"
         aria-labelledby="myNoticeboard"
         aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" id="myNoticeboardBody">

        </div>
    </div>

    <script src="{{asset('public/frontend/infixlmstheme/js/app.js'.assetVersion())}}"></script>

    <script src="{{asset('public/backend/js/summernote-bs5.min.js')}}{{assetVersion()}}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{Settings('gmap_key') }}"></script>
    <script src="{{ asset('public/frontend/infixlmstheme/js/map.js') }}"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/contact.js')}}{{assetVersion()}}"></script>

    {!! Toastr::message() !!}

    @if($errors->any())
        <script>
            @foreach($errors->all() as $error)
            toastr.error('{{ $error }}', 'Error', {
                closeButton: true,
                progressBar: true,
            });
            @endforeach
        </script>
    @endif


    @if (isModuleActive("Store"))
        <script src="{{asset('public/frontend/infixlmstheme/js/store_script.js')}}{{assetVersion()}}"></script>
        <script src="{{asset('public/frontend/infixlmstheme/js/select2.min.js')}}{{assetVersion()}}"></script>
    @endif

    @yield('js')
    @stack('js')
    <script>
        setTimeout(function () {
            $('.preloader').fadeOut('hide', function () {
                // $(this).remove();

            });
        }, 0);


        $('#cartView').on('click', '.remove_cart', function () {
            let id = $(this).data('id');
            let total = $('.notify_count').html();

            $(this).closest(".single_cart").hide();
            let url = "{{url(('/home/removeItemAjax'))}}" + '/' + id;

            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    let finalTotal = total - 1;
                    if (finalTotal < 0) {
                        finalTotal = 0
                    }
                    $('.notify_count').html(finalTotal);
                }
            });
        });

        $(function () {
            $('.lazy').Lazy();
        });


    </script>
    @auth
        @if(Auth::user()->role_id==3 && ((int)Settings('device_limit_time')) > 0)
            <script>
                let start = false;

                function update() {
                    if (!start) {
                        $.ajax({
                            type: 'GET',
                            url: "{{url('/')}}" + "/update-activity",
                            success: function (data) {
                                start = false;

                            }
                        });
                    }

                }

                let time = parseInt("{{((int) Settings('device_limit_time')*60)-30}}");

                setInterval(function () {
                    start = true;
                    update();
                }, time * 1000);

            </script>
        @endif
    @endauth
    <script>
        $(document).on('click', '.show_notify', function (e) {
            e.preventDefault();

            console.log('notify');
        });
        if ($('#main-nav-for-chat').length) {
        } else {
            $('#main-content').append('<div id="main-nav-for-chat" style="visibility: hidden;"></div>');
        }

        if ($('#admin-visitor-area').length) {
        } else {
            $('#main-content').append('<div id="admin-visitor-area" style="visibility: hidden;"></div>');
        }
    </script>


    @if(str_contains(request()->url(), 'chat'))
        <script src="{{asset('public/backend/js/jquery-ui.js')}}{{assetVersion()}}"></script>
        <script src="{{asset('public/frontend/infixlmstheme/js/select2.min.js')}}{{assetVersion()}}"></script>
        <script src="{{ asset('public/js/app.js') }}{{assetVersion()}}"></script>
        <script src="{{ asset('public/chat/js/custom.js') }}{{assetVersion()}}"></script>
    @endif

    @if(auth()->check() && auth()->user()->role_id == 3 && !str_contains(request()->url(), 'chat'))
        <script src="{{ asset('public/js/app.js') }}{{assetVersion()}}"></script>
    @endif


    @if(isModuleActive("WhatsappSupport"))
        <script src="{{ asset('public/whatsapp-support/scripts.js') }}{{assetVersion()}}"></script>

        @include('whatsappsupport::partials._popup')

    @endif

    <script src="{{ asset('public/frontend/infixlmstheme/js/custom.js') }}{{assetVersion()}}"></script>
    @if(Settings('gamification_status') && Settings('gamification_leaderboard_status'))
        <script>
            $(document).on("change", ".leaderboard_filter", function () {
                 let type = $('#myLeaderBoard').find('.nav-link.active').data('type');
                if (type == undefined) {
                    type = 'point';
                }
                loadData(type);
            });
            $(document).on("click", ".point_btn", function () {
                let modal = $('#myLeaderBoard')
                modal.modal('show');
                let type = modal.find('.nav-link.active').data('type');
                if (type == undefined) {
                    let link = modal.find('.nav-link:first');
                    link.addClass('active')
                    type = link.data('type');

                }
                loadData(type);
            });
            $(document).on("click", ".how_to_point", function () {
                let modal = $('#myLeaderBoard')
                modal.modal('show');
                let link = modal.find('.nav-link:first');
                link.addClass('active')
                loadData('how_to_point')
            });

            $(document).on("click", ".nav-point", function () {
                let type = $(this).data('type');
                loadData(type);
            });

            function loadData(type, id = 0) {
                let body = $('#leaderboardBody');

                let level = '';
                let course = '';
                let institute = '';
                 if (body.find('.leaderboardFilter').length > 0) {
                     level = body.find('[name="leaderboard_filter_course_level"]').val();
                     course = body.find('[name="leaderboard_filter_class"]').val();
                     institute = body.find('[name="leaderboard_filter_institute"]').val();
                }

                let url = '{{url('/')}}';
                let formData = {
                    type: type,
                    id: id,
                    'level': level,
                    'course': course,
                    'institute': institute
                };
                body.html('<div class="d-flex align-items-center justify-content-center py-3"><i class="fas fa-spinner  fa-spin"></i></div>')


                $.ajax({
                    type: "get",
                    data: formData,
                    dataType: "html",
                    url: url + '/my-leaderboard',
                    success: function (data) {
                        body.html(data);
                    },
                    error: function (data) {
                        body.html("");
                    }

                });
            }
        </script>
    @endif


    @if (Settings('real_time_qa_update') == 1)

        <script src="{{asset('public/js/pusher.min.js')}}"></script>

        <script>

            let pusher = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {
                cluster: '{{config('broadcasting.connections.pusher.options.cluster')}}'
            });


            let channel2 = pusher.subscribe('new-notification-channel');

            channel2.bind('new-notification', function (data) {
                $.ajax({
                    url: '{{route('getNotificationUpdate')}}',
                    method: 'GET',
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                        toastr.success("{{__('frontend.New notification')}}");
                        $('.notify_count').removeClass('d-none')
                        $('.notification_body').html(response.notification_body);
                    },
                    error: function (response) {
                    }
                });
            });
        </script>
    @endif

    <script>

        function getList() {
            $('.shoping_cart ,.dark_overlay').toggleClass('active');

            let url = $('.item_list').val();
            $.ajax({
                type: 'GET',
                dataType: 'html',
                url: url,
                data: {
                    "responseType": "view"
                },

                success: function (data) {
                    $('#cartView').empty().html(data);
                    $('.notify_count').html(data.total);
                    $('.preloader').fadeOut('slow');
                }
            });
        }

        $(document).on('click', '.cart_store', function (e) {
            e.preventDefault();
            let btn = $(this);
            let id = $(this).data('id');
            let url = $('.enroll_cart').val();
            let csrf_token = $('.csrf_token').val();
            if ($.isNumeric(id)) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: url + '/' + id,
                    data: {
                        _token: csrf_token
                    },
                    success: function (data) {
                        $('.preloader').fadeOut('slow');
                        $('.notify_count').html(data.total);

                        if (data['result'] === "failed") {
                            toastr.error(data['message']);
                            // btn.show();
                        } else {
                            toastr.success(data['message']);
                            // btn.hide();
                        }
                        if (data.type === 'addToCart') {
                            getList();
                        } else {

                        }

                    }
                });

            } else {
                getList();
            }


        });
        $(".stripe-button-el").remove();
        $(".razorpay-payment-button").hide();


    </script>
</div>
</body>

</html>
