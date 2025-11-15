@php
    $last_time =null;
    $next_time =null;
    if (Illuminate\Support\Facades\Storage::has('.reset_log')){
        $last_time =Illuminate\Support\Facades\Storage::get('.reset_log');
        $last_time =\Illuminate\Support\Carbon::parse($last_time);
        $next_time =$last_time->addMinutes((int)env('DEMO_RESET_TIME'));
        $next_time =$next_time->format('Y-m-d H:i:s');
    }
@endphp
@if(config('app.demo_mode') && env('DEMO_RESET_TIME') && \Illuminate\Support\Facades\Storage::has('.reset_log') && !empty($next_time))
    <link rel="stylesheet" href="{{asset('public/vendor/flipdown/flipdown.css')}}"/>
    <script src="{{asset('public/vendor/flipdown/flipdown.js')}}"></script>
    <style>
        .flipdown .rotor {
        }
    </style>
    <div id="flipdown" class="flipdown"></div>
    <script>
        $(document).ready(function () {
            var datetime = (new Date("{{$next_time}}").getTime() / 1000);
            let flipdown = new FlipDown(datetime, {
                theme: "light",
            });
            flipdown.start();
            flipdown.ifEnded(() => {
                toastr.warning('Demo will be reset soon', 'Warning');
            });
        });


    </script>
@endif
