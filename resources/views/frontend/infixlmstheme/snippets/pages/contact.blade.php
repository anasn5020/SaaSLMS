<div
    class="full-page"
    data-type="component-text"
    data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/contact/all_contact_page_section.jpg')}}"
    data-aoraeditor-title="All Contact Page Section" data-aoraeditor-categories="Contact Page">

    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._banner'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._contact_map'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._contact_page_section'))
        </div>
    </div>

</div>

@include(theme('snippets.components._contact_page_section'))
@include(theme('snippets.components._contact_map'))
