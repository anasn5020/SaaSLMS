<footer class="{{Settings('footer_show')==0?'d-none d-sm-none d-md-block d-lg-block d-xl-block':''}}">
    @if(@$homeContent->show_subscribe_section==1)
        <x-footer-news-letter/>
    @endif
    <div class="copyright_area">
        <div class="container">
            <div class="row">
                {{--                @if(!isset($sectionWidgets) || (count($sectionWidgets['one'])==0 && count($sectionWidgets['two'])==0 && count($sectionWidgets['three'])==0 ) )--}}

                <div class="col-xl-4 col-lg-4 col-md-12">
                    <div class="footer_widget">
                        <div class="footer_logo">
                            <a href="#">
                                <img src="{{getCourseImage(Settings('logo2'))}}" alt=""
                                     style="width: 108px">
                            </a>
                        </div>
                        <p>{{ function_exists('footerSettings')?footerSettings('footer_about_description'):''  }}</p>
                        <div class="copyright_text">
                            <p>{!! function_exists('footerSettings')?footerSettings('footer_copy_right'):''  !!}</p>
                        </div>

                        <style>


                        </style>
                        <div class="">
                            <ul class="pt-3 ">
                                <ul class="social-network">
                                    <x-footer-social-links/>
                                </ul>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8 col-lg-8 col-md-6">

                    <x-footer-section-widgets/>

                </div>

            </div>
        </div>
    </div>
</footer>
