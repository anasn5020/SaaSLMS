<?php

namespace Modules\FrontendManage\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\UploadMedia;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Modules\FrontendManage\Entities\LoginPage;

class LoginPageController extends Controller
{
    use UploadMedia;

    public function index()
    {
        $page = LoginPage::getData();
        return view('frontendmanage::loginpage', compact('page'));
    }


    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $page = LoginPage::first();
        foreach ((array)$request->title as $key => $title) {
            $page->setTranslation('title', $key, $title);
        }

        foreach ((array)$request->slogan1 as $key => $slogans1) {
            $page->setTranslation('slogans1', $key, $slogans1);
        }

        foreach ((array)$request->slogan2 as $key => $slogans2) {
            $page->setTranslation('slogans2', $key, $slogans2);
        }

        foreach ((array)$request->slogan3 as $key => $slogan3) {
            $page->setTranslation('slogans3', $key, $slogan3);
        }

        foreach ((array)$request->reg_title as $key => $reg_title) {
            $page->setTranslation('reg_title', $key, $reg_title);
        }

        foreach ((array)$request->reg_slogan1 as $key => $slogans1) {
            $page->setTranslation('reg_slogans1', $key, $slogans1);
        }

        foreach ((array)$request->reg_slogan2 as $key => $slogans2) {
            $page->setTranslation('reg_slogans2', $key, $slogans2);
        }

        foreach ((array)$request->reg_slogan3 as $key => $slogan3) {
            $page->setTranslation('reg_slogans3', $key, $slogan3);
        }


        foreach ((array)$request->forget_title as $key => $forget_title) {
            $page->setTranslation('forget_title', $key, $forget_title);
        }

        foreach ((array)$request->forget_slogan1 as $key => $slogans1) {
            $page->setTranslation('forget_slogans1', $key, $slogans1);
        }

        foreach ((array)$request->forget_slogan2 as $key => $slogans2) {
            $page->setTranslation('forget_slogans2', $key, $slogans2);
        }

        foreach ((array)$request->forget_slogan3 as $key => $slogan3) {
            $page->setTranslation('forget_slogans3', $key, $slogan3);
        }
        $page->banner = null;
        $page->reg_banner = null;
        $page->forget_banner = null;
        $page->save();

        $this->removeLink($page->id, get_class($page));

        if ($request->banner) {
            $page->banner = $this->generateLink($request->banner, $page->id, get_class($page), 'banner');
        }
        if ($request->reg_banner) {
            $page->reg_banner = $this->generateLink($request->reg_banner, $page->id, get_class($page), 'reg_banner');
        }
        if ($request->forget_banner) {
            $page->forget_banner = $this->generateLink($request->forget_banner, $page->id, get_class($page), 'forget_banner');
        }
        $page->save();

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }


}
