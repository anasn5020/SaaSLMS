<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_permission', function (Blueprint $table) {
            $table->id();
            $table->integer('permission_id')->nullable();
            $table->integer('role_id')->nullable()->unsigned();
            $table->boolean('status')->default(1);
            $table->integer('created_by')->default(1)->unsigned();
            $table->integer('updated_by')->default(1)->unsigned();
            $table->timestamps();

        });

        DB::table('role_permission')->insert(
            array(
                0 =>
                    array(
                        'permission_id' => 1,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                1 =>
                    array(
                        'permission_id' => 274,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                2 =>
                    array(
                        'permission_id' => 275,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                3 =>
                    array(
                        'permission_id' => 276,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                4 =>
                    array(
                        'permission_id' => 277,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                5 =>
                    array(
                        'permission_id' => 278,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                6 =>
                    array(
                        'permission_id' => 279,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                7 =>
                    array(
                        'permission_id' => 280,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                8 =>
                    array(
                        'permission_id' => 281,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                9 =>
                    array(
                        'permission_id' => 282,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                10 =>
                    array(
                        'permission_id' => 283,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                11 =>
                    array(
                        'permission_id' => 284,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                12 =>
                    array(
                        'permission_id' => 4,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                13 =>
                    array(
                        'permission_id' => 49,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                14 =>
                    array(
                        'permission_id' => 5,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                15 =>
                    array(
                        'permission_id' => 49,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                16 =>
                    array(
                        'permission_id' => 4,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                17 =>
                    array(
                        'permission_id' => 62,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                18 =>
                    array(
                        'permission_id' => 63,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                19 =>
                    array(
                        'permission_id' => 64,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                20 =>
                    array(
                        'permission_id' => 67,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                21 =>
                    array(
                        'permission_id' => 68,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                22 =>
                    array(
                        'permission_id' => 69,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                23 =>
                    array(
                        'permission_id' => 70,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                24 =>
                    array(
                        'permission_id' => 71,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                25 =>
                    array(
                        'permission_id' => 72,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                26 =>
                    array(
                        'permission_id' => 74,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                27 =>
                    array(
                        'permission_id' => 61,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                28 =>
                    array(
                        'permission_id' => 60,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                29 =>
                    array(
                        'permission_id' => 135,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                30 =>
                    array(
                        'permission_id' => 136,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                31 =>
                    array(
                        'permission_id' => 18,
                        'role_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                32 =>
                    array(
                        'permission_id' => 359,
                        'role_id' => 3,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                33 =>
                    array(
                        'permission_id' => 360,
                        'role_id' => 3,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                34 =>
                    array(
                        'permission_id' => 361,
                        'role_id' => 3,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                35 =>
                    array(
                        'permission_id' => 362,
                        'role_id' => 3,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                36 =>
                    array(
                        'permission_id' => 363,
                        'role_id' => 3,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                37 =>
                    array(
                        'permission_id' => 364,
                        'role_id' => 3,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                38 =>
                    array(
                        'permission_id' => 365,
                        'role_id' => 3,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                39 =>
                    array(
                        'permission_id' => 366,
                        'role_id' => 3,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                40 =>
                    array(
                        'permission_id' => 367,
                        'role_id' => 3,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                41 =>
                    array(
                        'permission_id' => 368,
                        'role_id' => 3,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                42 =>
                    array(
                        'permission_id' => 369,
                        'role_id' => 3,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                43 =>
                    array(
                        'permission_id' => 370,
                        'role_id' => 3,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                44 =>
                    array(
                        'permission_id' => 739,
                        'role_id' => 3,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                45 =>
                    array(
                        'permission_id' => 2,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                46 =>
                    array(
                        'permission_id' => 31,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                47 =>
                    array(
                        'permission_id' => 32,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                48 =>
                    array(
                        'permission_id' => 33,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                49 =>
                    array(
                        'permission_id' => 34,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                50 =>
                    array(
                        'permission_id' => 36,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                51 =>
                    array(
                        'permission_id' => 553,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                52 =>
                    array(
                        'permission_id' => 603,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                53 =>
                    array(
                        'permission_id' => 604,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                54 =>
                    array(
                        'permission_id' => 605,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                55 =>
                    array(
                        'permission_id' => 37,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                56 =>
                    array(
                        'permission_id' => 680,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                57 =>
                    array(
                        'permission_id' => 4,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                58 =>
                    array(
                        'permission_id' => 44,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                59 =>
                    array(
                        'permission_id' => 45,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                60 =>
                    array(
                        'permission_id' => 46,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                61 =>
                    array(
                        'permission_id' => 47,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                62 =>
                    array(
                        'permission_id' => 48,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                63 =>
                    array(
                        'permission_id' => 5,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                64 =>
                    array(
                        'permission_id' => 60,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                65 =>
                    array(
                        'permission_id' => 554,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                66 =>
                    array(
                        'permission_id' => 555,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                67 =>
                    array(
                        'permission_id' => 556,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                68 =>
                    array(
                        'permission_id' => 61,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                69 =>
                    array(
                        'permission_id' => 62,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                70 =>
                    array(
                        'permission_id' => 63,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                71 =>
                    array(
                        'permission_id' => 64,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                72 =>
                    array(
                        'permission_id' => 67,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                73 =>
                    array(
                        'permission_id' => 346,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                74 =>
                    array(
                        'permission_id' => 7,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                75 =>
                    array(
                        'permission_id' => 105,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                76 =>
                    array(
                        'permission_id' => 106,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                77 =>
                    array(
                        'permission_id' => 107,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                78 =>
                    array(
                        'permission_id' => 108,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                79 =>
                    array(
                        'permission_id' => 693,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                80 =>
                    array(
                        'permission_id' => 371,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                81 =>
                    array(
                        'permission_id' => 113,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                82 =>
                    array(
                        'permission_id' => 114,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                83 =>
                    array(
                        'permission_id' => 115,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                84 =>
                    array(
                        'permission_id' => 116,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                85 =>
                    array(
                        'permission_id' => 117,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                86 =>
                    array(
                        'permission_id' => 118,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                87 =>
                    array(
                        'permission_id' => 119,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                88 =>
                    array(
                        'permission_id' => 120,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                89 =>
                    array(
                        'permission_id' => 695,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                90 =>
                    array(
                        'permission_id' => 704,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                91 =>
                    array(
                        'permission_id' => 216,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                92 =>
                    array(
                        'permission_id' => 121,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                93 =>
                    array(
                        'permission_id' => 122,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                94 =>
                    array(
                        'permission_id' => 123,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                95 =>
                    array(
                        'permission_id' => 109,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                96 =>
                    array(
                        'permission_id' => 110,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                97 =>
                    array(
                        'permission_id' => 111,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                98 =>
                    array(
                        'permission_id' => 112,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                99 =>
                    array(
                        'permission_id' => 19,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                100 =>
                    array(
                        'permission_id' => 247,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                101 =>
                    array(
                        'permission_id' => 249,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                102 =>
                    array(
                        'permission_id' => 250,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                103 =>
                    array(
                        'permission_id' => 248,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                104 =>
                    array(
                        'permission_id' => 667,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                105 =>
                    array(
                        'permission_id' => 668,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                106 =>
                    array(
                        'permission_id' => 669,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                107 =>
                    array(
                        'permission_id' => 219,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                108 =>
                    array(
                        'permission_id' => 221,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                109 =>
                    array(
                        'permission_id' => 233,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                110 =>
                    array(
                        'permission_id' => 234,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                111 =>
                    array(
                        'permission_id' => 237,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                112 =>
                    array(
                        'permission_id' => 238,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                113 =>
                    array(
                        'permission_id' => 239,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                114 =>
                    array(
                        'permission_id' => 630,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                115 =>
                    array(
                        'permission_id' => 636,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                116 =>
                    array(
                        'permission_id' => 637,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                117 =>
                    array(
                        'permission_id' => 638,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                118 =>
                    array(
                        'permission_id' => 639,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                119 =>
                    array(
                        'permission_id' => 640,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                120 =>
                    array(
                        'permission_id' => 631,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                121 =>
                    array(
                        'permission_id' => 633,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                122 =>
                    array(
                        'permission_id' => 634,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                123 =>
                    array(
                        'permission_id' => 635,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                124 =>
                    array(
                        'permission_id' => 13,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
                125 =>
                    array(
                        'permission_id' => 196,
                        'role_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ),
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_permission');
    }
}
