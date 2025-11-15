<div>
   
    <div class="calender_section section_padding ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="system_url" value="{{url('/')}}">
 <input type="hidden" id="today_date" value="{{date('Y-m-d')}}">
       <div class="modal fade lms_view_modal" id="lms_view_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal_header d-flex align-items-center gap_15 ">
                    <div class="modal_header_left flex-fill ">
                        <h4 class="modal-title" id="calendar_title"></h4>
                        <span class="edit_pop_text" id="calendar_date_time"></span>
                    </div>
                    <a href="#" class="link_icon" id="calendar_link">
                        <img src="{{asset('Modules/Calendar/Resources/assets/img/link_icon.svg')}}" alt="">
                    </a>
                </div>

                <div class="modal-body">
                    <div class="modal_bg">
                        <img class="img-fluid" id="calendar_banner" src="img/modal_banner.jpg" alt="">
                    </div>
                    <p class="description_text"></p>
                    <div class="modal_author_info">
                        <div class="thumb">
                            <img id="host_image" src="img/modal_author.png" alt="">
                        </div>
                        <div class="modal_author_content">
                            <a href="#">
                                <h4 id="host_name">ROBERT DOWNEY</h4>
                            </a>
                            <p id="host_title">UI/UX Designer</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>