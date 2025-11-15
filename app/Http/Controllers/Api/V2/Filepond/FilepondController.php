<?php

namespace App\Http\Controllers\Api\V2\Filepond;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\FilepondRepositoryInterface;
use Illuminate\Http\Request;

class FilepondController extends Controller
{
    /**
     * __construct
     *
     * @param  mixed $filepond
     * @return void
     */
    public function __construct(private FilepondRepositoryInterface $filepond)
    {
        //
    }
    /**
     * load
     *
     * @param  mixed $request
     * @return object
     */
    public function load(Request $request): object
    {
        return response()->json($this->filepond->load($request));
    }
    /**
     * upload
     *
     * @param  mixed $request
     * @return object
     */
    public function upload(Request $request): object
    {
        return response()->json([
            'success' => true,
            'data' => $this->filepond->upload($request),
            'message' => trans('api.Server ID generated successfully'),
        ]);
    }
    /**
     * chunk
     *
     * @param  mixed $request
     * @return mixed
     */
    public function chunk(Request $request): mixed
    {
        if ($this->filepond->chunk($request)) {
            return response()->json(['success' => true], 204);
        } else {
            return http_response_code(400);
        }
    }
    public function delete(Request $request): object
    {
        if ($this->filepond->delete($request)) {
            return response()->json(['success' => true]);
        } else {
            return response()->json();
        }
    }
}
