<?php

namespace App\Http\Controllers\Api\V2\Course;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Course\DripRepositoryInterface;
use Illuminate\Http\Request;

class DripController extends Controller
{
    public function __construct(private DripRepositoryInterface $drip)
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ?int $id):object
    {
        return response()->json([
            'success' => true,
            'data' => $this->drip->index($request, $id),
            'message' => trans('api.Getting drip content list successfully')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ?int $id)
    {
        $this->drip->update($request, $id);
        return response()->json([
            'success' => true,
            'message' => trans('api.Drip content updated successfully'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
