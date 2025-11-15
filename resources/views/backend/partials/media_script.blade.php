<script>

    let strings = {
        uploading: '{{__('setting.uploading')}}',
        cancelUpload: '{{__('setting.Cancel upload')}}',
        chooseFiles: '{{__('setting.Choose files')}}',
        addedNumFiles: '{{__('setting.Added')}} %{numFiles} {{__('setting.files')}}',
        addingMoreFiles: '{{__('setting.Adding more files')}}',
        done: '{{__('setting.Done')}}',
        complete: '{{__('setting.Complete')}}',
        addMore: '{{__('setting.Add more')}}',
        uploadComplete: '{{__('setting.Upload complete')}}',
        browseFiles: '{{__('setting.Browse Files')}}',
        dropPasteFiles: '{{__('setting.Drop files here')}} {{__('common.Or')}}  %{browseFiles}',

    };
    const Amaz = new Object();
    Amaz.data = {
        csrf: $('meta[name="_token"]').attr("content"),
        appUrl: '{{url("/")}}',
        fileBaseUrl: '{{url("/")}}' + '/'
    };
    Amaz.uploader = {
        data: {
            selectedFiles: [],
            selectedFilesObject: [],
            clickedForDelete: null,
            allFiles: [],
            multiple: false,
            type: "all",
            next_page_url: null,
            prev_page_url: null,
            for_name: ''
        },
        amazUppy: function () {
            if ($(".AmazUppyDragDrop").length > 0) {
                let uppy = new Uppy.Core({
                    autoProceed: true,
                    restrictions: {
                        maxFileSize: {{getMaxUploadFileSize()}},
                        maxNumberOfFiles: 20,
                        minNumberOfFiles: 1,
                        // allowedFileTypes: ['image/*']
                    }
                });
                uppy.use(Uppy.Dashboard, {
                    target: ".AmazUppyDragDrop",
                    inline: true,
                    locale: {
                        strings: strings,
                    },
                    showLinkToFileUploadResult: false,
                    showProgressDetails: true,
                    hideCancelButton: true,
                    hidePauseResumeButton: true,
                    hideUploadButton: true,
                    proudlyDisplayPoweredByUppy: false,
                });
                uppy.use(Uppy.XHRUpload, {
                    endpoint: '{{route('setting.media-manager.store')}}',
                    fieldName: "file",
                    formData: true,
                    headers: {
                        'X-CSRF-TOKEN': Amaz.data.csrf,
                    },
                });
                uppy.on("upload-success", function () {
                    Amaz.uploader.getAllUploads(
                        "{{route('setting.media-manager.get_files_for_modal')}}"
                    );
                });
            }
        },
        getAllUploads: function (url, search_key = null, sort_key = null) {
            $("#all_files_div").html(
                '<div class="loader_media"><div class="hhhdots_1"></div></div>'
            );
            let params = {};
            if (search_key != null && search_key.length > 0) {
                params["search"] = search_key;
            }
            if (sort_key != null && sort_key.length > 0) {
                params["sort"] = sort_key;
            } else {
                params["sort"] = 'newest';
            }
            $.get(url, params, function (data, status) {

                if (typeof data == 'string') {
                    data = JSON.parse(data);
                }
                Amaz.uploader.data.allFiles = data.files.data;
                Amaz.uploader.allowedFileType();
                Amaz.uploader.addSelectedValue();
                Amaz.uploader.addHiddenValue();
                Amaz.uploader.updateUploaderFiles();
                if (data.files.next_page_url != null) {
                    Amaz.uploader.data.next_page_url = data.files.next_page_url;
                    $("#uploader_next_btn").removeAttr("disabled");
                } else {
                    $("#uploader_next_btn").attr("disabled", true);
                }
                if (data.files.prev_page_url != null) {
                    Amaz.uploader.data.prev_page_url = data.files.prev_page_url;
                    $("#uploader_prev_btn").removeAttr("disabled");
                } else {
                    $("#uploader_prev_btn").attr("disabled", true);
                }
            });
        },
        allowedFileType: function () {
            if (Amaz.uploader.data.type !== "all") {
                let type = Amaz.uploader.data.type.split(',')
                Amaz.uploader.data.allFiles = Amaz.uploader.data.allFiles.filter(
                    function (item) {
                        return type.includes(item.type);
                    }
                );
            }
        },
        addHiddenValue: function () {
            for (let i = 0; i < Amaz.uploader.data.allFiles.length; i++) {
                Amaz.uploader.data.allFiles[i].aria_hidden = false;
            }
        },
        addSelectedValue: function () {
            for (let i = 0; i < Amaz.uploader.data.allFiles.length; i++) {
                if (
                    !Amaz.uploader.data.selectedFiles.includes(
                        Amaz.uploader.data.allFiles[i].id
                    )
                ) {
                    Amaz.uploader.data.allFiles[i].selected = false;
                } else {
                    Amaz.uploader.data.allFiles[i].selected = true;
                }
            }
        },
        updateUploaderSelected: function () {
            $(".upload_files_selected").html(
                Amaz.uploader.updateFileHtml(Amaz.uploader.data.selectedFiles)
            );
        },
        updateFileHtml: function (array) {
            let fileText = "";
            if (array.length > 1) {
                fileText = '{{__('setting.File Selected')}}';
            } else {
                fileText = '{{__('setting.Files Selected')}}';
            }
            return array.length + " " + fileText;
        },
        updateUploaderFiles: function () {
            $("#all_files_div").html(
                '<div class="loader_media"><div class="hhhdots_1"></div></div>'
            );

            let data = Amaz.uploader.data.allFiles;

            setTimeout(function () {
                $("#all_files_div").html(null);

                if (data.length > 0) {
                    for (let i = 0; i < data.length; i++) {
                        let thumb = "";
                        let hidden = "";
                        if (data[i].type === "image") {
                            if (data[i].storage == 'local') {
                                thumb =
                                    '<img src="' +
                                    Amaz.data.fileBaseUrl +
                                    data[i].file_name +
                                    '" class="">';
                            } else {
                                thumb =
                                    '<img src="' + data[i].file_name + '" class="">';
                            }

                        } else {
                            thumb = '<i class="ti-files"></i>';
                        }
                        let html = `
                            <div class="infixlms_file_body single_files" aria-hidden="${data[i].aria_hidden}" data-selected="${data[i].selected}">
                                <div class="modal_file_box" data-value="${data[i].id}">
                                    <div class="img-box">
                                        ${thumb}
                                    </div>
                                    <div class="infixlms_file_content-box">
                                        <div class="file-content-wrapper">
                                            <h5>${data[i].original_name}</h5>
                                            <p>${data[i].size} kb</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        $("#all_files_div").append(html);
                    }
                } else {
                    $("#all_files_div").html(
                        '<div class="align-items-center d-flex justify-content-center w-100"><div class="text-center"><h3>{{trans('common.No files found')}}</h3></div></div>'
                    );
                }
                Amaz.uploader.uploadSelect();
                // Amaz.uploader.deleteUploaderFile();
            }, 300);
        },
        searchUploaderFiles: function () {
            let timeout;
            $('[name="amaz_media_search"]').on("keyup", function () {
                let value = $(this).val();

                if (timeout) {
                    clearTimeout(timeout);
                }
                timeout = setTimeout(function () {
                    Amaz.uploader.getAllUploads(
                        "{{route('setting.media-manager.get_files_for_modal')}}",
                        value,
                        $('[name="Amaz_media_sort"]').val()
                    );
                }, 300);
            });

        },
        sortUploaderFiles: function () {
            $('[name="Amaz_media_sort"]').on("change", function () {
                let value = $(this).val();
                Amaz.uploader.getAllUploads(
                    "{{route('setting.media-manager.get_files_for_modal')}}",
                    $('[name="amaz_media_search"]').val(),
                    value
                );
            });
        },
        uploadSelect: function () {
            $(".modal_file_box").each(function () {
                let elem = $(this);
                elem.on("click", function (e) {
                    e.preventDefault();
                    let value = $(this).data("value");

                    let valueObject =
                        Amaz.uploader.data.allFiles[
                            Amaz.uploader.data.allFiles.findIndex(
                                (x) => x.id === value
                            )
                            ];

                    // elem.closest(".single_files").toggleAttr(
                    //     "data-selected",
                    //     "true",
                    //     "false"
                    // );
                    let closestSingleFiles = elem.closest(".single_files");
                    let isSelected = closestSingleFiles.attr("data-selected");

                    if (isSelected === "true") {
                        closestSingleFiles.attr("data-selected", "false");
                    } else {
                        closestSingleFiles.attr("data-selected", "true");
                    }
                    if (!Amaz.uploader.data.multiple) {
                        elem.closest(".single_files")
                            .siblings()
                            .attr("data-selected", "false");
                    }
                    if (!Amaz.uploader.data.selectedFiles.includes(value)) {
                        if (!Amaz.uploader.data.multiple) {
                            Amaz.uploader.data.selectedFiles = [];
                            Amaz.uploader.data.selectedFilesObject = [];
                        }
                        Amaz.uploader.data.selectedFiles.push(value);
                        Amaz.uploader.data.selectedFilesObject.push(valueObject);
                    } else {
                        Amaz.uploader.data.selectedFiles = Amaz.uploader.data.selectedFiles.filter(
                            function (item) {
                                return item !== value;
                            }
                        );
                        Amaz.uploader.data.selectedFilesObject = Amaz.uploader.data.selectedFilesObject.filter(
                            function (item) {
                                return item !== valueObject;
                            }
                        );
                    }
                    Amaz.uploader.addSelectedValue();
                    Amaz.uploader.updateUploaderSelected();
                });
            });
        },
        showSelectedFiles: function () {
            $('[name="selected_only"]').on("change", function () {
                if ($(this).is(":checked")) {
                    Amaz.uploader.data.allFiles = Amaz.uploader.data.selectedFilesObject;
                    Amaz.uploader.updateUploaderFiles();
                } else {
                    Amaz.uploader.getAllUploads(
                        "{{route('setting.media-manager.get_files_for_modal')}}",
                        $('[name="amaz_media_search"]').val(),
                        $('[name="Amaz_media_sort"]').val()
                    );
                }
            });
        },
        clearUploaderSelected: function () {
            $(".reset_selected").on("click", function (e) {
                e.preventDefault();
                Amaz.uploader.data.selectedFiles = [];
                Amaz.uploader.addSelectedValue();
                Amaz.uploader.addHiddenValue();
                Amaz.uploader.resetFilter();
                // Amaz.uploader.updateUploaderSelected();
                // Amaz.uploader.updateUploaderFiles();

                Amaz.uploader.getAllUploads(
                    "{{route('setting.media-manager.get_files_for_modal')}}",
                    $('[name="amaz_media_search"]').val(),
                    $('[name="Amaz_media_sort"]').val()
                );

            });
        },
        resetFilter: function () {
            $('[name="amaz_media_search"]').val("");
            $('[name="selected_only"]').prop("checked", false);
            $('[name="Amaz_media_sort"] option[value=newest]').prop(
                "selected",
                true
            );
            $('[name="Amaz_media_sort"]').niceSelect('update');
        },


        trigger: function (
            elem = null,
            from = "",
            type = "all",
            selected = "",
            multiple = false,
            callback = null
        ) {
            var elem = $(elem);
            var multiple = multiple;
            var type = type;
            var oldSelectedFiles = selected;
            if (oldSelectedFiles !== "") {
                Amaz.uploader.data.selectedFiles = oldSelectedFiles
                    .split(",")
                    .map(Number);

            } else {
                Amaz.uploader.data.selectedFiles = [];
            }
            if ("undefined" !== typeof type && type.length > 0) {
                Amaz.uploader.data.type = type;
            }
            if (multiple) {
                Amaz.uploader.data.multiple = true;
            } else {
                Amaz.uploader.data.multiple = false;
            }
            $('#pre-loader').removeClass('d-none');

            $.post(
                Amaz.data.appUrl + "/media-manager/get-modal",
                {_token: Amaz.data.csrf},
                function (data) {
                    $('#pre-loader').addClass('d-none');
                    $("#mediaManagerDiv").html(data);
                    $('.modal-backdrop').remove()
                    $("#media_modal").modal("show");
                    $('#sortStatus').niceSelect();
                    Amaz.uploader.amazUppy();
                    Amaz.uploader.getAllUploads(
                        Amaz.data.appUrl + "/media-manager/get-files-modal",
                        null,
                        $('[name="Amaz_media_sort"]').val()
                    );

                    Amaz.uploader.updateUploaderSelected();
                    Amaz.uploader.clearUploaderSelected();
                    Amaz.uploader.sortUploaderFiles();
                    Amaz.uploader.searchUploaderFiles();
                    Amaz.uploader.showSelectedFiles();

                    $("#uploader_next_btn").on("click", function (e) {
                        e.preventDefault();
                        if (Amaz.uploader.data.next_page_url != null) {
                            $('[name="aiz-show-selected"]').prop(
                                "checked",
                                false
                            );
                            Amaz.uploader.getAllUploads(
                                Amaz.uploader.data.next_page_url
                            );
                        }
                    });

                    $("#uploader_prev_btn").on("click", function (e) {
                        e.preventDefault();
                        if (Amaz.uploader.data.prev_page_url != null) {
                            $('[name="aiz-show-selected"]').prop(
                                "checked",
                                false
                            );
                            Amaz.uploader.getAllUploads(
                                Amaz.uploader.data.prev_page_url
                            );
                        }
                    });

                    $(".aiz-uploader-search i").on("click", function (e) {
                        e.preventDefault();
                        $(this).parent().toggleClass("open");
                    });

                    $('[data-bs-toggle="infixUploaderAddSelected"]').on(
                        "click",
                        function (e) {
                            e.preventDefault();
                            if (from === "input") {
                                Amaz.uploader.inputSelectPreviewGenerate(elem);
                            } else if (from === "direct") {
                                callback(Amaz.uploader.data.selectedFiles);
                            }
                            $("#media_modal").modal("hide");
                            $('#pre-loader').removeClass('d-none');
                        }
                    );
                }
            );
        },
        initForInput: function () {
            $(document).on("click", '[data-bs-toggle="infixUploader"]', function (e) {
                e.preventDefault();
                if (e.detail === 1) {
                    var elem = $(this);
                    var multiple = elem.data("multiple");
                    var type = elem.data("type");
                    var oldSelectedFiles = elem.find(".selected_files").val();
                    multiple = !multiple ? "" : multiple;
                    type = !type ? "" : type;
                    oldSelectedFiles = !oldSelectedFiles ? "" : oldSelectedFiles;
                    Amaz.uploader.data.for_name = elem.data('name');
                    Amaz.uploader.trigger(
                        this,
                        "input",
                        type,
                        oldSelectedFiles,
                        multiple
                    );
                }
            });
        },
        inputSelectPreviewGenerate: function (elem) {
            var prev_data = elem.find(".selected_files").val();
            elem.find(".selected_files").val(Amaz.uploader.data.selectedFiles);
            elem.next(".product_image_all_div").html(null);

            if (Amaz.uploader.data.selectedFiles.length > 0) {
                $.post(
                    "{{route('setting.media-manager.get_media_by_id')}}",
                    {_token: Amaz.data.csrf, ids: Amaz.uploader.data.selectedFiles, prev_ids: prev_data},
                    function (data) {
                        $('#pre-loader').addClass('d-none');

                        elem.closest('.single-uploader').find(".product_image_all_div").html(null);

                        if (data.length > 0) {
                            elem.find(".file_amount").attr('placeholder', Amaz.uploader.updateFileHtml(data));
                            for (let i = 0; i < data.length; i++) {


                                let thumb = "";
                                let imag = data[i].file_name;
                                let id = data[i].id;


                                if (data[i].type == 'image') {
                                    if (data[i].storage == 'local') {
                                        $('#show_path').text('{{url('')}}' + '/' + data[i].file_name);
                                        var image_path = "{{asset( '/')}}" + "/" + imag;
                                        imag = image_path;
                                    } else {
                                        $('#show_path').text(data[i].file_name);
                                        imag = imag;
                                    }
                                } else {
                                    if (data[i].storage == 'local') {
                                        $('#show_path').text('{{url('')}}' + '/' + data[i].file_name);
                                    } else {
                                        $('#show_path').text(data[i].file_name);
                                    }
                                    imag = "{{asset( '/')}}" + "public/preview/" + data[i].type + ".png";
                                }
                                thumb = `<img id="ThumbnailImg${id}" src="${imag}" alt="">`;

                                let html = `
                                    <div class="thumb_img_div" data-id="${data[i].id}">
                                        <div class="img_remove_btn">
                                            <i class="fas fa-times"></i>
                                        </div>
                                        ${thumb}
                                        <input type="hidden" class="product_images_hidden" name="${Amaz.uploader.data.for_name}" value="${data[i].id}">
                                    </div>
                                `;

                                elem.closest('.single-uploader').find(".product_image_all_div").append(html);
                            }
                        } else {
                            elem.closest('.single-uploader').find(".file_amount").html('Choose File');
                        }
                    });
            } else {
                elem.closest('.single-uploader').find(".file_amount").html('Choose File');
            }
        },
        previewGenerate: function () {


            $('[data-bs-toggle="infixUploader"]').each(function () {
                let $this = $(this);
                let files = $this.find(".selected_files").val().split(",").map(Number);
                if (files != "") {
                    $.post(
                        "{{route('setting.media-manager.get_media_by_id')}}",
                        {_token: Amaz.data.csrf, ids: files},
                        function (datas) {
                            Amaz.uploader.data.for_name = $this.data('name');
                            data = [];
                            files.forEach(function (key) {
                                let found = false;
                                datas = datas.filter(function (file) {
                                    if (!found && file.id == key) {
                                        data.push(file);
                                        found = true;
                                        return false;
                                    } else
                                        return true;
                                });
                            });
                            Amaz.uploader.data.selectedFilesObject = data;
                            if (data.length > 0) {
                                $this.next(".product_image_all_div").html(null);
                                $this.find(".file_amount").attr('placeholder', Amaz.uploader.updateFileHtml(data));
                                for (let i = 0; i < data.length; i++) {
                                    let thumb = "";
                                    let imag = data[i].file_name;
                                    let id = data[i].id;


                                    if (data[i].type == 'image') {
                                        if (data[i].storage == 'local') {
                                            $('#show_path').text('{{url('')}}' + '/' + data[i].file_name);
                                            var image_path = "{{asset( '/')}}" + "/" + imag;
                                            imag = image_path;
                                        } else {
                                            $('#show_path').text(data[i].file_name);
                                            imag = imag;
                                        }
                                    } else {
                                        if (data[i].storage == 'local') {
                                            $('#show_path').text('{{url('')}}' + '/' + data[i].file_name);
                                        } else {
                                            $('#show_path').text(data[i].file_name);
                                        }
                                        imag = "{{asset( '/')}}" + "public/preview/" + data[i].type + ".png";
                                    }
                                    thumb = `<img id="ThumbnailImg${id}" src="${imag}" alt="">`;

                                    let html = `
                                    <div class="thumb_img_div" data-id="${data[i].id}">
                                        <div class="img_remove_btn">
                                            <i class="fas fa-times"></i>
                                        </div>
                                        ${thumb}
                                        <input type="hidden" name="${Amaz.uploader.data.for_name}" class="product_images_hidden" value="${data[i].id}">
                                    </div>
                                `;

                                    $this.next(".product_image_all_div").append(html);
                                }
                            } else {
                                $this.find(".file_amount").html('Choose File');
                            }
                        });
                }
            });


        },
        removeAttachment: function () {
            $(document).on("click", '.img_remove_btn', function (e) {
                e.preventDefault();
                let value = $(this)
                    .closest(".thumb_img_div")
                    .data("id");
                let selected = $(this)
                    .closest(".product_image_all_div")
                    .prev('[data-bs-toggle="infixUploader"]')
                    .find(".selected_files")
                    .val()
                    .split(",")
                    .map(Number);

                Amaz.uploader.removeInputValue(
                    value,
                    selected,
                    $(this)
                        .closest(".product_image_all_div")
                        .prev('[data-bs-toggle="infixUploader"]')
                );
                $(this).closest(".thumb_img_div").remove();
            });
        },
        removeInputValue: function (id, array, elem) {
            let selected = array.filter(function (item) {
                return item !== id;
            });
            if (selected.length > 0) {
                $(elem)
                    .find(".file_amount")
                    .attr('placeholder', Amaz.uploader.updateFileHtml(selected));
            } else {
                elem.find(".file_amount").attr('placeholder', 'Choose File');
            }
            $(elem).find(".selected_files").val(selected);
        },
        sortImage: function () {
            $(".product_image_all_div").sortable({
                cursor: "move",
                connectWith: ".thumb_img_div",
                update: function (event, ui) {
                    let imageids = [];
                    $(this).find('.product_images_hidden').each(function (id) {
                        imageids.push($(this).val());
                    });
                    $(this).prev('[data-bs-toggle="infixUploader"]').find('.selected_files').val(imageids.join(','));
                }
            });
        }

    };

    Amaz.uploader.clearUploaderSelected();
    Amaz.uploader.initForInput();
    Amaz.uploader.removeAttachment();
    Amaz.uploader.sortImage();
    Amaz.uploader.previewGenerate();
</script>
