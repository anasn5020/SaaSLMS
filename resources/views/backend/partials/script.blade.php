<script src="{{asset('public/backend/js/plugin.js')}}{{assetVersion()}}" type="application/javascript"></script>

<script>
    @php
        $pdf_font= Settings('datatable_default_font');
        if(!$pdf_font || !file_exists(base_path('public/fonts/DejaVuSans.ttf'))){
            $pdf_font =asset('public/fonts/DejaVuSans.ttf');
        }else{
            $pdf_font = asset(Settings('datatable_default_font'));
        }

    @endphp

        pdfMake.fonts = {
        defaultFont: {
            normal: '{{$pdf_font}}',
            bold: '{{$pdf_font}}',
            italics: '{{$pdf_font}}',
            bolditalics: '{{$pdf_font}}',
        }
    };

</script>
<script src="{{asset('public/backend/js/datatable_extra.js')}}{{assetVersion()}}" type="application/javascript"></script>

{{--<script src="{{asset('public/backend/js/jquery-ui.js')}}"></script>--}}
@if(isModuleActive('Org'))
    <script src="{{asset('public/js/loadingoverlay.min.js')}}{{assetVersion()}}" type="application/javascript"></script>
@endif

<script>
    if ($('#main-nav-for-chat').length) {
    } else {
        $('#main-content').append('<div id="main-nav-for-chat" style="visibility: hidden;"></div>');
    }

    if ($('#admin-visitor-area').length) {
    } else {
        $('#main-content').append('<div id="admin-visitor-area" style="visibility: hidden;"></div>');
    }
</script>

@if(isModuleActive('Chat'))
    <script src="{{ asset('public/js/app.js') }}{{assetVersion()}}" type="application/javascript"></script>
@endif

<script>

    $(document).on('click', '.unread_notification', function (e) {
        e.preventDefault();
        $('.preloader').fadeIn('slow');
        let notification_id = $(this).attr('data-notification_id');
        let count_txt = $('.notificationCount');
        let count = count_txt.text();
        if (count > 0) {
            count--;
            count_txt.text(count);
        }
        $(this).closest('.single_notify').remove();


        let url = $('#url').val();

        let formData = {
            id: notification_id
        };
        $.ajax({
            type: "GET",
            data: formData,
            dataType: 'json',
            url: url + '/' + 'ajaxNotificationMakeRead',
            success: function (data) {
                if (data != '') {
                    window.location.href = data;

                } else {
                    $('.preloader').fadeOut('slow');
                }

            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    });

</script>


<script>
    if ($('.Crm_table_active3').length) {
        let datatable = $('.Crm_table_active3').DataTable(dataTableOptions);

        $(".selectAllQuiz").on("click", function () {
            let totalQuestions = $('#totalQuestions');
            let totalMarks = $('#totalMarks');

            if ($(this).is(':checked')) {
                datatable.$("input[type='checkbox']").prop('checked', true);
            } else {
                datatable.$("input[type='checkbox']").prop('checked', false);
            }
            let online_exam_id = $('#online_exam_id').val();
            let ques_assign = $('.ques_assign').val();
            let token = $('.csrf_token').val();
            var myCheckboxes = [];
            datatable.$("input[type='checkbox']").each(function () {
                if ($(this).is(':checked')) {
                    myCheckboxes.push($(this).val());
                }
            });
            $.ajax({
                type: 'POST',
                url: ques_assign,
                data: {
                    '_token': token,
                    online_exam_id: online_exam_id,
                    questions: myCheckboxes,
                },
                success: function (data) {
                    totalQuestions.html(data.totalQus);
                    totalMarks.html(data.totalMarks);
                    toastr.success('{{__('common.Successfully Assign')}}', '{{__('common.Success')}}');
                },
                error: function (data) {
                    toastr.error('{{__('common.Something Went Wrong')}}', '{{__('common.Error')}}')
                }
            });
        });

    }
</script>
<script>
    setTimeout(function () {
        $('.preloader').fadeOut('slow', function () {
            // $(this).remove();
        });
    }, 0);
</script>

<script>
    if ($('#main-nav-for-chat').length) {
    } else {
        $('#main-content').append('<div id="main-nav-for-chat" style="display: none;"></div>');
    }

    if ($('#admin-visitor-area').length) {
    } else {
        $('#main-content').append('<div id="admin-visitor-area" style="visibility: hidden;"></div>');
    }
</script>

<script>
    //datatable caching
    $.fn.dataTable.pipeline = function (opts) {
        // Configuration options
        var conf = $.extend({
            pages: 5,     // number of pages to cache
            url: '',      // script url
            data: null,   // function or object with parameters to send to the server
                          // matching how `ajax.data` works in DataTables
            method: 'GET' // Ajax HTTP method
        }, opts);
        // Private variables for storing the cache
        var cacheLower = -1;
        var cacheUpper = null;
        var cacheLastRequest = null;
        var cacheLastJson = null;
        return function (request, drawCallback, settings) {
            var ajax = false;
            var requestStart = request.start;
            var drawStart = request.start;
            var requestLength = request.length;
            var requestEnd = requestStart + requestLength;

            if (settings.clearCache) {
                // API requested that the cache be cleared
                ajax = true;
                settings.clearCache = false;
            } else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
                // outside cached data - need to make a request
                ajax = true;
            } else if (JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) ||
                JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
                JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
            ) {
                // properties changed (ordering, columns, searching)
                ajax = true;
            }

            // Store the request for checking next time around
            cacheLastRequest = $.extend(true, {}, request);

            if (ajax) {
                // Need data from the server
                if (requestStart < cacheLower) {
                    requestStart = requestStart - (requestLength * (conf.pages - 1));

                    if (requestStart < 0) {
                        requestStart = 0;
                    }
                }
                cacheLower = requestStart;
                cacheUpper = requestStart + (requestLength * conf.pages);

                request.start = requestStart;
                request.length = requestLength * conf.pages;

                // Provide the same `data` options as DataTables.
                if (typeof conf.data === 'function') {
                    // As a function it is executed with the data object as an arg
                    // for manipulation. If an object is returned, it is used as the
                    // data object to submit
                    var d = conf.data(request);
                    if (d) {
                        $.extend(request, d);
                    }
                } else if ($.isPlainObject(conf.data)) {
                    // As an object, the data given extends the default
                    $.extend(request, conf.data);
                }

                return $.ajax(
                    {
                        "type": conf.method,
                        "url": conf.url,
                        "data": request,
                        "dataType": "json",
                        "cache": false,
                        "success": function (json) {
                            cacheLastJson = $.extend(true, {}, json);

                            if (cacheLower != drawStart) {
                                json.data.splice(0, drawStart - cacheLower);
                            }
                            if (requestLength >= -1) {
                                json.data.splice(requestLength, json.data.length);
                            }

                            drawCallback(json);
                        }
                    });
            } else {
                var json = $.extend(true, {}, cacheLastJson);
                json.draw = request.draw; // Update the echo for each response
                json.data.splice(0, requestStart - cacheLower);
                json.data.splice(requestLength, json.data.length);

                drawCallback(json);
            }
        }
    };

    // Register an API method that will empty the pipelined data, forcing an Ajax
    // fetch on the next draw (i.e. `table.clearPipeline().draw()`)
    $.fn.dataTable.Api.register('clearPipeline()', function () {
        return this.iterator('table', function (settings) {
            settings.clearCache = true;
        });
    });
</script>

<script>
    $(function () {
        initFilePond();
    });

    function initFilePond() {
        FilePond.registerPlugin(FilePondPluginFileValidateType);

        let inputs = $('.filepond');
        const filePondInstances = [];
        inputs.each(function (i, obj) {
            let existingFileUrl = $(this).data('file');
            let fileType = $(this).data('type');
            let data_accepts = $(this).data('accepts') ?? "";
            let allowFileTypeValidation = false;
            let accepts = data_accepts != "" ? data_accepts.split(',') : '';
            if (accepts.length > 0) {
                allowFileTypeValidation = true;
            }
            const pond = FilePond.create(obj, {
                allowRevert: true,

                allowFileTypeValidation: allowFileTypeValidation,
                acceptedFileTypes: accepts,
                labelFileTypeNotAllowed: '{{__('common.Invalid File Format')}}',

                chunkUploads: true,
                'allowMultiple': $('#multipleForm').length ? true : false,
                server: {
                    url: '{{url('/filepond/api/process')}}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                files: existingFileUrl
                    ? [
                        {
                            source: existingFileUrl,
                            options: {
                                type: fileType ? fileType : 'local',
                            },
                        },
                    ]
                    : null,
                // Add any desired plugins
                plugins: [FilePondPluginFileValidateType],

            });
            if (existingFileUrl) {
                pond.setOptions({
                    data: {
                        fileUrl: existingFileUrl,
                    },
                });
            }
            filePondInstances.push(pond);
        });
    }
</script>
<script src="{{ asset('public/chat/js/custom.js') }}{{assetVersion()}}"></script>
@if(isModuleActive("WhatsappSupport"))
    <script src="{{ asset('public/whatsapp-support/scripts.js') }}{{assetVersion()}}"></script>
@endif
<!-- Load Uppy JS bundle. -->
<script src="{{ asset('public/vendor/uppy/uppy.min.js') }}"></script>
<script src="{{ asset('public/vendor/uppy/uppy.legacy.min.js') }}"></script>
<script src="{{ asset('public/vendor/uppy/ru_RU.min.js') }}"></script>

@stack('scripts')
<script>
    $('.dataTables_length label select').niceSelect();
    $('.dataTables_length label .nice-select').addClass('dataTable_select');
    $(document).on('click', '.dataTables_length label .nice-select', function () {
        $(this).toggleClass('open_selectlist');
    })
</script>

