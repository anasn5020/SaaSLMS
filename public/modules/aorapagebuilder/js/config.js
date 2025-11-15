CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
    // config.extraPlugins = 'bgimage';
    // config.allowedContent = 'div{.background-image}';
    // config.extraPlugins = 'imageuploader';

    let url = $('#url').val();

    config.filebrowserUploadUrl = url + '/page-builder/new-upload';
    config.filebrowserUploadMethod = 'form';
};
