<?php

namespace App\Http\Controllers\Api\V2\Communication;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ConversationRepositoryInterface;

class ConversationController extends Controller
{
    private $converstionRepository;

    public function __construct(ConversationRepositoryInterface $converstionRepository)
    {
        $this->converstionRepository = $converstionRepository;
    }
    public function list(Request $request): object
    {
        return response()->json([
            'success'   => true,
            'data'      => $this->converstionRepository->list($request),
            'message'   => trans('api.Operation successful')
        ]);
    }

    public function contactList(Request $request): object
    {
        return response()->json([
            'success'   => true,
            'data'      => $this->converstionRepository->contactList($request),
            'message'   => trans('api.Operation successful')
        ]);
    }
    public function messages(Request $request): object
    {
        $rules = [
            'opponent_id' => 'required|exists_in_columns:messages,reciever_id,sender_id'
        ];
        $request->validate($rules, validationMessage($rules));

        return response()->json([
            'success'   => true,
            'data'      => $this->converstionRepository->messages($request),
            'message'   => trans('api.Operation successful')
        ]);
    }

    public function storeMessage(Request $request): object
    {
        $rules = [
            'opponent_id'   => 'required|exists:users,id',
            'message'       => 'required|string'
        ];
        $request->validate($rules, validationMessage($rules));

        return response()->json([
            'success'   => true,
            'data'      => $this->converstionRepository->storeMessage($request),
            'message'   => trans('api.Operation successful')
        ]);
    }
}
