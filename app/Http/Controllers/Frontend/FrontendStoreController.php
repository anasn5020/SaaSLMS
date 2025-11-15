<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\FrontendManage\Entities\FrontPage;

class FrontendStoreController extends Controller
{
    public function products(Request $request)
    {
        try {
            if (hasDynamicPage()) {
                $row = FrontPage::where('slug', '/store')->first();
                $details = dynamicContentAppend($row->details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                return view(theme('pages.products'), compact('request'));
            }

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
