    @php
    $week_number = isset($week_number) ? $week_number : $this_week;
    $start_date = date('Y-m-d', strtotime($weekDates[0]));
    $end_date = date('Y-m-d', strtotime($weekDates[6]));
    @endphp
    <input type="hidden" name="user_id" id="user_id" value="{{ $instructor->id }}">
    <input type="hidden" name="next_date" id="next_date" value="{{ $end_date }}">
    <input type="hidden" name="pre_date" id="pre_date" value="{{ $start_date }}">
    <input type="hidden" name="timezone" id="timezone" value="">
    <!-- tutor list details:start -->
    <main class="tutor_listing_details">
        <div class="container">
            <div class="row">
                <div class="col-xxl-9 col-xl-10 offset-xl-1 col-md-12">
                    <div class="row">
                        <div class="col-lg-8 col-md-7">
                            @includeIf('appointment::frontend.inc.instructor_details')
                        </div>
                        <div class="col-lg-4 col-md-5">
                            @includeIf('appointment::frontend.inc.instructor_preview')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- tutor list details:end -->

    <!-- bg-shade:start -->
    <div class="bg-shade"></div>
    <!-- bg-shade:end -->

    <!-- view full schedule modal:start -->
    @includeIf('appointment::frontend.inc.schedule_modal')
    <!-- view full schedule modal:end -->