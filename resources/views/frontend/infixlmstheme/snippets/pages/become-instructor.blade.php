<div
    class="full-page"
    data-type="component-text"
    data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/become_instructor_page/all_section.jpg')}}"
    data-aoraeditor-title="All Section"
    data-aoraeditor-categories="Become Instructor Page"
>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._banner'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._become-instructor-page-join'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._become-instructor-page-join-top'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._become-instructor-page-process'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._become-instructor-page-join-bottom'))
        </div>
    </div>

</div>

@include(theme('snippets.components._become-instructor-page-join'))
@include(theme('snippets.components._become-instructor-page-join-top'))
@include(theme('snippets.components._become-instructor-page-process'))
@include(theme('snippets.components._become-instructor-page-join-bottom'))
