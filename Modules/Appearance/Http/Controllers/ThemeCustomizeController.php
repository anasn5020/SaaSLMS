<?php

namespace Modules\Appearance\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Appearance\Entities\Theme;
use Modules\Appearance\Entities\ThemeCustomize;
use Modules\Org\Http\Controllers\OrgColorController;

class ThemeCustomizeController extends Controller
{

    public function index()
    {
        try {
            $themes = ThemeCustomize::with('theme')->get();
            $data = [];
            if (isModuleActive('Org')) {
                $data['colors'] = OrgColorController::colorList();
            }
            return view('appearance::customize.index', $data, compact('themes'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function create()
    {
        $default = ThemeCustomize::getData();
        $themes = Theme::getAllData();
        return view('appearance::customize.create', compact('themes', 'default'));

    }


    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $request->validate([
            'title' => 'required|max:191',
            'theme' => 'required|max:191',
            'is_default' => 'sometimes|required|boolean',
            's_color' => 'required|string|max:20',
            'p_color' => 'required|string|max:20',
            'g_color' => 'required|string|max:20',
            'footer_background_color' => 'required|string|max:20',
            'footer_headline_color' => 'required|string|max:20',
            'footer_text_color' => 'required|string|max:20',
            'footer_text_hover_color' => 'required|string|max:20',
        ]);

        if ($request->is_default) {
            ThemeCustomize::where('is_default', 1)->where('theme_name', $request->theme)->update(['is_default' => 0]);
        }

        $theme = new ThemeCustomize();
        $theme->name = $request->title;
        $theme->theme_name = $request->theme;
        $theme->secondary_color = $request->s_color;
        $theme->primary_color = $request->p_color;
        $theme->gradient_color = $request->g_color;
        $theme->is_gradient = $request->is_gradient==1 ? 1 : 0;

        $theme->footer_background_color = $request->footer_background_color;
        $theme->footer_headline_color = $request->footer_headline_color;
        $theme->footer_text_color = $request->footer_text_color;
        $theme->footer_text_hover_color = $request->footer_text_hover_color;
        $theme->bg_color = $request->bg_color;

        $theme->is_default = $request->is_default ? 1 : 0;
        $theme->created_by = Auth::id();

        $theme->save();


        Toastr::success(__('setting.New Theme Created Successful'), __('common.Success'));
        return redirect()->to(route('appearance.themes-customize.index'));
    }

    public function update(Request $request, $id)
    {

        if (demoCheck()) {
            return redirect()->back();
        }
        $request->validate([
            'title' => 'required|max:191',
            'theme' => 'required|max:191',
            's_color' => 'required|string|max:20',
            'p_color' => 'required|string|max:20',
            'g_color' => 'required|string|max:20',
            'footer_background_color' => 'required|string|max:20',
            'footer_headline_color' => 'required|string|max:20',
            'footer_text_color' => 'required|string|max:20',
            'footer_text_hover_color' => 'required|string|max:20',
        ]);


        $theme = ThemeCustomize::findOrFail($id);
        $theme->name = $request->title;
        $theme->theme_name = $request->theme;
        $theme->secondary_color = $request->s_color;
        $theme->primary_color = $request->p_color;
        $theme->gradient_color = $request->g_color;
        $theme->is_gradient = $request->is_gradient==1 ? 1 : 0;


        $theme->footer_background_color = $request->footer_background_color;
        $theme->footer_headline_color = $request->footer_headline_color;
        $theme->footer_text_color = $request->footer_text_color;
        $theme->footer_text_hover_color = $request->footer_text_hover_color;
        $theme->bg_color = $request->bg_color;

        $theme->save();


        Toastr::success(__('setting.Theme Update Successfully'), __('common.Success'));
        return redirect()->to(route('appearance.themes-customize.index'));
    }

    public function edit($id)
    {
        $editData = ThemeCustomize::findOrFail($id);
        $themes = Theme::getAllData();
        return view('appearance::customize.edit', compact('themes', 'editData'));
    }

    public function destroy($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $theme = ThemeCustomize::findOrFail($id);

        if ($theme->id == 1) {
            Toastr::error(__('setting.You can not permitted to delete system theme'), __('common.Operation failed'));
            return redirect()->back();
        }

        if ($theme->is_default) {
            Theme::find(1)->update(['is_default' => 1]);
        }


        $theme->delete();
        Toastr::success(__('setting.Theme Deleted Successful'), __('common.Success'));
        return redirect()->back();
    }


    public function copy($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $theme = ThemeCustomize::findOrFail($id);
        $newTheme = new ThemeCustomize();
        $newTheme->name = __('setting.Clone of') . ' ' . $theme->name;
        $newTheme->created_at = Carbon::now();
        $newTheme->primary_color = $theme->primary_color;
        $newTheme->gradient_color = $theme->gradient_color;
        $newTheme->is_gradient = $theme->is_gradient;
        $newTheme->secondary_color = $theme->secondary_color;
        $newTheme->footer_background_color = $theme->footer_background_color;
        $newTheme->footer_headline_color = $theme->footer_headline_color;
        $newTheme->footer_text_color = $theme->footer_text_color;
        $newTheme->footer_text_hover_color = $theme->footer_text_hover_color;
        $newTheme->bg_color = $theme->bg_color;
        $newTheme->theme_name = $theme->theme_name;
        $newTheme->is_default = false;
        $newTheme->created_by = Auth::id();
        $newTheme->save();


        Toastr::success(__('setting.Theme Cloned Successful'), __('common.Success'));
        return redirect()->back();

    }

    public function default($id)
    {

        if (demoCheck()) {
            return redirect()->back();
        }
        $theme = ThemeCustomize::findOrFail($id);
        ThemeCustomize::where('id', '!=', $theme->id)->update(['is_default' => 0]);
        $theme->is_default = 1;
        $theme->save();

        Cache::rememberForever('color_theme_' . SaasDomain(), function () {
            return DB::table('themes')
                ->select(
                    'theme_customizes.primary_color',
                    'theme_customizes.is_gradient',
                    'theme_customizes.gradient_color',
                    'theme_customizes.secondary_color',
                    'theme_customizes.footer_background_color',
                    'theme_customizes.footer_headline_color',
                    'theme_customizes.footer_text_color',
                    'theme_customizes.footer_text_hover_color',
                )
                ->join('theme_customizes', 'themes.id', '=', 'theme_customizes.theme_id')
                ->where('theme_customizes.lms_id', '=', SaasInstitute()->id)
                ->where('themes.is_active', '=', 1)
                ->where('theme_customizes.is_default', '=', 1)
                ->first();
        });

        Toastr::success(__('setting.Theme Set Default Successful'), __('common.Success'));
        return redirect()->back();

    }

    public function settingUpdate(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $settings = $request->except('_token');
        foreach ($settings as $key => $setting) {
            UpdateGeneralSetting($key, $setting);
        }

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }
}
