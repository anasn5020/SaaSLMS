<?php

namespace Modules\FrontendManage\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\UploadMedia;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Modules\FrontendManage\Entities\Sponsor;

class SponsorController extends Controller
{
    use UploadMedia;

    public function index()
    {
        try {
            $sponsors = Sponsor::latest()->get();
            return view('frontendmanage::sponsors', compact('sponsors'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function create()
    {
        return view('frontendmanage::create');
    }

    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $code = auth()->user()->language_code;

        $rules = [
            'title.' . $code => 'required|max:255',
            'image' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {
            $sponsor = new Sponsor();
            foreach ($request->title as $key => $title) {
                $sponsor->setTranslation('title', $key, $title);
            }
            $sponsor->save();

            if ($request->image) {
                $sponsor->image = $this->generateLink($request->image, $sponsor->id, get_class($sponsor), 'image');
            }
            $sponsor->save();

            Toastr::success(trans('sponsor.Sponsor Saved Successfully'));
            return back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function show($id)
    {
        return view('frontendmanage::show');
    }

    public function edit($id)
    {
        try {
            $sponsors = Sponsor::latest()->get();

            $sponsor = Sponsor::findOrFail($id);
            return view('frontendmanage::sponsors', compact('sponsors', 'sponsor'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function update(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $code = auth()->user()->language_code;

        $rules = [
            'title.' . $code => 'required|unique:sponsors,title,' . $request->id,

        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $sponsor = Sponsor::find($request->id);
            foreach ($request->title as $key => $title) {
                $sponsor->setTranslation('title', $key, $title);
            }
            $sponsor->image = null;
            $sponsor->save();
            $this->removeLink($sponsor->id, get_class($sponsor));
            if ($request->image) {
                $sponsor->image = $this->generateLink($request->image, $sponsor->id, get_class($sponsor), 'image');
            }
            $sponsor->save();
            Toastr::success(trans('sponsor.Sponsor Updated Successfully'));
            return redirect()->route('frontend.sponsors.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function destroy($id)
    {
        if (demoCheckById($id,range(1,6))) {
            return redirect()->back();
        }
        try {
            Sponsor::destroy($id);
            Toastr::success(trans('sponsor.Sponsor Deleted Successfully'));
            return redirect()->route('frontend.sponsors.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
