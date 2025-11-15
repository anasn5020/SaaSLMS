<div>
    <div class="brand_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="barnd_wrapper brand_active owl-carousel">
                        @foreach($sponsors as $sponsor)
                            <div class="single_brand">
                                <img src="{{asset($sponsor->image)}}" alt="{{$sponsor->title}}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
