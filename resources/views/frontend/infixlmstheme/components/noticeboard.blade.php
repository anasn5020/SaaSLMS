<div>
    <div class="main_content_iner main_content_padding">

        <div class="dashboard_lg_card">
            <div class="container-fluid g-0">
                <div class="row">
                    <div class="col-12">
                        <div class="section__title3">
                            <h3>{{__('noticeboard.Noticeboard')}}</h3>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="noticeboard-wrap">
                            @foreach($noticeboards as $noticeboard)
                                <div class="noticeboard-card"
                                     style="--noticeboard_bg:{{$noticeboard->noticeType->color}}">
                                    <div class="noticeboard-card-left">
                                            <span
                                                class="d-block">{{showDate($noticeboard->created_at)}} </span>
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
                    <div class="col-12">
                        <div class="mt-4 mt-lg-5">

                            {{$noticeboards->links(theme('partials._new_pagination'))}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
