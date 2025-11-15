var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    // '/offline',
    //
    // '/public/images/icons/icon-72x72.png',
    // '/public/images/icons/icon-96x96.png',
    // '/public/images/icons/icon-128x128.png',
    // '/public/images/icons/icon-144x144.png',
    // '/public/images/icons/icon-152x152.png',
    // '/public/images/icons/icon-192x192.png',
    // '/public/images/icons/icon-384x384.png',
    // '/public/images/icons/icon-512x512.png',
    //
    // '/public/css/bootstrap.min.css',
    // '/public/frontend/infixlmstheme/css/owl.carousel.min.css',
    // '/public/frontend/infixlmstheme/css/magnific-popup.css',
    // '/public/frontend/infixlmstheme/css/fontawesome.css',
    // '/public/frontend/infixlmstheme/css/themify-icons.css',
    // '/public/frontend/infixlmstheme/css/flaticon.css',
    // '/public/frontend/infixlmstheme/css/nice-select.css',
    // '/public/frontend/infixlmstheme/css/animate.min.css',
    // '/public/css/toastr.css',
    // '/public/frontend/infixlmstheme/css/style.css',
    //
    // '/public/js/jquery-3.5.1.min.js',
    // '/public/js/bootstrap.bundle.min.js',
    // '/public/frontend/infixlmstheme/js/owl.carousel.min.js',
    // '/public/frontend/infixlmstheme/js/waypoints.min.js',
    // '/public/frontend/infixlmstheme/js/jquery.counterup.min.js',
    // '/public/frontend/infixlmstheme/js/imagesloaded.pkgd.min.js',
    // '/public/frontend/infixlmstheme/js/wow.min.js',
    // '/public/frontend/infixlmstheme/js/barfiller.js',
    // '/public/frontend/infixlmstheme/js/jquery.slicknav.js',
    // '/public/frontend/infixlmstheme/js/jquery.magnific-popup.min.js',
    // '/public/frontend/infixlmstheme/js/jquery.ajaxchimp.min.js',
    // '/public/frontend/infixlmstheme/js/parallax.js',
    // '/public/frontend/infixlmstheme/js/mail-script.js',
    // '/public/frontend/infixlmstheme/js/main.js',
    // '/public/frontend/infixlmstheme/js/footer.js',
    // '/public/js/toastr.js',

];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('offline');
            })
    )
});
