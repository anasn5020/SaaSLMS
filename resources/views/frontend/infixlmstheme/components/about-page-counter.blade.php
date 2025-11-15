<div>
    <style>
        .counter_area::before {
            background-image: url('{{asset($about->image4)}}');
        }
        .counter_wrapper {
            position: relative;
            z-index: 1;
        }

    </style>
    <div class="counter_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="counter_wrapper">
                        <div class="single_counter">
                            <h3><span class="">{{$about->total_teacher}}</span></h3>
                            <div class="counter_content">
                                <h4>{{$about->teacher_title}}</h4>
                                <p>{{$about->teacher_details}}</p>
                            </div>
                        </div>
                        <div class="single_counter">
                            <h3><span class="">{{$about->total_student}}</span></h3>
                            <div class="counter_content">
                                <h4>{{$about->student_title}}</h4>
                                <p>{{$about->student_details}}</p>
                            </div>
                        </div>
                        <div class="single_counter">
                            <h3><span class="">{{$about->total_courses}}</span></h3>
                            <div class="counter_content">
                                <h4>{{$about->student_title}}</h4>
                                <p>{{$about->student_details}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
