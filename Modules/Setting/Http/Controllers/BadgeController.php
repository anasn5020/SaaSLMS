<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ImageStore;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Modules\Setting\Entities\Badge;

class BadgeController extends Controller
{
    use ImageStore;

    public function index()
    {
        $types = $this->badgesTypes();
        $badges = Badge::orderBy('point', 'asc')->get();
        return view('setting::badges.index', compact('types', 'badges'));
    }

    public function store(Request $request)
    {
        session()->flash('request_type', 'store');
        session()->flash('type', $request->type);

        $rules = [
            'title' => 'required',
            'type' => 'required',
            'point' => 'required',
            'image' => 'required|mimes:jpeg,bmp,png,jpg,svg,gif',
        ];

        $this->validate($request, $rules, validationMessage($rules));


        try {
            $badge = new Badge();

            $badge->title = $request->title;
            $badge->point = $request->point;
            $badge->type = $request->type;
            $badge->status = 1;


            $badge->save();
            if ($request->image) {
                $badge->image = $this->saveImage($request->image);
            }
            $badge->save();

            session()->forget('type');
            session()->forget('request_type');

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('gamification.badges');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function edit($batch_id)
    {
        $badge = Badge::findOrFail($batch_id);
        return view('setting::badges.components.widget_edit', compact('badge'));
    }

    public function update(Request $request)
    {
        session()->flash('request_type', 'edit');
        session()->flash('id', $request->id);

        $rules = [
            'id' => 'required',
            'title' => 'required',
            'point' => 'required',
            'image' => 'nullable|mimes:jpeg,bmp,png,jpg,svg,gif',

        ];

        $this->validate($request, $rules, validationMessage($rules));


        $badge = Badge::findOrFail($request->id);
        try {
            $badge->title = $request->title;
            $badge->point = $request->point;
            $badge->save();
//            $this->removeLink($badge->id, get_class($badge));
            if ($request->image) {
                $badge->image = $this->saveImage($request->image);
            }
            $badge->save();
            session()->forget('request_type');
            session()->forget('id');

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('gamification.badges');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function destroy($id)
    {

        if (demoCheckById($id,range(1,112))) {
            return redirect()->back();
        }
        $badge = Badge::findOrFail($id);
        $badge->delete();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->route('gamification.badges');
    }

    public function badgesTypes()
    {
        if (Settings('hide_ecommerce') == 0) {
            $data = [
                'activity' => trans('setting.Activity badges'),
                'registration' => trans('setting.Registration badges'),
                'learning' => trans('setting.Learning badges'),
                'courses' => trans('setting.Course count badges'),
                'rating' => trans('setting.Course rating badges'),
                'sales' => trans('setting.Course sales badges'),
                'blogs' => trans('setting.Blog post badges'),
                'test' => trans('setting.Test badges'),
                'perfectionism' => trans('setting.Perfectionism badges'),
                'communication' => trans('setting.Communication badges'),
                'certification' => trans('setting.Certification badges'),
            ];
            if (isModuleActive('Assignment')) {
                $data['assignment'] = trans('setting.Assignment badges');
            }
            if (isModuleActive('Survey')) {
                $data['survey'] = trans('setting.Survey badges');
            }
            if (isModuleActive('Forum')) {
                $data['forum'] = trans('setting.Forum badges');
            }
        } else {
            $data = [
                'activity' => trans('setting.Activity badges'),
                'registration' => trans('setting.Registration badges'),
                'learning' => trans('setting.Learning badges'),
                'test' => trans('setting.Test badges'),
                'perfectionism' => trans('setting.Perfectionism badges'),
                'certification' => trans('setting.Certification badges'),
            ];
            if (isModuleActive('Survey')) {
                $data['survey'] = trans('setting.Survey badges');
            }
        }
        return $data;
    }

    public function pointType()
    {
        return [
            'each_login',
            'each_unit_complete',
            'each_course_complete',
            'each_certificate',
            'each_test_complete',
            'each_assignment_complete',
            'each_comment',
        ];
    }
}
