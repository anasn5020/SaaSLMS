<?php

namespace App\Http\Controllers\Api\V2\VirtualClass;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ZoomRepositoryInterface;

class ZoomController extends Controller
{
    private $zoomRepository;

    public function __construct(ZoomRepositoryInterface $zoomRepository)
    {
        $this->zoomRepository = $zoomRepository;
    }

    public function configure(Request $request): object
    {
        $rules = [
            'zoom_account_id'       => 'required',
            'zoom_client_id'        => 'required',
            'zoom_client_secret'    => 'required',
        ];
        $request->validate($rules, validationMessage($rules));

        $this->zoomRepository->configure($request);

        return response()->json([
            'success'   => true,
            'message'   => trans('api.Zoom configured successfully')
        ]);
    }

    public function settings(Request $request): object
    {
        $this->zoomRepository->settings($request);

        return response()->json([
            'success'   => true,
            'message'   => trans('api.Zoom configured successfully')
        ]);
    }

    public function getConfigSetting(): object
    {
        return response()->json([
            'success'   => true,
            'data'      => $this->zoomRepository->getConfigSetting(),
            'message'   => trans('api.Getting zoom settings'),
        ]);
    }

    public function approvelTypes(): object
    {
        return response()->json([
            'success'   => true,
            'data'      => $this->zoomRepository->approvelTypes(),
            'message'   => trans('api.Getting zoom approval type list')
        ]);
    }

    public function autoRecordings(): object
    {
        return response()->json([
            'success'   => true,
            'data'      => $this->zoomRepository->autoRecordings(),
            'message'   => trans('api.Getting zoom auto recording list')
        ]);
    }

    public function audios(): object
    {
        return response()->json([
            'success'   => true,
            'data'      => $this->zoomRepository->audios(),
            'message'   => trans('api.Getting zoom audio option list')
        ]);
    }

    public function packages(): object
    {
        return response()->json([
            'success'   => true,
            'data'      => $this->zoomRepository->packages(),
            'message'   => trans('api.Getting zoom package list')
        ]);
    }
}
