<?php

namespace Modules\PopupContent\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\UploadMedia;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Modules\PopupContent\Entities\PopupContent;

class PopupContentController extends Controller
{
    use UploadMedia;
    use ValidatesRequests;

    public function index()
    {
        try {
            $popup = PopupContent::getData();
            return view('popupcontent::popup_content.index', compact('popup'));

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function update(Request $request)
    {
        $popup = PopupContent::firstOrFail();

        if (demoCheckById($popup->id,range(1,1))) {
            return redirect()->back();
        }
        try {

            $popup->title = $request->title;
            $popup->btn_txt = $request->btn_txt;
            $popup->link = $request->link;
            $popup->status = (int)$request->status;
            $popup->message = $request->message;
            $popup->image = null;
            $popup->save();


            $this->removeLink($popup->id, get_class($popup));
            if ($request->image) {
                $popup->image = $this->generateLink($request->image, $popup->id, get_class($popup), 'image');
            }
            $popup->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));

            return back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }

    }
}
