<div data-type="component-text"
     data-preview="{{asset('')}}Modules/Appointment/Resources/assets/keditor/snippets/preview/affiliate/hero_area.png"
     data-keditor-title="Hero Section" data-keditor-categories="Hero Section">
    <section class="tutor hero_area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 offset-lg-1 col-md-7">
                    <div class="hero_area_inner">
                        <h1>More Than <span>25000+</span> Verified Online Tutors Join Us <span>Today</span></h1>
                        <p>Choose from over 100,000 online video courses with new additions published every month.</p>
                        <form action="{{ validRouteUrl('appointment.instructors') }}" method="GET">
                            <div class="input-control d-flex align-items-center">
                                <input type="search" name='search' class="input-control-input"
                                       placeholder='Search by language & speciality' required>
                                <input type="submit" value="Explore Tutors" class="input-control-input appointment_submit">
                            </div>
                            {{-- <p><b>Popular keywords:</b><a href='#'>Design</a><a href='#'>Creative</a><a href='#'>Marketing</a></p> --}}
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 col-md-5 text-center">
                    <div class="hero_area_img">
                        <img
                            src="{{ asset('Modules/Appointment/Resources/assets/frontend/') }}/img/tutor/instructor-img.png"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
