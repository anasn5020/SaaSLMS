<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!isModuleActive('Org')) {
            $users = User::get();
            foreach ($users as $user) {
                $user->username = $this->generateUniqueProfileUrl($user->name, $users);
                $user->save();
            }
        }

    }

    public function generateUniqueProfileUrl($name, $users)
    {
        $profileUrl = Str::slug($name);
        $count = 2;
        while ($users->where('username', $profileUrl)->first()) {
            $profileUrl = Str::slug($name) . '-' . $count;
            $count++;
        }

        return $profileUrl;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
