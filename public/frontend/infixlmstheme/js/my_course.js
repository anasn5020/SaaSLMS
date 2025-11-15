$("#categoryFilter").on('change', function () {
    let category = this.value;
    let site = $('#siteUrl').val();
    window.location.replace(site + "?category=" + category);

});
