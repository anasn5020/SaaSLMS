<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Routing\Controller;

class BlogSettingController extends Controller
{
    public function index()
    {
        return view('blog::setting');
    }
}
