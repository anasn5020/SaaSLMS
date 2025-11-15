@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('forum.Forum')}}
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/css/forum.css')}}{{assetVersion()}}">
    <link href="{{asset('public/backend/css/summernote-bs5.min.css')}}{{assetVersion()}}" rel="stylesheet">

@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/forum.js')}}"></script>

    <script src="{{asset('public/backend/js/summernote-bs5.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.forum_create').summernote({
                placeholder: 'Write here',
                tabsize: 2,
                height: 188,
                tooltip: false
            });
        });
        $(document).ready(function () {
            $('.note-toolbar').find('[data-toggle]').each(function () {
                $(this).attr('data-bs-toggle', $(this).attr('data-toggle')).removeAttr('data-toggle');
            });
        });
        $(document).ready(function () {
            $('.note-modal').find('[data-dismiss]').each(function () {
                $(this).attr('data-bs-dismiss', $(this).attr('data-dismiss')).removeAttr('data-dismiss');
            });
        });
    </script>

    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#forum_submit").click(function (e) {

            e.preventDefault();

            var title = $("input[name=title]").val();
            var privacy = $("input[name=privacy]").val();
            var description = $('.forum_create').summernote('code');

            $.ajax({
                type: 'POST',
                url: "{{ route('forum.storeForum') }}",
                data: {title: title, description: description, privacy: privacy},
                success: function (data) {
                    console.log(data);
                    alert(data.success);
                }
            });

        });
    </script>

@endsection

@section('mainContent')
    <x-breadcrumb :banner="trans('common.N/A')"
                  :title="trans('frontend.Join the Discussion in Our Forum')"
                  :subTitle="trans('frontend.Forum')"/>
    <!-- fourm_area::start  -->
    <div class="fourm_area section_spacing4">
        <div class="container">
            <div class="row">
                <div class="col-xl-2">
                    <ul class="lession_lists mb_30 mt_114">
                        <li><a href="{{route('forum.index')}}">home</a></li>
                        <li><a class="{{!isset($lesson_info)? 'active':''}}"
                               href="{{route('forum.CourseForum',$course_info->id)}}">{{@$course_info->title}}</a></li>
                        {{-- <li><a href="#" class="active">Lesson 01</a></li> --}}
                        @foreach ($course_info->lessons as $lesson)
                            <li>
                                <a class="{{isset($lesson_info)?$lesson_info->id==$lesson->id ? 'active':'':''}}"
                                   href="{{route('forum.LessonForum',$lesson->id)}}">{{$lesson->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-xl-7">
                    <div class="fourm_header d-flex align-items-center justify-content-between">
                        <div class="fourm_header_left">
                            <select class="fourm_select">

                                <option data-display="Select Courses">Select Courses</option>
                                @foreach ($courses as $course)
                                    <option
                                        {{$course_info->id == $course->id? 'selected':''}} value="{{$course->id}}">{{$course->title}} </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="fourm_header_right">
                            <div class="nav fouram_tabs" id="nav-tab" role="tablist">
                                <a class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Latest</a>
                                <a class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Unread</a>
                                <a class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Rising</a>
                                <a class="nav-link" id="nav-contact-tab2" data-bs-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact2" aria-selected="false">Most Liked</a>
                            </div>
                        </div> --}}
                    </div>
                    <div class="fourm_body">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                 aria-labelledby="nav-home-tab">
                                <div class="new_post_box">
                                    <div class="new_post_title d-flex align-items-center mt_15">
                                        <h3 class="mb-0 text-uppercase font_14 f_w_600">Make post</h3>
                                        {{-- <span class="post_pin">New Post</span> --}}
                                    </div>
                                    <form class="new_post_form" method="post" action="{{ route('forum.storeForum') }}">
                                        @csrf
                                        <input type="text" hidden name="course" value="{{$course_info->id}}">
                                        <input type="text" hidden name="category" value="{{$course_info->category_id}}">
                                        @if (isset($lesson_info))
                                            <input type="text" hidden name="lesson" value="{{$lesson_info->id}}">
                                        @endif
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div
                                                    class="post_label d-flex align-items-center justify-content-between flex-wrap gap_15">
                                                    <label class="primary_label2 mb-0">Title <span class="text-danger"> <strong>*</strong> </span></label>
                                                    <label class="primary_checkbox d-flex">
                                                        <input name="privacy" type="checkbox">
                                                        <span class="checkmark mr_10"></span>
                                                        <span class="label_name font_14 f_w_400">Make it Private</span>
                                                    </label>
                                                </div>
                                                <input name="title" placeholder="{{ __('common.Title') }}"
                                                       onfocus="this.placeholder = ''"
                                                       onblur="this.placeholder = 'Title'" class="primary_input3 mb_20"
                                                       required="" type="text">
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="primary_label2">Description <span
                                                        class="text-danger"> <strong>*</strong> </span> </label>
                                                <textarea class="primary_textarea3 mb_20 style2 forum_create"
                                                          name="description" placeholder="Write Note here"
                                                          onfocus="this.placeholder = ''"
                                                          onblur="this.placeholder = 'Write Note here'"
                                                          spellcheck="false"></textarea>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="theme_btn small_btn2 mt-3">Create Post
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="fourm_cat_boxes mb_20 mt_114">
                        @php
                            $category_list= Modules\CourseSetting\Entities\Category::with('courses')->whereHas('courses.forums')->where('status',1)->get();
                        @endphp
                        <h3 class="cat_title f_s_20 f_w_700">Categories</h3>
                        <ul class="Check_sidebar" id="category_list">
                            @foreach ($category_list as $category)

                                <li>
                                    <label class="primary_checkbox d-flex">
                                        <input type="checkbox" name="category[]"
                                               {{isset($categories)? in_array($category->id,$categories)? 'checked':'':''}} class="category_select"
                                               value="{{$category->id}}">
                                        <span class="checkmark mr_10"></span>
                                        <span class="label_name font_16 f_w_400">{{$category->name}}</span>
                                    </label>
                                </li>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
