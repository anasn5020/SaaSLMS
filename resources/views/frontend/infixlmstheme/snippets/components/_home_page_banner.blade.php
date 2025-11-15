<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/homepage_banner.jpg')}}"
     data-aoraeditor-title="HomePage Banner" data-aoraeditor-categories="Home Page;Banner">

    <form action="{{route('search')}}">
        <div class="banner_area"
             @if(isset($homeContent->slider_banner) && !empty($homeContent->slider_banner))
                 style="background-image: url('{{asset(@$homeContent->slider_banner)}}')"
            @endif>
            <div class="container">
                <div class="row d-flex align-items-center">
                    <div class="col-lg-9 offset-lg-1">
                        <div class="banner_text">
                            <h3>{{@$homeContent->slider_title}}</h3>
                            <p>{{@$homeContent->slider_text}}</p>
                            @if(@$homeContent->show_banner_search_box==1)
                                <div class="input-group theme_search_field large_search_field">
                                    <div class="input-group-prepend">
                                        <button class="btn" type="button" id="button-addon2"><i
                                                class="ti-search"></i>
                                        </button>
                                    </div>
                                    <input type="text" name="query" class="form-control"
                                           placeholder="{{__('frontend.Search for course, skills and Videos')}}">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
