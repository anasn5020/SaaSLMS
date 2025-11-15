<?php

namespace App\Repositories\Eloquents;

use Vimeo\Vimeo;
use Carbon\Carbon;
use App\Traits\Gdrive;
use App\Traits\Filepond;
use App\Traits\UploadMedia;
use App\Traits\BunnySettings;
use App\Jobs\SendGeneralEmail;
use App\Traits\SendNotification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Lesson;
use Modules\CourseSetting\Entities\Chapter;
use Illuminate\Validation\ValidationException;
use Modules\BunnyStorage\Entities\BunnyLesson;
use Modules\CourseSetting\Entities\LessonFile;
use Modules\H5P\Http\Controllers\H5PController;
use Modules\Assignment\Entities\InfixAssignment;
use Modules\XAPI\Http\Controllers\XAPIController;
use Modules\BunnyStorage\Service\BunnyEdgeStorage;
use Modules\BunnyStorage\Service\BunnyVideoStream;
use Modules\SCORM\Http\Controllers\SCORMController;
use App\Http\Resources\api\v2\Lesson\LessonListResource;
use Modules\Setting\Repositories\MediaManagerRepository;
use App\Repositories\Interfaces\LessonRepositoryInterface;
use Modules\CourseSetting\Http\Controllers\VimeoController;
use Modules\VdoCipher\Http\Controllers\VdoCipherController;
use Modules\BunnyStorage\Http\Controllers\BunnyStreamController;
use Modules\CourseSetting\Http\Controllers\CourseSettingController;

class LessonRepository implements LessonRepositoryInterface
{
    use Filepond, UploadMedia, BunnySettings, Gdrive, SendNotification;

    private $mediaManagerRepository;
    public function __construct(MediaManagerRepository $mediaManagerRepository)
    {
        $this->mediaManagerRepository = $mediaManagerRepository;
    }

    public function addLesson(object $request): bool|object
    {
        $user = auth()->user();

        if ($user->role_id == 2) {
            $course = Course::where('id', $request->course_id)->where('user_id', auth()->id())->first();
        } else {
            $course = Course::where('id', $request->course_id)->first();
        }

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
                }

                /* elseif ($request->get('host') == "BunnyStorage" && isModuleActive('BunnyStorage')) {
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
                               throw ValidationException::withMessages(['message' => $result['path']->getOriginalContent()['message']]);
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
                               throw ValidationException::withMessages(['message' => $result['path']->getOriginalContent()['message']]);
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
               } */

                elseif ($request->get('host') == "VdoCipher") {
                    $lesson->video_url = $request->vdocipher;
                }
                elseif ($request->get('host') == "Youtube" || $request->get('host') == "URL"  || $request->get('host') == "m3u8") {
                    $lesson->video_url = $request->video_url;
                } elseif ($request->get('host') == "Iframe") {
                    $lesson->video_url = $request->iframe_url;
                } elseif ($request->get('host') == "Self") {
                    $file = $this->getPublicPathFromServerId($request->get('file'));
                    if (empty($file)) {
                        throw ValidationException::withMessages(['message' => trans('courses.File is not uploaded')]);
                    }
                    $extension = pathinfo(base_path($file), PATHINFO_EXTENSION);
                    if (!in_array(strtolower($extension), ['mp4', 'webm', 'ogg'])) {
                        throw ValidationException::withMessages(['message' => trans('courses.Invalid Video file')]);
                    }
                    $lesson->video_url = $file;
                } elseif ($request->get('host') == "Storage") {
                    $lesson->video_url = null;
                    $lesson->save();

                    if ($request->video) {
                        $video = $this->mediaManagerRepository->store($request->video);
                        $lesson->video_url = $this->generateLink($video->id, $lesson->id, get_class($lesson), 'video_url');
                        $lesson->save();
                    }
                } elseif ($request->get('host') == "AmazonS3") {
                    $lesson->video_url = $this->filePathUrl($request->file('file'), 's3');
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
                            if($request->file('bunny')){
                                $result = $bunnyStreamController->uploadFileToBunny($request->bunny);
                            }else{
                                $result['status'] = true;
                                $result['path'] = $request->bunny;
                            }
                            if ($result['status']) {
                                $bunny_lesson_data['video_id'] = $result['path'];
                                $time = Carbon::now()->addDay(1)->unix();
                                $url = 'https://iframe.mediadelivery.net/embed/' . $settings['library_id'] . '/' . $result['path'];
                                $sha256 = hash('sha256', $settings['token_authentication_key'] . $result['path'] . $time);
                                $url .= "?token=" . $sha256 . '&expires=' . $time . '&autoplay=true&preload=true';
                                $lesson->video_url = $url;
                            } else {
                                $lesson->video_url = null;
                                throw ValidationException::withMessages(['message' => $result['path']->getOriginalContent()['message']]);
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
                                throw ValidationException::withMessages(['message' => $result['path']->getOriginalContent()['message']]);
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
                }
                /* elseif ($request->get('host') == "VdoCipher") {
                    $vdoCipher = new VdoCipherController();
                    $lesson->video_url = $vdoCipher->uploadToVdoCipher($request->get('file'));
                } */
                elseif ($request->get('host') == "SCORM") {
                    $scorm = new SCORMController();
                    $serverFile = $this->filePathUrl($request->file('file'));
                    if (empty($serverFile)) {
                        throw ValidationException::withMessages(['message' => trans('courses.File is invalid')]);
                    }
                    $result = $scorm->getScormUrl($serverFile['link'], $request->get('host'));
                    if ($result) {
                        $lesson->video_url = $result['url'] ?? "";
                        $lesson->scorm_title = $result['title'] ?? '';
                        $lesson->scorm_version = $result['version'] ?? '';
                        $lesson->scorm_identifier = $result['identifier'] ?? '';
                    } else {
                        throw ValidationException::withMessages(['message' => trans('courses.Scorm field is invalid')]);
                    }
                } elseif ($request->get('host') == "SCORM-AwsS3") {
                    $scorm = new SCORMController();
                    $serverFile = $this->filePathUrl($request->file('file'));
                    if (empty($serverFile)) {
                        throw ValidationException::withMessages(['message' => trans('courses.Scorm field is invalid')]);
                    }
                    $result = $scorm->getScormUrl($serverFile['link'], $request->get('host'));
                    if ($result) {
                        $lesson->video_url = $result['url'] ?? '';
                        $lesson->scorm_title = $result['title'] ?? '';
                        $lesson->scorm_version = $result['version'] ?? '';
                        $lesson->scorm_identifier = $result['identifier'] ?? '';
                    } else {
                        throw ValidationException::withMessages(['message' => trans('courses.Scorm field is invalid')]);
                    }
                } elseif ($request->get('host') == "H5P") {
                    $h5p = new H5PController();
                    $serverFile = $this->filePathUrl($request->file('file'));
                    if (empty($serverFile)) {
                        throw ValidationException::withMessages(['message' => trans('courses.H5P field is invalid')]);
                    }
                    $result = $h5p->getH5PUrl($serverFile ? $serverFile['link'] : null, $request->get('host'), $request);
                    if ($result) {
                        $lesson->video_url = $result->path;
                        $lesson->h5p_id = $result->id;
                    } else {
                        throw ValidationException::withMessages(['message' => trans('courses.H5P field is invalid')]);
                    }
                } elseif ($request->get('host') == "XAPI") {
                    $xapi = new XAPIController();
                    $serverFile = $this->filePathUrl($request->file('file'));
                    if (empty($serverFile)) {
                        throw ValidationException::withMessages(['message' => trans('courses.Scorm field is invalid')]);
                    }
                    $result = $xapi->getXAPIUrl($serverFile['link'], $request->get('host'));
                    if ($result) {
                        $lesson->video_url = $result['url'];
                    } else {
                        throw ValidationException::withMessages(['message' => trans('courses.XAPI field is invalid')]);
                    }
                } elseif ($request->get('host') == "XAPI-AwsS3") {
                    $xapi = new XAPIController();
                    $serverFile = $this->filePathUrl($request->file('file'));
                    if (empty($serverFile)) {
                        throw ValidationException::withMessages(['message' => trans('courses.Scorm field is invalid')]);
                    }
                    $result = $xapi->getXAPIUrl($serverFile['link'], $request->get('host'));
                    if ($result) {
                        $lesson->video_url = $result['url'] ?? '';
                    } else {
                        throw ValidationException::withMessages(['message' => trans('courses.XAPI field is invalid')]);
                    }
                } elseif (in_array($request->get('host'), ['Zip', 'PowerPoint', 'Excel', 'Text', 'Word', 'PDF', 'Image'])) {
                    $file = $this->getPublicPathFromServerId($request->get('file'));
                    if (empty($file)) {
                        throw ValidationException::withMessages(['message' => trans('courses.File is not uploaded')]);
                    }
                    $extension = pathinfo(base_path($file), PATHINFO_EXTENSION);
                    if ($request->get('host') == "Zip" && strtolower($extension) != 'zip') {
                        throw ValidationException::withMessages(['message' => trans('courses.Invalid Zip file')]);
                    } elseif ($request->get('host') == "PowerPoint" && !in_array(strtolower($extension), ['ppt', 'pptx'])) {
                        throw ValidationException::withMessages(['message' => trans('courses.Invalid PowerPoint file')]);
                    } elseif ($request->get('host') == "Excel" && !in_array(strtolower($extension), ['xlsx', 'xls'])) {
                        throw ValidationException::withMessages(['message' => trans('courses.Invalid Excel file')]);
                    } elseif ($request->get('host') == "Text" && !in_array(strtolower($extension), ['txt'])) {
                        throw ValidationException::withMessages(['message' => trans('courses.Invalid Excel file')]);
                    } elseif ($request->get('host') == "Word" && !in_array(strtolower($extension), ['doc', 'docx'])) {
                        throw ValidationException::withMessages(['message' => trans('courses.Invalid Word file')]);
                    } elseif ($request->get('host') == "PDF" && !in_array(strtolower($extension), ['pdf'])) {
                        throw ValidationException::withMessages(['message' => trans('courses.Invalid PDF file')]);
                    } elseif ($request->get('host') == "Image" && !in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'svg'])) {
                        throw ValidationException::withMessages(['message' => trans('courses.Invalid Image file')]);
                    }

                    $lesson->video_url = $file;
                } elseif ($request->get('host') == "GoogleDrive") {
                    if (empty(auth()->user()->googleToken)) {
                        throw ValidationException::withMessages(['message' => trans('setting.Google Drive login is required')]);
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
                $lesson->host = $request->host;
            }

            if ($lesson->video_url != null && saasPlanCheck('upload_limit', $lesson->video_url)) {
                throw ValidationException::withMessages(['message' => trans('frontend.You have reached upload limit')]);
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

            try {
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
                ], [
                    'actionText' => trans('common.View'),
                    'actionUrl' => courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                ]);
            } catch (\Exception) {
            }
            (new CourseSettingController)->updateTotalCountForCourse($course);
            return true;
        } else {
            return false;
        }
    }

    public function lessons(object $request): object
    {
        $lessons = Lesson::where('course_id', $request->course_id)
            ->when($request->chapter_id, function ($lesson) use ($request) {
                $lesson->where('chapter_id', $request->chapter_id);
            })
            ->when($request->quiz_id, function ($lesson) use ($request) {
                $lesson->where('quiz_id', $request->quiz_id);
            })->get();

        return LessonListResource::collection($lessons);
    }

    public function lessonDetail(object $request): object
    {
        $lesson = Lesson::where('is_quiz', 0)
            ->where('is_assignment', 0)
            ->where('course_id', $request->course_id)
            ->where('chapter_id', $request->chapter_id)
            ->find($request->lesson_id);

        return new LessonListResource($lesson);
    }

    public function hosts(): array
    {
        $hosts = [
            'Youtube'       => 'Youtube',
            'Vimeo'         => 'Vimeo',
            'VdoCipher'     => 'VdoCipher',
            'Self'          => 'Self',
            'URL'           => 'Video URL',
            'Iframe'        => 'Iframe embed',
            'Image'         => 'Image',
            'PDF'           => 'PDF File',
            'Word'          => 'Word File',
            'Excel'         => 'Excel File',
            'Text'          => 'Text File',
            'Zip'           => 'Zip File',
            'GoogleDrive'   => 'Google Drive',
            'PowerPoint'    => 'Power Point File',
        ];

        if(isModuleActive('SCORM')){
            $hosts['SCORM'] ='SCORM Self';
        }
        if(isModuleActive('BunnyStorage')){
            $hosts['BunnyStorage'] ='Bunny Storage';
        }
        if(isModuleActive('h5p')){
            $hosts['h5p'] ='H5P';
        }
        if(isModuleActive('XAPI')){
            $hosts['XAPI'] ='XAPI Self';
        }

        // return [
        //     'Storage'       => 'Storage',
        // ];
        return $hosts;
    }

    public function privacies(): object
    {
        $privacies = [
            [
                'key'   => 0,
                'name'  => 'Unlock',
            ],
            [
                'key'   => 1,
                'name'  => 'Locked'
            ]
        ];

        $response = [
            'success'   => true,
            'data'      => $privacies,
            'message'   => trans('api.Operation successful')
        ];

        return response()->json($response);
    }

    public function updateLesson(object $request): object
    {
        $user = auth()->user();
        if ($user->role_id == 2) {
            $course = Course::where('user_id', auth()->id())->find($request->course_id);
        } else {
            $course = Course::find($request->course_id);
        }
        $chapter = Chapter::where('course_id', $course->id)->find($request->chapter_id);

        if (isset($course) && isset($chapter)) {
            $lesson = Lesson::find($request->lesson_id);
            $lesson->course_id = $request->course_id;
            $lesson->chapter_id = $request->chapter_id;
            $lesson->name = $request->name;
            $lesson->description = $request->description;
            $lesson->host = $request->host;
            if ($request->get('host') == "Vimeo") {
                if (config('vimeo.connections.main.upload_type') == "Direct") {
                    $vimeoController = new VimeoController();
                    $lesson->video_url = $vimeoController->uploadFileIntoVimeo(md5(time()), $request->vimeo);
                } else {
                    $lesson->video_url = $request->vimeo;
                }
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
                        if($request->file('bunny')){
                            $result = $bunnyStreamController->uploadFileToBunny($request->bunny);
                        }else{
                            $result['status'] = true;
                            $result['path'] = $request->bunny;
                        }
                        if ($result['status']) {
                            $bunny_lesson_data['video_id'] = $result['path'];
                            $time = Carbon::now()->addDay(1)->unix();
                            $url = 'https://iframe.mediadelivery.net/embed/' . $settings['library_id'] . '/' . $result['path'];
                            $sha256 = hash('sha256', $settings['token_authentication_key'] . $result['path'] . $time);
                            $url .= "?token=" . $sha256 . '&expires=' . $time . '&autoplay=true&preload=true';
                            $lesson->video_url = $url;
                        } else {
                            $lesson->video_url = null;
                            // Toastr::error($result['path']->getOriginalContent()['message']);
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
            } elseif ($request->get('host') == "Youtube" || $request->get('host') == "URL") {
                $lesson->video_url = $request->video_url;
            } elseif ($request->get('host') == "Iframe") {
                $lesson->video_url = $request->iframe_url;
            } elseif ($request->get('host') == "Self") {
                $file = $this->getPublicPathFromServerId($request->get('file'));
                if (empty($file)) {
                    return response()->json(['message' => trans('courses.File is not uploaded')]);
                }
                $extension = pathinfo(base_path($file), PATHINFO_EXTENSION);

                if (!in_array(strtolower($extension), ['mp4', 'webm', 'ogg'])) {
                    return response()->json(['message' => trans('courses.Invalid Video file')]);
                }
                $lesson->video_url = $file;
            } elseif ($request->get('host') == "Storage") {
                $lesson->video_url = null;
                $lesson->save();
                $this->removeLink($lesson->id, get_class($lesson));

                if ($request->video) {
                    $video = $this->mediaManagerRepository->store($request->video);
                    $lesson->video_url = $this->generateLink($video->id, $lesson->id, get_class($lesson), 'video_url');
                    $lesson->save();
                }
            } elseif ($request->get('host') == "AmazonS3") {
                if (!empty($request->get('file'))) {
                    $lesson->video_url = $this->filePathUrl($request->file('file'), 's3');
                }
            } elseif ($request->get('host') == "SCORM") {
                if (!empty($request->get('file'))) {
                    $serverFile = $this->filePathUrl($request->file('file'));

                    $scorm = new SCORMController();
                    $result = $scorm->getScormUrl($serverFile['link'], $request->get('host'));
                    if ($result) {
                        $lesson->video_url = $result['url'];
                        $lesson->scorm_title = $result['title'];
                        $lesson->scorm_version = $result['version'];
                        $lesson->scorm_identifier = $result['identifier'];
                    } else {
                        return response()->json(['message' => trans('courses.Scorm field is invalid')]);
                    }
                }
            } elseif ($request->get('host') == "SCORM-AwsS3") {
                if (!empty($request->get('file'))) {
                    $scorm = new SCORMController();
                    $serverFile = $this->filePathUrl($request->file('file'));
                    $result = $scorm->getScormUrl($serverFile['link'], $request->get('host'));

                    if ($result) {
                        $lesson->video_url = $result['url'];
                        $lesson->scorm_title = $result['title'];
                        $lesson->scorm_version = $result['version'];
                        $lesson->scorm_identifier = $result['identifier'];
                    } else {
                        return response()->json(['message' => trans('courses.Scorm field is invalid')]);
                    }
                }
            } elseif ($request->get('host') == "H5P") {
                $h5p = new H5PController();
                $serverFile = $this->filePathUrl($request->file('file'));
                $result = $h5p->getH5PUrl($serverFile ? $serverFile['link'] : null, $request->get('host'), $request);

                if ($result) {
                    $lesson->video_url = $result->path;
                    $lesson->h5p_id = $result->id;
                } else {
                    return response()->json(['message' => trans('courses.H5P field is invalid')]);
                }
            } elseif ($request->get('host') == "XAPI") {
                $xapi = new XAPIController();
                $serverFile = $this->filePathUrl($request->file('file'));
                $result = $xapi->getXAPIUrl($serverFile['link'], $request->get('host'));
                if ($result) {
                    $lesson->video_url = $result['url'];
                } else {
                    return response()->json(['message' => trans('courses.XAPI field is invalid')]);
                }
            } elseif ($request->get('host') == "XAPI-AwsS3") {
                $xapi = new XAPIController();
                $serverFile = $this->filePathUrl($request->file('file'));
                $result = $xapi->getXAPIUrl($serverFile['link'], $request->get('host'));
                if ($result) {
                    $lesson->video_url = $result['url'];
                } else {
                    return response()->json(['message' => trans('courses.XAPI field is invalid')]);
                }
            } elseif (in_array($request->get('host'), ['Zip', 'PowerPoint', 'Excel', 'Text', 'Word', 'PDF', 'Image'])) {
                $file = $this->getPublicPathFromServerId($request->get('file'));

                if ($file) {
                    $extension = pathinfo(base_path($file), PATHINFO_EXTENSION);
                    if ($request->get('host') == "Zip" && strtolower($extension) != 'zip') {
                        return response()->json(['message' => trans('courses.Invalid Zip file')]);
                    } elseif ($request->get('host') == "PowerPoint" && !in_array(strtolower($extension), ['ppt', 'pptx'])) {
                        return response()->json(['message' => trans('courses.Invalid PowerPoint file')]);
                    } elseif ($request->get('host') == "Excel" && !in_array(strtolower($extension), ['xlsx', 'xls'])) {
                        return response()->json(['message' => trans('courses.Invalid Excel file')]);
                    } elseif ($request->get('host') == "Text" && !in_array(strtolower($extension), ['txt'])) {
                        return response()->json(['message' => trans('courses.Invalid Excel file')]);
                    } elseif ($request->get('host') == "Word" && !in_array(strtolower($extension), ['doc', 'docx'])) {
                        return response()->json(['message' => trans('courses.Invalid Word file')]);
                    } elseif ($request->get('host') == "PDF" && !in_array(strtolower($extension), ['pdf'])) {
                        return response()->json(['message' => trans('courses.Invalid PDF file')]);
                    } elseif ($request->get('host') == "Image" && !in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'svg'])) {
                        return response()->json(['message' => trans('courses.Invalid Image file')]);
                    }

                    $lesson->video_url = $file;
                }
            } elseif ($request->get('host') == "GoogleDrive") {
                if (empty(auth()->user()->googleToken)) {
                    // Toastr::error(trans('setting.Google Drive login is required'), trans('common.Error'));
                    return response()->json(['message' => trans('setting.Google Drive login is required')]);
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
            $ignoreHost = ['SCORM', 'SCORM-AwsS3', 'XAPI', 'XAPI-AwsS3'];
            if (in_array($lesson->host, $ignoreHost)) {
                $size = $serverFile['size'] ?? 0;
            } elseif (!empty($lesson->video_url) && selfHosted($lesson->host)) {
                $size = file_exists(base_path($lesson->video_url)) ? filesize($lesson->video_url) ?? 0 : 0;
            } else {
                $size = 0;
            }
            /* if (isModuleActive('Org')) {
                $lesson->file_id = null;
                $lesson->org_material_id = $this->getMaterialId($lesson->video_url);
            } else {
            } */
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
        }
        return response()->json(true);
    }

    public function deleteLesson(object $request): bool
    {
        $lesson = Lesson::where('course_id', $request->course_id)->where('chapter_id', $request->chapter_id)->find($request->lesson_id);

        if (auth()->user()->role_id == 2) {
            $course = Course::where('user_id', auth()->id())->find($lesson->course_id);
        } else {
            $course = Course::find($lesson->course_id);
        }

        if (isset($course)) {
            if ($lesson->is_assignment == 1) {
                $assignment = InfixAssignment::where('course_id', $course->id)->find($lesson->assignment_id);
                $assignment->delete();
            }
            $this->lessonFileDelete($lesson);

            if (isModuleActive('BunnyStorage')) {
                if ($lesson->bunnyLesson) {
                    $lesson->bunnyLesson->delete();
                }
            }
            $lesson->delete();
            return true;
        } else {
            return false;
        }
    }

    public function vimeoVideos(object $request): array
    {
        $video_list = [];
        if (empty($this->configVimeo())) {
            return $video_list;
        }
        if ($request->page) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        if ($request->search) {
            $search = $request->search;
        } else {
            $search = '';
        }
        $vimeo_video_list = $this->getVideoFromVimeoApi($page, $search);

        if (isset($vimeo_video_list['body']['data'])) {
            if (count($vimeo_video_list['body']['data']) != 0) {
                foreach ($vimeo_video_list['body']['data'] as $data) {
                    $video_list[] = $data;
                }
            }
        }


        $response = [];
        foreach ($video_list as $item) {
            $response[] = [
                'id' => $item['uri'],
                'text' => $item['name'],
            ];
        }
        // $output['results'] = $response;
        // $output['pagination'] = ["more" => count($response) != 0];

        return $response;
    }

    public function getAllVdocipherData(object $request): array
    {
        $curl = curl_init();

        $header = array(
            "Accept: application/json",
            "Authorization:Apisecret " . saasEnv('VDOCIPHER_API_SECRET'),
            "Content-Type: application/json"
        );
        if ($request->page) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        if ($request->search) {
            $search = $request->search;
        } else {
            $search = '';
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://dev.vdocipher.com/api/videos?page=" . $page . "&limit=20&q=" . $search,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            return [];
        } else {
            $items = json_decode($response)->rows;
            $response = [];
            foreach ($items as $item) {
                $response[] = [
                    'id' => $item->id,
                    'text' => $item->title
                ];
            }
            // $data['results'] = $response;
            // $data['pagination'] = ["more" => count($response) != 0 ? true : false];
            return $response;
        }
    }

    public function getBunnyVideos(object $request): array
    {
        try {
            $settings = $this->getSettings();
            $processResponse = [];
            if ($settings['service'] == 'stream') {
                $bunnyVideoStream = new BunnyVideoStream();
                $response = $bunnyVideoStream->listVideo($request->search, (int)$request->page);
                if ($response['status']) {
                    foreach ($response['data'] as $row) {
                        $processResponse[] = [
                            'id' => $row['guid'],
                            'text' => $row['title']
                        ];
                    }
                }
            } elseif ($settings['service'] == 'storage') {
                $bunnyVideoStream = new BunnyEdgeStorage();
                $response = $bunnyVideoStream->listFiles();
                if ($response['status'] && (int)$request->page == 1) {
                    foreach ($response['data'] as $row) {
                        $processResponse[] = [
                            'id' => $row['ObjectName'],
                            'text' => $row['ObjectName']
                        ];
                    }
                } else {
                    $processResponse = [];
                }
            }
            return $processResponse;
        } catch (\Throwable $th) {
            return $processResponse = [];
        }
    }


    private function lessonFileDelete($lesson): bool
    {
        try {
            $host = $lesson->host;
            if ($host == "SCORM") {
                $index = $lesson->video_url;
                if (!empty($index)) {
                    $new_path = str_replace("/public/uploads/scorm/", "", $index);
                    $folder = explode('/', $new_path)[0] ?? '';
                    $delete_dir = public_path() . "/uploads/scorm/" . $folder;

                    if (File::isDirectory($delete_dir)) {
                        File::deleteDirectory($delete_dir);
                    }
                }
            } elseif (in_array($host, ['Self', 'Image', 'PDF', 'Word', 'Excel', 'PowerPoint', 'Text', 'Zip'])) {
                $file = File::exists($lesson->video_url);

                if ($file) {
                    File::delete($lesson->video_url);
                }
            }
        } catch (\Exception $e) {
        }
        return true;
    }

    private function addFile($data): int
    {
        if (selfHosted($data['type'])) {
            $file = new LessonFile();
            $file->lesson_id = $data['lesson_id'];
            $file->link = $data['link'];
            $file->title = $data['title'];
            $file->version = $data['version'];
            $file->updated_by = auth()->id();
            $file->size = $data['size'] ?? '';
            $file->type = $data['type'];
            $file->scorm_title = $data['scorm_title'] ?? '';
            $file->scorm_version = $data['scorm_version'] ?? '';
            $file->scorm_identifier = $data['scorm_identifier'] ?? '';
            $file->save();
            return (int)$file->id;
        } else {
            return 0;
        }
    }

    private function configVimeo()
    {
        if (config('vimeo.connections.main.common_use')) {
            $vimeo_client = saasEnv('VIMEO_CLIENT');
            $vimeo_secret = saasEnv('VIMEO_SECRET');
            $vimeo_access = saasEnv('VIMEO_ACCESS');
        } else {
            $vimeos = Cache::rememberForever('vimeoSetting_' . SaasDomain(), function () {
                return \Modules\VimeoSetting\Entities\Vimeo::all();
            });
            $vimeo = $vimeos->where('created_by', auth()->user()->id)->first();
            if ($vimeo) {
                $vimeo_client = $vimeo->vimeo_client;
                $vimeo_secret = $vimeo->vimeo_secret;
                $vimeo_access = $vimeo->vimeo_access;
            }
        }
        if (empty($vimeo_secret) || empty($vimeo_client)) {
            return null;
        }
        $lib = new  Vimeo($vimeo_client, $vimeo_secret);
        $lib->setToken($vimeo_access);
        return $lib;
    }

    private function getVideoFromVimeoApi($page = 1, $search = null)
    {
        try {
            if (config('vimeo.connections.main.upload_type') == "Direct") {
                return [];
            }
            if ($this->configVimeo()) {
                return $this->configVimeo()->request('/me/videos', [
                    'per_page' => 10,
                    'page' => $page,
                    'query' => $search
                ], 'GET');
            } else {
                return [];
            }
        } catch (\Exception $e) {
            return [];
        }
    }

    private function getMaterialId($link)
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

    private function filePathUrl($file, $driver = 'local')
    {
        $result['name'] = '';
        $result['link'] = '';
        $path = '';

        if (isset($file)) {
            $ext = $file->getClientOriginalExtension();
            if (!$this->isFileAllow($ext)) {
                return null;
            }
            $result['name'] = pathinfo($file, PATHINFO_FILENAME);
            $current_date = Carbon::now()->format('d-m-Y');
            $finalLocation = 'public/uploads/file/' . $current_date;
            if (!File::isDirectory($finalLocation)) {
                File::makeDirectory($finalLocation, 0777, true, true);
            }

            $file_name = md5(uniqid()) . '.' . $ext;
            $link = $new_file = $finalLocation . '/' . $file_name;
            $result['size'] = 0;
            if ($driver == 'local') {
                File::move($file, $new_file);
                $result['size'] = File::size(base_path($link)) ?? 0;
            } elseif ($driver == 's3') {
                Storage::disk('s3')->put($new_file, file_get_contents($file), 'public');
                $link = Storage::disk('s3')->url($new_file);
            }

            File::deleteDirectory($path);

            $result['extension'] = $ext;
            $result['link'] = $link;

            if ($ext == 'php') {
                return null;
            }

            return $result;
        } else {
            return null;
        }
    }

    private function filePathLink($file, $driver = 'local')
    {
        $path = '';
        if (isset($file)) {
            $ext = $file->getClientOriginalExtension();
            if (!$this->isFileAllow($ext)) {
                return null;
            }
            $current_date = Carbon::now()->format('d-m-Y');
            $finalLocation = 'public/uploads/file/' . $current_date;
            if (!File::isDirectory($finalLocation)) {
                File::makeDirectory($finalLocation, 0777, true, true);
            }

            $file_name = md5(uniqid()) . '.' . $ext;
            $link = $new_file = $finalLocation . '/' . $file_name;

            if ($driver == 'local') {
                File::move($file, $new_file);
            } elseif ($driver == 's3') {
                Storage::disk('s3')->put($new_file, file_get_contents($file), 'public');
                $link = Storage::disk('s3')->url($new_file);
            }

            File::deleteDirectory($path);
            return $link;
        } else {
            return null;
        }
    }
}
