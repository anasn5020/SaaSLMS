<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\CourseSetting\Entities\CourseComment;
use Modules\SystemSetting\Entities\Message;

class CommunicationController extends Controller
{
    public function QuestionAnswer()
    {
        $comments = CourseComment::where('instructor_id', Auth::id())->with('course', 'replies', 'user')->paginate(10);
        return view('backend.communication.question_answer', compact('comments'));
    }

    public function PrivateMessage()
    {
        $query = User::query();


        if (isModuleActive('Organization')) {
            if (Auth::user()->role_id == 1) {
                $query->where('id', '!=', Auth::id())->whereIn('role_id', [2, 5]);
            } elseif (Auth::user()->role_id == 5) {
                $query->where('id', '!=', Auth::id())->where('organization_id', Auth::id());
            } else {
                $query->where('id', '!=', Auth::id())->where(function ($q) {
                    $q->where('role_id', 1)->orWhereHas('enrollStudents');
                })->get();
            }

        } else {
            if (Auth::user()->role_id == 1) {
                $query->where('id', '!=', Auth::id())->where('role_id', 2);
            } else {
                $query->where('id', '!=', Auth::id())->where(function ($query) {
                    $query->where('role_id', 1)->orWhereHas('enrollStudents');
                });
            }

        }


        $users = $query->select('id', 'name', 'image')->with(['sentLastMessages', 'receivedLastMessages'])
            ->get()
            ->sortByDesc(fn($user) => $user->lastMessage()->created_at??"");
        ;

        return view('backend.communication.private_messages', compact('users'));
    }


    public function StorePrivateMessage(Request $request)
    {
        if (demoCheck()) {
            return false;
        }

        $rules = [
            'message' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {

            $message = new Message;
            $message->sender_id = Auth::id();
            $message->reciever_id = (int)$request->reciever_id;
            $message->message = $request->message;
            $message->type = Auth::id() == 1 ? 1 : 0;
            $message->seen = 0;
            $message->save();


            Toastr::success(trans('frontend.Message has been send successfully'), trans('common.Success'));

            $messages = Message::whereIn('reciever_id', [Auth::id(), (int)$request->reciever_id])
                ->whereIn('sender_id', [Auth::id(), (int)$request->reciever_id])
                ->with('sender')
                ->get();

            $output = getConversations($messages);

            return response()->json($output);

        } catch (\Exception $e) {
            return '';
        }
    }


    public function getMessage(Request $request)
    {
        try {
            $receiver_id = (int)$request->id;
            $messages = Message::whereIn('reciever_id', [Auth::id(), $receiver_id])
                ->whereIn('sender_id', [Auth::id(), $receiver_id])
                ->with('sender')->get();
            $output = getConversations($messages);
            Message::where('seen', '=', 0)->where('sender_id', $receiver_id)->where('reciever_id', Auth::id())->update(['seen' => 1]);
            $data['messages'] = $output;
            $receiver = User::find($receiver_id);
            $data['receiver_name'] = $receiver->name;
            $data['avatar'] = url('public/' . $receiver->image);
            return response()->json($data);

        } catch (\Exception $e) {

            Log::info($e);
            return response()->json(['error' => 'error']);
        }
    }


}
