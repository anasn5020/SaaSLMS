<?php

namespace Modules\CourseSetting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendGeneralEmail;
use App\LessonComplete;
use App\Traits\BunnySettings;
use App\Traits\Filepond;
use App\Traits\Gdrive;
use App\Traits\SendNotification;
use App\Traits\UploadMedia;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Modules\BunnyStorage\Entities\BunnyLesson;
use Modules\BunnyStorage\Http\Controllers\BunnyStreamController;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Chapter;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseExercise;
use Modules\CourseSetting\Entities\CourseLevel;
use Modules\CourseSetting\Entities\Lesson;
use Modules\CourseSetting\Entities\LessonFile;
use Modules\H5P\Http\Controllers\H5PController;
use Modules\Localization\Entities\Language;
use Modules\Org\Entities\OrgMaterial;
use Modules\Org\Entities\OrgMaterialFile;
use Modules\Quiz\Entities\OnlineQuiz;
use Modules\SCORM\Http\Controllers\SCORMController;
use Modules\VdoCipher\Http\Controllers\VdoCipherController;
use Modules\XAPI\Http\Controllers\XAPIController;

class InstructorCourseSettingController extends Controller
{
    use Filepond, Gdrive, BunnySettings, SendNotification, UploadMedia;

    public function saveChapter(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = $this->rules($request);
        $this->validate($request, $rules, validationMessage($rules));

        if ($request->input_type == 1) {
            try {
                $loginUser = Auth::user();

                $course = Course::where('id', $request->course_id)->first();


                if (isset($course)) {

                    $chpter_no = Chapter::where('course_id', $course->course_id)->count();
                    $chapter = new Chapter();
                    $chapter->name = $request->chapter_name;
                    $chapter->course_id = $request->course_id;
                    $chapter->chapter_no = $chpter_no + 1;
                    $chapter->save();

                    if (isset($course->enrollUsers) && !empty($course->enrollUsers)) {
                        foreach ($course->enrollUsers as $user) {

                            $this->sendNotification('Course_Chapter_Added', $user, [
                                'time' => Carbon::now()->translatedFormat('d-M-Y, g:i A'),
                                'course' => $course->getTranslation('title', $user->language_code ?? config('app.fallback_locale')),
                                'chapter' => $chapter->name,
                            ], [
                                'actionText' => trans('common.View'),
                                'actionUrl' => courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                            ]);

                        }
                    }

                    $this->sendNotification('Course_Chapter_Added', $course->user, [
                        'time' => Carbon::now()->translatedFormat('d-M-Y, g:i A'),
                        'course' => $course->getTranslation('title', $course->user->language_code ?? config('app.fallback_locale')),
                        'chapter' => $chapter->name,
                    ]);

                    (new CourseSettingController())->updateTotalCountForCourse($course);
                    Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                    return redirect()->route('courseDetails', [$course->id]);
                } else {
                    Toastr::error(trans('frontend.Invalid Request'), trans('common.Failed'));
                    return redirect()->route('courseDetails', [$course->id]);
                }
            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
            }
        } else if ($request->input_type == 2) {
            try {

                $loginUser = Auth::user();
                $course = Course::where('id', $request->course_id)->first();

                $chapter = Chapter::find($request->chapterId);

                if (isset($course) && isset($chapter)) {

                    $lesson = new Lesson();
                    $lesson->course_id = $request->course_id;
                    $lesson->chapter_id = $request->chapterId;
                    $lesson->quiz_id = $request->quiz;
                    $lesson->is_quiz = $request->is_quiz;
                    $lesson->is_lock = (int)$request->lock;
                    $lesson->save();

                    $quiz = OnlineQuiz::find($request->quiz);

                    if (isset($course->enrollUsers) && !empty($course->enrollUsers)) {
                        foreach ($course->enrollUsers as $user) {


                            $this->sendNotification('Course_Quiz_Added', $user, [
                                'time' => Carbon::now()->translatedFormat('d-M-Y, g:i A'),
                                'course' => $course->getTranslation('title', $user->language_code ?? config('app.fallback_locale')),
                                'chapter' => $chapter->name,
                                'quiz' => $quiz->title,
                            ], [
                                'actionText' => trans('common.View'),
                                'actionUrl' => courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                            ]);

                        }
                    }


                    $this->sendNotification('Course_Quiz_Added', $course->user, [
                        'time' => Carbon::now()->translatedFormat('d-M-Y, g:i A'),
                        'course' => $course->getTranslation('title', $course->user->language_code ?? config('app.fallback_locale')),
                        'chapter' => $chapter->name,
                        'quiz' => $quiz->title,
                    ]);


                    Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                    return redirect()->route('courseDetails', [$course->id]);
                }
                (new CourseSettingController())->updateTotalCountForCourse($course);

                Toastr::error(trans('frontend.Invalid Request'), trans('common.Failed'));
                return redirect()->route('courseDetails', [$course->id]);

            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
            }
        } else {
            try {
                $user = Auth::user();

                $course = Course::where('id', $request->course_id)->first();


                $chapter = Chapter::find($request->chapter_id);

                if (isset($course) && isset($chapter)) {

                    $lesson = new Lesson();
                    $lesson->course_id = $request->course_id;
                    $lesson->chapter_id = $request->chapter_id;
                    $lesson->name = $request->name;
                    $lesson->description = $request->description;

                    if (isModuleActive('Org') && $request->fileType != 2) {
                        $host = $request->file_type;
                        if ($host == "Video") {
                            $host = "Self";
                        }
                        $lesson->host = $host;
                        $lesson->video_url = $request->file_path;
                        $lesson->scorm_title = $request->scorm_title;
                        $lesson->scorm_version = $request->scorm_version;
                        $lesson->scorm_identifier = $request->scorm_identifier;

                    } else {
                        if ($request->get('host') == "Vimeo") {
                            if (config('vimeo.connections.main.upload_type') == "Direct") {
                                $vimeoController = new VimeoController();
                                $lesson->video_url = $vimeoController->uploadFileIntoVimeo(md5(time()), $request->vimeo);
                            } else {
                                $lesson->video_url = $request->vimeo;
                            }
                        } elseif ($request->get('host') == "Editor") {
                            $lesson->editor =$request->editor;
                        }

                        elseif ($request->get('host') == "BunnyStorage" && isModuleActive('BunnyStorage')) {
                            $settings = $this->getSettings();

                            $bunny_lesson_data = [
                                'library_id' => $settings['library_id'],
                                'region' => $settings['region'],
                                'zone_name' => $settings['zone_name'],
                                'access_key' => $settings['access_key'],
                                'service_type' => $settings['service'],
                                'upload_type' => $settings['upload_type'],
                                'common_use' => $settings['common_use'],
                                'token_authentication_key' => $settings['token_authentication_key'],
                                'hostname' => $settings['hostname'],
                            ];

                            if ($settings['service'] == 'stream') {
                                if (saasEnv('BUNNY_UPLOAD_TYPE') == "Direct") {
                                    $bunnyStreamController = new BunnyStreamController();
                                    $result = $bunnyStreamController->uploadFileToBunny($request->bunny);
                                    if ($result['status']) {
                                        $bunny_lesson_data['video_id'] = $result['path'];
                                        $time = Carbon::now()->addDay(1)->unix();
                                        $url = 'https://iframe.mediadelivery.net/embed/' . $settings['library_id'] . '/' . $result['path'];
                                        $sha256 = hash('sha256', $settings['token_authentication_key'] . $result['path'] . $time);
                                        $url .= "?token=" . $sha256 . '&expires=' . $time . '&autoplay=true&preload=true';
                                        $lesson->video_url = $url;
                                    } else {
                                        $lesson->video_url = null;
                                        Toastr::error($result['path']->getOriginalContent()['message']);
                                    }
                                } else {
                                    $time = Carbon::now()->addDay(1)->unix();
                                    $url = 'https://iframe.mediadelivery.net/embed/' . $settings['library_id'] . '/' . $request->bunny;
                                    $sha256 = hash('sha256', $settings['token_authentication_key'] . $request->bunny . $time);
                                    $url .= "?token=" . $sha256 . '&expires=' . $time . '&autoplay=true&preload=true';
                                    $lesson->video_url = $url;
                                    $bunny_lesson_data['video_id'] = $request->bunny;
                                }
                            }
                           elseif ($settings['service'] == 'storage') {
                                if (saasEnv('BUNNY_UPLOAD_TYPE') == "Direct") {
                                    $bunnyStreamController = new BunnyStreamController();
                                    $result = $bunnyStreamController->uploadFileToBunny($request->bunny);
                                    if ($result['status']) {
                                        $time = Carbon::now()->addDay(1)->unix();
                                        $path = "https://" . $settings['zone_name'] . ".b-cdn.net/" . $result['path'];
                                        $url = $bunnyStreamController->sign_bcdn_url($path, $settings['token_authentication_key'], $time);
                                        $lesson->video_url = $url;
                                        $bunny_lesson_data['name'] = $result['path'];
                                    } else {
                                        Toastr::error($result['path']->getOriginalContent()['message']);
                                    }
                                } else {
                                    $bunnyStreamController = new BunnyStreamController();
                                    $time = Carbon::now()->addDay(1)->unix();
                                    $path = "https://" . $settings['zone_name'] . ".b-cdn.net/" . $request->bunny;
                                    $url = $bunnyStreamController->sign_bcdn_url($path, $settings['token_authentication_key'], $time);
                                    $lesson->video_url = $url;
                                    $bunny_lesson_data['name'] = $request->bunny;
                                }
                            }

                        } elseif ($request->get('host') == "VdoCipher") {
                            $lesson->video_url = $request->vdocipher;
                        } elseif ($request->get('host') == "Youtube" || $request->get('host') == "URL"  || $request->get('host') == "m3u8") {
                            $lesson->video_url = $request->video_url;
                        } elseif ($request->get('host') == "Iframe") {
                            $lesson->video_url = $request->iframe_url;
                        } elseif ($request->get('host') == "Self") {

                            $file = $this->getPublicPathFromServerId($request->get('file'));
                            if (empty($file)) {
                                Toastr::error(trans('courses.File is not uploaded'), trans('common.Error'));
                                return redirect()->back();
                            }
                            $extension = pathinfo(base_path($file), PATHINFO_EXTENSION);
                            if (!in_array(strtolower($extension), ['mp4', 'webm', 'ogg'])) {
                                Toastr::error(trans('courses.Invalid Video file'), trans('common.Error'));
                                return redirect()->back();
                            }
                            $lesson->video_url = $file;
                        } elseif ($request->get('host') == "Storage") {
                            $lesson->video_url = null;
                            $lesson->save();

                            if ($request->video) {
                                $lesson->video_url = $this->generateLink($request->video, $lesson->id, get_class($lesson), 'video_url');
                                $lesson->save();
                            }
                        } elseif ($request->get('host') == "AmazonS3") {
                            $lesson->video_url = $this->getPublicPathFromServerId($request->get('file'), 's3');

                        } elseif ($request->get('host') == "BunnyStorage" && isModuleActive('BunnyStorage')) {
                            $settings = $this->getSettings();

                            $bunny_lesson_data = [
                                'library_id' => $settings['library_id'],
                                'region' => $settings['region'],
                                'zone_name' => $settings['zone_name'],
                                'access_key' => $settings['access_key'],
                                'service_type' => $settings['service'],
                                'upload_type' => $settings['upload_type'],
                                'common_use' => $settings['common_use'],
                                'token_authentication_key' => $settings['token_authentication_key'],
                                'hostname' => $settings['hostname'],
                            ];

                            if ($settings['service'] == 'stream') {
                                if (saasEnv('BUNNY_UPLOAD_TYPE') == "Direct") {
                                    $bunnyStreamController = new BunnyStreamController();
                                    $result = $bunnyStreamController->uploadFileToBunny($request->bunny);
                                    if ($result['status']) {
                                        $bunny_lesson_data['video_id'] = $result['path'];
                                        $time = Carbon::now()->addDay(1)->unix();
                                        $url = 'https://iframe.mediadelivery.net/embed/' . $settings['library_id'] . '/' . $result['path'];
                                        $sha256 = hash('sha256', $settings['token_authentication_key'] . $result['path'] . $time);
                                        $url .= "?token=" . $sha256 . '&expires=' . $time . '&autoplay=true&preload=true';
                                        $lesson->video_url = $url;
                                    } else {
                                        $lesson->video_url = null;
                                        Toastr::error($result['path']->getOriginalContent()['message']);
                                    }
                                } else {
                                    $time = Carbon::now()->addDay(1)->unix();
                                    $url = 'https://iframe.mediadelivery.net/embed/' . $settings['library_id'] . '/' . $request->bunny;
                                    $sha256 = hash('sha256', $settings['token_authentication_key'] . $request->bunny . $time);
                                    $url .= "?token=" . $sha256 . '&expires=' . $time . '&autoplay=true&preload=true';
                                    $lesson->video_url = $url;
                                    $bunny_lesson_data['video_id'] = $request->bunny;
                                }
                            } elseif ($settings['service'] == 'storage') {
                                if (saasEnv('BUNNY_UPLOAD_TYPE') == "Direct") {
                                    $bunnyStreamController = new BunnyStreamController();
                                    $result = $bunnyStreamController->uploadFileToBunny($request->bunny);
                                    if ($result['status']) {
                                        $time = Carbon::now()->addDay(1)->unix();
                                        $path = "https://" . $settings['zone_name'] . ".b-cdn.net/" . $result['path'];
                                        $url = $bunnyStreamController->sign_bcdn_url($path, $settings['token_authentication_key'], $time);
                                        $lesson->video_url = $url;
                                        $bunny_lesson_data['name'] = $result['path'];
                                    } else {
                                        Toastr::error($result['path']->getOriginalContent()['message']);
                                    }
                                } else {
                                    $bunnyStreamController = new BunnyStreamController();
                                    $time = Carbon::now()->addDay(1)->unix();
                                    $path = "https://" . $settings['zone_name'] . ".b-cdn.net/" . $request->bunny;
                                    $url = $bunnyStreamController->sign_bcdn_url($path, $settings['token_authentication_key'], $time);
                                    $lesson->video_url = $url;
                                    $bunny_lesson_data['name'] = $request->bunny;
                                }
                            }

                        } elseif ($request->get('host') == "VdoCipher") {
                            $vdoCipher = new VdoCipherController();
                            $lesson->video_url = $vdoCipher->uploadToVdoCipher($request->get('file'));

                        } elseif ($request->get('host') == "SCORM") {
                            $scorm = new SCORMController();
                            $serverFile = $this->getPublicPathWithFileNameFromServerId($request->get('file'));
                            if (empty($serverFile)) {
                                Toastr::error(trans('courses.File is invalid'), trans('common.Error'));
                                return redirect()->back();
                            }
                            $result = $scorm->getScormUrl($serverFile['link'], $request->get('host'));
                            if ($result) {
                                $lesson->video_url = $result['url'] ?? "";
                                $lesson->scorm_title = $result['title'] ?? '';
                                $lesson->scorm_version = $result['version'] ?? '';
                                $lesson->scorm_identifier = $result['identifier'] ?? '';
                            } else {
                                Toastr::error(trans('courses.Scorm field is invalid'), trans('common.Error'));
                                return redirect()->back();
                            }
                        } elseif ($request->get('host') == "SCORM-AwsS3") {
                            $scorm = new SCORMController();
                            $serverFile = $this->getPublicPathWithFileNameFromServerId($request->get('file'));
                            if (empty($serverFile)) {
                                Toastr::error(trans('courses.Scorm field is invalid'), trans('common.Error'));
                                return redirect()->back();
                            }
                            $result = $scorm->getScormUrl($serverFile['link'], $request->get('host'));
                            if ($result) {
                                $lesson->video_url = $result['url'] ?? '';
                                $lesson->scorm_title = $result['title'] ?? '';
                                $lesson->scorm_version = $result['version'] ?? '';
                                $lesson->scorm_identifier = $result['identifier'] ?? '';
                            } else {
                                Toastr::error(trans('courses.Scorm field is invalid'), trans('common.Error'));
                                return redirect()->back();
                            }
                        } elseif ($request->get('host') == "H5P") {
                            $h5p = new H5PController();
                            $serverFile = $this->getPublicPathWithFileNameFromServerId($request->get('file'));
                            if (empty($serverFile)) {
                                Toastr::error(trans('courses.H5P field is invalid'), trans('common.Error'));
                                return redirect()->back();
                            }
                            $result = $h5p->getH5PUrl($serverFile ? $serverFile['link'] : null, $request->get('host'), $request);
                            if ($result) {
                                $lesson->video_url = $result->path;
                                $lesson->h5p_id = $result->id;
                            } else {
                                Toastr::error(trans('courses.H5P field is invalid'), trans('common.Error'));
                                return redirect()->back();
                            }
                        } elseif ($request->get('host') == "XAPI") {
                            $xapi = new XAPIController();
                            $serverFile = $this->getPublicPathWithFileNameFromServerId($request->get('file'));
                            if (empty($serverFile)) {
                                Toastr::error(trans('courses.Scorm field is invalid'), trans('common.Error'));
                                return redirect()->back();
                            }
                            $result = $xapi->getXAPIUrl($serverFile['link'], $request->get('host'));
                            if ($result) {
                                $lesson->video_url = $result['url'];
                            } else {
                                Toastr::error(trans('courses.XAPI field is invalid'), trans('common.Error'));
                                return redirect()->back();
                            }
                        } elseif ($request->get('host') == "XAPI-AwsS3") {
                            $xapi = new XAPIController();
                            $serverFile = $this->getPublicPathWithFileNameFromServerId($request->get('file'));
                            if (empty($serverFile)) {
                                Toastr::error(trans('courses.Scorm field is invalid'), trans('common.Error'));
                                return redirect()->back();
                            }
                            $result = $xapi->getXAPIUrl($serverFile['link'], $request->get('host'));
                            if ($result) {
                                $lesson->video_url = $result['url'] ?? '';
                            } else {
                                Toastr::error(trans('courses.XAPI field is invalid'), trans('common.Error'));
                                return redirect()->back();
                            }
                        } elseif (
                            $request->get('host') == "Zip"
                            || $request->get('host') == "PowerPoint"
                            || $request->get('host') == "Excel"
                            || $request->get('host') == "Text"
                            || $request->get('host') == "Word"
                            || $request->get('host') == "PDF"
                            || $request->get('host') == "Image"
                        ) {
                            $file = $this->getPublicPathFromServerId($request->get('file'));
                            if (empty($file)) {
                                Toastr::error(trans('courses.File is not uploaded'), trans('common.Error'));
                                return redirect()->back();
                            }
                            $extension = pathinfo(base_path($file), PATHINFO_EXTENSION);
                            if ($request->get('host') == "Zip" && strtolower($extension) != 'zip') {
                                Toastr::error(trans('courses.Invalid Zip file'), trans('common.Error'));
                                return redirect()->back();
                            } elseif ($request->get('host') == "PowerPoint" && !in_array(strtolower($extension), ['ppt', 'pptx'])) {
                                Toastr::error(trans('courses.Invalid PowerPoint file'), trans('common.Error'));
                                return redirect()->back();
                            } elseif ($request->get('host') == "Excel" && !in_array(strtolower($extension), ['xlsx', 'xls'])) {
                                Toastr::error(trans('courses.Invalid Excel file'), trans('common.Error'));
                                return redirect()->back();
                            } elseif ($request->get('host') == "Text" && !in_array(strtolower($extension), ['txt'])) {
                                Toastr::error(trans('courses.Invalid Excel file'), trans('common.Error'));
                                return redirect()->back();
                            } elseif ($request->get('host') == "Word" && !in_array(strtolower($extension), ['doc', 'docx'])) {
                                Toastr::error(trans('courses.Invalid Word file'), trans('common.Error'));
                                return redirect()->back();
                            } elseif ($request->get('host') == "PDF" && !in_array(strtolower($extension), ['pdf'])) {
                                Toastr::error(trans('courses.Invalid PDF file'), trans('common.Error'));
                                return redirect()->back();
                            } elseif ($request->get('host') == "Image" && !in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'svg'])) {
                                Toastr::error(trans('courses.Invalid Image file'), trans('common.Error'));
                                return redirect()->back();
                            }

                            $lesson->video_url = $file;

                        } elseif ($request->get('host') == "GoogleDrive") {
                            if (empty(\auth()->user()->googleToken)) {
                                Toastr::error(trans('setting.Google Drive login is required'), trans('common.Error'));
                                return redirect()->back();
                            }
                            $id = null;
                            $url = $this->getPublicPathFromServerId($request->get('file'), 'local');
                            if ($url) {
                                $file = $this->storeFileInGDrive(base_path($url), null);
                                if (isset($file->id)) {
                                    $id = $file->id;
                                }
                                if (File::exists(base_path($url))) {
                                    File::delete(base_path($url));
                                }
                            }

                            $lesson->video_url = $id;

                        } else {
                            $lesson->video_url = null;
                        }
                        $lesson->host = $request->host;

                    }


                    if ($lesson->video_url != null && saasPlanCheck('upload_limit', $lesson->video_url)) {
                        Toastr::error(trans('frontend.You have reached upload limit'), trans('common.Failed'));
                        return redirect()->back();
                    }

                    $lesson->duration = $request->duration;
                    $lesson->is_lock = (int)$request->is_lock;
                    $lesson->save();


                    $bunny_lesson_data['lesson_id'] = $lesson->id;

                    if (isModuleActive('BunnyStorage') && isset($bunny_lesson_data)) {
                        BunnyLesson::create($bunny_lesson_data);
                    }

                    $ignoreHost = ['SCORM', 'SCORM-AwsS3', 'XAPI', 'XAPI-AwsS3'];
                    if (in_array($lesson->host, $ignoreHost)) {
                        $size = $serverFile['size'] ?? 0;
                    } elseif (!empty($lesson->video_url) && selfHosted($lesson->host)) {
                        $size = file_exists(base_path($lesson->video_url)) ? filesize($lesson->video_url) ?? 0 : 0;
                    } else {
                        $size = 0;
                    }
                    if (isModuleActive('Org')) {
                        $lesson->file_id = null;
                        $lesson->org_material_id = $this->getMaterialId($lesson->video_url);
                    } else {
                        $lesson->file_id = $this->addFile([
                            'lesson_id' => $lesson->id,
                            'title' => $lesson->name,
                            'link' => $lesson->video_url,
                            'version' => 1,
                            'size' => $size,
                            'type' => $lesson->host,
                            'scorm_title' => $lesson->scorm_title,
                            'scorm_version' => $lesson->scorm_version,
                            'scorm_identifier' => $lesson->scorm_identifier,
                        ]);
                    }

                    $lesson->save();


                    if (isset($course->enrollUsers) && !empty($course->enrollUsers)) {
                        foreach ($course->enrollUsers as $user) {

                            $this->sendNotification('Course_Lesson_Added', $user, [
                                'time' => Carbon::now()->translatedFormat('d-M-Y, g:i A'),
                                'course' => $course->getTranslation('title', $user->language_code ?? config('app.fallback_locale')),
                                'chapter' => $chapter->name,
                                'lesson' => $lesson->name,
                            ], [
                                'actionText' => trans('common.View'),
                                'actionUrl' => courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                            ]);

                        }
                    }

                    $this->sendNotification('Course_Lesson_Added', $course->user, [
                        'time' => Carbon::now()->translatedFormat('d-M-Y, g:i A'),
                        'course' => $course->getTranslation('title', $course->user->language_code ?? config('app.fallback_locale')),
                        'chapter' => $chapter->name,
                        'lesson' => $lesson->name,
                    ]);

                    (new CourseSettingController())->updateTotalCountForCourse($course);

                    Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                    return redirect()->route('courseDetails', [$course->id]);
                }

                Toastr::error(trans('frontend.Invalid Request'), trans('common.Failed'));
                return redirect()->route('courseDetails', [$course->id]);

            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
            }
        }

    }

    public function rules($request)
    {
        $rules = [];
        if ($request->input_type == 1) {
            $rules['chapter_name'] = 'required';
        } else if ($request->input_type == 2) {
            $rules['quiz'] = 'required';
            $rules['chapterId'] = 'required';
        } else {
            $rules['name'] = 'required';
            $rules['chapter_id'] = 'required';
            $rules['course_id'] = 'required';

            if (isModuleActive('Org') && $request->fileType != 2) {
                $rules['file_type'] = 'required';
                $rules['file_path'] = 'required';
            } else {
                if ($request->get('host') == "Vimeo") {
                    $rules['vimeo'] = 'required';
                } elseif ($request->get('host') == "VdoCipher") {
                    $rules['vdocipher'] = 'required';
                } elseif ($request->get('host') == "BunnyStorage") {
                    $rules['bunny'] = 'required';
                } elseif ($request->get('host') == "Iframe") {
                    $rules['iframe_url'] = 'required';
                } elseif ($request->get('host') == "Youtube" || $request->get('host') == "URL" || $request->get('host') == "m3u8") {
                    $rules['video_url'] = 'required';
                } elseif ($request->get('host') == "ImagePreview") {

                } elseif ($request->get('host') == "Storage") {
                    $rules['video'] = 'required';
                }elseif ($request->get('host') == "Editor") {
                    $rules['editor'] = 'required';
                } else {
                    $rules['file'] = 'required';
                }
            }
        }
        return $rules;
    }

    public function getMaterialId($link)
    {
        $id = null;
        if (isModuleActive('Org')) {
            $file = OrgMaterialFile::where('link', $link)->first();
            if ($file) {
                $id = $file->material_id;
            }
        }
        return $id;
    }

    public function addFile($data)
    {
        if (selfHosted($data['type'])) {
            $file = new LessonFile();
            $file->lesson_id = $data['lesson_id'];
            $file->link = $data['link'];
            $file->title = $data['title'];
            $file->version = $data['version'];
            $file->updated_by = Auth::id();
            $file->size = $data['size'] ?? '';
            $file->type = $data['type'];
            $file->scorm_title = $data['scorm_title'] ?? '';
            $file->scorm_version = $data['scorm_version'] ?? '';
            $file->scorm_identifier = $data['scorm_identifier'] ?? '';
            $file->save();
            return $file->id;
        } else {
            return null;
        }
    }

    public function deleteChapter($chapter, $course_id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $user = Auth::user();
            if ($user->role_id == 2) {
                $course = Course::where('id', $course_id)->where('user_id', Auth::id())->first();
            } else {
                $course = Course::where('id', $course_id)->first();
            }

            // return $course;
            if (isset($course)) {
                $lessons = Lesson::where('chapter_id', $chapter)->where('course_id', $course_id)->get();
                foreach ($lessons as $key => $lesson) {
                    $complete_lessons = LessonComplete::where('lesson_id', $lesson->id)->get();
                    foreach ($complete_lessons as $complete) {
                        $complete->delete();
                    }
                    $lessonController = new LessonController();
                    $lessonController->lessonFileDelete($lesson);
                    $lesson->delete();
                }

                $chapter = Chapter::find($chapter);
                $chapter->delete();
                (new CourseSettingController())->updateTotalCountForCourse($course);

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->route('courseDetails', [$course_id]);
            } else {
                Toastr::error(trans('frontend.Invalid Request'), trans('common.Failed'));
                return redirect()->route('courseDetails', [$course_id]);
            }
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function updateChapter(Request $request)
    {
        $rules = $this->rules($request);
        $this->validate($request, $rules, validationMessage($rules));

        if ($request->input_type == 1) {
            try {
                $user = Auth::user();
                $course = Course::where('id', $request->course_id)->first();


                // return $course;
                if (isset($course)) {
                    $chapter = Chapter::find($request->chapter);
                    $chapter->name = $request->chapter_name;
                    $chapter->save();
                    (new CourseSettingController())->updateTotalCountForCourse($course);

                    Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                    return redirect()->route('courseDetails', [$request->course_id]);
                } else {
                    Toastr::error('Invalid Access !', 'Failed');
                    return redirect()->route('courseDetails', [$request->course_id]);
                }
            } catch (Exception $e) {

                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
            }
        } else if ($request->input_type == 2) {
            try {
                $user = Auth::user();

                $course = Course::where('id', $request->course_id)->first();


                $chapter = Chapter::find($request->chapterId);

                if (isset($course) && isset($chapter)) {

                    $lesson = Lesson::find($request->lesson_id);
                    $lesson->course_id = $request->course_id;
                    $lesson->chapter_id = $request->chapterId;
                    $lesson->quiz_id = $request->quiz;
                    $lesson->is_quiz = $request->is_quiz;
                    $lesson->is_lock = (int)$request->lock;
                    $lesson->save();
                    (new CourseSettingController())->updateTotalCountForCourse($course);

                    Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                    return redirect()->route('courseDetails', [$request->course_id]);
                }

                Toastr::error(trans('frontend.Invalid Request'), trans('common.Failed'));
                return redirect()->route('courseDetails', [$request->course_id]);

            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
            }
        } else {
            try {

                $user = Auth::user();
                $course = Course::where('id', $request->course_id)->first();

                $chapter = Chapter::find($request->chapter_id);

                if (isset($course) && isset($chapter)) {
                    // $success = trans('lang.Lesson').' '.trans('lang.Added').' '.trans('lang.Successfully');

                    $lesson = Lesson::find($request->lesson_id);
                    $lesson->course_id = $request->course_id;
                    $lesson->chapter_id = $request->chapter_id;
                    $lesson->name = $request->name;
                    $lesson->description = $request->description;

                    if (isModuleActive('Org') && $request->fileType != 2) {
                        $host = $request->file_type;
                        if ($host == "Video") {
                            $host = "Self";
                        }
                        $lesson->host = $host;
                        $lesson->video_url = $request->file_path;
                        $lesson->scorm_title = $request->scorm_title;
                        $lesson->scorm_version = $request->scorm_version;
                        $lesson->scorm_identifier = $request->scorm_identifier;

                    } else {
                        $lesson->host = $request->host;
                        if ($request->get('host') == "Vimeo") {
                            if (config('vimeo.connections.main.upload_type') == "Direct") {
                                $vimeoController = new VimeoController();
                                $lesson->video_url = $vimeoController->uploadFileIntoVimeo(md5(time()), $request->vimeo);
                            } else {
                                $lesson->video_url = $request->vimeo;
                            }
                        } elseif ($request->get('host') == "Editor") {
                            $lesson->editor =$request->editor;
                        } elseif ($request->get('host') == "BunnyStorage" && isModuleActive('BunnyStorage')) {
                            $settings = $this->getSettings();

                            $bunny_lesson_data = [
                                'library_id' => $settings['library_id'],
                                'region' => $settings['region'],
                                'zone_name' => $settings['zone_name'],
                                'access_key' => $settings['access_key'],
                                'service_type' => $settings['service'],
                                'upload_type' => $settings['upload_type'],
                                'common_use' => $settings['common_use'],
                                'token_authentication_key' => $settings['token_authentication_key'],
                                'hostname' => $settings['hostname'],
                                'lesson_id' => $lesson->id,
                            ];

                            if ($settings['service'] == 'stream') {
                                if (saasEnv('BUNNY_UPLOAD_TYPE') == "Direct") {
                                    $bunnyStreamController = new BunnyStreamController();
                                    $result = $bunnyStreamController->uploadFileToBunny($request->bunny);
                                    if ($result['status']) {
                                        $bunny_lesson_data['video_id'] = $result['path'];
                                        $time = Carbon::now()->addDay(1)->unix();
                                        $url = 'https://iframe.mediadelivery.net/embed/' . $settings['library_id'] . '/' . $result['path'];
                                        $sha256 = hash('sha256', $settings['token_authentication_key'] . $result['path'] . $time);
                                        $url .= "?token=" . $sha256 . '&expires=' . $time . '&autoplay=true&preload=true';
                                        $lesson->video_url = $url;
                                    } else {
                                        $lesson->video_url = null;
                                        Toastr::error($result['path']->getOriginalContent()['message']);
                                    }
                                } else {
                                    $time = Carbon::now()->addDay(1)->unix();
                                    $url = 'https://iframe.mediadelivery.net/embed/' . $settings['library_id'] . '/' . $request->bunny;
                                    $sha256 = hash('sha256', $settings['token_authentication_key'] . $request->bunny . $time);
                                    $url .= "?token=" . $sha256 . '&expires=' . $time . '&autoplay=true&preload=true';
                                    $lesson->video_url = $url;
                                    $bunny_lesson_data['video_id'] = $request->bunny;
                                }
                            } elseif ($settings['service'] == 'storage') {
                                if (saasEnv('BUNNY_UPLOAD_TYPE') == "Direct") {
                                    $bunnyStreamController = new BunnyStreamController();
                                    $result = $bunnyStreamController->uploadFileToBunny($request->bunny);
                                    if ($result['status']) {
                                        $time = Carbon::now()->addDay(1)->unix();
                                        $path = "https://" . $settings['zone_name'] . ".b-cdn.net/" . $result['path'];
                                        $url = $bunnyStreamController->sign_bcdn_url($path, $settings['token_authentication_key'], $time);
                                        $lesson->video_url = $url;
                                        $bunny_lesson_data['name'] = $result['path'];
                                    } else {
                                        Toastr::error($result['path']->getOriginalContent()['message']);
                                    }
                                } else {
                                    $bunnyStreamController = new BunnyStreamController();
                                    $time = Carbon::now()->addDay(1)->unix();
                                    $path = "https://" . $settings['zone_name'] . ".b-cdn.net/" . $request->bunny;
                                    $url = $bunnyStreamController->sign_bcdn_url($path, $settings['token_authentication_key'], $time);
                                    $lesson->video_url = $url;
                                    $bunny_lesson_data['name'] = $request->bunny;
                                }
                            }

                            $exist_bunny = BunnyLesson::where('lesson_id', $lesson->id)->first();
                            if ($exist_bunny) {
                                $exist_bunny->update($bunny_lesson_data);
                            } else {
                                BunnyLesson::create($bunny_lesson_data);
                            }

                        } elseif ($request->get('host') == "VdoCipher") {
                            $lesson->video_url = $request->vdocipher;
                        } elseif ($request->get('host') == "Youtube" || $request->get('host') == "URL"  || $request->get('host') == "m3u8") {
                            $lesson->video_url = $request->video_url;
                        } elseif ($request->get('host') == "Iframe") {
                            $lesson->video_url = $request->iframe_url;
                        } elseif ($request->get('host') == "Self") {

                            $file = $this->getPublicPathFromServerId($request->get('file'));
                            if (empty($file)) {
                                Toastr::error(trans('courses.File is not uploaded'), trans('common.Error'));
                                return redirect()->back();
                            }
                            $extension = pathinfo(base_path($file), PATHINFO_EXTENSION);

                            if (!in_array(strtolower($extension), ['mp4', 'webm', 'ogg'])) {
                                Toastr::error(trans('courses.Invalid Video file'), trans('common.Error'));
                                return redirect()->back();
                            }
                            $lesson->video_url = $file;

                        } elseif ($request->get('host') == "Storage") {
                            $lesson->video_url = null;
                            $lesson->save();
                            $this->removeLink($lesson->id, get_class($lesson));

                            if ($request->video) {
                                $lesson->video_url = $this->generateLink($request->video, $lesson->id, get_class($lesson), 'video_url');
                                $lesson->save();
                            }
                        } elseif ($request->get('host') == "AmazonS3") {
                            if (!empty($request->get('file'))) {
                                $lesson->video_url = $this->getPublicPathFromServerId($request->get('file'), 's3');
                            }

                        } elseif ($request->get('host') == "SCORM") {
                            if (!empty($request->get('file'))) {
                                $serverFile = $this->getPublicPathWithFileNameFromServerId($request->get('file'), 'local');

                                $scorm = new SCORMController();
                                $result = $scorm->getScormUrl($serverFile['link'], $request->get('host'));
                                if ($result) {
                                    $lesson->video_url = $result['url'];
                                    $lesson->scorm_title = $result['title'];
                                    $lesson->scorm_version = $result['version'];
                                    $lesson->scorm_identifier = $result['identifier'];
                                } else {
                                    Toastr::error(trans('courses.Scorm field is invalid'), trans('common.Error'));
                                    return redirect()->back();
                                }
                            }
                        } elseif ($request->get('host') == "SCORM-AwsS3") {
                            if (!empty($request->get('file'))) {
                                $scorm = new SCORMController();
                                $serverFile = $this->getPublicPathWithFileNameFromServerId($request->get('file'));
                                $result = $scorm->getScormUrl($serverFile['link'], $request->get('host'));

                                if ($result) {
                                    $lesson->video_url = $result['url'];
                                    $lesson->scorm_title = $result['title'];
                                    $lesson->scorm_version = $result['version'];
                                    $lesson->scorm_identifier = $result['identifier'];
                                } else {
                                    Toastr::error(trans('courses.Scorm field is invalid'), trans('common.Error'));
                                    return redirect()->back();
                                }
                            }
                        } elseif ($request->get('host') == "H5P") {
                            $h5p = new H5PController();
                            $serverFile = $this->getPublicPathWithFileNameFromServerId($request->get('file'));
                            $result = $h5p->getH5PUrl($serverFile ? $serverFile['link'] : null, $request->get('host'), $request);

                            if ($result) {
                                $lesson->video_url = $result->path;
                                $lesson->h5p_id = $result->id;
                            } else {
                                Toastr::error(trans('courses.H5P field is invalid'), trans('common.Error'));
                                return redirect()->back();
                            }
                        } elseif ($request->get('host') == "XAPI") {
                            $xapi = new XAPIController();
                            $serverFile = $this->getPublicPathWithFileNameFromServerId($request->get('file'));
                            $result = $xapi->getXAPIUrl($serverFile['link'], $request->get('host'));
                            if ($result) {
                                $lesson->video_url = $result['url'];
                            } else {
                                Toastr::error(trans('courses.XAPI field is invalid'), trans('common.Error'));
                                return redirect()->back();
                            }
                        } elseif ($request->get('host') == "XAPI-AwsS3") {
                            $xapi = new XAPIController();
                            $serverFile = $this->getPublicPathWithFileNameFromServerId($request->get('file'));
                            $result = $xapi->getXAPIUrl($serverFile['link'], $request->get('host'));
                            if ($result) {
                                $lesson->video_url = $result['url'];
                            } else {
                                Toastr::error(trans('courses.XAPI field is invalid'), trans('common.Error'));
                                return redirect()->back();
                            }
                        } elseif (
                            $request->get('host') == "Zip"
                            || $request->get('host') == "PowerPoint"
                            || $request->get('host') == "Excel"
                            || $request->get('host') == "Text"
                            || $request->get('host') == "Word"
                            || $request->get('host') == "PDF"
                            || $request->get('host') == "Image"
                        ) {
                            $file = $this->getPublicPathFromServerId($request->get('file'));

                            if ($file) {
                                $extension = pathinfo(base_path($file), PATHINFO_EXTENSION);
                                if ($request->get('host') == "Zip" && strtolower($extension) != 'zip') {
                                    Toastr::error(trans('courses.Invalid Zip file'), trans('common.Error'));
                                    return redirect()->back();
                                } elseif ($request->get('host') == "PowerPoint" && !in_array(strtolower($extension), ['ppt', 'pptx'])) {
                                    Toastr::error(trans('courses.Invalid PowerPoint file'), trans('common.Error'));
                                    return redirect()->back();
                                } elseif ($request->get('host') == "Excel" && !in_array(strtolower($extension), ['xlsx', 'xls'])) {
                                    Toastr::error(trans('courses.Invalid Excel file'), trans('common.Error'));
                                    return redirect()->back();
                                } elseif ($request->get('host') == "Text" && !in_array(strtolower($extension), ['txt'])) {
                                    Toastr::error(trans('courses.Invalid Excel file'), trans('common.Error'));
                                    return redirect()->back();
                                } elseif ($request->get('host') == "Word" && !in_array(strtolower($extension), ['doc', 'docx'])) {
                                    Toastr::error(trans('courses.Invalid Word file'), trans('common.Error'));
                                    return redirect()->back();
                                } elseif ($request->get('host') == "PDF" && !in_array(strtolower($extension), ['pdf'])) {
                                    Toastr::error(trans('courses.Invalid PDF file'), trans('common.Error'));
                                    return redirect()->back();
                                } elseif ($request->get('host') == "Image" && !in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'svg'])) {
                                    Toastr::error(trans('courses.Invalid Image file'), trans('common.Error'));
                                    return redirect()->back();
                                }

                                $lesson->video_url = $file;
                            }


                        } elseif ($request->get('host') == "GoogleDrive") {
                            if (empty(\auth()->user()->googleToken)) {
                                Toastr::error(trans('setting.Google Drive login is required'), trans('common.Error'));
                                return redirect()->back();
                            }
                            $id = null;
                            $url = $this->getPublicPathFromServerId($request->get('file'), 'local');
                            if ($url) {
                                $file = $this->storeFileInGDrive(base_path($url));
                                if (isset($file->id)) {
                                    $id = $file->id;
                                }
                                if (File::exists(base_path($url))) {
                                    File::delete(base_path($url));
                                }
                            }

                            $lesson->video_url = $id;

                        } else {
                            $lesson->video_url = null;
                        }
                    }
                    $ignoreHost = ['SCORM', 'SCORM-AwsS3', 'XAPI', 'XAPI-AwsS3'];
                    if (in_array($lesson->host, $ignoreHost)) {
                        $size = $serverFile['size'] ?? 0;
                    } elseif (!empty($lesson->video_url) && selfHosted($lesson->host)) {
                        $size = file_exists(base_path($lesson->video_url)) ? filesize($lesson->video_url) ?? 0 : 0;
                    } else {
                        $size = 0;
                    }
                    if (isModuleActive('Org')) {
                        $lesson->file_id = null;
                        $lesson->org_material_id = $this->getMaterialId($lesson->video_url);
                    } else {
                        $lesson->file_id = $this->addFile([
                            'lesson_id' => $lesson->id,
                            'link' => $lesson->video_url,
                            'title' => $lesson->name,
                            'version' => count($lesson->files) + 1,
                            'size' => $size,
                            'type' => $lesson->host,
                            'scorm_title' => $lesson->scorm_title,
                            'scorm_version' => $lesson->scorm_version,
                            'scorm_identifier' => $lesson->scorm_identifier,
                        ]);
                    }


                    $lesson->duration = $request->duration;
                    $lesson->is_lock = (int)$request->is_lock;
                    $lesson->update();

                    $self_hosts = ['Self', 'Image', 'PDF', 'Word', 'Excel', 'Text', 'Zip', 'PowerPoint'];
                    if (in_array($lesson->host, $self_hosts)) {
                        $filesize = file_exists(base_path($lesson->video_url)) ? filesize($lesson->video_url) ?? 0 : 0;
                        $filesize = round($filesize / 1024, 2); //KB
                        if (isModuleActive('LmsSaas')) {
                            if (in_array($lesson->host, $self_hosts)) {
                                saasPlanManagement('upload_limit', 'create', $filesize);
                            }
                            if (in_array($lesson->host, $self_hosts) && $lesson->old_file_size != null) {
                                saasPlanManagement('upload_limit', 'delete', $lesson->old_file_size);
                            }
                        }

                        $lesson->old_file_size = $filesize;
                        $lesson->file_size = $filesize;
                        $lesson->update();
                    }


                    (new CourseSettingController())->updateTotalCountForCourse($course);

                    Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                    return redirect()->route('courseDetails', [$request->course_id]);
                }

                Toastr::error(trans('frontend.Invalid Request'), trans('common.Failed'));
                return redirect()->route('courseDetails', [$request->course_id]);

            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
            }
        }

    }

    public function editChapter($id, $course_id)
    {

        try {
            $courseSetting = new CourseSettingController();
            $video_list = [];
            $vdocipher_list = [];
            $editChapter = Chapter::where('id', $id)->first();
            $course = Course::find($course_id);
            $chapters = Chapter::where('course_id', $course_id)->with('lessons')->get();
            $categories = Category::get();
            $instructors = User::where('role_id', 2)->get();
            $languages = Language::get();
            $quizzes = OnlineQuiz::where('category_id', $course->category_id)->get();
            $course_exercises = CourseExercise::where('course_id', $course_id)->get();
            $levels = CourseLevel::where('status', 1)->get();
            // return $course;
            return view('coursesetting::course_details', compact('vdocipher_list', 'levels', 'course', 'chapters', 'categories', 'instructors', 'languages', 'course_exercises', 'editChapter', 'quizzes', 'video_list'));

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function saveFile(Request $request)
    {

        Session::flash('type', 'files');

        $rules = [
            'file' => 'required',
            'fileName' => 'required',

        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {

            $course_file = new CourseExercise();
            $course_file->course_id = $request->id;
            $course_file->file = '';

            if (saasPlanCheck('upload_limit', $course_file->file)) {
                Toastr::error(trans('frontend.You have reached upload limit'), trans('common.Failed'));
                return redirect()->back();
            }

            $course_file->lock = (int)$request->lock;
            $course_file->fileName = $request->fileName;
            $course_file->status = (int)$request->status;
            $course_file->save();

            $course_file->file = $this->generateLink($request->file, $course_file->id, get_class($course_file), 'file');
             $course_file->save();


            $course = Course::find($request->id);
            if (isset($course->enrollUsers) && !empty($course->enrollUsers)) {
                foreach ($course->enrollUsers as $user) {

                    $this->sendNotification('Course_ExerciseFile_Added', $user, [
                        'time' => Carbon::now()->translatedFormat('d-M-Y ,g:i A'),
                        'course' => $course->getTranslation('title', $user->language_code ?? config('app.fallback_locale')),
                        'filename' => $course_file->fileName,
                    ]);


                }
            }
            $this->sendNotification('Course_ExerciseFile_Added', $course->user, [
                'time' => Carbon::now()->translatedFormat('d-M-Y ,g:i A'),
                'course' => $course->getTranslation('title', $course->user->language_code ?? config('app.fallback_locale')),
                'filename' => $course_file->fileName,
            ]);
            (new CourseSettingController())->updateTotalCountForCourse($course);

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function updateFile(Request $request)
    {
        Session::flash('type', 'files');


        try {

            $course_file = CourseExercise::find($request->id);
            $course_file->file = null;
            $course_file->save();
            $this->removeLink($course_file->id, get_class($course_file));

            $filesize = 0;
            if ($request->get('file') != "") {
                $course_file->file = $this->generateLink($request->file, $course_file->id, get_class($course_file), 'file');


                $filesize = file_exists(base_path($course_file->file)) ? filesize($course_file->file) ?? 0 : 0;
                // $filesize = round($filesize / 1024 / 1024, 1); //MB
                $filesize = round($filesize / 1024, 2); //KB
                if (saasPlanCheck('upload_limit', $filesize)) {
                    Toastr::error(trans('frontend.You have reached upload limit'), trans('common.Failed'));
                    return redirect()->back();
                }
                if (isModuleActive('LmsSaas')) {
                    saasPlanManagement('upload_limit', 'create', $filesize);
                    if ($course_file->old_file_size != null) {
                        saasPlanManagement('upload_limit', 'delete', $course_file->old_file_size);
                    }
                }
            }

            $course_file->old_file_size = $filesize;
            $course_file->file_size = $filesize;

            $course_file->lock = (int)$request->lock;
            $course_file->fileName = $request->fileName;
            $course_file->status = (int)$request->status;
            $course_file->save();
            $course = Course::find($course_file->course_id);
            if ($course) {
                if (isset($course->enrollUsers) && !empty($course->enrollUsers)) {

                    foreach ($course->enrollUsers as $user) {
                        $this->sendNotification('Course_ExerciseFile_Added', $user, [
                            'time' => Carbon::now()->translatedFormat('d-M-Y ,g:i A'),
                            'course' => $course->getTranslation('title', $user->language_code ?? config('app.fallback_locale')),
                            'filename' => $course_file->fileName,
                        ]);

                    }
                }
            }
            (new CourseSettingController())->updateTotalCountForCourse($course);

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function deleteFile(Request $request)
    {
        Session::flash('type', 'files');
        try {
            $course_file = CourseExercise::find($request->id);
            if (file_exists($course_file->file)) {
                unlink($course_file->file);
            }
            $course_file->delete();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function download_course_file($id)
    {
        try {
            $course_file = CourseExercise::find($id);
            // return base_path();
            $file_path = base_path('/' . $course_file->file);
            return response()->download($file_path);
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function addSyncFile($data)
    {
        return null;

        $file_id = null;
        $link = $data['link'] ?? '';
        $material = OrgMaterial::where('link', $link)->first();
        if ($material) {
            $files = $material->files;
            foreach ($files as $f) {
                $file = new LessonFile();
                $file->lesson_id = $data['lesson_id'];
                $file->link = $f->link;
                $file->title = $f->title;
                $file->version = $f->version;
                $file->updated_by = $f->updated_by;
                $file->size = $f->size;
                $file->type = $f->type;
                $file->scorm_title = $f->scorm_title;
                $file->scorm_version = $f->scorm_version;
                $file->scorm_identifier = $f->scorm_identifier;
                $file->save();

                if ($file->link == $link) {
                    $file_id = $file->id;
                }
            }
        }

        return $file_id;
    }

    public function restore($id)
    {
        $file = LessonFile::findOrFail($id);
        $lesson = $file->lesson;
        $lesson->file_id = $file->id;
        $lesson->host = $file->type;
        $lesson->scorm_title = $file->scorm_title;
        $lesson->scorm_version = $file->scorm_version;
        $lesson->scorm_identifier = $file->scorm_identifier;
        $lesson->save();

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function fileDelete(Request $request)
    {
        $file = LessonFile::findOrfail($request->id);

        if ($file->type == 'SCORM' || $file->type == 'XAPI') {
            $path = explode('/', $file->link);

            if (isset($path[4])) {
                $this->delete_directory(base_path('/public/uploads/scorm/' . $path[4]));
            }
        } else {
            if (File::exists(base_path($file->link))) {
                File::delete(base_path($file->link));
            }
        }
        $file->delete();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function updateFileAjax($id)
    {
        $edit = CourseExercise::findOrfail($id);
        return view('coursesetting::edit_file_modal', compact('edit'));
    }
}
