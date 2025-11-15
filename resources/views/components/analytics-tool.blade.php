<div>
    @if(Settings('google_analytics_status') == 1)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{saasEnv('MEASUREMENT_ID')}}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());
            gtag('config', '{{saasEnv('MEASUREMENT_ID')}}');
        </script>

        <script>
            function collectClientId() {
                if (typeof ga !== 'undefined') {
                    ga(function (tracker) {
                        var clientId = tracker.get('clientId');
                        postClientId(clientId);
                    });
                } else {
                    gtag('get', "{{ saasEnv('MEASUREMENT_ID', null) }}", 'client_id', function (clientId) {
                        postClientId(clientId);
                    });
                }
            }

            function postClientId(clientId) {
                var data = new FormData();
                data.append('client_id', clientId);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'store-google-analytics-client-id', true);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.send(data);
            }

            @if (!session('google-analytics-4-measurement-protocol.client_id', false))
            collectClientId();
            @endif
        </script>
    @endif

    @if(Settings('facebook_pixel_status') == 1)
        <script>
            !function (f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function () {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', {{Settings('facebook_pixel')}});
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                 src="https://www.facebook.com/tr?id={{Settings('facebook_pixel')}}/&ev=PageView&noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->
    @endif

    @if(Settings('gtm_status') == 1)
             <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','{{Settings('gtm_id')}}');</script>




         <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id={{Settings('gtm_id')}}"
                    height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif
</div>
