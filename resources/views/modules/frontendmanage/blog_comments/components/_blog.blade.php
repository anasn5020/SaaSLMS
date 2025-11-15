@if($row->blog->slug)
    <a target="_blank"
       href="{{route('blogDetails',[$row->blog->slug])}}?preview=1">{{\Illuminate\Support\Str::limit($row->blog->title,35,'...')}}</a>

@else
    {{__('common.N/A')}}
@endif
