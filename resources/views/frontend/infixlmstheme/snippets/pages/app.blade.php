<div
    class="full-page"
    data-type="component-text"
    data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/class/all_class_page_section.jpg')}}"
    data-aoraeditor-title="Only App Mode" data-aoraeditor-categories="App Page">

    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._section_title'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._apk_section'))
        </div>
    </div>
</div>

@include(theme('snippets.components._section_title'))
