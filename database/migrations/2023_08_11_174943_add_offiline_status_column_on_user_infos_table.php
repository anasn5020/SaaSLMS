<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_infos', function (Blueprint $table) {
            if (!Schema::hasColumn("user_infos", 'offline_status')) {
                $table->boolean('offline_status')->default(false);
            }
            if (!Schema::hasColumn("user_infos", 'offline_message')) {
                $table->string('offline_message', 500)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_infos', function (Blueprint $table) {
            if (Schema::hasColumn("user_infos", 'offline_status')) {
                $table->dropColumn('offline_status');
            }
            if (Schema::hasColumn("user_infos", 'offline_message')) {
                $table->dropColumn('offline_message');
            }
        });
    }
};
