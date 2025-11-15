@if ($lesson->host == 'XAPI' || $lesson->host == 'XAPI-AwsS3')
    <script>
        @if (!isset($lesson->completed->status))

        function checkCompleteStatus() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var course_id = "{{ $course->id }}";
            var lesson_id = "{{ $lesson->id }}";
            $.ajax({
                type: 'POST',
                url: '{{ route('xapi.checkLessonStatus') }}',
                data: {
                    course_id: course_id,
                    lesson_id: lesson_id
                },
                success: function (data) {
                    if (data == 1) {
                        if ($('#autoNext').is(':checked')) {
                            if ($('#next_lesson_btn').length) {
                                jQuery('#next_lesson_btn').click();
                            } else {
                                location.reload();
                            }
                        }
                    }
                }
            });
        }

        setInterval(checkCompleteStatus, 2000)
        @endif
    </script>
@endif

@if (
    $lesson->host == 'SCORM' ||
        $lesson->host == 'SCORM-AwsS3' ||
        $lesson->host == 'XAPI' ||
        $lesson->host == 'XAPI-AwsS3')
    <script>
        let video_element = $('#video-id');
        let url = "{{ asset($lesson->video_url) }}";
        let LESSON_ID = "{{$lesson->id}}";
        @auth
        let full_name = "{{ auth()->user()->name }}";
        @if (isModuleActive('Org'))
        let org_chart_name = "{{ auth()->user()->branch->group }}";
        @endif
        @endauth
        @guest()
        let full_name = "Guest";
        let org_chart_name = "";
        @endguest
        let course_name = "{{ $course->title }}";





        @if ($lesson->scorm_version == 'scorm_12')

        var API = {};

        (function ($) {
            $(document).ready(function () {
                setupScormApi()
                video_element.attr('src', url)
            });

            function setupScormApi() {
                API.LMSInitialize = LMSInitialize;
                API.LMSGetValue = LMSGetValue;
                API.LMSSetValue = LMSSetValue;
                API.LMSCommit = LMSCommit;
                API.LMSFinish = LMSFinish;
                API.LMSGetLastError = LMSGetLastError;
                API.LMSGetDiagnostic = LMSGetDiagnostic;
                API.LMSGetErrorString = LMSGetErrorString;
            }

            function LMSInitialize(initializeInput) {
                displayLog("LMSInitialize: " + initializeInput);
                return true;
            }

            function LMSGetValue(varname) {


                displayLog("LMSGetValue: " + varname);
                return varname;
            }

            function LMSSetValue(varname, varvalue) {
                updateScormReport(varname, varvalue);
                if (varvalue == 'completed' || varvalue == 'passed') {
                    lessonAutoComplete(course_id, {{ showPicName(Request::url()) }});
                }
                // displayLog("LMSSetValue: " + varname + "=" + varvalue);
                return "";
            }

            function LMSCommit(commitInput) {
                displayLog("LMSCommit: " + commitInput);
                return true;
            }

            function LMSFinish(finishInput) {
                lessonAutoComplete(course_id, {{ showPicName(Request::url()) }});
                displayLog("LMSFinish: " + finishInput);
                return true;
            }

            function LMSGetLastError() {
                displayLog("LMSGetLastError: ");
                return 0;
            }

            function LMSGetDiagnostic(errorCode) {
                displayLog("LMSGetDiagnostic: " + errorCode);
                return "";
            }

            function LMSGetErrorString(errorCode) {
                displayLog("LMSGetErrorString: " + errorCode);
                return "";
            }

        })(jQuery);
        @elseif ($lesson->scorm_version == 'scorm_2004')

        var API_1484_11 = {};

        (function ($) {
            $(document).ready(function () {
                setupScormApi();
                video_element.attr('src', url);

                window.addEventListener('unload', saveScormProgress);
                window.addEventListener('beforeunload', saveScormProgress);
            });

            function setupScormApi() {
                API_1484_11.Initialize = Initialize;
                API_1484_11.Commit = Commit;
                API_1484_11.Terminate = Terminate;
                API_1484_11.GetValue = GetValue;
                API_1484_11.SetValue = SetValue;
                API_1484_11.GetErrorString = GetErrorString;
                API_1484_11.GetDiagnostic = GetDiagnostic;
                API_1484_11.GetLastError = GetLastError;


            }

            function Initialize(parameter) {
                loadScormProgress();

                displayLog('Initialize ' + parameter)
                return true
            }

            function Commit(parameter) {
                displayLog('Commit ' + parameter)
                saveScormProgress();
                return true
            }

            function Terminate(parameter) {
                {{-- lessonAutoComplete(course_id, {{showPicName(Request::url())}}); --}}
                displayLog('Terminate ' + parameter)
                saveScormProgress();
                return true
            }

            function GetValue(name) {
                displayLog('GetValue ' + name)
                return localStorage.getItem('scorm_' + LESSON_ID + '_' + name) || "";

            }

            function SetValue(name, value) {
                localStorage.setItem('scorm_' + LESSON_ID + '_' + name, value);
                updateScormReport(name, value);
                if (value == 'completed' || value == 'passed') {
                    lessonAutoComplete(course_id, {{ showPicName(Request::url()) }});
                }
                displayLog('SetValue ' + name + ' = ' + value)
                saveScormProgress();
                return true
            }

            function GetErrorString() {
                displayLog('GetErrorString')
                return ''
            }

            function GetDiagnostic() {
                displayLog('GetDiagnostic')
                return ''
            }

            function GetLastError() {
                displayLog('GetLastError')
                return 0
            }

            function saveScormProgress() {
                var lessonLocation = API_1484_11.GetValue('cmi.location');
                var suspendData = API_1484_11.GetValue('cmi.suspend_data');

                if (lessonLocation && suspendData) {
                    fetch("{{url('/scorm/save-progress')}}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            lesson_id: LESSON_ID,
                            lesson_location: lessonLocation,
                            suspend_data: suspendData
                        })
                    }).then(response => response.json())
                        .then(data => displayLog('Progress saved'))
                        .catch(error => displayLog('Error saving progress: ' + error));
                    ;

                }
            }

            function loadScormProgress() {
                fetch("{{url('/scorm/get-progress/'.$lesson->id)}}")
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.lesson_location && data.suspend_data) {
                            API_1484_11.SetValue('cmi.location', data.lesson_location);
                            API_1484_11.SetValue('cmi.suspend_data', data.suspend_data);
                            displayLog('Progress loaded');
                        }
                    }).catch(error => displayLog('Error loading progress: ' + error));
                ;
            }


        })(jQuery);
        @endif


        function displayLog(textToDisplay) {
            // console.log(textToDisplay);
        }

        @if (isModuleActive('SCORM'))
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function updateScormReport(key, value) {
            @if (!isset($lesson->completed->status))

            var course_id = "{{ $course->id }}";
            var lesson_id = "{{ $lesson->id }}";
            $.ajax({
                type: 'POST',
                url: '{{ route('scorm.report.store') }}',
                data: {
                    course_id: course_id,
                    lesson_id: lesson_id,
                    key: key,
                    value: value
                },
                success: function (data) {
                    console.log(data);
                }
            });
            @endif


        }

        @endif
    </script>
@endif
