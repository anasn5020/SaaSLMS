<?php

namespace Modules\CourseSetting\Http\Controllers;

use App\Events\NewNotification;
use App\Events\QuestionAnswerEvent;
use App\Http\Controllers\Controller;
use App\Traits\SendNotification;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\CourseSetting\Entities\LessonQuestion;
use Modules\RolePermission\Entities\Role;
use Yajra\DataTables\DataTables;

class QuestionAnswerController extends Controller
{
    use SendNotification;

    public function index()
    {
        return view('coursesetting::qa.index');
    }

    public function data(Request $request)
    {
        $query = LessonQuestion::whereHas('user', function ($q) {
            $q->where('role_id', 3);
        })->with('course')->with('course', 'lesson', 'user', 'child')->latest();
//        $query->select('lesson_questions.*');
         return Datatables::of($query)
            ->addIndexColumn()
            ->editColumn('course_id', function ($query) {
                return $query->course?->title;
            })
            ->editColumn('lesson_id', function ($query) {
                return $query->lesson?->name;
            })
            ->editColumn('user_id', function ($query) {
                return $query->user?->name;
            })
            ->editColumn('text', function ($query) {
                return Str::limit(strip_tags($query->text), 50);
            })
            ->addColumn('total_replies', function ($query) {
                return $query->replied == 1 ? trans('common.Yes') : trans('common.No');
            })->addColumn('reserved', function ($query) {
                $id = $query->id;
                if ($query->parent_id) {
                    $id = $query->parent_id;
                }
                $typing = Cache::get('question_answer_' . $id);
                if ($typing && Auth::id() == $typing->id) {
                    $typing = null;
                }
                return $typing ? trans('common.Yes') : trans('common.No');
            })
            ->addColumn('status', function ($query) {
                return view('coursesetting::qa.components._status_td', ['query' => $query]);
            })
            ->addColumn('action', function ($query) {
                return view('coursesetting::qa.components._action_td', ['query' => $query]);
            })
            ->rawColumns(['status', 'action'])
            ->make();
    }

    public function show($id)
    {

        $question = LessonQuestion::findOrFail($id);
        $typing = Cache::get('question_answer_' . $id);
        if ($typing && Auth::id() == $typing->id) {
            $typing = null;
        }
        return view('coursesetting::qa.show', compact('question', 'typing'));
    }

    public function edit($id)
    {
        $question = LessonQuestion::findOrFail($id);
        return view('coursesetting::qa.edit', compact('question'));
    }

    public function update($id, Request $request)
    {
        $rules = [
            'text' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        $question = LessonQuestion::findOrFail($id);
        $question->text = $request->text;
        $question->save();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->route('qa.questions');
    }

    public function reply($id, Request $request)
    {
        $rules = [
            'text' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        $parent = LessonQuestion::findOrFail($id);

        $lastQus = LessonQuestion::query()
            ->where('course_id', $parent->course_id)
            ->where('lesson_id', $parent->lesson_id)
            ->latest()
            ->first();
        if ($lastQus) {
            $lastQus->replied = 1;
            $lastQus->save();
        }
        $question = LessonQuestion::create([
            'text' => $request->text,
            'parent_id' => $parent->id,
            'course_id' => $parent->course_id,
            'lesson_id' => $parent->lesson_id,
            'status' => 1,
            'user_id' => auth()->id()
        ]);


        if (Auth::user()->role_id != 3) {
            $lesson_url = route('myQA.show', $parent->id);
            $user = $parent->user;
            $this->sendNotification('New_Question_Reply', $user, [
                'name' => $user->name,
                'question' => $parent->text,
                'reply' => $question->text,
                'date_time' => Carbon::now()->format('d-M-Y, g:i A'),
            ], [
                'actionText' => trans('common.View'),
                'actionUrl' => $lesson_url,
            ]);

        } else {
            $lesson_url = route('qa.questions.show', [$parent->id]);
            $users = User::select(['id', 'name', 'email', 'role_id'])->whereIn('role_id', [1, Settings('assign_question_answerers_role')])->get();
            foreach ($users as $user) {
                $this->sendNotification('New_Question_Reply', $user, [
                    'name' => $user->name,
                    'question' => $parent->text,
                    'reply' => $question->text,
                    'date_time' => Carbon::now()->format('d-M-Y, g:i A'),
                ], [
                    'actionText' => trans('common.View'),
                    'actionUrl' => $lesson_url,
                ]);
            }
        }

        if (Settings('real_time_qa_update') == 1) {
            $user = auth()->user();
            event(new QuestionAnswerEvent([
                'id' => $parent->id,
                'img' => getProfileImage($user->image, $user->name),
                'name' => $user->name,
                'date' => showDate(date('Y-m-d H:i:s')),
                'text' => $request->text
            ], [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id
            ]));
            event(new NewNotification('Reply', 'Question/Reply Submit', '#', $parent->user_id));

        }

        Cache::forget('question_answer_' . $request->question_id);

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function delete($id)
    {
        $question = LessonQuestion::findOrFail($id);
        $question->delete();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->route('qa.questions');
    }


    public function setting()
    {
        $roles = Role::select('id', 'name')->whereNotIn('id', [1, 2, 3])->get();
        return view('coursesetting::qa.setting', compact('roles'));
    }

    public function settingUpdate(Request $request)
    {

        UpdateGeneralSetting('assign_question_answerers_role', $request->get('assign_question_answerers_role', 0));
        UpdateGeneralSetting('real_time_qa_update', $request->get('real_time_qa_update', 0));

        putEnvConfigration('PUSHER_APP_ID', $request->get('pusher_app_id'));
        putEnvConfigration('PUSHER_APP_KEY', $request->get('pusher_app_key'));
        putEnvConfigration('PUSHER_APP_SECRET', $request->get('pusher_app_secret'));
        putEnvConfigration('PUSHER_APP_CLUSTER', $request->get('pusher_app_cluster'));


        if ($request->get('assign_question_answerers_role', 0)){
            //New_Question_Reply
            DB::table('role_email_templates')
                ->where('template_act', 'New_Question_Reply')
                ->where('role_id', 3,)
                ->updateOrInsert([
                    'template_act' => 'New_Question_Reply',
                    'role_id' => 3,
                    'status' => 1,
                ]);
            //admin and other roles
            $roles = [1, Settings('assign_question_answerers_role')];
            foreach ($roles as $role) {
                DB::table('role_email_templates')
                    ->where('template_act', 'New_Question')
                    ->where('role_id', $role)
                    ->updateOrInsert([
                        'template_act' => 'New_Question',
                        'role_id' => $role,
                        'status' => 1,
                    ]);
            }
        }



        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function checkOnline(Request $request)
    {
        $user = \App\User::select(['id', 'name', 'role_id', 'image'])->where('id', \request()->get('user_id'))->first();
        event(new NewNotification('Reply', 'Question/Reply Submit', '#', $user->id));
        return Cache::put('question_answer_' . $request->question_id, $user);
    }

    public function exitOnline(Request $request)
    {
        try {
            Cache::forget('question_answer_' . $request->question_id);
            $question = LessonQuestion::find($request->question_id);
            event(new NewNotification('Reply', 'Question/Reply Submit', '#', $question->user_id));
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
}
//lesson
