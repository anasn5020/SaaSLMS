<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function ($table) {
            if (!Schema::hasColumn('courses', 'price_text')) {
                $table->string('price_text')->nullable();
            }
        });
    }
    public function down(): void
    {
        //
    }
};
