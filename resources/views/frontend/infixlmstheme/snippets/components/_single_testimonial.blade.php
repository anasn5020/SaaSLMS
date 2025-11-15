<div class="testmonail_active owl-carousel">
    @foreach ($result as $testimonial)
        <div class="single_testmonial">
            <div class="testmonial_header d-flex align-items-center">
                <div class="thumb profile_info ">
                    <div class="profile_img">
                        <div class="testimonialImage"
                             style="background-image: url('{{getProfileImage($testimonial->image,$testimonial->author)}}')"></div>
                    </div>

                </div>
                <div class="reviewer_name">
                    <h4>{{@$testimonial->author}}</h4>
                    <div class="rate d-flex align-items-center">

                        @for($i=1;$i<=$testimonial->star;$i++)
                            <i class="fas fa-star"></i>
                        @endfor

                    </div>
                </div>
            </div>
            <p> “{{@$testimonial->body}}”</p>
        </div>
    @endforeach

</div>
<script>

</script>
