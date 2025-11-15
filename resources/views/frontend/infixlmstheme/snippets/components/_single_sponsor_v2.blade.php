<style>
    @media only screen and (max-width: 991px) {
        .sponsor {
            padding: 50px 0
        }
    }

    .sponsor-title {
        margin-bottom: 50px
    }

    .sponsor-title h4 {
        font-size: 48px;
        line-height: 1.25;
        margin-bottom: 0
    }

    @media only screen and (min-width: 1280px) and (max-width: 1439px) {
        .sponsor-title h4 {
            font-size: 42px
        }
    }

    @media only screen and (min-width: 992px) and (max-width: 1279px) {
        .sponsor-title h4 {
            font-size: 36px
        }
    }

    @media only screen and (min-width: 768px) and (max-width: 991px) {
        .sponsor-title h4 {
            font-size: 32px
        }
    }

    @media only screen and (max-width: 767px) {
        .sponsor-title h4 {
            font-size: 28px
        }
    }

    .sponsor-wrapper {
        padding: 0 80px;
        gap: 14px
    }

    @media (max-width: 1339px) {
        .sponsor-wrapper {
            padding: 0 15px
        }
    }

    .sponsor-single {
        width: calc(100% / 12 * 3 - 11px);
        flex: 0 0 auto;
        border-radius: 8px;
        overflow: hidden;
        padding: 10px;
        background-color: #fff
    }

    @media only screen and (min-width: 992px) and (max-width: 1279px) {
        .sponsor-single {
            width: calc(100% / 12 * 4 - 11px)
        }
    }

    @media only screen and (max-width: 767px) {
        .sponsor-single {
            width: calc(100% / 12 * 4 - 11px)
        }
    }

    .sponsor-single img {
        width: 100%;
        height: 60px;
        object-fit: contain;
        margin: auto
    }

    @media only screen and (min-width: 992px) and (max-width: 1279px) {
        .sponsor-single img {
            height: 50px
        }
    }

    @media only screen and (min-width: 768px) and (max-width: 991px) {
        .sponsor-single img {
            height: 80px
        }
    }

    @media only screen and (max-width: 767px) {
        .sponsor-single img {
            height: 60px
        }
    }

    @media only screen and (max-width: 479px) {
        .sponsor-single img {
            height: 80px
        }
    }

</style>

<div class="sponsor">
    <div class="sponsor-title text-center">
        <h4 class="fw-bold text-primary">{{__('frontend.Brand Who Trust Us')}}</h4>
    </div>
    <div class="sponsor-wrapper d-flex flex-wrap align-items-center justify-content-center">
        @foreach ($result as $sponsor)
            <div class="sponsor-single">
                <img src="{{asset($sponsor->image)}}" alt="{{$sponsor->title}}">
            </div>
        @endforeach
    </div>
</div>
