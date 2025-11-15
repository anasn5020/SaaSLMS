<?php

namespace App\Exports;

use Modules\Quiz\Entities\QuizTest;
use Modules\Quiz\Http\Controllers\OnlineQuizController;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Contracts\View\View;

class OnlineQuizReport implements FromView, WithStyles
{
    public function view(): View
    {
        $quizController =new OnlineQuizController();
        $quiz = $quizController->query()->get();
        return view('quiz::exports.quiz-report', [
            'quizzes' => $quiz
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
