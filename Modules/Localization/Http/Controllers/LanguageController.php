<?php

namespace Modules\Localization\Http\Controllers;

use App\Traits\ImageStore;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Modules\Localization\Entities\Language;
use Modules\Localization\Repositories\LanguageRepositoryInterface;

class LanguageController extends Controller
{
    use ImageStore;
    protected $languageRepository;

    public function __construct(LanguageRepositoryInterface $languageRepository)
    {

        $this->languageRepository = $languageRepository;
    }

    public function index()
    {
        $languages = $this->languageRepository->all();
        return view('localization::languages.index', [
            "languages" => $languages
        ]);
    }

    public function update_rtl_status(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $language = Language::findOrFail($request->id);
        $language->rtl = $request->status;
        if ($language->save()) {
            return 1;
        }
        return 0;
    }

    public function update_active_status(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $language = Language::findOrFail($request->id);
        $language->status = $request->status;
        if ($language->save()) {
            Cache::forget('LanguageList_' . SaasDomain());
            Cache::forget('languages_' . SaasDomain());
            return 1;
        }
        return 0;
    }

    public function store(Request $request)
    {
         if (demoCheck()) {
            return redirect()->back();
        }
        try {
           if($request->rtl == null){
               $request->merge(['rtl'=>0]);
           }

            if ($request->flag_img) {
                $request->merge(['flag'=>$this->saveImage($request->flag_img)]);
            }
             $this->languageRepository->create($request->except("_token",'flag_img'));
            Toastr::success(__('setting.Language Added Successfully'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            Toastr::error(__('common.Something Went Wrong'), trans('common.Failed'));
            return redirect()->back();

        }
    }

    public function edit(Request $request)
    {
        try {
            $language = $this->languageRepository->find($request->id);
            return view('localization::languages.edit_modal', [
                "language" => $language
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            $language = $this->languageRepository->find($id);
            Session::put('locale', $language->code);
            return view('localization::languages.translate_view', [
                "language" => $language
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {

            if ($request->flag_img) {
                $request->merge(['flag'=>$this->saveImage($request->flag_img)]);
            }
            $this->languageRepository->update($request->except("_token",'flag_img'), $id);

            Toastr::success(__('setting.Language Updated Successfully'), trans('common.Success'));
            return redirect()->back();

        } catch (Exception $e) {
            return back()->with('message-danger', __('common.Something Went Wrong'));
        }
    }


    public function key_value_store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $validate_rules = [
            'id' => 'required',
            'translatable_file_name' => 'required',
            'key' => 'required',
        ];

        $request->validate($validate_rules, validationMessage($validate_rules));

        try {
            $language = Language::findOrFail($request->id);

            $file_name = $request->translatable_file_name;

            $check_module = explode('::', $file_name);

            if (count($check_module) > 1) {
                $translatable_file_name = $check_module[1];
                $folder = module_path(ucfirst($check_module[0])) . '/Resources/lang/' . $language->code . '/';
            } else {
                $translatable_file_name = $request->translatable_file_name;
                $folder = resource_path('lang/' . $language->code . '/');
            }

            $file = $folder . $translatable_file_name;

            if (!file_exists($folder)) {
                mkdir($folder);
            }
            if (file_exists($file)) {
                file_put_contents($file, '');
            }

            file_put_contents($file, '<?php return ' . var_export($request->key, true) . ';');
            Artisan::call('cache:clear',[
                '--no-interaction' => true,
            ]);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return back();

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function changeLanguage(Request $request)
    {

        Session::put('locale', $request->code);
        UpdateGeneralSetting('language_name', $request->code);
        return 1;
    }

    public function get_translate_file(Request $request)
    {
        try {
            $language = $this->languageRepository->find($request->id);

            $file_name = explode('.', $request->file_name);
            $languages = Lang::get($file_name[0]);
            $translatable_file_name = $request->file_name;

            $file1 = base_path('resources/lang/default/'.$request->file_name);
            if (!file_exists(base_path('resources/lang/'.$language->code))) {
                mkdir(base_path('resources/lang/'.$language->code));
            }

            if (!file_exists(base_path('resources/lang/'.$language->code.'/'.$request->file_name))) {
                copy($file1,base_path('resources/lang/'.$language->code.'/'.$request->file_name));
                $url = base_path('resources/lang/'.$language->code.'/'.$request->file_name);
                $languages = include  "{$url}";
                return view('localization::modals.translate_modal', [
                    "languages" => $languages,
                    "language" => $language,
                    "translatable_file_name" => $translatable_file_name
                ]);
            }

            $file2 = base_path('resources/lang/'.$language->code.'/'.$request->file_name);
            // Count the number of lines on file
            $default_file_arr = include  "{$file1}";
            $lang_file_arr = include  "{$file2}";

            if (count($default_file_arr) > count($lang_file_arr)) {
                $languages = array_merge($default_file_arr, $lang_file_arr);
            } else{
                $url = base_path('resources/lang/'.$language->code.'/'.$request->file_name);
                $languages = include  "{$url}";
            }

            return view('localization::modals.translate_modal', [
                "languages" => $languages,
                "language" => $language,
                "translatable_file_name" => $translatable_file_name
            ]);
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }


    public function destroy($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $this->languageRepository->delete($id);
            Toastr::success(__('setting.Language has been deleted Successfully'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            return back()->with('message-danger', __('common.Something Went Wrong'));
        }
    }
}
