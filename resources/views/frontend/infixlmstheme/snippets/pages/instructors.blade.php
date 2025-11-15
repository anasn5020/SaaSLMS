<div
    class="full-page"
    data-type="component-text"
    data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/instractor/all_section.jpg')}}"
    data-aoraeditor-title="All Instructor Section" data-aoraeditor-categories="Instructor Page">

    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._banner'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._popular_instructors'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._all_instructors'))
        </div>
    </div>

</div>

@include(theme('snippets.components._popular_instructors'))
@include(theme('snippets.components._all_instructors'))
