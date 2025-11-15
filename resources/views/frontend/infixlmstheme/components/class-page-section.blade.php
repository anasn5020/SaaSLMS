<div>
    <input type="hidden" class="class_route" name="class_route" value="{{route('classes')}}">

    <div class="courses_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-xl-3">

                    <x-class-page-section-sidebar :level="$level" :type="$type" :categories="$categories"
                                                  :category="$category" :languages="$languages" :language="$language" :mode="$mode"/>
                </div>
                <div class="col-lg-8 col-xl-9">
                    <x-class-page-section-details :total="$total" :order="$order" :courses="$courses"/>
                </div>
            </div>
        </div>
    </div>
</div>
