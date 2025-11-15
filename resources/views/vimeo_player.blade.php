
<iframe style="width: 100vw;height: 100vh" class="video_iframe" id="video-id"
        src="https://player.vimeo.com/video/{{$video_id}}?autoplay=1&"
        frameborder="0" controls=0></iframe>
<script src="https://f.vimeocdn.com/js/froogaloop2.min.js"></script>

    <script src="{{asset('public/js/jquery-3.5.1.min.js')}}"></script>
    <script src='https://player.vimeo.com/api/player.js'></script>
    <script>
        $(function () {
            var iframe = $('#video-id')[0];
            var player = new Vimeo.Player(iframe);

            player.on('pause', function () {
                console.log('paused');
            });
            player.on('ended', function () {
                console.log('ended');
            });
        });
    </script>
