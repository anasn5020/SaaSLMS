<div
    class="full-page"
    data-type="component-text"
    data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/certificate_verification/search.jpg')}}"
    data-aoraeditor-title="Certificate Verification Page" data-aoraeditor-categories="Certificate Verification Page">
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._banner'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._certificate_verification'))
        </div>
    </div>

</div>
@include(theme('snippets.components._certificate_verification'))
