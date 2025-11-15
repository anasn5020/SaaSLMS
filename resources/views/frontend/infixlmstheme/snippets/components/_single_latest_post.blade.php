@foreach($result as $post)
    <div class="single_newslist">
        <a href="{{route('blogDetails',[$post->slug])}}">
            <h4>{{$post->title}}</h4>
        </a>
        <p>{{ showDate(@$post->authored_date ) }} / {{$post->category->title}}</p>
    </div>
@endforeach
