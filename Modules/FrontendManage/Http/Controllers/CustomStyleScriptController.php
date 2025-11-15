<?php

namespace Modules\FrontendManage\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

class CustomStyleScriptController extends Controller
{
    public $css_path, $js_path;

    public function __construct()
    {
        $this->css_path = 'public/frontend/' . currentTheme() . '/css/custom.css';
        $this->js_path = 'public/frontend/' . currentTheme() . '/js/custom.js';
    }

    public function index()
    {


        if (!File::exists($this->css_path)) {
            File::put($this->css_path, "");
        }
        if (!File::exists($this->js_path)) {
            File::put($this->js_path, "");
        }
        $css = File::get($this->css_path);
        $js = File::get($this->js_path);
        return view('frontendmanage::custom-css-js', compact('css', 'js'));
    }

    public function store(Request $request)
    {
        if (demoCheckById(1,[1])) {
            return redirect()->back();
        }
        try {
            if ($request->type == 'css') {
                File::put($this->css_path, $request->data);
            }
            if ($request->type == 'js') {
                File::put($this->js_path, $request->data);
            }
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

}
