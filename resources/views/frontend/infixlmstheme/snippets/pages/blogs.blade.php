<div
    class="full-page"
    data-type="component-text"
    data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/blog/list.jpg')}}"
    data-aoraeditor-title="All Blog Page Section"
    data-aoraeditor-categories="Blog Page"
>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._banner'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._blog_page_section'))
        </div>
    </div>

</div>
@include(theme('snippets.components._blog_page_section'))
