<?php

namespace Modules\Quiz\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\AdvanceQuiz\Http\Controllers\AdvanceQuizGroupController;
use Modules\Quiz\Entities\QuestionGroup;

class QuizController extends Controller
{
    public function index()
    {
        try {
            if (isModuleActive('AdvanceQuiz')) {
                $AdvanceQuizGroupController = new AdvanceQuizGroupController();
                return $AdvanceQuizGroupController->index();
            } else {
                $query = QuestionGroup::query();
                if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                    $query->whereHas('user', function ($q) {
                        $q->where('organization_id', Auth::id());
                        $q->orWhere('user_id', Auth::id());
                    });
                }
                $groups = $query->latest()->get();
                return view('quiz::index', compact('groups'));
            }

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function store(Request $request)
    {
        if (isModuleActive('AdvanceQuiz')) {
            $rules = [
                'title' => ['required', Rule::unique('question_groups', 'title')->when(isModuleActive('LmsSaas'), function ($q) {
                    return $q->where('lms_id', app('institute')->id);
                })],
                'code' => 'required|unique:question_groups',
                'parent_id' => 'nullable'
            ];
        } else {
            $rules = [
                'title' => 'required',
            ];
        }

        $this->validate($request, $rules, validationMessage($rules));

        try {
            if (isModuleActive('AdvanceQuiz')) {
                $AdvanceQuizGroupController = new AdvanceQuizGroupController();
                $result = $AdvanceQuizGroupController->createOrUpdate($request);
            } else {
                $group = new QuestionGroup();
                $group->title = $request->title;
                $group->user_id = Auth::id();
                $result = $group->save();
            }

            if ($result) {
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            } else {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function show($id)
    {
        if (isModuleActive('AdvanceQuiz')) {
            return redirect('quiz/question-group');
        }
        try {
            $user = Auth::user();
            $group = QuestionGroup::find($id);
            $query = QuestionGroup::where('active_status', 1);
            if (isModuleActive('Organization') && $user->isOrganization()) {
                $query->whereHas('user', function ($q) {
                    $q->where('organization_id', Auth::id());
                    $q->orWhere('user_id', Auth::id());
                });
            }
            $groups = $query->latest()->get();
            return view('quiz::index', compact('groups', 'group'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function update(Request $request, $id)
    {

        $rules = [
            'title' => ['required'],
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            if (isModuleActive('AdvanceQuiz')) {
                $AdvanceQuizGroupController = new AdvanceQuizGroupController();
                $result = $AdvanceQuizGroupController->createOrUpdate($request, $request->id);
            } else {
                $group = QuestionGroup::find($request->id);
                $group->title = $request->title;
                $result = $group->save();
            }
            if ($result) {
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect('quiz/question-group');
            } else {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function destroy($id)
    {
        if (demoCheckById($id,[1,2,3])) {
            return redirect()->back();
        }

        try {
            if (isModuleActive('AdvanceQuiz')) {
                $group = QuestionGroup::findOrFail($id);
                $childs = $group->getAllChildIds($group);
                $group->delete();
                foreach ($childs as $child) {
                    $b = QuestionGroup::where('id', $child)->first();
                    $b->delete();
                }
            } else {
                $group = QuestionGroup::destroy($id);
            }

            if ($group) {
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect('quiz/question-group');
            } else {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
