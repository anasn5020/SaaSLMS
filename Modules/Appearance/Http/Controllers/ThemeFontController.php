<?php

namespace Modules\Appearance\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class ThemeFontController extends Controller
{

    public function index()
    {
        $fonts = $this->getGoogleFonts();
        return view('appearance::font.index', compact('fonts'));
    }


    public function create()
    {
        return view('appearance::create');
    }

    public function store(Request $request)
    {
        $items = $request->except('_token');
        foreach ($items as $key => $item) {
            UpdateGeneralSetting($key, $item);
        }
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();

    }

    private function getGoogleFonts()
    {
        $response = Http::get('https://www.googleapis.com/webfonts/v1/webfonts', [
            'key' => Settings('google_font_key')
        ]);

        if ($response->successful()) {
            return collect($response->json('items'))->pluck('family')->toArray();
        }

        return [];
    }

}
