(function ($) {
    "use strict";

    $(document).ready(function () {
        // select js
        $(".search-hide").select2({
            minimumResultsForSearch: Infinity,
        });
    });

    $(document).ready(function () {

        $(document).on("click", "#show-filter", function (e) {
            $(this)
                .closest(".course-filter")
                .find(".course-filter-wrapper")
                .slideToggle("fast");
        });
        $(document).on("click", "#hide-filter", function (e) {
            $(this)
                .closest(".course-filter")
                .find(".course-filter-wrapper")
                .slideUp("fast");
        });

        // course grid view toggle
        $(document).on("click", "#course_list", function (e) {
            $("#course_grid").removeClass("active");
            $(this).addClass("active");
        });

        $(document).on("click", "#course_grid", function (e) {
            $("#course_list").removeClass("active");
            $(this).addClass("active");
        });

        // sidebar categorys
        $(document).on("click", "#sidebar-cate", function (e) {
            $(this)
                .closest(".course-filter-sidebar")
                .find(".course-filter-limit")
                .css("height", "auto");
        });
        $(document).on("click", "#show-side-filter", function (e) {
            e.stopPropagation();
            $(".course-filter-sidebar").toggleClass("show");
            $(".backdrop").toggleClass("show");
        });
        $(document).on("click", "[data-dismiss]", function (e) {
            $(".course-filter-sidebar").removeClass("show");
            $(".backdrop").removeClass("show");
        });
        $(document).on("click", function (e) {
            if (!$(e.target).is(".course-filter-sidebar *")) {
                $(".course-filter-sidebar").removeClass("show");
                $(".backdrop").removeClass("show");
            }
        });
    });


})(jQuery);
