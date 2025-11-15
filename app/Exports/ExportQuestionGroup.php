<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Modules\Quiz\Entities\QuestionGroup;

class ExportQuestionGroup implements FromView
{

    public function view(): View
    {
        $user = Auth::user();
        if ($user->role_id == 2) {
            $groups = QuestionGroup::where('user_id', $user->id)->latest()->get();
        } else {
            $groups = QuestionGroup::latest()->get();
        }
        return view('quiz::exports.groups', [
            'groups' => $groups
        ]);
    }
}
