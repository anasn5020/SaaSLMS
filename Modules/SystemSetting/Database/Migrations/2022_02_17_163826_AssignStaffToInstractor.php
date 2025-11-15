<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AssignStaffToInstractor extends Migration
{

    public function up()
    {
        $users = DB::table('users')->select('id')->whereNotIn('role_id', [1, 3])->get();
        foreach ($users as $user) {
            $check = DB::table('staffs')->where('user_id', $user->id)->first();
            if ($check) {
                DB::table('staffs')->insert([
                    'user_id' => $user->id
                ]);
            }
        }
    }

    public function down()
    {
        //
    }
}
