<?php

namespace Modules\FrontendManage\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\UploadMedia;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Modules\CourseSetting\Entities\Course;
use Modules\FrontendManage\Entities\HomeContent;
use Modules\FrontendManage\Entities\Slider;

class SliderController extends Controller
{
    use UploadMedia;

    public function index()
    {
        try {
            $sliders = Slider::latest()->get();
            $data = [];
            if (Settings('frontend_active_theme') == 'tvt') {
                $data['courses'] = Course::select('id', 'title')->where('status', 1)->get();
            }
            return view('frontendmanage::sliders', $data, compact('sliders'));
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
            'image' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $slider = new Slider();
            $slider->course_id = $request->course_id ?? 0;
            $slider->title = $request->title;
            $slider->sub_title = $request->sub_title;

            $slider->btn_title1 = $request->btn_title1;
            $slider->btn_link1 = $request->btn_link1;


            $slider->btn_title2 = $request->btn_title2;
            $slider->btn_link2 = $request->btn_link2;
//            $slider->image = null;
//            $slider->btn_image1 = null;
//            $slider->btn_image2 = null;

            if ($request->btn_type1 == 1) {
                $slider->btn_type1 = 1;
            } else {
                $slider->btn_type1 = 0;
            }

            if ($request->btn_type2 == 1) {
                $slider->btn_type2 = 1;
            } else {
                $slider->btn_type2 = 0;
            }
            $slider->save();

            if ($request->image) {
                $slider->image = $this->generateLink($request->image, $slider->id, get_class($slider), 'image');
            }
            if ($request->btn_image1) {
                $slider->btn_image1 = $this->generateLink($request->btn_image1, $slider->id, get_class($slider), 'btn_image1');
            }
            if ($request->btn_image2) {
                $slider->btn_image2 = $this->generateLink($request->btn_image2, $slider->id, get_class($slider), 'btn_image2');
            }
            $slider->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function edit($id)
    {
        try {
            $sliders = Slider::latest()->get();
            $slider = Slider::findOrFail($id);
            $data = [];
            if (Settings('frontend_active_theme') == 'tvt') {
                $data['courses'] = Course::select('id', 'title')->where('status', 1)->get();
            }
            return view('frontendmanage::sliders', $data, compact('sliders', 'slider'));
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
            $slider = Slider::find($request->id);
            $slider->course_id = $request->course_id ?? 0;
            $slider->title = $request->title;
            $slider->sub_title = $request->sub_title;

            $slider->btn_title1 = $request->btn_title1;
            $slider->btn_link1 = $request->btn_link1;


            $slider->btn_title2 = $request->btn_title2;
            $slider->btn_link2 = $request->btn_link2;

            $slider->image = null;
            $slider->btn_image1 = null;
            $slider->btn_image2 = null;

            if ($request->btn_type1 == 1) {
                $slider->btn_type1 = 1;
            } else {
                $slider->btn_type1 = 0;
            }

            if ($request->btn_type2 == 1) {
                $slider->btn_type2 = 1;
            } else {
                $slider->btn_type2 = 0;
            }

            $slider->save();
            $this->removeLink($slider->id, get_class($slider));

            if ($request->image) {
                $slider->image = $this->generateLink($request->image, $slider->id, get_class($slider), 'image');
            }
            if ($request->btn_image1) {
                $slider->btn_image1 = $this->generateLink($request->btn_image1, $slider->id, get_class($slider), 'btn_image1');
            }
            if ($request->btn_image2) {
                $slider->btn_image2 = $this->generateLink($request->btn_image2, $slider->id, get_class($slider), 'btn_image2');
            }
            $slider->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('frontend.sliders.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function destroy($id)
    {
        if (demoCheckById($id,[1,2])) {
            return redirect()->back();
        }
        try {
            Slider::destroy($id);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('frontend.sliders.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function setting()
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $home_content = app('getHomeContent');
            $setting = HomeContent::where('key', 'slider_banner')->first();

            return view('frontendmanage::slider_setting', compact('home_content', 'setting'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function settingSubmit(Request $request)
    {

        if (hasDynamicPage()) {

            $setting = HomeContent::where('key', 'slider_banner')->first();

            $setting->value = null;
            $setting->save();
            $this->removeLink($setting->id, get_class($setting));
            if ($request->slider_banner != null) {
                $image = $this->generateLink($request->slider_banner, $setting->id, get_class($setting), 'value');
                UpdateHomeContent('slider_banner', $image);

            }

            UpdateHomeContent('show_menu_search_box', $request->show_menu_search_box == 1 ? 1 : 0);
            UpdateHomeContent('show_banner_search_box', $request->show_banner_search_box == 1 ? 1 : 0);

        }

        UpdateGeneralSetting('slider_transition_time', $request->slider_transition_time ?? 5);
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }
}
