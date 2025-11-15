<style>
    .modal-dialog {
        max-width: 800px;
    }

    iframe {
        position: absolute !important;
        right: 0px;
        bottom: 0;
        top: 0;
        right: 0;
        left: 0;
    }
</style>
<script src="{{ asset('public') }}/js/jquery-3.5.1.min.js"></script>
<div class="modal cs_modal fade admin-query" id="playerModal" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$course->title}}</h5>
                <button id="playerModelCloseBtn" type="button" class="btn-close" data-bs-dismiss="modal"><i
                        class="ti-close "></i></button>
            </div>
            <div id="embedBox" class="video_iframe"></div>
            <script>
                (function (v, i, d, e, o) {
                    v[o] = v[o] || {};
                    v[o].add = v[o].add || function V(a) {
                        (v[o].d = v[o].d || []).push(a);
                    };
                    if (!v[o].l) {
                        v[o].l = 1 * new Date();
                        a = i.createElement(d), m = i.getElementsByTagName(d)[0];
                        a.async = 1;
                        a.src = e;
                        m.parentNode.insertBefore(a, m);
                    }
                })(window, document, "script", "https://player.vdocipher.com/playerAssets/1.6.10/vdo.js", "vdo");
                var video = vdo.add({
                    otp: "{{$course->otp}}",
                    playbackInfo: "{{$course->playbackInfo}}",
                    theme: "9ae8bbe8dd964ddc9bdb932cca1cb59a",
                    container: document.querySelector("#embedBox"),
                    plugins: [{
                        name: 'keyboard',
                        options: {
                            bindings: {
                                'Space': (player) => (player.status === 1) ? player.pause() : player.play(),
                                'Up': (player) => player.setVolume(player.volume + 0.2),
                                'Down': (player) => player.setVolume(player.volume - 0.2),
                                'Left': (player) => player.seek(player.currentTime - 20),
                                'Right': (player) => player.seek(player.currentTime + 20),
                            },
                        }
                    }]
                });

                $(document).ready(function () {
                    console.log(video);
                });

                $('#playerModelCloseBtn').click(function (e) {
                    player.pause()
                });
            </script>

        </div>
    </div>
</div>
