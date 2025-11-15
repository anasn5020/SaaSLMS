<div class="row reward-paginations align-items-center">
    <div class="col-lg-4 col-xl-5 col-xxl-3 d-none d-lg-block">

        <p>{{__('frontend.Showing')}}
            <strong>{{$paginator->firstItem()}} - {{$paginator->lastItem()}}</strong>
            {{__('frontend.from')}}
            <strong>{{$paginator->total()}}</strong> {{__('frontend.data')}}</p>
    </div>
    <div class="col-lg-8 col-xl-7 col-xxl-9">
        @if ($paginator->hasPages())
            <ul class="paginations justify-content-center justify-content-lg-end">

                @if ($paginator->onFirstPage())
                    <li class="paginations-list disabled"><a href="#" class="paginations-links prev">
                            <img src="{{asset('public/frontend/infixlmstheme/svg/pagination_arrow.svg')}}" alt="">
                        </a></li>
                @else
                    <li class="paginations-list"><a href="{{ $paginator->previousPageUrl() }}" class="prev paginations-links">
                            <img src="{{asset('public/frontend/infixlmstheme/svg/pagination_arrow.svg')}}" alt="">
                        </a></li>
                @endif


                @foreach ($elements as $element)

                    @if (is_string($element))
                        <li class="paginations-list"><a href="#" class="paginations-links "
                                                        aria-current="page">{{ $element }}</a>
                        </li>
                    @endif



                    @if (is_array($element))
                        @foreach ($element as $page => $url)

                            @if ($page == $paginator->currentPage())
                                <li class="paginations-list"><a href="#" class="paginations-links active"
                                                                aria-current="page">{{ $page }}</a>
                                </li>
                            @else
                                <li class="paginations-list"><a href="{{ $url }}" class="paginations-links "
                                                                aria-current="page">{{ $page }}</a>
                                </li>
                            @endif

                        @endforeach
                    @endif
                @endforeach


                @if ($paginator->hasMorePages())
                    <li class="paginations-list"><a href="{{ $paginator->nextPageUrl() }}" class="paginations-links next">
                            <img src="{{asset('public/frontend/infixlmstheme/svg/pagination_arrow.svg')}}" alt="">
                        </a></li>
                @else
                    <li class="paginations-list disabled"><a href="#" class="paginations-links">
                            <img src="{{asset('public/frontend/infixlmstheme/svg/pagination_arrow.svg')}}" alt="">
                        </a>
                    </li>
                @endif

            </ul>
        @endif
    </div>
</div>
