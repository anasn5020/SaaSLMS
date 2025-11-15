<?php

namespace Modules\FrontendManage\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ImageStore;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Modules\FrontendManage\Entities\BecomeInstructor;
use Modules\FrontendManage\Entities\WorkProcess;

class BecomeInstructorSettingController extends Controller
{
    use ImageStore;

    public function index()
    {
        try {
            $settings = BecomeInstructor::latest()->get();
            return view('frontendmanage::becomeInstructor', compact('settings'));

        } catch (Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function allWork()
    {
        try {
            $works = WorkProcess::latest()->get();
            return view('frontendmanage::workProcess', compact('works'));

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }


    }


    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'title' => 'required',
            'description' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {

            $work = new WorkProcess;

            foreach ($request->title as $key => $value) {
                $work->setTranslation('title', $key, $value);
            }
            foreach ($request->description as $key => $value) {
                $work->setTranslation('description', $key, $value);
            }
            $work->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {

            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }


    public function show($id)
    {
        return view('systemsetting::show');
    }

    public function edit($id)
    {
        try {
            $setting = BecomeInstructor::find($id);
            return response()->json([
                'setting' => $setting
            ], 200);
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    public function editWork($id)
    {
        try {
            $work = WorkProcess::find($id);
            return response()->json([
                'work' => $work
            ], 200);
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function update(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {

            $setting = BecomeInstructor::find($request->id);
            if ($request->id == 6) {
                if (!empty($request->section)) {
                    foreach ($request->section as $key => $value) {
                        $setting->setTranslation('section', $key, $value);
                    }
                }
            }

            if ($request->id == 4) {
                $setting->bg_image = $this->saveImage($request->bg_image);
            }
            if (!empty($request->title)) {
                foreach ($request->title as $key => $value) {
                    $setting->setTranslation('title', $key, $value);
                }
            }
            if (!empty($request->description)) {
                foreach ($request->description as $key => $value) {
                    $setting->setTranslation('description', $key, $value);
                }
            }
            if ($setting->id == 4 || $setting->id == 5) {
                foreach ($request->btn_name as $key => $value) {
                    $setting->setTranslation('btn_name', $key, $value);
                }
            }


            $setting->btn_link = $request->btn_link;
            $setting->icon = $request->icon;
            $setting->video = $request->video;


            if ($request->hasFile('image')) {
                $setting->image = $this->saveImage($request->image, 800, 500);
            }

            $setting->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    public function updateWork(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'title' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {

            $work = WorkProcess::find($request->id);
            foreach ($request->title as $key => $value) {
                $work->setTranslation('title', $key, $value);
            }
            foreach ($request->description as $key => $value) {
                $work->setTranslation('description', $key, $value);
            }
            $work->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    public function search()
    {
        try {
            $query = \Request::get('s');
            if ($query != '') {
                $settings = BecomeInstructor::where('section', 'like', '%' . $query . '%')
                    ->latest()->paginate(5);
            } else {
                $settings = BecomeInstructor::latest()->paginate(5);
            }

            return response()->json([
                'settings' => $settings
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => trans("lang.Oops, Something Went Wrong")]);

        }
    }

    public function searchWork()
    {
        try {
            $query = \Request::get('s');
            if ($query != '') {
                $works = WorkProcess::where('title', 'like', '%' . $query . '%')
                    ->latest()->paginate(5);
            } else {
                $works = WorkProcess::latest()->paginate(5);
            }

            return response()->json([
                'works' => $works
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => trans("lang.Oops, Something Went Wrong")]);
        }
    }


    public function status($id)
    {
        try {
            $work = WorkProcess::find($id);

            if ($work->status == 1) {
                $work->status = 0;
                $success = trans('lang.Work Process') . ' ' . trans('lang.Deactivated') . ' ' . trans('lang.Successfully');
            } else {
                $work->status = 1;
                $success = trans('lang.Work Process') . ' ' . trans('lang.Activated') . ' ' . trans('lang.Successfully');
            }

            $work->save();

            return response()->json([
                'success' => $success
            ], 200);

        } catch (Exception $e) {
            return response()->json(['error' => trans("lang.Operation Failed")]);

        }
    }

    public function destroy($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $success = trans('lang.Work Process') . ' ' . trans('lang.Deleted') . ' ' . trans('lang.Successfully');
            $work = WorkProcess::find($id);

            $work->delete();

            return response()->json([
                'success' => $success
            ], 200);

        } catch (Exception $e) {
            return response()->json(['error' => trans("lang.Operation Failed")]);
        }
    }

}
