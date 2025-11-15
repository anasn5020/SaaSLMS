<?php

namespace Modules\Quiz\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Quiz\Entities\OnlineExamQuestionAssign;
use Modules\Quiz\Entities\OnlineQuiz;

class QuestionAssignTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for ($i = 1; $i <= 5; $i++) {
            OnlineExamQuestionAssign::insert([
                'online_exam_id' => 1,
                'question_bank_id' => $i,
            ]);
        }
        for ($i = 6; $i <= 10; $i++) {
            OnlineExamQuestionAssign::insert([
                'online_exam_id' => 2,
                'question_bank_id' => $i,
            ]);
        }
        for ($i = 11; $i <= 15; $i++) {
            OnlineExamQuestionAssign::insert([
                'online_exam_id' => 3,
                'question_bank_id' => $i,
            ]);
        }

        $quizzes = OnlineQuiz::all();
        foreach ($quizzes as $quiz) {
            $quiz->total_marks = $quiz->totalMarks() ?? 0;
            $quiz->total_questions = $quiz->totalQuestions() ?? 0;
            $quiz->save();
        }
    }
}
