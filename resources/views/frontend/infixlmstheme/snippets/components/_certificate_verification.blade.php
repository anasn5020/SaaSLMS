<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/class/class_page_section.jpg')}}"
     data-aoraeditor-title="Certificate Verification Form" data-aoraeditor-categories="Certificate Verification Page">



    <link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/css/homepageV7/verify-certificate-v7.css')}}">
    <div class="verify_certificate_section container">
        <div class="row justify-content-center">
            <div class="col-md-6 d-flex flex-column align-items-center">
                <img src="{{themeAsset('img/verify-certificate.png')}}" class="verify_certificate_image" alt="verify certificate">
                <h2 class="verify_certificate_title">{{__('certificate.Certificate Verification')}}</h2>
                <form action="" class="verify_certificate_form d-flex gap-14">
                    <input type="text" name="certificate_number" class="verify_certificate_input"
                           value="{{old('certificate_number')}}"
                           placeholder="{{__('certificate.Enter Certificate Number')}}">
                    <button id="getCertificate"
                            type="button" class="verify_certificate_search">{{__('common.Search')}}</button>
                </form>
            </div>

            <div class="address_lines py-3">
                <img class="d-none" style="width: 100%; height:auto" src=""
                     id="certificateImg"
                     alt="">
                <h2 class="text-center text-danger" id="certificateMsg"></h2>
            </div>
        </div>
    </div>


</div>
