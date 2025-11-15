<div class="barnd_wrapper brand_active owl-carousel">
    @foreach ($result as $sponsor)
        <div class="single_brand">
            <img src="{{asset($sponsor->image)}}" alt="{{$sponsor->title}}">
        </div>
    @endforeach
</div>
