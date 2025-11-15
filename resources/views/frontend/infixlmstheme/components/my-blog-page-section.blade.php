<div>
    <div class="main_content_iner main_content_padding">
        <div class="dashboard_lg_card">
            <div class="container-fluid g-0">
                <div class="my_courses_wrapper">
                    <div class="row">
                        <div class="col-12">
                            <div class="section__title3">
                                <h3>
                                    {{ __("blog.My Blogs") }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3 mb-4">
                        <div class="col d-flex justify-content-end">
                            <a class="link_value theme_btn small_btn4" href="{{ route('users.blog.create') }}">
                                {{ __('blog.Add Post') }}
                            </a>
                        </div>
                    </div>

                    <div class="row d-flex align-items-center mb-4 mb-lg-5">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table custom_table3">
                                    <thead>
                                    <tr>
                                        <th>{{__('common.SL')}}</th>
                                        <th>{{__('common.Title')}}</th>
                                        <th>{{__('common.Image')}}</th>
                                        <th>{{__('blog.Published Date')}}</th>
                                        <th>{{__('common.Status')}}</th>
                                        <th>{{__('common.Action')}}</th>

                                    </tr>
                                    </thead>

                                    <tbody>
                                    @if(count($blogs) > 0)
                                        @foreach($blogs as $key => $blog)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>{{ Str::limit($blog->title,50) }}</td>
                                                <td>
                                                    <img class="img-fluid blog-img"
                                                         src="{{ getBlogImage($blog->image) }}">
                                                </td>
                                                <td>
                                                    {{ $blog->authored_date }}
                                                </td>
                                                <td>
                                                    @if($blog->status == '1')
                                                        {{ __("blog.Published") }}
                                                    @else
                                                        {{ __("blog.Pending") }}
                                                    @endif

                                                </td>
                                                <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle"
                                                                    type="button"
                                                                    id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                {{ __("blog.Action") }}
                                                            </button>
                                                            <div class="dropdown-menu"
                                                                 aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item"
                                                                   href="{{ route('blogDetails',[$blog->slug]) }}?preview=1">{{__("common.View")}}</a>

                                                                @if($blog->user_id == auth()->id())

                                                                <a class="dropdown-item"
                                                                   href="{{ route('users.blogs.edit',$blog->id) }}">{{__("common.Edit")}}</a>
                                                                <a class="dropdown-item"
                                                                   href="{{ route('users.blogs.delete',$blog->id) }}">{{__("common.Delete")}}</a>
                                                                @endif

                                                            </div>
                                                        </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan='6' class='text-center'>
                                                {{__('common.No data available in the table')}}
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <div>{{$blogs->links()}}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
