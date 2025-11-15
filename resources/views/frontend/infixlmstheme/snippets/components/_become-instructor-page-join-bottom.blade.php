<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/become_instructor_page/join_bottom_section.jpg')}}"
     data-aoraeditor-title="Join Bottom section"
     data-aoraeditor-categories="Become Instructor Page"
>
    @php
        $cta_part=  $become_instructor->where('id',5)->first();
    @endphp
    <section class="cta_part section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="cta_part_iner">
                        <h2>{{$cta_part->title}}</h2>
                        <p>{{$cta_part->description}}</p>
                        @if(Settings('instructor_reg') ==1)
                            <a href="#" class="theme_btn" data-bs-toggle="modal"
                               data-bs-target="#Instructor">
                                {{__('frontendmanage.Become Instructor')}}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
