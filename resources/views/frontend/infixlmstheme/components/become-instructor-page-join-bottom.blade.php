<div>
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
                                @if(!empty($joining_part->btn_name))
                                    {{$cta_part->btn_name}}
                                @else
                                    {{__('frontendmanage.Become Instructor')}}
                                @endif
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
