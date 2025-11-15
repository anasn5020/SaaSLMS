<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/become_instructor_page/join_section.jpg')}}"
     data-aoraeditor-title="Join section"
     data-aoraeditor-categories="Become Instructor Page"
>
    <section class="instructor_process section_padding bg-white">
        <div class="container">
            <div class="row justify-content-center">
                @foreach($become_instructor->whereIn('id',[1,2,3]) as $item)
                    <div class="col-lg-4 col-sm-6">
                        <div class="single_instructor_part">
                            <i class="{{$item->icon}} fa-5x"></i>
                            <h4>{{$item->title}}</h4>
                            <p>{{$item->description}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
