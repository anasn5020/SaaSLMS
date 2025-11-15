<?php

namespace Modules\FrontendManage\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Modules\FrontendManage\Entities\HomePageFaq;

class HomePageFaqController extends Controller
{
    public function index()
    {
        try {
            $faqs = HomePageFaq::orderBy('order')->get();
            return view('frontendmanage::faq.index', compact('faqs'));

        } catch (Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();

        }
    }


    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $code = auth()->user()->language_code;

        $rules = [
            'question.' . $code => 'required|max:255',
            'answer.' . $code => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));


        try {
            $total = HomePageFaq::latest()->count();
            $faq = new HomePageFaq;
            foreach ($request->question as $key => $question) {
                $faq->setTranslation('question', $key, $question);
            }

            foreach ($request->answer as $key => $answer) {
                $faq->setTranslation('answer', $key, $answer);
            }
            $faq->order = $total + 1;
            $faq->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));

            return redirect()->back();

        } catch (Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));

            return redirect()->back();
        }
    }

    public function show(Request $request)
    {
        $faq = HomePageFaq::findOrFail($request->id);
        $LanguageList = getLanguageList();
        return view('frontendmanage::faq.show', compact('faq','LanguageList'));
    }

    public function update(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $code = auth()->user()->language_code;

        $rules = [
            'question.' . $code => 'required|max:255',
            'answer.' . $code => 'required',
        ];


        $this->validate($request, $rules, validationMessage($rules));

        $faq = HomePageFaq::findOrFail($request->id);

        try {
            foreach ($request->question as $key => $question) {
                $faq->setTranslation('question', $key, $question);
            }

            foreach ($request->answer as $key => $answer) {
                $faq->setTranslation('answer', $key, $answer);
            }
            $faq->order = $request->order;
            $faq->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));

            return redirect()->back();

        } catch (Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));

            return redirect()->back();

        }
    }


    public function destroy(Request $request)
    {
        $id = $request->id;

        if (demoCheckById($id,range(1,5))) {
            return redirect()->back();
        }
        try {
            $faq = HomePageFaq::find($id);
            $faq->delete();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));

            return redirect()->back();

        } catch (Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function changeFaqPosition(Request $request)
    {
        if (demoCheck()) {
            return false;
        }
        $ids = $request->get('ids');
        if (count($ids) != 0) {
            foreach ($ids as $key => $id) {
                $chapter = HomePageFaq::find($id);
                if ($chapter) {
                    $chapter->order = $key + 1;
                    $chapter->save();
                }
            }
        }
        return true;
    }
}
