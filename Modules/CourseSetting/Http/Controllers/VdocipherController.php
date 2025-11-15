<?php

namespace Modules\CourseSetting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VdocipherController extends Controller
{
    public function getAllVdocipherData(Request $request)
    {
        try {
            $curl = curl_init();

            $header = array(
                "Accept: application/json",
                "Authorization:Apisecret " . saasEnv('VDOCIPHER_API_SECRET'),
                "Content-Type: application/json"
            );
            if ($request->page) {
                $page = $request->page;
            } else {
                $page = 1;
            }

            if ($request->search) {
                $search = $request->search;
            } else {
                $search = '';
            }

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://dev.vdocipher.com/api/videos?page=" . $page . "&limit=20&q=" . $search,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => $header,
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            if ($err) {
                return [];
            } else {
                $items = json_decode($response)->rows;
                $response = [];
                foreach ($items as $item) {
                    $response[] = [
                        'id' => $item->id,
                        'text' => $item->title
                    ];
                }
                $data['results'] = $response;
                $data['pagination'] = ["more" => count($response) != 0 ? true : false];
                return response()->json($data);
            }
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getSingleVdocipherData($id)
    {
        try {
            $curl = curl_init();

            $header = array(
                "Accept: application/json",
                "Authorization:Apisecret " . saasEnv('VDOCIPHER_API_SECRET'),
                "Content-Type: application/json"
            );

//            &q=array
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://dev.vdocipher.com/api/videos/" . $id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => $header,
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            if ($err) {
                return null;
            } else {
                $item = json_decode($response);

                return response()->json($item);
            }
        } catch (\Exception $e) {
            return null;
        }
    }
}
