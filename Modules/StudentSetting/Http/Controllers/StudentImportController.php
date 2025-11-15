<?php

namespace Modules\StudentSetting\Http\Controllers;

use App\Exports\CountryList;
use App\Exports\OfflineStudentExport;
use App\Exports\RegularStudentExport;
use App\Http\Controllers\Controller;
use App\Imports\ImportRegularStudent;
use App\Imports\StudentImport;
use App\Jobs\SendGeneralEmail;
use App\StudentCustomField;
use App\Traits\SendNotification;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\StudentSetting\Entities\StudentImportTemporary;

class StudentImportController extends Controller
{
    use SendNotification;

    public function index()
    {
        $courses = Course::where('type', 1)->get();
        $custom_field = StudentCustomField::getData();
        return view('studentsetting::student_import', compact('courses', 'custom_field'));
    }


    public function regular()
    {
        return view('studentsetting::regular_student_import');
    }

    public function create()
    {
        return view('studentsetting::create');
    }

    public function export()
    {
        return Excel::download(new OfflineStudentExport, 'student_import.xlsx');
    }

    public function regularStudentexport()
    {
        return Excel::download(new RegularStudentExport, 'sample-student.xlsx');
    }

    public function country_list_export()
    {
        return Excel::download(new CountryLIst, 'country_list.xlsx');
    }

    public function store(Request $request)
    {
        if (saasPlanCheck('student')) {
            Toastr::error(trans('frontend.You have reached student limit'), trans('common.Failed'));
            return redirect()->back();
        }
        if (demoCheck()) {
            return redirect()->back();
        }

        $validate_rules = [
            'course' => 'required',
            'file' => 'required',
        ];
        $request->validate($validate_rules, validationMessage($validate_rules));

        $file_type = strtolower($request->file->getClientOriginalExtension());
        if ($file_type <> 'csv' && $file_type <> 'xlsx' && $file_type <> 'xls') {
            Toastr::warning(trans('frontend.The file must be a file of type: xlsx, csv or xls'),);
            return redirect()->back();
        } else {
            try {

                DB::beginTransaction();
                $path = $request->file('file');
                $custom_field = StudentCustomField::getData();
                Excel::import(new StudentImport($custom_field), $request->file('file'), 'local', \Maatwebsite\Excel\Excel::XLSX);


                $data = StudentImportTemporary::where('created_by', Auth::user()->id)->get();


                if (count($data) == 0) {
                    Toastr::error(trans('common.No Data Saved'), trans('common.Failed'));
                    return redirect()->back();
                }
                foreach ($data as $key => $student) {
                    $password = getTrx(8);
                    $check_user = User::where('email', $student->email)->first();
                    if ($check_user == null) {
                        $new_student = new User();
                        $new_student->role_id = 3;
                        $new_student->name = $student->name;
                        $new_student->email = $student->email;
                        $new_student->username = $student->email;
                        $new_student->phone = $student->phone;
                        $new_student->dob = @$student->dob;
                        $new_student->gender = @$student->gender;
                        $new_student->country = isset($student->country) ? $student->country : Settings('country_id');
                        $new_student->job_title = @$student->job_title;
                        $new_student->company_id = @$student->company;
                        $new_student->identification_number = @$student->identification_number;
                        $new_student->password = $password;
                        $new_student->created_at = date('Y-m-d h:i:s');
                        $new_student->referral = Str::random(10);
                        $new_student->email_verified_at = now();
                        $new_student->teach_via = 2;
                        $new_student->lms_id = SaasInstitute()->id;


                        $new_student->language_id = Settings('language_id');
                        $new_student->language_code = Settings('language_code');
                        $new_student->language_name = Settings('language_name');
                        $new_student->language_rtl = Settings('language_rtl');

                        if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                            $new_student->organization_id = Auth::id();
                        }

                        $new_student->save();

                        applyDefaultRoleToUser($new_student);


                        $this->sendNotification('Offline_Enrolled', $new_student, [
                            'email' => $new_student->email,
                            'password' => $password,
                        ]);

                    } else {
                        $new_student = $check_user;
                        Toastr::warning($new_student->name . ' ' . trans('common.Already added'));
                    }


                    $check_enrolled = CourseEnrolled::where('user_id', $new_student->id)->where('course_id', $request->course)->with('course')->first();

                    if ($check_enrolled == null) {
                        $enroll = new CourseEnrolled();
                        $enroll->user_id = $new_student->id;
                        $enroll->course_id = $request->course;
                        $enroll->purchase_price = 0.00;
                        $enroll->coupon = null;
                        $enroll->discount_amount = 0.00;
                        $enroll->save();
                    } else {
                        Toastr::warning($new_student->name . ' ' . trans('common.Already enrolled') . ' ' . $check_enrolled->course->title);
                    }


                }


                StudentImportTemporary::where('created_by', Auth::user()->id)->delete();

                DB::commit();
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            } catch (Exception $e) {
                DB::rollBack();
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }
        }
    }


    public function regularStore(Request $request)
    {
        if (saasPlanCheck('student')) {
            Toastr::error(trans('frontend.You have reached student limit'), trans('common.Failed'));
            return redirect()->back();
        }
        if (demoCheck()) {
            return redirect()->back();
        }

        $rules = [
            'file' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));


        $extensions = ["xls", "xlsx"];
        $result = strtolower($request->file->getClientOriginalExtension());
        if (!in_array($result, $extensions)) {
            Toastr::warning(trans('frontend.The file must be a file of type: xlsx, csv or xls'),);
            return redirect()->back();
        }
        $path = $request->file('file');
        Excel::import(new ImportRegularStudent(), $path, 'local', \Maatwebsite\Excel\Excel::XLSX);
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();

    }


}
