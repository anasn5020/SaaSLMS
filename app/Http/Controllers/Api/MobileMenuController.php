<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Modules\Org\Entities\MobileMenu;

class MobileMenuController extends Controller
{
    public function __construct()
    {
        config(['auth.defaults.guard' => 'api']);
    }

    public function mobileMenus()
    {
        $data = MobileMenu::where('status', 1)->select('id', 'name', 'position')->orderBy('position')->get();
        if ($data) {
            $response = [
                'success' => true,
                'data' => $data,
                'total' => count($data),
                'message' => 'Getting Mobile Menu Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Menu Found',
            ];
        }
        return response()->json($response, 200);
    }


}
