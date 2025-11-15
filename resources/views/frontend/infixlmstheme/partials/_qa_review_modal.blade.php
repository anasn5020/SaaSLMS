<div class="modal cs_modal fade admin-query" id="viewAllReviewModal" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('frontend.View All Reviews')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                        class="ti-close "></i></button>
            </div>
            <div class="modal-body" id="allReviewList">
                <!-- <div class="customers_reviews" id="customers_reviews"></div>                  -->
            </div>
            <div class="modal-footer justify-content-end">
                <div class="mt-40">
                    <button type="button" class="theme_line_btn me-2 small_btn2"
                            data-bs-dismiss="modal">{{ __('common.Cancel') }}
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal cs_modal fade admin-query" id="viewAllQAModal" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('frontend.View All QA')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                        class="ti-close "></i></button>
            </div>
            <div class="modal-body" id="allCommentList">
             </div>
            <div class="modal-footer justify-content-end">
                <div class="mt-40">
                    <button type="button" class="theme_line_btn me-2 small_btn2"
                            data-bs-dismiss="modal">{{ __('common.Cancel') }}
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

@section('js')
<script>

    var SITEURL = "{{courseDetailsUrl($course->id,$course->type,$course->slug)}}";
    var page = 1;
    $(document).on('click', '.view_all_review_btn', function () {
        load_more_review(page);
    });
    $(document).on('click', '.view_all_qa_btn', function () {
        load_more(page);
    });


    function load_more(page) {
        $.ajax({
            url: SITEURL + "?page=" + page,
            type: "get",
            datatype: "html",
            data: {'type': 'comment'},
            beforeSend: function () {
                $('.ajax-loading').show();
            }
        })
            .done(function (data) {
                $('.ajax-loading').hide();
                $("#allCommentList").append(data);


            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('No response from server');
            });

    }


    function load_more_review(page) {
        $.ajax({
            url: SITEURL + "?page=" + page,
            type: "get",
            datatype: "html",
            data: {'type': 'review'},
            beforeSend: function () {
                $('.ajax-loading').show();
            }
        })
            .done(function (data) {
                $('.ajax-loading').hide();
                $("#allReviewList").append(data);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('No response from server');
            });

    }

</script>
@endsection
