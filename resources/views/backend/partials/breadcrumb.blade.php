<section class="sms-breadcrumb mb-10 white-box">
    <div class="container-fluid p-0">
        <div class="d-flex flex-wrap justify-content-between row-gap-3 column-gap-5">
            <h1 class="text-uppercase">{{$menu->name}}</h1>
            <div class="bc-pages">
                @if(isset($links[0]) && $links[0]['route']!='dashboard')
                    <a href="{{validRouteUrl('dashboard')}}">{{__('dashboard.Dashboard')}}</a>
                @endif
                @foreach($links as $link)
                    <a href="{{routeIsExist($link['route'])?validRouteUrl($link['route']):''}}">{{$link['name']}}</a>
                @endforeach
            </div>
        </div>
    </div>
</section>
