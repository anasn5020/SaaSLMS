<?php

namespace App\Exports;

use App\Country;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Modules\Quiz\Entities\QuestionBank;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuestionBankExport implements FromView, WithStyles, WithColumnWidths
{
    public function view(): View
    {
        $user = Auth::user();


        if ($user->role_id == 2) {
            $queries = QuestionBank::latest()->select('question_banks.*')->where('question_banks.active_status', 1)->with('category', 'subCategory', 'questionGroup')->where('question_banks.user_id', $user->id);
        } else {
            $queries = QuestionBank::latest()->select('question_banks.*')->where('question_banks.active_status', 1)->with('category', 'subCategory', 'questionGroup');
        }
        $banks = $queries->get();
        return view('advancequiz::exports.all_question_banks', [
            'banks' => $banks
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,
            'C' => 50,
            'D' => 20,
        ];
    }
}
