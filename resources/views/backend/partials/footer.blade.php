<footer class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mt-5 footer-copyright">
                <p class="p-3 mb-0">{!! Settings('copyright_text') !!}</p>
            </div>
        </div>
    </div>
</footer>
</div>
</div>

<div class="modal fade admin-query" id="commonModal">

</div>

<div id="mediaManagerDiv">
</div>
@if(isModuleActive("AIContent"))
    @include('aicontent::content_generator_modal')
@endif

@if(isModuleActive("WhatsappSupport"))
    @include('whatsappsupport::partials._popup')
@endif

@include('backend.partials.script')
{!! Toastr::message() !!}

@if($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{ $error }}', '{{trans('common.Error')}}', {
            closeButton: true,
            progressBar: true,
        });
        @endforeach
    </script>
@endif

@if(env('APP_SYNC') || config('app.demo_mode'))
    <a target="_blank" href="https://aorasoft.com/" class="float_button"> <i class="ti-shopping-cart-full"></i>
        <h3>Purchase InfixLMS</h3>
    </a>
@endif
@livewireScripts
<script src="{{ asset('public/js/alpine.min.js') }}{{assetVersion()}}"></script>

<script>
    window.jsLang = function (key, replace) {
        let translation = true

        let json_file = window._translations;
        translation = json_file[key]
            ? json_file[key]
            : key


        $.each(replace, (value, key) => {
            translation = translation.replace(':' + key, value)
        })

        return translation
    }

</script>
@if (Settings('real_time_qa_update') == 1)

    <script src="{{asset('public/js/pusher.min.js')}}"></script>

    <script>
        let footerPusher = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {
            cluster: '{{config('broadcasting.connections.pusher.options.cluster')}}'
        });

        let channel2 = footerPusher.subscribe('new-notification-channel');

        channel2.bind('new-notification', function (data) {
            if (data.login_user_id != '{{auth()->id()}}' && data.type != 'Reply') {
                $.ajax({
                    url: '{{route('getNotificationUpdate')}}',
                    method: 'GET',
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                        $('.Notification_body').html(response.notification_body);
                        $('.notification_count').html(response.total);
                        toastr.success("{{__('frontend.New notification')}}");
                    },
                    error: function (response) {
                    }
                });
            }
        });

    </script>
    @endif
    @include('backend.partials.media_script')

    @stack('js')

    </body>
    </html>
