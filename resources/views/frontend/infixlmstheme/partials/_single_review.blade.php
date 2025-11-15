<div class="course_review_wrapper">
    <div class="course_cutomer_reviews">
        <div class="customers_reviews">
            <div class="single_reviews" id="{{$review->id}}_single_reviews">
                <div class="thumb link">
                    {{substr($review->userName, 0, 1)}}

                    @if(reviewCanDelete($review->userId,$review->instructor_id))
                        <a class="deleteBtn pe-0" href="#"
                           data-bs-toggle="modal"
                           onclick="deleteCommnet('{{route('deleteReview',$review->id)}}','{{$review->id}}_single_reviews')"
                           data-bs-target="#deleteComment">
                            <svg  class="delete_svg_icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 5.98047C17.67 5.65047 14.32 5.48047 10.98 5.48047C9 5.48047 7.02 5.58047 5.04 5.78047L3 5.98047" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8.5 4.97L8.72 3.66C8.88 2.71 9 2 10.69 2H13.31C15 2 15.13 2.75 15.28 3.67L15.5 4.97" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M18.8484 9.13965L18.1984 19.2096C18.0884 20.7796 17.9984 21.9996 15.2084 21.9996H8.78844C5.99844 21.9996 5.90844 20.7796 5.79844 19.2096L5.14844 9.13965" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M10.3281 16.5H13.6581" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9.5 12.5H14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    @endif
                </div>
                <div class="review_content">
                    <div class="d-flex gap-4">
                        <h4 class="f_w_500">{{$review->userName}}</h4>
                        <span class="time">{{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</span>
                    </div>
                    <div class="rated_customer d-flex align-items-center">
                        <div class="feedmak_stars">
                            @php
                                $main_stars=$review->star;
                                $stars=intval($review->star);
                            @endphp
                            @for ($i = 0; $i <  $stars; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                            @if ($main_stars>$stars)
                                <i class="fas fa-star-half"></i>
                            @endif

                        </div>
                    </div>
                    <p class="text-start">
                        {!! $review->comment !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
