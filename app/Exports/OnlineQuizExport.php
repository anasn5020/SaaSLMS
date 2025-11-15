<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Contracts\View\View;
use Modules\Quiz\Entities\OnlineQuiz;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OnlineQuizExport implements FromView, WithStyles
{

    public function view(): View
    {
        $user = Auth::user();
        if ($user->role_id == 2) {
            $online_exams = OnlineQuiz::latest()->get();
        } else {
            $online_exams = OnlineQuiz::where('created_by', $user->id)->latest()->get();
        }
        return view('advancequiz::exports.all_quiz', [
            'online_exams' => $online_exams
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
