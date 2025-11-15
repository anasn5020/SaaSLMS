<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class ChangeTitleLimitOnQuizQuestionOptionTitle extends Migration
{
    public function up()
    {
        try {
            DB::statement('ALTER TABLE `question_bank_mu_options` CHANGE `title` `title` TEXT  NULL DEFAULT NULL;');
        } catch (\Exception $e) {
        }
    }

    public function down()
    {
        //
    }
}
