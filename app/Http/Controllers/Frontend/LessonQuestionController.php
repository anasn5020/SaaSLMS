<?php

namespace App\Http\Controllers\Frontend;


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
use Illuminate\Support\Str;
use Modules\CourseSetting\Entities\LessonQuestion;
use Yajra\DataTables\DataTables;

class LessonQuestionController extends Controller
{
    use SendNotification;

    public function __construct()
    {
        $this->middleware(['maintenanceMode', 'onlyAppMode']);
    }

    public function index()
    {
        try {
            return view(theme('pages.my_qa'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function indexData(Request $request)
    {
        $query = LessonQuestion::where('user_id', Auth::id())->where('parent_id', 0)->with(['course', 'lesson'])->withCount('child')->latest()->select('lesson_questions.*');
        return Datatables::of($query)
            ->addIndexColumn()
            ->editColumn('course_id', function ($query) {
                return $query->course->title;
            })
            ->editColumn('lesson_id', function ($query) {
                return $query->lesson->name;
            })
            ->editColumn('user_id', function ($query) {
                return $query->user->name;
            })
            ->editColumn('text', function ($query) {
                return Str::limit(strip_tags($query->text), 50);
            })
            ->addColumn('total_replies', function ($query) {
                return $query->replied == 1 ? trans('common.Yes') : trans('common.No');
            })->addColumn('reserved', function ($query) {
                $typing = Cache::get('question_answer_' . $query->id);
                return $typing ? trans('common.Yes') : trans('common.No');
            })
            ->addColumn('action', function ($question) {
                return '  <div class="dropdown">
                                                                      <button class="btn btn-secondary dropdown-toggle"
                                                                              type="button"
                                                                              id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                                              aria-haspopup="true" aria-expanded="false">
                                                                        ' . __("common.Action") . '
                                                                      </button>
                                                                      <div class="dropdown-menu"
                                                                           aria-labelledby="dropdownMenuButton">

                                                                          <a target="_blank"
                                                                             href="' . route('fullScreenView', [$question->course_id, $question->lesson_id]) . '"
                                                                             class="dropdown-item">
                                                                             ' . trans('common.View') . ' ' . trans('courses.Lesson') . '
                                                                          </a>
                                                                          <a class="dropdown-item"
                                                                             href="' . route('myQA.show', $question->id) . '">' . __("common.View") . ' ' . __("common.Details") . '</a>
                                                                          <a class="dropdown-item"
                                                                             href="' . route('myQA.edit', $question->id) . '">' . __("common.Edit") . '</a>
                                                                          <a class="dropdown-item"
                                                                             href="' . route('myQA.delete', $question->id) . '">' . __("common.Delete") . '</a>
                                                                      </div>
                                                                  </div>';
            })
            ->rawColumns(['action'])
            ->make();

    }

    public function loadQna($course_id, $lesson_id)
    {
        $data['lesson_questions'] = LessonQuestion::where('lesson_id', $lesson_id)->where('course_id', $course_id)->where('parent_id', 0)->where('status', 1)->with(['course', 'lesson', 'user'])->get();
        return view(theme('partials._qna_list'), $data);
    }

    public function store(Request $request)
    {

        $rules = [
            'course_id' => 'required',
            'lesson_id' => 'required',
            'text' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        $question = new LessonQuestion();
        $question->course_id = $request->course_id;
        $question->lesson_id = $request->lesson_id;
        $question->user_id = Auth::id();
        $question->text = $request->text;
        $question->parent_id = (int)$request->parent_id;
        $question->status = 0;

        $question->save();


        $lesson_url = route('qa.questions.show', [$question->id]);
        $users = User::select(['id', 'name', 'email', 'role_id'])->whereIn('role_id', [1, Settings('assign_question_answerers_role')])->get();
        foreach ($users as $user) {
            $this->sendNotification('New_Question', $user, [
                'name' => $user->name,
                'question' => $question->text,
                'date_time' => Carbon::now()->translatedFormat('d-M-Y, g:i A'),
            ], [
                'actionText' => trans('common.View'),
                'actionUrl' => $lesson_url,
            ]);
        }
        if (Settings('real_time_qa_update') == 1) {
            event(new QuestionAnswerEvent([
                'id' => $question->parent_id,
                'img' => getProfileImage(auth()->user()->image, auth()->user()->name),
                'name' => auth()->user()->name,
                'date' => showDate(date('Y-m-d H:i:s')),
                'text' => $request->text
            ], null));

            event(new NewNotification('QNA', 'Question/Reply Submit', '#'));
        }

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function edit($id)
    {
        $question = LessonQuestion::where('user_id', Auth::id())->findOrFail($id);
        return view(theme('pages.edit_qa'), compact('question'));
    }

    public function update($id, Request $request)
    {
        $rules = [
            'text' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));
        $question = LessonQuestion::where('user_id', Auth::id())->findOrFail($id);
        $question->text = $request->text;
        $question->save();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->route('myQA');
    }

    public function delete($id)
    {
        $question = LessonQuestion::where('user_id', Auth::id())->findOrFail($id);
        $question->delete();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->route('myQA');
    }

    public function show($id)
    {
        $question = LessonQuestion::where('user_id', Auth::id())->findOrFail($id);
        return view(theme('pages.show_qa'), compact('question'));
    }


}
