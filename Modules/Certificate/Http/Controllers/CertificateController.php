<?php

namespace Modules\Certificate\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\UploadMedia;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
//use Intervention\Image\Drivers\Imagick\Driver; //change driver
use Intervention\Image\ImageManager;
use Modules\Certificate\Entities\Certificate;
use Modules\Certificate\Entities\CertificateFont;
use Modules\Certificate\Entities\CertificateRecord;
use Modules\CertificatePro\Entities\CertificateTemplate;
use Modules\CourseSetting\Entities\Course;
use Modules\Setting\Model\DateFormat;
use QrCode;
use Spondonit\Arabic\I18N_Arabic;


class CertificateController extends Controller
{
    use UploadMedia;

    public $manager;
    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());

    }

    public function clone($id)
    {

        try {
            // Find the original row you want to clone
            $originalRow = Certificate::find($id);

            // Create a new instance of the model and copy attributes
            $clonedRow = new Certificate($originalRow->attributesToArray());

            // Duplicate the image file
            $originalPath = $clonedRow->image;
            if ($originalPath) {
                $pathInfo = pathinfo($originalPath);
                $newImagePath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . Str::random(10) . '.' . $pathInfo['extension'];
                File::copy($originalPath, $newImagePath);
                $clonedRow->image = $newImagePath;
            }


            // Duplicate the signature file
            $originalSignaturePath = $clonedRow->signature;
            if ($originalSignaturePath) {
                $pathInfoSignature = pathinfo($originalSignaturePath);
                $newSignaturePath = $pathInfoSignature['dirname'] . '/' . $pathInfoSignature['filename'] . Str::random(10) . '.' . $pathInfoSignature['extension'];
                File::copy($originalSignaturePath, $newSignaturePath);
                $clonedRow->signature = $newSignaturePath;
            }

            //change attribute
//            $clonedRow->title = $clonedRow->titie.' clone' ;

            // Save the cloned row
            $clonedRow->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('certificate.index');

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function index()
    {
        $certificates = Certificate::query();
        if (Auth::user()->role_id == 2) {
            $certificates->where('created_by', Auth::id());
        }
        $certificates= $certificates->latest()->get();


        return view('certificate::certificate.index', compact('certificates'));
    }

    public function allfonts()
    {
        $fonts = CertificateFont::all();
        return view('certificate::fonts.index', compact('fonts'));
    }

    public function saveFont(Request $request)
    {


        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'title' => 'required',
            'name' => 'required',
            'font' => 'required',

        ];
        $this->validate($request, $rules, validationMessage($rules));


        $newFont = new CertificateFont();
        $newFont->title = $request->title;
        $newFont->name = $request->name;
        $newFont->rtl = (int)$request->rtl;
        $newFont->save();

        if ($request->font) {
            $newFont->font = $this->generateLink($request->font, $newFont->id, get_class($newFont), 'font');
        }


        $newFont->save();

        File::copy($newFont->font, public_path('fonts') . '/' . $request->name . '.ttf');
        Toastr::success(trans('certificate.Certificate Font Saved Successfully'), trans('common.Success'));
        return redirect()->back();
    }

    public function deleteFont(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'id' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        $font = CertificateFont::findOrFail($request->id);
        $font->delete();
        Toastr::success(trans('certificate.Certificate Font Delete Successfully'), trans('common.Success'));
        return redirect()->back();


    }

    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $rules = [
            'image' => 'required'

        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {

            $data = $request->except(['image', 'signature', '_token', 'certificate_id', 'makeURL', 'uploadURL', 'bgImageInput', 'sigImageInput']);
            foreach ($data as $key => $item) {
                if ((strpos($key, '_x') || strpos($key, '_y')) && empty($item)) {
                    $data[$key] = 0;
                } elseif ($key == 'qr' && empty($item)) {
                    $data[$key] = 0;
                } elseif ($key == 'date' && empty($item)) {
                    $data[$key] = 0;
                } elseif ($key == 'profile' && empty($item)) {
                    $data[$key] = 0;
                } elseif ($key == 'show_title' && empty($item)) {
                    $data[$key] = 0;
                }elseif ($key == 'name' && empty($item)) {
                    $data[$key] = 0;
                }
            }
            $certificate = Certificate::create($data);


            if ($request->file('signature') != "") {
                $name = md5($request->title . time()) . '.' . 'png';
                $img = $this->manager->read($request->signature);
                $upload_path = 'public/uploads/certificate/';
                $img->save($upload_path . $name);
                $certificate->signature = 'public/uploads/certificate/' . $name;
            }
            if ($request->file('image') != "") {
                $name = md5($request->title . rand(0, 1000)) . '.' . 'png';
                $img = $this->manager->read($request->image);
                $upload_path = 'public/uploads/certificate/';
                $img->save($upload_path . $name);
                $certificate->image = 'public/uploads/certificate/' . $name;
            }

            $certificate->created_by = Auth::id();
            if (isModuleActive('CPD') || isModuleActive('Membership')) {
                $certificate->type = $request->type;
            }

            $certificate->save();
            Toastr::success(trans('certificate.Certificate Saved Successfully'), trans('common.Success'));

            return redirect()->route('certificate.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function create()
    {
        $font_list = $this->fonts();
        $formats = DateFormat::all();
        return view('certificate::certificate.index', compact('font_list', 'formats'));

    }

    public function fonts()
    {
        $fonts = CertificateFont::all();

        $font_list = [];
        if (count($fonts) == 0) {
            $font_list = [
                'nunito' => 'Nunito',
                'vazir' => 'Vazir',
                'arabic' => 'Arabic',
            ];
        } else {
            foreach ($fonts as $font) {
                $font_list[$font->name] = $font->title;
            }
        }
        return $font_list;
    }

    public function edit($id)
    {
        $font_list = $this->fonts();
        $certificate = Certificate::findOrFail($id);
        $formats = DateFormat::all();
//        if (isModuleActive('CPD')) {
//            if ($certificate->type) {
//                return view('cpd::certificate.index', compact('certificate', 'font_list', 'formats'));
//            }
//        }
        return view('certificate::certificate.index', compact('certificate', 'font_list', 'formats'));
    }

    public function destroy($id)
    {
        if (demoCheckById($id,[1,2,3])) {
            return redirect()->back();
        }
        try {
            Certificate::destroy($id);
            Toastr::success(trans('certificate.Certificate Deleted Successfully'), trans('common.Success'));
            return back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function courseCertificate($id)
    {
        try {

            Certificate::where('for_course', 1)->update(['for_course' => 0]);

            $certificate = Certificate::find($id);
            $certificate->for_course = 1;
            $certificate->for_quiz = 0;
            $certificate->for_class = 0;
            $certificate->save();
            Toastr::success(trans('certificate.Certificate for Course Selected Successfully'), trans('common.Success'));
            return back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function update(Request $request, $id)
    {
        // return $request;
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $certificate = Certificate::findOrFail($id);
            $data = $request->except(['image', 'signature', '_token', 'certificate_id', 'makeURL', 'uploadURL', 'bgImageInput', 'sigImageInput']);

            foreach ($data as $key => $item) {
                if ((strpos($key, '_x') || strpos($key, '_y')) && empty($item)) {
                    $data[$key] = 0;
                } elseif ($key == 'qr' && empty($item)) {
                    $data[$key] = 0;
                } elseif ($key == 'date' && empty($item)) {
                    $data[$key] = 0;
                } elseif ($key == 'profile' && empty($item)) {
                    $data[$key] = 0;
                } elseif ($key == 'show_title' && empty($item)) {
                    $data[$key] = 0;
                }
            }

            $certificate->fill($data);

            if ($request->file('image') != "") {
                $name = md5($request->title . time()) . '.' . 'png';
                $img = $this->manager->read($request->image);
                $upload_path = 'public/uploads/certificate/';
                $img->save($upload_path . $name);
                $certificate->image = 'public/uploads/certificate/' . $name;
            }
            if ($request->file('signature') != "") {
                $name = md5($request->title . time()) . '.' . 'png';
                $img = $this->manager->read($request->signature);
                $upload_path = 'public/uploads/certificate/';
                $img->save($upload_path . $name);
                $certificate->signature = 'public/uploads/certificate/' . $name;
            }
            if (isModuleActive('CPD') || isModuleActive('Membership')) {
                $certificate->type = $request->type;
            }
            $certificate->save();

            Toastr::success(trans('certificate.Certificate Update Successfully'), trans('common.Success'));
            if (isModuleActive('CPD') && $request->filled('cpd')) {
                return redirect()->route('cpd.certificate');
            }
            return redirect()->route('certificate.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function quizCertificate($id)
    {
        try {
            $certificate = Certificate::find($id);

            $certificate->for_quiz = 1;
            $certificate->for_course = 0;
            $certificate->for_class = 0;
            $certificate->save();
            Toastr::success(trans('certificate.Certificate for Quiz Selected Successfully'), trans('common.Success'));
            return back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function classCertificate($id)
    {
        try {
            Certificate::where('for_class', 1)->update(['for_class' => 0]);
            $certificate = Certificate::find($id);
            $certificate->for_quiz = 0;
            $certificate->for_course = 0;
            $certificate->for_class = 1;
            $certificate->save();
            Toastr::success(trans('certificate.Certificate for Live Class Selected Successfully'), trans('common.Success'));
            return back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function getVariants(Request $request)
    {
        $font_family = $request->font;
        $url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAdtrr9rVkPASrFJCfmeOmV3ZLtpsk-BaU";
        $result = json_decode(file_get_contents($url));
        $output = '';
        foreach ($result->items as $font) {
            if ($font->family == $font_family) {
                $variants = $font->variants;
                $files = [];
                foreach ($font->files as $key => $file)
                    $files[] = $file;
                foreach ($variants as $key => $variant) {
                    if (is_numeric($variant) || $variant == 'regular')
                        $output .= '<option value="' . $variant . '">' . $variant . '</option>';
                }
            }
        }
        return $output;
    }

    public function view($id, Request $request)
    {
         try {
            $certificate = $this->makeCertificate($id, $request)['image'] ?? '';
             return response($certificate->toPng())
                 ->header('Content-Type', 'image/png');

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }


    }

    public function makeCertificate($id, Request $request)
    {

        try {
            if (!empty($id)) {
                $certificate = Certificate::find($id);
            }

            if (!empty($request->bgImage)) {
                $bg_image = $request->bgImage;
            } elseif ($id) {
                $bg_image = $certificate->image ?? '';
            } else {
                $bg_image = '';
            }


            if (!empty($request->sigImageInput)) {
                $sig_image = $request->sigImageInput;
            } elseif ($id) {
                $sig_image = $certificate->signature ?? '';
            } else {
                $sig_image = '';
            }
            $width = 1300;
            $height = 910;
            if (!empty($request->bgImage) || $id) {
                $bg_image_url = asset($bg_image);
                try {
                    $width = getimagesize($bg_image_url)[0];
                    $height = getimagesize($bg_image_url)[1];
                } catch (Exception $exception) {

                }
            }

            $img = $this->manager->create($width, $height);
            if (!empty($bg_image)) {
                $bgImageRow = $this->manager->read($bg_image);
                $bgImageRow->resize($width, $height);
                $img->place($bgImageRow, 'center', 0, 0);
            }

            if (!empty($request->title)) {
                $title = $request->title;
            } elseif (!empty($id)) {
                $title = $certificate->title ?? '';
            } else {
                $title = 'Certificate Title';
            }

            if (!empty($request->certificate_number_prefix)) {
                $certificate_number_prefix = $request->certificate_number_prefix;
            } elseif (!empty($id)) {
                $certificate_number_prefix = $certificate->certificate_number_prefix ?? '';
            } else {
                $certificate_number_prefix = '';
            }

            if (!empty($request->certificate_id)) {
                $certificate_id = $request->certificate_id;
            } else {
                $certificate_id = trans('certificate.Dynamic ID');
            }

            if (isset($request->show_title)) {
                $show_title = (int)$request->show_title;
            } elseif (!empty($id)) {
                $show_title = (int) $certificate->show_title ?? 0;
            } else {
                $show_title = 1;
            }


            if (!empty($request->title_position_x)) {
                $title_position_x = $request->title_position_x;
            } elseif (!empty($id)) {
                $title_position_x = $certificate->title_position_x ?? '';
            } else {
                $title_position_x = 0;
            }


            if (!empty($request->title_position_y)) {
                $title_position_y = $request->title_position_y;
            } elseif (!empty($id)) {
                $title_position_y = $certificate->title_position_y ?? '';
            } else {
                $title_position_y = 0;
            }


            if (!empty($request->title_font_color)) {
                $title_font_color = $request->title_font_color;
            } elseif (!empty($id)) {
                $title_font_color = $certificate->title_font_color ?? '#000';
            } else {
                $title_font_color = '#000';
            }


            if (!empty($request->title_font_size)) {
                $title_font_size = $request->title_font_size;
            } elseif (!empty($id)) {
                $title_font_size = $certificate->title_font_size ?? 30;
            } else {
                $title_font_size = 30;
            }

            if (!empty($request->title_font_family)) {
                $title_font_family = $request->title_font_family;
            } elseif (!empty($id)) {
                $title_font_family = $certificate->title_font_family ?? 'nunito';
            } else {
                $title_font_family = 'nunito';
            }


            if ($this->isRtl($title_font_family)) {
                $title = $this->mb_strrev($title);
            }
            //body part style start form here
            if (!empty($request->body)) {
                $body = $request->body;
            } elseif (!empty($id)) {
                if (isset($request->user) & isset($request->course)) {
                    $body = $certificate->body;
                    $body = str_replace("[name]", $request->user->name, $body);
                    $body = str_replace("[course]", $request->course->title, $body);
                    $body = str_replace("[instructor]", $request->course->user->name, $body);
                } else {
                    $body = $certificate->body ?? '';
                }

            } else {

                $body = '';
            }

            if (!empty($request->body_position_x)) {
                $body_position_x = $request->body_position_x;
            } elseif (!empty($id)) {
                $body_position_x = $certificate->body_position_x ?? 0;
            } else {
                $body_position_x = 0;
            }

            if (!empty($request->body_position_y)) {
                $body_position_y = $request->body_position_y;
            } elseif (!empty($id)) {
                $body_position_y = $certificate->body_position_y ?? 0;
            } else {
                $body_position_y = 0;
            }

            if (!empty($request->body_font_family)) {
                $body_font_family = $request->body_font_family;
            } elseif (!empty($id)) {
                $body_font_family = $certificate->body_font_family ?? 'nunito';
            } else {
                $body_font_family = 'nunito';
            }
            if ($this->isRtl($body_font_family)) {
                $body = $this->mb_strrev($body);
            }

            if (!empty($request->body_max_len)) {
                $body_max_len = $request->body_max_len;
            } elseif (!empty($id)) {
                $body_max_len = $certificate->body_max_len ?? 80;
            } else {
                $body_max_len = 80;
            }

            if (!empty($request->body_font_size)) {
                $body_font_size = $request->body_font_size;
            } elseif (!empty($id)) {
                $body_font_size = $certificate->body_font_size ?? 25;
            } else {
                $body_font_size = 25;
            }

            if (!empty($request->body_font_color)) {
                $body_font_color = $request->body_font_color;
            } elseif (!empty($id)) {
                $body_font_color = $certificate->body_font_color ?? '#000';
            } else {
                $body_font_color = '#000';
            }


            if (isset($request->profile)) {
                $profile = $request->profile;
            } elseif (!empty($id)) {
                $profile = $certificate->profile ?? 0;
            } else {
                $profile = 0;
            }

            if (!empty($request->profile_x)) {
                $profile_x = $request->profile_x;
            } elseif (!empty($id)) {
                $profile_x = $certificate->profile_x ?? 0;
            } else {
                $profile_x = 0;
            }


            if (!empty($request->profile_y)) {
                $profile_y = $request->profile_y;
            } elseif (!empty($id)) {
                $profile_y = $certificate->profile_y ?? 0;
            } else {
                $profile_y = 0;
            }


            if (!empty($request->profile_height)) {
                $profile_height = $request->profile_height;
            } elseif (!empty($id)) {
                $profile_height = $certificate->profile_height ?? 50;
            } else {
                $profile_height = 50;
            }


            if (!empty($request->profile_weight)) {
                $profile_weight = $request->profile_weight;
            } elseif (!empty($id)) {
                $profile_weight = $certificate->profile_weight ?? 50;
            } else {
                $profile_weight = 50;
            }


            //        qr start
            if (isset($request->qr)) {
                $qr = $request->qr;
            } elseif (!empty($id)) {
                $qr = $certificate->qr ?? 0;
            } else {
                $qr = 0;
            }

            if (!empty($request->qr_x)) {
                $qr_x = $request->qr_x;
            } elseif (!empty($id)) {
                $qr_x = $certificate->qr_x ?? 0;
            } else {
                $qr_x = 0;
            }


            if (!empty($request->qr_y)) {
                $qr_y = $request->qr_y;
            } elseif (!empty($id)) {
                $qr_y = $certificate->qr_y ?? 0;
            } else {
                $qr_y = 0;
            }


            if (!empty($request->qr_height)) {
                $qr_height = $request->qr_height;
            } elseif (!empty($id)) {
                $qr_height = $certificate->qr_height ?? 50;
            } else {
                $qr_height = 50;
            }


            if (!empty($request->qr_weight)) {
                $qr_weight = $request->qr_weight;
            } elseif (!empty($id)) {
                $qr_weight = $certificate->qr_weight ?? 50;
            } else {
                $qr_weight = 50;
            }
            //        qr end


            $studentName = 'Student Name';
            if (isset($request->name)) {
                $name = $request->name;
            } elseif (isset($certificate->name)) {
                if (isset($request->user) & isset($request->course)) {
                    $studentName = $request->user->name;
                }
                $name = $certificate->name;
            } else {
                $name = 1;
            }


            if (!empty($request->name_position_x)) {
                $name_position_x = $request->name_position_x;
            } elseif (!empty($id)) {
                $name_position_x = $certificate->name_position_x ?? 0;
            } else {
                $name_position_x = 0;
            }

            if (!empty($request->name_position_y)) {
                $name_position_y = $request->name_position_y;
            } elseif (!empty($id)) {
                $name_position_y = $certificate->name_position_y ?? 0;
            } else {
                $name_position_y = 0;
            }

            if (!empty($request->name_font_family)) {
                $name_font_family = $request->name_font_family;
            } elseif (!empty($id)) {
                $name_font_family = $certificate->name_font_family ?? 'nunito';
            } else {
                $name_font_family = 'nunito';
            }
            if ($this->isRtl($name_font_family)) {
                $name = $this->mb_strrev($name);
            }

            if (!empty($request->name_font_size)) {
                $name_font_size = $request->name_font_size;
            } elseif (!empty($id)) {
                $name_font_size = $certificate->name_font_size ?? 50;
            } else {
                $name_font_size = 50;
            }

            if (!empty($request->name_font_color)) {
                $name_font_color = $request->name_font_color;
            } elseif (!empty($id)) {
                $name_font_color = $certificate->name_font_color ?? '#000';
            } else {
                $name_font_color = '#000';
            }

            //Certificate Noumber

            if (isset($request->certificate_no)) {
                $certificate_no = $request->certificate_no;
            } elseif (isset($certificate->certificate_no)) {
                $certificate_no = $certificate->certificate_no;
            } else {
                $certificate_no = 0;
            }

            if (!empty($request->certificate_no_position_x)) {
                $certificate_no_position_x = $request->certificate_no_position_x;
            } elseif (!empty($id)) {
                $certificate_no_position_x = $certificate->certificate_no_position_x ?? 0;
            } else {
                $certificate_no_position_x = 0;
            }

            if (!empty($request->certificate_no_position_y)) {
                $certificate_no_position_y = $request->certificate_no_position_y;
            } elseif (!empty($id)) {
                $certificate_no_position_y = $certificate->certificate_no_position_y ?? 0;
            } else {
                $certificate_no_position_y = 0;
            }

            if (!empty($request->certificate_no_font_family)) {
                $certificate_no_font_family = $request->certificate_no_font_family;
            } elseif (!empty($id)) {
                $certificate_no_font_family = $certificate->certificate_no_font_family ?? 'nunito';
            } else {
                $certificate_no_font_family = 'nunito';
            }

            $certificate_no_text = trans('certificate.Certificate No');
            if ($this->isRtl($certificate_no_font_family)) {
                $certificate_no_text = $this->mb_strrev($certificate_no_text);
            }

            if (!empty($request->certificate_no_font_size)) {
                $certificate_no_font_size = $request->certificate_no_font_size;
            } elseif (!empty($id)) {
                $certificate_no_font_size = $certificate->certificate_no_font_size ?? 30;
            } else {
                $certificate_no_font_size = 30;
            }

            if (!empty($request->certificate_no_font_color)) {
                $certificate_no_font_color = $request->certificate_no_font_color;
            } elseif (!empty($id)) {
                $certificate_no_font_color = $certificate->certificate_no_font_color ?? '#000';
            } else {
                $certificate_no_font_color = '#000';
            }

            //Date
            if (isset($request->date)) {
                $date = $request->date;
            } elseif (isset($certificate->date)) {
                $date = $certificate->date;
            } else {
                $date = 0;
            }

            if (!empty($request->date_position_x)) {
                $date_position_x = $request->date_position_x;
            } elseif (!empty($id)) {
                $date_position_x = $certificate->date_position_x ?? 0;
            } else {
                $date_position_x = 0;
            }

            if (!empty($request->date_position_y)) {
                $date_position_y = $request->date_position_y;
            } elseif (!empty($id)) {
                $date_position_y = $certificate->date_position_y ?? 0;
            } else {
                $date_position_y = 0;
            }

            if (!empty($request->date_font_family)) {
                $date_font_family = $request->date_font_family;
            } elseif (!empty($id)) {
                $date_font_family = $certificate->date_font_family ?? 'nunito';
            } else {
                $date_font_family = 'nunito';
            }
            $date_text = trans('certificate.Date');
            if ($this->isRtl($date_font_family)) {
                $date_text = $this->mb_strrev($date_text);
            }

            if (!empty($request->date_font_size)) {
                $date_font_size = $request->date_font_size;
            } elseif (!empty($id)) {
                $date_font_size = $certificate->date_font_size ?? 30;
            } else {
                $date_font_size = 30;
            }

            if (!empty($request->date_font_color)) {
                $date_font_color = $request->date_font_color;
            } elseif (!empty($id)) {
                $date_font_color = $certificate->date_font_color ?? '#000';
            } else {
                $date_font_color = '#000';
            }


            if (!empty($request->date_format)) {
                $date_format = $request->date_format;
            } elseif (!empty($id)) {
                $date_format = $certificate->date_format ?? 1;
            } else {
                $date_format = 1;
            }


            if (!empty($request->signature_position_x)) {
                $signature_position_x = $request->signature_position_x;
            } elseif (!empty($id)) {
                $signature_position_x = $certificate->signature_position_x ?? 0;
            } else {
                $signature_position_x = 0;
            }


            if (!empty($request->signature_position_y)) {
                $signature_position_y = $request->signature_position_y;
            } elseif (!empty($id)) {
                $signature_position_y = $certificate->signature_position_y ?? 0;
            } else {
                $signature_position_y = 0;
            }


            if (!empty($request->signature_height)) {
                $signature_height = $request->signature_height;
            } elseif (!empty($id)) {
                $signature_height = $certificate->signature_height ?? 100;
            } else {
                $signature_height = 70;
            }

            if (!empty($request->signature_weight)) {
                $signature_weight = $request->signature_weight;
            } elseif (!empty($id)) {
                $signature_weight = $certificate->signature_weight ?? 100;
            } else {
                $signature_weight = 100;
            }

            if (!empty($request->signature_text)) {
                $signature_text = $request->signature_text;
            } elseif (!empty($id)) {
                $signature_text = $certificate->signature_text ?? '';
            } else {
                $signature_text = '';
            }
            if (!empty($request->signature_text_position_x)) {
                $signature_text_position_x = $request->signature_text_position_x;
            } elseif (!empty($id)) {
                $signature_text_position_x = $certificate->signature_text_position_x ?? 0;
            } else {
                $signature_text_position_x = 0;
            }

            if (!empty($request->signature_text_position_y)) {
                $signature_text_position_y = $request->signature_text_position_y;
            } elseif (!empty($id)) {
                $signature_text_position_y = $certificate->signature_text_position_y ?? 0;
            } else {
                $signature_text_position_y = 0;
            }

            if (!empty($request->signature_text_font_family)) {
                $signature_text_font_family = $request->signature_text_font_family;
            } elseif (!empty($id)) {
                $signature_text_font_family = $certificate->signature_text_font_family ?? 'nunito';
            } else {
                $signature_text_font_family = 'nunito';
            }

            if ($this->isRtl($signature_text_font_family)) {
                $signature_text = $this->mb_strrev($signature_text);
            }

            if (!empty($request->signature_text_font_size)) {
                $signature_text_font_size = $request->signature_text_font_size;
            } elseif (!empty($id)) {
                $signature_text_font_size = $certificate->signature_text_font_size ?? 30;
            } else {
                $signature_text_font_size = 30;
            }


            if (!empty($request->signature_text_font_color)) {
                $signature_text_font_color = $request->signature_text_font_color;
            } elseif (!empty($id)) {
                $signature_text_font_color = $certificate->signature_text_font_color ?? '#000';
            } else {
                $signature_text_font_color = '#000';
            }

            //title part
            if ($show_title == 1) {
                $img->text($title, ($width / 2) + $title_position_x, $title_position_y + 150, function ($font) use ($title_font_family, $title_font_size, $title_font_color) {
                    $font->size($title_font_size);
                    $font->file(public_path('fonts/' . $title_font_family . '.ttf'));
                    $font->color($title_font_color);
                    $font->align('center');
                    $font->valign('top');
                });
            }


            if ($name == 1) {
                $img->text($studentName, ($width / 2) + $name_position_x, $name_position_y + 200, function ($font) use ($name_font_family, $name_font_size, $name_font_color) {
                    $font->size($name_font_size);
                    $font->file(public_path('fonts/' . $name_font_family . '.ttf'));
                    $font->color($name_font_color);
                    $font->align('center');
                    $font->valign('top');
                });
            }


            //            org group start
            if (isModuleActive('Org')) {
                if (isset($request->show_org_chart)) {
                    $show_org_chart = $request->show_org_chart;
                } elseif (!empty($id)) {
                    $show_org_chart = $certificate->show_org_chart ?? 0;
                } else {
                    $show_org_chart = 1;
                }

                if (!empty($request->org_chart_x)) {
                    $org_chart_x = $request->org_chart_x;
                } elseif (!empty($id)) {
                    $org_chart_x = $certificate->org_chart_x ?? 0;
                } else {
                    $org_chart_x = 0;
                }

                if (!empty($request->org_chart_y)) {
                    $org_chart_y = $request->org_chart_y;
                } elseif (!empty($id)) {
                    $org_chart_y = $certificate->org_chart_y ?? 0;
                } else {
                    $org_chart_y = 0;
                }

                if (!empty($request->org_chart_font_family)) {
                    $org_chart_font_family = $request->org_chart_font_family;
                } elseif (!empty($id)) {
                    $org_chart_font_family = $certificate->org_chart_font_family ?? 'nunito';
                } else {
                    $org_chart_font_family = 'nunito';
                }

                if (!empty($request->org_chart_font_size)) {
                    $org_chart_font_size = $request->org_chart_font_size;
                } elseif (!empty($id)) {
                    $org_chart_font_size = $certificate->org_chart_font_size ?? 20;
                } else {
                    $org_chart_font_size = 20;
                }

                if (!empty($request->org_chart_font_color)) {
                    $org_chart_font_color = $request->org_chart_font_color;
                } elseif (!empty($id)) {
                    $org_chart_font_color = $certificate->org_chart_font_color ?? '#383cc1';
                } else {
                    $org_chart_font_color = '#383cc1';
                }
                $branchName = 'Branch Name';
                if (isset($request->user)) {
                    $branchName = $request->user->branch->group;
                }

                if ($show_org_chart == 1) {
                    $img->text($branchName, ($width / 2) + $org_chart_x, $org_chart_y + 250, function ($font) use ($org_chart_font_family, $org_chart_font_size, $org_chart_font_color) {
                        $font->size($org_chart_font_size);
                        $font->file(public_path('fonts/' . $org_chart_font_family . '.ttf'));
                        $font->color($org_chart_font_color);
                        $font->align('center');
                        $font->valign('top');
                    });
                }
            }


            //            org group end


            // body part
            $center_x = ($width / 2) + $body_position_x;
            $center_y = ($height / 2) + $body_position_y;
            $max_len = $body_max_len;
            $font_height = 20;
            $lines = explode("\n", wordwrap($body, $max_len));
            $y = $center_y - ((count($lines) - 1) * $font_height);
            foreach ($lines as $line) {
                $img->text($line, $center_x, $y, function ($font) use ($body_font_size, $body_font_family, $body_font_color) {
                    $font->file(public_path('fonts/' . $body_font_family . '.ttf'));
                    $font->size($body_font_size);
                    $font->color($body_font_color);
                    $font->align('center');
                    $font->valign('center');
                });
                $y += $font_height * 2;
            }


            //Profile  part
            if ($profile == 1) {
                $imagePath = public_path('uploads/staff/user.png');
                if (isset($request->user) & isset($request->course)) {
                    $userImage = $request->user->image;
                    if (!empty($userImage) && file_exists(public_path('../' . $userImage))) {
                        $imagePath = public_path('../' . $userImage);
                    }

                }
                $profileImageRow = $this->manager->read($imagePath);
                $profileImageRow->resize($profile_weight, $profile_height);
                $profileImg = $this->manager->create($profile_weight, $profile_height);
//                $profileImg->opacity(0);
                $profileImg->place($profileImageRow, 'center', 0, 0);
                $img->place($profileImg, 'top-left', $profile_x + 200, $profile_y + 250);
            }

            //START QR CODE SECTION
            if ($qr == 1) {
                if (in_array('imagick', get_loaded_extensions())) {
                    try {
                        QrCode::size(500)
                            ->format('png')
                            ->generate(url('verify-certificate/') . '/' . $request->certificate_id, public_path('images/qrcode/' . $request->certificate_id . '.png'));

                        $qrImageRow = $this->manager->read(public_path('images/qrcode/' . $request->certificate_id . '.png'));
                        $qrImageRow->resize($qr_weight, $qr_height);
                        $qrImg = $this->manager->create($qr_weight, $qr_height);
//                        $qrImg->opacity(0);

                        $qrImg->place($qrImageRow, 'center', 0, 0);
                        $img->place($qrImg, 'top-left', $qr_x + 600, $qr_y + 300);

                    } catch (Exception $e) {
                        Log::info($e->getMessage());
                    }
                } else {
                    Log::info('php imagick extention not found');
                }
            }

            if ($certificate_no == 1) {
                $img->text($certificate_no_text . ': ' . $certificate_number_prefix . $certificate_id, (200 + ($width / 2)) + $certificate_no_position_x, (($height / 2) - 250) + $certificate_no_position_y, function ($font) use ($certificate_no_font_color, $certificate_no_font_size, $certificate_no_font_family) {
                    $font->size($certificate_no_font_size);
                    $font->file(public_path('fonts/' . $certificate_no_font_family . '.ttf'));
                    $font->color($certificate_no_font_color);
                    $font->align('right');
                    $font->valign('right');

                });
            }


            //END QR CODE SECTION
            if ($date == 1) {
                $dateFormat = DateFormat::find($date_format);

                if (!empty($request->completed_at)) {
                    $completed_at = Carbon::parse($request->completed_at)->format($dateFormat->format ?? 'd/m/Y');
                } else {
                    $completed_at = date($dateFormat->format ?? 'd/m/Y');
                }

                $img->text($date_text . ': ' . $completed_at, (200 + ($width / 2)) + $date_position_x, (($height / 2) - 200) + $date_position_y, function ($font) use ($date_font_color, $date_font_size, $date_font_family) {
                    $font->size($date_font_size);
                    $font->file(public_path('fonts/' . $date_font_family . '.ttf'));
                    $font->color($date_font_color);
                    $font->align('right');
                    $font->valign('right');

                });

            }
            //

            if (!empty($sig_image)) {
                $sigImageRow = $this->manager->read($sig_image);
                $sigImageRow->resize($signature_weight, $signature_height);
                $sigImg = $this->manager->create($signature_weight, $signature_height);
//                $sigImg->opacity(0);
                $sigImg->place($sigImageRow, 'center', 0, 0);
                $img->place($sigImg, 'top-left', $signature_position_x + 650, $signature_position_y + 750);

            }


            $img->text('------------------------', ($width / 2) + $signature_text_position_x, ($height - (round($height / 5))) + $signature_text_position_y, function ($font) use ($signature_text_font_size, $signature_text_font_color, $signature_text_font_family) {
                $font->size($signature_text_font_size);
                $font->file(public_path('fonts/' . $signature_text_font_family . '.ttf'));
                $font->color($signature_text_font_color);
                $font->align('center');
                $font->valign('bottom');

            });


            $img->text($signature_text, ($width / 2) + $signature_text_position_x, ($height - (round($height / 7) + $signature_text_position_y)), function ($font) use ($signature_text_font_size, $signature_text_font_color, $signature_text_font_family) {
                $font->size($signature_text_font_size);
                $font->file(public_path('fonts/' . $signature_text_font_family . '.ttf'));
                $font->color($signature_text_font_color);
                $font->align('center');
                $font->valign('bottom');

            });
            $data['image'] = $img;
            $data['height'] = $height;
            $data['width'] = $width;

            return $data;
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
            return null;
        }
    }

    public function isRtl($font_name)
    {
        if ($font_name == 'arabic') {
            return true;
        }
        $font = CertificateFont::where('name', $font_name)->where('rtl', 1)->first();

        if ($font) {
            return true;
        }
        return false;
    }

    function mb_strrev($str)
    {

        $Arabic = new I18N_Arabic('Glyphs');

        return $Arabic->utf8Glyphs($str);

        //        $r = '';
        //        for ($i = mb_strlen($str); $i >= 0; $i--) {
        //            $r .= mb_substr($str, $i, 1, 'UTF-8');
        //        }
        //        return trim($r);
    }

    public function download($id, Request $request)
    {
        try {
            $certificate = $this->makeCertificate($id, $request)['image'] ?? '';

            $certificate= $certificate->toPng();
            $headers = [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename=' . 'demo.jpg',
            ];
            return response()->stream(function () use ($certificate) {
                echo $certificate;
            }, 200, $headers);
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function preview(Request $request)
    {
        try {
            $id = $request->id;
            $certificate = $this->makeCertificate($id, $request);
            $data['image'] = $certificate['image']->toPng()->toDataUri();
            $data['height'] = $certificate['height'];
            $data['width'] = $certificate['width'];
            return json_encode($data);
        } catch (Exception $e) {
            return null;
        }
    }

    public function upload(Request $request)
    {
        if ($_FILES["file"]["name"] != '') {
            $test = explode('.', $_FILES["file"]["name"]);
            $ext = end($test);
            $name = md5(rand(100, 999999999999) . time()) . '.' . $ext;
            $location = public_path('uploads/certificate') . '/' . $name;
            $public_path = 'public/uploads/certificate/' . $name;
            $status = move_uploaded_file($_FILES["file"]["tmp_name"], $location);
            if ($status) {
                $data['type'] = 'Success';
                $data['location'] = $public_path;
            } else {
                $data['type'] = 'Error';
                $data['location'] = '';
            }


        } else {
            $data['type'] = 'Error';
            $data['location'] = '';
        }
        return json_encode($data);
    }

    public function getByAjax(Request $request)
    {
        try {
            $certificate_record = CertificateRecord::where('certificate_id', $request->certificate_number)->first();
            if ($certificate_record) {
                $course = Course::find($certificate_record->course_id);

                if (isModuleActive('CertificatePro') && Settings('use_certificate_template') == 'pro') {
                    if (!empty($course->pro_certificate_id)) {
                        $certificate = CertificateTemplate::find($course->pro_certificate_id);

                    } else {
                        if ($course->type == 1) {
                            $certificate = CertificateTemplate::where('default_for', 'c')->first();
                        } elseif ($course->type == 2) {
                            $certificate = CertificateTemplate::where('default_for', 'q')->first();
                        } elseif ($course->type == 3) {
                            $certificate = CertificateTemplate::where('default_for', 'l')->first();
                        } else {
                            $certificate = null;
                        }
                    }

                    $url = route('certificate_pro.student_certificate', [$certificate->id, 'course' => $course->id, 'c_id' => $certificate_record->certificate_id, 'u_id' => $certificate_record->student_id]);
                    return [
                        'success' => true,
                        'certificate' => '',
                        'url' => $url
                    ];

                } else {
                    if ($course->certificate_id != null) {
                        $certificate = Certificate::find($course->certificate_id);
                    } else {
                        if ($course->type == 1) {
                            $certificate = Certificate::where('for_course', 1)->first();
                        } else {
                            $certificate = Certificate::where('for_quiz', 1)->first();
                        }
                    }

                    if ($certificate) {
                        $downloadFile = new CertificateController();

                        $request->certificate_id = $certificate_record->certificate_id;
                        $request->course = $course;
                        $request->user = User::find($certificate_record->student_id);
                        $certificate = $downloadFile->makeCertificate($certificate->id, $request)['image'] ?? '';
                        if ($certificate){
                            $certificate =$certificate->toPng()->toDataUri();
                        }

                        return [
                            'success' => true,
                            'certificate' => $certificate,
                            'url' => ''
                        ];
                    }

                }


            }

        } catch (Exception $e) {

        }

        return [
            'success' => false,
            'message' => trans('certificate.Invalid Certificate Number')
        ];
    }
}
