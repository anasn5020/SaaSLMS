<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('states');
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('country_id');
        });

        $sql =array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Andaman and Nicobar Islands',
                    'country_id' => 101,
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Andhra Pradesh',
                    'country_id' => 101,
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Arunachal Pradesh',
                    'country_id' => 101,
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'Assam',
                    'country_id' => 101,
                ),
            4 =>
                array (
                    'id' => 5,
                    'name' => 'Bihar',
                    'country_id' => 101,
                ),
            5 =>
                array (
                    'id' => 6,
                    'name' => 'Chandigarh',
                    'country_id' => 101,
                ),
            6 =>
                array (
                    'id' => 7,
                    'name' => 'Chhattisgarh',
                    'country_id' => 101,
                ),
            7 =>
                array (
                    'id' => 8,
                    'name' => 'Dadra and Nagar Haveli',
                    'country_id' => 101,
                ),
            8 =>
                array (
                    'id' => 9,
                    'name' => 'Daman and Diu',
                    'country_id' => 101,
                ),
            9 =>
                array (
                    'id' => 10,
                    'name' => 'Delhi',
                    'country_id' => 101,
                ),
            10 =>
                array (
                    'id' => 11,
                    'name' => 'Goa',
                    'country_id' => 101,
                ),
            11 =>
                array (
                    'id' => 12,
                    'name' => 'Gujarat',
                    'country_id' => 101,
                ),
            12 =>
                array (
                    'id' => 13,
                    'name' => 'Haryana',
                    'country_id' => 101,
                ),
            13 =>
                array (
                    'id' => 14,
                    'name' => 'Himachal Pradesh',
                    'country_id' => 101,
                ),
            14 =>
                array (
                    'id' => 15,
                    'name' => 'Jammu and Kashmir',
                    'country_id' => 101,
                ),
            15 =>
                array (
                    'id' => 16,
                    'name' => 'Jharkhand',
                    'country_id' => 101,
                ),
            16 =>
                array (
                    'id' => 17,
                    'name' => 'Karnataka',
                    'country_id' => 101,
                ),
            17 =>
                array (
                    'id' => 18,
                    'name' => 'Kenmore',
                    'country_id' => 101,
                ),
            18 =>
                array (
                    'id' => 19,
                    'name' => 'Kerala',
                    'country_id' => 101,
                ),
            19 =>
                array (
                    'id' => 20,
                    'name' => 'Lakshadweep',
                    'country_id' => 101,
                ),
            20 =>
                array (
                    'id' => 21,
                    'name' => 'Madhya Pradesh',
                    'country_id' => 101,
                ),
            21 =>
                array (
                    'id' => 22,
                    'name' => 'Maharashtra',
                    'country_id' => 101,
                ),
            22 =>
                array (
                    'id' => 23,
                    'name' => 'Manipur',
                    'country_id' => 101,
                ),
            23 =>
                array (
                    'id' => 24,
                    'name' => 'Meghalaya',
                    'country_id' => 101,
                ),
            24 =>
                array (
                    'id' => 25,
                    'name' => 'Mizoram',
                    'country_id' => 101,
                ),
            25 =>
                array (
                    'id' => 26,
                    'name' => 'Nagaland',
                    'country_id' => 101,
                ),
            26 =>
                array (
                    'id' => 27,
                    'name' => 'Narora',
                    'country_id' => 101,
                ),
            27 =>
                array (
                    'id' => 28,
                    'name' => 'Natwar',
                    'country_id' => 101,
                ),
            28 =>
                array (
                    'id' => 29,
                    'name' => 'Odisha',
                    'country_id' => 101,
                ),
            29 =>
                array (
                    'id' => 30,
                    'name' => 'Paschim Medinipur',
                    'country_id' => 101,
                ),
            30 =>
                array (
                    'id' => 31,
                    'name' => 'Pondicherry',
                    'country_id' => 101,
                ),
            31 =>
                array (
                    'id' => 32,
                    'name' => 'Punjab',
                    'country_id' => 101,
                ),
            32 =>
                array (
                    'id' => 33,
                    'name' => 'Rajasthan',
                    'country_id' => 101,
                ),
            33 =>
                array (
                    'id' => 34,
                    'name' => 'Sikkim',
                    'country_id' => 101,
                ),
            34 =>
                array (
                    'id' => 35,
                    'name' => 'Tamil Nadu',
                    'country_id' => 101,
                ),
            35 =>
                array (
                    'id' => 36,
                    'name' => 'Telangana',
                    'country_id' => 101,
                ),
            36 =>
                array (
                    'id' => 37,
                    'name' => 'Tripura',
                    'country_id' => 101,
                ),
            37 =>
                array (
                    'id' => 38,
                    'name' => 'Uttar Pradesh',
                    'country_id' => 101,
                ),
            38 =>
                array (
                    'id' => 39,
                    'name' => 'Uttarakhand',
                    'country_id' => 101,
                ),
            39 =>
                array (
                    'id' => 40,
                    'name' => 'Vaishali',
                    'country_id' => 101,
                ),
            40 =>
                array (
                    'id' => 41,
                    'name' => 'West Bengal',
                    'country_id' => 101,
                ),
            41 =>
                array (
                    'id' => 42,
                    'name' => 'Badakhshan',
                    'country_id' => 1,
                ),
            42 =>
                array (
                    'id' => 43,
                    'name' => 'Badgis',
                    'country_id' => 1,
                ),
            43 =>
                array (
                    'id' => 44,
                    'name' => 'Baglan',
                    'country_id' => 1,
                ),
            44 =>
                array (
                    'id' => 45,
                    'name' => 'Balkh',
                    'country_id' => 1,
                ),
            45 =>
                array (
                    'id' => 46,
                    'name' => 'Bamiyan',
                    'country_id' => 1,
                ),
            46 =>
                array (
                    'id' => 47,
                    'name' => 'Farah',
                    'country_id' => 1,
                ),
            47 =>
                array (
                    'id' => 48,
                    'name' => 'Faryab',
                    'country_id' => 1,
                ),
            48 =>
                array (
                    'id' => 49,
                    'name' => 'Gawr',
                    'country_id' => 1,
                ),
            49 =>
                array (
                    'id' => 50,
                    'name' => 'Gazni',
                    'country_id' => 1,
                ),
            50 =>
                array (
                    'id' => 51,
                    'name' => 'Herat',
                    'country_id' => 1,
                ),
            51 =>
                array (
                    'id' => 52,
                    'name' => 'Hilmand',
                    'country_id' => 1,
                ),
            52 =>
                array (
                    'id' => 53,
                    'name' => 'Jawzjan',
                    'country_id' => 1,
                ),
            53 =>
                array (
                    'id' => 54,
                    'name' => 'Kabul',
                    'country_id' => 1,
                ),
            54 =>
                array (
                    'id' => 55,
                    'name' => 'Kapisa',
                    'country_id' => 1,
                ),
            55 =>
                array (
                    'id' => 56,
                    'name' => 'Khawst',
                    'country_id' => 1,
                ),
            56 =>
                array (
                    'id' => 57,
                    'name' => 'Kunar',
                    'country_id' => 1,
                ),
            57 =>
                array (
                    'id' => 58,
                    'name' => 'Lagman',
                    'country_id' => 1,
                ),
            58 =>
                array (
                    'id' => 59,
                    'name' => 'Lawghar',
                    'country_id' => 1,
                ),
            59 =>
                array (
                    'id' => 60,
                    'name' => 'Nangarhar',
                    'country_id' => 1,
                ),
            60 =>
                array (
                    'id' => 61,
                    'name' => 'Nimruz',
                    'country_id' => 1,
                ),
            61 =>
                array (
                    'id' => 62,
                    'name' => 'Nuristan',
                    'country_id' => 1,
                ),
            62 =>
                array (
                    'id' => 63,
                    'name' => 'Paktika',
                    'country_id' => 1,
                ),
            63 =>
                array (
                    'id' => 64,
                    'name' => 'Paktiya',
                    'country_id' => 1,
                ),
            64 =>
                array (
                    'id' => 65,
                    'name' => 'Parwan',
                    'country_id' => 1,
                ),
            65 =>
                array (
                    'id' => 66,
                    'name' => 'Qandahar',
                    'country_id' => 1,
                ),
            66 =>
                array (
                    'id' => 67,
                    'name' => 'Qunduz',
                    'country_id' => 1,
                ),
            67 =>
                array (
                    'id' => 68,
                    'name' => 'Samangan',
                    'country_id' => 1,
                ),
            68 =>
                array (
                    'id' => 69,
                    'name' => 'Sar-e Pul',
                    'country_id' => 1,
                ),
            69 =>
                array (
                    'id' => 70,
                    'name' => 'Takhar',
                    'country_id' => 1,
                ),
            70 =>
                array (
                    'id' => 71,
                    'name' => 'Uruzgan',
                    'country_id' => 1,
                ),
            71 =>
                array (
                    'id' => 72,
                    'name' => 'Wardak',
                    'country_id' => 1,
                ),
            72 =>
                array (
                    'id' => 73,
                    'name' => 'Zabul',
                    'country_id' => 1,
                ),
            73 =>
                array (
                    'id' => 74,
                    'name' => 'Berat',
                    'country_id' => 3,
                ),
            74 =>
                array (
                    'id' => 75,
                    'name' => 'Bulqize',
                    'country_id' => 3,
                ),
            75 =>
                array (
                    'id' => 76,
                    'name' => 'Delvine',
                    'country_id' => 3,
                ),
            76 =>
                array (
                    'id' => 77,
                    'name' => 'Devoll',
                    'country_id' => 3,
                ),
            77 =>
                array (
                    'id' => 78,
                    'name' => 'Dibre',
                    'country_id' => 3,
                ),
            78 =>
                array (
                    'id' => 79,
                    'name' => 'Durres',
                    'country_id' => 3,
                ),
            79 =>
                array (
                    'id' => 80,
                    'name' => 'Elbasan',
                    'country_id' => 3,
                ),
            80 =>
                array (
                    'id' => 81,
                    'name' => 'Fier',
                    'country_id' => 3,
                ),
            81 =>
                array (
                    'id' => 82,
                    'name' => 'Gjirokaster',
                    'country_id' => 3,
                ),
            82 =>
                array (
                    'id' => 83,
                    'name' => 'Gramsh',
                    'country_id' => 3,
                ),
            83 =>
                array (
                    'id' => 84,
                    'name' => 'Has',
                    'country_id' => 3,
                ),
            84 =>
                array (
                    'id' => 85,
                    'name' => 'Kavaje',
                    'country_id' => 3,
                ),
            85 =>
                array (
                    'id' => 86,
                    'name' => 'Kolonje',
                    'country_id' => 3,
                ),
            86 =>
                array (
                    'id' => 87,
                    'name' => 'Korce',
                    'country_id' => 3,
                ),
            87 =>
                array (
                    'id' => 88,
                    'name' => 'Kruje',
                    'country_id' => 3,
                ),
            88 =>
                array (
                    'id' => 89,
                    'name' => 'Kucove',
                    'country_id' => 3,
                ),
            89 =>
                array (
                    'id' => 90,
                    'name' => 'Kukes',
                    'country_id' => 3,
                ),
            90 =>
                array (
                    'id' => 91,
                    'name' => 'Kurbin',
                    'country_id' => 3,
                ),
            91 =>
                array (
                    'id' => 92,
                    'name' => 'Lezhe',
                    'country_id' => 3,
                ),
            92 =>
                array (
                    'id' => 93,
                    'name' => 'Librazhd',
                    'country_id' => 3,
                ),
            93 =>
                array (
                    'id' => 94,
                    'name' => 'Lushnje',
                    'country_id' => 3,
                ),
            94 =>
                array (
                    'id' => 95,
                    'name' => 'Mallakaster',
                    'country_id' => 3,
                ),
            95 =>
                array (
                    'id' => 96,
                    'name' => 'Malsi e Madhe',
                    'country_id' => 3,
                ),
            96 =>
                array (
                    'id' => 97,
                    'name' => 'Mat',
                    'country_id' => 3,
                ),
            97 =>
                array (
                    'id' => 98,
                    'name' => 'Mirdite',
                    'country_id' => 3,
                ),
            98 =>
                array (
                    'id' => 99,
                    'name' => 'Peqin',
                    'country_id' => 3,
                ),
            99 =>
                array (
                    'id' => 100,
                    'name' => 'Permet',
                    'country_id' => 3,
                ),
            100 =>
                array (
                    'id' => 101,
                    'name' => 'Pogradec',
                    'country_id' => 3,
                ),
            101 =>
                array (
                    'id' => 102,
                    'name' => 'Puke',
                    'country_id' => 3,
                ),
            102 =>
                array (
                    'id' => 103,
                    'name' => 'Sarande',
                    'country_id' => 3,
                ),
            103 =>
                array (
                    'id' => 104,
                    'name' => 'Shkoder',
                    'country_id' => 3,
                ),
            104 =>
                array (
                    'id' => 105,
                    'name' => 'Skrapar',
                    'country_id' => 3,
                ),
            105 =>
                array (
                    'id' => 106,
                    'name' => 'Tepelene',
                    'country_id' => 3,
                ),
            106 =>
                array (
                    'id' => 107,
                    'name' => 'Tirane',
                    'country_id' => 3,
                ),
            107 =>
                array (
                    'id' => 108,
                    'name' => 'Tropoje',
                    'country_id' => 3,
                ),
            108 =>
                array (
                    'id' => 109,
                    'name' => 'Vlore',
                    'country_id' => 3,
                ),
            109 =>
                array (
                    'id' => 110,
                    'name' => '\'Ayn Daflah',
                    'country_id' => 4,
                ),
            110 =>
                array (
                    'id' => 111,
                    'name' => '\'Ayn Tamushanat',
                    'country_id' => 4,
                ),
            111 =>
                array (
                    'id' => 112,
                    'name' => 'Adrar',
                    'country_id' => 4,
                ),
            112 =>
                array (
                    'id' => 113,
                    'name' => 'Algiers',
                    'country_id' => 4,
                ),
            113 =>
                array (
                    'id' => 114,
                    'name' => 'Annabah',
                    'country_id' => 4,
                ),
            114 =>
                array (
                    'id' => 115,
                    'name' => 'Bashshar',
                    'country_id' => 4,
                ),
            115 =>
                array (
                    'id' => 116,
                    'name' => 'Batnah',
                    'country_id' => 4,
                ),
            116 =>
                array (
                    'id' => 117,
                    'name' => 'Bijayah',
                    'country_id' => 4,
                ),
            117 =>
                array (
                    'id' => 118,
                    'name' => 'Biskrah',
                    'country_id' => 4,
                ),
            118 =>
                array (
                    'id' => 119,
                    'name' => 'Blidah',
                    'country_id' => 4,
                ),
            119 =>
                array (
                    'id' => 120,
                    'name' => 'Buirah',
                    'country_id' => 4,
                ),
            120 =>
                array (
                    'id' => 121,
                    'name' => 'Bumardas',
                    'country_id' => 4,
                ),
            121 =>
                array (
                    'id' => 122,
                    'name' => 'Burj Bu Arririj',
                    'country_id' => 4,
                ),
            122 =>
                array (
                    'id' => 123,
                    'name' => 'Ghalizan',
                    'country_id' => 4,
                ),
            123 =>
                array (
                    'id' => 124,
                    'name' => 'Ghardayah',
                    'country_id' => 4,
                ),
            124 =>
                array (
                    'id' => 125,
                    'name' => 'Ilizi',
                    'country_id' => 4,
                ),
            125 =>
                array (
                    'id' => 126,
                    'name' => 'Jijili',
                    'country_id' => 4,
                ),
            126 =>
                array (
                    'id' => 127,
                    'name' => 'Jilfah',
                    'country_id' => 4,
                ),
            127 =>
                array (
                    'id' => 128,
                    'name' => 'Khanshalah',
                    'country_id' => 4,
                ),
            128 =>
                array (
                    'id' => 129,
                    'name' => 'Masilah',
                    'country_id' => 4,
                ),
            129 =>
                array (
                    'id' => 130,
                    'name' => 'Midyah',
                    'country_id' => 4,
                ),
            130 =>
                array (
                    'id' => 131,
                    'name' => 'Milah',
                    'country_id' => 4,
                ),
            131 =>
                array (
                    'id' => 132,
                    'name' => 'Muaskar',
                    'country_id' => 4,
                ),
            132 =>
                array (
                    'id' => 133,
                    'name' => 'Mustaghanam',
                    'country_id' => 4,
                ),
            133 =>
                array (
                    'id' => 134,
                    'name' => 'Naama',
                    'country_id' => 4,
                ),
            134 =>
                array (
                    'id' => 135,
                    'name' => 'Oran',
                    'country_id' => 4,
                ),
            135 =>
                array (
                    'id' => 136,
                    'name' => 'Ouargla',
                    'country_id' => 4,
                ),
            136 =>
                array (
                    'id' => 137,
                    'name' => 'Qalmah',
                    'country_id' => 4,
                ),
            137 =>
                array (
                    'id' => 138,
                    'name' => 'Qustantinah',
                    'country_id' => 4,
                ),
            138 =>
                array (
                    'id' => 139,
                    'name' => 'Sakikdah',
                    'country_id' => 4,
                ),
            139 =>
                array (
                    'id' => 140,
                    'name' => 'Satif',
                    'country_id' => 4,
                ),
            140 =>
                array (
                    'id' => 141,
                    'name' => 'Sayda\'',
                    'country_id' => 4,
                ),
            141 =>
                array (
                    'id' => 142,
                    'name' => 'Sidi ban-al-\'Abbas',
                    'country_id' => 4,
                ),
            142 =>
                array (
                    'id' => 143,
                    'name' => 'Suq Ahras',
                    'country_id' => 4,
                ),
            143 =>
                array (
                    'id' => 144,
                    'name' => 'Tamanghasat',
                    'country_id' => 4,
                ),
            144 =>
                array (
                    'id' => 145,
                    'name' => 'Tibazah',
                    'country_id' => 4,
                ),
            145 =>
                array (
                    'id' => 146,
                    'name' => 'Tibissah',
                    'country_id' => 4,
                ),
            146 =>
                array (
                    'id' => 147,
                    'name' => 'Tilimsan',
                    'country_id' => 4,
                ),
            147 =>
                array (
                    'id' => 148,
                    'name' => 'Tinduf',
                    'country_id' => 4,
                ),
            148 =>
                array (
                    'id' => 149,
                    'name' => 'Tisamsilt',
                    'country_id' => 4,
                ),
            149 =>
                array (
                    'id' => 150,
                    'name' => 'Tiyarat',
                    'country_id' => 4,
                ),
            150 =>
                array (
                    'id' => 151,
                    'name' => 'Tizi Wazu',
                    'country_id' => 4,
                ),
            151 =>
                array (
                    'id' => 152,
                    'name' => 'Umm-al-Bawaghi',
                    'country_id' => 4,
                ),
            152 =>
                array (
                    'id' => 153,
                    'name' => 'Wahran',
                    'country_id' => 4,
                ),
            153 =>
                array (
                    'id' => 154,
                    'name' => 'Warqla',
                    'country_id' => 4,
                ),
            154 =>
                array (
                    'id' => 155,
                    'name' => 'Wilaya d Alger',
                    'country_id' => 4,
                ),
            155 =>
                array (
                    'id' => 156,
                    'name' => 'Wilaya de Bejaia',
                    'country_id' => 4,
                ),
            156 =>
                array (
                    'id' => 157,
                    'name' => 'Wilaya de Constantine',
                    'country_id' => 4,
                ),
            157 =>
                array (
                    'id' => 158,
                    'name' => 'al-Aghwat',
                    'country_id' => 4,
                ),
            158 =>
                array (
                    'id' => 159,
                    'name' => 'al-Bayadh',
                    'country_id' => 4,
                ),
            159 =>
                array (
                    'id' => 160,
                    'name' => 'al-Jaza\'ir',
                    'country_id' => 4,
                ),
            160 =>
                array (
                    'id' => 161,
                    'name' => 'al-Wad',
                    'country_id' => 4,
                ),
            161 =>
                array (
                    'id' => 162,
                    'name' => 'ash-Shalif',
                    'country_id' => 4,
                ),
            162 =>
                array (
                    'id' => 163,
                    'name' => 'at-Tarif',
                    'country_id' => 4,
                ),
            163 =>
                array (
                    'id' => 164,
                    'name' => 'Eastern',
                    'country_id' => 5,
                ),
            164 =>
                array (
                    'id' => 165,
                    'name' => 'Manu\'a',
                    'country_id' => 5,
                ),
            165 =>
                array (
                    'id' => 166,
                    'name' => 'Swains Island',
                    'country_id' => 5,
                ),
            166 =>
                array (
                    'id' => 167,
                    'name' => 'Western',
                    'country_id' => 5,
                ),
            167 =>
                array (
                    'id' => 168,
                    'name' => 'Andorra la Vella',
                    'country_id' => 6,
                ),
            168 =>
                array (
                    'id' => 169,
                    'name' => 'Canillo',
                    'country_id' => 6,
                ),
            169 =>
                array (
                    'id' => 170,
                    'name' => 'Encamp',
                    'country_id' => 6,
                ),
            170 =>
                array (
                    'id' => 171,
                    'name' => 'La Massana',
                    'country_id' => 6,
                ),
            171 =>
                array (
                    'id' => 172,
                    'name' => 'Les Escaldes',
                    'country_id' => 6,
                ),
            172 =>
                array (
                    'id' => 173,
                    'name' => 'Ordino',
                    'country_id' => 6,
                ),
            173 =>
                array (
                    'id' => 174,
                    'name' => 'Sant Julia de Loria',
                    'country_id' => 6,
                ),
            174 =>
                array (
                    'id' => 175,
                    'name' => 'Bengo',
                    'country_id' => 7,
                ),
            175 =>
                array (
                    'id' => 176,
                    'name' => 'Benguela',
                    'country_id' => 7,
                ),
            176 =>
                array (
                    'id' => 177,
                    'name' => 'Bie',
                    'country_id' => 7,
                ),
            177 =>
                array (
                    'id' => 178,
                    'name' => 'Cabinda',
                    'country_id' => 7,
                ),
            178 =>
                array (
                    'id' => 179,
                    'name' => 'Cunene',
                    'country_id' => 7,
                ),
            179 =>
                array (
                    'id' => 180,
                    'name' => 'Huambo',
                    'country_id' => 7,
                ),
            180 =>
                array (
                    'id' => 181,
                    'name' => 'Huila',
                    'country_id' => 7,
                ),
            181 =>
                array (
                    'id' => 182,
                    'name' => 'Kuando-Kubango',
                    'country_id' => 7,
                ),
            182 =>
                array (
                    'id' => 183,
                    'name' => 'Kwanza Norte',
                    'country_id' => 7,
                ),
            183 =>
                array (
                    'id' => 184,
                    'name' => 'Kwanza Sul',
                    'country_id' => 7,
                ),
            184 =>
                array (
                    'id' => 185,
                    'name' => 'Luanda',
                    'country_id' => 7,
                ),
            185 =>
                array (
                    'id' => 186,
                    'name' => 'Lunda Norte',
                    'country_id' => 7,
                ),
            186 =>
                array (
                    'id' => 187,
                    'name' => 'Lunda Sul',
                    'country_id' => 7,
                ),
            187 =>
                array (
                    'id' => 188,
                    'name' => 'Malanje',
                    'country_id' => 7,
                ),
            188 =>
                array (
                    'id' => 189,
                    'name' => 'Moxico',
                    'country_id' => 7,
                ),
            189 =>
                array (
                    'id' => 190,
                    'name' => 'Namibe',
                    'country_id' => 7,
                ),
            190 =>
                array (
                    'id' => 191,
                    'name' => 'Uige',
                    'country_id' => 7,
                ),
            191 =>
                array (
                    'id' => 192,
                    'name' => 'Zaire',
                    'country_id' => 7,
                ),
            192 =>
                array (
                    'id' => 193,
                    'name' => 'Other Provinces',
                    'country_id' => 8,
                ),
            193 =>
                array (
                    'id' => 194,
                    'name' => 'Sector claimed by Argentina/Ch',
                    'country_id' => 9,
                ),
            194 =>
                array (
                    'id' => 195,
                    'name' => 'Sector claimed by Argentina/UK',
                    'country_id' => 9,
                ),
            195 =>
                array (
                    'id' => 196,
                    'name' => 'Sector claimed by Australia',
                    'country_id' => 9,
                ),
            196 =>
                array (
                    'id' => 197,
                    'name' => 'Sector claimed by France',
                    'country_id' => 9,
                ),
            197 =>
                array (
                    'id' => 198,
                    'name' => 'Sector claimed by New Zealand',
                    'country_id' => 9,
                ),
            198 =>
                array (
                    'id' => 199,
                    'name' => 'Sector claimed by Norway',
                    'country_id' => 9,
                ),
            199 =>
                array (
                    'id' => 200,
                    'name' => 'Unclaimed Sector',
                    'country_id' => 9,
                ),
            200 =>
                array (
                    'id' => 201,
                    'name' => 'Barbuda',
                    'country_id' => 10,
                ),
            201 =>
                array (
                    'id' => 202,
                    'name' => 'Saint George',
                    'country_id' => 10,
                ),
            202 =>
                array (
                    'id' => 203,
                    'name' => 'Saint John',
                    'country_id' => 10,
                ),
            203 =>
                array (
                    'id' => 204,
                    'name' => 'Saint Mary',
                    'country_id' => 10,
                ),
            204 =>
                array (
                    'id' => 205,
                    'name' => 'Saint Paul',
                    'country_id' => 10,
                ),
            205 =>
                array (
                    'id' => 206,
                    'name' => 'Saint Peter',
                    'country_id' => 10,
                ),
            206 =>
                array (
                    'id' => 207,
                    'name' => 'Saint Philip',
                    'country_id' => 10,
                ),
            207 =>
                array (
                    'id' => 208,
                    'name' => 'Buenos Aires',
                    'country_id' => 11,
                ),
            208 =>
                array (
                    'id' => 209,
                    'name' => 'Catamarca',
                    'country_id' => 11,
                ),
            209 =>
                array (
                    'id' => 210,
                    'name' => 'Chaco',
                    'country_id' => 11,
                ),
            210 =>
                array (
                    'id' => 211,
                    'name' => 'Chubut',
                    'country_id' => 11,
                ),
            211 =>
                array (
                    'id' => 212,
                    'name' => 'Cordoba',
                    'country_id' => 11,
                ),
            212 =>
                array (
                    'id' => 213,
                    'name' => 'Corrientes',
                    'country_id' => 11,
                ),
            213 =>
                array (
                    'id' => 214,
                    'name' => 'Distrito Federal',
                    'country_id' => 11,
                ),
            214 =>
                array (
                    'id' => 215,
                    'name' => 'Entre Rios',
                    'country_id' => 11,
                ),
            215 =>
                array (
                    'id' => 216,
                    'name' => 'Formosa',
                    'country_id' => 11,
                ),
            216 =>
                array (
                    'id' => 217,
                    'name' => 'Jujuy',
                    'country_id' => 11,
                ),
            217 =>
                array (
                    'id' => 218,
                    'name' => 'La Pampa',
                    'country_id' => 11,
                ),
            218 =>
                array (
                    'id' => 219,
                    'name' => 'La Rioja',
                    'country_id' => 11,
                ),
            219 =>
                array (
                    'id' => 220,
                    'name' => 'Mendoza',
                    'country_id' => 11,
                ),
            220 =>
                array (
                    'id' => 221,
                    'name' => 'Misiones',
                    'country_id' => 11,
                ),
            221 =>
                array (
                    'id' => 222,
                    'name' => 'Neuquen',
                    'country_id' => 11,
                ),
            222 =>
                array (
                    'id' => 223,
                    'name' => 'Rio Negro',
                    'country_id' => 11,
                ),
            223 =>
                array (
                    'id' => 224,
                    'name' => 'Salta',
                    'country_id' => 11,
                ),
            224 =>
                array (
                    'id' => 225,
                    'name' => 'San Juan',
                    'country_id' => 11,
                ),
            225 =>
                array (
                    'id' => 226,
                    'name' => 'San Luis',
                    'country_id' => 11,
                ),
            226 =>
                array (
                    'id' => 227,
                    'name' => 'Santa Cruz',
                    'country_id' => 11,
                ),
            227 =>
                array (
                    'id' => 228,
                    'name' => 'Santa Fe',
                    'country_id' => 11,
                ),
            228 =>
                array (
                    'id' => 229,
                    'name' => 'Santiago del Estero',
                    'country_id' => 11,
                ),
            229 =>
                array (
                    'id' => 230,
                    'name' => 'Tierra del Fuego',
                    'country_id' => 11,
                ),
            230 =>
                array (
                    'id' => 231,
                    'name' => 'Tucuman',
                    'country_id' => 11,
                ),
            231 =>
                array (
                    'id' => 232,
                    'name' => 'Aragatsotn',
                    'country_id' => 12,
                ),
            232 =>
                array (
                    'id' => 233,
                    'name' => 'Ararat',
                    'country_id' => 12,
                ),
            233 =>
                array (
                    'id' => 234,
                    'name' => 'Armavir',
                    'country_id' => 12,
                ),
            234 =>
                array (
                    'id' => 235,
                    'name' => 'Gegharkunik',
                    'country_id' => 12,
                ),
            235 =>
                array (
                    'id' => 236,
                    'name' => 'Kotaik',
                    'country_id' => 12,
                ),
            236 =>
                array (
                    'id' => 237,
                    'name' => 'Lori',
                    'country_id' => 12,
                ),
            237 =>
                array (
                    'id' => 238,
                    'name' => 'Shirak',
                    'country_id' => 12,
                ),
            238 =>
                array (
                    'id' => 239,
                    'name' => 'Stepanakert',
                    'country_id' => 12,
                ),
            239 =>
                array (
                    'id' => 240,
                    'name' => 'Syunik',
                    'country_id' => 12,
                ),
            240 =>
                array (
                    'id' => 241,
                    'name' => 'Tavush',
                    'country_id' => 12,
                ),
            241 =>
                array (
                    'id' => 242,
                    'name' => 'Vayots Dzor',
                    'country_id' => 12,
                ),
            242 =>
                array (
                    'id' => 243,
                    'name' => 'Yerevan',
                    'country_id' => 12,
                ),
            243 =>
                array (
                    'id' => 244,
                    'name' => 'Aruba',
                    'country_id' => 13,
                ),
            244 =>
                array (
                    'id' => 245,
                    'name' => 'Auckland',
                    'country_id' => 14,
                ),
            245 =>
                array (
                    'id' => 246,
                    'name' => 'Australian Capital Territory',
                    'country_id' => 14,
                ),
            246 =>
                array (
                    'id' => 247,
                    'name' => 'Balgowlah',
                    'country_id' => 14,
                ),
            247 =>
                array (
                    'id' => 248,
                    'name' => 'Balmain',
                    'country_id' => 14,
                ),
            248 =>
                array (
                    'id' => 249,
                    'name' => 'Bankstown',
                    'country_id' => 14,
                ),
            249 =>
                array (
                    'id' => 250,
                    'name' => 'Baulkham Hills',
                    'country_id' => 14,
                ),
            250 =>
                array (
                    'id' => 251,
                    'name' => 'Bonnet Bay',
                    'country_id' => 14,
                ),
            251 =>
                array (
                    'id' => 252,
                    'name' => 'Camberwell',
                    'country_id' => 14,
                ),
            252 =>
                array (
                    'id' => 253,
                    'name' => 'Carole Park',
                    'country_id' => 14,
                ),
            253 =>
                array (
                    'id' => 254,
                    'name' => 'Castle Hill',
                    'country_id' => 14,
                ),
            254 =>
                array (
                    'id' => 255,
                    'name' => 'Caulfield',
                    'country_id' => 14,
                ),
            255 =>
                array (
                    'id' => 256,
                    'name' => 'Chatswood',
                    'country_id' => 14,
                ),
            256 =>
                array (
                    'id' => 257,
                    'name' => 'Cheltenham',
                    'country_id' => 14,
                ),
            257 =>
                array (
                    'id' => 258,
                    'name' => 'Cherrybrook',
                    'country_id' => 14,
                ),
            258 =>
                array (
                    'id' => 259,
                    'name' => 'Clayton',
                    'country_id' => 14,
                ),
            259 =>
                array (
                    'id' => 260,
                    'name' => 'Collingwood',
                    'country_id' => 14,
                ),
            260 =>
                array (
                    'id' => 261,
                    'name' => 'Frenchs Forest',
                    'country_id' => 14,
                ),
            261 =>
                array (
                    'id' => 262,
                    'name' => 'Hawthorn',
                    'country_id' => 14,
                ),
            262 =>
                array (
                    'id' => 263,
                    'name' => 'Jannnali',
                    'country_id' => 14,
                ),
            263 =>
                array (
                    'id' => 264,
                    'name' => 'Knoxfield',
                    'country_id' => 14,
                ),
            264 =>
                array (
                    'id' => 265,
                    'name' => 'Melbourne',
                    'country_id' => 14,
                ),
            265 =>
                array (
                    'id' => 266,
                    'name' => 'New South Wales',
                    'country_id' => 14,
                ),
            266 =>
                array (
                    'id' => 267,
                    'name' => 'Northern Territory',
                    'country_id' => 14,
                ),
            267 =>
                array (
                    'id' => 268,
                    'name' => 'Perth',
                    'country_id' => 14,
                ),
            268 =>
                array (
                    'id' => 269,
                    'name' => 'Queensland',
                    'country_id' => 14,
                ),
            269 =>
                array (
                    'id' => 270,
                    'name' => 'South Australia',
                    'country_id' => 14,
                ),
            270 =>
                array (
                    'id' => 271,
                    'name' => 'Tasmania',
                    'country_id' => 14,
                ),
            271 =>
                array (
                    'id' => 272,
                    'name' => 'Templestowe',
                    'country_id' => 14,
                ),
            272 =>
                array (
                    'id' => 273,
                    'name' => 'Victoria',
                    'country_id' => 14,
                ),
            273 =>
                array (
                    'id' => 274,
                    'name' => 'Werribee south',
                    'country_id' => 14,
                ),
            274 =>
                array (
                    'id' => 275,
                    'name' => 'Western Australia',
                    'country_id' => 14,
                ),
            275 =>
                array (
                    'id' => 276,
                    'name' => 'Wheeler',
                    'country_id' => 14,
                ),
            276 =>
                array (
                    'id' => 277,
                    'name' => 'Bundesland Salzburg',
                    'country_id' => 15,
                ),
            277 =>
                array (
                    'id' => 278,
                    'name' => 'Bundesland Steiermark',
                    'country_id' => 15,
                ),
            278 =>
                array (
                    'id' => 279,
                    'name' => 'Bundesland Tirol',
                    'country_id' => 15,
                ),
            279 =>
                array (
                    'id' => 280,
                    'name' => 'Burgenland',
                    'country_id' => 15,
                ),
            280 =>
                array (
                    'id' => 281,
                    'name' => 'Carinthia',
                    'country_id' => 15,
                ),
            281 =>
                array (
                    'id' => 282,
                    'name' => 'Karnten',
                    'country_id' => 15,
                ),
            282 =>
                array (
                    'id' => 283,
                    'name' => 'Liezen',
                    'country_id' => 15,
                ),
            283 =>
                array (
                    'id' => 284,
                    'name' => 'Lower Austria',
                    'country_id' => 15,
                ),
            284 =>
                array (
                    'id' => 285,
                    'name' => 'Niederosterreich',
                    'country_id' => 15,
                ),
            285 =>
                array (
                    'id' => 286,
                    'name' => 'Oberosterreich',
                    'country_id' => 15,
                ),
            286 =>
                array (
                    'id' => 287,
                    'name' => 'Salzburg',
                    'country_id' => 15,
                ),
            287 =>
                array (
                    'id' => 288,
                    'name' => 'Schleswig-Holstein',
                    'country_id' => 15,
                ),
            288 =>
                array (
                    'id' => 289,
                    'name' => 'Steiermark',
                    'country_id' => 15,
                ),
            289 =>
                array (
                    'id' => 290,
                    'name' => 'Styria',
                    'country_id' => 15,
                ),
            290 =>
                array (
                    'id' => 291,
                    'name' => 'Tirol',
                    'country_id' => 15,
                ),
            291 =>
                array (
                    'id' => 292,
                    'name' => 'Upper Austria',
                    'country_id' => 15,
                ),
            292 =>
                array (
                    'id' => 293,
                    'name' => 'Vorarlberg',
                    'country_id' => 15,
                ),
            293 =>
                array (
                    'id' => 294,
                    'name' => 'Wien',
                    'country_id' => 15,
                ),
            294 =>
                array (
                    'id' => 295,
                    'name' => 'Abseron',
                    'country_id' => 16,
                ),
            295 =>
                array (
                    'id' => 296,
                    'name' => 'Baki Sahari',
                    'country_id' => 16,
                ),
            296 =>
                array (
                    'id' => 297,
                    'name' => 'Ganca',
                    'country_id' => 16,
                ),
            297 =>
                array (
                    'id' => 298,
                    'name' => 'Ganja',
                    'country_id' => 16,
                ),
            298 =>
                array (
                    'id' => 299,
                    'name' => 'Kalbacar',
                    'country_id' => 16,
                ),
            299 =>
                array (
                    'id' => 300,
                    'name' => 'Lankaran',
                    'country_id' => 16,
                ),
            300 =>
                array (
                    'id' => 301,
                    'name' => 'Mil-Qarabax',
                    'country_id' => 16,
                ),
            301 =>
                array (
                    'id' => 302,
                    'name' => 'Mugan-Salyan',
                    'country_id' => 16,
                ),
            302 =>
                array (
                    'id' => 303,
                    'name' => 'Nagorni-Qarabax',
                    'country_id' => 16,
                ),
            303 =>
                array (
                    'id' => 304,
                    'name' => 'Naxcivan',
                    'country_id' => 16,
                ),
            304 =>
                array (
                    'id' => 305,
                    'name' => 'Priaraks',
                    'country_id' => 16,
                ),
            305 =>
                array (
                    'id' => 306,
                    'name' => 'Qazax',
                    'country_id' => 16,
                ),
            306 =>
                array (
                    'id' => 307,
                    'name' => 'Saki',
                    'country_id' => 16,
                ),
            307 =>
                array (
                    'id' => 308,
                    'name' => 'Sirvan',
                    'country_id' => 16,
                ),
            308 =>
                array (
                    'id' => 309,
                    'name' => 'Xacmaz',
                    'country_id' => 16,
                ),
            309 =>
                array (
                    'id' => 310,
                    'name' => 'Abaco',
                    'country_id' => 17,
                ),
            310 =>
                array (
                    'id' => 311,
                    'name' => 'Acklins Island',
                    'country_id' => 17,
                ),
            311 =>
                array (
                    'id' => 312,
                    'name' => 'Andros',
                    'country_id' => 17,
                ),
            312 =>
                array (
                    'id' => 313,
                    'name' => 'Berry Islands',
                    'country_id' => 17,
                ),
            313 =>
                array (
                    'id' => 314,
                    'name' => 'Biminis',
                    'country_id' => 17,
                ),
            314 =>
                array (
                    'id' => 315,
                    'name' => 'Cat Island',
                    'country_id' => 17,
                ),
            315 =>
                array (
                    'id' => 316,
                    'name' => 'Crooked Island',
                    'country_id' => 17,
                ),
            316 =>
                array (
                    'id' => 317,
                    'name' => 'Eleuthera',
                    'country_id' => 17,
                ),
            317 =>
                array (
                    'id' => 318,
                    'name' => 'Exuma and Cays',
                    'country_id' => 17,
                ),
            318 =>
                array (
                    'id' => 319,
                    'name' => 'Grand Bahama',
                    'country_id' => 17,
                ),
            319 =>
                array (
                    'id' => 320,
                    'name' => 'Inagua Islands',
                    'country_id' => 17,
                ),
            320 =>
                array (
                    'id' => 321,
                    'name' => 'Long Island',
                    'country_id' => 17,
                ),
            321 =>
                array (
                    'id' => 322,
                    'name' => 'Mayaguana',
                    'country_id' => 17,
                ),
            322 =>
                array (
                    'id' => 323,
                    'name' => 'New Providence',
                    'country_id' => 17,
                ),
            323 =>
                array (
                    'id' => 324,
                    'name' => 'Ragged Island',
                    'country_id' => 17,
                ),
            324 =>
                array (
                    'id' => 325,
                    'name' => 'Rum Cay',
                    'country_id' => 17,
                ),
            325 =>
                array (
                    'id' => 326,
                    'name' => 'San Salvador',
                    'country_id' => 17,
                ),
            326 =>
                array (
                    'id' => 327,
                    'name' => '\'Isa',
                    'country_id' => 18,
                ),
            327 =>
                array (
                    'id' => 328,
                    'name' => 'Badiyah',
                    'country_id' => 18,
                ),
            328 =>
                array (
                    'id' => 329,
                    'name' => 'Hidd',
                    'country_id' => 18,
                ),
            329 =>
                array (
                    'id' => 330,
                    'name' => 'Jidd Hafs',
                    'country_id' => 18,
                ),
            330 =>
                array (
                    'id' => 331,
                    'name' => 'Mahama',
                    'country_id' => 18,
                ),
            331 =>
                array (
                    'id' => 332,
                    'name' => 'Manama',
                    'country_id' => 18,
                ),
            332 =>
                array (
                    'id' => 333,
                    'name' => 'Sitrah',
                    'country_id' => 18,
                ),
            333 =>
                array (
                    'id' => 334,
                    'name' => 'al-Manamah',
                    'country_id' => 18,
                ),
            334 =>
                array (
                    'id' => 335,
                    'name' => 'al-Muharraq',
                    'country_id' => 18,
                ),
            335 =>
                array (
                    'id' => 336,
                    'name' => 'ar-Rifa\'a',
                    'country_id' => 18,
                ),
            336 =>
                array (
                    'id' => 337,
                    'name' => 'Bagar Hat',
                    'country_id' => 19,
                ),
            337 =>
                array (
                    'id' => 338,
                    'name' => 'Bandarban',
                    'country_id' => 19,
                ),
            338 =>
                array (
                    'id' => 339,
                    'name' => 'Barguna',
                    'country_id' => 19,
                ),
            339 =>
                array (
                    'id' => 340,
                    'name' => 'Barisal',
                    'country_id' => 19,
                ),
            340 =>
                array (
                    'id' => 341,
                    'name' => 'Bhola',
                    'country_id' => 19,
                ),
            341 =>
                array (
                    'id' => 342,
                    'name' => 'Bogora',
                    'country_id' => 19,
                ),
            342 =>
                array (
                    'id' => 343,
                    'name' => 'Brahman Bariya',
                    'country_id' => 19,
                ),
            343 =>
                array (
                    'id' => 344,
                    'name' => 'Chandpur',
                    'country_id' => 19,
                ),
            344 =>
                array (
                    'id' => 345,
                    'name' => 'Chattagam',
                    'country_id' => 19,
                ),
            345 =>
                array (
                    'id' => 346,
                    'name' => 'Chittagong Division',
                    'country_id' => 19,
                ),
            346 =>
                array (
                    'id' => 347,
                    'name' => 'Chuadanga',
                    'country_id' => 19,
                ),
            347 =>
                array (
                    'id' => 348,
                    'name' => 'Dhaka',
                    'country_id' => 19,
                ),
            348 =>
                array (
                    'id' => 349,
                    'name' => 'Dinajpur',
                    'country_id' => 19,
                ),
            349 =>
                array (
                    'id' => 350,
                    'name' => 'Faridpur',
                    'country_id' => 19,
                ),
            350 =>
                array (
                    'id' => 351,
                    'name' => 'Feni',
                    'country_id' => 19,
                ),
            351 =>
                array (
                    'id' => 352,
                    'name' => 'Gaybanda',
                    'country_id' => 19,
                ),
            352 =>
                array (
                    'id' => 353,
                    'name' => 'Gazipur',
                    'country_id' => 19,
                ),
            353 =>
                array (
                    'id' => 354,
                    'name' => 'Gopalganj',
                    'country_id' => 19,
                ),
            354 =>
                array (
                    'id' => 355,
                    'name' => 'Habiganj',
                    'country_id' => 19,
                ),
            355 =>
                array (
                    'id' => 356,
                    'name' => 'Jaipur Hat',
                    'country_id' => 19,
                ),
            356 =>
                array (
                    'id' => 357,
                    'name' => 'Jamalpur',
                    'country_id' => 19,
                ),
            357 =>
                array (
                    'id' => 358,
                    'name' => 'Jessor',
                    'country_id' => 19,
                ),
            358 =>
                array (
                    'id' => 359,
                    'name' => 'Jhalakati',
                    'country_id' => 19,
                ),
            359 =>
                array (
                    'id' => 360,
                    'name' => 'Jhanaydah',
                    'country_id' => 19,
                ),
            360 =>
                array (
                    'id' => 361,
                    'name' => 'Khagrachhari',
                    'country_id' => 19,
                ),
            361 =>
                array (
                    'id' => 362,
                    'name' => 'Khulna',
                    'country_id' => 19,
                ),
            362 =>
                array (
                    'id' => 363,
                    'name' => 'Kishorganj',
                    'country_id' => 19,
                ),
            363 =>
                array (
                    'id' => 364,
                    'name' => 'Koks Bazar',
                    'country_id' => 19,
                ),
            364 =>
                array (
                    'id' => 365,
                    'name' => 'Komilla',
                    'country_id' => 19,
                ),
            365 =>
                array (
                    'id' => 366,
                    'name' => 'Kurigram',
                    'country_id' => 19,
                ),
            366 =>
                array (
                    'id' => 367,
                    'name' => 'Kushtiya',
                    'country_id' => 19,
                ),
            367 =>
                array (
                    'id' => 368,
                    'name' => 'Lakshmipur',
                    'country_id' => 19,
                ),
            368 =>
                array (
                    'id' => 369,
                    'name' => 'Lalmanir Hat',
                    'country_id' => 19,
                ),
            369 =>
                array (
                    'id' => 370,
                    'name' => 'Madaripur',
                    'country_id' => 19,
                ),
            370 =>
                array (
                    'id' => 371,
                    'name' => 'Magura',
                    'country_id' => 19,
                ),
            371 =>
                array (
                    'id' => 372,
                    'name' => 'Maimansingh',
                    'country_id' => 19,
                ),
            372 =>
                array (
                    'id' => 373,
                    'name' => 'Manikganj',
                    'country_id' => 19,
                ),
            373 =>
                array (
                    'id' => 374,
                    'name' => 'Maulvi Bazar',
                    'country_id' => 19,
                ),
            374 =>
                array (
                    'id' => 375,
                    'name' => 'Meherpur',
                    'country_id' => 19,
                ),
            375 =>
                array (
                    'id' => 376,
                    'name' => 'Munshiganj',
                    'country_id' => 19,
                ),
            376 =>
                array (
                    'id' => 377,
                    'name' => 'Naral',
                    'country_id' => 19,
                ),
            377 =>
                array (
                    'id' => 378,
                    'name' => 'Narayanganj',
                    'country_id' => 19,
                ),
            378 =>
                array (
                    'id' => 379,
                    'name' => 'Narsingdi',
                    'country_id' => 19,
                ),
            379 =>
                array (
                    'id' => 380,
                    'name' => 'Nator',
                    'country_id' => 19,
                ),
            380 =>
                array (
                    'id' => 381,
                    'name' => 'Naugaon',
                    'country_id' => 19,
                ),
            381 =>
                array (
                    'id' => 382,
                    'name' => 'Nawabganj',
                    'country_id' => 19,
                ),
            382 =>
                array (
                    'id' => 383,
                    'name' => 'Netrakona',
                    'country_id' => 19,
                ),
            383 =>
                array (
                    'id' => 384,
                    'name' => 'Nilphamari',
                    'country_id' => 19,
                ),
            384 =>
                array (
                    'id' => 385,
                    'name' => 'Noakhali',
                    'country_id' => 19,
                ),
            385 =>
                array (
                    'id' => 386,
                    'name' => 'Pabna',
                    'country_id' => 19,
                ),
            386 =>
                array (
                    'id' => 387,
                    'name' => 'Panchagarh',
                    'country_id' => 19,
                ),
            387 =>
                array (
                    'id' => 388,
                    'name' => 'Patuakhali',
                    'country_id' => 19,
                ),
            388 =>
                array (
                    'id' => 389,
                    'name' => 'Pirojpur',
                    'country_id' => 19,
                ),
            389 =>
                array (
                    'id' => 390,
                    'name' => 'Rajbari',
                    'country_id' => 19,
                ),
            390 =>
                array (
                    'id' => 391,
                    'name' => 'Rajshahi',
                    'country_id' => 19,
                ),
            391 =>
                array (
                    'id' => 392,
                    'name' => 'Rangamati',
                    'country_id' => 19,
                ),
            392 =>
                array (
                    'id' => 393,
                    'name' => 'Rangpur',
                    'country_id' => 19,
                ),
            393 =>
                array (
                    'id' => 394,
                    'name' => 'Satkhira',
                    'country_id' => 19,
                ),
            394 =>
                array (
                    'id' => 395,
                    'name' => 'Shariatpur',
                    'country_id' => 19,
                ),
            395 =>
                array (
                    'id' => 396,
                    'name' => 'Sherpur',
                    'country_id' => 19,
                ),
            396 =>
                array (
                    'id' => 397,
                    'name' => 'Silhat',
                    'country_id' => 19,
                ),
            397 =>
                array (
                    'id' => 398,
                    'name' => 'Sirajganj',
                    'country_id' => 19,
                ),
            398 =>
                array (
                    'id' => 399,
                    'name' => 'Sunamganj',
                    'country_id' => 19,
                ),
            399 =>
                array (
                    'id' => 400,
                    'name' => 'Tangayal',
                    'country_id' => 19,
                ),
            400 =>
                array (
                    'id' => 401,
                    'name' => 'Thakurgaon',
                    'country_id' => 19,
                ),
            401 =>
                array (
                    'id' => 402,
                    'name' => 'Christ Church',
                    'country_id' => 20,
                ),
            402 =>
                array (
                    'id' => 403,
                    'name' => 'Saint Andrew',
                    'country_id' => 20,
                ),
            403 =>
                array (
                    'id' => 404,
                    'name' => 'Saint George',
                    'country_id' => 20,
                ),
            404 =>
                array (
                    'id' => 405,
                    'name' => 'Saint James',
                    'country_id' => 20,
                ),
            405 =>
                array (
                    'id' => 406,
                    'name' => 'Saint John',
                    'country_id' => 20,
                ),
            406 =>
                array (
                    'id' => 407,
                    'name' => 'Saint Joseph',
                    'country_id' => 20,
                ),
            407 =>
                array (
                    'id' => 408,
                    'name' => 'Saint Lucy',
                    'country_id' => 20,
                ),
            408 =>
                array (
                    'id' => 409,
                    'name' => 'Saint Michael',
                    'country_id' => 20,
                ),
            409 =>
                array (
                    'id' => 410,
                    'name' => 'Saint Peter',
                    'country_id' => 20,
                ),
            410 =>
                array (
                    'id' => 411,
                    'name' => 'Saint Philip',
                    'country_id' => 20,
                ),
            411 =>
                array (
                    'id' => 412,
                    'name' => 'Saint Thomas',
                    'country_id' => 20,
                ),
            412 =>
                array (
                    'id' => 413,
                    'name' => 'Brest',
                    'country_id' => 21,
                ),
            413 =>
                array (
                    'id' => 414,
                    'name' => 'Homjel\'',
                    'country_id' => 21,
                ),
            414 =>
                array (
                    'id' => 415,
                    'name' => 'Hrodna',
                    'country_id' => 21,
                ),
            415 =>
                array (
                    'id' => 416,
                    'name' => 'Mahiljow',
                    'country_id' => 21,
                ),
            416 =>
                array (
                    'id' => 417,
                    'name' => 'Mahilyowskaya Voblasts',
                    'country_id' => 21,
                ),
            417 =>
                array (
                    'id' => 418,
                    'name' => 'Minsk',
                    'country_id' => 21,
                ),
            418 =>
                array (
                    'id' => 419,
                    'name' => 'Minskaja Voblasts\'',
                    'country_id' => 21,
                ),
            419 =>
                array (
                    'id' => 420,
                    'name' => 'Petrik',
                    'country_id' => 21,
                ),
            420 =>
                array (
                    'id' => 421,
                    'name' => 'Vicebsk',
                    'country_id' => 21,
                ),
            421 =>
                array (
                    'id' => 422,
                    'name' => 'Antwerpen',
                    'country_id' => 22,
                ),
            422 =>
                array (
                    'id' => 423,
                    'name' => 'Berchem',
                    'country_id' => 22,
                ),
            423 =>
                array (
                    'id' => 424,
                    'name' => 'Brabant',
                    'country_id' => 22,
                ),
            424 =>
                array (
                    'id' => 425,
                    'name' => 'Brabant Wallon',
                    'country_id' => 22,
                ),
            425 =>
                array (
                    'id' => 426,
                    'name' => 'Brussel',
                    'country_id' => 22,
                ),
            426 =>
                array (
                    'id' => 427,
                    'name' => 'East Flanders',
                    'country_id' => 22,
                ),
            427 =>
                array (
                    'id' => 428,
                    'name' => 'Hainaut',
                    'country_id' => 22,
                ),
            428 =>
                array (
                    'id' => 429,
                    'name' => 'Liege',
                    'country_id' => 22,
                ),
            429 =>
                array (
                    'id' => 430,
                    'name' => 'Limburg',
                    'country_id' => 22,
                ),
            430 =>
                array (
                    'id' => 431,
                    'name' => 'Luxembourg',
                    'country_id' => 22,
                ),
            431 =>
                array (
                    'id' => 432,
                    'name' => 'Namur',
                    'country_id' => 22,
                ),
            432 =>
                array (
                    'id' => 433,
                    'name' => 'Ontario',
                    'country_id' => 22,
                ),
            433 =>
                array (
                    'id' => 434,
                    'name' => 'Oost-Vlaanderen',
                    'country_id' => 22,
                ),
            434 =>
                array (
                    'id' => 435,
                    'name' => 'Provincie Brabant',
                    'country_id' => 22,
                ),
            435 =>
                array (
                    'id' => 436,
                    'name' => 'Vlaams-Brabant',
                    'country_id' => 22,
                ),
            436 =>
                array (
                    'id' => 437,
                    'name' => 'Wallonne',
                    'country_id' => 22,
                ),
            437 =>
                array (
                    'id' => 438,
                    'name' => 'West-Vlaanderen',
                    'country_id' => 22,
                ),
            438 =>
                array (
                    'id' => 439,
                    'name' => 'Belize',
                    'country_id' => 23,
                ),
            439 =>
                array (
                    'id' => 440,
                    'name' => 'Cayo',
                    'country_id' => 23,
                ),
            440 =>
                array (
                    'id' => 441,
                    'name' => 'Corozal',
                    'country_id' => 23,
                ),
            441 =>
                array (
                    'id' => 442,
                    'name' => 'Orange Walk',
                    'country_id' => 23,
                ),
            442 =>
                array (
                    'id' => 443,
                    'name' => 'Stann Creek',
                    'country_id' => 23,
                ),
            443 =>
                array (
                    'id' => 444,
                    'name' => 'Toledo',
                    'country_id' => 23,
                ),
            444 =>
                array (
                    'id' => 445,
                    'name' => 'Alibori',
                    'country_id' => 24,
                ),
            445 =>
                array (
                    'id' => 446,
                    'name' => 'Atacora',
                    'country_id' => 24,
                ),
            446 =>
                array (
                    'id' => 447,
                    'name' => 'Atlantique',
                    'country_id' => 24,
                ),
            447 =>
                array (
                    'id' => 448,
                    'name' => 'Borgou',
                    'country_id' => 24,
                ),
            448 =>
                array (
                    'id' => 449,
                    'name' => 'Collines',
                    'country_id' => 24,
                ),
            449 =>
                array (
                    'id' => 450,
                    'name' => 'Couffo',
                    'country_id' => 24,
                ),
            450 =>
                array (
                    'id' => 451,
                    'name' => 'Donga',
                    'country_id' => 24,
                ),
            451 =>
                array (
                    'id' => 452,
                    'name' => 'Littoral',
                    'country_id' => 24,
                ),
            452 =>
                array (
                    'id' => 453,
                    'name' => 'Mono',
                    'country_id' => 24,
                ),
            453 =>
                array (
                    'id' => 454,
                    'name' => 'Oueme',
                    'country_id' => 24,
                ),
            454 =>
                array (
                    'id' => 455,
                    'name' => 'Plateau',
                    'country_id' => 24,
                ),
            455 =>
                array (
                    'id' => 456,
                    'name' => 'Zou',
                    'country_id' => 24,
                ),
            456 =>
                array (
                    'id' => 457,
                    'name' => 'Hamilton',
                    'country_id' => 25,
                ),
            457 =>
                array (
                    'id' => 458,
                    'name' => 'Saint George',
                    'country_id' => 25,
                ),
            458 =>
                array (
                    'id' => 459,
                    'name' => 'Bumthang',
                    'country_id' => 26,
                ),
            459 =>
                array (
                    'id' => 460,
                    'name' => 'Chhukha',
                    'country_id' => 26,
                ),
            460 =>
                array (
                    'id' => 461,
                    'name' => 'Chirang',
                    'country_id' => 26,
                ),
            461 =>
                array (
                    'id' => 462,
                    'name' => 'Daga',
                    'country_id' => 26,
                ),
            462 =>
                array (
                    'id' => 463,
                    'name' => 'Geylegphug',
                    'country_id' => 26,
                ),
            463 =>
                array (
                    'id' => 464,
                    'name' => 'Ha',
                    'country_id' => 26,
                ),
            464 =>
                array (
                    'id' => 465,
                    'name' => 'Lhuntshi',
                    'country_id' => 26,
                ),
            465 =>
                array (
                    'id' => 466,
                    'name' => 'Mongar',
                    'country_id' => 26,
                ),
            466 =>
                array (
                    'id' => 467,
                    'name' => 'Pemagatsel',
                    'country_id' => 26,
                ),
            467 =>
                array (
                    'id' => 468,
                    'name' => 'Punakha',
                    'country_id' => 26,
                ),
            468 =>
                array (
                    'id' => 469,
                    'name' => 'Rinpung',
                    'country_id' => 26,
                ),
            469 =>
                array (
                    'id' => 470,
                    'name' => 'Samchi',
                    'country_id' => 26,
                ),
            470 =>
                array (
                    'id' => 471,
                    'name' => 'Samdrup Jongkhar',
                    'country_id' => 26,
                ),
            471 =>
                array (
                    'id' => 472,
                    'name' => 'Shemgang',
                    'country_id' => 26,
                ),
            472 =>
                array (
                    'id' => 473,
                    'name' => 'Tashigang',
                    'country_id' => 26,
                ),
            473 =>
                array (
                    'id' => 474,
                    'name' => 'Timphu',
                    'country_id' => 26,
                ),
            474 =>
                array (
                    'id' => 475,
                    'name' => 'Tongsa',
                    'country_id' => 26,
                ),
            475 =>
                array (
                    'id' => 476,
                    'name' => 'Wangdiphodrang',
                    'country_id' => 26,
                ),
            476 =>
                array (
                    'id' => 477,
                    'name' => 'Beni',
                    'country_id' => 27,
                ),
            477 =>
                array (
                    'id' => 478,
                    'name' => 'Chuquisaca',
                    'country_id' => 27,
                ),
            478 =>
                array (
                    'id' => 479,
                    'name' => 'Cochabamba',
                    'country_id' => 27,
                ),
            479 =>
                array (
                    'id' => 480,
                    'name' => 'La Paz',
                    'country_id' => 27,
                ),
            480 =>
                array (
                    'id' => 481,
                    'name' => 'Oruro',
                    'country_id' => 27,
                ),
            481 =>
                array (
                    'id' => 482,
                    'name' => 'Pando',
                    'country_id' => 27,
                ),
            482 =>
                array (
                    'id' => 483,
                    'name' => 'Potosi',
                    'country_id' => 27,
                ),
            483 =>
                array (
                    'id' => 484,
                    'name' => 'Santa Cruz',
                    'country_id' => 27,
                ),
            484 =>
                array (
                    'id' => 485,
                    'name' => 'Tarija',
                    'country_id' => 27,
                ),
            485 =>
                array (
                    'id' => 486,
                    'name' => 'Federacija Bosna i Hercegovina',
                    'country_id' => 28,
                ),
            486 =>
                array (
                    'id' => 487,
                    'name' => 'Republika Srpska',
                    'country_id' => 28,
                ),
            487 =>
                array (
                    'id' => 488,
                    'name' => 'Central Bobonong',
                    'country_id' => 29,
                ),
            488 =>
                array (
                    'id' => 489,
                    'name' => 'Central Boteti',
                    'country_id' => 29,
                ),
            489 =>
                array (
                    'id' => 490,
                    'name' => 'Central Mahalapye',
                    'country_id' => 29,
                ),
            490 =>
                array (
                    'id' => 491,
                    'name' => 'Central Serowe-Palapye',
                    'country_id' => 29,
                ),
            491 =>
                array (
                    'id' => 492,
                    'name' => 'Central Tutume',
                    'country_id' => 29,
                ),
            492 =>
                array (
                    'id' => 493,
                    'name' => 'Chobe',
                    'country_id' => 29,
                ),
            493 =>
                array (
                    'id' => 494,
                    'name' => 'Francistown',
                    'country_id' => 29,
                ),
            494 =>
                array (
                    'id' => 495,
                    'name' => 'Gaborone',
                    'country_id' => 29,
                ),
            495 =>
                array (
                    'id' => 496,
                    'name' => 'Ghanzi',
                    'country_id' => 29,
                ),
            496 =>
                array (
                    'id' => 497,
                    'name' => 'Jwaneng',
                    'country_id' => 29,
                ),
            497 =>
                array (
                    'id' => 498,
                    'name' => 'Kgalagadi North',
                    'country_id' => 29,
                ),
            498 =>
                array (
                    'id' => 499,
                    'name' => 'Kgalagadi South',
                    'country_id' => 29,
                ),
            499 =>
                array (
                    'id' => 500,
                    'name' => 'Kgatleng',
                    'country_id' => 29,
                ),
            500 =>
                array (
                    'id' => 501,
                    'name' => 'Kweneng',
                    'country_id' => 29,
                ),
            501 =>
                array (
                    'id' => 502,
                    'name' => 'Lobatse',
                    'country_id' => 29,
                ),
            502 =>
                array (
                    'id' => 503,
                    'name' => 'Ngamiland',
                    'country_id' => 29,
                ),
            503 =>
                array (
                    'id' => 504,
                    'name' => 'Ngwaketse',
                    'country_id' => 29,
                ),
            504 =>
                array (
                    'id' => 505,
                    'name' => 'North East',
                    'country_id' => 29,
                ),
            505 =>
                array (
                    'id' => 506,
                    'name' => 'Okavango',
                    'country_id' => 29,
                ),
            506 =>
                array (
                    'id' => 507,
                    'name' => 'Orapa',
                    'country_id' => 29,
                ),
            507 =>
                array (
                    'id' => 508,
                    'name' => 'Selibe Phikwe',
                    'country_id' => 29,
                ),
            508 =>
                array (
                    'id' => 509,
                    'name' => 'South East',
                    'country_id' => 29,
                ),
            509 =>
                array (
                    'id' => 510,
                    'name' => 'Sowa',
                    'country_id' => 29,
                ),
            510 =>
                array (
                    'id' => 511,
                    'name' => 'Bouvet Island',
                    'country_id' => 30,
                ),
            511 =>
                array (
                    'id' => 512,
                    'name' => 'Acre',
                    'country_id' => 31,
                ),
            512 =>
                array (
                    'id' => 513,
                    'name' => 'Alagoas',
                    'country_id' => 31,
                ),
            513 =>
                array (
                    'id' => 514,
                    'name' => 'Amapa',
                    'country_id' => 31,
                ),
            514 =>
                array (
                    'id' => 515,
                    'name' => 'Amazonas',
                    'country_id' => 31,
                ),
            515 =>
                array (
                    'id' => 516,
                    'name' => 'Bahia',
                    'country_id' => 31,
                ),
            516 =>
                array (
                    'id' => 517,
                    'name' => 'Ceara',
                    'country_id' => 31,
                ),
            517 =>
                array (
                    'id' => 518,
                    'name' => 'Distrito Federal',
                    'country_id' => 31,
                ),
            518 =>
                array (
                    'id' => 519,
                    'name' => 'Espirito Santo',
                    'country_id' => 31,
                ),
            519 =>
                array (
                    'id' => 520,
                    'name' => 'Estado de Sao Paulo',
                    'country_id' => 31,
                ),
            520 =>
                array (
                    'id' => 521,
                    'name' => 'Goias',
                    'country_id' => 31,
                ),
            521 =>
                array (
                    'id' => 522,
                    'name' => 'Maranhao',
                    'country_id' => 31,
                ),
            522 =>
                array (
                    'id' => 523,
                    'name' => 'Mato Grosso',
                    'country_id' => 31,
                ),
            523 =>
                array (
                    'id' => 524,
                    'name' => 'Mato Grosso do Sul',
                    'country_id' => 31,
                ),
            524 =>
                array (
                    'id' => 525,
                    'name' => 'Minas Gerais',
                    'country_id' => 31,
                ),
            525 =>
                array (
                    'id' => 526,
                    'name' => 'Para',
                    'country_id' => 31,
                ),
            526 =>
                array (
                    'id' => 527,
                    'name' => 'Paraiba',
                    'country_id' => 31,
                ),
            527 =>
                array (
                    'id' => 528,
                    'name' => 'Parana',
                    'country_id' => 31,
                ),
            528 =>
                array (
                    'id' => 529,
                    'name' => 'Pernambuco',
                    'country_id' => 31,
                ),
            529 =>
                array (
                    'id' => 530,
                    'name' => 'Piaui',
                    'country_id' => 31,
                ),
            530 =>
                array (
                    'id' => 531,
                    'name' => 'Rio Grande do Norte',
                    'country_id' => 31,
                ),
            531 =>
                array (
                    'id' => 532,
                    'name' => 'Rio Grande do Sul',
                    'country_id' => 31,
                ),
            532 =>
                array (
                    'id' => 533,
                    'name' => 'Rio de Janeiro',
                    'country_id' => 31,
                ),
            533 =>
                array (
                    'id' => 534,
                    'name' => 'Rondonia',
                    'country_id' => 31,
                ),
            534 =>
                array (
                    'id' => 535,
                    'name' => 'Roraima',
                    'country_id' => 31,
                ),
            535 =>
                array (
                    'id' => 536,
                    'name' => 'Santa Catarina',
                    'country_id' => 31,
                ),
            536 =>
                array (
                    'id' => 537,
                    'name' => 'Sao Paulo',
                    'country_id' => 31,
                ),
            537 =>
                array (
                    'id' => 538,
                    'name' => 'Sergipe',
                    'country_id' => 31,
                ),
            538 =>
                array (
                    'id' => 539,
                    'name' => 'Tocantins',
                    'country_id' => 31,
                ),
            539 =>
                array (
                    'id' => 540,
                    'name' => 'British Indian Ocean Territory',
                    'country_id' => 32,
                ),
            540 =>
                array (
                    'id' => 541,
                    'name' => 'Belait',
                    'country_id' => 33,
                ),
            541 =>
                array (
                    'id' => 542,
                    'name' => 'Brunei-Muara',
                    'country_id' => 33,
                ),
            542 =>
                array (
                    'id' => 543,
                    'name' => 'Temburong',
                    'country_id' => 33,
                ),
            543 =>
                array (
                    'id' => 544,
                    'name' => 'Tutong',
                    'country_id' => 33,
                ),
            544 =>
                array (
                    'id' => 545,
                    'name' => 'Blagoevgrad',
                    'country_id' => 34,
                ),
            545 =>
                array (
                    'id' => 546,
                    'name' => 'Burgas',
                    'country_id' => 34,
                ),
            546 =>
                array (
                    'id' => 547,
                    'name' => 'Dobrich',
                    'country_id' => 34,
                ),
            547 =>
                array (
                    'id' => 548,
                    'name' => 'Gabrovo',
                    'country_id' => 34,
                ),
            548 =>
                array (
                    'id' => 549,
                    'name' => 'Haskovo',
                    'country_id' => 34,
                ),
            549 =>
                array (
                    'id' => 550,
                    'name' => 'Jambol',
                    'country_id' => 34,
                ),
            550 =>
                array (
                    'id' => 551,
                    'name' => 'Kardzhali',
                    'country_id' => 34,
                ),
            551 =>
                array (
                    'id' => 552,
                    'name' => 'Kjustendil',
                    'country_id' => 34,
                ),
            552 =>
                array (
                    'id' => 553,
                    'name' => 'Lovech',
                    'country_id' => 34,
                ),
            553 =>
                array (
                    'id' => 554,
                    'name' => 'Montana',
                    'country_id' => 34,
                ),
            554 =>
                array (
                    'id' => 555,
                    'name' => 'Oblast Sofiya-Grad',
                    'country_id' => 34,
                ),
            555 =>
                array (
                    'id' => 556,
                    'name' => 'Pazardzhik',
                    'country_id' => 34,
                ),
            556 =>
                array (
                    'id' => 557,
                    'name' => 'Pernik',
                    'country_id' => 34,
                ),
            557 =>
                array (
                    'id' => 558,
                    'name' => 'Pleven',
                    'country_id' => 34,
                ),
            558 =>
                array (
                    'id' => 559,
                    'name' => 'Plovdiv',
                    'country_id' => 34,
                ),
            559 =>
                array (
                    'id' => 560,
                    'name' => 'Razgrad',
                    'country_id' => 34,
                ),
            560 =>
                array (
                    'id' => 561,
                    'name' => 'Ruse',
                    'country_id' => 34,
                ),
            561 =>
                array (
                    'id' => 562,
                    'name' => 'Shumen',
                    'country_id' => 34,
                ),
            562 =>
                array (
                    'id' => 563,
                    'name' => 'Silistra',
                    'country_id' => 34,
                ),
            563 =>
                array (
                    'id' => 564,
                    'name' => 'Sliven',
                    'country_id' => 34,
                ),
            564 =>
                array (
                    'id' => 565,
                    'name' => 'Smoljan',
                    'country_id' => 34,
                ),
            565 =>
                array (
                    'id' => 566,
                    'name' => 'Sofija grad',
                    'country_id' => 34,
                ),
            566 =>
                array (
                    'id' => 567,
                    'name' => 'Sofijska oblast',
                    'country_id' => 34,
                ),
            567 =>
                array (
                    'id' => 568,
                    'name' => 'Stara Zagora',
                    'country_id' => 34,
                ),
            568 =>
                array (
                    'id' => 569,
                    'name' => 'Targovishte',
                    'country_id' => 34,
                ),
            569 =>
                array (
                    'id' => 570,
                    'name' => 'Varna',
                    'country_id' => 34,
                ),
            570 =>
                array (
                    'id' => 571,
                    'name' => 'Veliko Tarnovo',
                    'country_id' => 34,
                ),
            571 =>
                array (
                    'id' => 572,
                    'name' => 'Vidin',
                    'country_id' => 34,
                ),
            572 =>
                array (
                    'id' => 573,
                    'name' => 'Vraca',
                    'country_id' => 34,
                ),
            573 =>
                array (
                    'id' => 574,
                    'name' => 'Yablaniza',
                    'country_id' => 34,
                ),
            574 =>
                array (
                    'id' => 575,
                    'name' => 'Bale',
                    'country_id' => 35,
                ),
            575 =>
                array (
                    'id' => 576,
                    'name' => 'Bam',
                    'country_id' => 35,
                ),
            576 =>
                array (
                    'id' => 577,
                    'name' => 'Bazega',
                    'country_id' => 35,
                ),
            577 =>
                array (
                    'id' => 578,
                    'name' => 'Bougouriba',
                    'country_id' => 35,
                ),
            578 =>
                array (
                    'id' => 579,
                    'name' => 'Boulgou',
                    'country_id' => 35,
                ),
            579 =>
                array (
                    'id' => 580,
                    'name' => 'Boulkiemde',
                    'country_id' => 35,
                ),
            580 =>
                array (
                    'id' => 581,
                    'name' => 'Comoe',
                    'country_id' => 35,
                ),
            581 =>
                array (
                    'id' => 582,
                    'name' => 'Ganzourgou',
                    'country_id' => 35,
                ),
            582 =>
                array (
                    'id' => 583,
                    'name' => 'Gnagna',
                    'country_id' => 35,
                ),
            583 =>
                array (
                    'id' => 584,
                    'name' => 'Gourma',
                    'country_id' => 35,
                ),
            584 =>
                array (
                    'id' => 585,
                    'name' => 'Houet',
                    'country_id' => 35,
                ),
            585 =>
                array (
                    'id' => 586,
                    'name' => 'Ioba',
                    'country_id' => 35,
                ),
            586 =>
                array (
                    'id' => 587,
                    'name' => 'Kadiogo',
                    'country_id' => 35,
                ),
            587 =>
                array (
                    'id' => 588,
                    'name' => 'Kenedougou',
                    'country_id' => 35,
                ),
            588 =>
                array (
                    'id' => 589,
                    'name' => 'Komandjari',
                    'country_id' => 35,
                ),
            589 =>
                array (
                    'id' => 590,
                    'name' => 'Kompienga',
                    'country_id' => 35,
                ),
            590 =>
                array (
                    'id' => 591,
                    'name' => 'Kossi',
                    'country_id' => 35,
                ),
            591 =>
                array (
                    'id' => 592,
                    'name' => 'Kouritenga',
                    'country_id' => 35,
                ),
            592 =>
                array (
                    'id' => 593,
                    'name' => 'Kourweogo',
                    'country_id' => 35,
                ),
            593 =>
                array (
                    'id' => 594,
                    'name' => 'Leraba',
                    'country_id' => 35,
                ),
            594 =>
                array (
                    'id' => 595,
                    'name' => 'Mouhoun',
                    'country_id' => 35,
                ),
            595 =>
                array (
                    'id' => 596,
                    'name' => 'Nahouri',
                    'country_id' => 35,
                ),
            596 =>
                array (
                    'id' => 597,
                    'name' => 'Namentenga',
                    'country_id' => 35,
                ),
            597 =>
                array (
                    'id' => 598,
                    'name' => 'Noumbiel',
                    'country_id' => 35,
                ),
            598 =>
                array (
                    'id' => 599,
                    'name' => 'Oubritenga',
                    'country_id' => 35,
                ),
            599 =>
                array (
                    'id' => 600,
                    'name' => 'Oudalan',
                    'country_id' => 35,
                ),
            600 =>
                array (
                    'id' => 601,
                    'name' => 'Passore',
                    'country_id' => 35,
                ),
            601 =>
                array (
                    'id' => 602,
                    'name' => 'Poni',
                    'country_id' => 35,
                ),
            602 =>
                array (
                    'id' => 603,
                    'name' => 'Sanguie',
                    'country_id' => 35,
                ),
            603 =>
                array (
                    'id' => 604,
                    'name' => 'Sanmatenga',
                    'country_id' => 35,
                ),
            604 =>
                array (
                    'id' => 605,
                    'name' => 'Seno',
                    'country_id' => 35,
                ),
            605 =>
                array (
                    'id' => 606,
                    'name' => 'Sissili',
                    'country_id' => 35,
                ),
            606 =>
                array (
                    'id' => 607,
                    'name' => 'Soum',
                    'country_id' => 35,
                ),
            607 =>
                array (
                    'id' => 608,
                    'name' => 'Sourou',
                    'country_id' => 35,
                ),
            608 =>
                array (
                    'id' => 609,
                    'name' => 'Tapoa',
                    'country_id' => 35,
                ),
            609 =>
                array (
                    'id' => 610,
                    'name' => 'Tuy',
                    'country_id' => 35,
                ),
            610 =>
                array (
                    'id' => 611,
                    'name' => 'Yatenga',
                    'country_id' => 35,
                ),
            611 =>
                array (
                    'id' => 612,
                    'name' => 'Zondoma',
                    'country_id' => 35,
                ),
            612 =>
                array (
                    'id' => 613,
                    'name' => 'Zoundweogo',
                    'country_id' => 35,
                ),
            613 =>
                array (
                    'id' => 614,
                    'name' => 'Bubanza',
                    'country_id' => 36,
                ),
            614 =>
                array (
                    'id' => 615,
                    'name' => 'Bujumbura',
                    'country_id' => 36,
                ),
            615 =>
                array (
                    'id' => 616,
                    'name' => 'Bururi',
                    'country_id' => 36,
                ),
            616 =>
                array (
                    'id' => 617,
                    'name' => 'Cankuzo',
                    'country_id' => 36,
                ),
            617 =>
                array (
                    'id' => 618,
                    'name' => 'Cibitoke',
                    'country_id' => 36,
                ),
            618 =>
                array (
                    'id' => 619,
                    'name' => 'Gitega',
                    'country_id' => 36,
                ),
            619 =>
                array (
                    'id' => 620,
                    'name' => 'Karuzi',
                    'country_id' => 36,
                ),
            620 =>
                array (
                    'id' => 621,
                    'name' => 'Kayanza',
                    'country_id' => 36,
                ),
            621 =>
                array (
                    'id' => 622,
                    'name' => 'Kirundo',
                    'country_id' => 36,
                ),
            622 =>
                array (
                    'id' => 623,
                    'name' => 'Makamba',
                    'country_id' => 36,
                ),
            623 =>
                array (
                    'id' => 624,
                    'name' => 'Muramvya',
                    'country_id' => 36,
                ),
            624 =>
                array (
                    'id' => 625,
                    'name' => 'Muyinga',
                    'country_id' => 36,
                ),
            625 =>
                array (
                    'id' => 626,
                    'name' => 'Ngozi',
                    'country_id' => 36,
                ),
            626 =>
                array (
                    'id' => 627,
                    'name' => 'Rutana',
                    'country_id' => 36,
                ),
            627 =>
                array (
                    'id' => 628,
                    'name' => 'Ruyigi',
                    'country_id' => 36,
                ),
            628 =>
                array (
                    'id' => 629,
                    'name' => 'Banteay Mean Chey',
                    'country_id' => 37,
                ),
            629 =>
                array (
                    'id' => 630,
                    'name' => 'Bat Dambang',
                    'country_id' => 37,
                ),
            630 =>
                array (
                    'id' => 631,
                    'name' => 'Kampong Cham',
                    'country_id' => 37,
                ),
            631 =>
                array (
                    'id' => 632,
                    'name' => 'Kampong Chhnang',
                    'country_id' => 37,
                ),
            632 =>
                array (
                    'id' => 633,
                    'name' => 'Kampong Spoeu',
                    'country_id' => 37,
                ),
            633 =>
                array (
                    'id' => 634,
                    'name' => 'Kampong Thum',
                    'country_id' => 37,
                ),
            634 =>
                array (
                    'id' => 635,
                    'name' => 'Kampot',
                    'country_id' => 37,
                ),
            635 =>
                array (
                    'id' => 636,
                    'name' => 'Kandal',
                    'country_id' => 37,
                ),
            636 =>
                array (
                    'id' => 637,
                    'name' => 'Kaoh Kong',
                    'country_id' => 37,
                ),
            637 =>
                array (
                    'id' => 638,
                    'name' => 'Kracheh',
                    'country_id' => 37,
                ),
            638 =>
                array (
                    'id' => 639,
                    'name' => 'Krong Kaeb',
                    'country_id' => 37,
                ),
            639 =>
                array (
                    'id' => 640,
                    'name' => 'Krong Pailin',
                    'country_id' => 37,
                ),
            640 =>
                array (
                    'id' => 641,
                    'name' => 'Krong Preah Sihanouk',
                    'country_id' => 37,
                ),
            641 =>
                array (
                    'id' => 642,
                    'name' => 'Mondol Kiri',
                    'country_id' => 37,
                ),
            642 =>
                array (
                    'id' => 643,
                    'name' => 'Otdar Mean Chey',
                    'country_id' => 37,
                ),
            643 =>
                array (
                    'id' => 644,
                    'name' => 'Phnum Penh',
                    'country_id' => 37,
                ),
            644 =>
                array (
                    'id' => 645,
                    'name' => 'Pousat',
                    'country_id' => 37,
                ),
            645 =>
                array (
                    'id' => 646,
                    'name' => 'Preah Vihear',
                    'country_id' => 37,
                ),
            646 =>
                array (
                    'id' => 647,
                    'name' => 'Prey Veaeng',
                    'country_id' => 37,
                ),
            647 =>
                array (
                    'id' => 648,
                    'name' => 'Rotanak Kiri',
                    'country_id' => 37,
                ),
            648 =>
                array (
                    'id' => 649,
                    'name' => 'Siem Reab',
                    'country_id' => 37,
                ),
            649 =>
                array (
                    'id' => 650,
                    'name' => 'Stueng Traeng',
                    'country_id' => 37,
                ),
            650 =>
                array (
                    'id' => 651,
                    'name' => 'Svay Rieng',
                    'country_id' => 37,
                ),
            651 =>
                array (
                    'id' => 652,
                    'name' => 'Takaev',
                    'country_id' => 37,
                ),
            652 =>
                array (
                    'id' => 653,
                    'name' => 'Adamaoua',
                    'country_id' => 38,
                ),
            653 =>
                array (
                    'id' => 654,
                    'name' => 'Centre',
                    'country_id' => 38,
                ),
            654 =>
                array (
                    'id' => 655,
                    'name' => 'Est',
                    'country_id' => 38,
                ),
            655 =>
                array (
                    'id' => 656,
                    'name' => 'Littoral',
                    'country_id' => 38,
                ),
            656 =>
                array (
                    'id' => 657,
                    'name' => 'Nord',
                    'country_id' => 38,
                ),
            657 =>
                array (
                    'id' => 658,
                    'name' => 'Nord Extreme',
                    'country_id' => 38,
                ),
            658 =>
                array (
                    'id' => 659,
                    'name' => 'Nordouest',
                    'country_id' => 38,
                ),
            659 =>
                array (
                    'id' => 660,
                    'name' => 'Ouest',
                    'country_id' => 38,
                ),
            660 =>
                array (
                    'id' => 661,
                    'name' => 'Sud',
                    'country_id' => 38,
                ),
            661 =>
                array (
                    'id' => 662,
                    'name' => 'Sudouest',
                    'country_id' => 38,
                ),
            662 =>
                array (
                    'id' => 663,
                    'name' => 'Alberta',
                    'country_id' => 39,
                ),
            663 =>
                array (
                    'id' => 664,
                    'name' => 'British Columbia',
                    'country_id' => 39,
                ),
            664 =>
                array (
                    'id' => 665,
                    'name' => 'Manitoba',
                    'country_id' => 39,
                ),
            665 =>
                array (
                    'id' => 666,
                    'name' => 'New Brunswick',
                    'country_id' => 39,
                ),
            666 =>
                array (
                    'id' => 667,
                    'name' => 'Newfoundland and Labrador',
                    'country_id' => 39,
                ),
            667 =>
                array (
                    'id' => 668,
                    'name' => 'Northwest Territories',
                    'country_id' => 39,
                ),
            668 =>
                array (
                    'id' => 669,
                    'name' => 'Nova Scotia',
                    'country_id' => 39,
                ),
            669 =>
                array (
                    'id' => 670,
                    'name' => 'Nunavut',
                    'country_id' => 39,
                ),
            670 =>
                array (
                    'id' => 671,
                    'name' => 'Ontario',
                    'country_id' => 39,
                ),
            671 =>
                array (
                    'id' => 672,
                    'name' => 'Prince Edward Island',
                    'country_id' => 39,
                ),
            672 =>
                array (
                    'id' => 673,
                    'name' => 'Quebec',
                    'country_id' => 39,
                ),
            673 =>
                array (
                    'id' => 674,
                    'name' => 'Saskatchewan',
                    'country_id' => 39,
                ),
            674 =>
                array (
                    'id' => 675,
                    'name' => 'Yukon',
                    'country_id' => 39,
                ),
            675 =>
                array (
                    'id' => 676,
                    'name' => 'Boavista',
                    'country_id' => 40,
                ),
            676 =>
                array (
                    'id' => 677,
                    'name' => 'Brava',
                    'country_id' => 40,
                ),
            677 =>
                array (
                    'id' => 678,
                    'name' => 'Fogo',
                    'country_id' => 40,
                ),
            678 =>
                array (
                    'id' => 679,
                    'name' => 'Maio',
                    'country_id' => 40,
                ),
            679 =>
                array (
                    'id' => 680,
                    'name' => 'Sal',
                    'country_id' => 40,
                ),
            680 =>
                array (
                    'id' => 681,
                    'name' => 'Santo Antao',
                    'country_id' => 40,
                ),
            681 =>
                array (
                    'id' => 682,
                    'name' => 'Sao Nicolau',
                    'country_id' => 40,
                ),
            682 =>
                array (
                    'id' => 683,
                    'name' => 'Sao Tiago',
                    'country_id' => 40,
                ),
            683 =>
                array (
                    'id' => 684,
                    'name' => 'Sao Vicente',
                    'country_id' => 40,
                ),
            684 =>
                array (
                    'id' => 685,
                    'name' => 'Grand Cayman',
                    'country_id' => 41,
                ),
            685 =>
                array (
                    'id' => 686,
                    'name' => 'Bamingui-Bangoran',
                    'country_id' => 42,
                ),
            686 =>
                array (
                    'id' => 687,
                    'name' => 'Bangui',
                    'country_id' => 42,
                ),
            687 =>
                array (
                    'id' => 688,
                    'name' => 'Basse-Kotto',
                    'country_id' => 42,
                ),
            688 =>
                array (
                    'id' => 689,
                    'name' => 'Haut-Mbomou',
                    'country_id' => 42,
                ),
            689 =>
                array (
                    'id' => 690,
                    'name' => 'Haute-Kotto',
                    'country_id' => 42,
                ),
            690 =>
                array (
                    'id' => 691,
                    'name' => 'Kemo',
                    'country_id' => 42,
                ),
            691 =>
                array (
                    'id' => 692,
                    'name' => 'Lobaye',
                    'country_id' => 42,
                ),
            692 =>
                array (
                    'id' => 693,
                    'name' => 'Mambere-Kadei',
                    'country_id' => 42,
                ),
            693 =>
                array (
                    'id' => 694,
                    'name' => 'Mbomou',
                    'country_id' => 42,
                ),
            694 =>
                array (
                    'id' => 695,
                    'name' => 'Nana-Gribizi',
                    'country_id' => 42,
                ),
            695 =>
                array (
                    'id' => 696,
                    'name' => 'Nana-Mambere',
                    'country_id' => 42,
                ),
            696 =>
                array (
                    'id' => 697,
                    'name' => 'Ombella Mpoko',
                    'country_id' => 42,
                ),
            697 =>
                array (
                    'id' => 698,
                    'name' => 'Ouaka',
                    'country_id' => 42,
                ),
            698 =>
                array (
                    'id' => 699,
                    'name' => 'Ouham',
                    'country_id' => 42,
                ),
            699 =>
                array (
                    'id' => 700,
                    'name' => 'Ouham-Pende',
                    'country_id' => 42,
                ),
            700 =>
                array (
                    'id' => 701,
                    'name' => 'Sangha-Mbaere',
                    'country_id' => 42,
                ),
            701 =>
                array (
                    'id' => 702,
                    'name' => 'Vakaga',
                    'country_id' => 42,
                ),
            702 =>
                array (
                    'id' => 703,
                    'name' => 'Batha',
                    'country_id' => 43,
                ),
            703 =>
                array (
                    'id' => 704,
                    'name' => 'Biltine',
                    'country_id' => 43,
                ),
            704 =>
                array (
                    'id' => 705,
                    'name' => 'Bourkou-Ennedi-Tibesti',
                    'country_id' => 43,
                ),
            705 =>
                array (
                    'id' => 706,
                    'name' => 'Chari-Baguirmi',
                    'country_id' => 43,
                ),
            706 =>
                array (
                    'id' => 707,
                    'name' => 'Guera',
                    'country_id' => 43,
                ),
            707 =>
                array (
                    'id' => 708,
                    'name' => 'Kanem',
                    'country_id' => 43,
                ),
            708 =>
                array (
                    'id' => 709,
                    'name' => 'Lac',
                    'country_id' => 43,
                ),
            709 =>
                array (
                    'id' => 710,
                    'name' => 'Logone Occidental',
                    'country_id' => 43,
                ),
            710 =>
                array (
                    'id' => 711,
                    'name' => 'Logone Oriental',
                    'country_id' => 43,
                ),
            711 =>
                array (
                    'id' => 712,
                    'name' => 'Mayo-Kebbi',
                    'country_id' => 43,
                ),
            712 =>
                array (
                    'id' => 713,
                    'name' => 'Moyen-Chari',
                    'country_id' => 43,
                ),
            713 =>
                array (
                    'id' => 714,
                    'name' => 'Ouaddai',
                    'country_id' => 43,
                ),
            714 =>
                array (
                    'id' => 715,
                    'name' => 'Salamat',
                    'country_id' => 43,
                ),
            715 =>
                array (
                    'id' => 716,
                    'name' => 'Tandjile',
                    'country_id' => 43,
                ),
            716 =>
                array (
                    'id' => 717,
                    'name' => 'Aisen',
                    'country_id' => 44,
                ),
            717 =>
                array (
                    'id' => 718,
                    'name' => 'Antofagasta',
                    'country_id' => 44,
                ),
            718 =>
                array (
                    'id' => 719,
                    'name' => 'Araucania',
                    'country_id' => 44,
                ),
            719 =>
                array (
                    'id' => 720,
                    'name' => 'Atacama',
                    'country_id' => 44,
                ),
            720 =>
                array (
                    'id' => 721,
                    'name' => 'Bio Bio',
                    'country_id' => 44,
                ),
            721 =>
                array (
                    'id' => 722,
                    'name' => 'Coquimbo',
                    'country_id' => 44,
                ),
            722 =>
                array (
                    'id' => 723,
                    'name' => 'Libertador General Bernardo O\'',
                    'country_id' => 44,
                ),
            723 =>
                array (
                    'id' => 724,
                    'name' => 'Los Lagos',
                    'country_id' => 44,
                ),
            724 =>
                array (
                    'id' => 725,
                    'name' => 'Magellanes',
                    'country_id' => 44,
                ),
            725 =>
                array (
                    'id' => 726,
                    'name' => 'Maule',
                    'country_id' => 44,
                ),
            726 =>
                array (
                    'id' => 727,
                    'name' => 'Metropolitana',
                    'country_id' => 44,
                ),
            727 =>
                array (
                    'id' => 728,
                    'name' => 'Metropolitana de Santiago',
                    'country_id' => 44,
                ),
            728 =>
                array (
                    'id' => 729,
                    'name' => 'Tarapaca',
                    'country_id' => 44,
                ),
            729 =>
                array (
                    'id' => 730,
                    'name' => 'Valparaiso',
                    'country_id' => 44,
                ),
            730 =>
                array (
                    'id' => 731,
                    'name' => 'Anhui',
                    'country_id' => 45,
                ),
            731 =>
                array (
                    'id' => 732,
                    'name' => 'Anhui Province',
                    'country_id' => 45,
                ),
            732 =>
                array (
                    'id' => 733,
                    'name' => 'Anhui Sheng',
                    'country_id' => 45,
                ),
            733 =>
                array (
                    'id' => 734,
                    'name' => 'Aomen',
                    'country_id' => 45,
                ),
            734 =>
                array (
                    'id' => 735,
                    'name' => 'Beijing',
                    'country_id' => 45,
                ),
            735 =>
                array (
                    'id' => 736,
                    'name' => 'Beijing Shi',
                    'country_id' => 45,
                ),
            736 =>
                array (
                    'id' => 737,
                    'name' => 'Chongqing',
                    'country_id' => 45,
                ),
            737 =>
                array (
                    'id' => 738,
                    'name' => 'Fujian',
                    'country_id' => 45,
                ),
            738 =>
                array (
                    'id' => 739,
                    'name' => 'Fujian Sheng',
                    'country_id' => 45,
                ),
            739 =>
                array (
                    'id' => 740,
                    'name' => 'Gansu',
                    'country_id' => 45,
                ),
            740 =>
                array (
                    'id' => 741,
                    'name' => 'Guangdong',
                    'country_id' => 45,
                ),
            741 =>
                array (
                    'id' => 742,
                    'name' => 'Guangdong Sheng',
                    'country_id' => 45,
                ),
            742 =>
                array (
                    'id' => 743,
                    'name' => 'Guangxi',
                    'country_id' => 45,
                ),
            743 =>
                array (
                    'id' => 744,
                    'name' => 'Guizhou',
                    'country_id' => 45,
                ),
            744 =>
                array (
                    'id' => 745,
                    'name' => 'Hainan',
                    'country_id' => 45,
                ),
            745 =>
                array (
                    'id' => 746,
                    'name' => 'Hebei',
                    'country_id' => 45,
                ),
            746 =>
                array (
                    'id' => 747,
                    'name' => 'Heilongjiang',
                    'country_id' => 45,
                ),
            747 =>
                array (
                    'id' => 748,
                    'name' => 'Henan',
                    'country_id' => 45,
                ),
            748 =>
                array (
                    'id' => 749,
                    'name' => 'Hubei',
                    'country_id' => 45,
                ),
            749 =>
                array (
                    'id' => 750,
                    'name' => 'Hunan',
                    'country_id' => 45,
                ),
            750 =>
                array (
                    'id' => 751,
                    'name' => 'Jiangsu',
                    'country_id' => 45,
                ),
            751 =>
                array (
                    'id' => 752,
                    'name' => 'Jiangsu Sheng',
                    'country_id' => 45,
                ),
            752 =>
                array (
                    'id' => 753,
                    'name' => 'Jiangxi',
                    'country_id' => 45,
                ),
            753 =>
                array (
                    'id' => 754,
                    'name' => 'Jilin',
                    'country_id' => 45,
                ),
            754 =>
                array (
                    'id' => 755,
                    'name' => 'Liaoning',
                    'country_id' => 45,
                ),
            755 =>
                array (
                    'id' => 756,
                    'name' => 'Liaoning Sheng',
                    'country_id' => 45,
                ),
            756 =>
                array (
                    'id' => 757,
                    'name' => 'Nei Monggol',
                    'country_id' => 45,
                ),
            757 =>
                array (
                    'id' => 758,
                    'name' => 'Ningxia Hui',
                    'country_id' => 45,
                ),
            758 =>
                array (
                    'id' => 759,
                    'name' => 'Qinghai',
                    'country_id' => 45,
                ),
            759 =>
                array (
                    'id' => 760,
                    'name' => 'Shaanxi',
                    'country_id' => 45,
                ),
            760 =>
                array (
                    'id' => 761,
                    'name' => 'Shandong',
                    'country_id' => 45,
                ),
            761 =>
                array (
                    'id' => 762,
                    'name' => 'Shandong Sheng',
                    'country_id' => 45,
                ),
            762 =>
                array (
                    'id' => 763,
                    'name' => 'Shanghai',
                    'country_id' => 45,
                ),
            763 =>
                array (
                    'id' => 764,
                    'name' => 'Shanxi',
                    'country_id' => 45,
                ),
            764 =>
                array (
                    'id' => 765,
                    'name' => 'Sichuan',
                    'country_id' => 45,
                ),
            765 =>
                array (
                    'id' => 766,
                    'name' => 'Tianjin',
                    'country_id' => 45,
                ),
            766 =>
                array (
                    'id' => 767,
                    'name' => 'Xianggang',
                    'country_id' => 45,
                ),
            767 =>
                array (
                    'id' => 768,
                    'name' => 'Xinjiang',
                    'country_id' => 45,
                ),
            768 =>
                array (
                    'id' => 769,
                    'name' => 'Xizang',
                    'country_id' => 45,
                ),
            769 =>
                array (
                    'id' => 770,
                    'name' => 'Yunnan',
                    'country_id' => 45,
                ),
            770 =>
                array (
                    'id' => 771,
                    'name' => 'Zhejiang',
                    'country_id' => 45,
                ),
            771 =>
                array (
                    'id' => 772,
                    'name' => 'Zhejiang Sheng',
                    'country_id' => 45,
                ),
            772 =>
                array (
                    'id' => 773,
                    'name' => 'Christmas Island',
                    'country_id' => 46,
                ),
            773 =>
                array (
                    'id' => 774,
                    'name' => 'Cocos (Keeling) Islands',
                    'country_id' => 47,
                ),
            774 =>
                array (
                    'id' => 775,
                    'name' => 'Amazonas',
                    'country_id' => 48,
                ),
            775 =>
                array (
                    'id' => 776,
                    'name' => 'Antioquia',
                    'country_id' => 48,
                ),
            776 =>
                array (
                    'id' => 777,
                    'name' => 'Arauca',
                    'country_id' => 48,
                ),
            777 =>
                array (
                    'id' => 778,
                    'name' => 'Atlantico',
                    'country_id' => 48,
                ),
            778 =>
                array (
                    'id' => 779,
                    'name' => 'Bogota',
                    'country_id' => 48,
                ),
            779 =>
                array (
                    'id' => 780,
                    'name' => 'Bolivar',
                    'country_id' => 48,
                ),
            780 =>
                array (
                    'id' => 781,
                    'name' => 'Boyaca',
                    'country_id' => 48,
                ),
            781 =>
                array (
                    'id' => 782,
                    'name' => 'Caldas',
                    'country_id' => 48,
                ),
            782 =>
                array (
                    'id' => 783,
                    'name' => 'Caqueta',
                    'country_id' => 48,
                ),
            783 =>
                array (
                    'id' => 784,
                    'name' => 'Casanare',
                    'country_id' => 48,
                ),
            784 =>
                array (
                    'id' => 785,
                    'name' => 'Cauca',
                    'country_id' => 48,
                ),
            785 =>
                array (
                    'id' => 786,
                    'name' => 'Cesar',
                    'country_id' => 48,
                ),
            786 =>
                array (
                    'id' => 787,
                    'name' => 'Choco',
                    'country_id' => 48,
                ),
            787 =>
                array (
                    'id' => 788,
                    'name' => 'Cordoba',
                    'country_id' => 48,
                ),
            788 =>
                array (
                    'id' => 789,
                    'name' => 'Cundinamarca',
                    'country_id' => 48,
                ),
            789 =>
                array (
                    'id' => 790,
                    'name' => 'Guainia',
                    'country_id' => 48,
                ),
            790 =>
                array (
                    'id' => 791,
                    'name' => 'Guaviare',
                    'country_id' => 48,
                ),
            791 =>
                array (
                    'id' => 792,
                    'name' => 'Huila',
                    'country_id' => 48,
                ),
            792 =>
                array (
                    'id' => 793,
                    'name' => 'La Guajira',
                    'country_id' => 48,
                ),
            793 =>
                array (
                    'id' => 794,
                    'name' => 'Magdalena',
                    'country_id' => 48,
                ),
            794 =>
                array (
                    'id' => 795,
                    'name' => 'Meta',
                    'country_id' => 48,
                ),
            795 =>
                array (
                    'id' => 796,
                    'name' => 'Narino',
                    'country_id' => 48,
                ),
            796 =>
                array (
                    'id' => 797,
                    'name' => 'Norte de Santander',
                    'country_id' => 48,
                ),
            797 =>
                array (
                    'id' => 798,
                    'name' => 'Putumayo',
                    'country_id' => 48,
                ),
            798 =>
                array (
                    'id' => 799,
                    'name' => 'Quindio',
                    'country_id' => 48,
                ),
            799 =>
                array (
                    'id' => 800,
                    'name' => 'Risaralda',
                    'country_id' => 48,
                ),
            800 =>
                array (
                    'id' => 801,
                    'name' => 'San Andres y Providencia',
                    'country_id' => 48,
                ),
            801 =>
                array (
                    'id' => 802,
                    'name' => 'Santander',
                    'country_id' => 48,
                ),
            802 =>
                array (
                    'id' => 803,
                    'name' => 'Sucre',
                    'country_id' => 48,
                ),
            803 =>
                array (
                    'id' => 804,
                    'name' => 'Tolima',
                    'country_id' => 48,
                ),
            804 =>
                array (
                    'id' => 805,
                    'name' => 'Valle del Cauca',
                    'country_id' => 48,
                ),
            805 =>
                array (
                    'id' => 806,
                    'name' => 'Vaupes',
                    'country_id' => 48,
                ),
            806 =>
                array (
                    'id' => 807,
                    'name' => 'Vichada',
                    'country_id' => 48,
                ),
            807 =>
                array (
                    'id' => 808,
                    'name' => 'Mwali',
                    'country_id' => 49,
                ),
            808 =>
                array (
                    'id' => 809,
                    'name' => 'Njazidja',
                    'country_id' => 49,
                ),
            809 =>
                array (
                    'id' => 810,
                    'name' => 'Nzwani',
                    'country_id' => 49,
                ),
            810 =>
                array (
                    'id' => 811,
                    'name' => 'Bouenza',
                    'country_id' => 50,
                ),
            811 =>
                array (
                    'id' => 812,
                    'name' => 'Brazzaville',
                    'country_id' => 50,
                ),
            812 =>
                array (
                    'id' => 813,
                    'name' => 'Cuvette',
                    'country_id' => 50,
                ),
            813 =>
                array (
                    'id' => 814,
                    'name' => 'Kouilou',
                    'country_id' => 50,
                ),
            814 =>
                array (
                    'id' => 815,
                    'name' => 'Lekoumou',
                    'country_id' => 50,
                ),
            815 =>
                array (
                    'id' => 816,
                    'name' => 'Likouala',
                    'country_id' => 50,
                ),
            816 =>
                array (
                    'id' => 817,
                    'name' => 'Niari',
                    'country_id' => 50,
                ),
            817 =>
                array (
                    'id' => 818,
                    'name' => 'Plateaux',
                    'country_id' => 50,
                ),
            818 =>
                array (
                    'id' => 819,
                    'name' => 'Pool',
                    'country_id' => 50,
                ),
            819 =>
                array (
                    'id' => 820,
                    'name' => 'Sangha',
                    'country_id' => 50,
                ),
            820 =>
                array (
                    'id' => 821,
                    'name' => 'Bandundu',
                    'country_id' => 51,
                ),
            821 =>
                array (
                    'id' => 822,
                    'name' => 'Bas-Congo',
                    'country_id' => 51,
                ),
            822 =>
                array (
                    'id' => 823,
                    'name' => 'Equateur',
                    'country_id' => 51,
                ),
            823 =>
                array (
                    'id' => 824,
                    'name' => 'Haut-Congo',
                    'country_id' => 51,
                ),
            824 =>
                array (
                    'id' => 825,
                    'name' => 'Kasai-Occidental',
                    'country_id' => 51,
                ),
            825 =>
                array (
                    'id' => 826,
                    'name' => 'Kasai-Oriental',
                    'country_id' => 51,
                ),
            826 =>
                array (
                    'id' => 827,
                    'name' => 'Katanga',
                    'country_id' => 51,
                ),
            827 =>
                array (
                    'id' => 828,
                    'name' => 'Kinshasa',
                    'country_id' => 51,
                ),
            828 =>
                array (
                    'id' => 829,
                    'name' => 'Maniema',
                    'country_id' => 51,
                ),
            829 =>
                array (
                    'id' => 830,
                    'name' => 'Nord-Kivu',
                    'country_id' => 51,
                ),
            830 =>
                array (
                    'id' => 831,
                    'name' => 'Sud-Kivu',
                    'country_id' => 51,
                ),
            831 =>
                array (
                    'id' => 832,
                    'name' => 'Aitutaki',
                    'country_id' => 52,
                ),
            832 =>
                array (
                    'id' => 833,
                    'name' => 'Atiu',
                    'country_id' => 52,
                ),
            833 =>
                array (
                    'id' => 834,
                    'name' => 'Mangaia',
                    'country_id' => 52,
                ),
            834 =>
                array (
                    'id' => 835,
                    'name' => 'Manihiki',
                    'country_id' => 52,
                ),
            835 =>
                array (
                    'id' => 836,
                    'name' => 'Mauke',
                    'country_id' => 52,
                ),
            836 =>
                array (
                    'id' => 837,
                    'name' => 'Mitiaro',
                    'country_id' => 52,
                ),
            837 =>
                array (
                    'id' => 838,
                    'name' => 'Nassau',
                    'country_id' => 52,
                ),
            838 =>
                array (
                    'id' => 839,
                    'name' => 'Pukapuka',
                    'country_id' => 52,
                ),
            839 =>
                array (
                    'id' => 840,
                    'name' => 'Rakahanga',
                    'country_id' => 52,
                ),
            840 =>
                array (
                    'id' => 841,
                    'name' => 'Rarotonga',
                    'country_id' => 52,
                ),
            841 =>
                array (
                    'id' => 842,
                    'name' => 'Tongareva',
                    'country_id' => 52,
                ),
            842 =>
                array (
                    'id' => 843,
                    'name' => 'Alajuela',
                    'country_id' => 53,
                ),
            843 =>
                array (
                    'id' => 844,
                    'name' => 'Cartago',
                    'country_id' => 53,
                ),
            844 =>
                array (
                    'id' => 845,
                    'name' => 'Guanacaste',
                    'country_id' => 53,
                ),
            845 =>
                array (
                    'id' => 846,
                    'name' => 'Heredia',
                    'country_id' => 53,
                ),
            846 =>
                array (
                    'id' => 847,
                    'name' => 'Limon',
                    'country_id' => 53,
                ),
            847 =>
                array (
                    'id' => 848,
                    'name' => 'Puntarenas',
                    'country_id' => 53,
                ),
            848 =>
                array (
                    'id' => 849,
                    'name' => 'San Jose',
                    'country_id' => 53,
                ),
            849 =>
                array (
                    'id' => 850,
                    'name' => 'Abidjan',
                    'country_id' => 54,
                ),
            850 =>
                array (
                    'id' => 851,
                    'name' => 'Agneby',
                    'country_id' => 54,
                ),
            851 =>
                array (
                    'id' => 852,
                    'name' => 'Bafing',
                    'country_id' => 54,
                ),
            852 =>
                array (
                    'id' => 853,
                    'name' => 'Denguele',
                    'country_id' => 54,
                ),
            853 =>
                array (
                    'id' => 854,
                    'name' => 'Dix-huit Montagnes',
                    'country_id' => 54,
                ),
            854 =>
                array (
                    'id' => 855,
                    'name' => 'Fromager',
                    'country_id' => 54,
                ),
            855 =>
                array (
                    'id' => 856,
                    'name' => 'Haut-Sassandra',
                    'country_id' => 54,
                ),
            856 =>
                array (
                    'id' => 857,
                    'name' => 'Lacs',
                    'country_id' => 54,
                ),
            857 =>
                array (
                    'id' => 858,
                    'name' => 'Lagunes',
                    'country_id' => 54,
                ),
            858 =>
                array (
                    'id' => 859,
                    'name' => 'Marahoue',
                    'country_id' => 54,
                ),
            859 =>
                array (
                    'id' => 860,
                    'name' => 'Moyen-Cavally',
                    'country_id' => 54,
                ),
            860 =>
                array (
                    'id' => 861,
                    'name' => 'Moyen-Comoe',
                    'country_id' => 54,
                ),
            861 =>
                array (
                    'id' => 862,
                    'name' => 'N\'zi-Comoe',
                    'country_id' => 54,
                ),
            862 =>
                array (
                    'id' => 863,
                    'name' => 'Sassandra',
                    'country_id' => 54,
                ),
            863 =>
                array (
                    'id' => 864,
                    'name' => 'Savanes',
                    'country_id' => 54,
                ),
            864 =>
                array (
                    'id' => 865,
                    'name' => 'Sud-Bandama',
                    'country_id' => 54,
                ),
            865 =>
                array (
                    'id' => 866,
                    'name' => 'Sud-Comoe',
                    'country_id' => 54,
                ),
            866 =>
                array (
                    'id' => 867,
                    'name' => 'Vallee du Bandama',
                    'country_id' => 54,
                ),
            867 =>
                array (
                    'id' => 868,
                    'name' => 'Worodougou',
                    'country_id' => 54,
                ),
            868 =>
                array (
                    'id' => 869,
                    'name' => 'Zanzan',
                    'country_id' => 54,
                ),
            869 =>
                array (
                    'id' => 870,
                    'name' => 'Bjelovar-Bilogora',
                    'country_id' => 55,
                ),
            870 =>
                array (
                    'id' => 871,
                    'name' => 'Dubrovnik-Neretva',
                    'country_id' => 55,
                ),
            871 =>
                array (
                    'id' => 872,
                    'name' => 'Grad Zagreb',
                    'country_id' => 55,
                ),
            872 =>
                array (
                    'id' => 873,
                    'name' => 'Istra',
                    'country_id' => 55,
                ),
            873 =>
                array (
                    'id' => 874,
                    'name' => 'Karlovac',
                    'country_id' => 55,
                ),
            874 =>
                array (
                    'id' => 875,
                    'name' => 'Koprivnica-Krizhevci',
                    'country_id' => 55,
                ),
            875 =>
                array (
                    'id' => 876,
                    'name' => 'Krapina-Zagorje',
                    'country_id' => 55,
                ),
            876 =>
                array (
                    'id' => 877,
                    'name' => 'Lika-Senj',
                    'country_id' => 55,
                ),
            877 =>
                array (
                    'id' => 878,
                    'name' => 'Medhimurje',
                    'country_id' => 55,
                ),
            878 =>
                array (
                    'id' => 879,
                    'name' => 'Medimurska Zupanija',
                    'country_id' => 55,
                ),
            879 =>
                array (
                    'id' => 880,
                    'name' => 'Osijek-Baranja',
                    'country_id' => 55,
                ),
            880 =>
                array (
                    'id' => 881,
                    'name' => 'Osjecko-Baranjska Zupanija',
                    'country_id' => 55,
                ),
            881 =>
                array (
                    'id' => 882,
                    'name' => 'Pozhega-Slavonija',
                    'country_id' => 55,
                ),
            882 =>
                array (
                    'id' => 883,
                    'name' => 'Primorje-Gorski Kotar',
                    'country_id' => 55,
                ),
            883 =>
                array (
                    'id' => 884,
                    'name' => 'Shibenik-Knin',
                    'country_id' => 55,
                ),
            884 =>
                array (
                    'id' => 885,
                    'name' => 'Sisak-Moslavina',
                    'country_id' => 55,
                ),
            885 =>
                array (
                    'id' => 886,
                    'name' => 'Slavonski Brod-Posavina',
                    'country_id' => 55,
                ),
            886 =>
                array (
                    'id' => 887,
                    'name' => 'Split-Dalmacija',
                    'country_id' => 55,
                ),
            887 =>
                array (
                    'id' => 888,
                    'name' => 'Varazhdin',
                    'country_id' => 55,
                ),
            888 =>
                array (
                    'id' => 889,
                    'name' => 'Virovitica-Podravina',
                    'country_id' => 55,
                ),
            889 =>
                array (
                    'id' => 890,
                    'name' => 'Vukovar-Srijem',
                    'country_id' => 55,
                ),
            890 =>
                array (
                    'id' => 891,
                    'name' => 'Zadar',
                    'country_id' => 55,
                ),
            891 =>
                array (
                    'id' => 892,
                    'name' => 'Zagreb',
                    'country_id' => 55,
                ),
            892 =>
                array (
                    'id' => 893,
                    'name' => 'Camaguey',
                    'country_id' => 56,
                ),
            893 =>
                array (
                    'id' => 894,
                    'name' => 'Ciego de Avila',
                    'country_id' => 56,
                ),
            894 =>
                array (
                    'id' => 895,
                    'name' => 'Cienfuegos',
                    'country_id' => 56,
                ),
            895 =>
                array (
                    'id' => 896,
                    'name' => 'Ciudad de la Habana',
                    'country_id' => 56,
                ),
            896 =>
                array (
                    'id' => 897,
                    'name' => 'Granma',
                    'country_id' => 56,
                ),
            897 =>
                array (
                    'id' => 898,
                    'name' => 'Guantanamo',
                    'country_id' => 56,
                ),
            898 =>
                array (
                    'id' => 899,
                    'name' => 'Habana',
                    'country_id' => 56,
                ),
            899 =>
                array (
                    'id' => 900,
                    'name' => 'Holguin',
                    'country_id' => 56,
                ),
            900 =>
                array (
                    'id' => 901,
                    'name' => 'Isla de la Juventud',
                    'country_id' => 56,
                ),
            901 =>
                array (
                    'id' => 902,
                    'name' => 'La Habana',
                    'country_id' => 56,
                ),
            902 =>
                array (
                    'id' => 903,
                    'name' => 'Las Tunas',
                    'country_id' => 56,
                ),
            903 =>
                array (
                    'id' => 904,
                    'name' => 'Matanzas',
                    'country_id' => 56,
                ),
            904 =>
                array (
                    'id' => 905,
                    'name' => 'Pinar del Rio',
                    'country_id' => 56,
                ),
            905 =>
                array (
                    'id' => 906,
                    'name' => 'Sancti Spiritus',
                    'country_id' => 56,
                ),
            906 =>
                array (
                    'id' => 907,
                    'name' => 'Santiago de Cuba',
                    'country_id' => 56,
                ),
            907 =>
                array (
                    'id' => 908,
                    'name' => 'Villa Clara',
                    'country_id' => 56,
                ),
            908 =>
                array (
                    'id' => 909,
                    'name' => 'Government controlled area',
                    'country_id' => 57,
                ),
            909 =>
                array (
                    'id' => 910,
                    'name' => 'Limassol',
                    'country_id' => 57,
                ),
            910 =>
                array (
                    'id' => 911,
                    'name' => 'Nicosia District',
                    'country_id' => 57,
                ),
            911 =>
                array (
                    'id' => 912,
                    'name' => 'Paphos',
                    'country_id' => 57,
                ),
            912 =>
                array (
                    'id' => 913,
                    'name' => 'Turkish controlled area',
                    'country_id' => 57,
                ),
            913 =>
                array (
                    'id' => 914,
                    'name' => 'Central Bohemian',
                    'country_id' => 58,
                ),
            914 =>
                array (
                    'id' => 915,
                    'name' => 'Frycovice',
                    'country_id' => 58,
                ),
            915 =>
                array (
                    'id' => 916,
                    'name' => 'Jihocesky Kraj',
                    'country_id' => 58,
                ),
            916 =>
                array (
                    'id' => 917,
                    'name' => 'Jihochesky',
                    'country_id' => 58,
                ),
            917 =>
                array (
                    'id' => 918,
                    'name' => 'Jihomoravsky',
                    'country_id' => 58,
                ),
            918 =>
                array (
                    'id' => 919,
                    'name' => 'Karlovarsky',
                    'country_id' => 58,
                ),
            919 =>
                array (
                    'id' => 920,
                    'name' => 'Klecany',
                    'country_id' => 58,
                ),
            920 =>
                array (
                    'id' => 921,
                    'name' => 'Kralovehradecky',
                    'country_id' => 58,
                ),
            921 =>
                array (
                    'id' => 922,
                    'name' => 'Liberecky',
                    'country_id' => 58,
                ),
            922 =>
                array (
                    'id' => 923,
                    'name' => 'Lipov',
                    'country_id' => 58,
                ),
            923 =>
                array (
                    'id' => 924,
                    'name' => 'Moravskoslezsky',
                    'country_id' => 58,
                ),
            924 =>
                array (
                    'id' => 925,
                    'name' => 'Olomoucky',
                    'country_id' => 58,
                ),
            925 =>
                array (
                    'id' => 926,
                    'name' => 'Olomoucky Kraj',
                    'country_id' => 58,
                ),
            926 =>
                array (
                    'id' => 927,
                    'name' => 'Pardubicky',
                    'country_id' => 58,
                ),
            927 =>
                array (
                    'id' => 928,
                    'name' => 'Plzensky',
                    'country_id' => 58,
                ),
            928 =>
                array (
                    'id' => 929,
                    'name' => 'Praha',
                    'country_id' => 58,
                ),
            929 =>
                array (
                    'id' => 930,
                    'name' => 'Rajhrad',
                    'country_id' => 58,
                ),
            930 =>
                array (
                    'id' => 931,
                    'name' => 'Smirice',
                    'country_id' => 58,
                ),
            931 =>
                array (
                    'id' => 932,
                    'name' => 'South Moravian',
                    'country_id' => 58,
                ),
            932 =>
                array (
                    'id' => 933,
                    'name' => 'Straz nad Nisou',
                    'country_id' => 58,
                ),
            933 =>
                array (
                    'id' => 934,
                    'name' => 'Stredochesky',
                    'country_id' => 58,
                ),
            934 =>
                array (
                    'id' => 935,
                    'name' => 'Unicov',
                    'country_id' => 58,
                ),
            935 =>
                array (
                    'id' => 936,
                    'name' => 'Ustecky',
                    'country_id' => 58,
                ),
            936 =>
                array (
                    'id' => 937,
                    'name' => 'Valletta',
                    'country_id' => 58,
                ),
            937 =>
                array (
                    'id' => 938,
                    'name' => 'Velesin',
                    'country_id' => 58,
                ),
            938 =>
                array (
                    'id' => 939,
                    'name' => 'Vysochina',
                    'country_id' => 58,
                ),
            939 =>
                array (
                    'id' => 940,
                    'name' => 'Zlinsky',
                    'country_id' => 58,
                ),
            940 =>
                array (
                    'id' => 941,
                    'name' => 'Arhus',
                    'country_id' => 59,
                ),
            941 =>
                array (
                    'id' => 942,
                    'name' => 'Bornholm',
                    'country_id' => 59,
                ),
            942 =>
                array (
                    'id' => 943,
                    'name' => 'Frederiksborg',
                    'country_id' => 59,
                ),
            943 =>
                array (
                    'id' => 944,
                    'name' => 'Fyn',
                    'country_id' => 59,
                ),
            944 =>
                array (
                    'id' => 945,
                    'name' => 'Hovedstaden',
                    'country_id' => 59,
                ),
            945 =>
                array (
                    'id' => 946,
                    'name' => 'Kobenhavn',
                    'country_id' => 59,
                ),
            946 =>
                array (
                    'id' => 947,
                    'name' => 'Kobenhavns Amt',
                    'country_id' => 59,
                ),
            947 =>
                array (
                    'id' => 948,
                    'name' => 'Kobenhavns Kommune',
                    'country_id' => 59,
                ),
            948 =>
                array (
                    'id' => 949,
                    'name' => 'Nordjylland',
                    'country_id' => 59,
                ),
            949 =>
                array (
                    'id' => 950,
                    'name' => 'Ribe',
                    'country_id' => 59,
                ),
            950 =>
                array (
                    'id' => 951,
                    'name' => 'Ringkobing',
                    'country_id' => 59,
                ),
            951 =>
                array (
                    'id' => 952,
                    'name' => 'Roervig',
                    'country_id' => 59,
                ),
            952 =>
                array (
                    'id' => 953,
                    'name' => 'Roskilde',
                    'country_id' => 59,
                ),
            953 =>
                array (
                    'id' => 954,
                    'name' => 'Roslev',
                    'country_id' => 59,
                ),
            954 =>
                array (
                    'id' => 955,
                    'name' => 'Sjaelland',
                    'country_id' => 59,
                ),
            955 =>
                array (
                    'id' => 956,
                    'name' => 'Soeborg',
                    'country_id' => 59,
                ),
            956 =>
                array (
                    'id' => 957,
                    'name' => 'Sonderjylland',
                    'country_id' => 59,
                ),
            957 =>
                array (
                    'id' => 958,
                    'name' => 'Storstrom',
                    'country_id' => 59,
                ),
            958 =>
                array (
                    'id' => 959,
                    'name' => 'Syddanmark',
                    'country_id' => 59,
                ),
            959 =>
                array (
                    'id' => 960,
                    'name' => 'Toelloese',
                    'country_id' => 59,
                ),
            960 =>
                array (
                    'id' => 961,
                    'name' => 'Vejle',
                    'country_id' => 59,
                ),
            961 =>
                array (
                    'id' => 962,
                    'name' => 'Vestsjalland',
                    'country_id' => 59,
                ),
            962 =>
                array (
                    'id' => 963,
                    'name' => 'Viborg',
                    'country_id' => 59,
                ),
            963 =>
                array (
                    'id' => 964,
                    'name' => '\'Ali Sabih',
                    'country_id' => 60,
                ),
            964 =>
                array (
                    'id' => 965,
                    'name' => 'Dikhil',
                    'country_id' => 60,
                ),
            965 =>
                array (
                    'id' => 966,
                    'name' => 'Jibuti',
                    'country_id' => 60,
                ),
            966 =>
                array (
                    'id' => 967,
                    'name' => 'Tajurah',
                    'country_id' => 60,
                ),
            967 =>
                array (
                    'id' => 968,
                    'name' => 'Ubuk',
                    'country_id' => 60,
                ),
            968 =>
                array (
                    'id' => 969,
                    'name' => 'Saint Andrew',
                    'country_id' => 61,
                ),
            969 =>
                array (
                    'id' => 970,
                    'name' => 'Saint David',
                    'country_id' => 61,
                ),
            970 =>
                array (
                    'id' => 971,
                    'name' => 'Saint George',
                    'country_id' => 61,
                ),
            971 =>
                array (
                    'id' => 972,
                    'name' => 'Saint John',
                    'country_id' => 61,
                ),
            972 =>
                array (
                    'id' => 973,
                    'name' => 'Saint Joseph',
                    'country_id' => 61,
                ),
            973 =>
                array (
                    'id' => 974,
                    'name' => 'Saint Luke',
                    'country_id' => 61,
                ),
            974 =>
                array (
                    'id' => 975,
                    'name' => 'Saint Mark',
                    'country_id' => 61,
                ),
            975 =>
                array (
                    'id' => 976,
                    'name' => 'Saint Patrick',
                    'country_id' => 61,
                ),
            976 =>
                array (
                    'id' => 977,
                    'name' => 'Saint Paul',
                    'country_id' => 61,
                ),
            977 =>
                array (
                    'id' => 978,
                    'name' => 'Saint Peter',
                    'country_id' => 61,
                ),
            978 =>
                array (
                    'id' => 979,
                    'name' => 'Azua',
                    'country_id' => 62,
                ),
            979 =>
                array (
                    'id' => 980,
                    'name' => 'Bahoruco',
                    'country_id' => 62,
                ),
            980 =>
                array (
                    'id' => 981,
                    'name' => 'Barahona',
                    'country_id' => 62,
                ),
            981 =>
                array (
                    'id' => 982,
                    'name' => 'Dajabon',
                    'country_id' => 62,
                ),
            982 =>
                array (
                    'id' => 983,
                    'name' => 'Distrito Nacional',
                    'country_id' => 62,
                ),
            983 =>
                array (
                    'id' => 984,
                    'name' => 'Duarte',
                    'country_id' => 62,
                ),
            984 =>
                array (
                    'id' => 985,
                    'name' => 'El Seybo',
                    'country_id' => 62,
                ),
            985 =>
                array (
                    'id' => 986,
                    'name' => 'Elias Pina',
                    'country_id' => 62,
                ),
            986 =>
                array (
                    'id' => 987,
                    'name' => 'Espaillat',
                    'country_id' => 62,
                ),
            987 =>
                array (
                    'id' => 988,
                    'name' => 'Hato Mayor',
                    'country_id' => 62,
                ),
            988 =>
                array (
                    'id' => 989,
                    'name' => 'Independencia',
                    'country_id' => 62,
                ),
            989 =>
                array (
                    'id' => 990,
                    'name' => 'La Altagracia',
                    'country_id' => 62,
                ),
            990 =>
                array (
                    'id' => 991,
                    'name' => 'La Romana',
                    'country_id' => 62,
                ),
            991 =>
                array (
                    'id' => 992,
                    'name' => 'La Vega',
                    'country_id' => 62,
                ),
            992 =>
                array (
                    'id' => 993,
                    'name' => 'Maria Trinidad Sanchez',
                    'country_id' => 62,
                ),
            993 =>
                array (
                    'id' => 994,
                    'name' => 'Monsenor Nouel',
                    'country_id' => 62,
                ),
            994 =>
                array (
                    'id' => 995,
                    'name' => 'Monte Cristi',
                    'country_id' => 62,
                ),
            995 =>
                array (
                    'id' => 996,
                    'name' => 'Monte Plata',
                    'country_id' => 62,
                ),
            996 =>
                array (
                    'id' => 997,
                    'name' => 'Pedernales',
                    'country_id' => 62,
                ),
            997 =>
                array (
                    'id' => 998,
                    'name' => 'Peravia',
                    'country_id' => 62,
                ),
            998 =>
                array (
                    'id' => 999,
                    'name' => 'Puerto Plata',
                    'country_id' => 62,
                ),
            999 =>
                array (
                    'id' => 1000,
                    'name' => 'Salcedo',
                    'country_id' => 62,
                ),
            1000 =>
                array (
                    'id' => 1001,
                    'name' => 'Samana',
                    'country_id' => 62,
                ),
            1001 =>
                array (
                    'id' => 1002,
                    'name' => 'San Cristobal',
                    'country_id' => 62,
                ),
            1002 =>
                array (
                    'id' => 1003,
                    'name' => 'San Juan',
                    'country_id' => 62,
                ),
            1003 =>
                array (
                    'id' => 1004,
                    'name' => 'San Pedro de Macoris',
                    'country_id' => 62,
                ),
            1004 =>
                array (
                    'id' => 1005,
                    'name' => 'Sanchez Ramirez',
                    'country_id' => 62,
                ),
            1005 =>
                array (
                    'id' => 1006,
                    'name' => 'Santiago',
                    'country_id' => 62,
                ),
            1006 =>
                array (
                    'id' => 1007,
                    'name' => 'Santiago Rodriguez',
                    'country_id' => 62,
                ),
            1007 =>
                array (
                    'id' => 1008,
                    'name' => 'Valverde',
                    'country_id' => 62,
                ),
            1008 =>
                array (
                    'id' => 1022,
                    'name' => 'Azuay',
                    'country_id' => 64,
                ),
            1009 =>
                array (
                    'id' => 1023,
                    'name' => 'Bolivar',
                    'country_id' => 64,
                ),
            1010 =>
                array (
                    'id' => 1024,
                    'name' => 'Canar',
                    'country_id' => 64,
                ),
            1011 =>
                array (
                    'id' => 1025,
                    'name' => 'Carchi',
                    'country_id' => 64,
                ),
            1012 =>
                array (
                    'id' => 1026,
                    'name' => 'Chimborazo',
                    'country_id' => 64,
                ),
            1013 =>
                array (
                    'id' => 1027,
                    'name' => 'Cotopaxi',
                    'country_id' => 64,
                ),
            1014 =>
                array (
                    'id' => 1028,
                    'name' => 'El Oro',
                    'country_id' => 64,
                ),
            1015 =>
                array (
                    'id' => 1029,
                    'name' => 'Esmeraldas',
                    'country_id' => 64,
                ),
            1016 =>
                array (
                    'id' => 1030,
                    'name' => 'Galapagos',
                    'country_id' => 64,
                ),
            1017 =>
                array (
                    'id' => 1031,
                    'name' => 'Guayas',
                    'country_id' => 64,
                ),
            1018 =>
                array (
                    'id' => 1032,
                    'name' => 'Imbabura',
                    'country_id' => 64,
                ),
            1019 =>
                array (
                    'id' => 1033,
                    'name' => 'Loja',
                    'country_id' => 64,
                ),
            1020 =>
                array (
                    'id' => 1034,
                    'name' => 'Los Rios',
                    'country_id' => 64,
                ),
            1021 =>
                array (
                    'id' => 1035,
                    'name' => 'Manabi',
                    'country_id' => 64,
                ),
            1022 =>
                array (
                    'id' => 1036,
                    'name' => 'Morona Santiago',
                    'country_id' => 64,
                ),
            1023 =>
                array (
                    'id' => 1037,
                    'name' => 'Napo',
                    'country_id' => 64,
                ),
            1024 =>
                array (
                    'id' => 1038,
                    'name' => 'Orellana',
                    'country_id' => 64,
                ),
            1025 =>
                array (
                    'id' => 1039,
                    'name' => 'Pastaza',
                    'country_id' => 64,
                ),
            1026 =>
                array (
                    'id' => 1040,
                    'name' => 'Pichincha',
                    'country_id' => 64,
                ),
            1027 =>
                array (
                    'id' => 1041,
                    'name' => 'Sucumbios',
                    'country_id' => 64,
                ),
            1028 =>
                array (
                    'id' => 1042,
                    'name' => 'Tungurahua',
                    'country_id' => 64,
                ),
            1029 =>
                array (
                    'id' => 1043,
                    'name' => 'Zamora Chinchipe',
                    'country_id' => 64,
                ),
            1030 =>
                array (
                    'id' => 1044,
                    'name' => 'Aswan',
                    'country_id' => 65,
                ),
            1031 =>
                array (
                    'id' => 1045,
                    'name' => 'Asyut',
                    'country_id' => 65,
                ),
            1032 =>
                array (
                    'id' => 1046,
                    'name' => 'Bani Suwayf',
                    'country_id' => 65,
                ),
            1033 =>
                array (
                    'id' => 1047,
                    'name' => 'Bur Sa\'id',
                    'country_id' => 65,
                ),
            1034 =>
                array (
                    'id' => 1048,
                    'name' => 'Cairo',
                    'country_id' => 65,
                ),
            1035 =>
                array (
                    'id' => 1049,
                    'name' => 'Dumyat',
                    'country_id' => 65,
                ),
            1036 =>
                array (
                    'id' => 1050,
                    'name' => 'Kafr-ash-Shaykh',
                    'country_id' => 65,
                ),
            1037 =>
                array (
                    'id' => 1051,
                    'name' => 'Matruh',
                    'country_id' => 65,
                ),
            1038 =>
                array (
                    'id' => 1052,
                    'name' => 'Muhafazat ad Daqahliyah',
                    'country_id' => 65,
                ),
            1039 =>
                array (
                    'id' => 1053,
                    'name' => 'Muhafazat al Fayyum',
                    'country_id' => 65,
                ),
            1040 =>
                array (
                    'id' => 1054,
                    'name' => 'Muhafazat al Gharbiyah',
                    'country_id' => 65,
                ),
            1041 =>
                array (
                    'id' => 1055,
                    'name' => 'Muhafazat al Iskandariyah',
                    'country_id' => 65,
                ),
            1042 =>
                array (
                    'id' => 1056,
                    'name' => 'Muhafazat al Qahirah',
                    'country_id' => 65,
                ),
            1043 =>
                array (
                    'id' => 1057,
                    'name' => 'Qina',
                    'country_id' => 65,
                ),
            1044 =>
                array (
                    'id' => 1058,
                    'name' => 'Sawhaj',
                    'country_id' => 65,
                ),
            1045 =>
                array (
                    'id' => 1059,
                    'name' => 'Sina al-Janubiyah',
                    'country_id' => 65,
                ),
            1046 =>
                array (
                    'id' => 1060,
                    'name' => 'Sina ash-Shamaliyah',
                    'country_id' => 65,
                ),
            1047 =>
                array (
                    'id' => 1061,
                    'name' => 'ad-Daqahliyah',
                    'country_id' => 65,
                ),
            1048 =>
                array (
                    'id' => 1062,
                    'name' => 'al-Bahr-al-Ahmar',
                    'country_id' => 65,
                ),
            1049 =>
                array (
                    'id' => 1063,
                    'name' => 'al-Buhayrah',
                    'country_id' => 65,
                ),
            1050 =>
                array (
                    'id' => 1064,
                    'name' => 'al-Fayyum',
                    'country_id' => 65,
                ),
            1051 =>
                array (
                    'id' => 1065,
                    'name' => 'al-Gharbiyah',
                    'country_id' => 65,
                ),
            1052 =>
                array (
                    'id' => 1066,
                    'name' => 'al-Iskandariyah',
                    'country_id' => 65,
                ),
            1053 =>
                array (
                    'id' => 1067,
                    'name' => 'al-Ismailiyah',
                    'country_id' => 65,
                ),
            1054 =>
                array (
                    'id' => 1068,
                    'name' => 'al-Jizah',
                    'country_id' => 65,
                ),
            1055 =>
                array (
                    'id' => 1069,
                    'name' => 'al-Minufiyah',
                    'country_id' => 65,
                ),
            1056 =>
                array (
                    'id' => 1070,
                    'name' => 'al-Minya',
                    'country_id' => 65,
                ),
            1057 =>
                array (
                    'id' => 1071,
                    'name' => 'al-Qahira',
                    'country_id' => 65,
                ),
            1058 =>
                array (
                    'id' => 1072,
                    'name' => 'al-Qalyubiyah',
                    'country_id' => 65,
                ),
            1059 =>
                array (
                    'id' => 1073,
                    'name' => 'al-Uqsur',
                    'country_id' => 65,
                ),
            1060 =>
                array (
                    'id' => 1074,
                    'name' => 'al-Wadi al-Jadid',
                    'country_id' => 65,
                ),
            1061 =>
                array (
                    'id' => 1075,
                    'name' => 'as-Suways',
                    'country_id' => 65,
                ),
            1062 =>
                array (
                    'id' => 1076,
                    'name' => 'ash-Sharqiyah',
                    'country_id' => 65,
                ),
            1063 =>
                array (
                    'id' => 1077,
                    'name' => 'Ahuachapan',
                    'country_id' => 66,
                ),
            1064 =>
                array (
                    'id' => 1078,
                    'name' => 'Cabanas',
                    'country_id' => 66,
                ),
            1065 =>
                array (
                    'id' => 1079,
                    'name' => 'Chalatenango',
                    'country_id' => 66,
                ),
            1066 =>
                array (
                    'id' => 1080,
                    'name' => 'Cuscatlan',
                    'country_id' => 66,
                ),
            1067 =>
                array (
                    'id' => 1081,
                    'name' => 'La Libertad',
                    'country_id' => 66,
                ),
            1068 =>
                array (
                    'id' => 1082,
                    'name' => 'La Paz',
                    'country_id' => 66,
                ),
            1069 =>
                array (
                    'id' => 1083,
                    'name' => 'La Union',
                    'country_id' => 66,
                ),
            1070 =>
                array (
                    'id' => 1084,
                    'name' => 'Morazan',
                    'country_id' => 66,
                ),
            1071 =>
                array (
                    'id' => 1085,
                    'name' => 'San Miguel',
                    'country_id' => 66,
                ),
            1072 =>
                array (
                    'id' => 1086,
                    'name' => 'San Salvador',
                    'country_id' => 66,
                ),
            1073 =>
                array (
                    'id' => 1087,
                    'name' => 'San Vicente',
                    'country_id' => 66,
                ),
            1074 =>
                array (
                    'id' => 1088,
                    'name' => 'Santa Ana',
                    'country_id' => 66,
                ),
            1075 =>
                array (
                    'id' => 1089,
                    'name' => 'Sonsonate',
                    'country_id' => 66,
                ),
            1076 =>
                array (
                    'id' => 1090,
                    'name' => 'Usulutan',
                    'country_id' => 66,
                ),
            1077 =>
                array (
                    'id' => 1091,
                    'name' => 'Annobon',
                    'country_id' => 67,
                ),
            1078 =>
                array (
                    'id' => 1092,
                    'name' => 'Bioko Norte',
                    'country_id' => 67,
                ),
            1079 =>
                array (
                    'id' => 1093,
                    'name' => 'Bioko Sur',
                    'country_id' => 67,
                ),
            1080 =>
                array (
                    'id' => 1094,
                    'name' => 'Centro Sur',
                    'country_id' => 67,
                ),
            1081 =>
                array (
                    'id' => 1095,
                    'name' => 'Kie-Ntem',
                    'country_id' => 67,
                ),
            1082 =>
                array (
                    'id' => 1096,
                    'name' => 'Litoral',
                    'country_id' => 67,
                ),
            1083 =>
                array (
                    'id' => 1097,
                    'name' => 'Wele-Nzas',
                    'country_id' => 67,
                ),
            1084 =>
                array (
                    'id' => 1098,
                    'name' => 'Anseba',
                    'country_id' => 68,
                ),
            1085 =>
                array (
                    'id' => 1099,
                    'name' => 'Debub',
                    'country_id' => 68,
                ),
            1086 =>
                array (
                    'id' => 1100,
                    'name' => 'Debub-Keih-Bahri',
                    'country_id' => 68,
                ),
            1087 =>
                array (
                    'id' => 1101,
                    'name' => 'Gash-Barka',
                    'country_id' => 68,
                ),
            1088 =>
                array (
                    'id' => 1102,
                    'name' => 'Maekel',
                    'country_id' => 68,
                ),
            1089 =>
                array (
                    'id' => 1103,
                    'name' => 'Semien-Keih-Bahri',
                    'country_id' => 68,
                ),
            1090 =>
                array (
                    'id' => 1104,
                    'name' => 'Harju',
                    'country_id' => 69,
                ),
            1091 =>
                array (
                    'id' => 1105,
                    'name' => 'Hiiu',
                    'country_id' => 69,
                ),
            1092 =>
                array (
                    'id' => 1106,
                    'name' => 'Ida-Viru',
                    'country_id' => 69,
                ),
            1093 =>
                array (
                    'id' => 1107,
                    'name' => 'Jarva',
                    'country_id' => 69,
                ),
            1094 =>
                array (
                    'id' => 1108,
                    'name' => 'Jogeva',
                    'country_id' => 69,
                ),
            1095 =>
                array (
                    'id' => 1109,
                    'name' => 'Laane',
                    'country_id' => 69,
                ),
            1096 =>
                array (
                    'id' => 1110,
                    'name' => 'Laane-Viru',
                    'country_id' => 69,
                ),
            1097 =>
                array (
                    'id' => 1111,
                    'name' => 'Parnu',
                    'country_id' => 69,
                ),
            1098 =>
                array (
                    'id' => 1112,
                    'name' => 'Polva',
                    'country_id' => 69,
                ),
            1099 =>
                array (
                    'id' => 1113,
                    'name' => 'Rapla',
                    'country_id' => 69,
                ),
            1100 =>
                array (
                    'id' => 1114,
                    'name' => 'Saare',
                    'country_id' => 69,
                ),
            1101 =>
                array (
                    'id' => 1115,
                    'name' => 'Tartu',
                    'country_id' => 69,
                ),
            1102 =>
                array (
                    'id' => 1116,
                    'name' => 'Valga',
                    'country_id' => 69,
                ),
            1103 =>
                array (
                    'id' => 1117,
                    'name' => 'Viljandi',
                    'country_id' => 69,
                ),
            1104 =>
                array (
                    'id' => 1118,
                    'name' => 'Voru',
                    'country_id' => 69,
                ),
            1105 =>
                array (
                    'id' => 1119,
                    'name' => 'Addis Abeba',
                    'country_id' => 70,
                ),
            1106 =>
                array (
                    'id' => 1120,
                    'name' => 'Afar',
                    'country_id' => 70,
                ),
            1107 =>
                array (
                    'id' => 1121,
                    'name' => 'Amhara',
                    'country_id' => 70,
                ),
            1108 =>
                array (
                    'id' => 1122,
                    'name' => 'Benishangul',
                    'country_id' => 70,
                ),
            1109 =>
                array (
                    'id' => 1123,
                    'name' => 'Diredawa',
                    'country_id' => 70,
                ),
            1110 =>
                array (
                    'id' => 1124,
                    'name' => 'Gambella',
                    'country_id' => 70,
                ),
            1111 =>
                array (
                    'id' => 1125,
                    'name' => 'Harar',
                    'country_id' => 70,
                ),
            1112 =>
                array (
                    'id' => 1126,
                    'name' => 'Jigjiga',
                    'country_id' => 70,
                ),
            1113 =>
                array (
                    'id' => 1127,
                    'name' => 'Mekele',
                    'country_id' => 70,
                ),
            1114 =>
                array (
                    'id' => 1128,
                    'name' => 'Oromia',
                    'country_id' => 70,
                ),
            1115 =>
                array (
                    'id' => 1129,
                    'name' => 'Somali',
                    'country_id' => 70,
                ),
            1116 =>
                array (
                    'id' => 1130,
                    'name' => 'Southern',
                    'country_id' => 70,
                ),
            1117 =>
                array (
                    'id' => 1131,
                    'name' => 'Tigray',
                    'country_id' => 70,
                ),
            1118 =>
                array (
                    'id' => 1135,
                    'name' => 'Falkland Islands',
                    'country_id' => 71,
                ),
            1119 =>
                array (
                    'id' => 1136,
                    'name' => 'South Georgia',
                    'country_id' => 71,
                ),
            1120 =>
                array (
                    'id' => 1137,
                    'name' => 'Klaksvik',
                    'country_id' => 72,
                ),
            1121 =>
                array (
                    'id' => 1138,
                    'name' => 'Nor ara Eysturoy',
                    'country_id' => 72,
                ),
            1122 =>
                array (
                    'id' => 1139,
                    'name' => 'Nor oy',
                    'country_id' => 72,
                ),
            1123 =>
                array (
                    'id' => 1140,
                    'name' => 'Sandoy',
                    'country_id' => 72,
                ),
            1124 =>
                array (
                    'id' => 1141,
                    'name' => 'Streymoy',
                    'country_id' => 72,
                ),
            1125 =>
                array (
                    'id' => 1142,
                    'name' => 'Su uroy',
                    'country_id' => 72,
                ),
            1126 =>
                array (
                    'id' => 1143,
                    'name' => 'Sy ra Eysturoy',
                    'country_id' => 72,
                ),
            1127 =>
                array (
                    'id' => 1144,
                    'name' => 'Torshavn',
                    'country_id' => 72,
                ),
            1128 =>
                array (
                    'id' => 1145,
                    'name' => 'Vaga',
                    'country_id' => 72,
                ),
            1129 =>
                array (
                    'id' => 1146,
                    'name' => 'Central',
                    'country_id' => 73,
                ),
            1130 =>
                array (
                    'id' => 1147,
                    'name' => 'Eastern',
                    'country_id' => 73,
                ),
            1131 =>
                array (
                    'id' => 1148,
                    'name' => 'Northern',
                    'country_id' => 73,
                ),
            1132 =>
                array (
                    'id' => 1149,
                    'name' => 'South Pacific',
                    'country_id' => 73,
                ),
            1133 =>
                array (
                    'id' => 1150,
                    'name' => 'Western',
                    'country_id' => 73,
                ),
            1134 =>
                array (
                    'id' => 1151,
                    'name' => 'Ahvenanmaa',
                    'country_id' => 74,
                ),
            1135 =>
                array (
                    'id' => 1152,
                    'name' => 'Etela-Karjala',
                    'country_id' => 74,
                ),
            1136 =>
                array (
                    'id' => 1153,
                    'name' => 'Etela-Pohjanmaa',
                    'country_id' => 74,
                ),
            1137 =>
                array (
                    'id' => 1154,
                    'name' => 'Etela-Savo',
                    'country_id' => 74,
                ),
            1138 =>
                array (
                    'id' => 1155,
                    'name' => 'Etela-Suomen Laani',
                    'country_id' => 74,
                ),
            1139 =>
                array (
                    'id' => 1156,
                    'name' => 'Ita-Suomen Laani',
                    'country_id' => 74,
                ),
            1140 =>
                array (
                    'id' => 1157,
                    'name' => 'Ita-Uusimaa',
                    'country_id' => 74,
                ),
            1141 =>
                array (
                    'id' => 1158,
                    'name' => 'Kainuu',
                    'country_id' => 74,
                ),
            1142 =>
                array (
                    'id' => 1159,
                    'name' => 'Kanta-Hame',
                    'country_id' => 74,
                ),
            1143 =>
                array (
                    'id' => 1160,
                    'name' => 'Keski-Pohjanmaa',
                    'country_id' => 74,
                ),
            1144 =>
                array (
                    'id' => 1161,
                    'name' => 'Keski-Suomi',
                    'country_id' => 74,
                ),
            1145 =>
                array (
                    'id' => 1162,
                    'name' => 'Kymenlaakso',
                    'country_id' => 74,
                ),
            1146 =>
                array (
                    'id' => 1163,
                    'name' => 'Lansi-Suomen Laani',
                    'country_id' => 74,
                ),
            1147 =>
                array (
                    'id' => 1164,
                    'name' => 'Lappi',
                    'country_id' => 74,
                ),
            1148 =>
                array (
                    'id' => 1165,
                    'name' => 'Northern Savonia',
                    'country_id' => 74,
                ),
            1149 =>
                array (
                    'id' => 1166,
                    'name' => 'Ostrobothnia',
                    'country_id' => 74,
                ),
            1150 =>
                array (
                    'id' => 1167,
                    'name' => 'Oulun Laani',
                    'country_id' => 74,
                ),
            1151 =>
                array (
                    'id' => 1168,
                    'name' => 'Paijat-Hame',
                    'country_id' => 74,
                ),
            1152 =>
                array (
                    'id' => 1169,
                    'name' => 'Pirkanmaa',
                    'country_id' => 74,
                ),
            1153 =>
                array (
                    'id' => 1170,
                    'name' => 'Pohjanmaa',
                    'country_id' => 74,
                ),
            1154 =>
                array (
                    'id' => 1171,
                    'name' => 'Pohjois-Karjala',
                    'country_id' => 74,
                ),
            1155 =>
                array (
                    'id' => 1172,
                    'name' => 'Pohjois-Pohjanmaa',
                    'country_id' => 74,
                ),
            1156 =>
                array (
                    'id' => 1173,
                    'name' => 'Pohjois-Savo',
                    'country_id' => 74,
                ),
            1157 =>
                array (
                    'id' => 1174,
                    'name' => 'Saarijarvi',
                    'country_id' => 74,
                ),
            1158 =>
                array (
                    'id' => 1175,
                    'name' => 'Satakunta',
                    'country_id' => 74,
                ),
            1159 =>
                array (
                    'id' => 1176,
                    'name' => 'Southern Savonia',
                    'country_id' => 74,
                ),
            1160 =>
                array (
                    'id' => 1177,
                    'name' => 'Tavastia Proper',
                    'country_id' => 74,
                ),
            1161 =>
                array (
                    'id' => 1178,
                    'name' => 'Uleaborgs Lan',
                    'country_id' => 74,
                ),
            1162 =>
                array (
                    'id' => 1179,
                    'name' => 'Uusimaa',
                    'country_id' => 74,
                ),
            1163 =>
                array (
                    'id' => 1180,
                    'name' => 'Varsinais-Suomi',
                    'country_id' => 74,
                ),
            1164 =>
                array (
                    'id' => 1181,
                    'name' => 'Ain',
                    'country_id' => 75,
                ),
            1165 =>
                array (
                    'id' => 1182,
                    'name' => 'Aisne',
                    'country_id' => 75,
                ),
            1166 =>
                array (
                    'id' => 1183,
                    'name' => 'Albi Le Sequestre',
                    'country_id' => 75,
                ),
            1167 =>
                array (
                    'id' => 1184,
                    'name' => 'Allier',
                    'country_id' => 75,
                ),
            1168 =>
                array (
                    'id' => 1185,
                    'name' => 'Alpes-Cote dAzur',
                    'country_id' => 75,
                ),
            1169 =>
                array (
                    'id' => 1186,
                    'name' => 'Alpes-Maritimes',
                    'country_id' => 75,
                ),
            1170 =>
                array (
                    'id' => 1187,
                    'name' => 'Alpes-de-Haute-Provence',
                    'country_id' => 75,
                ),
            1171 =>
                array (
                    'id' => 1188,
                    'name' => 'Alsace',
                    'country_id' => 75,
                ),
            1172 =>
                array (
                    'id' => 1189,
                    'name' => 'Aquitaine',
                    'country_id' => 75,
                ),
            1173 =>
                array (
                    'id' => 1190,
                    'name' => 'Ardeche',
                    'country_id' => 75,
                ),
            1174 =>
                array (
                    'id' => 1191,
                    'name' => 'Ardennes',
                    'country_id' => 75,
                ),
            1175 =>
                array (
                    'id' => 1192,
                    'name' => 'Ariege',
                    'country_id' => 75,
                ),
            1176 =>
                array (
                    'id' => 1193,
                    'name' => 'Aube',
                    'country_id' => 75,
                ),
            1177 =>
                array (
                    'id' => 1194,
                    'name' => 'Aude',
                    'country_id' => 75,
                ),
            1178 =>
                array (
                    'id' => 1195,
                    'name' => 'Auvergne',
                    'country_id' => 75,
                ),
            1179 =>
                array (
                    'id' => 1196,
                    'name' => 'Aveyron',
                    'country_id' => 75,
                ),
            1180 =>
                array (
                    'id' => 1197,
                    'name' => 'Bas-Rhin',
                    'country_id' => 75,
                ),
            1181 =>
                array (
                    'id' => 1198,
                    'name' => 'Basse-Normandie',
                    'country_id' => 75,
                ),
            1182 =>
                array (
                    'id' => 1199,
                    'name' => 'Bouches-du-Rhone',
                    'country_id' => 75,
                ),
            1183 =>
                array (
                    'id' => 1200,
                    'name' => 'Bourgogne',
                    'country_id' => 75,
                ),
            1184 =>
                array (
                    'id' => 1201,
                    'name' => 'Bretagne',
                    'country_id' => 75,
                ),
            1185 =>
                array (
                    'id' => 1202,
                    'name' => 'Brittany',
                    'country_id' => 75,
                ),
            1186 =>
                array (
                    'id' => 1203,
                    'name' => 'Burgundy',
                    'country_id' => 75,
                ),
            1187 =>
                array (
                    'id' => 1204,
                    'name' => 'Calvados',
                    'country_id' => 75,
                ),
            1188 =>
                array (
                    'id' => 1205,
                    'name' => 'Cantal',
                    'country_id' => 75,
                ),
            1189 =>
                array (
                    'id' => 1206,
                    'name' => 'Cedex',
                    'country_id' => 75,
                ),
            1190 =>
                array (
                    'id' => 1207,
                    'name' => 'Centre',
                    'country_id' => 75,
                ),
            1191 =>
                array (
                    'id' => 1208,
                    'name' => 'Charente',
                    'country_id' => 75,
                ),
            1192 =>
                array (
                    'id' => 1209,
                    'name' => 'Charente-Maritime',
                    'country_id' => 75,
                ),
            1193 =>
                array (
                    'id' => 1210,
                    'name' => 'Cher',
                    'country_id' => 75,
                ),
            1194 =>
                array (
                    'id' => 1211,
                    'name' => 'Correze',
                    'country_id' => 75,
                ),
            1195 =>
                array (
                    'id' => 1212,
                    'name' => 'Corse-du-Sud',
                    'country_id' => 75,
                ),
            1196 =>
                array (
                    'id' => 1213,
                    'name' => 'Cote-d\'Or',
                    'country_id' => 75,
                ),
            1197 =>
                array (
                    'id' => 1214,
                    'name' => 'Cotes-d\'Armor',
                    'country_id' => 75,
                ),
            1198 =>
                array (
                    'id' => 1215,
                    'name' => 'Creuse',
                    'country_id' => 75,
                ),
            1199 =>
                array (
                    'id' => 1216,
                    'name' => 'Crolles',
                    'country_id' => 75,
                ),
            1200 =>
                array (
                    'id' => 1217,
                    'name' => 'Deux-Sevres',
                    'country_id' => 75,
                ),
            1201 =>
                array (
                    'id' => 1218,
                    'name' => 'Dordogne',
                    'country_id' => 75,
                ),
            1202 =>
                array (
                    'id' => 1219,
                    'name' => 'Doubs',
                    'country_id' => 75,
                ),
            1203 =>
                array (
                    'id' => 1220,
                    'name' => 'Drome',
                    'country_id' => 75,
                ),
            1204 =>
                array (
                    'id' => 1221,
                    'name' => 'Essonne',
                    'country_id' => 75,
                ),
            1205 =>
                array (
                    'id' => 1222,
                    'name' => 'Eure',
                    'country_id' => 75,
                ),
            1206 =>
                array (
                    'id' => 1223,
                    'name' => 'Eure-et-Loir',
                    'country_id' => 75,
                ),
            1207 =>
                array (
                    'id' => 1224,
                    'name' => 'Feucherolles',
                    'country_id' => 75,
                ),
            1208 =>
                array (
                    'id' => 1225,
                    'name' => 'Finistere',
                    'country_id' => 75,
                ),
            1209 =>
                array (
                    'id' => 1226,
                    'name' => 'Franche-Comte',
                    'country_id' => 75,
                ),
            1210 =>
                array (
                    'id' => 1227,
                    'name' => 'Gard',
                    'country_id' => 75,
                ),
            1211 =>
                array (
                    'id' => 1228,
                    'name' => 'Gers',
                    'country_id' => 75,
                ),
            1212 =>
                array (
                    'id' => 1229,
                    'name' => 'Gironde',
                    'country_id' => 75,
                ),
            1213 =>
                array (
                    'id' => 1230,
                    'name' => 'Haut-Rhin',
                    'country_id' => 75,
                ),
            1214 =>
                array (
                    'id' => 1231,
                    'name' => 'Haute-Corse',
                    'country_id' => 75,
                ),
            1215 =>
                array (
                    'id' => 1232,
                    'name' => 'Haute-Garonne',
                    'country_id' => 75,
                ),
            1216 =>
                array (
                    'id' => 1233,
                    'name' => 'Haute-Loire',
                    'country_id' => 75,
                ),
            1217 =>
                array (
                    'id' => 1234,
                    'name' => 'Haute-Marne',
                    'country_id' => 75,
                ),
            1218 =>
                array (
                    'id' => 1235,
                    'name' => 'Haute-Saone',
                    'country_id' => 75,
                ),
            1219 =>
                array (
                    'id' => 1236,
                    'name' => 'Haute-Savoie',
                    'country_id' => 75,
                ),
            1220 =>
                array (
                    'id' => 1237,
                    'name' => 'Haute-Vienne',
                    'country_id' => 75,
                ),
            1221 =>
                array (
                    'id' => 1238,
                    'name' => 'Hautes-Alpes',
                    'country_id' => 75,
                ),
            1222 =>
                array (
                    'id' => 1239,
                    'name' => 'Hautes-Pyrenees',
                    'country_id' => 75,
                ),
            1223 =>
                array (
                    'id' => 1240,
                    'name' => 'Hauts-de-Seine',
                    'country_id' => 75,
                ),
            1224 =>
                array (
                    'id' => 1241,
                    'name' => 'Herault',
                    'country_id' => 75,
                ),
            1225 =>
                array (
                    'id' => 1242,
                    'name' => 'Ile-de-France',
                    'country_id' => 75,
                ),
            1226 =>
                array (
                    'id' => 1243,
                    'name' => 'Ille-et-Vilaine',
                    'country_id' => 75,
                ),
            1227 =>
                array (
                    'id' => 1244,
                    'name' => 'Indre',
                    'country_id' => 75,
                ),
            1228 =>
                array (
                    'id' => 1245,
                    'name' => 'Indre-et-Loire',
                    'country_id' => 75,
                ),
            1229 =>
                array (
                    'id' => 1246,
                    'name' => 'Isere',
                    'country_id' => 75,
                ),
            1230 =>
                array (
                    'id' => 1247,
                    'name' => 'Jura',
                    'country_id' => 75,
                ),
            1231 =>
                array (
                    'id' => 1248,
                    'name' => 'Klagenfurt',
                    'country_id' => 75,
                ),
            1232 =>
                array (
                    'id' => 1249,
                    'name' => 'Landes',
                    'country_id' => 75,
                ),
            1233 =>
                array (
                    'id' => 1250,
                    'name' => 'Languedoc-Roussillon',
                    'country_id' => 75,
                ),
            1234 =>
                array (
                    'id' => 1251,
                    'name' => 'Larcay',
                    'country_id' => 75,
                ),
            1235 =>
                array (
                    'id' => 1252,
                    'name' => 'Le Castellet',
                    'country_id' => 75,
                ),
            1236 =>
                array (
                    'id' => 1253,
                    'name' => 'Le Creusot',
                    'country_id' => 75,
                ),
            1237 =>
                array (
                    'id' => 1254,
                    'name' => 'Limousin',
                    'country_id' => 75,
                ),
            1238 =>
                array (
                    'id' => 1255,
                    'name' => 'Loir-et-Cher',
                    'country_id' => 75,
                ),
            1239 =>
                array (
                    'id' => 1256,
                    'name' => 'Loire',
                    'country_id' => 75,
                ),
            1240 =>
                array (
                    'id' => 1257,
                    'name' => 'Loire-Atlantique',
                    'country_id' => 75,
                ),
            1241 =>
                array (
                    'id' => 1258,
                    'name' => 'Loiret',
                    'country_id' => 75,
                ),
            1242 =>
                array (
                    'id' => 1259,
                    'name' => 'Lorraine',
                    'country_id' => 75,
                ),
            1243 =>
                array (
                    'id' => 1260,
                    'name' => 'Lot',
                    'country_id' => 75,
                ),
            1244 =>
                array (
                    'id' => 1261,
                    'name' => 'Lot-et-Garonne',
                    'country_id' => 75,
                ),
            1245 =>
                array (
                    'id' => 1262,
                    'name' => 'Lower Normandy',
                    'country_id' => 75,
                ),
            1246 =>
                array (
                    'id' => 1263,
                    'name' => 'Lozere',
                    'country_id' => 75,
                ),
            1247 =>
                array (
                    'id' => 1264,
                    'name' => 'Maine-et-Loire',
                    'country_id' => 75,
                ),
            1248 =>
                array (
                    'id' => 1265,
                    'name' => 'Manche',
                    'country_id' => 75,
                ),
            1249 =>
                array (
                    'id' => 1266,
                    'name' => 'Marne',
                    'country_id' => 75,
                ),
            1250 =>
                array (
                    'id' => 1267,
                    'name' => 'Mayenne',
                    'country_id' => 75,
                ),
            1251 =>
                array (
                    'id' => 1268,
                    'name' => 'Meurthe-et-Moselle',
                    'country_id' => 75,
                ),
            1252 =>
                array (
                    'id' => 1269,
                    'name' => 'Meuse',
                    'country_id' => 75,
                ),
            1253 =>
                array (
                    'id' => 1270,
                    'name' => 'Midi-Pyrenees',
                    'country_id' => 75,
                ),
            1254 =>
                array (
                    'id' => 1271,
                    'name' => 'Morbihan',
                    'country_id' => 75,
                ),
            1255 =>
                array (
                    'id' => 1272,
                    'name' => 'Moselle',
                    'country_id' => 75,
                ),
            1256 =>
                array (
                    'id' => 1273,
                    'name' => 'Nievre',
                    'country_id' => 75,
                ),
            1257 =>
                array (
                    'id' => 1274,
                    'name' => 'Nord',
                    'country_id' => 75,
                ),
            1258 =>
                array (
                    'id' => 1275,
                    'name' => 'Nord-Pas-de-Calais',
                    'country_id' => 75,
                ),
            1259 =>
                array (
                    'id' => 1276,
                    'name' => 'Oise',
                    'country_id' => 75,
                ),
            1260 =>
                array (
                    'id' => 1277,
                    'name' => 'Orne',
                    'country_id' => 75,
                ),
            1261 =>
                array (
                    'id' => 1278,
                    'name' => 'Paris',
                    'country_id' => 75,
                ),
            1262 =>
                array (
                    'id' => 1279,
                    'name' => 'Pas-de-Calais',
                    'country_id' => 75,
                ),
            1263 =>
                array (
                    'id' => 1280,
                    'name' => 'Pays de la Loire',
                    'country_id' => 75,
                ),
            1264 =>
                array (
                    'id' => 1281,
                    'name' => 'Pays-de-la-Loire',
                    'country_id' => 75,
                ),
            1265 =>
                array (
                    'id' => 1282,
                    'name' => 'Picardy',
                    'country_id' => 75,
                ),
            1266 =>
                array (
                    'id' => 1283,
                    'name' => 'Puy-de-Dome',
                    'country_id' => 75,
                ),
            1267 =>
                array (
                    'id' => 1284,
                    'name' => 'Pyrenees-Atlantiques',
                    'country_id' => 75,
                ),
            1268 =>
                array (
                    'id' => 1285,
                    'name' => 'Pyrenees-Orientales',
                    'country_id' => 75,
                ),
            1269 =>
                array (
                    'id' => 1286,
                    'name' => 'Quelmes',
                    'country_id' => 75,
                ),
            1270 =>
                array (
                    'id' => 1287,
                    'name' => 'Rhone',
                    'country_id' => 75,
                ),
            1271 =>
                array (
                    'id' => 1288,
                    'name' => 'Rhone-Alpes',
                    'country_id' => 75,
                ),
            1272 =>
                array (
                    'id' => 1289,
                    'name' => 'Saint Ouen',
                    'country_id' => 75,
                ),
            1273 =>
                array (
                    'id' => 1290,
                    'name' => 'Saint Viatre',
                    'country_id' => 75,
                ),
            1274 =>
                array (
                    'id' => 1291,
                    'name' => 'Saone-et-Loire',
                    'country_id' => 75,
                ),
            1275 =>
                array (
                    'id' => 1292,
                    'name' => 'Sarthe',
                    'country_id' => 75,
                ),
            1276 =>
                array (
                    'id' => 1293,
                    'name' => 'Savoie',
                    'country_id' => 75,
                ),
            1277 =>
                array (
                    'id' => 1294,
                    'name' => 'Seine-Maritime',
                    'country_id' => 75,
                ),
            1278 =>
                array (
                    'id' => 1295,
                    'name' => 'Seine-Saint-Denis',
                    'country_id' => 75,
                ),
            1279 =>
                array (
                    'id' => 1296,
                    'name' => 'Seine-et-Marne',
                    'country_id' => 75,
                ),
            1280 =>
                array (
                    'id' => 1297,
                    'name' => 'Somme',
                    'country_id' => 75,
                ),
            1281 =>
                array (
                    'id' => 1298,
                    'name' => 'Sophia Antipolis',
                    'country_id' => 75,
                ),
            1282 =>
                array (
                    'id' => 1299,
                    'name' => 'Souvans',
                    'country_id' => 75,
                ),
            1283 =>
                array (
                    'id' => 1300,
                    'name' => 'Tarn',
                    'country_id' => 75,
                ),
            1284 =>
                array (
                    'id' => 1301,
                    'name' => 'Tarn-et-Garonne',
                    'country_id' => 75,
                ),
            1285 =>
                array (
                    'id' => 1302,
                    'name' => 'Territoire de Belfort',
                    'country_id' => 75,
                ),
            1286 =>
                array (
                    'id' => 1303,
                    'name' => 'Treignac',
                    'country_id' => 75,
                ),
            1287 =>
                array (
                    'id' => 1304,
                    'name' => 'Upper Normandy',
                    'country_id' => 75,
                ),
            1288 =>
                array (
                    'id' => 1305,
                    'name' => 'Val-d\'Oise',
                    'country_id' => 75,
                ),
            1289 =>
                array (
                    'id' => 1306,
                    'name' => 'Val-de-Marne',
                    'country_id' => 75,
                ),
            1290 =>
                array (
                    'id' => 1307,
                    'name' => 'Var',
                    'country_id' => 75,
                ),
            1291 =>
                array (
                    'id' => 1308,
                    'name' => 'Vaucluse',
                    'country_id' => 75,
                ),
            1292 =>
                array (
                    'id' => 1309,
                    'name' => 'Vellise',
                    'country_id' => 75,
                ),
            1293 =>
                array (
                    'id' => 1310,
                    'name' => 'Vendee',
                    'country_id' => 75,
                ),
            1294 =>
                array (
                    'id' => 1311,
                    'name' => 'Vienne',
                    'country_id' => 75,
                ),
            1295 =>
                array (
                    'id' => 1312,
                    'name' => 'Vosges',
                    'country_id' => 75,
                ),
            1296 =>
                array (
                    'id' => 1313,
                    'name' => 'Yonne',
                    'country_id' => 75,
                ),
            1297 =>
                array (
                    'id' => 1314,
                    'name' => 'Yvelines',
                    'country_id' => 75,
                ),
            1298 =>
                array (
                    'id' => 1315,
                    'name' => 'Cayenne',
                    'country_id' => 76,
                ),
            1299 =>
                array (
                    'id' => 1316,
                    'name' => 'Saint-Laurent-du-Maroni',
                    'country_id' => 76,
                ),
            1300 =>
                array (
                    'id' => 1317,
                    'name' => 'Iles du Vent',
                    'country_id' => 77,
                ),
            1301 =>
                array (
                    'id' => 1318,
                    'name' => 'Iles sous le Vent',
                    'country_id' => 77,
                ),
            1302 =>
                array (
                    'id' => 1319,
                    'name' => 'Marquesas',
                    'country_id' => 77,
                ),
            1303 =>
                array (
                    'id' => 1320,
                    'name' => 'Tuamotu',
                    'country_id' => 77,
                ),
            1304 =>
                array (
                    'id' => 1321,
                    'name' => 'Tubuai',
                    'country_id' => 77,
                ),
            1305 =>
                array (
                    'id' => 1322,
                    'name' => 'Amsterdam',
                    'country_id' => 78,
                ),
            1306 =>
                array (
                    'id' => 1323,
                    'name' => 'Crozet Islands',
                    'country_id' => 78,
                ),
            1307 =>
                array (
                    'id' => 1324,
                    'name' => 'Kerguelen',
                    'country_id' => 78,
                ),
            1308 =>
                array (
                    'id' => 1325,
                    'name' => 'Estuaire',
                    'country_id' => 79,
                ),
            1309 =>
                array (
                    'id' => 1326,
                    'name' => 'Haut-Ogooue',
                    'country_id' => 79,
                ),
            1310 =>
                array (
                    'id' => 1327,
                    'name' => 'Moyen-Ogooue',
                    'country_id' => 79,
                ),
            1311 =>
                array (
                    'id' => 1328,
                    'name' => 'Ngounie',
                    'country_id' => 79,
                ),
            1312 =>
                array (
                    'id' => 1329,
                    'name' => 'Nyanga',
                    'country_id' => 79,
                ),
            1313 =>
                array (
                    'id' => 1330,
                    'name' => 'Ogooue-Ivindo',
                    'country_id' => 79,
                ),
            1314 =>
                array (
                    'id' => 1331,
                    'name' => 'Ogooue-Lolo',
                    'country_id' => 79,
                ),
            1315 =>
                array (
                    'id' => 1332,
                    'name' => 'Ogooue-Maritime',
                    'country_id' => 79,
                ),
            1316 =>
                array (
                    'id' => 1333,
                    'name' => 'Woleu-Ntem',
                    'country_id' => 79,
                ),
            1317 =>
                array (
                    'id' => 1334,
                    'name' => 'Banjul',
                    'country_id' => 80,
                ),
            1318 =>
                array (
                    'id' => 1335,
                    'name' => 'Basse',
                    'country_id' => 80,
                ),
            1319 =>
                array (
                    'id' => 1336,
                    'name' => 'Brikama',
                    'country_id' => 80,
                ),
            1320 =>
                array (
                    'id' => 1337,
                    'name' => 'Janjanbureh',
                    'country_id' => 80,
                ),
            1321 =>
                array (
                    'id' => 1338,
                    'name' => 'Kanifing',
                    'country_id' => 80,
                ),
            1322 =>
                array (
                    'id' => 1339,
                    'name' => 'Kerewan',
                    'country_id' => 80,
                ),
            1323 =>
                array (
                    'id' => 1340,
                    'name' => 'Kuntaur',
                    'country_id' => 80,
                ),
            1324 =>
                array (
                    'id' => 1341,
                    'name' => 'Mansakonko',
                    'country_id' => 80,
                ),
            1325 =>
                array (
                    'id' => 1342,
                    'name' => 'Abhasia',
                    'country_id' => 81,
                ),
            1326 =>
                array (
                    'id' => 1343,
                    'name' => 'Ajaria',
                    'country_id' => 81,
                ),
            1327 =>
                array (
                    'id' => 1344,
                    'name' => 'Guria',
                    'country_id' => 81,
                ),
            1328 =>
                array (
                    'id' => 1345,
                    'name' => 'Imereti',
                    'country_id' => 81,
                ),
            1329 =>
                array (
                    'id' => 1346,
                    'name' => 'Kaheti',
                    'country_id' => 81,
                ),
            1330 =>
                array (
                    'id' => 1347,
                    'name' => 'Kvemo Kartli',
                    'country_id' => 81,
                ),
            1331 =>
                array (
                    'id' => 1348,
                    'name' => 'Mcheta-Mtianeti',
                    'country_id' => 81,
                ),
            1332 =>
                array (
                    'id' => 1349,
                    'name' => 'Racha',
                    'country_id' => 81,
                ),
            1333 =>
                array (
                    'id' => 1350,
                    'name' => 'Samagrelo-Zemo Svaneti',
                    'country_id' => 81,
                ),
            1334 =>
                array (
                    'id' => 1351,
                    'name' => 'Samche-Zhavaheti',
                    'country_id' => 81,
                ),
            1335 =>
                array (
                    'id' => 1352,
                    'name' => 'Shida Kartli',
                    'country_id' => 81,
                ),
            1336 =>
                array (
                    'id' => 1353,
                    'name' => 'Tbilisi',
                    'country_id' => 81,
                ),
            1337 =>
                array (
                    'id' => 1354,
                    'name' => 'Auvergne',
                    'country_id' => 82,
                ),
            1338 =>
                array (
                    'id' => 1355,
                    'name' => 'Baden-Wurttemberg',
                    'country_id' => 82,
                ),
            1339 =>
                array (
                    'id' => 1356,
                    'name' => 'Bavaria',
                    'country_id' => 82,
                ),
            1340 =>
                array (
                    'id' => 1357,
                    'name' => 'Bayern',
                    'country_id' => 82,
                ),
            1341 =>
                array (
                    'id' => 1358,
                    'name' => 'Beilstein Wurtt',
                    'country_id' => 82,
                ),
            1342 =>
                array (
                    'id' => 1359,
                    'name' => 'Berlin',
                    'country_id' => 82,
                ),
            1343 =>
                array (
                    'id' => 1360,
                    'name' => 'Brandenburg',
                    'country_id' => 82,
                ),
            1344 =>
                array (
                    'id' => 1361,
                    'name' => 'Bremen',
                    'country_id' => 82,
                ),
            1345 =>
                array (
                    'id' => 1362,
                    'name' => 'Dreisbach',
                    'country_id' => 82,
                ),
            1346 =>
                array (
                    'id' => 1363,
                    'name' => 'Freistaat Bayern',
                    'country_id' => 82,
                ),
            1347 =>
                array (
                    'id' => 1364,
                    'name' => 'Hamburg',
                    'country_id' => 82,
                ),
            1348 =>
                array (
                    'id' => 1365,
                    'name' => 'Hannover',
                    'country_id' => 82,
                ),
            1349 =>
                array (
                    'id' => 1366,
                    'name' => 'Heroldstatt',
                    'country_id' => 82,
                ),
            1350 =>
                array (
                    'id' => 1367,
                    'name' => 'Hessen',
                    'country_id' => 82,
                ),
            1351 =>
                array (
                    'id' => 1368,
                    'name' => 'Kortenberg',
                    'country_id' => 82,
                ),
            1352 =>
                array (
                    'id' => 1369,
                    'name' => 'Laasdorf',
                    'country_id' => 82,
                ),
            1353 =>
                array (
                    'id' => 1370,
                    'name' => 'Land Baden-Wurttemberg',
                    'country_id' => 82,
                ),
            1354 =>
                array (
                    'id' => 1371,
                    'name' => 'Land Bayern',
                    'country_id' => 82,
                ),
            1355 =>
                array (
                    'id' => 1372,
                    'name' => 'Land Brandenburg',
                    'country_id' => 82,
                ),
            1356 =>
                array (
                    'id' => 1373,
                    'name' => 'Land Hessen',
                    'country_id' => 82,
                ),
            1357 =>
                array (
                    'id' => 1374,
                    'name' => 'Land Mecklenburg-Vorpommern',
                    'country_id' => 82,
                ),
            1358 =>
                array (
                    'id' => 1375,
                    'name' => 'Land Nordrhein-Westfalen',
                    'country_id' => 82,
                ),
            1359 =>
                array (
                    'id' => 1376,
                    'name' => 'Land Rheinland-Pfalz',
                    'country_id' => 82,
                ),
            1360 =>
                array (
                    'id' => 1377,
                    'name' => 'Land Sachsen',
                    'country_id' => 82,
                ),
            1361 =>
                array (
                    'id' => 1378,
                    'name' => 'Land Sachsen-Anhalt',
                    'country_id' => 82,
                ),
            1362 =>
                array (
                    'id' => 1379,
                    'name' => 'Land Thuringen',
                    'country_id' => 82,
                ),
            1363 =>
                array (
                    'id' => 1380,
                    'name' => 'Lower Saxony',
                    'country_id' => 82,
                ),
            1364 =>
                array (
                    'id' => 1381,
                    'name' => 'Mecklenburg-Vorpommern',
                    'country_id' => 82,
                ),
            1365 =>
                array (
                    'id' => 1382,
                    'name' => 'Mulfingen',
                    'country_id' => 82,
                ),
            1366 =>
                array (
                    'id' => 1383,
                    'name' => 'Munich',
                    'country_id' => 82,
                ),
            1367 =>
                array (
                    'id' => 1384,
                    'name' => 'Neubeuern',
                    'country_id' => 82,
                ),
            1368 =>
                array (
                    'id' => 1385,
                    'name' => 'Niedersachsen',
                    'country_id' => 82,
                ),
            1369 =>
                array (
                    'id' => 1386,
                    'name' => 'Noord-Holland',
                    'country_id' => 82,
                ),
            1370 =>
                array (
                    'id' => 1387,
                    'name' => 'Nordrhein-Westfalen',
                    'country_id' => 82,
                ),
            1371 =>
                array (
                    'id' => 1388,
                    'name' => 'North Rhine-Westphalia',
                    'country_id' => 82,
                ),
            1372 =>
                array (
                    'id' => 1389,
                    'name' => 'Osterode',
                    'country_id' => 82,
                ),
            1373 =>
                array (
                    'id' => 1390,
                    'name' => 'Rheinland-Pfalz',
                    'country_id' => 82,
                ),
            1374 =>
                array (
                    'id' => 1391,
                    'name' => 'Rhineland-Palatinate',
                    'country_id' => 82,
                ),
            1375 =>
                array (
                    'id' => 1392,
                    'name' => 'Saarland',
                    'country_id' => 82,
                ),
            1376 =>
                array (
                    'id' => 1393,
                    'name' => 'Sachsen',
                    'country_id' => 82,
                ),
            1377 =>
                array (
                    'id' => 1394,
                    'name' => 'Sachsen-Anhalt',
                    'country_id' => 82,
                ),
            1378 =>
                array (
                    'id' => 1395,
                    'name' => 'Saxony',
                    'country_id' => 82,
                ),
            1379 =>
                array (
                    'id' => 1396,
                    'name' => 'Schleswig-Holstein',
                    'country_id' => 82,
                ),
            1380 =>
                array (
                    'id' => 1397,
                    'name' => 'Thuringia',
                    'country_id' => 82,
                ),
            1381 =>
                array (
                    'id' => 1398,
                    'name' => 'Webling',
                    'country_id' => 82,
                ),
            1382 =>
                array (
                    'id' => 1399,
                    'name' => 'Weinstrabe',
                    'country_id' => 82,
                ),
            1383 =>
                array (
                    'id' => 1400,
                    'name' => 'schlobborn',
                    'country_id' => 82,
                ),
            1384 =>
                array (
                    'id' => 1401,
                    'name' => 'Ashanti',
                    'country_id' => 83,
                ),
            1385 =>
                array (
                    'id' => 1402,
                    'name' => 'Brong-Ahafo',
                    'country_id' => 83,
                ),
            1386 =>
                array (
                    'id' => 1403,
                    'name' => 'Central',
                    'country_id' => 83,
                ),
            1387 =>
                array (
                    'id' => 1404,
                    'name' => 'Eastern',
                    'country_id' => 83,
                ),
            1388 =>
                array (
                    'id' => 1405,
                    'name' => 'Greater Accra',
                    'country_id' => 83,
                ),
            1389 =>
                array (
                    'id' => 1406,
                    'name' => 'Northern',
                    'country_id' => 83,
                ),
            1390 =>
                array (
                    'id' => 1407,
                    'name' => 'Upper East',
                    'country_id' => 83,
                ),
            1391 =>
                array (
                    'id' => 1408,
                    'name' => 'Upper West',
                    'country_id' => 83,
                ),
            1392 =>
                array (
                    'id' => 1409,
                    'name' => 'Volta',
                    'country_id' => 83,
                ),
            1393 =>
                array (
                    'id' => 1410,
                    'name' => 'Western',
                    'country_id' => 83,
                ),
            1394 =>
                array (
                    'id' => 1411,
                    'name' => 'Gibraltar',
                    'country_id' => 84,
                ),
            1395 =>
                array (
                    'id' => 1412,
                    'name' => 'Acharnes',
                    'country_id' => 85,
                ),
            1396 =>
                array (
                    'id' => 1413,
                    'name' => 'Ahaia',
                    'country_id' => 85,
                ),
            1397 =>
                array (
                    'id' => 1414,
                    'name' => 'Aitolia kai Akarnania',
                    'country_id' => 85,
                ),
            1398 =>
                array (
                    'id' => 1415,
                    'name' => 'Argolis',
                    'country_id' => 85,
                ),
            1399 =>
                array (
                    'id' => 1416,
                    'name' => 'Arkadia',
                    'country_id' => 85,
                ),
            1400 =>
                array (
                    'id' => 1417,
                    'name' => 'Arta',
                    'country_id' => 85,
                ),
            1401 =>
                array (
                    'id' => 1418,
                    'name' => 'Attica',
                    'country_id' => 85,
                ),
            1402 =>
                array (
                    'id' => 1419,
                    'name' => 'Attiki',
                    'country_id' => 85,
                ),
            1403 =>
                array (
                    'id' => 1420,
                    'name' => 'Ayion Oros',
                    'country_id' => 85,
                ),
            1404 =>
                array (
                    'id' => 1421,
                    'name' => 'Crete',
                    'country_id' => 85,
                ),
            1405 =>
                array (
                    'id' => 1422,
                    'name' => 'Dodekanisos',
                    'country_id' => 85,
                ),
            1406 =>
                array (
                    'id' => 1423,
                    'name' => 'Drama',
                    'country_id' => 85,
                ),
            1407 =>
                array (
                    'id' => 1424,
                    'name' => 'Evia',
                    'country_id' => 85,
                ),
            1408 =>
                array (
                    'id' => 1425,
                    'name' => 'Evritania',
                    'country_id' => 85,
                ),
            1409 =>
                array (
                    'id' => 1426,
                    'name' => 'Evros',
                    'country_id' => 85,
                ),
            1410 =>
                array (
                    'id' => 1427,
                    'name' => 'Evvoia',
                    'country_id' => 85,
                ),
            1411 =>
                array (
                    'id' => 1428,
                    'name' => 'Florina',
                    'country_id' => 85,
                ),
            1412 =>
                array (
                    'id' => 1429,
                    'name' => 'Fokis',
                    'country_id' => 85,
                ),
            1413 =>
                array (
                    'id' => 1430,
                    'name' => 'Fthiotis',
                    'country_id' => 85,
                ),
            1414 =>
                array (
                    'id' => 1431,
                    'name' => 'Grevena',
                    'country_id' => 85,
                ),
            1415 =>
                array (
                    'id' => 1432,
                    'name' => 'Halandri',
                    'country_id' => 85,
                ),
            1416 =>
                array (
                    'id' => 1433,
                    'name' => 'Halkidiki',
                    'country_id' => 85,
                ),
            1417 =>
                array (
                    'id' => 1434,
                    'name' => 'Hania',
                    'country_id' => 85,
                ),
            1418 =>
                array (
                    'id' => 1435,
                    'name' => 'Heraklion',
                    'country_id' => 85,
                ),
            1419 =>
                array (
                    'id' => 1436,
                    'name' => 'Hios',
                    'country_id' => 85,
                ),
            1420 =>
                array (
                    'id' => 1437,
                    'name' => 'Ilia',
                    'country_id' => 85,
                ),
            1421 =>
                array (
                    'id' => 1438,
                    'name' => 'Imathia',
                    'country_id' => 85,
                ),
            1422 =>
                array (
                    'id' => 1439,
                    'name' => 'Ioannina',
                    'country_id' => 85,
                ),
            1423 =>
                array (
                    'id' => 1440,
                    'name' => 'Iraklion',
                    'country_id' => 85,
                ),
            1424 =>
                array (
                    'id' => 1441,
                    'name' => 'Karditsa',
                    'country_id' => 85,
                ),
            1425 =>
                array (
                    'id' => 1442,
                    'name' => 'Kastoria',
                    'country_id' => 85,
                ),
            1426 =>
                array (
                    'id' => 1443,
                    'name' => 'Kavala',
                    'country_id' => 85,
                ),
            1427 =>
                array (
                    'id' => 1444,
                    'name' => 'Kefallinia',
                    'country_id' => 85,
                ),
            1428 =>
                array (
                    'id' => 1445,
                    'name' => 'Kerkira',
                    'country_id' => 85,
                ),
            1429 =>
                array (
                    'id' => 1446,
                    'name' => 'Kiklades',
                    'country_id' => 85,
                ),
            1430 =>
                array (
                    'id' => 1447,
                    'name' => 'Kilkis',
                    'country_id' => 85,
                ),
            1431 =>
                array (
                    'id' => 1448,
                    'name' => 'Korinthia',
                    'country_id' => 85,
                ),
            1432 =>
                array (
                    'id' => 1449,
                    'name' => 'Kozani',
                    'country_id' => 85,
                ),
            1433 =>
                array (
                    'id' => 1450,
                    'name' => 'Lakonia',
                    'country_id' => 85,
                ),
            1434 =>
                array (
                    'id' => 1451,
                    'name' => 'Larisa',
                    'country_id' => 85,
                ),
            1435 =>
                array (
                    'id' => 1452,
                    'name' => 'Lasithi',
                    'country_id' => 85,
                ),
            1436 =>
                array (
                    'id' => 1453,
                    'name' => 'Lesvos',
                    'country_id' => 85,
                ),
            1437 =>
                array (
                    'id' => 1454,
                    'name' => 'Levkas',
                    'country_id' => 85,
                ),
            1438 =>
                array (
                    'id' => 1455,
                    'name' => 'Magnisia',
                    'country_id' => 85,
                ),
            1439 =>
                array (
                    'id' => 1456,
                    'name' => 'Messinia',
                    'country_id' => 85,
                ),
            1440 =>
                array (
                    'id' => 1457,
                    'name' => 'Nomos Attikis',
                    'country_id' => 85,
                ),
            1441 =>
                array (
                    'id' => 1458,
                    'name' => 'Nomos Zakynthou',
                    'country_id' => 85,
                ),
            1442 =>
                array (
                    'id' => 1459,
                    'name' => 'Pella',
                    'country_id' => 85,
                ),
            1443 =>
                array (
                    'id' => 1460,
                    'name' => 'Pieria',
                    'country_id' => 85,
                ),
            1444 =>
                array (
                    'id' => 1461,
                    'name' => 'Piraios',
                    'country_id' => 85,
                ),
            1445 =>
                array (
                    'id' => 1462,
                    'name' => 'Preveza',
                    'country_id' => 85,
                ),
            1446 =>
                array (
                    'id' => 1463,
                    'name' => 'Rethimni',
                    'country_id' => 85,
                ),
            1447 =>
                array (
                    'id' => 1464,
                    'name' => 'Rodopi',
                    'country_id' => 85,
                ),
            1448 =>
                array (
                    'id' => 1465,
                    'name' => 'Samos',
                    'country_id' => 85,
                ),
            1449 =>
                array (
                    'id' => 1466,
                    'name' => 'Serrai',
                    'country_id' => 85,
                ),
            1450 =>
                array (
                    'id' => 1467,
                    'name' => 'Thesprotia',
                    'country_id' => 85,
                ),
            1451 =>
                array (
                    'id' => 1468,
                    'name' => 'Thessaloniki',
                    'country_id' => 85,
                ),
            1452 =>
                array (
                    'id' => 1469,
                    'name' => 'Trikala',
                    'country_id' => 85,
                ),
            1453 =>
                array (
                    'id' => 1470,
                    'name' => 'Voiotia',
                    'country_id' => 85,
                ),
            1454 =>
                array (
                    'id' => 1471,
                    'name' => 'West Greece',
                    'country_id' => 85,
                ),
            1455 =>
                array (
                    'id' => 1472,
                    'name' => 'Xanthi',
                    'country_id' => 85,
                ),
            1456 =>
                array (
                    'id' => 1473,
                    'name' => 'Zakinthos',
                    'country_id' => 85,
                ),
            1457 =>
                array (
                    'id' => 1474,
                    'name' => 'Aasiaat',
                    'country_id' => 86,
                ),
            1458 =>
                array (
                    'id' => 1475,
                    'name' => 'Ammassalik',
                    'country_id' => 86,
                ),
            1459 =>
                array (
                    'id' => 1476,
                    'name' => 'Illoqqortoormiut',
                    'country_id' => 86,
                ),
            1460 =>
                array (
                    'id' => 1477,
                    'name' => 'Ilulissat',
                    'country_id' => 86,
                ),
            1461 =>
                array (
                    'id' => 1478,
                    'name' => 'Ivittuut',
                    'country_id' => 86,
                ),
            1462 =>
                array (
                    'id' => 1479,
                    'name' => 'Kangaatsiaq',
                    'country_id' => 86,
                ),
            1463 =>
                array (
                    'id' => 1480,
                    'name' => 'Maniitsoq',
                    'country_id' => 86,
                ),
            1464 =>
                array (
                    'id' => 1481,
                    'name' => 'Nanortalik',
                    'country_id' => 86,
                ),
            1465 =>
                array (
                    'id' => 1482,
                    'name' => 'Narsaq',
                    'country_id' => 86,
                ),
            1466 =>
                array (
                    'id' => 1483,
                    'name' => 'Nuuk',
                    'country_id' => 86,
                ),
            1467 =>
                array (
                    'id' => 1484,
                    'name' => 'Paamiut',
                    'country_id' => 86,
                ),
            1468 =>
                array (
                    'id' => 1485,
                    'name' => 'Qaanaaq',
                    'country_id' => 86,
                ),
            1469 =>
                array (
                    'id' => 1486,
                    'name' => 'Qaqortoq',
                    'country_id' => 86,
                ),
            1470 =>
                array (
                    'id' => 1487,
                    'name' => 'Qasigiannguit',
                    'country_id' => 86,
                ),
            1471 =>
                array (
                    'id' => 1488,
                    'name' => 'Qeqertarsuaq',
                    'country_id' => 86,
                ),
            1472 =>
                array (
                    'id' => 1489,
                    'name' => 'Sisimiut',
                    'country_id' => 86,
                ),
            1473 =>
                array (
                    'id' => 1490,
                    'name' => 'Udenfor kommunal inddeling',
                    'country_id' => 86,
                ),
            1474 =>
                array (
                    'id' => 1491,
                    'name' => 'Upernavik',
                    'country_id' => 86,
                ),
            1475 =>
                array (
                    'id' => 1492,
                    'name' => 'Uummannaq',
                    'country_id' => 86,
                ),
            1476 =>
                array (
                    'id' => 1493,
                    'name' => 'Carriacou-Petite Martinique',
                    'country_id' => 87,
                ),
            1477 =>
                array (
                    'id' => 1494,
                    'name' => 'Saint Andrew',
                    'country_id' => 87,
                ),
            1478 =>
                array (
                    'id' => 1495,
                    'name' => 'Saint Davids',
                    'country_id' => 87,
                ),
            1479 =>
                array (
                    'id' => 1496,
                    'name' => 'Saint George\'s',
                    'country_id' => 87,
                ),
            1480 =>
                array (
                    'id' => 1497,
                    'name' => 'Saint John',
                    'country_id' => 87,
                ),
            1481 =>
                array (
                    'id' => 1498,
                    'name' => 'Saint Mark',
                    'country_id' => 87,
                ),
            1482 =>
                array (
                    'id' => 1499,
                    'name' => 'Saint Patrick',
                    'country_id' => 87,
                ),
            1483 =>
                array (
                    'id' => 1500,
                    'name' => 'Basse-Terre',
                    'country_id' => 88,
                ),
            1484 =>
                array (
                    'id' => 1501,
                    'name' => 'Grande-Terre',
                    'country_id' => 88,
                ),
            1485 =>
                array (
                    'id' => 1502,
                    'name' => 'Iles des Saintes',
                    'country_id' => 88,
                ),
            1486 =>
                array (
                    'id' => 1503,
                    'name' => 'La Desirade',
                    'country_id' => 88,
                ),
            1487 =>
                array (
                    'id' => 1504,
                    'name' => 'Marie-Galante',
                    'country_id' => 88,
                ),
            1488 =>
                array (
                    'id' => 1505,
                    'name' => 'Saint Barthelemy',
                    'country_id' => 88,
                ),
            1489 =>
                array (
                    'id' => 1506,
                    'name' => 'Saint Martin',
                    'country_id' => 88,
                ),
            1490 =>
                array (
                    'id' => 1507,
                    'name' => 'Agana Heights',
                    'country_id' => 89,
                ),
            1491 =>
                array (
                    'id' => 1508,
                    'name' => 'Agat',
                    'country_id' => 89,
                ),
            1492 =>
                array (
                    'id' => 1509,
                    'name' => 'Barrigada',
                    'country_id' => 89,
                ),
            1493 =>
                array (
                    'id' => 1510,
                    'name' => 'Chalan-Pago-Ordot',
                    'country_id' => 89,
                ),
            1494 =>
                array (
                    'id' => 1511,
                    'name' => 'Dededo',
                    'country_id' => 89,
                ),
            1495 =>
                array (
                    'id' => 1512,
                    'name' => 'Hagatna',
                    'country_id' => 89,
                ),
            1496 =>
                array (
                    'id' => 1513,
                    'name' => 'Inarajan',
                    'country_id' => 89,
                ),
            1497 =>
                array (
                    'id' => 1514,
                    'name' => 'Mangilao',
                    'country_id' => 89,
                ),
            1498 =>
                array (
                    'id' => 1515,
                    'name' => 'Merizo',
                    'country_id' => 89,
                ),
            1499 =>
                array (
                    'id' => 1516,
                    'name' => 'Mongmong-Toto-Maite',
                    'country_id' => 89,
                ),
            1500 =>
                array (
                    'id' => 1517,
                    'name' => 'Santa Rita',
                    'country_id' => 89,
                ),
            1501 =>
                array (
                    'id' => 1518,
                    'name' => 'Sinajana',
                    'country_id' => 89,
                ),
            1502 =>
                array (
                    'id' => 1519,
                    'name' => 'Talofofo',
                    'country_id' => 89,
                ),
            1503 =>
                array (
                    'id' => 1520,
                    'name' => 'Tamuning',
                    'country_id' => 89,
                ),
            1504 =>
                array (
                    'id' => 1521,
                    'name' => 'Yigo',
                    'country_id' => 89,
                ),
            1505 =>
                array (
                    'id' => 1522,
                    'name' => 'Yona',
                    'country_id' => 89,
                ),
            1506 =>
                array (
                    'id' => 1523,
                    'name' => 'Alta Verapaz',
                    'country_id' => 90,
                ),
            1507 =>
                array (
                    'id' => 1524,
                    'name' => 'Baja Verapaz',
                    'country_id' => 90,
                ),
            1508 =>
                array (
                    'id' => 1525,
                    'name' => 'Chimaltenango',
                    'country_id' => 90,
                ),
            1509 =>
                array (
                    'id' => 1526,
                    'name' => 'Chiquimula',
                    'country_id' => 90,
                ),
            1510 =>
                array (
                    'id' => 1527,
                    'name' => 'El Progreso',
                    'country_id' => 90,
                ),
            1511 =>
                array (
                    'id' => 1528,
                    'name' => 'Escuintla',
                    'country_id' => 90,
                ),
            1512 =>
                array (
                    'id' => 1529,
                    'name' => 'Guatemala',
                    'country_id' => 90,
                ),
            1513 =>
                array (
                    'id' => 1530,
                    'name' => 'Huehuetenango',
                    'country_id' => 90,
                ),
            1514 =>
                array (
                    'id' => 1531,
                    'name' => 'Izabal',
                    'country_id' => 90,
                ),
            1515 =>
                array (
                    'id' => 1532,
                    'name' => 'Jalapa',
                    'country_id' => 90,
                ),
            1516 =>
                array (
                    'id' => 1533,
                    'name' => 'Jutiapa',
                    'country_id' => 90,
                ),
            1517 =>
                array (
                    'id' => 1534,
                    'name' => 'Peten',
                    'country_id' => 90,
                ),
            1518 =>
                array (
                    'id' => 1535,
                    'name' => 'Quezaltenango',
                    'country_id' => 90,
                ),
            1519 =>
                array (
                    'id' => 1536,
                    'name' => 'Quiche',
                    'country_id' => 90,
                ),
            1520 =>
                array (
                    'id' => 1537,
                    'name' => 'Retalhuleu',
                    'country_id' => 90,
                ),
            1521 =>
                array (
                    'id' => 1538,
                    'name' => 'Sacatepequez',
                    'country_id' => 90,
                ),
            1522 =>
                array (
                    'id' => 1539,
                    'name' => 'San Marcos',
                    'country_id' => 90,
                ),
            1523 =>
                array (
                    'id' => 1540,
                    'name' => 'Santa Rosa',
                    'country_id' => 90,
                ),
            1524 =>
                array (
                    'id' => 1541,
                    'name' => 'Solola',
                    'country_id' => 90,
                ),
            1525 =>
                array (
                    'id' => 1542,
                    'name' => 'Suchitepequez',
                    'country_id' => 90,
                ),
            1526 =>
                array (
                    'id' => 1543,
                    'name' => 'Totonicapan',
                    'country_id' => 90,
                ),
            1527 =>
                array (
                    'id' => 1544,
                    'name' => 'Zacapa',
                    'country_id' => 90,
                ),
            1528 =>
                array (
                    'id' => 1557,
                    'name' => 'Beyla',
                    'country_id' => 92,
                ),
            1529 =>
                array (
                    'id' => 1558,
                    'name' => 'Boffa',
                    'country_id' => 92,
                ),
            1530 =>
                array (
                    'id' => 1559,
                    'name' => 'Boke',
                    'country_id' => 92,
                ),
            1531 =>
                array (
                    'id' => 1560,
                    'name' => 'Conakry',
                    'country_id' => 92,
                ),
            1532 =>
                array (
                    'id' => 1561,
                    'name' => 'Coyah',
                    'country_id' => 92,
                ),
            1533 =>
                array (
                    'id' => 1562,
                    'name' => 'Dabola',
                    'country_id' => 92,
                ),
            1534 =>
                array (
                    'id' => 1563,
                    'name' => 'Dalaba',
                    'country_id' => 92,
                ),
            1535 =>
                array (
                    'id' => 1564,
                    'name' => 'Dinguiraye',
                    'country_id' => 92,
                ),
            1536 =>
                array (
                    'id' => 1565,
                    'name' => 'Faranah',
                    'country_id' => 92,
                ),
            1537 =>
                array (
                    'id' => 1566,
                    'name' => 'Forecariah',
                    'country_id' => 92,
                ),
            1538 =>
                array (
                    'id' => 1567,
                    'name' => 'Fria',
                    'country_id' => 92,
                ),
            1539 =>
                array (
                    'id' => 1568,
                    'name' => 'Gaoual',
                    'country_id' => 92,
                ),
            1540 =>
                array (
                    'id' => 1569,
                    'name' => 'Gueckedou',
                    'country_id' => 92,
                ),
            1541 =>
                array (
                    'id' => 1570,
                    'name' => 'Kankan',
                    'country_id' => 92,
                ),
            1542 =>
                array (
                    'id' => 1571,
                    'name' => 'Kerouane',
                    'country_id' => 92,
                ),
            1543 =>
                array (
                    'id' => 1572,
                    'name' => 'Kindia',
                    'country_id' => 92,
                ),
            1544 =>
                array (
                    'id' => 1573,
                    'name' => 'Kissidougou',
                    'country_id' => 92,
                ),
            1545 =>
                array (
                    'id' => 1574,
                    'name' => 'Koubia',
                    'country_id' => 92,
                ),
            1546 =>
                array (
                    'id' => 1575,
                    'name' => 'Koundara',
                    'country_id' => 92,
                ),
            1547 =>
                array (
                    'id' => 1576,
                    'name' => 'Kouroussa',
                    'country_id' => 92,
                ),
            1548 =>
                array (
                    'id' => 1577,
                    'name' => 'Labe',
                    'country_id' => 92,
                ),
            1549 =>
                array (
                    'id' => 1578,
                    'name' => 'Lola',
                    'country_id' => 92,
                ),
            1550 =>
                array (
                    'id' => 1579,
                    'name' => 'Macenta',
                    'country_id' => 92,
                ),
            1551 =>
                array (
                    'id' => 1580,
                    'name' => 'Mali',
                    'country_id' => 92,
                ),
            1552 =>
                array (
                    'id' => 1581,
                    'name' => 'Mamou',
                    'country_id' => 92,
                ),
            1553 =>
                array (
                    'id' => 1582,
                    'name' => 'Mandiana',
                    'country_id' => 92,
                ),
            1554 =>
                array (
                    'id' => 1583,
                    'name' => 'Nzerekore',
                    'country_id' => 92,
                ),
            1555 =>
                array (
                    'id' => 1584,
                    'name' => 'Pita',
                    'country_id' => 92,
                ),
            1556 =>
                array (
                    'id' => 1585,
                    'name' => 'Siguiri',
                    'country_id' => 92,
                ),
            1557 =>
                array (
                    'id' => 1586,
                    'name' => 'Telimele',
                    'country_id' => 92,
                ),
            1558 =>
                array (
                    'id' => 1587,
                    'name' => 'Tougue',
                    'country_id' => 92,
                ),
            1559 =>
                array (
                    'id' => 1588,
                    'name' => 'Yomou',
                    'country_id' => 92,
                ),
            1560 =>
                array (
                    'id' => 1589,
                    'name' => 'Bafata',
                    'country_id' => 93,
                ),
            1561 =>
                array (
                    'id' => 1590,
                    'name' => 'Bissau',
                    'country_id' => 93,
                ),
            1562 =>
                array (
                    'id' => 1591,
                    'name' => 'Bolama',
                    'country_id' => 93,
                ),
            1563 =>
                array (
                    'id' => 1592,
                    'name' => 'Cacheu',
                    'country_id' => 93,
                ),
            1564 =>
                array (
                    'id' => 1593,
                    'name' => 'Gabu',
                    'country_id' => 93,
                ),
            1565 =>
                array (
                    'id' => 1594,
                    'name' => 'Oio',
                    'country_id' => 93,
                ),
            1566 =>
                array (
                    'id' => 1595,
                    'name' => 'Quinara',
                    'country_id' => 93,
                ),
            1567 =>
                array (
                    'id' => 1596,
                    'name' => 'Tombali',
                    'country_id' => 93,
                ),
            1568 =>
                array (
                    'id' => 1597,
                    'name' => 'Barima-Waini',
                    'country_id' => 94,
                ),
            1569 =>
                array (
                    'id' => 1598,
                    'name' => 'Cuyuni-Mazaruni',
                    'country_id' => 94,
                ),
            1570 =>
                array (
                    'id' => 1599,
                    'name' => 'Demerara-Mahaica',
                    'country_id' => 94,
                ),
            1571 =>
                array (
                    'id' => 1600,
                    'name' => 'East Berbice-Corentyne',
                    'country_id' => 94,
                ),
            1572 =>
                array (
                    'id' => 1601,
                    'name' => 'Essequibo Islands-West Demerar',
                    'country_id' => 94,
                ),
            1573 =>
                array (
                    'id' => 1602,
                    'name' => 'Mahaica-Berbice',
                    'country_id' => 94,
                ),
            1574 =>
                array (
                    'id' => 1603,
                    'name' => 'Pomeroon-Supenaam',
                    'country_id' => 94,
                ),
            1575 =>
                array (
                    'id' => 1604,
                    'name' => 'Potaro-Siparuni',
                    'country_id' => 94,
                ),
            1576 =>
                array (
                    'id' => 1605,
                    'name' => 'Upper Demerara-Berbice',
                    'country_id' => 94,
                ),
            1577 =>
                array (
                    'id' => 1606,
                    'name' => 'Upper Takutu-Upper Essequibo',
                    'country_id' => 94,
                ),
            1578 =>
                array (
                    'id' => 1607,
                    'name' => 'Artibonite',
                    'country_id' => 95,
                ),
            1579 =>
                array (
                    'id' => 1608,
                    'name' => 'Centre',
                    'country_id' => 95,
                ),
            1580 =>
                array (
                    'id' => 1609,
                    'name' => 'Grand\'Anse',
                    'country_id' => 95,
                ),
            1581 =>
                array (
                    'id' => 1610,
                    'name' => 'Nord',
                    'country_id' => 95,
                ),
            1582 =>
                array (
                    'id' => 1611,
                    'name' => 'Nord-Est',
                    'country_id' => 95,
                ),
            1583 =>
                array (
                    'id' => 1612,
                    'name' => 'Nord-Ouest',
                    'country_id' => 95,
                ),
            1584 =>
                array (
                    'id' => 1613,
                    'name' => 'Ouest',
                    'country_id' => 95,
                ),
            1585 =>
                array (
                    'id' => 1614,
                    'name' => 'Sud',
                    'country_id' => 95,
                ),
            1586 =>
                array (
                    'id' => 1615,
                    'name' => 'Sud-Est',
                    'country_id' => 95,
                ),
            1587 =>
                array (
                    'id' => 1616,
                    'name' => 'Heard and McDonald Islands',
                    'country_id' => 96,
                ),
            1588 =>
                array (
                    'id' => 1617,
                    'name' => 'Atlantida',
                    'country_id' => 97,
                ),
            1589 =>
                array (
                    'id' => 1618,
                    'name' => 'Choluteca',
                    'country_id' => 97,
                ),
            1590 =>
                array (
                    'id' => 1619,
                    'name' => 'Colon',
                    'country_id' => 97,
                ),
            1591 =>
                array (
                    'id' => 1620,
                    'name' => 'Comayagua',
                    'country_id' => 97,
                ),
            1592 =>
                array (
                    'id' => 1621,
                    'name' => 'Copan',
                    'country_id' => 97,
                ),
            1593 =>
                array (
                    'id' => 1622,
                    'name' => 'Cortes',
                    'country_id' => 97,
                ),
            1594 =>
                array (
                    'id' => 1623,
                    'name' => 'Distrito Central',
                    'country_id' => 97,
                ),
            1595 =>
                array (
                    'id' => 1624,
                    'name' => 'El Paraiso',
                    'country_id' => 97,
                ),
            1596 =>
                array (
                    'id' => 1625,
                    'name' => 'Francisco Morazan',
                    'country_id' => 97,
                ),
            1597 =>
                array (
                    'id' => 1626,
                    'name' => 'Gracias a Dios',
                    'country_id' => 97,
                ),
            1598 =>
                array (
                    'id' => 1627,
                    'name' => 'Intibuca',
                    'country_id' => 97,
                ),
            1599 =>
                array (
                    'id' => 1628,
                    'name' => 'Islas de la Bahia',
                    'country_id' => 97,
                ),
            1600 =>
                array (
                    'id' => 1629,
                    'name' => 'La Paz',
                    'country_id' => 97,
                ),
            1601 =>
                array (
                    'id' => 1630,
                    'name' => 'Lempira',
                    'country_id' => 97,
                ),
            1602 =>
                array (
                    'id' => 1631,
                    'name' => 'Ocotepeque',
                    'country_id' => 97,
                ),
            1603 =>
                array (
                    'id' => 1632,
                    'name' => 'Olancho',
                    'country_id' => 97,
                ),
            1604 =>
                array (
                    'id' => 1633,
                    'name' => 'Santa Barbara',
                    'country_id' => 97,
                ),
            1605 =>
                array (
                    'id' => 1634,
                    'name' => 'Valle',
                    'country_id' => 97,
                ),
            1606 =>
                array (
                    'id' => 1635,
                    'name' => 'Yoro',
                    'country_id' => 97,
                ),
            1607 =>
                array (
                    'id' => 1636,
                    'name' => 'Hong Kong',
                    'country_id' => 98,
                ),
            1608 =>
                array (
                    'id' => 1637,
                    'name' => 'Bacs-Kiskun',
                    'country_id' => 99,
                ),
            1609 =>
                array (
                    'id' => 1638,
                    'name' => 'Baranya',
                    'country_id' => 99,
                ),
            1610 =>
                array (
                    'id' => 1639,
                    'name' => 'Bekes',
                    'country_id' => 99,
                ),
            1611 =>
                array (
                    'id' => 1640,
                    'name' => 'Borsod-Abauj-Zemplen',
                    'country_id' => 99,
                ),
            1612 =>
                array (
                    'id' => 1641,
                    'name' => 'Budapest',
                    'country_id' => 99,
                ),
            1613 =>
                array (
                    'id' => 1642,
                    'name' => 'Csongrad',
                    'country_id' => 99,
                ),
            1614 =>
                array (
                    'id' => 1643,
                    'name' => 'Fejer',
                    'country_id' => 99,
                ),
            1615 =>
                array (
                    'id' => 1644,
                    'name' => 'Gyor-Moson-Sopron',
                    'country_id' => 99,
                ),
            1616 =>
                array (
                    'id' => 1645,
                    'name' => 'Hajdu-Bihar',
                    'country_id' => 99,
                ),
            1617 =>
                array (
                    'id' => 1646,
                    'name' => 'Heves',
                    'country_id' => 99,
                ),
            1618 =>
                array (
                    'id' => 1647,
                    'name' => 'Jasz-Nagykun-Szolnok',
                    'country_id' => 99,
                ),
            1619 =>
                array (
                    'id' => 1648,
                    'name' => 'Komarom-Esztergom',
                    'country_id' => 99,
                ),
            1620 =>
                array (
                    'id' => 1649,
                    'name' => 'Nograd',
                    'country_id' => 99,
                ),
            1621 =>
                array (
                    'id' => 1650,
                    'name' => 'Pest',
                    'country_id' => 99,
                ),
            1622 =>
                array (
                    'id' => 1651,
                    'name' => 'Somogy',
                    'country_id' => 99,
                ),
            1623 =>
                array (
                    'id' => 1652,
                    'name' => 'Szabolcs-Szatmar-Bereg',
                    'country_id' => 99,
                ),
            1624 =>
                array (
                    'id' => 1653,
                    'name' => 'Tolna',
                    'country_id' => 99,
                ),
            1625 =>
                array (
                    'id' => 1654,
                    'name' => 'Vas',
                    'country_id' => 99,
                ),
            1626 =>
                array (
                    'id' => 1655,
                    'name' => 'Veszprem',
                    'country_id' => 99,
                ),
            1627 =>
                array (
                    'id' => 1656,
                    'name' => 'Zala',
                    'country_id' => 99,
                ),
            1628 =>
                array (
                    'id' => 1657,
                    'name' => 'Austurland',
                    'country_id' => 100,
                ),
            1629 =>
                array (
                    'id' => 1658,
                    'name' => 'Gullbringusysla',
                    'country_id' => 100,
                ),
            1630 =>
                array (
                    'id' => 1659,
                    'name' => 'Hofu borgarsva i',
                    'country_id' => 100,
                ),
            1631 =>
                array (
                    'id' => 1660,
                    'name' => 'Nor urland eystra',
                    'country_id' => 100,
                ),
            1632 =>
                array (
                    'id' => 1661,
                    'name' => 'Nor urland vestra',
                    'country_id' => 100,
                ),
            1633 =>
                array (
                    'id' => 1662,
                    'name' => 'Su urland',
                    'country_id' => 100,
                ),
            1634 =>
                array (
                    'id' => 1663,
                    'name' => 'Su urnes',
                    'country_id' => 100,
                ),
            1635 =>
                array (
                    'id' => 1664,
                    'name' => 'Vestfir ir',
                    'country_id' => 100,
                ),
            1636 =>
                array (
                    'id' => 1665,
                    'name' => 'Vesturland',
                    'country_id' => 100,
                ),
            1637 =>
                array (
                    'id' => 1666,
                    'name' => 'Aceh',
                    'country_id' => 102,
                ),
            1638 =>
                array (
                    'id' => 1667,
                    'name' => 'Bali',
                    'country_id' => 102,
                ),
            1639 =>
                array (
                    'id' => 1668,
                    'name' => 'Bangka-Belitung',
                    'country_id' => 102,
                ),
            1640 =>
                array (
                    'id' => 1669,
                    'name' => 'Banten',
                    'country_id' => 102,
                ),
            1641 =>
                array (
                    'id' => 1670,
                    'name' => 'Bengkulu',
                    'country_id' => 102,
                ),
            1642 =>
                array (
                    'id' => 1671,
                    'name' => 'Gandaria',
                    'country_id' => 102,
                ),
            1643 =>
                array (
                    'id' => 1672,
                    'name' => 'Gorontalo',
                    'country_id' => 102,
                ),
            1644 =>
                array (
                    'id' => 1673,
                    'name' => 'Jakarta',
                    'country_id' => 102,
                ),
            1645 =>
                array (
                    'id' => 1674,
                    'name' => 'Jambi',
                    'country_id' => 102,
                ),
            1646 =>
                array (
                    'id' => 1675,
                    'name' => 'Jawa Barat',
                    'country_id' => 102,
                ),
            1647 =>
                array (
                    'id' => 1676,
                    'name' => 'Jawa Tengah',
                    'country_id' => 102,
                ),
            1648 =>
                array (
                    'id' => 1677,
                    'name' => 'Jawa Timur',
                    'country_id' => 102,
                ),
            1649 =>
                array (
                    'id' => 1678,
                    'name' => 'Kalimantan Barat',
                    'country_id' => 102,
                ),
            1650 =>
                array (
                    'id' => 1679,
                    'name' => 'Kalimantan Selatan',
                    'country_id' => 102,
                ),
            1651 =>
                array (
                    'id' => 1680,
                    'name' => 'Kalimantan Tengah',
                    'country_id' => 102,
                ),
            1652 =>
                array (
                    'id' => 1681,
                    'name' => 'Kalimantan Timur',
                    'country_id' => 102,
                ),
            1653 =>
                array (
                    'id' => 1682,
                    'name' => 'Kendal',
                    'country_id' => 102,
                ),
            1654 =>
                array (
                    'id' => 1683,
                    'name' => 'Lampung',
                    'country_id' => 102,
                ),
            1655 =>
                array (
                    'id' => 1684,
                    'name' => 'Maluku',
                    'country_id' => 102,
                ),
            1656 =>
                array (
                    'id' => 1685,
                    'name' => 'Maluku Utara',
                    'country_id' => 102,
                ),
            1657 =>
                array (
                    'id' => 1686,
                    'name' => 'Nusa Tenggara Barat',
                    'country_id' => 102,
                ),
            1658 =>
                array (
                    'id' => 1687,
                    'name' => 'Nusa Tenggara Timur',
                    'country_id' => 102,
                ),
            1659 =>
                array (
                    'id' => 1688,
                    'name' => 'Papua',
                    'country_id' => 102,
                ),
            1660 =>
                array (
                    'id' => 1689,
                    'name' => 'Riau',
                    'country_id' => 102,
                ),
            1661 =>
                array (
                    'id' => 1690,
                    'name' => 'Riau Kepulauan',
                    'country_id' => 102,
                ),
            1662 =>
                array (
                    'id' => 1691,
                    'name' => 'Solo',
                    'country_id' => 102,
                ),
            1663 =>
                array (
                    'id' => 1692,
                    'name' => 'Sulawesi Selatan',
                    'country_id' => 102,
                ),
            1664 =>
                array (
                    'id' => 1693,
                    'name' => 'Sulawesi Tengah',
                    'country_id' => 102,
                ),
            1665 =>
                array (
                    'id' => 1694,
                    'name' => 'Sulawesi Tenggara',
                    'country_id' => 102,
                ),
            1666 =>
                array (
                    'id' => 1695,
                    'name' => 'Sulawesi Utara',
                    'country_id' => 102,
                ),
            1667 =>
                array (
                    'id' => 1696,
                    'name' => 'Sumatera Barat',
                    'country_id' => 102,
                ),
            1668 =>
                array (
                    'id' => 1697,
                    'name' => 'Sumatera Selatan',
                    'country_id' => 102,
                ),
            1669 =>
                array (
                    'id' => 1698,
                    'name' => 'Sumatera Utara',
                    'country_id' => 102,
                ),
            1670 =>
                array (
                    'id' => 1699,
                    'name' => 'Yogyakarta',
                    'country_id' => 102,
                ),
            1671 =>
                array (
                    'id' => 1700,
                    'name' => 'Ardabil',
                    'country_id' => 103,
                ),
            1672 =>
                array (
                    'id' => 1701,
                    'name' => 'Azarbayjan-e Bakhtari',
                    'country_id' => 103,
                ),
            1673 =>
                array (
                    'id' => 1702,
                    'name' => 'Azarbayjan-e Khavari',
                    'country_id' => 103,
                ),
            1674 =>
                array (
                    'id' => 1703,
                    'name' => 'Bushehr',
                    'country_id' => 103,
                ),
            1675 =>
                array (
                    'id' => 1704,
                    'name' => 'Chahar Mahal-e Bakhtiari',
                    'country_id' => 103,
                ),
            1676 =>
                array (
                    'id' => 1705,
                    'name' => 'Esfahan',
                    'country_id' => 103,
                ),
            1677 =>
                array (
                    'id' => 1706,
                    'name' => 'Fars',
                    'country_id' => 103,
                ),
            1678 =>
                array (
                    'id' => 1707,
                    'name' => 'Gilan',
                    'country_id' => 103,
                ),
            1679 =>
                array (
                    'id' => 1708,
                    'name' => 'Golestan',
                    'country_id' => 103,
                ),
            1680 =>
                array (
                    'id' => 1709,
                    'name' => 'Hamadan',
                    'country_id' => 103,
                ),
            1681 =>
                array (
                    'id' => 1710,
                    'name' => 'Hormozgan',
                    'country_id' => 103,
                ),
            1682 =>
                array (
                    'id' => 1711,
                    'name' => 'Ilam',
                    'country_id' => 103,
                ),
            1683 =>
                array (
                    'id' => 1712,
                    'name' => 'Kerman',
                    'country_id' => 103,
                ),
            1684 =>
                array (
                    'id' => 1713,
                    'name' => 'Kermanshah',
                    'country_id' => 103,
                ),
            1685 =>
                array (
                    'id' => 1714,
                    'name' => 'Khorasan',
                    'country_id' => 103,
                ),
            1686 =>
                array (
                    'id' => 1715,
                    'name' => 'Khuzestan',
                    'country_id' => 103,
                ),
            1687 =>
                array (
                    'id' => 1716,
                    'name' => 'Kohgiluyeh-e Boyerahmad',
                    'country_id' => 103,
                ),
            1688 =>
                array (
                    'id' => 1717,
                    'name' => 'Kordestan',
                    'country_id' => 103,
                ),
            1689 =>
                array (
                    'id' => 1718,
                    'name' => 'Lorestan',
                    'country_id' => 103,
                ),
            1690 =>
                array (
                    'id' => 1719,
                    'name' => 'Markazi',
                    'country_id' => 103,
                ),
            1691 =>
                array (
                    'id' => 1720,
                    'name' => 'Mazandaran',
                    'country_id' => 103,
                ),
            1692 =>
                array (
                    'id' => 1721,
                    'name' => 'Ostan-e Esfahan',
                    'country_id' => 103,
                ),
            1693 =>
                array (
                    'id' => 1722,
                    'name' => 'Qazvin',
                    'country_id' => 103,
                ),
            1694 =>
                array (
                    'id' => 1723,
                    'name' => 'Qom',
                    'country_id' => 103,
                ),
            1695 =>
                array (
                    'id' => 1724,
                    'name' => 'Semnan',
                    'country_id' => 103,
                ),
            1696 =>
                array (
                    'id' => 1725,
                    'name' => 'Sistan-e Baluchestan',
                    'country_id' => 103,
                ),
            1697 =>
                array (
                    'id' => 1726,
                    'name' => 'Tehran',
                    'country_id' => 103,
                ),
            1698 =>
                array (
                    'id' => 1727,
                    'name' => 'Yazd',
                    'country_id' => 103,
                ),
            1699 =>
                array (
                    'id' => 1728,
                    'name' => 'Zanjan',
                    'country_id' => 103,
                ),
            1700 =>
                array (
                    'id' => 1729,
                    'name' => 'Babil',
                    'country_id' => 104,
                ),
            1701 =>
                array (
                    'id' => 1730,
                    'name' => 'Baghdad',
                    'country_id' => 104,
                ),
            1702 =>
                array (
                    'id' => 1731,
                    'name' => 'Dahuk',
                    'country_id' => 104,
                ),
            1703 =>
                array (
                    'id' => 1732,
                    'name' => 'Dhi Qar',
                    'country_id' => 104,
                ),
            1704 =>
                array (
                    'id' => 1733,
                    'name' => 'Diyala',
                    'country_id' => 104,
                ),
            1705 =>
                array (
                    'id' => 1734,
                    'name' => 'Erbil',
                    'country_id' => 104,
                ),
            1706 =>
                array (
                    'id' => 1735,
                    'name' => 'Irbil',
                    'country_id' => 104,
                ),
            1707 =>
                array (
                    'id' => 1736,
                    'name' => 'Karbala',
                    'country_id' => 104,
                ),
            1708 =>
                array (
                    'id' => 1737,
                    'name' => 'Kurdistan',
                    'country_id' => 104,
                ),
            1709 =>
                array (
                    'id' => 1738,
                    'name' => 'Maysan',
                    'country_id' => 104,
                ),
            1710 =>
                array (
                    'id' => 1739,
                    'name' => 'Ninawa',
                    'country_id' => 104,
                ),
            1711 =>
                array (
                    'id' => 1740,
                    'name' => 'Salah-ad-Din',
                    'country_id' => 104,
                ),
            1712 =>
                array (
                    'id' => 1741,
                    'name' => 'Wasit',
                    'country_id' => 104,
                ),
            1713 =>
                array (
                    'id' => 1742,
                    'name' => 'al-Anbar',
                    'country_id' => 104,
                ),
            1714 =>
                array (
                    'id' => 1743,
                    'name' => 'al-Basrah',
                    'country_id' => 104,
                ),
            1715 =>
                array (
                    'id' => 1744,
                    'name' => 'al-Muthanna',
                    'country_id' => 104,
                ),
            1716 =>
                array (
                    'id' => 1745,
                    'name' => 'al-Qadisiyah',
                    'country_id' => 104,
                ),
            1717 =>
                array (
                    'id' => 1746,
                    'name' => 'an-Najaf',
                    'country_id' => 104,
                ),
            1718 =>
                array (
                    'id' => 1747,
                    'name' => 'as-Sulaymaniyah',
                    'country_id' => 104,
                ),
            1719 =>
                array (
                    'id' => 1748,
                    'name' => 'at-Ta\'mim',
                    'country_id' => 104,
                ),
            1720 =>
                array (
                    'id' => 1749,
                    'name' => 'Armagh',
                    'country_id' => 105,
                ),
            1721 =>
                array (
                    'id' => 1750,
                    'name' => 'Carlow',
                    'country_id' => 105,
                ),
            1722 =>
                array (
                    'id' => 1751,
                    'name' => 'Cavan',
                    'country_id' => 105,
                ),
            1723 =>
                array (
                    'id' => 1752,
                    'name' => 'Clare',
                    'country_id' => 105,
                ),
            1724 =>
                array (
                    'id' => 1753,
                    'name' => 'Cork',
                    'country_id' => 105,
                ),
            1725 =>
                array (
                    'id' => 1754,
                    'name' => 'Donegal',
                    'country_id' => 105,
                ),
            1726 =>
                array (
                    'id' => 1755,
                    'name' => 'Dublin',
                    'country_id' => 105,
                ),
            1727 =>
                array (
                    'id' => 1756,
                    'name' => 'Galway',
                    'country_id' => 105,
                ),
            1728 =>
                array (
                    'id' => 1757,
                    'name' => 'Kerry',
                    'country_id' => 105,
                ),
            1729 =>
                array (
                    'id' => 1758,
                    'name' => 'Kildare',
                    'country_id' => 105,
                ),
            1730 =>
                array (
                    'id' => 1759,
                    'name' => 'Kilkenny',
                    'country_id' => 105,
                ),
            1731 =>
                array (
                    'id' => 1760,
                    'name' => 'Laois',
                    'country_id' => 105,
                ),
            1732 =>
                array (
                    'id' => 1761,
                    'name' => 'Leinster',
                    'country_id' => 105,
                ),
            1733 =>
                array (
                    'id' => 1762,
                    'name' => 'Leitrim',
                    'country_id' => 105,
                ),
            1734 =>
                array (
                    'id' => 1763,
                    'name' => 'Limerick',
                    'country_id' => 105,
                ),
            1735 =>
                array (
                    'id' => 1764,
                    'name' => 'Loch Garman',
                    'country_id' => 105,
                ),
            1736 =>
                array (
                    'id' => 1765,
                    'name' => 'Longford',
                    'country_id' => 105,
                ),
            1737 =>
                array (
                    'id' => 1766,
                    'name' => 'Louth',
                    'country_id' => 105,
                ),
            1738 =>
                array (
                    'id' => 1767,
                    'name' => 'Mayo',
                    'country_id' => 105,
                ),
            1739 =>
                array (
                    'id' => 1768,
                    'name' => 'Meath',
                    'country_id' => 105,
                ),
            1740 =>
                array (
                    'id' => 1769,
                    'name' => 'Monaghan',
                    'country_id' => 105,
                ),
            1741 =>
                array (
                    'id' => 1770,
                    'name' => 'Offaly',
                    'country_id' => 105,
                ),
            1742 =>
                array (
                    'id' => 1771,
                    'name' => 'Roscommon',
                    'country_id' => 105,
                ),
            1743 =>
                array (
                    'id' => 1772,
                    'name' => 'Sligo',
                    'country_id' => 105,
                ),
            1744 =>
                array (
                    'id' => 1773,
                    'name' => 'Tipperary North Riding',
                    'country_id' => 105,
                ),
            1745 =>
                array (
                    'id' => 1774,
                    'name' => 'Tipperary South Riding',
                    'country_id' => 105,
                ),
            1746 =>
                array (
                    'id' => 1775,
                    'name' => 'Ulster',
                    'country_id' => 105,
                ),
            1747 =>
                array (
                    'id' => 1776,
                    'name' => 'Waterford',
                    'country_id' => 105,
                ),
            1748 =>
                array (
                    'id' => 1777,
                    'name' => 'Westmeath',
                    'country_id' => 105,
                ),
            1749 =>
                array (
                    'id' => 1778,
                    'name' => 'Wexford',
                    'country_id' => 105,
                ),
            1750 =>
                array (
                    'id' => 1779,
                    'name' => 'Wicklow',
                    'country_id' => 105,
                ),
            1751 =>
                array (
                    'id' => 1780,
                    'name' => 'Beit Hanania',
                    'country_id' => 106,
                ),
            1752 =>
                array (
                    'id' => 1781,
                    'name' => 'Ben Gurion Airport',
                    'country_id' => 106,
                ),
            1753 =>
                array (
                    'id' => 1782,
                    'name' => 'Bethlehem',
                    'country_id' => 106,
                ),
            1754 =>
                array (
                    'id' => 1783,
                    'name' => 'Caesarea',
                    'country_id' => 106,
                ),
            1755 =>
                array (
                    'id' => 1784,
                    'name' => 'Centre',
                    'country_id' => 106,
                ),
            1756 =>
                array (
                    'id' => 1785,
                    'name' => 'Gaza',
                    'country_id' => 106,
                ),
            1757 =>
                array (
                    'id' => 1786,
                    'name' => 'Hadaron',
                    'country_id' => 106,
                ),
            1758 =>
                array (
                    'id' => 1787,
                    'name' => 'Haifa District',
                    'country_id' => 106,
                ),
            1759 =>
                array (
                    'id' => 1788,
                    'name' => 'Hamerkaz',
                    'country_id' => 106,
                ),
            1760 =>
                array (
                    'id' => 1789,
                    'name' => 'Hazafon',
                    'country_id' => 106,
                ),
            1761 =>
                array (
                    'id' => 1790,
                    'name' => 'Hebron',
                    'country_id' => 106,
                ),
            1762 =>
                array (
                    'id' => 1791,
                    'name' => 'Jaffa',
                    'country_id' => 106,
                ),
            1763 =>
                array (
                    'id' => 1792,
                    'name' => 'Jerusalem',
                    'country_id' => 106,
                ),
            1764 =>
                array (
                    'id' => 1793,
                    'name' => 'Khefa',
                    'country_id' => 106,
                ),
            1765 =>
                array (
                    'id' => 1794,
                    'name' => 'Kiryat Yam',
                    'country_id' => 106,
                ),
            1766 =>
                array (
                    'id' => 1795,
                    'name' => 'Lower Galilee',
                    'country_id' => 106,
                ),
            1767 =>
                array (
                    'id' => 1796,
                    'name' => 'Qalqilya',
                    'country_id' => 106,
                ),
            1768 =>
                array (
                    'id' => 1797,
                    'name' => 'Talme Elazar',
                    'country_id' => 106,
                ),
            1769 =>
                array (
                    'id' => 1798,
                    'name' => 'Tel Aviv',
                    'country_id' => 106,
                ),
            1770 =>
                array (
                    'id' => 1799,
                    'name' => 'Tsafon',
                    'country_id' => 106,
                ),
            1771 =>
                array (
                    'id' => 1800,
                    'name' => 'Umm El Fahem',
                    'country_id' => 106,
                ),
            1772 =>
                array (
                    'id' => 1801,
                    'name' => 'Yerushalayim',
                    'country_id' => 106,
                ),
            1773 =>
                array (
                    'id' => 1802,
                    'name' => 'Abruzzi',
                    'country_id' => 107,
                ),
            1774 =>
                array (
                    'id' => 1803,
                    'name' => 'Abruzzo',
                    'country_id' => 107,
                ),
            1775 =>
                array (
                    'id' => 1804,
                    'name' => 'Agrigento',
                    'country_id' => 107,
                ),
            1776 =>
                array (
                    'id' => 1805,
                    'name' => 'Alessandria',
                    'country_id' => 107,
                ),
            1777 =>
                array (
                    'id' => 1806,
                    'name' => 'Ancona',
                    'country_id' => 107,
                ),
            1778 =>
                array (
                    'id' => 1807,
                    'name' => 'Arezzo',
                    'country_id' => 107,
                ),
            1779 =>
                array (
                    'id' => 1808,
                    'name' => 'Ascoli Piceno',
                    'country_id' => 107,
                ),
            1780 =>
                array (
                    'id' => 1809,
                    'name' => 'Asti',
                    'country_id' => 107,
                ),
            1781 =>
                array (
                    'id' => 1810,
                    'name' => 'Avellino',
                    'country_id' => 107,
                ),
            1782 =>
                array (
                    'id' => 1811,
                    'name' => 'Bari',
                    'country_id' => 107,
                ),
            1783 =>
                array (
                    'id' => 1812,
                    'name' => 'Basilicata',
                    'country_id' => 107,
                ),
            1784 =>
                array (
                    'id' => 1813,
                    'name' => 'Belluno',
                    'country_id' => 107,
                ),
            1785 =>
                array (
                    'id' => 1814,
                    'name' => 'Benevento',
                    'country_id' => 107,
                ),
            1786 =>
                array (
                    'id' => 1815,
                    'name' => 'Bergamo',
                    'country_id' => 107,
                ),
            1787 =>
                array (
                    'id' => 1816,
                    'name' => 'Biella',
                    'country_id' => 107,
                ),
            1788 =>
                array (
                    'id' => 1817,
                    'name' => 'Bologna',
                    'country_id' => 107,
                ),
            1789 =>
                array (
                    'id' => 1818,
                    'name' => 'Bolzano',
                    'country_id' => 107,
                ),
            1790 =>
                array (
                    'id' => 1819,
                    'name' => 'Brescia',
                    'country_id' => 107,
                ),
            1791 =>
                array (
                    'id' => 1820,
                    'name' => 'Brindisi',
                    'country_id' => 107,
                ),
            1792 =>
                array (
                    'id' => 1821,
                    'name' => 'Calabria',
                    'country_id' => 107,
                ),
            1793 =>
                array (
                    'id' => 1822,
                    'name' => 'Campania',
                    'country_id' => 107,
                ),
            1794 =>
                array (
                    'id' => 1823,
                    'name' => 'Cartoceto',
                    'country_id' => 107,
                ),
            1795 =>
                array (
                    'id' => 1824,
                    'name' => 'Caserta',
                    'country_id' => 107,
                ),
            1796 =>
                array (
                    'id' => 1825,
                    'name' => 'Catania',
                    'country_id' => 107,
                ),
            1797 =>
                array (
                    'id' => 1826,
                    'name' => 'Chieti',
                    'country_id' => 107,
                ),
            1798 =>
                array (
                    'id' => 1827,
                    'name' => 'Como',
                    'country_id' => 107,
                ),
            1799 =>
                array (
                    'id' => 1828,
                    'name' => 'Cosenza',
                    'country_id' => 107,
                ),
            1800 =>
                array (
                    'id' => 1829,
                    'name' => 'Cremona',
                    'country_id' => 107,
                ),
            1801 =>
                array (
                    'id' => 1830,
                    'name' => 'Cuneo',
                    'country_id' => 107,
                ),
            1802 =>
                array (
                    'id' => 1831,
                    'name' => 'Emilia-Romagna',
                    'country_id' => 107,
                ),
            1803 =>
                array (
                    'id' => 1832,
                    'name' => 'Ferrara',
                    'country_id' => 107,
                ),
            1804 =>
                array (
                    'id' => 1833,
                    'name' => 'Firenze',
                    'country_id' => 107,
                ),
            1805 =>
                array (
                    'id' => 1834,
                    'name' => 'Florence',
                    'country_id' => 107,
                ),
            1806 =>
                array (
                    'id' => 1835,
                    'name' => 'Forli-Cesena ',
                    'country_id' => 107,
                ),
            1807 =>
                array (
                    'id' => 1836,
                    'name' => 'Friuli-Venezia Giulia',
                    'country_id' => 107,
                ),
            1808 =>
                array (
                    'id' => 1837,
                    'name' => 'Frosinone',
                    'country_id' => 107,
                ),
            1809 =>
                array (
                    'id' => 1838,
                    'name' => 'Genoa',
                    'country_id' => 107,
                ),
            1810 =>
                array (
                    'id' => 1839,
                    'name' => 'Gorizia',
                    'country_id' => 107,
                ),
            1811 =>
                array (
                    'id' => 1840,
                    'name' => 'L\'Aquila',
                    'country_id' => 107,
                ),
            1812 =>
                array (
                    'id' => 1841,
                    'name' => 'Lazio',
                    'country_id' => 107,
                ),
            1813 =>
                array (
                    'id' => 1842,
                    'name' => 'Lecce',
                    'country_id' => 107,
                ),
            1814 =>
                array (
                    'id' => 1843,
                    'name' => 'Lecco',
                    'country_id' => 107,
                ),
            1815 =>
                array (
                    'id' => 1844,
                    'name' => 'Lecco Province',
                    'country_id' => 107,
                ),
            1816 =>
                array (
                    'id' => 1845,
                    'name' => 'Liguria',
                    'country_id' => 107,
                ),
            1817 =>
                array (
                    'id' => 1846,
                    'name' => 'Lodi',
                    'country_id' => 107,
                ),
            1818 =>
                array (
                    'id' => 1847,
                    'name' => 'Lombardia',
                    'country_id' => 107,
                ),
            1819 =>
                array (
                    'id' => 1848,
                    'name' => 'Lombardy',
                    'country_id' => 107,
                ),
            1820 =>
                array (
                    'id' => 1849,
                    'name' => 'Macerata',
                    'country_id' => 107,
                ),
            1821 =>
                array (
                    'id' => 1850,
                    'name' => 'Mantova',
                    'country_id' => 107,
                ),
            1822 =>
                array (
                    'id' => 1851,
                    'name' => 'Marche',
                    'country_id' => 107,
                ),
            1823 =>
                array (
                    'id' => 1852,
                    'name' => 'Messina',
                    'country_id' => 107,
                ),
            1824 =>
                array (
                    'id' => 1853,
                    'name' => 'Milan',
                    'country_id' => 107,
                ),
            1825 =>
                array (
                    'id' => 1854,
                    'name' => 'Modena',
                    'country_id' => 107,
                ),
            1826 =>
                array (
                    'id' => 1855,
                    'name' => 'Molise',
                    'country_id' => 107,
                ),
            1827 =>
                array (
                    'id' => 1856,
                    'name' => 'Molteno',
                    'country_id' => 107,
                ),
            1828 =>
                array (
                    'id' => 1857,
                    'name' => 'Montenegro',
                    'country_id' => 107,
                ),
            1829 =>
                array (
                    'id' => 1858,
                    'name' => 'Monza and Brianza',
                    'country_id' => 107,
                ),
            1830 =>
                array (
                    'id' => 1859,
                    'name' => 'Naples',
                    'country_id' => 107,
                ),
            1831 =>
                array (
                    'id' => 1860,
                    'name' => 'Novara',
                    'country_id' => 107,
                ),
            1832 =>
                array (
                    'id' => 1861,
                    'name' => 'Padova',
                    'country_id' => 107,
                ),
            1833 =>
                array (
                    'id' => 1862,
                    'name' => 'Parma',
                    'country_id' => 107,
                ),
            1834 =>
                array (
                    'id' => 1863,
                    'name' => 'Pavia',
                    'country_id' => 107,
                ),
            1835 =>
                array (
                    'id' => 1864,
                    'name' => 'Perugia',
                    'country_id' => 107,
                ),
            1836 =>
                array (
                    'id' => 1865,
                    'name' => 'Pesaro-Urbino',
                    'country_id' => 107,
                ),
            1837 =>
                array (
                    'id' => 1866,
                    'name' => 'Piacenza',
                    'country_id' => 107,
                ),
            1838 =>
                array (
                    'id' => 1867,
                    'name' => 'Piedmont',
                    'country_id' => 107,
                ),
            1839 =>
                array (
                    'id' => 1868,
                    'name' => 'Piemonte',
                    'country_id' => 107,
                ),
            1840 =>
                array (
                    'id' => 1869,
                    'name' => 'Pisa',
                    'country_id' => 107,
                ),
            1841 =>
                array (
                    'id' => 1870,
                    'name' => 'Pordenone',
                    'country_id' => 107,
                ),
            1842 =>
                array (
                    'id' => 1871,
                    'name' => 'Potenza',
                    'country_id' => 107,
                ),
            1843 =>
                array (
                    'id' => 1872,
                    'name' => 'Puglia',
                    'country_id' => 107,
                ),
            1844 =>
                array (
                    'id' => 1873,
                    'name' => 'Reggio Emilia',
                    'country_id' => 107,
                ),
            1845 =>
                array (
                    'id' => 1874,
                    'name' => 'Rimini',
                    'country_id' => 107,
                ),
            1846 =>
                array (
                    'id' => 1875,
                    'name' => 'Roma',
                    'country_id' => 107,
                ),
            1847 =>
                array (
                    'id' => 1876,
                    'name' => 'Salerno',
                    'country_id' => 107,
                ),
            1848 =>
                array (
                    'id' => 1877,
                    'name' => 'Sardegna',
                    'country_id' => 107,
                ),
            1849 =>
                array (
                    'id' => 1878,
                    'name' => 'Sassari',
                    'country_id' => 107,
                ),
            1850 =>
                array (
                    'id' => 1879,
                    'name' => 'Savona',
                    'country_id' => 107,
                ),
            1851 =>
                array (
                    'id' => 1880,
                    'name' => 'Sicilia',
                    'country_id' => 107,
                ),
            1852 =>
                array (
                    'id' => 1881,
                    'name' => 'Siena',
                    'country_id' => 107,
                ),
            1853 =>
                array (
                    'id' => 1882,
                    'name' => 'Sondrio',
                    'country_id' => 107,
                ),
            1854 =>
                array (
                    'id' => 1883,
                    'name' => 'South Tyrol',
                    'country_id' => 107,
                ),
            1855 =>
                array (
                    'id' => 1884,
                    'name' => 'Taranto',
                    'country_id' => 107,
                ),
            1856 =>
                array (
                    'id' => 1885,
                    'name' => 'Teramo',
                    'country_id' => 107,
                ),
            1857 =>
                array (
                    'id' => 1886,
                    'name' => 'Torino',
                    'country_id' => 107,
                ),
            1858 =>
                array (
                    'id' => 1887,
                    'name' => 'Toscana',
                    'country_id' => 107,
                ),
            1859 =>
                array (
                    'id' => 1888,
                    'name' => 'Trapani',
                    'country_id' => 107,
                ),
            1860 =>
                array (
                    'id' => 1889,
                    'name' => 'Trentino-Alto Adige',
                    'country_id' => 107,
                ),
            1861 =>
                array (
                    'id' => 1890,
                    'name' => 'Trento',
                    'country_id' => 107,
                ),
            1862 =>
                array (
                    'id' => 1891,
                    'name' => 'Treviso',
                    'country_id' => 107,
                ),
            1863 =>
                array (
                    'id' => 1892,
                    'name' => 'Udine',
                    'country_id' => 107,
                ),
            1864 =>
                array (
                    'id' => 1893,
                    'name' => 'Umbria',
                    'country_id' => 107,
                ),
            1865 =>
                array (
                    'id' => 1894,
                    'name' => 'Valle d\'Aosta',
                    'country_id' => 107,
                ),
            1866 =>
                array (
                    'id' => 1895,
                    'name' => 'Varese',
                    'country_id' => 107,
                ),
            1867 =>
                array (
                    'id' => 1896,
                    'name' => 'Veneto',
                    'country_id' => 107,
                ),
            1868 =>
                array (
                    'id' => 1897,
                    'name' => 'Venezia',
                    'country_id' => 107,
                ),
            1869 =>
                array (
                    'id' => 1898,
                    'name' => 'Verbano-Cusio-Ossola',
                    'country_id' => 107,
                ),
            1870 =>
                array (
                    'id' => 1899,
                    'name' => 'Vercelli',
                    'country_id' => 107,
                ),
            1871 =>
                array (
                    'id' => 1900,
                    'name' => 'Verona',
                    'country_id' => 107,
                ),
            1872 =>
                array (
                    'id' => 1901,
                    'name' => 'Vicenza',
                    'country_id' => 107,
                ),
            1873 =>
                array (
                    'id' => 1902,
                    'name' => 'Viterbo',
                    'country_id' => 107,
                ),
            1874 =>
                array (
                    'id' => 1903,
                    'name' => 'Buxoro Viloyati',
                    'country_id' => 108,
                ),
            1875 =>
                array (
                    'id' => 1904,
                    'name' => 'Clarendon',
                    'country_id' => 108,
                ),
            1876 =>
                array (
                    'id' => 1905,
                    'name' => 'Hanover',
                    'country_id' => 108,
                ),
            1877 =>
                array (
                    'id' => 1906,
                    'name' => 'Kingston',
                    'country_id' => 108,
                ),
            1878 =>
                array (
                    'id' => 1907,
                    'name' => 'Manchester',
                    'country_id' => 108,
                ),
            1879 =>
                array (
                    'id' => 1908,
                    'name' => 'Portland',
                    'country_id' => 108,
                ),
            1880 =>
                array (
                    'id' => 1909,
                    'name' => 'Saint Andrews',
                    'country_id' => 108,
                ),
            1881 =>
                array (
                    'id' => 1910,
                    'name' => 'Saint Ann',
                    'country_id' => 108,
                ),
            1882 =>
                array (
                    'id' => 1911,
                    'name' => 'Saint Catherine',
                    'country_id' => 108,
                ),
            1883 =>
                array (
                    'id' => 1912,
                    'name' => 'Saint Elizabeth',
                    'country_id' => 108,
                ),
            1884 =>
                array (
                    'id' => 1913,
                    'name' => 'Saint James',
                    'country_id' => 108,
                ),
            1885 =>
                array (
                    'id' => 1914,
                    'name' => 'Saint Mary',
                    'country_id' => 108,
                ),
            1886 =>
                array (
                    'id' => 1915,
                    'name' => 'Saint Thomas',
                    'country_id' => 108,
                ),
            1887 =>
                array (
                    'id' => 1916,
                    'name' => 'Trelawney',
                    'country_id' => 108,
                ),
            1888 =>
                array (
                    'id' => 1917,
                    'name' => 'Westmoreland',
                    'country_id' => 108,
                ),
            1889 =>
                array (
                    'id' => 1918,
                    'name' => 'Aichi',
                    'country_id' => 109,
                ),
            1890 =>
                array (
                    'id' => 1919,
                    'name' => 'Akita',
                    'country_id' => 109,
                ),
            1891 =>
                array (
                    'id' => 1920,
                    'name' => 'Aomori',
                    'country_id' => 109,
                ),
            1892 =>
                array (
                    'id' => 1921,
                    'name' => 'Chiba',
                    'country_id' => 109,
                ),
            1893 =>
                array (
                    'id' => 1922,
                    'name' => 'Ehime',
                    'country_id' => 109,
                ),
            1894 =>
                array (
                    'id' => 1923,
                    'name' => 'Fukui',
                    'country_id' => 109,
                ),
            1895 =>
                array (
                    'id' => 1924,
                    'name' => 'Fukuoka',
                    'country_id' => 109,
                ),
            1896 =>
                array (
                    'id' => 1925,
                    'name' => 'Fukushima',
                    'country_id' => 109,
                ),
            1897 =>
                array (
                    'id' => 1926,
                    'name' => 'Gifu',
                    'country_id' => 109,
                ),
            1898 =>
                array (
                    'id' => 1927,
                    'name' => 'Gumma',
                    'country_id' => 109,
                ),
            1899 =>
                array (
                    'id' => 1928,
                    'name' => 'Hiroshima',
                    'country_id' => 109,
                ),
            1900 =>
                array (
                    'id' => 1929,
                    'name' => 'Hokkaido',
                    'country_id' => 109,
                ),
            1901 =>
                array (
                    'id' => 1930,
                    'name' => 'Hyogo',
                    'country_id' => 109,
                ),
            1902 =>
                array (
                    'id' => 1931,
                    'name' => 'Ibaraki',
                    'country_id' => 109,
                ),
            1903 =>
                array (
                    'id' => 1932,
                    'name' => 'Ishikawa',
                    'country_id' => 109,
                ),
            1904 =>
                array (
                    'id' => 1933,
                    'name' => 'Iwate',
                    'country_id' => 109,
                ),
            1905 =>
                array (
                    'id' => 1934,
                    'name' => 'Kagawa',
                    'country_id' => 109,
                ),
            1906 =>
                array (
                    'id' => 1935,
                    'name' => 'Kagoshima',
                    'country_id' => 109,
                ),
            1907 =>
                array (
                    'id' => 1936,
                    'name' => 'Kanagawa',
                    'country_id' => 109,
                ),
            1908 =>
                array (
                    'id' => 1937,
                    'name' => 'Kanto',
                    'country_id' => 109,
                ),
            1909 =>
                array (
                    'id' => 1938,
                    'name' => 'Kochi',
                    'country_id' => 109,
                ),
            1910 =>
                array (
                    'id' => 1939,
                    'name' => 'Kumamoto',
                    'country_id' => 109,
                ),
            1911 =>
                array (
                    'id' => 1940,
                    'name' => 'Kyoto',
                    'country_id' => 109,
                ),
            1912 =>
                array (
                    'id' => 1941,
                    'name' => 'Mie',
                    'country_id' => 109,
                ),
            1913 =>
                array (
                    'id' => 1942,
                    'name' => 'Miyagi',
                    'country_id' => 109,
                ),
            1914 =>
                array (
                    'id' => 1943,
                    'name' => 'Miyazaki',
                    'country_id' => 109,
                ),
            1915 =>
                array (
                    'id' => 1944,
                    'name' => 'Nagano',
                    'country_id' => 109,
                ),
            1916 =>
                array (
                    'id' => 1945,
                    'name' => 'Nagasaki',
                    'country_id' => 109,
                ),
            1917 =>
                array (
                    'id' => 1946,
                    'name' => 'Nara',
                    'country_id' => 109,
                ),
            1918 =>
                array (
                    'id' => 1947,
                    'name' => 'Niigata',
                    'country_id' => 109,
                ),
            1919 =>
                array (
                    'id' => 1948,
                    'name' => 'Oita',
                    'country_id' => 109,
                ),
            1920 =>
                array (
                    'id' => 1949,
                    'name' => 'Okayama',
                    'country_id' => 109,
                ),
            1921 =>
                array (
                    'id' => 1950,
                    'name' => 'Okinawa',
                    'country_id' => 109,
                ),
            1922 =>
                array (
                    'id' => 1951,
                    'name' => 'Osaka',
                    'country_id' => 109,
                ),
            1923 =>
                array (
                    'id' => 1952,
                    'name' => 'Saga',
                    'country_id' => 109,
                ),
            1924 =>
                array (
                    'id' => 1953,
                    'name' => 'Saitama',
                    'country_id' => 109,
                ),
            1925 =>
                array (
                    'id' => 1954,
                    'name' => 'Shiga',
                    'country_id' => 109,
                ),
            1926 =>
                array (
                    'id' => 1955,
                    'name' => 'Shimane',
                    'country_id' => 109,
                ),
            1927 =>
                array (
                    'id' => 1956,
                    'name' => 'Shizuoka',
                    'country_id' => 109,
                ),
            1928 =>
                array (
                    'id' => 1957,
                    'name' => 'Tochigi',
                    'country_id' => 109,
                ),
            1929 =>
                array (
                    'id' => 1958,
                    'name' => 'Tokushima',
                    'country_id' => 109,
                ),
            1930 =>
                array (
                    'id' => 1959,
                    'name' => 'Tokyo',
                    'country_id' => 109,
                ),
            1931 =>
                array (
                    'id' => 1960,
                    'name' => 'Tottori',
                    'country_id' => 109,
                ),
            1932 =>
                array (
                    'id' => 1961,
                    'name' => 'Toyama',
                    'country_id' => 109,
                ),
            1933 =>
                array (
                    'id' => 1962,
                    'name' => 'Wakayama',
                    'country_id' => 109,
                ),
            1934 =>
                array (
                    'id' => 1963,
                    'name' => 'Yamagata',
                    'country_id' => 109,
                ),
            1935 =>
                array (
                    'id' => 1964,
                    'name' => 'Yamaguchi',
                    'country_id' => 109,
                ),
            1936 =>
                array (
                    'id' => 1965,
                    'name' => 'Yamanashi',
                    'country_id' => 109,
                ),
            1937 =>
                array (
                    'id' => 1977,
                    'name' => '\'Ajlun',
                    'country_id' => 111,
                ),
            1938 =>
                array (
                    'id' => 1978,
                    'name' => 'Amman',
                    'country_id' => 111,
                ),
            1939 =>
                array (
                    'id' => 1979,
                    'name' => 'Irbid',
                    'country_id' => 111,
                ),
            1940 =>
                array (
                    'id' => 1980,
                    'name' => 'Jarash',
                    'country_id' => 111,
                ),
            1941 =>
                array (
                    'id' => 1981,
                    'name' => 'Ma\'an',
                    'country_id' => 111,
                ),
            1942 =>
                array (
                    'id' => 1982,
                    'name' => 'Madaba',
                    'country_id' => 111,
                ),
            1943 =>
                array (
                    'id' => 1983,
                    'name' => 'al-\'Aqabah',
                    'country_id' => 111,
                ),
            1944 =>
                array (
                    'id' => 1984,
                    'name' => 'al-Balqa\'',
                    'country_id' => 111,
                ),
            1945 =>
                array (
                    'id' => 1985,
                    'name' => 'al-Karak',
                    'country_id' => 111,
                ),
            1946 =>
                array (
                    'id' => 1986,
                    'name' => 'al-Mafraq',
                    'country_id' => 111,
                ),
            1947 =>
                array (
                    'id' => 1987,
                    'name' => 'at-Tafilah',
                    'country_id' => 111,
                ),
            1948 =>
                array (
                    'id' => 1988,
                    'name' => 'az-Zarqa\'',
                    'country_id' => 111,
                ),
            1949 =>
                array (
                    'id' => 1989,
                    'name' => 'Akmecet',
                    'country_id' => 112,
                ),
            1950 =>
                array (
                    'id' => 1990,
                    'name' => 'Akmola',
                    'country_id' => 112,
                ),
            1951 =>
                array (
                    'id' => 1991,
                    'name' => 'Aktobe',
                    'country_id' => 112,
                ),
            1952 =>
                array (
                    'id' => 1992,
                    'name' => 'Almati',
                    'country_id' => 112,
                ),
            1953 =>
                array (
                    'id' => 1993,
                    'name' => 'Atirau',
                    'country_id' => 112,
                ),
            1954 =>
                array (
                    'id' => 1994,
                    'name' => 'Batis Kazakstan',
                    'country_id' => 112,
                ),
            1955 =>
                array (
                    'id' => 1995,
                    'name' => 'Burlinsky Region',
                    'country_id' => 112,
                ),
            1956 =>
                array (
                    'id' => 1996,
                    'name' => 'Karagandi',
                    'country_id' => 112,
                ),
            1957 =>
                array (
                    'id' => 1997,
                    'name' => 'Kostanay',
                    'country_id' => 112,
                ),
            1958 =>
                array (
                    'id' => 1998,
                    'name' => 'Mankistau',
                    'country_id' => 112,
                ),
            1959 =>
                array (
                    'id' => 1999,
                    'name' => 'Ontustik Kazakstan',
                    'country_id' => 112,
                ),
            1960 =>
                array (
                    'id' => 2000,
                    'name' => 'Pavlodar',
                    'country_id' => 112,
                ),
            1961 =>
                array (
                    'id' => 2001,
                    'name' => 'Sigis Kazakstan',
                    'country_id' => 112,
                ),
            1962 =>
                array (
                    'id' => 2002,
                    'name' => 'Soltustik Kazakstan',
                    'country_id' => 112,
                ),
            1963 =>
                array (
                    'id' => 2003,
                    'name' => 'Taraz',
                    'country_id' => 112,
                ),
            1964 =>
                array (
                    'id' => 2004,
                    'name' => 'Central',
                    'country_id' => 113,
                ),
            1965 =>
                array (
                    'id' => 2005,
                    'name' => 'Coast',
                    'country_id' => 113,
                ),
            1966 =>
                array (
                    'id' => 2006,
                    'name' => 'Eastern',
                    'country_id' => 113,
                ),
            1967 =>
                array (
                    'id' => 2007,
                    'name' => 'Nairobi',
                    'country_id' => 113,
                ),
            1968 =>
                array (
                    'id' => 2008,
                    'name' => 'North Eastern',
                    'country_id' => 113,
                ),
            1969 =>
                array (
                    'id' => 2009,
                    'name' => 'Nyanza',
                    'country_id' => 113,
                ),
            1970 =>
                array (
                    'id' => 2010,
                    'name' => 'Rift Valley',
                    'country_id' => 113,
                ),
            1971 =>
                array (
                    'id' => 2011,
                    'name' => 'Western',
                    'country_id' => 113,
                ),
            1972 =>
                array (
                    'id' => 2012,
                    'name' => 'Abaiang',
                    'country_id' => 114,
                ),
            1973 =>
                array (
                    'id' => 2013,
                    'name' => 'Abemana',
                    'country_id' => 114,
                ),
            1974 =>
                array (
                    'id' => 2014,
                    'name' => 'Aranuka',
                    'country_id' => 114,
                ),
            1975 =>
                array (
                    'id' => 2015,
                    'name' => 'Arorae',
                    'country_id' => 114,
                ),
            1976 =>
                array (
                    'id' => 2016,
                    'name' => 'Banaba',
                    'country_id' => 114,
                ),
            1977 =>
                array (
                    'id' => 2017,
                    'name' => 'Beru',
                    'country_id' => 114,
                ),
            1978 =>
                array (
                    'id' => 2018,
                    'name' => 'Butaritari',
                    'country_id' => 114,
                ),
            1979 =>
                array (
                    'id' => 2019,
                    'name' => 'Kiritimati',
                    'country_id' => 114,
                ),
            1980 =>
                array (
                    'id' => 2020,
                    'name' => 'Kuria',
                    'country_id' => 114,
                ),
            1981 =>
                array (
                    'id' => 2021,
                    'name' => 'Maiana',
                    'country_id' => 114,
                ),
            1982 =>
                array (
                    'id' => 2022,
                    'name' => 'Makin',
                    'country_id' => 114,
                ),
            1983 =>
                array (
                    'id' => 2023,
                    'name' => 'Marakei',
                    'country_id' => 114,
                ),
            1984 =>
                array (
                    'id' => 2024,
                    'name' => 'Nikunau',
                    'country_id' => 114,
                ),
            1985 =>
                array (
                    'id' => 2025,
                    'name' => 'Nonouti',
                    'country_id' => 114,
                ),
            1986 =>
                array (
                    'id' => 2026,
                    'name' => 'Onotoa',
                    'country_id' => 114,
                ),
            1987 =>
                array (
                    'id' => 2027,
                    'name' => 'Phoenix Islands',
                    'country_id' => 114,
                ),
            1988 =>
                array (
                    'id' => 2028,
                    'name' => 'Tabiteuea North',
                    'country_id' => 114,
                ),
            1989 =>
                array (
                    'id' => 2029,
                    'name' => 'Tabiteuea South',
                    'country_id' => 114,
                ),
            1990 =>
                array (
                    'id' => 2030,
                    'name' => 'Tabuaeran',
                    'country_id' => 114,
                ),
            1991 =>
                array (
                    'id' => 2031,
                    'name' => 'Tamana',
                    'country_id' => 114,
                ),
            1992 =>
                array (
                    'id' => 2032,
                    'name' => 'Tarawa North',
                    'country_id' => 114,
                ),
            1993 =>
                array (
                    'id' => 2033,
                    'name' => 'Tarawa South',
                    'country_id' => 114,
                ),
            1994 =>
                array (
                    'id' => 2034,
                    'name' => 'Teraina',
                    'country_id' => 114,
                ),
            1995 =>
                array (
                    'id' => 2035,
                    'name' => 'Chagangdo',
                    'country_id' => 115,
                ),
            1996 =>
                array (
                    'id' => 2036,
                    'name' => 'Hamgyeongbukto',
                    'country_id' => 115,
                ),
            1997 =>
                array (
                    'id' => 2037,
                    'name' => 'Hamgyeongnamdo',
                    'country_id' => 115,
                ),
            1998 =>
                array (
                    'id' => 2038,
                    'name' => 'Hwanghaebukto',
                    'country_id' => 115,
                ),
            1999 =>
                array (
                    'id' => 2039,
                    'name' => 'Hwanghaenamdo',
                    'country_id' => 115,
                ),
            2000 =>
                array (
                    'id' => 2040,
                    'name' => 'Kaeseong',
                    'country_id' => 115,
                ),
            2001 =>
                array (
                    'id' => 2041,
                    'name' => 'Kangweon',
                    'country_id' => 115,
                ),
            2002 =>
                array (
                    'id' => 2042,
                    'name' => 'Nampo',
                    'country_id' => 115,
                ),
            2003 =>
                array (
                    'id' => 2043,
                    'name' => 'Pyeonganbukto',
                    'country_id' => 115,
                ),
            2004 =>
                array (
                    'id' => 2044,
                    'name' => 'Pyeongannamdo',
                    'country_id' => 115,
                ),
            2005 =>
                array (
                    'id' => 2045,
                    'name' => 'Pyeongyang',
                    'country_id' => 115,
                ),
            2006 =>
                array (
                    'id' => 2046,
                    'name' => 'Yanggang',
                    'country_id' => 115,
                ),
            2007 =>
                array (
                    'id' => 2047,
                    'name' => 'Busan',
                    'country_id' => 116,
                ),
            2008 =>
                array (
                    'id' => 2048,
                    'name' => 'Cheju',
                    'country_id' => 116,
                ),
            2009 =>
                array (
                    'id' => 2049,
                    'name' => 'Chollabuk',
                    'country_id' => 116,
                ),
            2010 =>
                array (
                    'id' => 2050,
                    'name' => 'Chollanam',
                    'country_id' => 116,
                ),
            2011 =>
                array (
                    'id' => 2051,
                    'name' => 'Chungbuk',
                    'country_id' => 116,
                ),
            2012 =>
                array (
                    'id' => 2052,
                    'name' => 'Chungcheongbuk',
                    'country_id' => 116,
                ),
            2013 =>
                array (
                    'id' => 2053,
                    'name' => 'Chungcheongnam',
                    'country_id' => 116,
                ),
            2014 =>
                array (
                    'id' => 2054,
                    'name' => 'Chungnam',
                    'country_id' => 116,
                ),
            2015 =>
                array (
                    'id' => 2055,
                    'name' => 'Daegu',
                    'country_id' => 116,
                ),
            2016 =>
                array (
                    'id' => 2056,
                    'name' => 'Gangwon-do',
                    'country_id' => 116,
                ),
            2017 =>
                array (
                    'id' => 2057,
                    'name' => 'Goyang-si',
                    'country_id' => 116,
                ),
            2018 =>
                array (
                    'id' => 2058,
                    'name' => 'Gyeonggi-do',
                    'country_id' => 116,
                ),
            2019 =>
                array (
                    'id' => 2059,
                    'name' => 'Gyeongsang ',
                    'country_id' => 116,
                ),
            2020 =>
                array (
                    'id' => 2060,
                    'name' => 'Gyeongsangnam-do',
                    'country_id' => 116,
                ),
            2021 =>
                array (
                    'id' => 2061,
                    'name' => 'Incheon',
                    'country_id' => 116,
                ),
            2022 =>
                array (
                    'id' => 2062,
                    'name' => 'Jeju-Si',
                    'country_id' => 116,
                ),
            2023 =>
                array (
                    'id' => 2063,
                    'name' => 'Jeonbuk',
                    'country_id' => 116,
                ),
            2024 =>
                array (
                    'id' => 2064,
                    'name' => 'Kangweon',
                    'country_id' => 116,
                ),
            2025 =>
                array (
                    'id' => 2065,
                    'name' => 'Kwangju',
                    'country_id' => 116,
                ),
            2026 =>
                array (
                    'id' => 2066,
                    'name' => 'Kyeonggi',
                    'country_id' => 116,
                ),
            2027 =>
                array (
                    'id' => 2067,
                    'name' => 'Kyeongsangbuk',
                    'country_id' => 116,
                ),
            2028 =>
                array (
                    'id' => 2068,
                    'name' => 'Kyeongsangnam',
                    'country_id' => 116,
                ),
            2029 =>
                array (
                    'id' => 2069,
                    'name' => 'Kyonggi-do',
                    'country_id' => 116,
                ),
            2030 =>
                array (
                    'id' => 2070,
                    'name' => 'Kyungbuk-Do',
                    'country_id' => 116,
                ),
            2031 =>
                array (
                    'id' => 2071,
                    'name' => 'Kyunggi-Do',
                    'country_id' => 116,
                ),
            2032 =>
                array (
                    'id' => 2072,
                    'name' => 'Kyunggi-do',
                    'country_id' => 116,
                ),
            2033 =>
                array (
                    'id' => 2073,
                    'name' => 'Pusan',
                    'country_id' => 116,
                ),
            2034 =>
                array (
                    'id' => 2074,
                    'name' => 'Seoul',
                    'country_id' => 116,
                ),
            2035 =>
                array (
                    'id' => 2075,
                    'name' => 'Sudogwon',
                    'country_id' => 116,
                ),
            2036 =>
                array (
                    'id' => 2076,
                    'name' => 'Taegu',
                    'country_id' => 116,
                ),
            2037 =>
                array (
                    'id' => 2077,
                    'name' => 'Taejeon',
                    'country_id' => 116,
                ),
            2038 =>
                array (
                    'id' => 2078,
                    'name' => 'Taejon-gwangyoksi',
                    'country_id' => 116,
                ),
            2039 =>
                array (
                    'id' => 2079,
                    'name' => 'Ulsan',
                    'country_id' => 116,
                ),
            2040 =>
                array (
                    'id' => 2080,
                    'name' => 'Wonju',
                    'country_id' => 116,
                ),
            2041 =>
                array (
                    'id' => 2081,
                    'name' => 'gwangyoksi',
                    'country_id' => 116,
                ),
            2042 =>
                array (
                    'id' => 2082,
                    'name' => 'Al Asimah',
                    'country_id' => 117,
                ),
            2043 =>
                array (
                    'id' => 2083,
                    'name' => 'Hawalli',
                    'country_id' => 117,
                ),
            2044 =>
                array (
                    'id' => 2084,
                    'name' => 'Mishref',
                    'country_id' => 117,
                ),
            2045 =>
                array (
                    'id' => 2085,
                    'name' => 'Qadesiya',
                    'country_id' => 117,
                ),
            2046 =>
                array (
                    'id' => 2086,
                    'name' => 'Safat',
                    'country_id' => 117,
                ),
            2047 =>
                array (
                    'id' => 2087,
                    'name' => 'Salmiya',
                    'country_id' => 117,
                ),
            2048 =>
                array (
                    'id' => 2088,
                    'name' => 'al-Ahmadi',
                    'country_id' => 117,
                ),
            2049 =>
                array (
                    'id' => 2089,
                    'name' => 'al-Farwaniyah',
                    'country_id' => 117,
                ),
            2050 =>
                array (
                    'id' => 2090,
                    'name' => 'al-Jahra',
                    'country_id' => 117,
                ),
            2051 =>
                array (
                    'id' => 2091,
                    'name' => 'al-Kuwayt',
                    'country_id' => 117,
                ),
            2052 =>
                array (
                    'id' => 2092,
                    'name' => 'Batken',
                    'country_id' => 118,
                ),
            2053 =>
                array (
                    'id' => 2093,
                    'name' => 'Bishkek',
                    'country_id' => 118,
                ),
            2054 =>
                array (
                    'id' => 2094,
                    'name' => 'Chui',
                    'country_id' => 118,
                ),
            2055 =>
                array (
                    'id' => 2095,
                    'name' => 'Issyk-Kul',
                    'country_id' => 118,
                ),
            2056 =>
                array (
                    'id' => 2096,
                    'name' => 'Jalal-Abad',
                    'country_id' => 118,
                ),
            2057 =>
                array (
                    'id' => 2097,
                    'name' => 'Naryn',
                    'country_id' => 118,
                ),
            2058 =>
                array (
                    'id' => 2098,
                    'name' => 'Osh',
                    'country_id' => 118,
                ),
            2059 =>
                array (
                    'id' => 2099,
                    'name' => 'Talas',
                    'country_id' => 118,
                ),
            2060 =>
                array (
                    'id' => 2100,
                    'name' => 'Attopu',
                    'country_id' => 119,
                ),
            2061 =>
                array (
                    'id' => 2101,
                    'name' => 'Bokeo',
                    'country_id' => 119,
                ),
            2062 =>
                array (
                    'id' => 2102,
                    'name' => 'Bolikhamsay',
                    'country_id' => 119,
                ),
            2063 =>
                array (
                    'id' => 2103,
                    'name' => 'Champasak',
                    'country_id' => 119,
                ),
            2064 =>
                array (
                    'id' => 2104,
                    'name' => 'Houaphanh',
                    'country_id' => 119,
                ),
            2065 =>
                array (
                    'id' => 2105,
                    'name' => 'Khammouane',
                    'country_id' => 119,
                ),
            2066 =>
                array (
                    'id' => 2106,
                    'name' => 'Luang Nam Tha',
                    'country_id' => 119,
                ),
            2067 =>
                array (
                    'id' => 2107,
                    'name' => 'Luang Prabang',
                    'country_id' => 119,
                ),
            2068 =>
                array (
                    'id' => 2108,
                    'name' => 'Oudomxay',
                    'country_id' => 119,
                ),
            2069 =>
                array (
                    'id' => 2109,
                    'name' => 'Phongsaly',
                    'country_id' => 119,
                ),
            2070 =>
                array (
                    'id' => 2110,
                    'name' => 'Saravan',
                    'country_id' => 119,
                ),
            2071 =>
                array (
                    'id' => 2111,
                    'name' => 'Savannakhet',
                    'country_id' => 119,
                ),
            2072 =>
                array (
                    'id' => 2112,
                    'name' => 'Sekong',
                    'country_id' => 119,
                ),
            2073 =>
                array (
                    'id' => 2113,
                    'name' => 'Viangchan Prefecture',
                    'country_id' => 119,
                ),
            2074 =>
                array (
                    'id' => 2114,
                    'name' => 'Viangchan Province',
                    'country_id' => 119,
                ),
            2075 =>
                array (
                    'id' => 2115,
                    'name' => 'Xaignabury',
                    'country_id' => 119,
                ),
            2076 =>
                array (
                    'id' => 2116,
                    'name' => 'Xiang Khuang',
                    'country_id' => 119,
                ),
            2077 =>
                array (
                    'id' => 2117,
                    'name' => 'Aizkraukles',
                    'country_id' => 120,
                ),
            2078 =>
                array (
                    'id' => 2118,
                    'name' => 'Aluksnes',
                    'country_id' => 120,
                ),
            2079 =>
                array (
                    'id' => 2119,
                    'name' => 'Balvu',
                    'country_id' => 120,
                ),
            2080 =>
                array (
                    'id' => 2120,
                    'name' => 'Bauskas',
                    'country_id' => 120,
                ),
            2081 =>
                array (
                    'id' => 2121,
                    'name' => 'Cesu',
                    'country_id' => 120,
                ),
            2082 =>
                array (
                    'id' => 2122,
                    'name' => 'Daugavpils',
                    'country_id' => 120,
                ),
            2083 =>
                array (
                    'id' => 2123,
                    'name' => 'Daugavpils City',
                    'country_id' => 120,
                ),
            2084 =>
                array (
                    'id' => 2124,
                    'name' => 'Dobeles',
                    'country_id' => 120,
                ),
            2085 =>
                array (
                    'id' => 2125,
                    'name' => 'Gulbenes',
                    'country_id' => 120,
                ),
            2086 =>
                array (
                    'id' => 2126,
                    'name' => 'Jekabspils',
                    'country_id' => 120,
                ),
            2087 =>
                array (
                    'id' => 2127,
                    'name' => 'Jelgava',
                    'country_id' => 120,
                ),
            2088 =>
                array (
                    'id' => 2128,
                    'name' => 'Jelgavas',
                    'country_id' => 120,
                ),
            2089 =>
                array (
                    'id' => 2129,
                    'name' => 'Jurmala City',
                    'country_id' => 120,
                ),
            2090 =>
                array (
                    'id' => 2130,
                    'name' => 'Kraslavas',
                    'country_id' => 120,
                ),
            2091 =>
                array (
                    'id' => 2131,
                    'name' => 'Kuldigas',
                    'country_id' => 120,
                ),
            2092 =>
                array (
                    'id' => 2132,
                    'name' => 'Liepaja',
                    'country_id' => 120,
                ),
            2093 =>
                array (
                    'id' => 2133,
                    'name' => 'Liepajas',
                    'country_id' => 120,
                ),
            2094 =>
                array (
                    'id' => 2134,
                    'name' => 'Limbazhu',
                    'country_id' => 120,
                ),
            2095 =>
                array (
                    'id' => 2135,
                    'name' => 'Ludzas',
                    'country_id' => 120,
                ),
            2096 =>
                array (
                    'id' => 2136,
                    'name' => 'Madonas',
                    'country_id' => 120,
                ),
            2097 =>
                array (
                    'id' => 2137,
                    'name' => 'Ogres',
                    'country_id' => 120,
                ),
            2098 =>
                array (
                    'id' => 2138,
                    'name' => 'Preilu',
                    'country_id' => 120,
                ),
            2099 =>
                array (
                    'id' => 2139,
                    'name' => 'Rezekne',
                    'country_id' => 120,
                ),
            2100 =>
                array (
                    'id' => 2140,
                    'name' => 'Rezeknes',
                    'country_id' => 120,
                ),
            2101 =>
                array (
                    'id' => 2141,
                    'name' => 'Riga',
                    'country_id' => 120,
                ),
            2102 =>
                array (
                    'id' => 2142,
                    'name' => 'Rigas',
                    'country_id' => 120,
                ),
            2103 =>
                array (
                    'id' => 2143,
                    'name' => 'Saldus',
                    'country_id' => 120,
                ),
            2104 =>
                array (
                    'id' => 2144,
                    'name' => 'Talsu',
                    'country_id' => 120,
                ),
            2105 =>
                array (
                    'id' => 2145,
                    'name' => 'Tukuma',
                    'country_id' => 120,
                ),
            2106 =>
                array (
                    'id' => 2146,
                    'name' => 'Valkas',
                    'country_id' => 120,
                ),
            2107 =>
                array (
                    'id' => 2147,
                    'name' => 'Valmieras',
                    'country_id' => 120,
                ),
            2108 =>
                array (
                    'id' => 2148,
                    'name' => 'Ventspils',
                    'country_id' => 120,
                ),
            2109 =>
                array (
                    'id' => 2149,
                    'name' => 'Ventspils City',
                    'country_id' => 120,
                ),
            2110 =>
                array (
                    'id' => 2150,
                    'name' => 'Beirut',
                    'country_id' => 121,
                ),
            2111 =>
                array (
                    'id' => 2151,
                    'name' => 'Jabal Lubnan',
                    'country_id' => 121,
                ),
            2112 =>
                array (
                    'id' => 2152,
                    'name' => 'Mohafazat Liban-Nord',
                    'country_id' => 121,
                ),
            2113 =>
                array (
                    'id' => 2153,
                    'name' => 'Mohafazat Mont-Liban',
                    'country_id' => 121,
                ),
            2114 =>
                array (
                    'id' => 2154,
                    'name' => 'Sidon',
                    'country_id' => 121,
                ),
            2115 =>
                array (
                    'id' => 2155,
                    'name' => 'al-Biqa',
                    'country_id' => 121,
                ),
            2116 =>
                array (
                    'id' => 2156,
                    'name' => 'al-Janub',
                    'country_id' => 121,
                ),
            2117 =>
                array (
                    'id' => 2157,
                    'name' => 'an-Nabatiyah',
                    'country_id' => 121,
                ),
            2118 =>
                array (
                    'id' => 2158,
                    'name' => 'ash-Shamal',
                    'country_id' => 121,
                ),
            2119 =>
                array (
                    'id' => 2159,
                    'name' => 'Berea',
                    'country_id' => 122,
                ),
            2120 =>
                array (
                    'id' => 2160,
                    'name' => 'Butha-Buthe',
                    'country_id' => 122,
                ),
            2121 =>
                array (
                    'id' => 2161,
                    'name' => 'Leribe',
                    'country_id' => 122,
                ),
            2122 =>
                array (
                    'id' => 2162,
                    'name' => 'Mafeteng',
                    'country_id' => 122,
                ),
            2123 =>
                array (
                    'id' => 2163,
                    'name' => 'Maseru',
                    'country_id' => 122,
                ),
            2124 =>
                array (
                    'id' => 2164,
                    'name' => 'Mohale\'s Hoek',
                    'country_id' => 122,
                ),
            2125 =>
                array (
                    'id' => 2165,
                    'name' => 'Mokhotlong',
                    'country_id' => 122,
                ),
            2126 =>
                array (
                    'id' => 2166,
                    'name' => 'Qacha\'s Nek',
                    'country_id' => 122,
                ),
            2127 =>
                array (
                    'id' => 2167,
                    'name' => 'Quthing',
                    'country_id' => 122,
                ),
            2128 =>
                array (
                    'id' => 2168,
                    'name' => 'Thaba-Tseka',
                    'country_id' => 122,
                ),
            2129 =>
                array (
                    'id' => 2169,
                    'name' => 'Bomi',
                    'country_id' => 123,
                ),
            2130 =>
                array (
                    'id' => 2170,
                    'name' => 'Bong',
                    'country_id' => 123,
                ),
            2131 =>
                array (
                    'id' => 2171,
                    'name' => 'Grand Bassa',
                    'country_id' => 123,
                ),
            2132 =>
                array (
                    'id' => 2172,
                    'name' => 'Grand Cape Mount',
                    'country_id' => 123,
                ),
            2133 =>
                array (
                    'id' => 2173,
                    'name' => 'Grand Gedeh',
                    'country_id' => 123,
                ),
            2134 =>
                array (
                    'id' => 2174,
                    'name' => 'Loffa',
                    'country_id' => 123,
                ),
            2135 =>
                array (
                    'id' => 2175,
                    'name' => 'Margibi',
                    'country_id' => 123,
                ),
            2136 =>
                array (
                    'id' => 2176,
                    'name' => 'Maryland and Grand Kru',
                    'country_id' => 123,
                ),
            2137 =>
                array (
                    'id' => 2177,
                    'name' => 'Montserrado',
                    'country_id' => 123,
                ),
            2138 =>
                array (
                    'id' => 2178,
                    'name' => 'Nimba',
                    'country_id' => 123,
                ),
            2139 =>
                array (
                    'id' => 2179,
                    'name' => 'Rivercess',
                    'country_id' => 123,
                ),
            2140 =>
                array (
                    'id' => 2180,
                    'name' => 'Sinoe',
                    'country_id' => 123,
                ),
            2141 =>
                array (
                    'id' => 2181,
                    'name' => 'Ajdabiya',
                    'country_id' => 124,
                ),
            2142 =>
                array (
                    'id' => 2182,
                    'name' => 'Fezzan',
                    'country_id' => 124,
                ),
            2143 =>
                array (
                    'id' => 2183,
                    'name' => 'Banghazi',
                    'country_id' => 124,
                ),
            2144 =>
                array (
                    'id' => 2184,
                    'name' => 'Darnah',
                    'country_id' => 124,
                ),
            2145 =>
                array (
                    'id' => 2185,
                    'name' => 'Ghadamis',
                    'country_id' => 124,
                ),
            2146 =>
                array (
                    'id' => 2186,
                    'name' => 'Gharyan',
                    'country_id' => 124,
                ),
            2147 =>
                array (
                    'id' => 2187,
                    'name' => 'Misratah',
                    'country_id' => 124,
                ),
            2148 =>
                array (
                    'id' => 2188,
                    'name' => 'Murzuq',
                    'country_id' => 124,
                ),
            2149 =>
                array (
                    'id' => 2189,
                    'name' => 'Sabha',
                    'country_id' => 124,
                ),
            2150 =>
                array (
                    'id' => 2190,
                    'name' => 'Sawfajjin',
                    'country_id' => 124,
                ),
            2151 =>
                array (
                    'id' => 2191,
                    'name' => 'Surt',
                    'country_id' => 124,
                ),
            2152 =>
                array (
                    'id' => 2192,
                    'name' => 'Tarabulus',
                    'country_id' => 124,
                ),
            2153 =>
                array (
                    'id' => 2193,
                    'name' => 'Tarhunah',
                    'country_id' => 124,
                ),
            2154 =>
                array (
                    'id' => 2194,
                    'name' => 'Tripolitania',
                    'country_id' => 124,
                ),
            2155 =>
                array (
                    'id' => 2195,
                    'name' => 'Tubruq',
                    'country_id' => 124,
                ),
            2156 =>
                array (
                    'id' => 2196,
                    'name' => 'Yafran',
                    'country_id' => 124,
                ),
            2157 =>
                array (
                    'id' => 2197,
                    'name' => 'Zlitan',
                    'country_id' => 124,
                ),
            2158 =>
                array (
                    'id' => 2198,
                    'name' => 'al-\'Aziziyah',
                    'country_id' => 124,
                ),
            2159 =>
                array (
                    'id' => 2199,
                    'name' => 'al-Fatih',
                    'country_id' => 124,
                ),
            2160 =>
                array (
                    'id' => 2200,
                    'name' => 'al-Jabal al Akhdar',
                    'country_id' => 124,
                ),
            2161 =>
                array (
                    'id' => 2201,
                    'name' => 'al-Jufrah',
                    'country_id' => 124,
                ),
            2162 =>
                array (
                    'id' => 2202,
                    'name' => 'al-Khums',
                    'country_id' => 124,
                ),
            2163 =>
                array (
                    'id' => 2203,
                    'name' => 'al-Kufrah',
                    'country_id' => 124,
                ),
            2164 =>
                array (
                    'id' => 2204,
                    'name' => 'an-Nuqat al-Khams',
                    'country_id' => 124,
                ),
            2165 =>
                array (
                    'id' => 2205,
                    'name' => 'ash-Shati\'',
                    'country_id' => 124,
                ),
            2166 =>
                array (
                    'id' => 2206,
                    'name' => 'az-Zawiyah',
                    'country_id' => 124,
                ),
            2167 =>
                array (
                    'id' => 2207,
                    'name' => 'Balzers',
                    'country_id' => 125,
                ),
            2168 =>
                array (
                    'id' => 2208,
                    'name' => 'Eschen',
                    'country_id' => 125,
                ),
            2169 =>
                array (
                    'id' => 2209,
                    'name' => 'Gamprin',
                    'country_id' => 125,
                ),
            2170 =>
                array (
                    'id' => 2210,
                    'name' => 'Mauren',
                    'country_id' => 125,
                ),
            2171 =>
                array (
                    'id' => 2211,
                    'name' => 'Planken',
                    'country_id' => 125,
                ),
            2172 =>
                array (
                    'id' => 2212,
                    'name' => 'Ruggell',
                    'country_id' => 125,
                ),
            2173 =>
                array (
                    'id' => 2213,
                    'name' => 'Schaan',
                    'country_id' => 125,
                ),
            2174 =>
                array (
                    'id' => 2214,
                    'name' => 'Schellenberg',
                    'country_id' => 125,
                ),
            2175 =>
                array (
                    'id' => 2215,
                    'name' => 'Triesen',
                    'country_id' => 125,
                ),
            2176 =>
                array (
                    'id' => 2216,
                    'name' => 'Triesenberg',
                    'country_id' => 125,
                ),
            2177 =>
                array (
                    'id' => 2217,
                    'name' => 'Vaduz',
                    'country_id' => 125,
                ),
            2178 =>
                array (
                    'id' => 2218,
                    'name' => 'Alytaus',
                    'country_id' => 126,
                ),
            2179 =>
                array (
                    'id' => 2219,
                    'name' => 'Anyksciai',
                    'country_id' => 126,
                ),
            2180 =>
                array (
                    'id' => 2220,
                    'name' => 'Kauno',
                    'country_id' => 126,
                ),
            2181 =>
                array (
                    'id' => 2221,
                    'name' => 'Klaipedos',
                    'country_id' => 126,
                ),
            2182 =>
                array (
                    'id' => 2222,
                    'name' => 'Marijampoles',
                    'country_id' => 126,
                ),
            2183 =>
                array (
                    'id' => 2223,
                    'name' => 'Panevezhio',
                    'country_id' => 126,
                ),
            2184 =>
                array (
                    'id' => 2224,
                    'name' => 'Panevezys',
                    'country_id' => 126,
                ),
            2185 =>
                array (
                    'id' => 2225,
                    'name' => 'Shiauliu',
                    'country_id' => 126,
                ),
            2186 =>
                array (
                    'id' => 2226,
                    'name' => 'Taurages',
                    'country_id' => 126,
                ),
            2187 =>
                array (
                    'id' => 2227,
                    'name' => 'Telshiu',
                    'country_id' => 126,
                ),
            2188 =>
                array (
                    'id' => 2228,
                    'name' => 'Telsiai',
                    'country_id' => 126,
                ),
            2189 =>
                array (
                    'id' => 2229,
                    'name' => 'Utenos',
                    'country_id' => 126,
                ),
            2190 =>
                array (
                    'id' => 2230,
                    'name' => 'Vilniaus',
                    'country_id' => 126,
                ),
            2191 =>
                array (
                    'id' => 2231,
                    'name' => 'Capellen',
                    'country_id' => 127,
                ),
            2192 =>
                array (
                    'id' => 2232,
                    'name' => 'Clervaux',
                    'country_id' => 127,
                ),
            2193 =>
                array (
                    'id' => 2233,
                    'name' => 'Diekirch',
                    'country_id' => 127,
                ),
            2194 =>
                array (
                    'id' => 2234,
                    'name' => 'Echternach',
                    'country_id' => 127,
                ),
            2195 =>
                array (
                    'id' => 2235,
                    'name' => 'Esch-sur-Alzette',
                    'country_id' => 127,
                ),
            2196 =>
                array (
                    'id' => 2236,
                    'name' => 'Grevenmacher',
                    'country_id' => 127,
                ),
            2197 =>
                array (
                    'id' => 2237,
                    'name' => 'Luxembourg',
                    'country_id' => 127,
                ),
            2198 =>
                array (
                    'id' => 2238,
                    'name' => 'Mersch',
                    'country_id' => 127,
                ),
            2199 =>
                array (
                    'id' => 2239,
                    'name' => 'Redange',
                    'country_id' => 127,
                ),
            2200 =>
                array (
                    'id' => 2240,
                    'name' => 'Remich',
                    'country_id' => 127,
                ),
            2201 =>
                array (
                    'id' => 2241,
                    'name' => 'Vianden',
                    'country_id' => 127,
                ),
            2202 =>
                array (
                    'id' => 2242,
                    'name' => 'Wiltz',
                    'country_id' => 127,
                ),
            2203 =>
                array (
                    'id' => 2243,
                    'name' => 'Macau',
                    'country_id' => 128,
                ),
            2204 =>
                array (
                    'id' => 2244,
                    'name' => 'Berovo',
                    'country_id' => 129,
                ),
            2205 =>
                array (
                    'id' => 2245,
                    'name' => 'Bitola',
                    'country_id' => 129,
                ),
            2206 =>
                array (
                    'id' => 2246,
                    'name' => 'Brod',
                    'country_id' => 129,
                ),
            2207 =>
                array (
                    'id' => 2247,
                    'name' => 'Debar',
                    'country_id' => 129,
                ),
            2208 =>
                array (
                    'id' => 2248,
                    'name' => 'Delchevo',
                    'country_id' => 129,
                ),
            2209 =>
                array (
                    'id' => 2249,
                    'name' => 'Demir Hisar',
                    'country_id' => 129,
                ),
            2210 =>
                array (
                    'id' => 2250,
                    'name' => 'Gevgelija',
                    'country_id' => 129,
                ),
            2211 =>
                array (
                    'id' => 2251,
                    'name' => 'Gostivar',
                    'country_id' => 129,
                ),
            2212 =>
                array (
                    'id' => 2252,
                    'name' => 'Kavadarci',
                    'country_id' => 129,
                ),
            2213 =>
                array (
                    'id' => 2253,
                    'name' => 'Kichevo',
                    'country_id' => 129,
                ),
            2214 =>
                array (
                    'id' => 2254,
                    'name' => 'Kochani',
                    'country_id' => 129,
                ),
            2215 =>
                array (
                    'id' => 2255,
                    'name' => 'Kratovo',
                    'country_id' => 129,
                ),
            2216 =>
                array (
                    'id' => 2256,
                    'name' => 'Kriva Palanka',
                    'country_id' => 129,
                ),
            2217 =>
                array (
                    'id' => 2257,
                    'name' => 'Krushevo',
                    'country_id' => 129,
                ),
            2218 =>
                array (
                    'id' => 2258,
                    'name' => 'Kumanovo',
                    'country_id' => 129,
                ),
            2219 =>
                array (
                    'id' => 2259,
                    'name' => 'Negotino',
                    'country_id' => 129,
                ),
            2220 =>
                array (
                    'id' => 2260,
                    'name' => 'Ohrid',
                    'country_id' => 129,
                ),
            2221 =>
                array (
                    'id' => 2261,
                    'name' => 'Prilep',
                    'country_id' => 129,
                ),
            2222 =>
                array (
                    'id' => 2262,
                    'name' => 'Probishtip',
                    'country_id' => 129,
                ),
            2223 =>
                array (
                    'id' => 2263,
                    'name' => 'Radovish',
                    'country_id' => 129,
                ),
            2224 =>
                array (
                    'id' => 2264,
                    'name' => 'Resen',
                    'country_id' => 129,
                ),
            2225 =>
                array (
                    'id' => 2265,
                    'name' => 'Shtip',
                    'country_id' => 129,
                ),
            2226 =>
                array (
                    'id' => 2266,
                    'name' => 'Skopje',
                    'country_id' => 129,
                ),
            2227 =>
                array (
                    'id' => 2267,
                    'name' => 'Struga',
                    'country_id' => 129,
                ),
            2228 =>
                array (
                    'id' => 2268,
                    'name' => 'Strumica',
                    'country_id' => 129,
                ),
            2229 =>
                array (
                    'id' => 2269,
                    'name' => 'Sveti Nikole',
                    'country_id' => 129,
                ),
            2230 =>
                array (
                    'id' => 2270,
                    'name' => 'Tetovo',
                    'country_id' => 129,
                ),
            2231 =>
                array (
                    'id' => 2271,
                    'name' => 'Valandovo',
                    'country_id' => 129,
                ),
            2232 =>
                array (
                    'id' => 2272,
                    'name' => 'Veles',
                    'country_id' => 129,
                ),
            2233 =>
                array (
                    'id' => 2273,
                    'name' => 'Vinica',
                    'country_id' => 129,
                ),
            2234 =>
                array (
                    'id' => 2274,
                    'name' => 'Antananarivo',
                    'country_id' => 130,
                ),
            2235 =>
                array (
                    'id' => 2275,
                    'name' => 'Antsiranana',
                    'country_id' => 130,
                ),
            2236 =>
                array (
                    'id' => 2276,
                    'name' => 'Fianarantsoa',
                    'country_id' => 130,
                ),
            2237 =>
                array (
                    'id' => 2277,
                    'name' => 'Mahajanga',
                    'country_id' => 130,
                ),
            2238 =>
                array (
                    'id' => 2278,
                    'name' => 'Toamasina',
                    'country_id' => 130,
                ),
            2239 =>
                array (
                    'id' => 2279,
                    'name' => 'Toliary',
                    'country_id' => 130,
                ),
            2240 =>
                array (
                    'id' => 2280,
                    'name' => 'Balaka',
                    'country_id' => 131,
                ),
            2241 =>
                array (
                    'id' => 2281,
                    'name' => 'Blantyre City',
                    'country_id' => 131,
                ),
            2242 =>
                array (
                    'id' => 2282,
                    'name' => 'Chikwawa',
                    'country_id' => 131,
                ),
            2243 =>
                array (
                    'id' => 2283,
                    'name' => 'Chiradzulu',
                    'country_id' => 131,
                ),
            2244 =>
                array (
                    'id' => 2284,
                    'name' => 'Chitipa',
                    'country_id' => 131,
                ),
            2245 =>
                array (
                    'id' => 2285,
                    'name' => 'Dedza',
                    'country_id' => 131,
                ),
            2246 =>
                array (
                    'id' => 2286,
                    'name' => 'Dowa',
                    'country_id' => 131,
                ),
            2247 =>
                array (
                    'id' => 2287,
                    'name' => 'Karonga',
                    'country_id' => 131,
                ),
            2248 =>
                array (
                    'id' => 2288,
                    'name' => 'Kasungu',
                    'country_id' => 131,
                ),
            2249 =>
                array (
                    'id' => 2289,
                    'name' => 'Lilongwe City',
                    'country_id' => 131,
                ),
            2250 =>
                array (
                    'id' => 2290,
                    'name' => 'Machinga',
                    'country_id' => 131,
                ),
            2251 =>
                array (
                    'id' => 2291,
                    'name' => 'Mangochi',
                    'country_id' => 131,
                ),
            2252 =>
                array (
                    'id' => 2292,
                    'name' => 'Mchinji',
                    'country_id' => 131,
                ),
            2253 =>
                array (
                    'id' => 2293,
                    'name' => 'Mulanje',
                    'country_id' => 131,
                ),
            2254 =>
                array (
                    'id' => 2294,
                    'name' => 'Mwanza',
                    'country_id' => 131,
                ),
            2255 =>
                array (
                    'id' => 2295,
                    'name' => 'Mzimba',
                    'country_id' => 131,
                ),
            2256 =>
                array (
                    'id' => 2296,
                    'name' => 'Mzuzu City',
                    'country_id' => 131,
                ),
            2257 =>
                array (
                    'id' => 2297,
                    'name' => 'Nkhata Bay',
                    'country_id' => 131,
                ),
            2258 =>
                array (
                    'id' => 2298,
                    'name' => 'Nkhotakota',
                    'country_id' => 131,
                ),
            2259 =>
                array (
                    'id' => 2299,
                    'name' => 'Nsanje',
                    'country_id' => 131,
                ),
            2260 =>
                array (
                    'id' => 2300,
                    'name' => 'Ntcheu',
                    'country_id' => 131,
                ),
            2261 =>
                array (
                    'id' => 2301,
                    'name' => 'Ntchisi',
                    'country_id' => 131,
                ),
            2262 =>
                array (
                    'id' => 2302,
                    'name' => 'Phalombe',
                    'country_id' => 131,
                ),
            2263 =>
                array (
                    'id' => 2303,
                    'name' => 'Rumphi',
                    'country_id' => 131,
                ),
            2264 =>
                array (
                    'id' => 2304,
                    'name' => 'Salima',
                    'country_id' => 131,
                ),
            2265 =>
                array (
                    'id' => 2305,
                    'name' => 'Thyolo',
                    'country_id' => 131,
                ),
            2266 =>
                array (
                    'id' => 2306,
                    'name' => 'Zomba Municipality',
                    'country_id' => 131,
                ),
            2267 =>
                array (
                    'id' => 2307,
                    'name' => 'Johor',
                    'country_id' => 132,
                ),
            2268 =>
                array (
                    'id' => 2308,
                    'name' => 'Kedah',
                    'country_id' => 132,
                ),
            2269 =>
                array (
                    'id' => 2309,
                    'name' => 'Kelantan',
                    'country_id' => 132,
                ),
            2270 =>
                array (
                    'id' => 2310,
                    'name' => 'Kuala Lumpur',
                    'country_id' => 132,
                ),
            2271 =>
                array (
                    'id' => 2311,
                    'name' => 'Labuan',
                    'country_id' => 132,
                ),
            2272 =>
                array (
                    'id' => 2312,
                    'name' => 'Melaka',
                    'country_id' => 132,
                ),
            2273 =>
                array (
                    'id' => 2313,
                    'name' => 'Negeri Johor',
                    'country_id' => 132,
                ),
            2274 =>
                array (
                    'id' => 2314,
                    'name' => 'Negeri Sembilan',
                    'country_id' => 132,
                ),
            2275 =>
                array (
                    'id' => 2315,
                    'name' => 'Pahang',
                    'country_id' => 132,
                ),
            2276 =>
                array (
                    'id' => 2316,
                    'name' => 'Penang',
                    'country_id' => 132,
                ),
            2277 =>
                array (
                    'id' => 2317,
                    'name' => 'Perak',
                    'country_id' => 132,
                ),
            2278 =>
                array (
                    'id' => 2318,
                    'name' => 'Perlis',
                    'country_id' => 132,
                ),
            2279 =>
                array (
                    'id' => 2319,
                    'name' => 'Pulau Pinang',
                    'country_id' => 132,
                ),
            2280 =>
                array (
                    'id' => 2320,
                    'name' => 'Sabah',
                    'country_id' => 132,
                ),
            2281 =>
                array (
                    'id' => 2321,
                    'name' => 'Sarawak',
                    'country_id' => 132,
                ),
            2282 =>
                array (
                    'id' => 2322,
                    'name' => 'Selangor',
                    'country_id' => 132,
                ),
            2283 =>
                array (
                    'id' => 2323,
                    'name' => 'Sembilan',
                    'country_id' => 132,
                ),
            2284 =>
                array (
                    'id' => 2324,
                    'name' => 'Terengganu',
                    'country_id' => 132,
                ),
            2285 =>
                array (
                    'id' => 2325,
                    'name' => 'Alif Alif',
                    'country_id' => 133,
                ),
            2286 =>
                array (
                    'id' => 2326,
                    'name' => 'Alif Dhaal',
                    'country_id' => 133,
                ),
            2287 =>
                array (
                    'id' => 2327,
                    'name' => 'Baa',
                    'country_id' => 133,
                ),
            2288 =>
                array (
                    'id' => 2328,
                    'name' => 'Dhaal',
                    'country_id' => 133,
                ),
            2289 =>
                array (
                    'id' => 2329,
                    'name' => 'Faaf',
                    'country_id' => 133,
                ),
            2290 =>
                array (
                    'id' => 2330,
                    'name' => 'Gaaf Alif',
                    'country_id' => 133,
                ),
            2291 =>
                array (
                    'id' => 2331,
                    'name' => 'Gaaf Dhaal',
                    'country_id' => 133,
                ),
            2292 =>
                array (
                    'id' => 2332,
                    'name' => 'Ghaviyani',
                    'country_id' => 133,
                ),
            2293 =>
                array (
                    'id' => 2333,
                    'name' => 'Haa Alif',
                    'country_id' => 133,
                ),
            2294 =>
                array (
                    'id' => 2334,
                    'name' => 'Haa Dhaal',
                    'country_id' => 133,
                ),
            2295 =>
                array (
                    'id' => 2335,
                    'name' => 'Kaaf',
                    'country_id' => 133,
                ),
            2296 =>
                array (
                    'id' => 2336,
                    'name' => 'Laam',
                    'country_id' => 133,
                ),
            2297 =>
                array (
                    'id' => 2337,
                    'name' => 'Lhaviyani',
                    'country_id' => 133,
                ),
            2298 =>
                array (
                    'id' => 2338,
                    'name' => 'Male',
                    'country_id' => 133,
                ),
            2299 =>
                array (
                    'id' => 2339,
                    'name' => 'Miim',
                    'country_id' => 133,
                ),
            2300 =>
                array (
                    'id' => 2340,
                    'name' => 'Nuun',
                    'country_id' => 133,
                ),
            2301 =>
                array (
                    'id' => 2341,
                    'name' => 'Raa',
                    'country_id' => 133,
                ),
            2302 =>
                array (
                    'id' => 2342,
                    'name' => 'Shaviyani',
                    'country_id' => 133,
                ),
            2303 =>
                array (
                    'id' => 2343,
                    'name' => 'Siin',
                    'country_id' => 133,
                ),
            2304 =>
                array (
                    'id' => 2344,
                    'name' => 'Thaa',
                    'country_id' => 133,
                ),
            2305 =>
                array (
                    'id' => 2345,
                    'name' => 'Vaav',
                    'country_id' => 133,
                ),
            2306 =>
                array (
                    'id' => 2346,
                    'name' => 'Bamako',
                    'country_id' => 134,
                ),
            2307 =>
                array (
                    'id' => 2347,
                    'name' => 'Gao',
                    'country_id' => 134,
                ),
            2308 =>
                array (
                    'id' => 2348,
                    'name' => 'Kayes',
                    'country_id' => 134,
                ),
            2309 =>
                array (
                    'id' => 2349,
                    'name' => 'Kidal',
                    'country_id' => 134,
                ),
            2310 =>
                array (
                    'id' => 2350,
                    'name' => 'Koulikoro',
                    'country_id' => 134,
                ),
            2311 =>
                array (
                    'id' => 2351,
                    'name' => 'Mopti',
                    'country_id' => 134,
                ),
            2312 =>
                array (
                    'id' => 2352,
                    'name' => 'Segou',
                    'country_id' => 134,
                ),
            2313 =>
                array (
                    'id' => 2353,
                    'name' => 'Sikasso',
                    'country_id' => 134,
                ),
            2314 =>
                array (
                    'id' => 2354,
                    'name' => 'Tombouctou',
                    'country_id' => 134,
                ),
            2315 =>
                array (
                    'id' => 2355,
                    'name' => 'Gozo and Comino',
                    'country_id' => 135,
                ),
            2316 =>
                array (
                    'id' => 2356,
                    'name' => 'Inner Harbour',
                    'country_id' => 135,
                ),
            2317 =>
                array (
                    'id' => 2357,
                    'name' => 'Northern',
                    'country_id' => 135,
                ),
            2318 =>
                array (
                    'id' => 2358,
                    'name' => 'Outer Harbour',
                    'country_id' => 135,
                ),
            2319 =>
                array (
                    'id' => 2359,
                    'name' => 'South Eastern',
                    'country_id' => 135,
                ),
            2320 =>
                array (
                    'id' => 2360,
                    'name' => 'Valletta',
                    'country_id' => 135,
                ),
            2321 =>
                array (
                    'id' => 2361,
                    'name' => 'Western',
                    'country_id' => 135,
                ),
            2322 =>
                array (
                    'id' => 2370,
                    'name' => 'Ailinlaplap',
                    'country_id' => 137,
                ),
            2323 =>
                array (
                    'id' => 2371,
                    'name' => 'Ailuk',
                    'country_id' => 137,
                ),
            2324 =>
                array (
                    'id' => 2372,
                    'name' => 'Arno',
                    'country_id' => 137,
                ),
            2325 =>
                array (
                    'id' => 2373,
                    'name' => 'Aur',
                    'country_id' => 137,
                ),
            2326 =>
                array (
                    'id' => 2374,
                    'name' => 'Bikini',
                    'country_id' => 137,
                ),
            2327 =>
                array (
                    'id' => 2375,
                    'name' => 'Ebon',
                    'country_id' => 137,
                ),
            2328 =>
                array (
                    'id' => 2376,
                    'name' => 'Enewetak',
                    'country_id' => 137,
                ),
            2329 =>
                array (
                    'id' => 2377,
                    'name' => 'Jabat',
                    'country_id' => 137,
                ),
            2330 =>
                array (
                    'id' => 2378,
                    'name' => 'Jaluit',
                    'country_id' => 137,
                ),
            2331 =>
                array (
                    'id' => 2379,
                    'name' => 'Kili',
                    'country_id' => 137,
                ),
            2332 =>
                array (
                    'id' => 2380,
                    'name' => 'Kwajalein',
                    'country_id' => 137,
                ),
            2333 =>
                array (
                    'id' => 2381,
                    'name' => 'Lae',
                    'country_id' => 137,
                ),
            2334 =>
                array (
                    'id' => 2382,
                    'name' => 'Lib',
                    'country_id' => 137,
                ),
            2335 =>
                array (
                    'id' => 2383,
                    'name' => 'Likiep',
                    'country_id' => 137,
                ),
            2336 =>
                array (
                    'id' => 2384,
                    'name' => 'Majuro',
                    'country_id' => 137,
                ),
            2337 =>
                array (
                    'id' => 2385,
                    'name' => 'Maloelap',
                    'country_id' => 137,
                ),
            2338 =>
                array (
                    'id' => 2386,
                    'name' => 'Mejit',
                    'country_id' => 137,
                ),
            2339 =>
                array (
                    'id' => 2387,
                    'name' => 'Mili',
                    'country_id' => 137,
                ),
            2340 =>
                array (
                    'id' => 2388,
                    'name' => 'Namorik',
                    'country_id' => 137,
                ),
            2341 =>
                array (
                    'id' => 2389,
                    'name' => 'Namu',
                    'country_id' => 137,
                ),
            2342 =>
                array (
                    'id' => 2390,
                    'name' => 'Rongelap',
                    'country_id' => 137,
                ),
            2343 =>
                array (
                    'id' => 2391,
                    'name' => 'Ujae',
                    'country_id' => 137,
                ),
            2344 =>
                array (
                    'id' => 2392,
                    'name' => 'Utrik',
                    'country_id' => 137,
                ),
            2345 =>
                array (
                    'id' => 2393,
                    'name' => 'Wotho',
                    'country_id' => 137,
                ),
            2346 =>
                array (
                    'id' => 2394,
                    'name' => 'Wotje',
                    'country_id' => 137,
                ),
            2347 =>
                array (
                    'id' => 2395,
                    'name' => 'Fort-de-France',
                    'country_id' => 138,
                ),
            2348 =>
                array (
                    'id' => 2396,
                    'name' => 'La Trinite',
                    'country_id' => 138,
                ),
            2349 =>
                array (
                    'id' => 2397,
                    'name' => 'Le Marin',
                    'country_id' => 138,
                ),
            2350 =>
                array (
                    'id' => 2398,
                    'name' => 'Saint-Pierre',
                    'country_id' => 138,
                ),
            2351 =>
                array (
                    'id' => 2399,
                    'name' => 'Adrar',
                    'country_id' => 139,
                ),
            2352 =>
                array (
                    'id' => 2400,
                    'name' => 'Assaba',
                    'country_id' => 139,
                ),
            2353 =>
                array (
                    'id' => 2401,
                    'name' => 'Brakna',
                    'country_id' => 139,
                ),
            2354 =>
                array (
                    'id' => 2402,
                    'name' => 'Dhakhlat Nawadibu',
                    'country_id' => 139,
                ),
            2355 =>
                array (
                    'id' => 2403,
                    'name' => 'Hudh-al-Gharbi',
                    'country_id' => 139,
                ),
            2356 =>
                array (
                    'id' => 2404,
                    'name' => 'Hudh-ash-Sharqi',
                    'country_id' => 139,
                ),
            2357 =>
                array (
                    'id' => 2405,
                    'name' => 'Inshiri',
                    'country_id' => 139,
                ),
            2358 =>
                array (
                    'id' => 2406,
                    'name' => 'Nawakshut',
                    'country_id' => 139,
                ),
            2359 =>
                array (
                    'id' => 2407,
                    'name' => 'Qidimagha',
                    'country_id' => 139,
                ),
            2360 =>
                array (
                    'id' => 2408,
                    'name' => 'Qurqul',
                    'country_id' => 139,
                ),
            2361 =>
                array (
                    'id' => 2409,
                    'name' => 'Taqant',
                    'country_id' => 139,
                ),
            2362 =>
                array (
                    'id' => 2410,
                    'name' => 'Tiris Zammur',
                    'country_id' => 139,
                ),
            2363 =>
                array (
                    'id' => 2411,
                    'name' => 'Trarza',
                    'country_id' => 139,
                ),
            2364 =>
                array (
                    'id' => 2412,
                    'name' => 'Black River',
                    'country_id' => 140,
                ),
            2365 =>
                array (
                    'id' => 2413,
                    'name' => 'Eau Coulee',
                    'country_id' => 140,
                ),
            2366 =>
                array (
                    'id' => 2414,
                    'name' => 'Flacq',
                    'country_id' => 140,
                ),
            2367 =>
                array (
                    'id' => 2415,
                    'name' => 'Floreal',
                    'country_id' => 140,
                ),
            2368 =>
                array (
                    'id' => 2416,
                    'name' => 'Grand Port',
                    'country_id' => 140,
                ),
            2369 =>
                array (
                    'id' => 2417,
                    'name' => 'Moka',
                    'country_id' => 140,
                ),
            2370 =>
                array (
                    'id' => 2418,
                    'name' => 'Pamplempousses',
                    'country_id' => 140,
                ),
            2371 =>
                array (
                    'id' => 2419,
                    'name' => 'Plaines Wilhelm',
                    'country_id' => 140,
                ),
            2372 =>
                array (
                    'id' => 2420,
                    'name' => 'Port Louis',
                    'country_id' => 140,
                ),
            2373 =>
                array (
                    'id' => 2421,
                    'name' => 'Riviere du Rempart',
                    'country_id' => 140,
                ),
            2374 =>
                array (
                    'id' => 2422,
                    'name' => 'Rodrigues',
                    'country_id' => 140,
                ),
            2375 =>
                array (
                    'id' => 2423,
                    'name' => 'Rose Hill',
                    'country_id' => 140,
                ),
            2376 =>
                array (
                    'id' => 2424,
                    'name' => 'Savanne',
                    'country_id' => 140,
                ),
            2377 =>
                array (
                    'id' => 2425,
                    'name' => 'Mayotte',
                    'country_id' => 141,
                ),
            2378 =>
                array (
                    'id' => 2426,
                    'name' => 'Pamanzi',
                    'country_id' => 141,
                ),
            2379 =>
                array (
                    'id' => 2427,
                    'name' => 'Aguascalientes',
                    'country_id' => 142,
                ),
            2380 =>
                array (
                    'id' => 2428,
                    'name' => 'Baja California',
                    'country_id' => 142,
                ),
            2381 =>
                array (
                    'id' => 2429,
                    'name' => 'Baja California Sur',
                    'country_id' => 142,
                ),
            2382 =>
                array (
                    'id' => 2430,
                    'name' => 'Campeche',
                    'country_id' => 142,
                ),
            2383 =>
                array (
                    'id' => 2431,
                    'name' => 'Chiapas',
                    'country_id' => 142,
                ),
            2384 =>
                array (
                    'id' => 2432,
                    'name' => 'Chihuahua',
                    'country_id' => 142,
                ),
            2385 =>
                array (
                    'id' => 2433,
                    'name' => 'Coahuila',
                    'country_id' => 142,
                ),
            2386 =>
                array (
                    'id' => 2434,
                    'name' => 'Colima',
                    'country_id' => 142,
                ),
            2387 =>
                array (
                    'id' => 2435,
                    'name' => 'Distrito Federal',
                    'country_id' => 142,
                ),
            2388 =>
                array (
                    'id' => 2436,
                    'name' => 'Durango',
                    'country_id' => 142,
                ),
            2389 =>
                array (
                    'id' => 2437,
                    'name' => 'Estado de Mexico',
                    'country_id' => 142,
                ),
            2390 =>
                array (
                    'id' => 2438,
                    'name' => 'Guanajuato',
                    'country_id' => 142,
                ),
            2391 =>
                array (
                    'id' => 2439,
                    'name' => 'Guerrero',
                    'country_id' => 142,
                ),
            2392 =>
                array (
                    'id' => 2440,
                    'name' => 'Hidalgo',
                    'country_id' => 142,
                ),
            2393 =>
                array (
                    'id' => 2441,
                    'name' => 'Jalisco',
                    'country_id' => 142,
                ),
            2394 =>
                array (
                    'id' => 2442,
                    'name' => 'Mexico',
                    'country_id' => 142,
                ),
            2395 =>
                array (
                    'id' => 2443,
                    'name' => 'Michoacan',
                    'country_id' => 142,
                ),
            2396 =>
                array (
                    'id' => 2444,
                    'name' => 'Morelos',
                    'country_id' => 142,
                ),
            2397 =>
                array (
                    'id' => 2445,
                    'name' => 'Nayarit',
                    'country_id' => 142,
                ),
            2398 =>
                array (
                    'id' => 2446,
                    'name' => 'Nuevo Leon',
                    'country_id' => 142,
                ),
            2399 =>
                array (
                    'id' => 2447,
                    'name' => 'Oaxaca',
                    'country_id' => 142,
                ),
            2400 =>
                array (
                    'id' => 2448,
                    'name' => 'Puebla',
                    'country_id' => 142,
                ),
            2401 =>
                array (
                    'id' => 2449,
                    'name' => 'Queretaro',
                    'country_id' => 142,
                ),
            2402 =>
                array (
                    'id' => 2450,
                    'name' => 'Quintana Roo',
                    'country_id' => 142,
                ),
            2403 =>
                array (
                    'id' => 2451,
                    'name' => 'San Luis Potosi',
                    'country_id' => 142,
                ),
            2404 =>
                array (
                    'id' => 2452,
                    'name' => 'Sinaloa',
                    'country_id' => 142,
                ),
            2405 =>
                array (
                    'id' => 2453,
                    'name' => 'Sonora',
                    'country_id' => 142,
                ),
            2406 =>
                array (
                    'id' => 2454,
                    'name' => 'Tabasco',
                    'country_id' => 142,
                ),
            2407 =>
                array (
                    'id' => 2455,
                    'name' => 'Tamaulipas',
                    'country_id' => 142,
                ),
            2408 =>
                array (
                    'id' => 2456,
                    'name' => 'Tlaxcala',
                    'country_id' => 142,
                ),
            2409 =>
                array (
                    'id' => 2457,
                    'name' => 'Veracruz',
                    'country_id' => 142,
                ),
            2410 =>
                array (
                    'id' => 2458,
                    'name' => 'Yucatan',
                    'country_id' => 142,
                ),
            2411 =>
                array (
                    'id' => 2459,
                    'name' => 'Zacatecas',
                    'country_id' => 142,
                ),
            2412 =>
                array (
                    'id' => 2460,
                    'name' => 'Chuuk',
                    'country_id' => 143,
                ),
            2413 =>
                array (
                    'id' => 2461,
                    'name' => 'Kusaie',
                    'country_id' => 143,
                ),
            2414 =>
                array (
                    'id' => 2462,
                    'name' => 'Pohnpei',
                    'country_id' => 143,
                ),
            2415 =>
                array (
                    'id' => 2463,
                    'name' => 'Yap',
                    'country_id' => 143,
                ),
            2416 =>
                array (
                    'id' => 2464,
                    'name' => 'Balti',
                    'country_id' => 144,
                ),
            2417 =>
                array (
                    'id' => 2465,
                    'name' => 'Cahul',
                    'country_id' => 144,
                ),
            2418 =>
                array (
                    'id' => 2466,
                    'name' => 'Chisinau',
                    'country_id' => 144,
                ),
            2419 =>
                array (
                    'id' => 2467,
                    'name' => 'Chisinau Oras',
                    'country_id' => 144,
                ),
            2420 =>
                array (
                    'id' => 2468,
                    'name' => 'Edinet',
                    'country_id' => 144,
                ),
            2421 =>
                array (
                    'id' => 2469,
                    'name' => 'Gagauzia',
                    'country_id' => 144,
                ),
            2422 =>
                array (
                    'id' => 2470,
                    'name' => 'Lapusna',
                    'country_id' => 144,
                ),
            2423 =>
                array (
                    'id' => 2471,
                    'name' => 'Orhei',
                    'country_id' => 144,
                ),
            2424 =>
                array (
                    'id' => 2472,
                    'name' => 'Soroca',
                    'country_id' => 144,
                ),
            2425 =>
                array (
                    'id' => 2473,
                    'name' => 'Taraclia',
                    'country_id' => 144,
                ),
            2426 =>
                array (
                    'id' => 2474,
                    'name' => 'Tighina',
                    'country_id' => 144,
                ),
            2427 =>
                array (
                    'id' => 2475,
                    'name' => 'Transnistria',
                    'country_id' => 144,
                ),
            2428 =>
                array (
                    'id' => 2476,
                    'name' => 'Ungheni',
                    'country_id' => 144,
                ),
            2429 =>
                array (
                    'id' => 2477,
                    'name' => 'Fontvieille',
                    'country_id' => 145,
                ),
            2430 =>
                array (
                    'id' => 2478,
                    'name' => 'La Condamine',
                    'country_id' => 145,
                ),
            2431 =>
                array (
                    'id' => 2479,
                    'name' => 'Monaco-Ville',
                    'country_id' => 145,
                ),
            2432 =>
                array (
                    'id' => 2480,
                    'name' => 'Monte Carlo',
                    'country_id' => 145,
                ),
            2433 =>
                array (
                    'id' => 2481,
                    'name' => 'Arhangaj',
                    'country_id' => 146,
                ),
            2434 =>
                array (
                    'id' => 2482,
                    'name' => 'Bajan-Olgij',
                    'country_id' => 146,
                ),
            2435 =>
                array (
                    'id' => 2483,
                    'name' => 'Bajanhongor',
                    'country_id' => 146,
                ),
            2436 =>
                array (
                    'id' => 2484,
                    'name' => 'Bulgan',
                    'country_id' => 146,
                ),
            2437 =>
                array (
                    'id' => 2485,
                    'name' => 'Darhan-Uul',
                    'country_id' => 146,
                ),
            2438 =>
                array (
                    'id' => 2486,
                    'name' => 'Dornod',
                    'country_id' => 146,
                ),
            2439 =>
                array (
                    'id' => 2487,
                    'name' => 'Dornogovi',
                    'country_id' => 146,
                ),
            2440 =>
                array (
                    'id' => 2488,
                    'name' => 'Dundgovi',
                    'country_id' => 146,
                ),
            2441 =>
                array (
                    'id' => 2489,
                    'name' => 'Govi-Altaj',
                    'country_id' => 146,
                ),
            2442 =>
                array (
                    'id' => 2490,
                    'name' => 'Govisumber',
                    'country_id' => 146,
                ),
            2443 =>
                array (
                    'id' => 2491,
                    'name' => 'Hentij',
                    'country_id' => 146,
                ),
            2444 =>
                array (
                    'id' => 2492,
                    'name' => 'Hovd',
                    'country_id' => 146,
                ),
            2445 =>
                array (
                    'id' => 2493,
                    'name' => 'Hovsgol',
                    'country_id' => 146,
                ),
            2446 =>
                array (
                    'id' => 2494,
                    'name' => 'Omnogovi',
                    'country_id' => 146,
                ),
            2447 =>
                array (
                    'id' => 2495,
                    'name' => 'Orhon',
                    'country_id' => 146,
                ),
            2448 =>
                array (
                    'id' => 2496,
                    'name' => 'Ovorhangaj',
                    'country_id' => 146,
                ),
            2449 =>
                array (
                    'id' => 2497,
                    'name' => 'Selenge',
                    'country_id' => 146,
                ),
            2450 =>
                array (
                    'id' => 2498,
                    'name' => 'Suhbaatar',
                    'country_id' => 146,
                ),
            2451 =>
                array (
                    'id' => 2499,
                    'name' => 'Tov',
                    'country_id' => 146,
                ),
            2452 =>
                array (
                    'id' => 2500,
                    'name' => 'Ulaanbaatar',
                    'country_id' => 146,
                ),
            2453 =>
                array (
                    'id' => 2501,
                    'name' => 'Uvs',
                    'country_id' => 146,
                ),
            2454 =>
                array (
                    'id' => 2502,
                    'name' => 'Zavhan',
                    'country_id' => 146,
                ),
            2455 =>
                array (
                    'id' => 2503,
                    'name' => 'Montserrat',
                    'country_id' => 148,
                ),
            2456 =>
                array (
                    'id' => 2504,
                    'name' => 'Agadir',
                    'country_id' => 149,
                ),
            2457 =>
                array (
                    'id' => 2505,
                    'name' => 'Casablanca',
                    'country_id' => 149,
                ),
            2458 =>
                array (
                    'id' => 2506,
                    'name' => 'Chaouia-Ouardigha',
                    'country_id' => 149,
                ),
            2459 =>
                array (
                    'id' => 2507,
                    'name' => 'Doukkala-Abda',
                    'country_id' => 149,
                ),
            2460 =>
                array (
                    'id' => 2508,
                    'name' => 'Fes-Boulemane',
                    'country_id' => 149,
                ),
            2461 =>
                array (
                    'id' => 2509,
                    'name' => 'Gharb-Chrarda-Beni Hssen',
                    'country_id' => 149,
                ),
            2462 =>
                array (
                    'id' => 2510,
                    'name' => 'Guelmim',
                    'country_id' => 149,
                ),
            2463 =>
                array (
                    'id' => 2511,
                    'name' => 'Kenitra',
                    'country_id' => 149,
                ),
            2464 =>
                array (
                    'id' => 2512,
                    'name' => 'Marrakech-Tensift-Al Haouz',
                    'country_id' => 149,
                ),
            2465 =>
                array (
                    'id' => 2513,
                    'name' => 'Meknes-Tafilalet',
                    'country_id' => 149,
                ),
            2466 =>
                array (
                    'id' => 2514,
                    'name' => 'Oriental',
                    'country_id' => 149,
                ),
            2467 =>
                array (
                    'id' => 2515,
                    'name' => 'Oujda',
                    'country_id' => 149,
                ),
            2468 =>
                array (
                    'id' => 2516,
                    'name' => 'Province de Tanger',
                    'country_id' => 149,
                ),
            2469 =>
                array (
                    'id' => 2517,
                    'name' => 'Rabat-Sale-Zammour-Zaer',
                    'country_id' => 149,
                ),
            2470 =>
                array (
                    'id' => 2518,
                    'name' => 'Sala Al Jadida',
                    'country_id' => 149,
                ),
            2471 =>
                array (
                    'id' => 2519,
                    'name' => 'Settat',
                    'country_id' => 149,
                ),
            2472 =>
                array (
                    'id' => 2520,
                    'name' => 'Souss Massa-Draa',
                    'country_id' => 149,
                ),
            2473 =>
                array (
                    'id' => 2521,
                    'name' => 'Tadla-Azilal',
                    'country_id' => 149,
                ),
            2474 =>
                array (
                    'id' => 2522,
                    'name' => 'Tangier-Tetouan',
                    'country_id' => 149,
                ),
            2475 =>
                array (
                    'id' => 2523,
                    'name' => 'Taza-Al Hoceima-Taounate',
                    'country_id' => 149,
                ),
            2476 =>
                array (
                    'id' => 2524,
                    'name' => 'Wilaya de Casablanca',
                    'country_id' => 149,
                ),
            2477 =>
                array (
                    'id' => 2525,
                    'name' => 'Wilaya de Rabat-Sale',
                    'country_id' => 149,
                ),
            2478 =>
                array (
                    'id' => 2526,
                    'name' => 'Cabo Delgado',
                    'country_id' => 150,
                ),
            2479 =>
                array (
                    'id' => 2527,
                    'name' => 'Gaza',
                    'country_id' => 150,
                ),
            2480 =>
                array (
                    'id' => 2528,
                    'name' => 'Inhambane',
                    'country_id' => 150,
                ),
            2481 =>
                array (
                    'id' => 2529,
                    'name' => 'Manica',
                    'country_id' => 150,
                ),
            2482 =>
                array (
                    'id' => 2530,
                    'name' => 'Maputo',
                    'country_id' => 150,
                ),
            2483 =>
                array (
                    'id' => 2531,
                    'name' => 'Maputo Provincia',
                    'country_id' => 150,
                ),
            2484 =>
                array (
                    'id' => 2532,
                    'name' => 'Nampula',
                    'country_id' => 150,
                ),
            2485 =>
                array (
                    'id' => 2533,
                    'name' => 'Niassa',
                    'country_id' => 150,
                ),
            2486 =>
                array (
                    'id' => 2534,
                    'name' => 'Sofala',
                    'country_id' => 150,
                ),
            2487 =>
                array (
                    'id' => 2535,
                    'name' => 'Tete',
                    'country_id' => 150,
                ),
            2488 =>
                array (
                    'id' => 2536,
                    'name' => 'Zambezia',
                    'country_id' => 150,
                ),
            2489 =>
                array (
                    'id' => 2537,
                    'name' => 'Ayeyarwady',
                    'country_id' => 151,
                ),
            2490 =>
                array (
                    'id' => 2538,
                    'name' => 'Bago',
                    'country_id' => 151,
                ),
            2491 =>
                array (
                    'id' => 2539,
                    'name' => 'Chin',
                    'country_id' => 151,
                ),
            2492 =>
                array (
                    'id' => 2540,
                    'name' => 'Kachin',
                    'country_id' => 151,
                ),
            2493 =>
                array (
                    'id' => 2541,
                    'name' => 'Kayah',
                    'country_id' => 151,
                ),
            2494 =>
                array (
                    'id' => 2542,
                    'name' => 'Kayin',
                    'country_id' => 151,
                ),
            2495 =>
                array (
                    'id' => 2543,
                    'name' => 'Magway',
                    'country_id' => 151,
                ),
            2496 =>
                array (
                    'id' => 2544,
                    'name' => 'Mandalay',
                    'country_id' => 151,
                ),
            2497 =>
                array (
                    'id' => 2545,
                    'name' => 'Mon',
                    'country_id' => 151,
                ),
            2498 =>
                array (
                    'id' => 2546,
                    'name' => 'Nay Pyi Taw',
                    'country_id' => 151,
                ),
            2499 =>
                array (
                    'id' => 2547,
                    'name' => 'Rakhine',
                    'country_id' => 151,
                ),
            2500 =>
                array (
                    'id' => 2548,
                    'name' => 'Sagaing',
                    'country_id' => 151,
                ),
            2501 =>
                array (
                    'id' => 2549,
                    'name' => 'Shan',
                    'country_id' => 151,
                ),
            2502 =>
                array (
                    'id' => 2550,
                    'name' => 'Tanintharyi',
                    'country_id' => 151,
                ),
            2503 =>
                array (
                    'id' => 2551,
                    'name' => 'Yangon',
                    'country_id' => 151,
                ),
            2504 =>
                array (
                    'id' => 2552,
                    'name' => 'Caprivi',
                    'country_id' => 152,
                ),
            2505 =>
                array (
                    'id' => 2553,
                    'name' => 'Erongo',
                    'country_id' => 152,
                ),
            2506 =>
                array (
                    'id' => 2554,
                    'name' => 'Hardap',
                    'country_id' => 152,
                ),
            2507 =>
                array (
                    'id' => 2555,
                    'name' => 'Karas',
                    'country_id' => 152,
                ),
            2508 =>
                array (
                    'id' => 2556,
                    'name' => 'Kavango',
                    'country_id' => 152,
                ),
            2509 =>
                array (
                    'id' => 2557,
                    'name' => 'Khomas',
                    'country_id' => 152,
                ),
            2510 =>
                array (
                    'id' => 2558,
                    'name' => 'Kunene',
                    'country_id' => 152,
                ),
            2511 =>
                array (
                    'id' => 2559,
                    'name' => 'Ohangwena',
                    'country_id' => 152,
                ),
            2512 =>
                array (
                    'id' => 2560,
                    'name' => 'Omaheke',
                    'country_id' => 152,
                ),
            2513 =>
                array (
                    'id' => 2561,
                    'name' => 'Omusati',
                    'country_id' => 152,
                ),
            2514 =>
                array (
                    'id' => 2562,
                    'name' => 'Oshana',
                    'country_id' => 152,
                ),
            2515 =>
                array (
                    'id' => 2563,
                    'name' => 'Oshikoto',
                    'country_id' => 152,
                ),
            2516 =>
                array (
                    'id' => 2564,
                    'name' => 'Otjozondjupa',
                    'country_id' => 152,
                ),
            2517 =>
                array (
                    'id' => 2565,
                    'name' => 'Yaren',
                    'country_id' => 153,
                ),
            2518 =>
                array (
                    'id' => 2566,
                    'name' => 'Bagmati',
                    'country_id' => 154,
                ),
            2519 =>
                array (
                    'id' => 2567,
                    'name' => 'Bheri',
                    'country_id' => 154,
                ),
            2520 =>
                array (
                    'id' => 2568,
                    'name' => 'Dhawalagiri',
                    'country_id' => 154,
                ),
            2521 =>
                array (
                    'id' => 2569,
                    'name' => 'Gandaki',
                    'country_id' => 154,
                ),
            2522 =>
                array (
                    'id' => 2570,
                    'name' => 'Janakpur',
                    'country_id' => 154,
                ),
            2523 =>
                array (
                    'id' => 2571,
                    'name' => 'Karnali',
                    'country_id' => 154,
                ),
            2524 =>
                array (
                    'id' => 2572,
                    'name' => 'Koshi',
                    'country_id' => 154,
                ),
            2525 =>
                array (
                    'id' => 2573,
                    'name' => 'Lumbini',
                    'country_id' => 154,
                ),
            2526 =>
                array (
                    'id' => 2574,
                    'name' => 'Mahakali',
                    'country_id' => 154,
                ),
            2527 =>
                array (
                    'id' => 2575,
                    'name' => 'Mechi',
                    'country_id' => 154,
                ),
            2528 =>
                array (
                    'id' => 2576,
                    'name' => 'Narayani',
                    'country_id' => 154,
                ),
            2529 =>
                array (
                    'id' => 2577,
                    'name' => 'Rapti',
                    'country_id' => 154,
                ),
            2530 =>
                array (
                    'id' => 2578,
                    'name' => 'Sagarmatha',
                    'country_id' => 154,
                ),
            2531 =>
                array (
                    'id' => 2579,
                    'name' => 'Seti',
                    'country_id' => 154,
                ),
            2532 =>
                array (
                    'id' => 2580,
                    'name' => 'Bonaire',
                    'country_id' => 155,
                ),
            2533 =>
                array (
                    'id' => 2581,
                    'name' => 'Curacao',
                    'country_id' => 155,
                ),
            2534 =>
                array (
                    'id' => 2582,
                    'name' => 'Saba',
                    'country_id' => 155,
                ),
            2535 =>
                array (
                    'id' => 2583,
                    'name' => 'Sint Eustatius',
                    'country_id' => 155,
                ),
            2536 =>
                array (
                    'id' => 2584,
                    'name' => 'Sint Maarten',
                    'country_id' => 155,
                ),
            2537 =>
                array (
                    'id' => 2585,
                    'name' => 'Amsterdam',
                    'country_id' => 156,
                ),
            2538 =>
                array (
                    'id' => 2586,
                    'name' => 'Benelux',
                    'country_id' => 156,
                ),
            2539 =>
                array (
                    'id' => 2587,
                    'name' => 'Drenthe',
                    'country_id' => 156,
                ),
            2540 =>
                array (
                    'id' => 2588,
                    'name' => 'Flevoland',
                    'country_id' => 156,
                ),
            2541 =>
                array (
                    'id' => 2589,
                    'name' => 'Friesland',
                    'country_id' => 156,
                ),
            2542 =>
                array (
                    'id' => 2590,
                    'name' => 'Gelderland',
                    'country_id' => 156,
                ),
            2543 =>
                array (
                    'id' => 2591,
                    'name' => 'Groningen',
                    'country_id' => 156,
                ),
            2544 =>
                array (
                    'id' => 2592,
                    'name' => 'Limburg',
                    'country_id' => 156,
                ),
            2545 =>
                array (
                    'id' => 2593,
                    'name' => 'Noord-Brabant',
                    'country_id' => 156,
                ),
            2546 =>
                array (
                    'id' => 2594,
                    'name' => 'Noord-Holland',
                    'country_id' => 156,
                ),
            2547 =>
                array (
                    'id' => 2595,
                    'name' => 'Overijssel',
                    'country_id' => 156,
                ),
            2548 =>
                array (
                    'id' => 2596,
                    'name' => 'South Holland',
                    'country_id' => 156,
                ),
            2549 =>
                array (
                    'id' => 2597,
                    'name' => 'Utrecht',
                    'country_id' => 156,
                ),
            2550 =>
                array (
                    'id' => 2598,
                    'name' => 'Zeeland',
                    'country_id' => 156,
                ),
            2551 =>
                array (
                    'id' => 2599,
                    'name' => 'Zuid-Holland',
                    'country_id' => 156,
                ),
            2552 =>
                array (
                    'id' => 2600,
                    'name' => 'Iles',
                    'country_id' => 157,
                ),
            2553 =>
                array (
                    'id' => 2601,
                    'name' => 'Nord',
                    'country_id' => 157,
                ),
            2554 =>
                array (
                    'id' => 2602,
                    'name' => 'Sud',
                    'country_id' => 157,
                ),
            2555 =>
                array (
                    'id' => 2603,
                    'name' => 'Area Outside Region',
                    'country_id' => 158,
                ),
            2556 =>
                array (
                    'id' => 2604,
                    'name' => 'Auckland',
                    'country_id' => 158,
                ),
            2557 =>
                array (
                    'id' => 2605,
                    'name' => 'Bay of Plenty',
                    'country_id' => 158,
                ),
            2558 =>
                array (
                    'id' => 2606,
                    'name' => 'Canterbury',
                    'country_id' => 158,
                ),
            2559 =>
                array (
                    'id' => 2607,
                    'name' => 'Christchurch',
                    'country_id' => 158,
                ),
            2560 =>
                array (
                    'id' => 2608,
                    'name' => 'Gisborne',
                    'country_id' => 158,
                ),
            2561 =>
                array (
                    'id' => 2609,
                    'name' => 'Hawke\'s Bay',
                    'country_id' => 158,
                ),
            2562 =>
                array (
                    'id' => 2610,
                    'name' => 'Manawatu-Wanganui',
                    'country_id' => 158,
                ),
            2563 =>
                array (
                    'id' => 2611,
                    'name' => 'Marlborough',
                    'country_id' => 158,
                ),
            2564 =>
                array (
                    'id' => 2612,
                    'name' => 'Nelson',
                    'country_id' => 158,
                ),
            2565 =>
                array (
                    'id' => 2613,
                    'name' => 'Northland',
                    'country_id' => 158,
                ),
            2566 =>
                array (
                    'id' => 2614,
                    'name' => 'Otago',
                    'country_id' => 158,
                ),
            2567 =>
                array (
                    'id' => 2615,
                    'name' => 'Rodney',
                    'country_id' => 158,
                ),
            2568 =>
                array (
                    'id' => 2616,
                    'name' => 'Southland',
                    'country_id' => 158,
                ),
            2569 =>
                array (
                    'id' => 2617,
                    'name' => 'Taranaki',
                    'country_id' => 158,
                ),
            2570 =>
                array (
                    'id' => 2618,
                    'name' => 'Tasman',
                    'country_id' => 158,
                ),
            2571 =>
                array (
                    'id' => 2619,
                    'name' => 'Waikato',
                    'country_id' => 158,
                ),
            2572 =>
                array (
                    'id' => 2620,
                    'name' => 'Wellington',
                    'country_id' => 158,
                ),
            2573 =>
                array (
                    'id' => 2621,
                    'name' => 'West Coast',
                    'country_id' => 158,
                ),
            2574 =>
                array (
                    'id' => 2622,
                    'name' => 'Atlantico Norte',
                    'country_id' => 159,
                ),
            2575 =>
                array (
                    'id' => 2623,
                    'name' => 'Atlantico Sur',
                    'country_id' => 159,
                ),
            2576 =>
                array (
                    'id' => 2624,
                    'name' => 'Boaco',
                    'country_id' => 159,
                ),
            2577 =>
                array (
                    'id' => 2625,
                    'name' => 'Carazo',
                    'country_id' => 159,
                ),
            2578 =>
                array (
                    'id' => 2626,
                    'name' => 'Chinandega',
                    'country_id' => 159,
                ),
            2579 =>
                array (
                    'id' => 2627,
                    'name' => 'Chontales',
                    'country_id' => 159,
                ),
            2580 =>
                array (
                    'id' => 2628,
                    'name' => 'Esteli',
                    'country_id' => 159,
                ),
            2581 =>
                array (
                    'id' => 2629,
                    'name' => 'Granada',
                    'country_id' => 159,
                ),
            2582 =>
                array (
                    'id' => 2630,
                    'name' => 'Jinotega',
                    'country_id' => 159,
                ),
            2583 =>
                array (
                    'id' => 2631,
                    'name' => 'Leon',
                    'country_id' => 159,
                ),
            2584 =>
                array (
                    'id' => 2632,
                    'name' => 'Madriz',
                    'country_id' => 159,
                ),
            2585 =>
                array (
                    'id' => 2633,
                    'name' => 'Managua',
                    'country_id' => 159,
                ),
            2586 =>
                array (
                    'id' => 2634,
                    'name' => 'Masaya',
                    'country_id' => 159,
                ),
            2587 =>
                array (
                    'id' => 2635,
                    'name' => 'Matagalpa',
                    'country_id' => 159,
                ),
            2588 =>
                array (
                    'id' => 2636,
                    'name' => 'Nueva Segovia',
                    'country_id' => 159,
                ),
            2589 =>
                array (
                    'id' => 2637,
                    'name' => 'Rio San Juan',
                    'country_id' => 159,
                ),
            2590 =>
                array (
                    'id' => 2638,
                    'name' => 'Rivas',
                    'country_id' => 159,
                ),
            2591 =>
                array (
                    'id' => 2639,
                    'name' => 'Agadez',
                    'country_id' => 160,
                ),
            2592 =>
                array (
                    'id' => 2640,
                    'name' => 'Diffa',
                    'country_id' => 160,
                ),
            2593 =>
                array (
                    'id' => 2641,
                    'name' => 'Dosso',
                    'country_id' => 160,
                ),
            2594 =>
                array (
                    'id' => 2642,
                    'name' => 'Maradi',
                    'country_id' => 160,
                ),
            2595 =>
                array (
                    'id' => 2643,
                    'name' => 'Niamey',
                    'country_id' => 160,
                ),
            2596 =>
                array (
                    'id' => 2644,
                    'name' => 'Tahoua',
                    'country_id' => 160,
                ),
            2597 =>
                array (
                    'id' => 2645,
                    'name' => 'Tillabery',
                    'country_id' => 160,
                ),
            2598 =>
                array (
                    'id' => 2646,
                    'name' => 'Zinder',
                    'country_id' => 160,
                ),
            2599 =>
                array (
                    'id' => 2647,
                    'name' => 'Abia',
                    'country_id' => 161,
                ),
            2600 =>
                array (
                    'id' => 2648,
                    'name' => 'Abuja Federal Capital Territor',
                    'country_id' => 161,
                ),
            2601 =>
                array (
                    'id' => 2649,
                    'name' => 'Adamawa',
                    'country_id' => 161,
                ),
            2602 =>
                array (
                    'id' => 2650,
                    'name' => 'Akwa Ibom',
                    'country_id' => 161,
                ),
            2603 =>
                array (
                    'id' => 2651,
                    'name' => 'Anambra',
                    'country_id' => 161,
                ),
            2604 =>
                array (
                    'id' => 2652,
                    'name' => 'Bauchi',
                    'country_id' => 161,
                ),
            2605 =>
                array (
                    'id' => 2653,
                    'name' => 'Bayelsa',
                    'country_id' => 161,
                ),
            2606 =>
                array (
                    'id' => 2654,
                    'name' => 'Benue',
                    'country_id' => 161,
                ),
            2607 =>
                array (
                    'id' => 2655,
                    'name' => 'Borno',
                    'country_id' => 161,
                ),
            2608 =>
                array (
                    'id' => 2656,
                    'name' => 'Cross River',
                    'country_id' => 161,
                ),
            2609 =>
                array (
                    'id' => 2657,
                    'name' => 'Delta',
                    'country_id' => 161,
                ),
            2610 =>
                array (
                    'id' => 2658,
                    'name' => 'Ebonyi',
                    'country_id' => 161,
                ),
            2611 =>
                array (
                    'id' => 2659,
                    'name' => 'Edo',
                    'country_id' => 161,
                ),
            2612 =>
                array (
                    'id' => 2660,
                    'name' => 'Ekiti',
                    'country_id' => 161,
                ),
            2613 =>
                array (
                    'id' => 2661,
                    'name' => 'Enugu',
                    'country_id' => 161,
                ),
            2614 =>
                array (
                    'id' => 2662,
                    'name' => 'Gombe',
                    'country_id' => 161,
                ),
            2615 =>
                array (
                    'id' => 2663,
                    'name' => 'Imo',
                    'country_id' => 161,
                ),
            2616 =>
                array (
                    'id' => 2664,
                    'name' => 'Jigawa',
                    'country_id' => 161,
                ),
            2617 =>
                array (
                    'id' => 2665,
                    'name' => 'Kaduna',
                    'country_id' => 161,
                ),
            2618 =>
                array (
                    'id' => 2666,
                    'name' => 'Kano',
                    'country_id' => 161,
                ),
            2619 =>
                array (
                    'id' => 2667,
                    'name' => 'Katsina',
                    'country_id' => 161,
                ),
            2620 =>
                array (
                    'id' => 2668,
                    'name' => 'Kebbi',
                    'country_id' => 161,
                ),
            2621 =>
                array (
                    'id' => 2669,
                    'name' => 'Kogi',
                    'country_id' => 161,
                ),
            2622 =>
                array (
                    'id' => 2670,
                    'name' => 'Kwara',
                    'country_id' => 161,
                ),
            2623 =>
                array (
                    'id' => 2671,
                    'name' => 'Lagos',
                    'country_id' => 161,
                ),
            2624 =>
                array (
                    'id' => 2672,
                    'name' => 'Nassarawa',
                    'country_id' => 161,
                ),
            2625 =>
                array (
                    'id' => 2673,
                    'name' => 'Niger',
                    'country_id' => 161,
                ),
            2626 =>
                array (
                    'id' => 2674,
                    'name' => 'Ogun',
                    'country_id' => 161,
                ),
            2627 =>
                array (
                    'id' => 2675,
                    'name' => 'Ondo',
                    'country_id' => 161,
                ),
            2628 =>
                array (
                    'id' => 2676,
                    'name' => 'Osun',
                    'country_id' => 161,
                ),
            2629 =>
                array (
                    'id' => 2677,
                    'name' => 'Oyo',
                    'country_id' => 161,
                ),
            2630 =>
                array (
                    'id' => 2678,
                    'name' => 'Plateau',
                    'country_id' => 161,
                ),
            2631 =>
                array (
                    'id' => 2679,
                    'name' => 'Rivers',
                    'country_id' => 161,
                ),
            2632 =>
                array (
                    'id' => 2680,
                    'name' => 'Sokoto',
                    'country_id' => 161,
                ),
            2633 =>
                array (
                    'id' => 2681,
                    'name' => 'Taraba',
                    'country_id' => 161,
                ),
            2634 =>
                array (
                    'id' => 2682,
                    'name' => 'Yobe',
                    'country_id' => 161,
                ),
            2635 =>
                array (
                    'id' => 2683,
                    'name' => 'Zamfara',
                    'country_id' => 161,
                ),
            2636 =>
                array (
                    'id' => 2684,
                    'name' => 'Niue',
                    'country_id' => 162,
                ),
            2637 =>
                array (
                    'id' => 2685,
                    'name' => 'Norfolk Island',
                    'country_id' => 163,
                ),
            2638 =>
                array (
                    'id' => 2686,
                    'name' => 'Northern Islands',
                    'country_id' => 164,
                ),
            2639 =>
                array (
                    'id' => 2687,
                    'name' => 'Rota',
                    'country_id' => 164,
                ),
            2640 =>
                array (
                    'id' => 2688,
                    'name' => 'Saipan',
                    'country_id' => 164,
                ),
            2641 =>
                array (
                    'id' => 2689,
                    'name' => 'Tinian',
                    'country_id' => 164,
                ),
            2642 =>
                array (
                    'id' => 2690,
                    'name' => 'Akershus',
                    'country_id' => 165,
                ),
            2643 =>
                array (
                    'id' => 2691,
                    'name' => 'Aust Agder',
                    'country_id' => 165,
                ),
            2644 =>
                array (
                    'id' => 2692,
                    'name' => 'Bergen',
                    'country_id' => 165,
                ),
            2645 =>
                array (
                    'id' => 2693,
                    'name' => 'Buskerud',
                    'country_id' => 165,
                ),
            2646 =>
                array (
                    'id' => 2694,
                    'name' => 'Finnmark',
                    'country_id' => 165,
                ),
            2647 =>
                array (
                    'id' => 2695,
                    'name' => 'Hedmark',
                    'country_id' => 165,
                ),
            2648 =>
                array (
                    'id' => 2696,
                    'name' => 'Hordaland',
                    'country_id' => 165,
                ),
            2649 =>
                array (
                    'id' => 2697,
                    'name' => 'Moere og Romsdal',
                    'country_id' => 165,
                ),
            2650 =>
                array (
                    'id' => 2698,
                    'name' => 'Nord Trondelag',
                    'country_id' => 165,
                ),
            2651 =>
                array (
                    'id' => 2699,
                    'name' => 'Nordland',
                    'country_id' => 165,
                ),
            2652 =>
                array (
                    'id' => 2700,
                    'name' => 'Oestfold',
                    'country_id' => 165,
                ),
            2653 =>
                array (
                    'id' => 2701,
                    'name' => 'Oppland',
                    'country_id' => 165,
                ),
            2654 =>
                array (
                    'id' => 2702,
                    'name' => 'Oslo',
                    'country_id' => 165,
                ),
            2655 =>
                array (
                    'id' => 2703,
                    'name' => 'Rogaland',
                    'country_id' => 165,
                ),
            2656 =>
                array (
                    'id' => 2704,
                    'name' => 'Soer Troendelag',
                    'country_id' => 165,
                ),
            2657 =>
                array (
                    'id' => 2705,
                    'name' => 'Sogn og Fjordane',
                    'country_id' => 165,
                ),
            2658 =>
                array (
                    'id' => 2706,
                    'name' => 'Stavern',
                    'country_id' => 165,
                ),
            2659 =>
                array (
                    'id' => 2707,
                    'name' => 'Sykkylven',
                    'country_id' => 165,
                ),
            2660 =>
                array (
                    'id' => 2708,
                    'name' => 'Telemark',
                    'country_id' => 165,
                ),
            2661 =>
                array (
                    'id' => 2709,
                    'name' => 'Troms',
                    'country_id' => 165,
                ),
            2662 =>
                array (
                    'id' => 2710,
                    'name' => 'Vest Agder',
                    'country_id' => 165,
                ),
            2663 =>
                array (
                    'id' => 2711,
                    'name' => 'Vestfold',
                    'country_id' => 165,
                ),
            2664 =>
                array (
                    'id' => 2712,
                    'name' => 'ÃƒÂ˜stfold',
                    'country_id' => 165,
                ),
            2665 =>
                array (
                    'id' => 2713,
                    'name' => 'Al Buraimi',
                    'country_id' => 166,
                ),
            2666 =>
                array (
                    'id' => 2714,
                    'name' => 'Dhufar',
                    'country_id' => 166,
                ),
            2667 =>
                array (
                    'id' => 2715,
                    'name' => 'Masqat',
                    'country_id' => 166,
                ),
            2668 =>
                array (
                    'id' => 2716,
                    'name' => 'Musandam',
                    'country_id' => 166,
                ),
            2669 =>
                array (
                    'id' => 2717,
                    'name' => 'Rusayl',
                    'country_id' => 166,
                ),
            2670 =>
                array (
                    'id' => 2718,
                    'name' => 'Wadi Kabir',
                    'country_id' => 166,
                ),
            2671 =>
                array (
                    'id' => 2719,
                    'name' => 'ad-Dakhiliyah',
                    'country_id' => 166,
                ),
            2672 =>
                array (
                    'id' => 2720,
                    'name' => 'adh-Dhahirah',
                    'country_id' => 166,
                ),
            2673 =>
                array (
                    'id' => 2721,
                    'name' => 'al-Batinah',
                    'country_id' => 166,
                ),
            2674 =>
                array (
                    'id' => 2722,
                    'name' => 'ash-Sharqiyah',
                    'country_id' => 166,
                ),
            2675 =>
                array (
                    'id' => 2723,
                    'name' => 'Azad kashmir',
                    'country_id' => 167,
                ),
            2676 =>
                array (
                    'id' => 2724,
                    'name' => 'Balochistan',
                    'country_id' => 167,
                ),
            2677 =>
                array (
                    'id' => 2725,
                    'name' => 'Fata',
                    'country_id' => 167,
                ),
            2678 =>
                array (
                    'id' => 2726,
                    'name' => 'Gilgit–baltistan',
                    'country_id' => 167,
                ),
            2679 =>
                array (
                    'id' => 2727,
                    'name' => 'Islamabad capital territory',
                    'country_id' => 167,
                ),
            2680 =>
                array (
                    'id' => 2728,
                    'name' => 'Khyber Pakhtunkhwa',
                    'country_id' => 167,
                ),
            2681 =>
                array (
                    'id' => 2729,
                    'name' => 'Punjab',
                    'country_id' => 167,
                ),
            2682 =>
                array (
                    'id' => 2730,
                    'name' => 'Sindh',
                    'country_id' => 167,
                ),
            2683 =>
                array (
                    'id' => 2731,
                    'name' => 'Aimeliik',
                    'country_id' => 168,
                ),
            2684 =>
                array (
                    'id' => 2732,
                    'name' => 'Airai',
                    'country_id' => 168,
                ),
            2685 =>
                array (
                    'id' => 2733,
                    'name' => 'Angaur',
                    'country_id' => 168,
                ),
            2686 =>
                array (
                    'id' => 2734,
                    'name' => 'Hatobohei',
                    'country_id' => 168,
                ),
            2687 =>
                array (
                    'id' => 2735,
                    'name' => 'Kayangel',
                    'country_id' => 168,
                ),
            2688 =>
                array (
                    'id' => 2736,
                    'name' => 'Koror',
                    'country_id' => 168,
                ),
            2689 =>
                array (
                    'id' => 2737,
                    'name' => 'Melekeok',
                    'country_id' => 168,
                ),
            2690 =>
                array (
                    'id' => 2738,
                    'name' => 'Ngaraard',
                    'country_id' => 168,
                ),
            2691 =>
                array (
                    'id' => 2739,
                    'name' => 'Ngardmau',
                    'country_id' => 168,
                ),
            2692 =>
                array (
                    'id' => 2740,
                    'name' => 'Ngaremlengui',
                    'country_id' => 168,
                ),
            2693 =>
                array (
                    'id' => 2741,
                    'name' => 'Ngatpang',
                    'country_id' => 168,
                ),
            2694 =>
                array (
                    'id' => 2742,
                    'name' => 'Ngchesar',
                    'country_id' => 168,
                ),
            2695 =>
                array (
                    'id' => 2743,
                    'name' => 'Ngerchelong',
                    'country_id' => 168,
                ),
            2696 =>
                array (
                    'id' => 2744,
                    'name' => 'Ngiwal',
                    'country_id' => 168,
                ),
            2697 =>
                array (
                    'id' => 2745,
                    'name' => 'Peleliu',
                    'country_id' => 168,
                ),
            2698 =>
                array (
                    'id' => 2746,
                    'name' => 'Sonsorol',
                    'country_id' => 168,
                ),
            2699 =>
                array (
                    'id' => 2747,
                    'name' => 'Ariha',
                    'country_id' => 169,
                ),
            2700 =>
                array (
                    'id' => 2748,
                    'name' => 'Bayt Lahm',
                    'country_id' => 169,
                ),
            2701 =>
                array (
                    'id' => 2749,
                    'name' => 'Bethlehem',
                    'country_id' => 169,
                ),
            2702 =>
                array (
                    'id' => 2750,
                    'name' => 'Dayr-al-Balah',
                    'country_id' => 169,
                ),
            2703 =>
                array (
                    'id' => 2751,
                    'name' => 'Ghazzah',
                    'country_id' => 169,
                ),
            2704 =>
                array (
                    'id' => 2752,
                    'name' => 'Ghazzah ash-Shamaliyah',
                    'country_id' => 169,
                ),
            2705 =>
                array (
                    'id' => 2753,
                    'name' => 'Janin',
                    'country_id' => 169,
                ),
            2706 =>
                array (
                    'id' => 2754,
                    'name' => 'Khan Yunis',
                    'country_id' => 169,
                ),
            2707 =>
                array (
                    'id' => 2755,
                    'name' => 'Nabulus',
                    'country_id' => 169,
                ),
            2708 =>
                array (
                    'id' => 2756,
                    'name' => 'Qalqilyah',
                    'country_id' => 169,
                ),
            2709 =>
                array (
                    'id' => 2757,
                    'name' => 'Rafah',
                    'country_id' => 169,
                ),
            2710 =>
                array (
                    'id' => 2758,
                    'name' => 'Ram Allah wal-Birah',
                    'country_id' => 169,
                ),
            2711 =>
                array (
                    'id' => 2759,
                    'name' => 'Salfit',
                    'country_id' => 169,
                ),
            2712 =>
                array (
                    'id' => 2760,
                    'name' => 'Tubas',
                    'country_id' => 169,
                ),
            2713 =>
                array (
                    'id' => 2761,
                    'name' => 'Tulkarm',
                    'country_id' => 169,
                ),
            2714 =>
                array (
                    'id' => 2762,
                    'name' => 'al-Khalil',
                    'country_id' => 169,
                ),
            2715 =>
                array (
                    'id' => 2763,
                    'name' => 'al-Quds',
                    'country_id' => 169,
                ),
            2716 =>
                array (
                    'id' => 2764,
                    'name' => 'Bocas del Toro',
                    'country_id' => 170,
                ),
            2717 =>
                array (
                    'id' => 2765,
                    'name' => 'Chiriqui',
                    'country_id' => 170,
                ),
            2718 =>
                array (
                    'id' => 2766,
                    'name' => 'Cocle',
                    'country_id' => 170,
                ),
            2719 =>
                array (
                    'id' => 2767,
                    'name' => 'Colon',
                    'country_id' => 170,
                ),
            2720 =>
                array (
                    'id' => 2768,
                    'name' => 'Darien',
                    'country_id' => 170,
                ),
            2721 =>
                array (
                    'id' => 2769,
                    'name' => 'Embera',
                    'country_id' => 170,
                ),
            2722 =>
                array (
                    'id' => 2770,
                    'name' => 'Herrera',
                    'country_id' => 170,
                ),
            2723 =>
                array (
                    'id' => 2771,
                    'name' => 'Kuna Yala',
                    'country_id' => 170,
                ),
            2724 =>
                array (
                    'id' => 2772,
                    'name' => 'Los Santos',
                    'country_id' => 170,
                ),
            2725 =>
                array (
                    'id' => 2773,
                    'name' => 'Ngobe Bugle',
                    'country_id' => 170,
                ),
            2726 =>
                array (
                    'id' => 2774,
                    'name' => 'Panama',
                    'country_id' => 170,
                ),
            2727 =>
                array (
                    'id' => 2775,
                    'name' => 'Veraguas',
                    'country_id' => 170,
                ),
            2728 =>
                array (
                    'id' => 2776,
                    'name' => 'East New Britain',
                    'country_id' => 171,
                ),
            2729 =>
                array (
                    'id' => 2777,
                    'name' => 'East Sepik',
                    'country_id' => 171,
                ),
            2730 =>
                array (
                    'id' => 2778,
                    'name' => 'Eastern Highlands',
                    'country_id' => 171,
                ),
            2731 =>
                array (
                    'id' => 2779,
                    'name' => 'Enga',
                    'country_id' => 171,
                ),
            2732 =>
                array (
                    'id' => 2780,
                    'name' => 'Fly River',
                    'country_id' => 171,
                ),
            2733 =>
                array (
                    'id' => 2781,
                    'name' => 'Gulf',
                    'country_id' => 171,
                ),
            2734 =>
                array (
                    'id' => 2782,
                    'name' => 'Madang',
                    'country_id' => 171,
                ),
            2735 =>
                array (
                    'id' => 2783,
                    'name' => 'Manus',
                    'country_id' => 171,
                ),
            2736 =>
                array (
                    'id' => 2784,
                    'name' => 'Milne Bay',
                    'country_id' => 171,
                ),
            2737 =>
                array (
                    'id' => 2785,
                    'name' => 'Morobe',
                    'country_id' => 171,
                ),
            2738 =>
                array (
                    'id' => 2786,
                    'name' => 'National Capital District',
                    'country_id' => 171,
                ),
            2739 =>
                array (
                    'id' => 2787,
                    'name' => 'New Ireland',
                    'country_id' => 171,
                ),
            2740 =>
                array (
                    'id' => 2788,
                    'name' => 'North Solomons',
                    'country_id' => 171,
                ),
            2741 =>
                array (
                    'id' => 2789,
                    'name' => 'Oro',
                    'country_id' => 171,
                ),
            2742 =>
                array (
                    'id' => 2790,
                    'name' => 'Sandaun',
                    'country_id' => 171,
                ),
            2743 =>
                array (
                    'id' => 2791,
                    'name' => 'Simbu',
                    'country_id' => 171,
                ),
            2744 =>
                array (
                    'id' => 2792,
                    'name' => 'Southern Highlands',
                    'country_id' => 171,
                ),
            2745 =>
                array (
                    'id' => 2793,
                    'name' => 'West New Britain',
                    'country_id' => 171,
                ),
            2746 =>
                array (
                    'id' => 2794,
                    'name' => 'Western Highlands',
                    'country_id' => 171,
                ),
            2747 =>
                array (
                    'id' => 2795,
                    'name' => 'Alto Paraguay',
                    'country_id' => 172,
                ),
            2748 =>
                array (
                    'id' => 2796,
                    'name' => 'Alto Parana',
                    'country_id' => 172,
                ),
            2749 =>
                array (
                    'id' => 2797,
                    'name' => 'Amambay',
                    'country_id' => 172,
                ),
            2750 =>
                array (
                    'id' => 2798,
                    'name' => 'Asuncion',
                    'country_id' => 172,
                ),
            2751 =>
                array (
                    'id' => 2799,
                    'name' => 'Boqueron',
                    'country_id' => 172,
                ),
            2752 =>
                array (
                    'id' => 2800,
                    'name' => 'Caaguazu',
                    'country_id' => 172,
                ),
            2753 =>
                array (
                    'id' => 2801,
                    'name' => 'Caazapa',
                    'country_id' => 172,
                ),
            2754 =>
                array (
                    'id' => 2802,
                    'name' => 'Canendiyu',
                    'country_id' => 172,
                ),
            2755 =>
                array (
                    'id' => 2803,
                    'name' => 'Central',
                    'country_id' => 172,
                ),
            2756 =>
                array (
                    'id' => 2804,
                    'name' => 'Concepcion',
                    'country_id' => 172,
                ),
            2757 =>
                array (
                    'id' => 2805,
                    'name' => 'Cordillera',
                    'country_id' => 172,
                ),
            2758 =>
                array (
                    'id' => 2806,
                    'name' => 'Guaira',
                    'country_id' => 172,
                ),
            2759 =>
                array (
                    'id' => 2807,
                    'name' => 'Itapua',
                    'country_id' => 172,
                ),
            2760 =>
                array (
                    'id' => 2808,
                    'name' => 'Misiones',
                    'country_id' => 172,
                ),
            2761 =>
                array (
                    'id' => 2809,
                    'name' => 'Neembucu',
                    'country_id' => 172,
                ),
            2762 =>
                array (
                    'id' => 2810,
                    'name' => 'Paraguari',
                    'country_id' => 172,
                ),
            2763 =>
                array (
                    'id' => 2811,
                    'name' => 'Presidente Hayes',
                    'country_id' => 172,
                ),
            2764 =>
                array (
                    'id' => 2812,
                    'name' => 'San Pedro',
                    'country_id' => 172,
                ),
            2765 =>
                array (
                    'id' => 2813,
                    'name' => 'Amazonas',
                    'country_id' => 173,
                ),
            2766 =>
                array (
                    'id' => 2814,
                    'name' => 'Ancash',
                    'country_id' => 173,
                ),
            2767 =>
                array (
                    'id' => 2815,
                    'name' => 'Apurimac',
                    'country_id' => 173,
                ),
            2768 =>
                array (
                    'id' => 2816,
                    'name' => 'Arequipa',
                    'country_id' => 173,
                ),
            2769 =>
                array (
                    'id' => 2817,
                    'name' => 'Ayacucho',
                    'country_id' => 173,
                ),
            2770 =>
                array (
                    'id' => 2818,
                    'name' => 'Cajamarca',
                    'country_id' => 173,
                ),
            2771 =>
                array (
                    'id' => 2819,
                    'name' => 'Cusco',
                    'country_id' => 173,
                ),
            2772 =>
                array (
                    'id' => 2820,
                    'name' => 'Huancavelica',
                    'country_id' => 173,
                ),
            2773 =>
                array (
                    'id' => 2821,
                    'name' => 'Huanuco',
                    'country_id' => 173,
                ),
            2774 =>
                array (
                    'id' => 2822,
                    'name' => 'Ica',
                    'country_id' => 173,
                ),
            2775 =>
                array (
                    'id' => 2823,
                    'name' => 'Junin',
                    'country_id' => 173,
                ),
            2776 =>
                array (
                    'id' => 2824,
                    'name' => 'La Libertad',
                    'country_id' => 173,
                ),
            2777 =>
                array (
                    'id' => 2825,
                    'name' => 'Lambayeque',
                    'country_id' => 173,
                ),
            2778 =>
                array (
                    'id' => 2826,
                    'name' => 'Lima y Callao',
                    'country_id' => 173,
                ),
            2779 =>
                array (
                    'id' => 2827,
                    'name' => 'Loreto',
                    'country_id' => 173,
                ),
            2780 =>
                array (
                    'id' => 2828,
                    'name' => 'Madre de Dios',
                    'country_id' => 173,
                ),
            2781 =>
                array (
                    'id' => 2829,
                    'name' => 'Moquegua',
                    'country_id' => 173,
                ),
            2782 =>
                array (
                    'id' => 2830,
                    'name' => 'Pasco',
                    'country_id' => 173,
                ),
            2783 =>
                array (
                    'id' => 2831,
                    'name' => 'Piura',
                    'country_id' => 173,
                ),
            2784 =>
                array (
                    'id' => 2832,
                    'name' => 'Puno',
                    'country_id' => 173,
                ),
            2785 =>
                array (
                    'id' => 2833,
                    'name' => 'San Martin',
                    'country_id' => 173,
                ),
            2786 =>
                array (
                    'id' => 2834,
                    'name' => 'Tacna',
                    'country_id' => 173,
                ),
            2787 =>
                array (
                    'id' => 2835,
                    'name' => 'Tumbes',
                    'country_id' => 173,
                ),
            2788 =>
                array (
                    'id' => 2836,
                    'name' => 'Ucayali',
                    'country_id' => 173,
                ),
            2789 =>
                array (
                    'id' => 2837,
                    'name' => 'Batangas',
                    'country_id' => 174,
                ),
            2790 =>
                array (
                    'id' => 2838,
                    'name' => 'Bicol',
                    'country_id' => 174,
                ),
            2791 =>
                array (
                    'id' => 2839,
                    'name' => 'Bulacan',
                    'country_id' => 174,
                ),
            2792 =>
                array (
                    'id' => 2840,
                    'name' => 'Cagayan',
                    'country_id' => 174,
                ),
            2793 =>
                array (
                    'id' => 2841,
                    'name' => 'Caraga',
                    'country_id' => 174,
                ),
            2794 =>
                array (
                    'id' => 2842,
                    'name' => 'Central Luzon',
                    'country_id' => 174,
                ),
            2795 =>
                array (
                    'id' => 2843,
                    'name' => 'Central Mindanao',
                    'country_id' => 174,
                ),
            2796 =>
                array (
                    'id' => 2844,
                    'name' => 'Central Visayas',
                    'country_id' => 174,
                ),
            2797 =>
                array (
                    'id' => 2845,
                    'name' => 'Cordillera',
                    'country_id' => 174,
                ),
            2798 =>
                array (
                    'id' => 2846,
                    'name' => 'Davao',
                    'country_id' => 174,
                ),
            2799 =>
                array (
                    'id' => 2847,
                    'name' => 'Eastern Visayas',
                    'country_id' => 174,
                ),
            2800 =>
                array (
                    'id' => 2848,
                    'name' => 'Greater Metropolitan Area',
                    'country_id' => 174,
                ),
            2801 =>
                array (
                    'id' => 2849,
                    'name' => 'Ilocos',
                    'country_id' => 174,
                ),
            2802 =>
                array (
                    'id' => 2850,
                    'name' => 'Laguna',
                    'country_id' => 174,
                ),
            2803 =>
                array (
                    'id' => 2851,
                    'name' => 'Luzon',
                    'country_id' => 174,
                ),
            2804 =>
                array (
                    'id' => 2852,
                    'name' => 'Mactan',
                    'country_id' => 174,
                ),
            2805 =>
                array (
                    'id' => 2853,
                    'name' => 'Metropolitan Manila Area',
                    'country_id' => 174,
                ),
            2806 =>
                array (
                    'id' => 2854,
                    'name' => 'Muslim Mindanao',
                    'country_id' => 174,
                ),
            2807 =>
                array (
                    'id' => 2855,
                    'name' => 'Northern Mindanao',
                    'country_id' => 174,
                ),
            2808 =>
                array (
                    'id' => 2856,
                    'name' => 'Southern Mindanao',
                    'country_id' => 174,
                ),
            2809 =>
                array (
                    'id' => 2857,
                    'name' => 'Southern Tagalog',
                    'country_id' => 174,
                ),
            2810 =>
                array (
                    'id' => 2858,
                    'name' => 'Western Mindanao',
                    'country_id' => 174,
                ),
            2811 =>
                array (
                    'id' => 2859,
                    'name' => 'Western Visayas',
                    'country_id' => 174,
                ),
            2812 =>
                array (
                    'id' => 2860,
                    'name' => 'Pitcairn Island',
                    'country_id' => 175,
                ),
            2813 =>
                array (
                    'id' => 2861,
                    'name' => 'Biale Blota',
                    'country_id' => 176,
                ),
            2814 =>
                array (
                    'id' => 2862,
                    'name' => 'Dobroszyce',
                    'country_id' => 176,
                ),
            2815 =>
                array (
                    'id' => 2863,
                    'name' => 'Dolnoslaskie',
                    'country_id' => 176,
                ),
            2816 =>
                array (
                    'id' => 2864,
                    'name' => 'Dziekanow Lesny',
                    'country_id' => 176,
                ),
            2817 =>
                array (
                    'id' => 2865,
                    'name' => 'Hopowo',
                    'country_id' => 176,
                ),
            2818 =>
                array (
                    'id' => 2866,
                    'name' => 'Kartuzy',
                    'country_id' => 176,
                ),
            2819 =>
                array (
                    'id' => 2867,
                    'name' => 'Koscian',
                    'country_id' => 176,
                ),
            2820 =>
                array (
                    'id' => 2868,
                    'name' => 'Krakow',
                    'country_id' => 176,
                ),
            2821 =>
                array (
                    'id' => 2869,
                    'name' => 'Kujawsko-Pomorskie',
                    'country_id' => 176,
                ),
            2822 =>
                array (
                    'id' => 2870,
                    'name' => 'Lodzkie',
                    'country_id' => 176,
                ),
            2823 =>
                array (
                    'id' => 2871,
                    'name' => 'Lubelskie',
                    'country_id' => 176,
                ),
            2824 =>
                array (
                    'id' => 2872,
                    'name' => 'Lubuskie',
                    'country_id' => 176,
                ),
            2825 =>
                array (
                    'id' => 2873,
                    'name' => 'Malomice',
                    'country_id' => 176,
                ),
            2826 =>
                array (
                    'id' => 2874,
                    'name' => 'Malopolskie',
                    'country_id' => 176,
                ),
            2827 =>
                array (
                    'id' => 2875,
                    'name' => 'Mazowieckie',
                    'country_id' => 176,
                ),
            2828 =>
                array (
                    'id' => 2876,
                    'name' => 'Mirkow',
                    'country_id' => 176,
                ),
            2829 =>
                array (
                    'id' => 2877,
                    'name' => 'Opolskie',
                    'country_id' => 176,
                ),
            2830 =>
                array (
                    'id' => 2878,
                    'name' => 'Ostrowiec',
                    'country_id' => 176,
                ),
            2831 =>
                array (
                    'id' => 2879,
                    'name' => 'Podkarpackie',
                    'country_id' => 176,
                ),
            2832 =>
                array (
                    'id' => 2880,
                    'name' => 'Podlaskie',
                    'country_id' => 176,
                ),
            2833 =>
                array (
                    'id' => 2881,
                    'name' => 'Polska',
                    'country_id' => 176,
                ),
            2834 =>
                array (
                    'id' => 2882,
                    'name' => 'Pomorskie',
                    'country_id' => 176,
                ),
            2835 =>
                array (
                    'id' => 2883,
                    'name' => 'Poznan',
                    'country_id' => 176,
                ),
            2836 =>
                array (
                    'id' => 2884,
                    'name' => 'Pruszkow',
                    'country_id' => 176,
                ),
            2837 =>
                array (
                    'id' => 2885,
                    'name' => 'Rymanowska',
                    'country_id' => 176,
                ),
            2838 =>
                array (
                    'id' => 2886,
                    'name' => 'Rzeszow',
                    'country_id' => 176,
                ),
            2839 =>
                array (
                    'id' => 2887,
                    'name' => 'Slaskie',
                    'country_id' => 176,
                ),
            2840 =>
                array (
                    'id' => 2888,
                    'name' => 'Stare Pole',
                    'country_id' => 176,
                ),
            2841 =>
                array (
                    'id' => 2889,
                    'name' => 'Swietokrzyskie',
                    'country_id' => 176,
                ),
            2842 =>
                array (
                    'id' => 2890,
                    'name' => 'Warminsko-Mazurskie',
                    'country_id' => 176,
                ),
            2843 =>
                array (
                    'id' => 2891,
                    'name' => 'Warsaw',
                    'country_id' => 176,
                ),
            2844 =>
                array (
                    'id' => 2892,
                    'name' => 'Wejherowo',
                    'country_id' => 176,
                ),
            2845 =>
                array (
                    'id' => 2893,
                    'name' => 'Wielkopolskie',
                    'country_id' => 176,
                ),
            2846 =>
                array (
                    'id' => 2894,
                    'name' => 'Wroclaw',
                    'country_id' => 176,
                ),
            2847 =>
                array (
                    'id' => 2895,
                    'name' => 'Zachodnio-Pomorskie',
                    'country_id' => 176,
                ),
            2848 =>
                array (
                    'id' => 2896,
                    'name' => 'Zukowo',
                    'country_id' => 176,
                ),
            2849 =>
                array (
                    'id' => 2897,
                    'name' => 'Abrantes',
                    'country_id' => 177,
                ),
            2850 =>
                array (
                    'id' => 2898,
                    'name' => 'Acores',
                    'country_id' => 177,
                ),
            2851 =>
                array (
                    'id' => 2899,
                    'name' => 'Alentejo',
                    'country_id' => 177,
                ),
            2852 =>
                array (
                    'id' => 2900,
                    'name' => 'Algarve',
                    'country_id' => 177,
                ),
            2853 =>
                array (
                    'id' => 2901,
                    'name' => 'Braga',
                    'country_id' => 177,
                ),
            2854 =>
                array (
                    'id' => 2902,
                    'name' => 'Centro',
                    'country_id' => 177,
                ),
            2855 =>
                array (
                    'id' => 2903,
                    'name' => 'Distrito de Leiria',
                    'country_id' => 177,
                ),
            2856 =>
                array (
                    'id' => 2904,
                    'name' => 'Distrito de Viana do Castelo',
                    'country_id' => 177,
                ),
            2857 =>
                array (
                    'id' => 2905,
                    'name' => 'Distrito de Vila Real',
                    'country_id' => 177,
                ),
            2858 =>
                array (
                    'id' => 2906,
                    'name' => 'Distrito do Porto',
                    'country_id' => 177,
                ),
            2859 =>
                array (
                    'id' => 2907,
                    'name' => 'Lisboa e Vale do Tejo',
                    'country_id' => 177,
                ),
            2860 =>
                array (
                    'id' => 2908,
                    'name' => 'Madeira',
                    'country_id' => 177,
                ),
            2861 =>
                array (
                    'id' => 2909,
                    'name' => 'Norte',
                    'country_id' => 177,
                ),
            2862 =>
                array (
                    'id' => 2910,
                    'name' => 'Paivas',
                    'country_id' => 177,
                ),
            2863 =>
                array (
                    'id' => 2911,
                    'name' => 'Arecibo',
                    'country_id' => 178,
                ),
            2864 =>
                array (
                    'id' => 2912,
                    'name' => 'Bayamon',
                    'country_id' => 178,
                ),
            2865 =>
                array (
                    'id' => 2913,
                    'name' => 'Carolina',
                    'country_id' => 178,
                ),
            2866 =>
                array (
                    'id' => 2914,
                    'name' => 'Florida',
                    'country_id' => 178,
                ),
            2867 =>
                array (
                    'id' => 2915,
                    'name' => 'Guayama',
                    'country_id' => 178,
                ),
            2868 =>
                array (
                    'id' => 2916,
                    'name' => 'Humacao',
                    'country_id' => 178,
                ),
            2869 =>
                array (
                    'id' => 2917,
                    'name' => 'Mayaguez-Aguadilla',
                    'country_id' => 178,
                ),
            2870 =>
                array (
                    'id' => 2918,
                    'name' => 'Ponce',
                    'country_id' => 178,
                ),
            2871 =>
                array (
                    'id' => 2919,
                    'name' => 'Salinas',
                    'country_id' => 178,
                ),
            2872 =>
                array (
                    'id' => 2920,
                    'name' => 'San Juan',
                    'country_id' => 178,
                ),
            2873 =>
                array (
                    'id' => 2921,
                    'name' => 'Doha',
                    'country_id' => 179,
                ),
            2874 =>
                array (
                    'id' => 2922,
                    'name' => 'Jarian-al-Batnah',
                    'country_id' => 179,
                ),
            2875 =>
                array (
                    'id' => 2923,
                    'name' => 'Umm Salal',
                    'country_id' => 179,
                ),
            2876 =>
                array (
                    'id' => 2924,
                    'name' => 'ad-Dawhah',
                    'country_id' => 179,
                ),
            2877 =>
                array (
                    'id' => 2925,
                    'name' => 'al-Ghuwayriyah',
                    'country_id' => 179,
                ),
            2878 =>
                array (
                    'id' => 2926,
                    'name' => 'al-Jumayliyah',
                    'country_id' => 179,
                ),
            2879 =>
                array (
                    'id' => 2927,
                    'name' => 'al-Khawr',
                    'country_id' => 179,
                ),
            2880 =>
                array (
                    'id' => 2928,
                    'name' => 'al-Wakrah',
                    'country_id' => 179,
                ),
            2881 =>
                array (
                    'id' => 2929,
                    'name' => 'ar-Rayyan',
                    'country_id' => 179,
                ),
            2882 =>
                array (
                    'id' => 2930,
                    'name' => 'ash-Shamal',
                    'country_id' => 179,
                ),
            2883 =>
                array (
                    'id' => 2931,
                    'name' => 'Saint-Benoit',
                    'country_id' => 180,
                ),
            2884 =>
                array (
                    'id' => 2932,
                    'name' => 'Saint-Denis',
                    'country_id' => 180,
                ),
            2885 =>
                array (
                    'id' => 2933,
                    'name' => 'Saint-Paul',
                    'country_id' => 180,
                ),
            2886 =>
                array (
                    'id' => 2934,
                    'name' => 'Saint-Pierre',
                    'country_id' => 180,
                ),
            2887 =>
                array (
                    'id' => 2935,
                    'name' => 'Alba',
                    'country_id' => 181,
                ),
            2888 =>
                array (
                    'id' => 2936,
                    'name' => 'Arad',
                    'country_id' => 181,
                ),
            2889 =>
                array (
                    'id' => 2937,
                    'name' => 'Arges',
                    'country_id' => 181,
                ),
            2890 =>
                array (
                    'id' => 2938,
                    'name' => 'Bacau',
                    'country_id' => 181,
                ),
            2891 =>
                array (
                    'id' => 2939,
                    'name' => 'Bihor',
                    'country_id' => 181,
                ),
            2892 =>
                array (
                    'id' => 2940,
                    'name' => 'Bistrita-Nasaud',
                    'country_id' => 181,
                ),
            2893 =>
                array (
                    'id' => 2941,
                    'name' => 'Botosani',
                    'country_id' => 181,
                ),
            2894 =>
                array (
                    'id' => 2942,
                    'name' => 'Braila',
                    'country_id' => 181,
                ),
            2895 =>
                array (
                    'id' => 2943,
                    'name' => 'Brasov',
                    'country_id' => 181,
                ),
            2896 =>
                array (
                    'id' => 2944,
                    'name' => 'Bucuresti',
                    'country_id' => 181,
                ),
            2897 =>
                array (
                    'id' => 2945,
                    'name' => 'Buzau',
                    'country_id' => 181,
                ),
            2898 =>
                array (
                    'id' => 2946,
                    'name' => 'Calarasi',
                    'country_id' => 181,
                ),
            2899 =>
                array (
                    'id' => 2947,
                    'name' => 'Caras-Severin',
                    'country_id' => 181,
                ),
            2900 =>
                array (
                    'id' => 2948,
                    'name' => 'Cluj',
                    'country_id' => 181,
                ),
            2901 =>
                array (
                    'id' => 2949,
                    'name' => 'Constanta',
                    'country_id' => 181,
                ),
            2902 =>
                array (
                    'id' => 2950,
                    'name' => 'Covasna',
                    'country_id' => 181,
                ),
            2903 =>
                array (
                    'id' => 2951,
                    'name' => 'Dambovita',
                    'country_id' => 181,
                ),
            2904 =>
                array (
                    'id' => 2952,
                    'name' => 'Dolj',
                    'country_id' => 181,
                ),
            2905 =>
                array (
                    'id' => 2953,
                    'name' => 'Galati',
                    'country_id' => 181,
                ),
            2906 =>
                array (
                    'id' => 2954,
                    'name' => 'Giurgiu',
                    'country_id' => 181,
                ),
            2907 =>
                array (
                    'id' => 2955,
                    'name' => 'Gorj',
                    'country_id' => 181,
                ),
            2908 =>
                array (
                    'id' => 2956,
                    'name' => 'Harghita',
                    'country_id' => 181,
                ),
            2909 =>
                array (
                    'id' => 2957,
                    'name' => 'Hunedoara',
                    'country_id' => 181,
                ),
            2910 =>
                array (
                    'id' => 2958,
                    'name' => 'Ialomita',
                    'country_id' => 181,
                ),
            2911 =>
                array (
                    'id' => 2959,
                    'name' => 'Iasi',
                    'country_id' => 181,
                ),
            2912 =>
                array (
                    'id' => 2960,
                    'name' => 'Ilfov',
                    'country_id' => 181,
                ),
            2913 =>
                array (
                    'id' => 2961,
                    'name' => 'Maramures',
                    'country_id' => 181,
                ),
            2914 =>
                array (
                    'id' => 2962,
                    'name' => 'Mehedinti',
                    'country_id' => 181,
                ),
            2915 =>
                array (
                    'id' => 2963,
                    'name' => 'Mures',
                    'country_id' => 181,
                ),
            2916 =>
                array (
                    'id' => 2964,
                    'name' => 'Neamt',
                    'country_id' => 181,
                ),
            2917 =>
                array (
                    'id' => 2965,
                    'name' => 'Olt',
                    'country_id' => 181,
                ),
            2918 =>
                array (
                    'id' => 2966,
                    'name' => 'Prahova',
                    'country_id' => 181,
                ),
            2919 =>
                array (
                    'id' => 2967,
                    'name' => 'Salaj',
                    'country_id' => 181,
                ),
            2920 =>
                array (
                    'id' => 2968,
                    'name' => 'Satu Mare',
                    'country_id' => 181,
                ),
            2921 =>
                array (
                    'id' => 2969,
                    'name' => 'Sibiu',
                    'country_id' => 181,
                ),
            2922 =>
                array (
                    'id' => 2970,
                    'name' => 'Sondelor',
                    'country_id' => 181,
                ),
            2923 =>
                array (
                    'id' => 2971,
                    'name' => 'Suceava',
                    'country_id' => 181,
                ),
            2924 =>
                array (
                    'id' => 2972,
                    'name' => 'Teleorman',
                    'country_id' => 181,
                ),
            2925 =>
                array (
                    'id' => 2973,
                    'name' => 'Timis',
                    'country_id' => 181,
                ),
            2926 =>
                array (
                    'id' => 2974,
                    'name' => 'Tulcea',
                    'country_id' => 181,
                ),
            2927 =>
                array (
                    'id' => 2975,
                    'name' => 'Valcea',
                    'country_id' => 181,
                ),
            2928 =>
                array (
                    'id' => 2976,
                    'name' => 'Vaslui',
                    'country_id' => 181,
                ),
            2929 =>
                array (
                    'id' => 2977,
                    'name' => 'Vrancea',
                    'country_id' => 181,
                ),
            2930 =>
                array (
                    'id' => 2978,
                    'name' => 'Adygeja',
                    'country_id' => 182,
                ),
            2931 =>
                array (
                    'id' => 2979,
                    'name' => 'Aga',
                    'country_id' => 182,
                ),
            2932 =>
                array (
                    'id' => 2980,
                    'name' => 'Alanija',
                    'country_id' => 182,
                ),
            2933 =>
                array (
                    'id' => 2981,
                    'name' => 'Altaj',
                    'country_id' => 182,
                ),
            2934 =>
                array (
                    'id' => 2982,
                    'name' => 'Amur',
                    'country_id' => 182,
                ),
            2935 =>
                array (
                    'id' => 2983,
                    'name' => 'Arhangelsk',
                    'country_id' => 182,
                ),
            2936 =>
                array (
                    'id' => 2984,
                    'name' => 'Astrahan',
                    'country_id' => 182,
                ),
            2937 =>
                array (
                    'id' => 2985,
                    'name' => 'Bashkortostan',
                    'country_id' => 182,
                ),
            2938 =>
                array (
                    'id' => 2986,
                    'name' => 'Belgorod',
                    'country_id' => 182,
                ),
            2939 =>
                array (
                    'id' => 2987,
                    'name' => 'Brjansk',
                    'country_id' => 182,
                ),
            2940 =>
                array (
                    'id' => 2988,
                    'name' => 'Burjatija',
                    'country_id' => 182,
                ),
            2941 =>
                array (
                    'id' => 2989,
                    'name' => 'Chechenija',
                    'country_id' => 182,
                ),
            2942 =>
                array (
                    'id' => 2990,
                    'name' => 'Cheljabinsk',
                    'country_id' => 182,
                ),
            2943 =>
                array (
                    'id' => 2991,
                    'name' => 'Chita',
                    'country_id' => 182,
                ),
            2944 =>
                array (
                    'id' => 2992,
                    'name' => 'Chukotka',
                    'country_id' => 182,
                ),
            2945 =>
                array (
                    'id' => 2993,
                    'name' => 'Chuvashija',
                    'country_id' => 182,
                ),
            2946 =>
                array (
                    'id' => 2994,
                    'name' => 'Dagestan',
                    'country_id' => 182,
                ),
            2947 =>
                array (
                    'id' => 2995,
                    'name' => 'Evenkija',
                    'country_id' => 182,
                ),
            2948 =>
                array (
                    'id' => 2996,
                    'name' => 'Gorno-Altaj',
                    'country_id' => 182,
                ),
            2949 =>
                array (
                    'id' => 2997,
                    'name' => 'Habarovsk',
                    'country_id' => 182,
                ),
            2950 =>
                array (
                    'id' => 2998,
                    'name' => 'Hakasija',
                    'country_id' => 182,
                ),
            2951 =>
                array (
                    'id' => 2999,
                    'name' => 'Hanty-Mansija',
                    'country_id' => 182,
                ),
            2952 =>
                array (
                    'id' => 3000,
                    'name' => 'Ingusetija',
                    'country_id' => 182,
                ),
            2953 =>
                array (
                    'id' => 3001,
                    'name' => 'Irkutsk',
                    'country_id' => 182,
                ),
            2954 =>
                array (
                    'id' => 3002,
                    'name' => 'Ivanovo',
                    'country_id' => 182,
                ),
            2955 =>
                array (
                    'id' => 3003,
                    'name' => 'Jamalo-Nenets',
                    'country_id' => 182,
                ),
            2956 =>
                array (
                    'id' => 3004,
                    'name' => 'Jaroslavl',
                    'country_id' => 182,
                ),
            2957 =>
                array (
                    'id' => 3005,
                    'name' => 'Jevrej',
                    'country_id' => 182,
                ),
            2958 =>
                array (
                    'id' => 3006,
                    'name' => 'Kabardino-Balkarija',
                    'country_id' => 182,
                ),
            2959 =>
                array (
                    'id' => 3007,
                    'name' => 'Kaliningrad',
                    'country_id' => 182,
                ),
            2960 =>
                array (
                    'id' => 3008,
                    'name' => 'Kalmykija',
                    'country_id' => 182,
                ),
            2961 =>
                array (
                    'id' => 3009,
                    'name' => 'Kaluga',
                    'country_id' => 182,
                ),
            2962 =>
                array (
                    'id' => 3010,
                    'name' => 'Kamchatka',
                    'country_id' => 182,
                ),
            2963 =>
                array (
                    'id' => 3011,
                    'name' => 'Karachaj-Cherkessija',
                    'country_id' => 182,
                ),
            2964 =>
                array (
                    'id' => 3012,
                    'name' => 'Karelija',
                    'country_id' => 182,
                ),
            2965 =>
                array (
                    'id' => 3013,
                    'name' => 'Kemerovo',
                    'country_id' => 182,
                ),
            2966 =>
                array (
                    'id' => 3014,
                    'name' => 'Khabarovskiy Kray',
                    'country_id' => 182,
                ),
            2967 =>
                array (
                    'id' => 3015,
                    'name' => 'Kirov',
                    'country_id' => 182,
                ),
            2968 =>
                array (
                    'id' => 3016,
                    'name' => 'Komi',
                    'country_id' => 182,
                ),
            2969 =>
                array (
                    'id' => 3017,
                    'name' => 'Komi-Permjakija',
                    'country_id' => 182,
                ),
            2970 =>
                array (
                    'id' => 3018,
                    'name' => 'Korjakija',
                    'country_id' => 182,
                ),
            2971 =>
                array (
                    'id' => 3019,
                    'name' => 'Kostroma',
                    'country_id' => 182,
                ),
            2972 =>
                array (
                    'id' => 3020,
                    'name' => 'Krasnodar',
                    'country_id' => 182,
                ),
            2973 =>
                array (
                    'id' => 3021,
                    'name' => 'Krasnojarsk',
                    'country_id' => 182,
                ),
            2974 =>
                array (
                    'id' => 3022,
                    'name' => 'Krasnoyarskiy Kray',
                    'country_id' => 182,
                ),
            2975 =>
                array (
                    'id' => 3023,
                    'name' => 'Kurgan',
                    'country_id' => 182,
                ),
            2976 =>
                array (
                    'id' => 3024,
                    'name' => 'Kursk',
                    'country_id' => 182,
                ),
            2977 =>
                array (
                    'id' => 3025,
                    'name' => 'Leningrad',
                    'country_id' => 182,
                ),
            2978 =>
                array (
                    'id' => 3026,
                    'name' => 'Lipeck',
                    'country_id' => 182,
                ),
            2979 =>
                array (
                    'id' => 3027,
                    'name' => 'Magadan',
                    'country_id' => 182,
                ),
            2980 =>
                array (
                    'id' => 3028,
                    'name' => 'Marij El',
                    'country_id' => 182,
                ),
            2981 =>
                array (
                    'id' => 3029,
                    'name' => 'Mordovija',
                    'country_id' => 182,
                ),
            2982 =>
                array (
                    'id' => 3030,
                    'name' => 'Moscow',
                    'country_id' => 182,
                ),
            2983 =>
                array (
                    'id' => 3031,
                    'name' => 'Moskovskaja Oblast',
                    'country_id' => 182,
                ),
            2984 =>
                array (
                    'id' => 3032,
                    'name' => 'Moskovskaya Oblast',
                    'country_id' => 182,
                ),
            2985 =>
                array (
                    'id' => 3033,
                    'name' => 'Moskva',
                    'country_id' => 182,
                ),
            2986 =>
                array (
                    'id' => 3034,
                    'name' => 'Murmansk',
                    'country_id' => 182,
                ),
            2987 =>
                array (
                    'id' => 3035,
                    'name' => 'Nenets',
                    'country_id' => 182,
                ),
            2988 =>
                array (
                    'id' => 3036,
                    'name' => 'Nizhnij Novgorod',
                    'country_id' => 182,
                ),
            2989 =>
                array (
                    'id' => 3037,
                    'name' => 'Novgorod',
                    'country_id' => 182,
                ),
            2990 =>
                array (
                    'id' => 3038,
                    'name' => 'Novokusnezk',
                    'country_id' => 182,
                ),
            2991 =>
                array (
                    'id' => 3039,
                    'name' => 'Novosibirsk',
                    'country_id' => 182,
                ),
            2992 =>
                array (
                    'id' => 3040,
                    'name' => 'Omsk',
                    'country_id' => 182,
                ),
            2993 =>
                array (
                    'id' => 3041,
                    'name' => 'Orenburg',
                    'country_id' => 182,
                ),
            2994 =>
                array (
                    'id' => 3042,
                    'name' => 'Orjol',
                    'country_id' => 182,
                ),
            2995 =>
                array (
                    'id' => 3043,
                    'name' => 'Penza',
                    'country_id' => 182,
                ),
            2996 =>
                array (
                    'id' => 3044,
                    'name' => 'Perm',
                    'country_id' => 182,
                ),
            2997 =>
                array (
                    'id' => 3045,
                    'name' => 'Primorje',
                    'country_id' => 182,
                ),
            2998 =>
                array (
                    'id' => 3046,
                    'name' => 'Pskov',
                    'country_id' => 182,
                ),
            2999 =>
                array (
                    'id' => 3047,
                    'name' => 'Pskovskaya Oblast',
                    'country_id' => 182,
                ),
            3000 =>
                array (
                    'id' => 3048,
                    'name' => 'Rjazan',
                    'country_id' => 182,
                ),
            3001 =>
                array (
                    'id' => 3049,
                    'name' => 'Rostov',
                    'country_id' => 182,
                ),
            3002 =>
                array (
                    'id' => 3050,
                    'name' => 'Saha',
                    'country_id' => 182,
                ),
            3003 =>
                array (
                    'id' => 3051,
                    'name' => 'Sahalin',
                    'country_id' => 182,
                ),
            3004 =>
                array (
                    'id' => 3052,
                    'name' => 'Samara',
                    'country_id' => 182,
                ),
            3005 =>
                array (
                    'id' => 3053,
                    'name' => 'Samarskaya',
                    'country_id' => 182,
                ),
            3006 =>
                array (
                    'id' => 3054,
                    'name' => 'Sankt-Peterburg',
                    'country_id' => 182,
                ),
            3007 =>
                array (
                    'id' => 3055,
                    'name' => 'Saratov',
                    'country_id' => 182,
                ),
            3008 =>
                array (
                    'id' => 3056,
                    'name' => 'Smolensk',
                    'country_id' => 182,
                ),
            3009 =>
                array (
                    'id' => 3057,
                    'name' => 'Stavropol',
                    'country_id' => 182,
                ),
            3010 =>
                array (
                    'id' => 3058,
                    'name' => 'Sverdlovsk',
                    'country_id' => 182,
                ),
            3011 =>
                array (
                    'id' => 3059,
                    'name' => 'Tajmyrija',
                    'country_id' => 182,
                ),
            3012 =>
                array (
                    'id' => 3060,
                    'name' => 'Tambov',
                    'country_id' => 182,
                ),
            3013 =>
                array (
                    'id' => 3061,
                    'name' => 'Tatarstan',
                    'country_id' => 182,
                ),
            3014 =>
                array (
                    'id' => 3062,
                    'name' => 'Tjumen',
                    'country_id' => 182,
                ),
            3015 =>
                array (
                    'id' => 3063,
                    'name' => 'Tomsk',
                    'country_id' => 182,
                ),
            3016 =>
                array (
                    'id' => 3064,
                    'name' => 'Tula',
                    'country_id' => 182,
                ),
            3017 =>
                array (
                    'id' => 3065,
                    'name' => 'Tver',
                    'country_id' => 182,
                ),
            3018 =>
                array (
                    'id' => 3066,
                    'name' => 'Tyva',
                    'country_id' => 182,
                ),
            3019 =>
                array (
                    'id' => 3067,
                    'name' => 'Udmurtija',
                    'country_id' => 182,
                ),
            3020 =>
                array (
                    'id' => 3068,
                    'name' => 'Uljanovsk',
                    'country_id' => 182,
                ),
            3021 =>
                array (
                    'id' => 3069,
                    'name' => 'Ulyanovskaya Oblast',
                    'country_id' => 182,
                ),
            3022 =>
                array (
                    'id' => 3070,
                    'name' => 'Ust-Orda',
                    'country_id' => 182,
                ),
            3023 =>
                array (
                    'id' => 3071,
                    'name' => 'Vladimir',
                    'country_id' => 182,
                ),
            3024 =>
                array (
                    'id' => 3072,
                    'name' => 'Volgograd',
                    'country_id' => 182,
                ),
            3025 =>
                array (
                    'id' => 3073,
                    'name' => 'Vologda',
                    'country_id' => 182,
                ),
            3026 =>
                array (
                    'id' => 3074,
                    'name' => 'Voronezh',
                    'country_id' => 182,
                ),
            3027 =>
                array (
                    'id' => 3075,
                    'name' => 'Butare',
                    'country_id' => 183,
                ),
            3028 =>
                array (
                    'id' => 3076,
                    'name' => 'Byumba',
                    'country_id' => 183,
                ),
            3029 =>
                array (
                    'id' => 3077,
                    'name' => 'Cyangugu',
                    'country_id' => 183,
                ),
            3030 =>
                array (
                    'id' => 3078,
                    'name' => 'Gikongoro',
                    'country_id' => 183,
                ),
            3031 =>
                array (
                    'id' => 3079,
                    'name' => 'Gisenyi',
                    'country_id' => 183,
                ),
            3032 =>
                array (
                    'id' => 3080,
                    'name' => 'Gitarama',
                    'country_id' => 183,
                ),
            3033 =>
                array (
                    'id' => 3081,
                    'name' => 'Kibungo',
                    'country_id' => 183,
                ),
            3034 =>
                array (
                    'id' => 3082,
                    'name' => 'Kibuye',
                    'country_id' => 183,
                ),
            3035 =>
                array (
                    'id' => 3083,
                    'name' => 'Kigali-ngali',
                    'country_id' => 183,
                ),
            3036 =>
                array (
                    'id' => 3084,
                    'name' => 'Ruhengeri',
                    'country_id' => 183,
                ),
            3037 =>
                array (
                    'id' => 3085,
                    'name' => 'Ascension',
                    'country_id' => 184,
                ),
            3038 =>
                array (
                    'id' => 3086,
                    'name' => 'Gough Island',
                    'country_id' => 184,
                ),
            3039 =>
                array (
                    'id' => 3087,
                    'name' => 'Saint Helena',
                    'country_id' => 184,
                ),
            3040 =>
                array (
                    'id' => 3088,
                    'name' => 'Tristan da Cunha',
                    'country_id' => 184,
                ),
            3041 =>
                array (
                    'id' => 3089,
                    'name' => 'Christ Church Nichola Town',
                    'country_id' => 185,
                ),
            3042 =>
                array (
                    'id' => 3090,
                    'name' => 'Saint Anne Sandy Point',
                    'country_id' => 185,
                ),
            3043 =>
                array (
                    'id' => 3091,
                    'name' => 'Saint George Basseterre',
                    'country_id' => 185,
                ),
            3044 =>
                array (
                    'id' => 3092,
                    'name' => 'Saint George Gingerland',
                    'country_id' => 185,
                ),
            3045 =>
                array (
                    'id' => 3093,
                    'name' => 'Saint James Windward',
                    'country_id' => 185,
                ),
            3046 =>
                array (
                    'id' => 3094,
                    'name' => 'Saint John Capesterre',
                    'country_id' => 185,
                ),
            3047 =>
                array (
                    'id' => 3095,
                    'name' => 'Saint John Figtree',
                    'country_id' => 185,
                ),
            3048 =>
                array (
                    'id' => 3096,
                    'name' => 'Saint Mary Cayon',
                    'country_id' => 185,
                ),
            3049 =>
                array (
                    'id' => 3097,
                    'name' => 'Saint Paul Capesterre',
                    'country_id' => 185,
                ),
            3050 =>
                array (
                    'id' => 3098,
                    'name' => 'Saint Paul Charlestown',
                    'country_id' => 185,
                ),
            3051 =>
                array (
                    'id' => 3099,
                    'name' => 'Saint Peter Basseterre',
                    'country_id' => 185,
                ),
            3052 =>
                array (
                    'id' => 3100,
                    'name' => 'Saint Thomas Lowland',
                    'country_id' => 185,
                ),
            3053 =>
                array (
                    'id' => 3101,
                    'name' => 'Saint Thomas Middle Island',
                    'country_id' => 185,
                ),
            3054 =>
                array (
                    'id' => 3102,
                    'name' => 'Trinity Palmetto Point',
                    'country_id' => 185,
                ),
            3055 =>
                array (
                    'id' => 3103,
                    'name' => 'Anse-la-Raye',
                    'country_id' => 186,
                ),
            3056 =>
                array (
                    'id' => 3104,
                    'name' => 'Canaries',
                    'country_id' => 186,
                ),
            3057 =>
                array (
                    'id' => 3105,
                    'name' => 'Castries',
                    'country_id' => 186,
                ),
            3058 =>
                array (
                    'id' => 3106,
                    'name' => 'Choiseul',
                    'country_id' => 186,
                ),
            3059 =>
                array (
                    'id' => 3107,
                    'name' => 'Dennery',
                    'country_id' => 186,
                ),
            3060 =>
                array (
                    'id' => 3108,
                    'name' => 'Gros Inlet',
                    'country_id' => 186,
                ),
            3061 =>
                array (
                    'id' => 3109,
                    'name' => 'Laborie',
                    'country_id' => 186,
                ),
            3062 =>
                array (
                    'id' => 3110,
                    'name' => 'Micoud',
                    'country_id' => 186,
                ),
            3063 =>
                array (
                    'id' => 3111,
                    'name' => 'Soufriere',
                    'country_id' => 186,
                ),
            3064 =>
                array (
                    'id' => 3112,
                    'name' => 'Vieux Fort',
                    'country_id' => 186,
                ),
            3065 =>
                array (
                    'id' => 3113,
                    'name' => 'Miquelon-Langlade',
                    'country_id' => 187,
                ),
            3066 =>
                array (
                    'id' => 3114,
                    'name' => 'Saint-Pierre',
                    'country_id' => 187,
                ),
            3067 =>
                array (
                    'id' => 3115,
                    'name' => 'Charlotte',
                    'country_id' => 188,
                ),
            3068 =>
                array (
                    'id' => 3116,
                    'name' => 'Grenadines',
                    'country_id' => 188,
                ),
            3069 =>
                array (
                    'id' => 3117,
                    'name' => 'Saint Andrew',
                    'country_id' => 188,
                ),
            3070 =>
                array (
                    'id' => 3118,
                    'name' => 'Saint David',
                    'country_id' => 188,
                ),
            3071 =>
                array (
                    'id' => 3119,
                    'name' => 'Saint George',
                    'country_id' => 188,
                ),
            3072 =>
                array (
                    'id' => 3120,
                    'name' => 'Saint Patrick',
                    'country_id' => 188,
                ),
            3073 =>
                array (
                    'id' => 3121,
                    'name' => 'A\'ana',
                    'country_id' => 191,
                ),
            3074 =>
                array (
                    'id' => 3122,
                    'name' => 'Aiga-i-le-Tai',
                    'country_id' => 191,
                ),
            3075 =>
                array (
                    'id' => 3123,
                    'name' => 'Atua',
                    'country_id' => 191,
                ),
            3076 =>
                array (
                    'id' => 3124,
                    'name' => 'Fa\'asaleleaga',
                    'country_id' => 191,
                ),
            3077 =>
                array (
                    'id' => 3125,
                    'name' => 'Gaga\'emauga',
                    'country_id' => 191,
                ),
            3078 =>
                array (
                    'id' => 3126,
                    'name' => 'Gagaifomauga',
                    'country_id' => 191,
                ),
            3079 =>
                array (
                    'id' => 3127,
                    'name' => 'Palauli',
                    'country_id' => 191,
                ),
            3080 =>
                array (
                    'id' => 3128,
                    'name' => 'Satupa\'itea',
                    'country_id' => 191,
                ),
            3081 =>
                array (
                    'id' => 3129,
                    'name' => 'Tuamasaga',
                    'country_id' => 191,
                ),
            3082 =>
                array (
                    'id' => 3130,
                    'name' => 'Va\'a-o-Fonoti',
                    'country_id' => 191,
                ),
            3083 =>
                array (
                    'id' => 3131,
                    'name' => 'Vaisigano',
                    'country_id' => 191,
                ),
            3084 =>
                array (
                    'id' => 3132,
                    'name' => 'Acquaviva',
                    'country_id' => 192,
                ),
            3085 =>
                array (
                    'id' => 3133,
                    'name' => 'Borgo Maggiore',
                    'country_id' => 192,
                ),
            3086 =>
                array (
                    'id' => 3134,
                    'name' => 'Chiesanuova',
                    'country_id' => 192,
                ),
            3087 =>
                array (
                    'id' => 3135,
                    'name' => 'Domagnano',
                    'country_id' => 192,
                ),
            3088 =>
                array (
                    'id' => 3136,
                    'name' => 'Faetano',
                    'country_id' => 192,
                ),
            3089 =>
                array (
                    'id' => 3137,
                    'name' => 'Fiorentino',
                    'country_id' => 192,
                ),
            3090 =>
                array (
                    'id' => 3138,
                    'name' => 'Montegiardino',
                    'country_id' => 192,
                ),
            3091 =>
                array (
                    'id' => 3139,
                    'name' => 'San Marino',
                    'country_id' => 192,
                ),
            3092 =>
                array (
                    'id' => 3140,
                    'name' => 'Serravalle',
                    'country_id' => 192,
                ),
            3093 =>
                array (
                    'id' => 3141,
                    'name' => 'Agua Grande',
                    'country_id' => 193,
                ),
            3094 =>
                array (
                    'id' => 3142,
                    'name' => 'Cantagalo',
                    'country_id' => 193,
                ),
            3095 =>
                array (
                    'id' => 3143,
                    'name' => 'Lemba',
                    'country_id' => 193,
                ),
            3096 =>
                array (
                    'id' => 3144,
                    'name' => 'Lobata',
                    'country_id' => 193,
                ),
            3097 =>
                array (
                    'id' => 3145,
                    'name' => 'Me-Zochi',
                    'country_id' => 193,
                ),
            3098 =>
                array (
                    'id' => 3146,
                    'name' => 'Pague',
                    'country_id' => 193,
                ),
            3099 =>
                array (
                    'id' => 3147,
                    'name' => 'Al Khobar',
                    'country_id' => 194,
                ),
            3100 =>
                array (
                    'id' => 3148,
                    'name' => 'Aseer',
                    'country_id' => 194,
                ),
            3101 =>
                array (
                    'id' => 3149,
                    'name' => 'Ash Sharqiyah',
                    'country_id' => 194,
                ),
            3102 =>
                array (
                    'id' => 3150,
                    'name' => 'Asir',
                    'country_id' => 194,
                ),
            3103 =>
                array (
                    'id' => 3151,
                    'name' => 'Central Province',
                    'country_id' => 194,
                ),
            3104 =>
                array (
                    'id' => 3152,
                    'name' => 'Eastern Province',
                    'country_id' => 194,
                ),
            3105 =>
                array (
                    'id' => 3153,
                    'name' => 'Ha\'il',
                    'country_id' => 194,
                ),
            3106 =>
                array (
                    'id' => 3154,
                    'name' => 'Jawf',
                    'country_id' => 194,
                ),
            3107 =>
                array (
                    'id' => 3155,
                    'name' => 'Jizan',
                    'country_id' => 194,
                ),
            3108 =>
                array (
                    'id' => 3156,
                    'name' => 'Makkah',
                    'country_id' => 194,
                ),
            3109 =>
                array (
                    'id' => 3157,
                    'name' => 'Najran',
                    'country_id' => 194,
                ),
            3110 =>
                array (
                    'id' => 3158,
                    'name' => 'Qasim',
                    'country_id' => 194,
                ),
            3111 =>
                array (
                    'id' => 3159,
                    'name' => 'Tabuk',
                    'country_id' => 194,
                ),
            3112 =>
                array (
                    'id' => 3160,
                    'name' => 'Western Province',
                    'country_id' => 194,
                ),
            3113 =>
                array (
                    'id' => 3161,
                    'name' => 'al-Bahah',
                    'country_id' => 194,
                ),
            3114 =>
                array (
                    'id' => 3162,
                    'name' => 'al-Hudud-ash-Shamaliyah',
                    'country_id' => 194,
                ),
            3115 =>
                array (
                    'id' => 3163,
                    'name' => 'al-Madinah',
                    'country_id' => 194,
                ),
            3116 =>
                array (
                    'id' => 3164,
                    'name' => 'ar-Riyad',
                    'country_id' => 194,
                ),
            3117 =>
                array (
                    'id' => 3165,
                    'name' => 'Dakar',
                    'country_id' => 195,
                ),
            3118 =>
                array (
                    'id' => 3166,
                    'name' => 'Diourbel',
                    'country_id' => 195,
                ),
            3119 =>
                array (
                    'id' => 3167,
                    'name' => 'Fatick',
                    'country_id' => 195,
                ),
            3120 =>
                array (
                    'id' => 3168,
                    'name' => 'Kaolack',
                    'country_id' => 195,
                ),
            3121 =>
                array (
                    'id' => 3169,
                    'name' => 'Kolda',
                    'country_id' => 195,
                ),
            3122 =>
                array (
                    'id' => 3170,
                    'name' => 'Louga',
                    'country_id' => 195,
                ),
            3123 =>
                array (
                    'id' => 3171,
                    'name' => 'Saint-Louis',
                    'country_id' => 195,
                ),
            3124 =>
                array (
                    'id' => 3172,
                    'name' => 'Tambacounda',
                    'country_id' => 195,
                ),
            3125 =>
                array (
                    'id' => 3173,
                    'name' => 'Thies',
                    'country_id' => 195,
                ),
            3126 =>
                array (
                    'id' => 3174,
                    'name' => 'Ziguinchor',
                    'country_id' => 195,
                ),
            3127 =>
                array (
                    'id' => 3175,
                    'name' => 'Central Serbia',
                    'country_id' => 196,
                ),
            3128 =>
                array (
                    'id' => 3176,
                    'name' => 'Kosovo and Metohija',
                    'country_id' => 196,
                ),
            3129 =>
                array (
                    'id' => 3177,
                    'name' => 'Vojvodina',
                    'country_id' => 196,
                ),
            3130 =>
                array (
                    'id' => 3178,
                    'name' => 'Anse Boileau',
                    'country_id' => 197,
                ),
            3131 =>
                array (
                    'id' => 3179,
                    'name' => 'Anse Royale',
                    'country_id' => 197,
                ),
            3132 =>
                array (
                    'id' => 3180,
                    'name' => 'Cascade',
                    'country_id' => 197,
                ),
            3133 =>
                array (
                    'id' => 3181,
                    'name' => 'Takamaka',
                    'country_id' => 197,
                ),
            3134 =>
                array (
                    'id' => 3182,
                    'name' => 'Victoria',
                    'country_id' => 197,
                ),
            3135 =>
                array (
                    'id' => 3183,
                    'name' => 'Eastern',
                    'country_id' => 198,
                ),
            3136 =>
                array (
                    'id' => 3184,
                    'name' => 'Northern',
                    'country_id' => 198,
                ),
            3137 =>
                array (
                    'id' => 3185,
                    'name' => 'Southern',
                    'country_id' => 198,
                ),
            3138 =>
                array (
                    'id' => 3186,
                    'name' => 'Western',
                    'country_id' => 198,
                ),
            3139 =>
                array (
                    'id' => 3187,
                    'name' => 'Singapore',
                    'country_id' => 199,
                ),
            3140 =>
                array (
                    'id' => 3188,
                    'name' => 'Banskobystricky',
                    'country_id' => 200,
                ),
            3141 =>
                array (
                    'id' => 3189,
                    'name' => 'Bratislavsky',
                    'country_id' => 200,
                ),
            3142 =>
                array (
                    'id' => 3190,
                    'name' => 'Kosicky',
                    'country_id' => 200,
                ),
            3143 =>
                array (
                    'id' => 3191,
                    'name' => 'Nitriansky',
                    'country_id' => 200,
                ),
            3144 =>
                array (
                    'id' => 3192,
                    'name' => 'Presovsky',
                    'country_id' => 200,
                ),
            3145 =>
                array (
                    'id' => 3193,
                    'name' => 'Trenciansky',
                    'country_id' => 200,
                ),
            3146 =>
                array (
                    'id' => 3194,
                    'name' => 'Trnavsky',
                    'country_id' => 200,
                ),
            3147 =>
                array (
                    'id' => 3195,
                    'name' => 'Zilinsky',
                    'country_id' => 200,
                ),
            3148 =>
                array (
                    'id' => 3196,
                    'name' => 'Benedikt',
                    'country_id' => 201,
                ),
            3149 =>
                array (
                    'id' => 3197,
                    'name' => 'Gorenjska',
                    'country_id' => 201,
                ),
            3150 =>
                array (
                    'id' => 3198,
                    'name' => 'Gorishka',
                    'country_id' => 201,
                ),
            3151 =>
                array (
                    'id' => 3199,
                    'name' => 'Jugovzhodna Slovenija',
                    'country_id' => 201,
                ),
            3152 =>
                array (
                    'id' => 3200,
                    'name' => 'Koroshka',
                    'country_id' => 201,
                ),
            3153 =>
                array (
                    'id' => 3201,
                    'name' => 'Notranjsko-krashka',
                    'country_id' => 201,
                ),
            3154 =>
                array (
                    'id' => 3202,
                    'name' => 'Obalno-krashka',
                    'country_id' => 201,
                ),
            3155 =>
                array (
                    'id' => 3203,
                    'name' => 'Obcina Domzale',
                    'country_id' => 201,
                ),
            3156 =>
                array (
                    'id' => 3204,
                    'name' => 'Obcina Vitanje',
                    'country_id' => 201,
                ),
            3157 =>
                array (
                    'id' => 3205,
                    'name' => 'Osrednjeslovenska',
                    'country_id' => 201,
                ),
            3158 =>
                array (
                    'id' => 3206,
                    'name' => 'Podravska',
                    'country_id' => 201,
                ),
            3159 =>
                array (
                    'id' => 3207,
                    'name' => 'Pomurska',
                    'country_id' => 201,
                ),
            3160 =>
                array (
                    'id' => 3208,
                    'name' => 'Savinjska',
                    'country_id' => 201,
                ),
            3161 =>
                array (
                    'id' => 3209,
                    'name' => 'Slovenian Littoral',
                    'country_id' => 201,
                ),
            3162 =>
                array (
                    'id' => 3210,
                    'name' => 'Spodnjeposavska',
                    'country_id' => 201,
                ),
            3163 =>
                array (
                    'id' => 3211,
                    'name' => 'Zasavska',
                    'country_id' => 201,
                ),
            3164 =>
                array (
                    'id' => 3213,
                    'name' => 'Central',
                    'country_id' => 202,
                ),
            3165 =>
                array (
                    'id' => 3214,
                    'name' => 'Choiseul',
                    'country_id' => 202,
                ),
            3166 =>
                array (
                    'id' => 3215,
                    'name' => 'Guadalcanal',
                    'country_id' => 202,
                ),
            3167 =>
                array (
                    'id' => 3216,
                    'name' => 'Isabel',
                    'country_id' => 202,
                ),
            3168 =>
                array (
                    'id' => 3217,
                    'name' => 'Makira and Ulawa',
                    'country_id' => 202,
                ),
            3169 =>
                array (
                    'id' => 3218,
                    'name' => 'Malaita',
                    'country_id' => 202,
                ),
            3170 =>
                array (
                    'id' => 3219,
                    'name' => 'Rennell and Bellona',
                    'country_id' => 202,
                ),
            3171 =>
                array (
                    'id' => 3220,
                    'name' => 'Temotu',
                    'country_id' => 202,
                ),
            3172 =>
                array (
                    'id' => 3221,
                    'name' => 'Western',
                    'country_id' => 202,
                ),
            3173 =>
                array (
                    'id' => 3222,
                    'name' => 'Awdal',
                    'country_id' => 203,
                ),
            3174 =>
                array (
                    'id' => 3223,
                    'name' => 'Bakol',
                    'country_id' => 203,
                ),
            3175 =>
                array (
                    'id' => 3224,
                    'name' => 'Banadir',
                    'country_id' => 203,
                ),
            3176 =>
                array (
                    'id' => 3225,
                    'name' => 'Bari',
                    'country_id' => 203,
                ),
            3177 =>
                array (
                    'id' => 3226,
                    'name' => 'Bay',
                    'country_id' => 203,
                ),
            3178 =>
                array (
                    'id' => 3227,
                    'name' => 'Galgudug',
                    'country_id' => 203,
                ),
            3179 =>
                array (
                    'id' => 3228,
                    'name' => 'Gedo',
                    'country_id' => 203,
                ),
            3180 =>
                array (
                    'id' => 3229,
                    'name' => 'Hiran',
                    'country_id' => 203,
                ),
            3181 =>
                array (
                    'id' => 3230,
                    'name' => 'Jubbada Hose',
                    'country_id' => 203,
                ),
            3182 =>
                array (
                    'id' => 3231,
                    'name' => 'Jubbadha Dexe',
                    'country_id' => 203,
                ),
            3183 =>
                array (
                    'id' => 3232,
                    'name' => 'Mudug',
                    'country_id' => 203,
                ),
            3184 =>
                array (
                    'id' => 3233,
                    'name' => 'Nugal',
                    'country_id' => 203,
                ),
            3185 =>
                array (
                    'id' => 3234,
                    'name' => 'Sanag',
                    'country_id' => 203,
                ),
            3186 =>
                array (
                    'id' => 3235,
                    'name' => 'Shabellaha Dhexe',
                    'country_id' => 203,
                ),
            3187 =>
                array (
                    'id' => 3236,
                    'name' => 'Shabellaha Hose',
                    'country_id' => 203,
                ),
            3188 =>
                array (
                    'id' => 3237,
                    'name' => 'Togdher',
                    'country_id' => 203,
                ),
            3189 =>
                array (
                    'id' => 3238,
                    'name' => 'Woqoyi Galbed',
                    'country_id' => 203,
                ),
            3190 =>
                array (
                    'id' => 3239,
                    'name' => 'Eastern Cape',
                    'country_id' => 204,
                ),
            3191 =>
                array (
                    'id' => 3240,
                    'name' => 'Free State',
                    'country_id' => 204,
                ),
            3192 =>
                array (
                    'id' => 3241,
                    'name' => 'Gauteng',
                    'country_id' => 204,
                ),
            3193 =>
                array (
                    'id' => 3242,
                    'name' => 'Kempton Park',
                    'country_id' => 204,
                ),
            3194 =>
                array (
                    'id' => 3243,
                    'name' => 'Kramerville',
                    'country_id' => 204,
                ),
            3195 =>
                array (
                    'id' => 3244,
                    'name' => 'KwaZulu Natal',
                    'country_id' => 204,
                ),
            3196 =>
                array (
                    'id' => 3245,
                    'name' => 'Limpopo',
                    'country_id' => 204,
                ),
            3197 =>
                array (
                    'id' => 3246,
                    'name' => 'Mpumalanga',
                    'country_id' => 204,
                ),
            3198 =>
                array (
                    'id' => 3247,
                    'name' => 'North West',
                    'country_id' => 204,
                ),
            3199 =>
                array (
                    'id' => 3248,
                    'name' => 'Northern Cape',
                    'country_id' => 204,
                ),
            3200 =>
                array (
                    'id' => 3249,
                    'name' => 'Parow',
                    'country_id' => 204,
                ),
            3201 =>
                array (
                    'id' => 3250,
                    'name' => 'Table View',
                    'country_id' => 204,
                ),
            3202 =>
                array (
                    'id' => 3251,
                    'name' => 'Umtentweni',
                    'country_id' => 204,
                ),
            3203 =>
                array (
                    'id' => 3252,
                    'name' => 'Western Cape',
                    'country_id' => 204,
                ),
            3204 =>
                array (
                    'id' => 3253,
                    'name' => 'South Georgia',
                    'country_id' => 205,
                ),
            3205 =>
                array (
                    'id' => 3254,
                    'name' => 'Central Equatoria',
                    'country_id' => 206,
                ),
            3206 =>
                array (
                    'id' => 3255,
                    'name' => 'A Coruna',
                    'country_id' => 207,
                ),
            3207 =>
                array (
                    'id' => 3256,
                    'name' => 'Alacant',
                    'country_id' => 207,
                ),
            3208 =>
                array (
                    'id' => 3257,
                    'name' => 'Alava',
                    'country_id' => 207,
                ),
            3209 =>
                array (
                    'id' => 3258,
                    'name' => 'Albacete',
                    'country_id' => 207,
                ),
            3210 =>
                array (
                    'id' => 3259,
                    'name' => 'Almeria',
                    'country_id' => 207,
                ),
            3211 =>
                array (
                    'id' => 3260,
                    'name' => 'Andalucia',
                    'country_id' => 207,
                ),
            3212 =>
                array (
                    'id' => 3261,
                    'name' => 'Asturias',
                    'country_id' => 207,
                ),
            3213 =>
                array (
                    'id' => 3262,
                    'name' => 'Avila',
                    'country_id' => 207,
                ),
            3214 =>
                array (
                    'id' => 3263,
                    'name' => 'Badajoz',
                    'country_id' => 207,
                ),
            3215 =>
                array (
                    'id' => 3264,
                    'name' => 'Balears',
                    'country_id' => 207,
                ),
            3216 =>
                array (
                    'id' => 3265,
                    'name' => 'Barcelona',
                    'country_id' => 207,
                ),
            3217 =>
                array (
                    'id' => 3266,
                    'name' => 'Bertamirans',
                    'country_id' => 207,
                ),
            3218 =>
                array (
                    'id' => 3267,
                    'name' => 'Biscay',
                    'country_id' => 207,
                ),
            3219 =>
                array (
                    'id' => 3268,
                    'name' => 'Burgos',
                    'country_id' => 207,
                ),
            3220 =>
                array (
                    'id' => 3269,
                    'name' => 'Caceres',
                    'country_id' => 207,
                ),
            3221 =>
                array (
                    'id' => 3270,
                    'name' => 'Cadiz',
                    'country_id' => 207,
                ),
            3222 =>
                array (
                    'id' => 3271,
                    'name' => 'Cantabria',
                    'country_id' => 207,
                ),
            3223 =>
                array (
                    'id' => 3272,
                    'name' => 'Castello',
                    'country_id' => 207,
                ),
            3224 =>
                array (
                    'id' => 3273,
                    'name' => 'Catalunya',
                    'country_id' => 207,
                ),
            3225 =>
                array (
                    'id' => 3274,
                    'name' => 'Ceuta',
                    'country_id' => 207,
                ),
            3226 =>
                array (
                    'id' => 3275,
                    'name' => 'Ciudad Real',
                    'country_id' => 207,
                ),
            3227 =>
                array (
                    'id' => 3276,
                    'name' => 'Comunidad Autonoma de Canarias',
                    'country_id' => 207,
                ),
            3228 =>
                array (
                    'id' => 3277,
                    'name' => 'Comunidad Autonoma de Cataluna',
                    'country_id' => 207,
                ),
            3229 =>
                array (
                    'id' => 3278,
                    'name' => 'Comunidad Autonoma de Galicia',
                    'country_id' => 207,
                ),
            3230 =>
                array (
                    'id' => 3279,
                    'name' => 'Comunidad Autonoma de las Isla',
                    'country_id' => 207,
                ),
            3231 =>
                array (
                    'id' => 3280,
                    'name' => 'Comunidad Autonoma del Princip',
                    'country_id' => 207,
                ),
            3232 =>
                array (
                    'id' => 3281,
                    'name' => 'Comunidad Valenciana',
                    'country_id' => 207,
                ),
            3233 =>
                array (
                    'id' => 3282,
                    'name' => 'Cordoba',
                    'country_id' => 207,
                ),
            3234 =>
                array (
                    'id' => 3283,
                    'name' => 'Cuenca',
                    'country_id' => 207,
                ),
            3235 =>
                array (
                    'id' => 3284,
                    'name' => 'Gipuzkoa',
                    'country_id' => 207,
                ),
            3236 =>
                array (
                    'id' => 3285,
                    'name' => 'Girona',
                    'country_id' => 207,
                ),
            3237 =>
                array (
                    'id' => 3286,
                    'name' => 'Granada',
                    'country_id' => 207,
                ),
            3238 =>
                array (
                    'id' => 3287,
                    'name' => 'Guadalajara',
                    'country_id' => 207,
                ),
            3239 =>
                array (
                    'id' => 3288,
                    'name' => 'Guipuzcoa',
                    'country_id' => 207,
                ),
            3240 =>
                array (
                    'id' => 3289,
                    'name' => 'Huelva',
                    'country_id' => 207,
                ),
            3241 =>
                array (
                    'id' => 3290,
                    'name' => 'Huesca',
                    'country_id' => 207,
                ),
            3242 =>
                array (
                    'id' => 3291,
                    'name' => 'Jaen',
                    'country_id' => 207,
                ),
            3243 =>
                array (
                    'id' => 3292,
                    'name' => 'La Rioja',
                    'country_id' => 207,
                ),
            3244 =>
                array (
                    'id' => 3293,
                    'name' => 'Las Palmas',
                    'country_id' => 207,
                ),
            3245 =>
                array (
                    'id' => 3294,
                    'name' => 'Leon',
                    'country_id' => 207,
                ),
            3246 =>
                array (
                    'id' => 3295,
                    'name' => 'Lerida',
                    'country_id' => 207,
                ),
            3247 =>
                array (
                    'id' => 3296,
                    'name' => 'Lleida',
                    'country_id' => 207,
                ),
            3248 =>
                array (
                    'id' => 3297,
                    'name' => 'Lugo',
                    'country_id' => 207,
                ),
            3249 =>
                array (
                    'id' => 3298,
                    'name' => 'Madrid',
                    'country_id' => 207,
                ),
            3250 =>
                array (
                    'id' => 3299,
                    'name' => 'Malaga',
                    'country_id' => 207,
                ),
            3251 =>
                array (
                    'id' => 3300,
                    'name' => 'Melilla',
                    'country_id' => 207,
                ),
            3252 =>
                array (
                    'id' => 3301,
                    'name' => 'Murcia',
                    'country_id' => 207,
                ),
            3253 =>
                array (
                    'id' => 3302,
                    'name' => 'Navarra',
                    'country_id' => 207,
                ),
            3254 =>
                array (
                    'id' => 3303,
                    'name' => 'Ourense',
                    'country_id' => 207,
                ),
            3255 =>
                array (
                    'id' => 3304,
                    'name' => 'Pais Vasco',
                    'country_id' => 207,
                ),
            3256 =>
                array (
                    'id' => 3305,
                    'name' => 'Palencia',
                    'country_id' => 207,
                ),
            3257 =>
                array (
                    'id' => 3306,
                    'name' => 'Pontevedra',
                    'country_id' => 207,
                ),
            3258 =>
                array (
                    'id' => 3307,
                    'name' => 'Salamanca',
                    'country_id' => 207,
                ),
            3259 =>
                array (
                    'id' => 3308,
                    'name' => 'Santa Cruz de Tenerife',
                    'country_id' => 207,
                ),
            3260 =>
                array (
                    'id' => 3309,
                    'name' => 'Segovia',
                    'country_id' => 207,
                ),
            3261 =>
                array (
                    'id' => 3310,
                    'name' => 'Sevilla',
                    'country_id' => 207,
                ),
            3262 =>
                array (
                    'id' => 3311,
                    'name' => 'Soria',
                    'country_id' => 207,
                ),
            3263 =>
                array (
                    'id' => 3312,
                    'name' => 'Tarragona',
                    'country_id' => 207,
                ),
            3264 =>
                array (
                    'id' => 3313,
                    'name' => 'Tenerife',
                    'country_id' => 207,
                ),
            3265 =>
                array (
                    'id' => 3314,
                    'name' => 'Teruel',
                    'country_id' => 207,
                ),
            3266 =>
                array (
                    'id' => 3315,
                    'name' => 'Toledo',
                    'country_id' => 207,
                ),
            3267 =>
                array (
                    'id' => 3316,
                    'name' => 'Valencia',
                    'country_id' => 207,
                ),
            3268 =>
                array (
                    'id' => 3317,
                    'name' => 'Valladolid',
                    'country_id' => 207,
                ),
            3269 =>
                array (
                    'id' => 3318,
                    'name' => 'Vizcaya',
                    'country_id' => 207,
                ),
            3270 =>
                array (
                    'id' => 3319,
                    'name' => 'Zamora',
                    'country_id' => 207,
                ),
            3271 =>
                array (
                    'id' => 3320,
                    'name' => 'Zaragoza',
                    'country_id' => 207,
                ),
            3272 =>
                array (
                    'id' => 3321,
                    'name' => 'Amparai',
                    'country_id' => 208,
                ),
            3273 =>
                array (
                    'id' => 3322,
                    'name' => 'Anuradhapuraya',
                    'country_id' => 208,
                ),
            3274 =>
                array (
                    'id' => 3323,
                    'name' => 'Badulla',
                    'country_id' => 208,
                ),
            3275 =>
                array (
                    'id' => 3324,
                    'name' => 'Boralesgamuwa',
                    'country_id' => 208,
                ),
            3276 =>
                array (
                    'id' => 3325,
                    'name' => 'Colombo',
                    'country_id' => 208,
                ),
            3277 =>
                array (
                    'id' => 3326,
                    'name' => 'Galla',
                    'country_id' => 208,
                ),
            3278 =>
                array (
                    'id' => 3327,
                    'name' => 'Gampaha',
                    'country_id' => 208,
                ),
            3279 =>
                array (
                    'id' => 3328,
                    'name' => 'Hambantota',
                    'country_id' => 208,
                ),
            3280 =>
                array (
                    'id' => 3329,
                    'name' => 'Kalatura',
                    'country_id' => 208,
                ),
            3281 =>
                array (
                    'id' => 3330,
                    'name' => 'Kegalla',
                    'country_id' => 208,
                ),
            3282 =>
                array (
                    'id' => 3331,
                    'name' => 'Kilinochchi',
                    'country_id' => 208,
                ),
            3283 =>
                array (
                    'id' => 3332,
                    'name' => 'Kurunegala',
                    'country_id' => 208,
                ),
            3284 =>
                array (
                    'id' => 3333,
                    'name' => 'Madakalpuwa',
                    'country_id' => 208,
                ),
            3285 =>
                array (
                    'id' => 3334,
                    'name' => 'Maha Nuwara',
                    'country_id' => 208,
                ),
            3286 =>
                array (
                    'id' => 3335,
                    'name' => 'Malwana',
                    'country_id' => 208,
                ),
            3287 =>
                array (
                    'id' => 3336,
                    'name' => 'Mannarama',
                    'country_id' => 208,
                ),
            3288 =>
                array (
                    'id' => 3337,
                    'name' => 'Matale',
                    'country_id' => 208,
                ),
            3289 =>
                array (
                    'id' => 3338,
                    'name' => 'Matara',
                    'country_id' => 208,
                ),
            3290 =>
                array (
                    'id' => 3339,
                    'name' => 'Monaragala',
                    'country_id' => 208,
                ),
            3291 =>
                array (
                    'id' => 3340,
                    'name' => 'Mullaitivu',
                    'country_id' => 208,
                ),
            3292 =>
                array (
                    'id' => 3341,
                    'name' => 'North Eastern Province',
                    'country_id' => 208,
                ),
            3293 =>
                array (
                    'id' => 3342,
                    'name' => 'North Western Province',
                    'country_id' => 208,
                ),
            3294 =>
                array (
                    'id' => 3343,
                    'name' => 'Nuwara Eliya',
                    'country_id' => 208,
                ),
            3295 =>
                array (
                    'id' => 3344,
                    'name' => 'Polonnaruwa',
                    'country_id' => 208,
                ),
            3296 =>
                array (
                    'id' => 3345,
                    'name' => 'Puttalama',
                    'country_id' => 208,
                ),
            3297 =>
                array (
                    'id' => 3346,
                    'name' => 'Ratnapuraya',
                    'country_id' => 208,
                ),
            3298 =>
                array (
                    'id' => 3347,
                    'name' => 'Southern Province',
                    'country_id' => 208,
                ),
            3299 =>
                array (
                    'id' => 3348,
                    'name' => 'Tirikunamalaya',
                    'country_id' => 208,
                ),
            3300 =>
                array (
                    'id' => 3349,
                    'name' => 'Tuscany',
                    'country_id' => 208,
                ),
            3301 =>
                array (
                    'id' => 3350,
                    'name' => 'Vavuniyawa',
                    'country_id' => 208,
                ),
            3302 =>
                array (
                    'id' => 3351,
                    'name' => 'Western Province',
                    'country_id' => 208,
                ),
            3303 =>
                array (
                    'id' => 3352,
                    'name' => 'Yapanaya',
                    'country_id' => 208,
                ),
            3304 =>
                array (
                    'id' => 3353,
                    'name' => 'kadawatha',
                    'country_id' => 208,
                ),
            3305 =>
                array (
                    'id' => 3354,
                    'name' => 'A\'ali-an-Nil',
                    'country_id' => 209,
                ),
            3306 =>
                array (
                    'id' => 3355,
                    'name' => 'Bahr-al-Jabal',
                    'country_id' => 209,
                ),
            3307 =>
                array (
                    'id' => 3356,
                    'name' => 'Central Equatoria',
                    'country_id' => 209,
                ),
            3308 =>
                array (
                    'id' => 3357,
                    'name' => 'Gharb Bahr-al-Ghazal',
                    'country_id' => 209,
                ),
            3309 =>
                array (
                    'id' => 3358,
                    'name' => 'Gharb Darfur',
                    'country_id' => 209,
                ),
            3310 =>
                array (
                    'id' => 3359,
                    'name' => 'Gharb Kurdufan',
                    'country_id' => 209,
                ),
            3311 =>
                array (
                    'id' => 3360,
                    'name' => 'Gharb-al-Istiwa\'iyah',
                    'country_id' => 209,
                ),
            3312 =>
                array (
                    'id' => 3361,
                    'name' => 'Janub Darfur',
                    'country_id' => 209,
                ),
            3313 =>
                array (
                    'id' => 3362,
                    'name' => 'Janub Kurdufan',
                    'country_id' => 209,
                ),
            3314 =>
                array (
                    'id' => 3363,
                    'name' => 'Junqali',
                    'country_id' => 209,
                ),
            3315 =>
                array (
                    'id' => 3364,
                    'name' => 'Kassala',
                    'country_id' => 209,
                ),
            3316 =>
                array (
                    'id' => 3365,
                    'name' => 'Nahr-an-Nil',
                    'country_id' => 209,
                ),
            3317 =>
                array (
                    'id' => 3366,
                    'name' => 'Shamal Bahr-al-Ghazal',
                    'country_id' => 209,
                ),
            3318 =>
                array (
                    'id' => 3367,
                    'name' => 'Shamal Darfur',
                    'country_id' => 209,
                ),
            3319 =>
                array (
                    'id' => 3368,
                    'name' => 'Shamal Kurdufan',
                    'country_id' => 209,
                ),
            3320 =>
                array (
                    'id' => 3369,
                    'name' => 'Sharq-al-Istiwa\'iyah',
                    'country_id' => 209,
                ),
            3321 =>
                array (
                    'id' => 3370,
                    'name' => 'Sinnar',
                    'country_id' => 209,
                ),
            3322 =>
                array (
                    'id' => 3371,
                    'name' => 'Warab',
                    'country_id' => 209,
                ),
            3323 =>
                array (
                    'id' => 3372,
                    'name' => 'Wilayat al Khartum',
                    'country_id' => 209,
                ),
            3324 =>
                array (
                    'id' => 3373,
                    'name' => 'al-Bahr-al-Ahmar',
                    'country_id' => 209,
                ),
            3325 =>
                array (
                    'id' => 3374,
                    'name' => 'al-Buhayrat',
                    'country_id' => 209,
                ),
            3326 =>
                array (
                    'id' => 3375,
                    'name' => 'al-Jazirah',
                    'country_id' => 209,
                ),
            3327 =>
                array (
                    'id' => 3376,
                    'name' => 'al-Khartum',
                    'country_id' => 209,
                ),
            3328 =>
                array (
                    'id' => 3377,
                    'name' => 'al-Qadarif',
                    'country_id' => 209,
                ),
            3329 =>
                array (
                    'id' => 3378,
                    'name' => 'al-Wahdah',
                    'country_id' => 209,
                ),
            3330 =>
                array (
                    'id' => 3379,
                    'name' => 'an-Nil-al-Abyad',
                    'country_id' => 209,
                ),
            3331 =>
                array (
                    'id' => 3380,
                    'name' => 'an-Nil-al-Azraq',
                    'country_id' => 209,
                ),
            3332 =>
                array (
                    'id' => 3381,
                    'name' => 'ash-Shamaliyah',
                    'country_id' => 209,
                ),
            3333 =>
                array (
                    'id' => 3382,
                    'name' => 'Brokopondo',
                    'country_id' => 210,
                ),
            3334 =>
                array (
                    'id' => 3383,
                    'name' => 'Commewijne',
                    'country_id' => 210,
                ),
            3335 =>
                array (
                    'id' => 3384,
                    'name' => 'Coronie',
                    'country_id' => 210,
                ),
            3336 =>
                array (
                    'id' => 3385,
                    'name' => 'Marowijne',
                    'country_id' => 210,
                ),
            3337 =>
                array (
                    'id' => 3386,
                    'name' => 'Nickerie',
                    'country_id' => 210,
                ),
            3338 =>
                array (
                    'id' => 3387,
                    'name' => 'Para',
                    'country_id' => 210,
                ),
            3339 =>
                array (
                    'id' => 3388,
                    'name' => 'Paramaribo',
                    'country_id' => 210,
                ),
            3340 =>
                array (
                    'id' => 3389,
                    'name' => 'Saramacca',
                    'country_id' => 210,
                ),
            3341 =>
                array (
                    'id' => 3390,
                    'name' => 'Wanica',
                    'country_id' => 210,
                ),
            3342 =>
                array (
                    'id' => 3391,
                    'name' => 'Svalbard',
                    'country_id' => 211,
                ),
            3343 =>
                array (
                    'id' => 3392,
                    'name' => 'Hhohho',
                    'country_id' => 212,
                ),
            3344 =>
                array (
                    'id' => 3393,
                    'name' => 'Lubombo',
                    'country_id' => 212,
                ),
            3345 =>
                array (
                    'id' => 3394,
                    'name' => 'Manzini',
                    'country_id' => 212,
                ),
            3346 =>
                array (
                    'id' => 3395,
                    'name' => 'Shiselweni',
                    'country_id' => 212,
                ),
            3347 =>
                array (
                    'id' => 3396,
                    'name' => 'Alvsborgs Lan',
                    'country_id' => 213,
                ),
            3348 =>
                array (
                    'id' => 3397,
                    'name' => 'Angermanland',
                    'country_id' => 213,
                ),
            3349 =>
                array (
                    'id' => 3398,
                    'name' => 'Blekinge',
                    'country_id' => 213,
                ),
            3350 =>
                array (
                    'id' => 3399,
                    'name' => 'Bohuslan',
                    'country_id' => 213,
                ),
            3351 =>
                array (
                    'id' => 3400,
                    'name' => 'Dalarna',
                    'country_id' => 213,
                ),
            3352 =>
                array (
                    'id' => 3401,
                    'name' => 'Gavleborg',
                    'country_id' => 213,
                ),
            3353 =>
                array (
                    'id' => 3402,
                    'name' => 'Gaza',
                    'country_id' => 213,
                ),
            3354 =>
                array (
                    'id' => 3403,
                    'name' => 'Gotland',
                    'country_id' => 213,
                ),
            3355 =>
                array (
                    'id' => 3404,
                    'name' => 'Halland',
                    'country_id' => 213,
                ),
            3356 =>
                array (
                    'id' => 3405,
                    'name' => 'Jamtland',
                    'country_id' => 213,
                ),
            3357 =>
                array (
                    'id' => 3406,
                    'name' => 'Jonkoping',
                    'country_id' => 213,
                ),
            3358 =>
                array (
                    'id' => 3407,
                    'name' => 'Kalmar',
                    'country_id' => 213,
                ),
            3359 =>
                array (
                    'id' => 3408,
                    'name' => 'Kristianstads',
                    'country_id' => 213,
                ),
            3360 =>
                array (
                    'id' => 3409,
                    'name' => 'Kronoberg',
                    'country_id' => 213,
                ),
            3361 =>
                array (
                    'id' => 3410,
                    'name' => 'Norrbotten',
                    'country_id' => 213,
                ),
            3362 =>
                array (
                    'id' => 3411,
                    'name' => 'Orebro',
                    'country_id' => 213,
                ),
            3363 =>
                array (
                    'id' => 3412,
                    'name' => 'Ostergotland',
                    'country_id' => 213,
                ),
            3364 =>
                array (
                    'id' => 3413,
                    'name' => 'Saltsjo-Boo',
                    'country_id' => 213,
                ),
            3365 =>
                array (
                    'id' => 3414,
                    'name' => 'Skane',
                    'country_id' => 213,
                ),
            3366 =>
                array (
                    'id' => 3415,
                    'name' => 'Smaland',
                    'country_id' => 213,
                ),
            3367 =>
                array (
                    'id' => 3416,
                    'name' => 'Sodermanland',
                    'country_id' => 213,
                ),
            3368 =>
                array (
                    'id' => 3417,
                    'name' => 'Stockholm',
                    'country_id' => 213,
                ),
            3369 =>
                array (
                    'id' => 3418,
                    'name' => 'Uppsala',
                    'country_id' => 213,
                ),
            3370 =>
                array (
                    'id' => 3419,
                    'name' => 'Varmland',
                    'country_id' => 213,
                ),
            3371 =>
                array (
                    'id' => 3420,
                    'name' => 'Vasterbotten',
                    'country_id' => 213,
                ),
            3372 =>
                array (
                    'id' => 3421,
                    'name' => 'Vastergotland',
                    'country_id' => 213,
                ),
            3373 =>
                array (
                    'id' => 3422,
                    'name' => 'Vasternorrland',
                    'country_id' => 213,
                ),
            3374 =>
                array (
                    'id' => 3423,
                    'name' => 'Vastmanland',
                    'country_id' => 213,
                ),
            3375 =>
                array (
                    'id' => 3424,
                    'name' => 'Vastra Gotaland',
                    'country_id' => 213,
                ),
            3376 =>
                array (
                    'id' => 3425,
                    'name' => 'Aargau',
                    'country_id' => 214,
                ),
            3377 =>
                array (
                    'id' => 3426,
                    'name' => 'Appenzell Inner-Rhoden',
                    'country_id' => 214,
                ),
            3378 =>
                array (
                    'id' => 3427,
                    'name' => 'Appenzell-Ausser Rhoden',
                    'country_id' => 214,
                ),
            3379 =>
                array (
                    'id' => 3428,
                    'name' => 'Basel-Landschaft',
                    'country_id' => 214,
                ),
            3380 =>
                array (
                    'id' => 3429,
                    'name' => 'Basel-Stadt',
                    'country_id' => 214,
                ),
            3381 =>
                array (
                    'id' => 3430,
                    'name' => 'Bern',
                    'country_id' => 214,
                ),
            3382 =>
                array (
                    'id' => 3431,
                    'name' => 'Canton Ticino',
                    'country_id' => 214,
                ),
            3383 =>
                array (
                    'id' => 3432,
                    'name' => 'Fribourg',
                    'country_id' => 214,
                ),
            3384 =>
                array (
                    'id' => 3433,
                    'name' => 'Geneve',
                    'country_id' => 214,
                ),
            3385 =>
                array (
                    'id' => 3434,
                    'name' => 'Glarus',
                    'country_id' => 214,
                ),
            3386 =>
                array (
                    'id' => 3435,
                    'name' => 'Graubunden',
                    'country_id' => 214,
                ),
            3387 =>
                array (
                    'id' => 3436,
                    'name' => 'Heerbrugg',
                    'country_id' => 214,
                ),
            3388 =>
                array (
                    'id' => 3437,
                    'name' => 'Jura',
                    'country_id' => 214,
                ),
            3389 =>
                array (
                    'id' => 3438,
                    'name' => 'Kanton Aargau',
                    'country_id' => 214,
                ),
            3390 =>
                array (
                    'id' => 3439,
                    'name' => 'Luzern',
                    'country_id' => 214,
                ),
            3391 =>
                array (
                    'id' => 3440,
                    'name' => 'Morbio Inferiore',
                    'country_id' => 214,
                ),
            3392 =>
                array (
                    'id' => 3441,
                    'name' => 'Muhen',
                    'country_id' => 214,
                ),
            3393 =>
                array (
                    'id' => 3442,
                    'name' => 'Neuchatel',
                    'country_id' => 214,
                ),
            3394 =>
                array (
                    'id' => 3443,
                    'name' => 'Nidwalden',
                    'country_id' => 214,
                ),
            3395 =>
                array (
                    'id' => 3444,
                    'name' => 'Obwalden',
                    'country_id' => 214,
                ),
            3396 =>
                array (
                    'id' => 3445,
                    'name' => 'Sankt Gallen',
                    'country_id' => 214,
                ),
            3397 =>
                array (
                    'id' => 3446,
                    'name' => 'Schaffhausen',
                    'country_id' => 214,
                ),
            3398 =>
                array (
                    'id' => 3447,
                    'name' => 'Schwyz',
                    'country_id' => 214,
                ),
            3399 =>
                array (
                    'id' => 3448,
                    'name' => 'Solothurn',
                    'country_id' => 214,
                ),
            3400 =>
                array (
                    'id' => 3449,
                    'name' => 'Thurgau',
                    'country_id' => 214,
                ),
            3401 =>
                array (
                    'id' => 3450,
                    'name' => 'Ticino',
                    'country_id' => 214,
                ),
            3402 =>
                array (
                    'id' => 3451,
                    'name' => 'Uri',
                    'country_id' => 214,
                ),
            3403 =>
                array (
                    'id' => 3452,
                    'name' => 'Valais',
                    'country_id' => 214,
                ),
            3404 =>
                array (
                    'id' => 3453,
                    'name' => 'Vaud',
                    'country_id' => 214,
                ),
            3405 =>
                array (
                    'id' => 3454,
                    'name' => 'Vauffelin',
                    'country_id' => 214,
                ),
            3406 =>
                array (
                    'id' => 3455,
                    'name' => 'Zug',
                    'country_id' => 214,
                ),
            3407 =>
                array (
                    'id' => 3456,
                    'name' => 'Zurich',
                    'country_id' => 214,
                ),
            3408 =>
                array (
                    'id' => 3457,
                    'name' => 'Aleppo',
                    'country_id' => 215,
                ),
            3409 =>
                array (
                    'id' => 3458,
                    'name' => 'Dar\'a',
                    'country_id' => 215,
                ),
            3410 =>
                array (
                    'id' => 3459,
                    'name' => 'Dayr-az-Zawr',
                    'country_id' => 215,
                ),
            3411 =>
                array (
                    'id' => 3460,
                    'name' => 'Dimashq',
                    'country_id' => 215,
                ),
            3412 =>
                array (
                    'id' => 3461,
                    'name' => 'Halab',
                    'country_id' => 215,
                ),
            3413 =>
                array (
                    'id' => 3462,
                    'name' => 'Hamah',
                    'country_id' => 215,
                ),
            3414 =>
                array (
                    'id' => 3463,
                    'name' => 'Hims',
                    'country_id' => 215,
                ),
            3415 =>
                array (
                    'id' => 3464,
                    'name' => 'Idlib',
                    'country_id' => 215,
                ),
            3416 =>
                array (
                    'id' => 3465,
                    'name' => 'Madinat Dimashq',
                    'country_id' => 215,
                ),
            3417 =>
                array (
                    'id' => 3466,
                    'name' => 'Tartus',
                    'country_id' => 215,
                ),
            3418 =>
                array (
                    'id' => 3467,
                    'name' => 'al-Hasakah',
                    'country_id' => 215,
                ),
            3419 =>
                array (
                    'id' => 3468,
                    'name' => 'al-Ladhiqiyah',
                    'country_id' => 215,
                ),
            3420 =>
                array (
                    'id' => 3469,
                    'name' => 'al-Qunaytirah',
                    'country_id' => 215,
                ),
            3421 =>
                array (
                    'id' => 3470,
                    'name' => 'ar-Raqqah',
                    'country_id' => 215,
                ),
            3422 =>
                array (
                    'id' => 3471,
                    'name' => 'as-Suwayda',
                    'country_id' => 215,
                ),
            3423 =>
                array (
                    'id' => 3472,
                    'name' => 'Changhwa',
                    'country_id' => 216,
                ),
            3424 =>
                array (
                    'id' => 3473,
                    'name' => 'Chiayi Hsien',
                    'country_id' => 216,
                ),
            3425 =>
                array (
                    'id' => 3474,
                    'name' => 'Chiayi Shih',
                    'country_id' => 216,
                ),
            3426 =>
                array (
                    'id' => 3475,
                    'name' => 'Eastern Taipei',
                    'country_id' => 216,
                ),
            3427 =>
                array (
                    'id' => 3476,
                    'name' => 'Hsinchu Hsien',
                    'country_id' => 216,
                ),
            3428 =>
                array (
                    'id' => 3477,
                    'name' => 'Hsinchu Shih',
                    'country_id' => 216,
                ),
            3429 =>
                array (
                    'id' => 3478,
                    'name' => 'Hualien',
                    'country_id' => 216,
                ),
            3430 =>
                array (
                    'id' => 3479,
                    'name' => 'Ilan',
                    'country_id' => 216,
                ),
            3431 =>
                array (
                    'id' => 3480,
                    'name' => 'Kaohsiung Hsien',
                    'country_id' => 216,
                ),
            3432 =>
                array (
                    'id' => 3481,
                    'name' => 'Kaohsiung Shih',
                    'country_id' => 216,
                ),
            3433 =>
                array (
                    'id' => 3482,
                    'name' => 'Keelung Shih',
                    'country_id' => 216,
                ),
            3434 =>
                array (
                    'id' => 3483,
                    'name' => 'Kinmen',
                    'country_id' => 216,
                ),
            3435 =>
                array (
                    'id' => 3484,
                    'name' => 'Miaoli',
                    'country_id' => 216,
                ),
            3436 =>
                array (
                    'id' => 3485,
                    'name' => 'Nantou',
                    'country_id' => 216,
                ),
            3437 =>
                array (
                    'id' => 3486,
                    'name' => 'Northern Taiwan',
                    'country_id' => 216,
                ),
            3438 =>
                array (
                    'id' => 3487,
                    'name' => 'Penghu',
                    'country_id' => 216,
                ),
            3439 =>
                array (
                    'id' => 3488,
                    'name' => 'Pingtung',
                    'country_id' => 216,
                ),
            3440 =>
                array (
                    'id' => 3489,
                    'name' => 'Taichung',
                    'country_id' => 216,
                ),
            3441 =>
                array (
                    'id' => 3490,
                    'name' => 'Taichung Hsien',
                    'country_id' => 216,
                ),
            3442 =>
                array (
                    'id' => 3491,
                    'name' => 'Taichung Shih',
                    'country_id' => 216,
                ),
            3443 =>
                array (
                    'id' => 3492,
                    'name' => 'Tainan Hsien',
                    'country_id' => 216,
                ),
            3444 =>
                array (
                    'id' => 3493,
                    'name' => 'Tainan Shih',
                    'country_id' => 216,
                ),
            3445 =>
                array (
                    'id' => 3494,
                    'name' => 'Taipei Hsien',
                    'country_id' => 216,
                ),
            3446 =>
                array (
                    'id' => 3495,
                    'name' => 'Taipei Shih / Taipei Hsien',
                    'country_id' => 216,
                ),
            3447 =>
                array (
                    'id' => 3496,
                    'name' => 'Taitung',
                    'country_id' => 216,
                ),
            3448 =>
                array (
                    'id' => 3497,
                    'name' => 'Taoyuan',
                    'country_id' => 216,
                ),
            3449 =>
                array (
                    'id' => 3498,
                    'name' => 'Yilan',
                    'country_id' => 216,
                ),
            3450 =>
                array (
                    'id' => 3499,
                    'name' => 'Yun-Lin Hsien',
                    'country_id' => 216,
                ),
            3451 =>
                array (
                    'id' => 3500,
                    'name' => 'Yunlin',
                    'country_id' => 216,
                ),
            3452 =>
                array (
                    'id' => 3501,
                    'name' => 'Dushanbe',
                    'country_id' => 217,
                ),
            3453 =>
                array (
                    'id' => 3502,
                    'name' => 'Gorno-Badakhshan',
                    'country_id' => 217,
                ),
            3454 =>
                array (
                    'id' => 3503,
                    'name' => 'Karotegin',
                    'country_id' => 217,
                ),
            3455 =>
                array (
                    'id' => 3504,
                    'name' => 'Khatlon',
                    'country_id' => 217,
                ),
            3456 =>
                array (
                    'id' => 3505,
                    'name' => 'Sughd',
                    'country_id' => 217,
                ),
            3457 =>
                array (
                    'id' => 3506,
                    'name' => 'Arusha',
                    'country_id' => 218,
                ),
            3458 =>
                array (
                    'id' => 3507,
                    'name' => 'Dar es Salaam',
                    'country_id' => 218,
                ),
            3459 =>
                array (
                    'id' => 3508,
                    'name' => 'Dodoma',
                    'country_id' => 218,
                ),
            3460 =>
                array (
                    'id' => 3509,
                    'name' => 'Iringa',
                    'country_id' => 218,
                ),
            3461 =>
                array (
                    'id' => 3510,
                    'name' => 'Kagera',
                    'country_id' => 218,
                ),
            3462 =>
                array (
                    'id' => 3511,
                    'name' => 'Kigoma',
                    'country_id' => 218,
                ),
            3463 =>
                array (
                    'id' => 3512,
                    'name' => 'Kilimanjaro',
                    'country_id' => 218,
                ),
            3464 =>
                array (
                    'id' => 3513,
                    'name' => 'Lindi',
                    'country_id' => 218,
                ),
            3465 =>
                array (
                    'id' => 3514,
                    'name' => 'Mara',
                    'country_id' => 218,
                ),
            3466 =>
                array (
                    'id' => 3515,
                    'name' => 'Mbeya',
                    'country_id' => 218,
                ),
            3467 =>
                array (
                    'id' => 3516,
                    'name' => 'Morogoro',
                    'country_id' => 218,
                ),
            3468 =>
                array (
                    'id' => 3517,
                    'name' => 'Mtwara',
                    'country_id' => 218,
                ),
            3469 =>
                array (
                    'id' => 3518,
                    'name' => 'Mwanza',
                    'country_id' => 218,
                ),
            3470 =>
                array (
                    'id' => 3519,
                    'name' => 'Pwani',
                    'country_id' => 218,
                ),
            3471 =>
                array (
                    'id' => 3520,
                    'name' => 'Rukwa',
                    'country_id' => 218,
                ),
            3472 =>
                array (
                    'id' => 3521,
                    'name' => 'Ruvuma',
                    'country_id' => 218,
                ),
            3473 =>
                array (
                    'id' => 3522,
                    'name' => 'Shinyanga',
                    'country_id' => 218,
                ),
            3474 =>
                array (
                    'id' => 3523,
                    'name' => 'Singida',
                    'country_id' => 218,
                ),
            3475 =>
                array (
                    'id' => 3524,
                    'name' => 'Tabora',
                    'country_id' => 218,
                ),
            3476 =>
                array (
                    'id' => 3525,
                    'name' => 'Tanga',
                    'country_id' => 218,
                ),
            3477 =>
                array (
                    'id' => 3526,
                    'name' => 'Zanzibar and Pemba',
                    'country_id' => 218,
                ),
            3478 =>
                array (
                    'id' => 3527,
                    'name' => 'Amnat Charoen',
                    'country_id' => 219,
                ),
            3479 =>
                array (
                    'id' => 3528,
                    'name' => 'Ang Thong',
                    'country_id' => 219,
                ),
            3480 =>
                array (
                    'id' => 3529,
                    'name' => 'Bangkok',
                    'country_id' => 219,
                ),
            3481 =>
                array (
                    'id' => 3530,
                    'name' => 'Buri Ram',
                    'country_id' => 219,
                ),
            3482 =>
                array (
                    'id' => 3531,
                    'name' => 'Chachoengsao',
                    'country_id' => 219,
                ),
            3483 =>
                array (
                    'id' => 3532,
                    'name' => 'Chai Nat',
                    'country_id' => 219,
                ),
            3484 =>
                array (
                    'id' => 3533,
                    'name' => 'Chaiyaphum',
                    'country_id' => 219,
                ),
            3485 =>
                array (
                    'id' => 3534,
                    'name' => 'Changwat Chaiyaphum',
                    'country_id' => 219,
                ),
            3486 =>
                array (
                    'id' => 3535,
                    'name' => 'Chanthaburi',
                    'country_id' => 219,
                ),
            3487 =>
                array (
                    'id' => 3536,
                    'name' => 'Chiang Mai',
                    'country_id' => 219,
                ),
            3488 =>
                array (
                    'id' => 3537,
                    'name' => 'Chiang Rai',
                    'country_id' => 219,
                ),
            3489 =>
                array (
                    'id' => 3538,
                    'name' => 'Chon Buri',
                    'country_id' => 219,
                ),
            3490 =>
                array (
                    'id' => 3539,
                    'name' => 'Chumphon',
                    'country_id' => 219,
                ),
            3491 =>
                array (
                    'id' => 3540,
                    'name' => 'Kalasin',
                    'country_id' => 219,
                ),
            3492 =>
                array (
                    'id' => 3541,
                    'name' => 'Kamphaeng Phet',
                    'country_id' => 219,
                ),
            3493 =>
                array (
                    'id' => 3542,
                    'name' => 'Kanchanaburi',
                    'country_id' => 219,
                ),
            3494 =>
                array (
                    'id' => 3543,
                    'name' => 'Khon Kaen',
                    'country_id' => 219,
                ),
            3495 =>
                array (
                    'id' => 3544,
                    'name' => 'Krabi',
                    'country_id' => 219,
                ),
            3496 =>
                array (
                    'id' => 3545,
                    'name' => 'Krung Thep',
                    'country_id' => 219,
                ),
            3497 =>
                array (
                    'id' => 3546,
                    'name' => 'Lampang',
                    'country_id' => 219,
                ),
            3498 =>
                array (
                    'id' => 3547,
                    'name' => 'Lamphun',
                    'country_id' => 219,
                ),
            3499 =>
                array (
                    'id' => 3548,
                    'name' => 'Loei',
                    'country_id' => 219,
                ),
            3500 =>
                array (
                    'id' => 3549,
                    'name' => 'Lop Buri',
                    'country_id' => 219,
                ),
            3501 =>
                array (
                    'id' => 3550,
                    'name' => 'Mae Hong Son',
                    'country_id' => 219,
                ),
            3502 =>
                array (
                    'id' => 3551,
                    'name' => 'Maha Sarakham',
                    'country_id' => 219,
                ),
            3503 =>
                array (
                    'id' => 3552,
                    'name' => 'Mukdahan',
                    'country_id' => 219,
                ),
            3504 =>
                array (
                    'id' => 3553,
                    'name' => 'Nakhon Nayok',
                    'country_id' => 219,
                ),
            3505 =>
                array (
                    'id' => 3554,
                    'name' => 'Nakhon Pathom',
                    'country_id' => 219,
                ),
            3506 =>
                array (
                    'id' => 3555,
                    'name' => 'Nakhon Phanom',
                    'country_id' => 219,
                ),
            3507 =>
                array (
                    'id' => 3556,
                    'name' => 'Nakhon Ratchasima',
                    'country_id' => 219,
                ),
            3508 =>
                array (
                    'id' => 3557,
                    'name' => 'Nakhon Sawan',
                    'country_id' => 219,
                ),
            3509 =>
                array (
                    'id' => 3558,
                    'name' => 'Nakhon Si Thammarat',
                    'country_id' => 219,
                ),
            3510 =>
                array (
                    'id' => 3559,
                    'name' => 'Nan',
                    'country_id' => 219,
                ),
            3511 =>
                array (
                    'id' => 3560,
                    'name' => 'Narathiwat',
                    'country_id' => 219,
                ),
            3512 =>
                array (
                    'id' => 3561,
                    'name' => 'Nong Bua Lam Phu',
                    'country_id' => 219,
                ),
            3513 =>
                array (
                    'id' => 3562,
                    'name' => 'Nong Khai',
                    'country_id' => 219,
                ),
            3514 =>
                array (
                    'id' => 3563,
                    'name' => 'Nonthaburi',
                    'country_id' => 219,
                ),
            3515 =>
                array (
                    'id' => 3564,
                    'name' => 'Pathum Thani',
                    'country_id' => 219,
                ),
            3516 =>
                array (
                    'id' => 3565,
                    'name' => 'Pattani',
                    'country_id' => 219,
                ),
            3517 =>
                array (
                    'id' => 3566,
                    'name' => 'Phangnga',
                    'country_id' => 219,
                ),
            3518 =>
                array (
                    'id' => 3567,
                    'name' => 'Phatthalung',
                    'country_id' => 219,
                ),
            3519 =>
                array (
                    'id' => 3568,
                    'name' => 'Phayao',
                    'country_id' => 219,
                ),
            3520 =>
                array (
                    'id' => 3569,
                    'name' => 'Phetchabun',
                    'country_id' => 219,
                ),
            3521 =>
                array (
                    'id' => 3570,
                    'name' => 'Phetchaburi',
                    'country_id' => 219,
                ),
            3522 =>
                array (
                    'id' => 3571,
                    'name' => 'Phichit',
                    'country_id' => 219,
                ),
            3523 =>
                array (
                    'id' => 3572,
                    'name' => 'Phitsanulok',
                    'country_id' => 219,
                ),
            3524 =>
                array (
                    'id' => 3573,
                    'name' => 'Phra Nakhon Si Ayutthaya',
                    'country_id' => 219,
                ),
            3525 =>
                array (
                    'id' => 3574,
                    'name' => 'Phrae',
                    'country_id' => 219,
                ),
            3526 =>
                array (
                    'id' => 3575,
                    'name' => 'Phuket',
                    'country_id' => 219,
                ),
            3527 =>
                array (
                    'id' => 3576,
                    'name' => 'Prachin Buri',
                    'country_id' => 219,
                ),
            3528 =>
                array (
                    'id' => 3577,
                    'name' => 'Prachuap Khiri Khan',
                    'country_id' => 219,
                ),
            3529 =>
                array (
                    'id' => 3578,
                    'name' => 'Ranong',
                    'country_id' => 219,
                ),
            3530 =>
                array (
                    'id' => 3579,
                    'name' => 'Ratchaburi',
                    'country_id' => 219,
                ),
            3531 =>
                array (
                    'id' => 3580,
                    'name' => 'Rayong',
                    'country_id' => 219,
                ),
            3532 =>
                array (
                    'id' => 3581,
                    'name' => 'Roi Et',
                    'country_id' => 219,
                ),
            3533 =>
                array (
                    'id' => 3582,
                    'name' => 'Sa Kaeo',
                    'country_id' => 219,
                ),
            3534 =>
                array (
                    'id' => 3583,
                    'name' => 'Sakon Nakhon',
                    'country_id' => 219,
                ),
            3535 =>
                array (
                    'id' => 3584,
                    'name' => 'Samut Prakan',
                    'country_id' => 219,
                ),
            3536 =>
                array (
                    'id' => 3585,
                    'name' => 'Samut Sakhon',
                    'country_id' => 219,
                ),
            3537 =>
                array (
                    'id' => 3586,
                    'name' => 'Samut Songkhran',
                    'country_id' => 219,
                ),
            3538 =>
                array (
                    'id' => 3587,
                    'name' => 'Saraburi',
                    'country_id' => 219,
                ),
            3539 =>
                array (
                    'id' => 3588,
                    'name' => 'Satun',
                    'country_id' => 219,
                ),
            3540 =>
                array (
                    'id' => 3589,
                    'name' => 'Si Sa Ket',
                    'country_id' => 219,
                ),
            3541 =>
                array (
                    'id' => 3590,
                    'name' => 'Sing Buri',
                    'country_id' => 219,
                ),
            3542 =>
                array (
                    'id' => 3591,
                    'name' => 'Songkhla',
                    'country_id' => 219,
                ),
            3543 =>
                array (
                    'id' => 3592,
                    'name' => 'Sukhothai',
                    'country_id' => 219,
                ),
            3544 =>
                array (
                    'id' => 3593,
                    'name' => 'Suphan Buri',
                    'country_id' => 219,
                ),
            3545 =>
                array (
                    'id' => 3594,
                    'name' => 'Surat Thani',
                    'country_id' => 219,
                ),
            3546 =>
                array (
                    'id' => 3595,
                    'name' => 'Surin',
                    'country_id' => 219,
                ),
            3547 =>
                array (
                    'id' => 3596,
                    'name' => 'Tak',
                    'country_id' => 219,
                ),
            3548 =>
                array (
                    'id' => 3597,
                    'name' => 'Trang',
                    'country_id' => 219,
                ),
            3549 =>
                array (
                    'id' => 3598,
                    'name' => 'Trat',
                    'country_id' => 219,
                ),
            3550 =>
                array (
                    'id' => 3599,
                    'name' => 'Ubon Ratchathani',
                    'country_id' => 219,
                ),
            3551 =>
                array (
                    'id' => 3600,
                    'name' => 'Udon Thani',
                    'country_id' => 219,
                ),
            3552 =>
                array (
                    'id' => 3601,
                    'name' => 'Uthai Thani',
                    'country_id' => 219,
                ),
            3553 =>
                array (
                    'id' => 3602,
                    'name' => 'Uttaradit',
                    'country_id' => 219,
                ),
            3554 =>
                array (
                    'id' => 3603,
                    'name' => 'Yala',
                    'country_id' => 219,
                ),
            3555 =>
                array (
                    'id' => 3604,
                    'name' => 'Yasothon',
                    'country_id' => 219,
                ),
            3556 =>
                array (
                    'id' => 3605,
                    'name' => 'Centre',
                    'country_id' => 220,
                ),
            3557 =>
                array (
                    'id' => 3606,
                    'name' => 'Kara',
                    'country_id' => 220,
                ),
            3558 =>
                array (
                    'id' => 3607,
                    'name' => 'Maritime',
                    'country_id' => 220,
                ),
            3559 =>
                array (
                    'id' => 3608,
                    'name' => 'Plateaux',
                    'country_id' => 220,
                ),
            3560 =>
                array (
                    'id' => 3609,
                    'name' => 'Savanes',
                    'country_id' => 220,
                ),
            3561 =>
                array (
                    'id' => 3610,
                    'name' => 'Atafu',
                    'country_id' => 221,
                ),
            3562 =>
                array (
                    'id' => 3611,
                    'name' => 'Fakaofo',
                    'country_id' => 221,
                ),
            3563 =>
                array (
                    'id' => 3612,
                    'name' => 'Nukunonu',
                    'country_id' => 221,
                ),
            3564 =>
                array (
                    'id' => 3613,
                    'name' => 'Eua',
                    'country_id' => 222,
                ),
            3565 =>
                array (
                    'id' => 3614,
                    'name' => 'Ha\'apai',
                    'country_id' => 222,
                ),
            3566 =>
                array (
                    'id' => 3615,
                    'name' => 'Niuas',
                    'country_id' => 222,
                ),
            3567 =>
                array (
                    'id' => 3616,
                    'name' => 'Tongatapu',
                    'country_id' => 222,
                ),
            3568 =>
                array (
                    'id' => 3617,
                    'name' => 'Vava\'u',
                    'country_id' => 222,
                ),
            3569 =>
                array (
                    'id' => 3618,
                    'name' => 'Arima-Tunapuna-Piarco',
                    'country_id' => 223,
                ),
            3570 =>
                array (
                    'id' => 3619,
                    'name' => 'Caroni',
                    'country_id' => 223,
                ),
            3571 =>
                array (
                    'id' => 3620,
                    'name' => 'Chaguanas',
                    'country_id' => 223,
                ),
            3572 =>
                array (
                    'id' => 3621,
                    'name' => 'Couva-Tabaquite-Talparo',
                    'country_id' => 223,
                ),
            3573 =>
                array (
                    'id' => 3622,
                    'name' => 'Diego Martin',
                    'country_id' => 223,
                ),
            3574 =>
                array (
                    'id' => 3623,
                    'name' => 'Glencoe',
                    'country_id' => 223,
                ),
            3575 =>
                array (
                    'id' => 3624,
                    'name' => 'Penal Debe',
                    'country_id' => 223,
                ),
            3576 =>
                array (
                    'id' => 3625,
                    'name' => 'Point Fortin',
                    'country_id' => 223,
                ),
            3577 =>
                array (
                    'id' => 3626,
                    'name' => 'Port of Spain',
                    'country_id' => 223,
                ),
            3578 =>
                array (
                    'id' => 3627,
                    'name' => 'Princes Town',
                    'country_id' => 223,
                ),
            3579 =>
                array (
                    'id' => 3628,
                    'name' => 'Saint George',
                    'country_id' => 223,
                ),
            3580 =>
                array (
                    'id' => 3629,
                    'name' => 'San Fernando',
                    'country_id' => 223,
                ),
            3581 =>
                array (
                    'id' => 3630,
                    'name' => 'San Juan',
                    'country_id' => 223,
                ),
            3582 =>
                array (
                    'id' => 3631,
                    'name' => 'Sangre Grande',
                    'country_id' => 223,
                ),
            3583 =>
                array (
                    'id' => 3632,
                    'name' => 'Siparia',
                    'country_id' => 223,
                ),
            3584 =>
                array (
                    'id' => 3633,
                    'name' => 'Tobago',
                    'country_id' => 223,
                ),
            3585 =>
                array (
                    'id' => 3634,
                    'name' => 'Aryanah',
                    'country_id' => 224,
                ),
            3586 =>
                array (
                    'id' => 3635,
                    'name' => 'Bajah',
                    'country_id' => 224,
                ),
            3587 =>
                array (
                    'id' => 3636,
                    'name' => 'Bin \'Arus',
                    'country_id' => 224,
                ),
            3588 =>
                array (
                    'id' => 3637,
                    'name' => 'Binzart',
                    'country_id' => 224,
                ),
            3589 =>
                array (
                    'id' => 3638,
                    'name' => 'Gouvernorat de Ariana',
                    'country_id' => 224,
                ),
            3590 =>
                array (
                    'id' => 3639,
                    'name' => 'Gouvernorat de Nabeul',
                    'country_id' => 224,
                ),
            3591 =>
                array (
                    'id' => 3640,
                    'name' => 'Gouvernorat de Sousse',
                    'country_id' => 224,
                ),
            3592 =>
                array (
                    'id' => 3641,
                    'name' => 'Hammamet Yasmine',
                    'country_id' => 224,
                ),
            3593 =>
                array (
                    'id' => 3642,
                    'name' => 'Jundubah',
                    'country_id' => 224,
                ),
            3594 =>
                array (
                    'id' => 3643,
                    'name' => 'Madaniyin',
                    'country_id' => 224,
                ),
            3595 =>
                array (
                    'id' => 3644,
                    'name' => 'Manubah',
                    'country_id' => 224,
                ),
            3596 =>
                array (
                    'id' => 3645,
                    'name' => 'Monastir',
                    'country_id' => 224,
                ),
            3597 =>
                array (
                    'id' => 3646,
                    'name' => 'Nabul',
                    'country_id' => 224,
                ),
            3598 =>
                array (
                    'id' => 3647,
                    'name' => 'Qabis',
                    'country_id' => 224,
                ),
            3599 =>
                array (
                    'id' => 3648,
                    'name' => 'Qafsah',
                    'country_id' => 224,
                ),
            3600 =>
                array (
                    'id' => 3649,
                    'name' => 'Qibili',
                    'country_id' => 224,
                ),
            3601 =>
                array (
                    'id' => 3650,
                    'name' => 'Safaqis',
                    'country_id' => 224,
                ),
            3602 =>
                array (
                    'id' => 3651,
                    'name' => 'Sfax',
                    'country_id' => 224,
                ),
            3603 =>
                array (
                    'id' => 3652,
                    'name' => 'Sidi Bu Zayd',
                    'country_id' => 224,
                ),
            3604 =>
                array (
                    'id' => 3653,
                    'name' => 'Silyanah',
                    'country_id' => 224,
                ),
            3605 =>
                array (
                    'id' => 3654,
                    'name' => 'Susah',
                    'country_id' => 224,
                ),
            3606 =>
                array (
                    'id' => 3655,
                    'name' => 'Tatawin',
                    'country_id' => 224,
                ),
            3607 =>
                array (
                    'id' => 3656,
                    'name' => 'Tawzar',
                    'country_id' => 224,
                ),
            3608 =>
                array (
                    'id' => 3657,
                    'name' => 'Tunis',
                    'country_id' => 224,
                ),
            3609 =>
                array (
                    'id' => 3658,
                    'name' => 'Zaghwan',
                    'country_id' => 224,
                ),
            3610 =>
                array (
                    'id' => 3659,
                    'name' => 'al-Kaf',
                    'country_id' => 224,
                ),
            3611 =>
                array (
                    'id' => 3660,
                    'name' => 'al-Mahdiyah',
                    'country_id' => 224,
                ),
            3612 =>
                array (
                    'id' => 3661,
                    'name' => 'al-Munastir',
                    'country_id' => 224,
                ),
            3613 =>
                array (
                    'id' => 3662,
                    'name' => 'al-Qasrayn',
                    'country_id' => 224,
                ),
            3614 =>
                array (
                    'id' => 3663,
                    'name' => 'al-Qayrawan',
                    'country_id' => 224,
                ),
            3615 =>
                array (
                    'id' => 3664,
                    'name' => 'Adana',
                    'country_id' => 225,
                ),
            3616 =>
                array (
                    'id' => 3665,
                    'name' => 'Adiyaman',
                    'country_id' => 225,
                ),
            3617 =>
                array (
                    'id' => 3666,
                    'name' => 'Afyon',
                    'country_id' => 225,
                ),
            3618 =>
                array (
                    'id' => 3667,
                    'name' => 'Agri',
                    'country_id' => 225,
                ),
            3619 =>
                array (
                    'id' => 3668,
                    'name' => 'Aksaray',
                    'country_id' => 225,
                ),
            3620 =>
                array (
                    'id' => 3669,
                    'name' => 'Amasya',
                    'country_id' => 225,
                ),
            3621 =>
                array (
                    'id' => 3670,
                    'name' => 'Ankara',
                    'country_id' => 225,
                ),
            3622 =>
                array (
                    'id' => 3671,
                    'name' => 'Antalya',
                    'country_id' => 225,
                ),
            3623 =>
                array (
                    'id' => 3672,
                    'name' => 'Ardahan',
                    'country_id' => 225,
                ),
            3624 =>
                array (
                    'id' => 3673,
                    'name' => 'Artvin',
                    'country_id' => 225,
                ),
            3625 =>
                array (
                    'id' => 3674,
                    'name' => 'Aydin',
                    'country_id' => 225,
                ),
            3626 =>
                array (
                    'id' => 3675,
                    'name' => 'Balikesir',
                    'country_id' => 225,
                ),
            3627 =>
                array (
                    'id' => 3676,
                    'name' => 'Bartin',
                    'country_id' => 225,
                ),
            3628 =>
                array (
                    'id' => 3677,
                    'name' => 'Batman',
                    'country_id' => 225,
                ),
            3629 =>
                array (
                    'id' => 3678,
                    'name' => 'Bayburt',
                    'country_id' => 225,
                ),
            3630 =>
                array (
                    'id' => 3679,
                    'name' => 'Bilecik',
                    'country_id' => 225,
                ),
            3631 =>
                array (
                    'id' => 3680,
                    'name' => 'Bingol',
                    'country_id' => 225,
                ),
            3632 =>
                array (
                    'id' => 3681,
                    'name' => 'Bitlis',
                    'country_id' => 225,
                ),
            3633 =>
                array (
                    'id' => 3682,
                    'name' => 'Bolu',
                    'country_id' => 225,
                ),
            3634 =>
                array (
                    'id' => 3683,
                    'name' => 'Burdur',
                    'country_id' => 225,
                ),
            3635 =>
                array (
                    'id' => 3684,
                    'name' => 'Bursa',
                    'country_id' => 225,
                ),
            3636 =>
                array (
                    'id' => 3685,
                    'name' => 'Canakkale',
                    'country_id' => 225,
                ),
            3637 =>
                array (
                    'id' => 3686,
                    'name' => 'Cankiri',
                    'country_id' => 225,
                ),
            3638 =>
                array (
                    'id' => 3687,
                    'name' => 'Corum',
                    'country_id' => 225,
                ),
            3639 =>
                array (
                    'id' => 3688,
                    'name' => 'Denizli',
                    'country_id' => 225,
                ),
            3640 =>
                array (
                    'id' => 3689,
                    'name' => 'Diyarbakir',
                    'country_id' => 225,
                ),
            3641 =>
                array (
                    'id' => 3690,
                    'name' => 'Duzce',
                    'country_id' => 225,
                ),
            3642 =>
                array (
                    'id' => 3691,
                    'name' => 'Edirne',
                    'country_id' => 225,
                ),
            3643 =>
                array (
                    'id' => 3692,
                    'name' => 'Elazig',
                    'country_id' => 225,
                ),
            3644 =>
                array (
                    'id' => 3693,
                    'name' => 'Erzincan',
                    'country_id' => 225,
                ),
            3645 =>
                array (
                    'id' => 3694,
                    'name' => 'Erzurum',
                    'country_id' => 225,
                ),
            3646 =>
                array (
                    'id' => 3695,
                    'name' => 'Eskisehir',
                    'country_id' => 225,
                ),
            3647 =>
                array (
                    'id' => 3696,
                    'name' => 'Gaziantep',
                    'country_id' => 225,
                ),
            3648 =>
                array (
                    'id' => 3697,
                    'name' => 'Giresun',
                    'country_id' => 225,
                ),
            3649 =>
                array (
                    'id' => 3698,
                    'name' => 'Gumushane',
                    'country_id' => 225,
                ),
            3650 =>
                array (
                    'id' => 3699,
                    'name' => 'Hakkari',
                    'country_id' => 225,
                ),
            3651 =>
                array (
                    'id' => 3700,
                    'name' => 'Hatay',
                    'country_id' => 225,
                ),
            3652 =>
                array (
                    'id' => 3701,
                    'name' => 'Icel',
                    'country_id' => 225,
                ),
            3653 =>
                array (
                    'id' => 3702,
                    'name' => 'Igdir',
                    'country_id' => 225,
                ),
            3654 =>
                array (
                    'id' => 3703,
                    'name' => 'Isparta',
                    'country_id' => 225,
                ),
            3655 =>
                array (
                    'id' => 3704,
                    'name' => 'Istanbul',
                    'country_id' => 225,
                ),
            3656 =>
                array (
                    'id' => 3705,
                    'name' => 'Izmir',
                    'country_id' => 225,
                ),
            3657 =>
                array (
                    'id' => 3706,
                    'name' => 'Kahramanmaras',
                    'country_id' => 225,
                ),
            3658 =>
                array (
                    'id' => 3707,
                    'name' => 'Karabuk',
                    'country_id' => 225,
                ),
            3659 =>
                array (
                    'id' => 3708,
                    'name' => 'Karaman',
                    'country_id' => 225,
                ),
            3660 =>
                array (
                    'id' => 3709,
                    'name' => 'Kars',
                    'country_id' => 225,
                ),
            3661 =>
                array (
                    'id' => 3710,
                    'name' => 'Karsiyaka',
                    'country_id' => 225,
                ),
            3662 =>
                array (
                    'id' => 3711,
                    'name' => 'Kastamonu',
                    'country_id' => 225,
                ),
            3663 =>
                array (
                    'id' => 3712,
                    'name' => 'Kayseri',
                    'country_id' => 225,
                ),
            3664 =>
                array (
                    'id' => 3713,
                    'name' => 'Kilis',
                    'country_id' => 225,
                ),
            3665 =>
                array (
                    'id' => 3714,
                    'name' => 'Kirikkale',
                    'country_id' => 225,
                ),
            3666 =>
                array (
                    'id' => 3715,
                    'name' => 'Kirklareli',
                    'country_id' => 225,
                ),
            3667 =>
                array (
                    'id' => 3716,
                    'name' => 'Kirsehir',
                    'country_id' => 225,
                ),
            3668 =>
                array (
                    'id' => 3717,
                    'name' => 'Kocaeli',
                    'country_id' => 225,
                ),
            3669 =>
                array (
                    'id' => 3718,
                    'name' => 'Konya',
                    'country_id' => 225,
                ),
            3670 =>
                array (
                    'id' => 3719,
                    'name' => 'Kutahya',
                    'country_id' => 225,
                ),
            3671 =>
                array (
                    'id' => 3720,
                    'name' => 'Lefkosa',
                    'country_id' => 225,
                ),
            3672 =>
                array (
                    'id' => 3721,
                    'name' => 'Malatya',
                    'country_id' => 225,
                ),
            3673 =>
                array (
                    'id' => 3722,
                    'name' => 'Manisa',
                    'country_id' => 225,
                ),
            3674 =>
                array (
                    'id' => 3723,
                    'name' => 'Mardin',
                    'country_id' => 225,
                ),
            3675 =>
                array (
                    'id' => 3724,
                    'name' => 'Mugla',
                    'country_id' => 225,
                ),
            3676 =>
                array (
                    'id' => 3725,
                    'name' => 'Mus',
                    'country_id' => 225,
                ),
            3677 =>
                array (
                    'id' => 3726,
                    'name' => 'Nevsehir',
                    'country_id' => 225,
                ),
            3678 =>
                array (
                    'id' => 3727,
                    'name' => 'Nigde',
                    'country_id' => 225,
                ),
            3679 =>
                array (
                    'id' => 3728,
                    'name' => 'Ordu',
                    'country_id' => 225,
                ),
            3680 =>
                array (
                    'id' => 3729,
                    'name' => 'Osmaniye',
                    'country_id' => 225,
                ),
            3681 =>
                array (
                    'id' => 3730,
                    'name' => 'Rize',
                    'country_id' => 225,
                ),
            3682 =>
                array (
                    'id' => 3731,
                    'name' => 'Sakarya',
                    'country_id' => 225,
                ),
            3683 =>
                array (
                    'id' => 3732,
                    'name' => 'Samsun',
                    'country_id' => 225,
                ),
            3684 =>
                array (
                    'id' => 3733,
                    'name' => 'Sanliurfa',
                    'country_id' => 225,
                ),
            3685 =>
                array (
                    'id' => 3734,
                    'name' => 'Siirt',
                    'country_id' => 225,
                ),
            3686 =>
                array (
                    'id' => 3735,
                    'name' => 'Sinop',
                    'country_id' => 225,
                ),
            3687 =>
                array (
                    'id' => 3736,
                    'name' => 'Sirnak',
                    'country_id' => 225,
                ),
            3688 =>
                array (
                    'id' => 3737,
                    'name' => 'Sivas',
                    'country_id' => 225,
                ),
            3689 =>
                array (
                    'id' => 3738,
                    'name' => 'Tekirdag',
                    'country_id' => 225,
                ),
            3690 =>
                array (
                    'id' => 3739,
                    'name' => 'Tokat',
                    'country_id' => 225,
                ),
            3691 =>
                array (
                    'id' => 3740,
                    'name' => 'Trabzon',
                    'country_id' => 225,
                ),
            3692 =>
                array (
                    'id' => 3741,
                    'name' => 'Tunceli',
                    'country_id' => 225,
                ),
            3693 =>
                array (
                    'id' => 3742,
                    'name' => 'Usak',
                    'country_id' => 225,
                ),
            3694 =>
                array (
                    'id' => 3743,
                    'name' => 'Van',
                    'country_id' => 225,
                ),
            3695 =>
                array (
                    'id' => 3744,
                    'name' => 'Yalova',
                    'country_id' => 225,
                ),
            3696 =>
                array (
                    'id' => 3745,
                    'name' => 'Yozgat',
                    'country_id' => 225,
                ),
            3697 =>
                array (
                    'id' => 3746,
                    'name' => 'Zonguldak',
                    'country_id' => 225,
                ),
            3698 =>
                array (
                    'id' => 3747,
                    'name' => 'Ahal',
                    'country_id' => 226,
                ),
            3699 =>
                array (
                    'id' => 3748,
                    'name' => 'Asgabat',
                    'country_id' => 226,
                ),
            3700 =>
                array (
                    'id' => 3749,
                    'name' => 'Balkan',
                    'country_id' => 226,
                ),
            3701 =>
                array (
                    'id' => 3750,
                    'name' => 'Dasoguz',
                    'country_id' => 226,
                ),
            3702 =>
                array (
                    'id' => 3751,
                    'name' => 'Lebap',
                    'country_id' => 226,
                ),
            3703 =>
                array (
                    'id' => 3752,
                    'name' => 'Mari',
                    'country_id' => 226,
                ),
            3704 =>
                array (
                    'id' => 3753,
                    'name' => 'Grand Turk',
                    'country_id' => 227,
                ),
            3705 =>
                array (
                    'id' => 3754,
                    'name' => 'South Caicos and East Caicos',
                    'country_id' => 227,
                ),
            3706 =>
                array (
                    'id' => 3755,
                    'name' => 'Funafuti',
                    'country_id' => 228,
                ),
            3707 =>
                array (
                    'id' => 3756,
                    'name' => 'Nanumanga',
                    'country_id' => 228,
                ),
            3708 =>
                array (
                    'id' => 3757,
                    'name' => 'Nanumea',
                    'country_id' => 228,
                ),
            3709 =>
                array (
                    'id' => 3758,
                    'name' => 'Niutao',
                    'country_id' => 228,
                ),
            3710 =>
                array (
                    'id' => 3759,
                    'name' => 'Nui',
                    'country_id' => 228,
                ),
            3711 =>
                array (
                    'id' => 3760,
                    'name' => 'Nukufetau',
                    'country_id' => 228,
                ),
            3712 =>
                array (
                    'id' => 3761,
                    'name' => 'Nukulaelae',
                    'country_id' => 228,
                ),
            3713 =>
                array (
                    'id' => 3762,
                    'name' => 'Vaitupu',
                    'country_id' => 228,
                ),
            3714 =>
                array (
                    'id' => 3763,
                    'name' => 'Central',
                    'country_id' => 229,
                ),
            3715 =>
                array (
                    'id' => 3764,
                    'name' => 'Eastern',
                    'country_id' => 229,
                ),
            3716 =>
                array (
                    'id' => 3765,
                    'name' => 'Northern',
                    'country_id' => 229,
                ),
            3717 =>
                array (
                    'id' => 3766,
                    'name' => 'Western',
                    'country_id' => 229,
                ),
            3718 =>
                array (
                    'id' => 3767,
                    'name' => 'Cherkas\'ka',
                    'country_id' => 230,
                ),
            3719 =>
                array (
                    'id' => 3768,
                    'name' => 'Chernihivs\'ka',
                    'country_id' => 230,
                ),
            3720 =>
                array (
                    'id' => 3769,
                    'name' => 'Chernivets\'ka',
                    'country_id' => 230,
                ),
            3721 =>
                array (
                    'id' => 3770,
                    'name' => 'Crimea',
                    'country_id' => 230,
                ),
            3722 =>
                array (
                    'id' => 3771,
                    'name' => 'Dnipropetrovska',
                    'country_id' => 230,
                ),
            3723 =>
                array (
                    'id' => 3772,
                    'name' => 'Donets\'ka',
                    'country_id' => 230,
                ),
            3724 =>
                array (
                    'id' => 3773,
                    'name' => 'Ivano-Frankivs\'ka',
                    'country_id' => 230,
                ),
            3725 =>
                array (
                    'id' => 3774,
                    'name' => 'Kharkiv',
                    'country_id' => 230,
                ),
            3726 =>
                array (
                    'id' => 3775,
                    'name' => 'Kharkov',
                    'country_id' => 230,
                ),
            3727 =>
                array (
                    'id' => 3776,
                    'name' => 'Khersonska',
                    'country_id' => 230,
                ),
            3728 =>
                array (
                    'id' => 3777,
                    'name' => 'Khmel\'nyts\'ka',
                    'country_id' => 230,
                ),
            3729 =>
                array (
                    'id' => 3778,
                    'name' => 'Kirovohrad',
                    'country_id' => 230,
                ),
            3730 =>
                array (
                    'id' => 3779,
                    'name' => 'Krym',
                    'country_id' => 230,
                ),
            3731 =>
                array (
                    'id' => 3780,
                    'name' => 'Kyyiv',
                    'country_id' => 230,
                ),
            3732 =>
                array (
                    'id' => 3781,
                    'name' => 'Kyyivs\'ka',
                    'country_id' => 230,
                ),
            3733 =>
                array (
                    'id' => 3782,
                    'name' => 'L\'vivs\'ka',
                    'country_id' => 230,
                ),
            3734 =>
                array (
                    'id' => 3783,
                    'name' => 'Luhans\'ka',
                    'country_id' => 230,
                ),
            3735 =>
                array (
                    'id' => 3784,
                    'name' => 'Mykolayivs\'ka',
                    'country_id' => 230,
                ),
            3736 =>
                array (
                    'id' => 3785,
                    'name' => 'Odes\'ka',
                    'country_id' => 230,
                ),
            3737 =>
                array (
                    'id' => 3786,
                    'name' => 'Odessa',
                    'country_id' => 230,
                ),
            3738 =>
                array (
                    'id' => 3787,
                    'name' => 'Poltavs\'ka',
                    'country_id' => 230,
                ),
            3739 =>
                array (
                    'id' => 3788,
                    'name' => 'Rivnens\'ka',
                    'country_id' => 230,
                ),
            3740 =>
                array (
                    'id' => 3789,
                    'name' => 'Sevastopol\'',
                    'country_id' => 230,
                ),
            3741 =>
                array (
                    'id' => 3790,
                    'name' => 'Sums\'ka',
                    'country_id' => 230,
                ),
            3742 =>
                array (
                    'id' => 3791,
                    'name' => 'Ternopil\'s\'ka',
                    'country_id' => 230,
                ),
            3743 =>
                array (
                    'id' => 3792,
                    'name' => 'Volyns\'ka',
                    'country_id' => 230,
                ),
            3744 =>
                array (
                    'id' => 3793,
                    'name' => 'Vynnyts\'ka',
                    'country_id' => 230,
                ),
            3745 =>
                array (
                    'id' => 3794,
                    'name' => 'Zakarpats\'ka',
                    'country_id' => 230,
                ),
            3746 =>
                array (
                    'id' => 3795,
                    'name' => 'Zaporizhia',
                    'country_id' => 230,
                ),
            3747 =>
                array (
                    'id' => 3796,
                    'name' => 'Zhytomyrs\'ka',
                    'country_id' => 230,
                ),
            3748 =>
                array (
                    'id' => 3797,
                    'name' => 'Abu Zabi',
                    'country_id' => 231,
                ),
            3749 =>
                array (
                    'id' => 3798,
                    'name' => 'Ajman',
                    'country_id' => 231,
                ),
            3750 =>
                array (
                    'id' => 3799,
                    'name' => 'Dubai',
                    'country_id' => 231,
                ),
            3751 =>
                array (
                    'id' => 3800,
                    'name' => 'Ras al-Khaymah',
                    'country_id' => 231,
                ),
            3752 =>
                array (
                    'id' => 3801,
                    'name' => 'Sharjah',
                    'country_id' => 231,
                ),
            3753 =>
                array (
                    'id' => 3802,
                    'name' => 'Sharjha',
                    'country_id' => 231,
                ),
            3754 =>
                array (
                    'id' => 3803,
                    'name' => 'Umm al Qaywayn',
                    'country_id' => 231,
                ),
            3755 =>
                array (
                    'id' => 3804,
                    'name' => 'al-Fujayrah',
                    'country_id' => 231,
                ),
            3756 =>
                array (
                    'id' => 3805,
                    'name' => 'ash-Shariqah',
                    'country_id' => 231,
                ),
            3757 =>
                array (
                    'id' => 3806,
                    'name' => 'Aberdeen',
                    'country_id' => 232,
                ),
            3758 =>
                array (
                    'id' => 3807,
                    'name' => 'Aberdeenshire',
                    'country_id' => 232,
                ),
            3759 =>
                array (
                    'id' => 3808,
                    'name' => 'Argyll',
                    'country_id' => 232,
                ),
            3760 =>
                array (
                    'id' => 3809,
                    'name' => 'Armagh',
                    'country_id' => 232,
                ),
            3761 =>
                array (
                    'id' => 3810,
                    'name' => 'Bedfordshire',
                    'country_id' => 232,
                ),
            3762 =>
                array (
                    'id' => 3811,
                    'name' => 'Belfast',
                    'country_id' => 232,
                ),
            3763 =>
                array (
                    'id' => 3812,
                    'name' => 'Berkshire',
                    'country_id' => 232,
                ),
            3764 =>
                array (
                    'id' => 3813,
                    'name' => 'Birmingham',
                    'country_id' => 232,
                ),
            3765 =>
                array (
                    'id' => 3814,
                    'name' => 'Brechin',
                    'country_id' => 232,
                ),
            3766 =>
                array (
                    'id' => 3815,
                    'name' => 'Bridgnorth',
                    'country_id' => 232,
                ),
            3767 =>
                array (
                    'id' => 3816,
                    'name' => 'Bristol',
                    'country_id' => 232,
                ),
            3768 =>
                array (
                    'id' => 3817,
                    'name' => 'Buckinghamshire',
                    'country_id' => 232,
                ),
            3769 =>
                array (
                    'id' => 3818,
                    'name' => 'Cambridge',
                    'country_id' => 232,
                ),
            3770 =>
                array (
                    'id' => 3819,
                    'name' => 'Cambridgeshire',
                    'country_id' => 232,
                ),
            3771 =>
                array (
                    'id' => 3820,
                    'name' => 'Channel Islands',
                    'country_id' => 232,
                ),
            3772 =>
                array (
                    'id' => 3821,
                    'name' => 'Cheshire',
                    'country_id' => 232,
                ),
            3773 =>
                array (
                    'id' => 3822,
                    'name' => 'Cleveland',
                    'country_id' => 232,
                ),
            3774 =>
                array (
                    'id' => 3823,
                    'name' => 'Co Fermanagh',
                    'country_id' => 232,
                ),
            3775 =>
                array (
                    'id' => 3824,
                    'name' => 'Conwy',
                    'country_id' => 232,
                ),
            3776 =>
                array (
                    'id' => 3825,
                    'name' => 'Cornwall',
                    'country_id' => 232,
                ),
            3777 =>
                array (
                    'id' => 3826,
                    'name' => 'Coventry',
                    'country_id' => 232,
                ),
            3778 =>
                array (
                    'id' => 3827,
                    'name' => 'Craven Arms',
                    'country_id' => 232,
                ),
            3779 =>
                array (
                    'id' => 3828,
                    'name' => 'Cumbria',
                    'country_id' => 232,
                ),
            3780 =>
                array (
                    'id' => 3829,
                    'name' => 'Denbighshire',
                    'country_id' => 232,
                ),
            3781 =>
                array (
                    'id' => 3830,
                    'name' => 'Derby',
                    'country_id' => 232,
                ),
            3782 =>
                array (
                    'id' => 3831,
                    'name' => 'Derbyshire',
                    'country_id' => 232,
                ),
            3783 =>
                array (
                    'id' => 3832,
                    'name' => 'Devon',
                    'country_id' => 232,
                ),
            3784 =>
                array (
                    'id' => 3833,
                    'name' => 'Dial Code Dungannon',
                    'country_id' => 232,
                ),
            3785 =>
                array (
                    'id' => 3834,
                    'name' => 'Didcot',
                    'country_id' => 232,
                ),
            3786 =>
                array (
                    'id' => 3835,
                    'name' => 'Dorset',
                    'country_id' => 232,
                ),
            3787 =>
                array (
                    'id' => 3836,
                    'name' => 'Dunbartonshire',
                    'country_id' => 232,
                ),
            3788 =>
                array (
                    'id' => 3837,
                    'name' => 'Durham',
                    'country_id' => 232,
                ),
            3789 =>
                array (
                    'id' => 3838,
                    'name' => 'East Dunbartonshire',
                    'country_id' => 232,
                ),
            3790 =>
                array (
                    'id' => 3839,
                    'name' => 'East Lothian',
                    'country_id' => 232,
                ),
            3791 =>
                array (
                    'id' => 3840,
                    'name' => 'East Midlands',
                    'country_id' => 232,
                ),
            3792 =>
                array (
                    'id' => 3841,
                    'name' => 'East Sussex',
                    'country_id' => 232,
                ),
            3793 =>
                array (
                    'id' => 3842,
                    'name' => 'East Yorkshire',
                    'country_id' => 232,
                ),
            3794 =>
                array (
                    'id' => 3843,
                    'name' => 'England',
                    'country_id' => 232,
                ),
            3795 =>
                array (
                    'id' => 3844,
                    'name' => 'Essex',
                    'country_id' => 232,
                ),
            3796 =>
                array (
                    'id' => 3845,
                    'name' => 'Fermanagh',
                    'country_id' => 232,
                ),
            3797 =>
                array (
                    'id' => 3846,
                    'name' => 'Fife',
                    'country_id' => 232,
                ),
            3798 =>
                array (
                    'id' => 3847,
                    'name' => 'Flintshire',
                    'country_id' => 232,
                ),
            3799 =>
                array (
                    'id' => 3848,
                    'name' => 'Fulham',
                    'country_id' => 232,
                ),
            3800 =>
                array (
                    'id' => 3849,
                    'name' => 'Gainsborough',
                    'country_id' => 232,
                ),
            3801 =>
                array (
                    'id' => 3850,
                    'name' => 'Glocestershire',
                    'country_id' => 232,
                ),
            3802 =>
                array (
                    'id' => 3851,
                    'name' => 'Gwent',
                    'country_id' => 232,
                ),
            3803 =>
                array (
                    'id' => 3852,
                    'name' => 'Hampshire',
                    'country_id' => 232,
                ),
            3804 =>
                array (
                    'id' => 3853,
                    'name' => 'Hants',
                    'country_id' => 232,
                ),
            3805 =>
                array (
                    'id' => 3854,
                    'name' => 'Herefordshire',
                    'country_id' => 232,
                ),
            3806 =>
                array (
                    'id' => 3855,
                    'name' => 'Hertfordshire',
                    'country_id' => 232,
                ),
            3807 =>
                array (
                    'id' => 3856,
                    'name' => 'Ireland',
                    'country_id' => 232,
                ),
            3808 =>
                array (
                    'id' => 3857,
                    'name' => 'Isle Of Man',
                    'country_id' => 232,
                ),
            3809 =>
                array (
                    'id' => 3858,
                    'name' => 'Isle of Wight',
                    'country_id' => 232,
                ),
            3810 =>
                array (
                    'id' => 3859,
                    'name' => 'Kenford',
                    'country_id' => 232,
                ),
            3811 =>
                array (
                    'id' => 3860,
                    'name' => 'Kent',
                    'country_id' => 232,
                ),
            3812 =>
                array (
                    'id' => 3861,
                    'name' => 'Kilmarnock',
                    'country_id' => 232,
                ),
            3813 =>
                array (
                    'id' => 3862,
                    'name' => 'Lanarkshire',
                    'country_id' => 232,
                ),
            3814 =>
                array (
                    'id' => 3863,
                    'name' => 'Lancashire',
                    'country_id' => 232,
                ),
            3815 =>
                array (
                    'id' => 3864,
                    'name' => 'Leicestershire',
                    'country_id' => 232,
                ),
            3816 =>
                array (
                    'id' => 3865,
                    'name' => 'Lincolnshire',
                    'country_id' => 232,
                ),
            3817 =>
                array (
                    'id' => 3866,
                    'name' => 'Llanymynech',
                    'country_id' => 232,
                ),
            3818 =>
                array (
                    'id' => 3867,
                    'name' => 'London',
                    'country_id' => 232,
                ),
            3819 =>
                array (
                    'id' => 3868,
                    'name' => 'Ludlow',
                    'country_id' => 232,
                ),
            3820 =>
                array (
                    'id' => 3869,
                    'name' => 'Manchester',
                    'country_id' => 232,
                ),
            3821 =>
                array (
                    'id' => 3870,
                    'name' => 'Mayfair',
                    'country_id' => 232,
                ),
            3822 =>
                array (
                    'id' => 3871,
                    'name' => 'Merseyside',
                    'country_id' => 232,
                ),
            3823 =>
                array (
                    'id' => 3872,
                    'name' => 'Mid Glamorgan',
                    'country_id' => 232,
                ),
            3824 =>
                array (
                    'id' => 3873,
                    'name' => 'Middlesex',
                    'country_id' => 232,
                ),
            3825 =>
                array (
                    'id' => 3874,
                    'name' => 'Mildenhall',
                    'country_id' => 232,
                ),
            3826 =>
                array (
                    'id' => 3875,
                    'name' => 'Monmouthshire',
                    'country_id' => 232,
                ),
            3827 =>
                array (
                    'id' => 3876,
                    'name' => 'Newton Stewart',
                    'country_id' => 232,
                ),
            3828 =>
                array (
                    'id' => 3877,
                    'name' => 'Norfolk',
                    'country_id' => 232,
                ),
            3829 =>
                array (
                    'id' => 3878,
                    'name' => 'North Humberside',
                    'country_id' => 232,
                ),
            3830 =>
                array (
                    'id' => 3879,
                    'name' => 'North Yorkshire',
                    'country_id' => 232,
                ),
            3831 =>
                array (
                    'id' => 3880,
                    'name' => 'Northamptonshire',
                    'country_id' => 232,
                ),
            3832 =>
                array (
                    'id' => 3881,
                    'name' => 'Northants',
                    'country_id' => 232,
                ),
            3833 =>
                array (
                    'id' => 3882,
                    'name' => 'Northern Ireland',
                    'country_id' => 232,
                ),
            3834 =>
                array (
                    'id' => 3883,
                    'name' => 'Northumberland',
                    'country_id' => 232,
                ),
            3835 =>
                array (
                    'id' => 3884,
                    'name' => 'Nottinghamshire',
                    'country_id' => 232,
                ),
            3836 =>
                array (
                    'id' => 3885,
                    'name' => 'Oxford',
                    'country_id' => 232,
                ),
            3837 =>
                array (
                    'id' => 3886,
                    'name' => 'Powys',
                    'country_id' => 232,
                ),
            3838 =>
                array (
                    'id' => 3887,
                    'name' => 'Roos-shire',
                    'country_id' => 232,
                ),
            3839 =>
                array (
                    'id' => 3888,
                    'name' => 'SUSSEX',
                    'country_id' => 232,
                ),
            3840 =>
                array (
                    'id' => 3889,
                    'name' => 'Sark',
                    'country_id' => 232,
                ),
            3841 =>
                array (
                    'id' => 3890,
                    'name' => 'Scotland',
                    'country_id' => 232,
                ),
            3842 =>
                array (
                    'id' => 3891,
                    'name' => 'Scottish Borders',
                    'country_id' => 232,
                ),
            3843 =>
                array (
                    'id' => 3892,
                    'name' => 'Shropshire',
                    'country_id' => 232,
                ),
            3844 =>
                array (
                    'id' => 3893,
                    'name' => 'Somerset',
                    'country_id' => 232,
                ),
            3845 =>
                array (
                    'id' => 3894,
                    'name' => 'South Glamorgan',
                    'country_id' => 232,
                ),
            3846 =>
                array (
                    'id' => 3895,
                    'name' => 'South Wales',
                    'country_id' => 232,
                ),
            3847 =>
                array (
                    'id' => 3896,
                    'name' => 'South Yorkshire',
                    'country_id' => 232,
                ),
            3848 =>
                array (
                    'id' => 3897,
                    'name' => 'Southwell',
                    'country_id' => 232,
                ),
            3849 =>
                array (
                    'id' => 3898,
                    'name' => 'Staffordshire',
                    'country_id' => 232,
                ),
            3850 =>
                array (
                    'id' => 3899,
                    'name' => 'Strabane',
                    'country_id' => 232,
                ),
            3851 =>
                array (
                    'id' => 3900,
                    'name' => 'Suffolk',
                    'country_id' => 232,
                ),
            3852 =>
                array (
                    'id' => 3901,
                    'name' => 'Surrey',
                    'country_id' => 232,
                ),
            3853 =>
                array (
                    'id' => 3902,
                    'name' => 'Sussex',
                    'country_id' => 232,
                ),
            3854 =>
                array (
                    'id' => 3903,
                    'name' => 'Twickenham',
                    'country_id' => 232,
                ),
            3855 =>
                array (
                    'id' => 3904,
                    'name' => 'Tyne and Wear',
                    'country_id' => 232,
                ),
            3856 =>
                array (
                    'id' => 3905,
                    'name' => 'Tyrone',
                    'country_id' => 232,
                ),
            3857 =>
                array (
                    'id' => 3906,
                    'name' => 'Utah',
                    'country_id' => 232,
                ),
            3858 =>
                array (
                    'id' => 3907,
                    'name' => 'Wales',
                    'country_id' => 232,
                ),
            3859 =>
                array (
                    'id' => 3908,
                    'name' => 'Warwickshire',
                    'country_id' => 232,
                ),
            3860 =>
                array (
                    'id' => 3909,
                    'name' => 'West Lothian',
                    'country_id' => 232,
                ),
            3861 =>
                array (
                    'id' => 3910,
                    'name' => 'West Midlands',
                    'country_id' => 232,
                ),
            3862 =>
                array (
                    'id' => 3911,
                    'name' => 'West Sussex',
                    'country_id' => 232,
                ),
            3863 =>
                array (
                    'id' => 3912,
                    'name' => 'West Yorkshire',
                    'country_id' => 232,
                ),
            3864 =>
                array (
                    'id' => 3913,
                    'name' => 'Whissendine',
                    'country_id' => 232,
                ),
            3865 =>
                array (
                    'id' => 3914,
                    'name' => 'Wiltshire',
                    'country_id' => 232,
                ),
            3866 =>
                array (
                    'id' => 3915,
                    'name' => 'Wokingham',
                    'country_id' => 232,
                ),
            3867 =>
                array (
                    'id' => 3916,
                    'name' => 'Worcestershire',
                    'country_id' => 232,
                ),
            3868 =>
                array (
                    'id' => 3917,
                    'name' => 'Wrexham',
                    'country_id' => 232,
                ),
            3869 =>
                array (
                    'id' => 3918,
                    'name' => 'Wurttemberg',
                    'country_id' => 232,
                ),
            3870 =>
                array (
                    'id' => 3919,
                    'name' => 'Yorkshire',
                    'country_id' => 232,
                ),
            3871 =>
                array (
                    'id' => 3920,
                    'name' => 'Alabama',
                    'country_id' => 233,
                ),
            3872 =>
                array (
                    'id' => 3921,
                    'name' => 'Alaska',
                    'country_id' => 233,
                ),
            3873 =>
                array (
                    'id' => 3922,
                    'name' => 'Arizona',
                    'country_id' => 233,
                ),
            3874 =>
                array (
                    'id' => 3923,
                    'name' => 'Arkansas',
                    'country_id' => 233,
                ),
            3875 =>
                array (
                    'id' => 3924,
                    'name' => 'Byram',
                    'country_id' => 233,
                ),
            3876 =>
                array (
                    'id' => 3925,
                    'name' => 'California',
                    'country_id' => 233,
                ),
            3877 =>
                array (
                    'id' => 3926,
                    'name' => 'Cokato',
                    'country_id' => 233,
                ),
            3878 =>
                array (
                    'id' => 3927,
                    'name' => 'Colorado',
                    'country_id' => 233,
                ),
            3879 =>
                array (
                    'id' => 3928,
                    'name' => 'Connecticut',
                    'country_id' => 233,
                ),
            3880 =>
                array (
                    'id' => 3929,
                    'name' => 'Delaware',
                    'country_id' => 233,
                ),
            3881 =>
                array (
                    'id' => 3930,
                    'name' => 'District of Columbia',
                    'country_id' => 233,
                ),
            3882 =>
                array (
                    'id' => 3931,
                    'name' => 'Florida',
                    'country_id' => 233,
                ),
            3883 =>
                array (
                    'id' => 3932,
                    'name' => 'Georgia',
                    'country_id' => 233,
                ),
            3884 =>
                array (
                    'id' => 3933,
                    'name' => 'Hawaii',
                    'country_id' => 233,
                ),
            3885 =>
                array (
                    'id' => 3934,
                    'name' => 'Idaho',
                    'country_id' => 233,
                ),
            3886 =>
                array (
                    'id' => 3935,
                    'name' => 'Illinois',
                    'country_id' => 233,
                ),
            3887 =>
                array (
                    'id' => 3936,
                    'name' => 'Indiana',
                    'country_id' => 233,
                ),
            3888 =>
                array (
                    'id' => 3937,
                    'name' => 'Iowa',
                    'country_id' => 233,
                ),
            3889 =>
                array (
                    'id' => 3938,
                    'name' => 'Kansas',
                    'country_id' => 233,
                ),
            3890 =>
                array (
                    'id' => 3939,
                    'name' => 'Kentucky',
                    'country_id' => 233,
                ),
            3891 =>
                array (
                    'id' => 3940,
                    'name' => 'Louisiana',
                    'country_id' => 233,
                ),
            3892 =>
                array (
                    'id' => 3941,
                    'name' => 'Lowa',
                    'country_id' => 233,
                ),
            3893 =>
                array (
                    'id' => 3942,
                    'name' => 'Maine',
                    'country_id' => 233,
                ),
            3894 =>
                array (
                    'id' => 3943,
                    'name' => 'Maryland',
                    'country_id' => 233,
                ),
            3895 =>
                array (
                    'id' => 3944,
                    'name' => 'Massachusetts',
                    'country_id' => 233,
                ),
            3896 =>
                array (
                    'id' => 3945,
                    'name' => 'Medfield',
                    'country_id' => 233,
                ),
            3897 =>
                array (
                    'id' => 3946,
                    'name' => 'Michigan',
                    'country_id' => 233,
                ),
            3898 =>
                array (
                    'id' => 3947,
                    'name' => 'Minnesota',
                    'country_id' => 233,
                ),
            3899 =>
                array (
                    'id' => 3948,
                    'name' => 'Mississippi',
                    'country_id' => 233,
                ),
            3900 =>
                array (
                    'id' => 3949,
                    'name' => 'Missouri',
                    'country_id' => 233,
                ),
            3901 =>
                array (
                    'id' => 3950,
                    'name' => 'Montana',
                    'country_id' => 233,
                ),
            3902 =>
                array (
                    'id' => 3951,
                    'name' => 'Nebraska',
                    'country_id' => 233,
                ),
            3903 =>
                array (
                    'id' => 3952,
                    'name' => 'Nevada',
                    'country_id' => 233,
                ),
            3904 =>
                array (
                    'id' => 3953,
                    'name' => 'New Hampshire',
                    'country_id' => 233,
                ),
            3905 =>
                array (
                    'id' => 3954,
                    'name' => 'New Jersey',
                    'country_id' => 233,
                ),
            3906 =>
                array (
                    'id' => 3955,
                    'name' => 'New Jersy',
                    'country_id' => 233,
                ),
            3907 =>
                array (
                    'id' => 3956,
                    'name' => 'New Mexico',
                    'country_id' => 233,
                ),
            3908 =>
                array (
                    'id' => 3957,
                    'name' => 'New York',
                    'country_id' => 233,
                ),
            3909 =>
                array (
                    'id' => 3958,
                    'name' => 'North Carolina',
                    'country_id' => 233,
                ),
            3910 =>
                array (
                    'id' => 3959,
                    'name' => 'North Dakota',
                    'country_id' => 233,
                ),
            3911 =>
                array (
                    'id' => 3960,
                    'name' => 'Ohio',
                    'country_id' => 233,
                ),
            3912 =>
                array (
                    'id' => 3961,
                    'name' => 'Oklahoma',
                    'country_id' => 233,
                ),
            3913 =>
                array (
                    'id' => 3962,
                    'name' => 'Ontario',
                    'country_id' => 233,
                ),
            3914 =>
                array (
                    'id' => 3963,
                    'name' => 'Oregon',
                    'country_id' => 233,
                ),
            3915 =>
                array (
                    'id' => 3964,
                    'name' => 'Pennsylvania',
                    'country_id' => 233,
                ),
            3916 =>
                array (
                    'id' => 3965,
                    'name' => 'Ramey',
                    'country_id' => 233,
                ),
            3917 =>
                array (
                    'id' => 3966,
                    'name' => 'Rhode Island',
                    'country_id' => 233,
                ),
            3918 =>
                array (
                    'id' => 3967,
                    'name' => 'South Carolina',
                    'country_id' => 233,
                ),
            3919 =>
                array (
                    'id' => 3968,
                    'name' => 'South Dakota',
                    'country_id' => 233,
                ),
            3920 =>
                array (
                    'id' => 3969,
                    'name' => 'Sublimity',
                    'country_id' => 233,
                ),
            3921 =>
                array (
                    'id' => 3970,
                    'name' => 'Tennessee',
                    'country_id' => 233,
                ),
            3922 =>
                array (
                    'id' => 3971,
                    'name' => 'Texas',
                    'country_id' => 233,
                ),
            3923 =>
                array (
                    'id' => 3972,
                    'name' => 'Trimble',
                    'country_id' => 233,
                ),
            3924 =>
                array (
                    'id' => 3973,
                    'name' => 'Utah',
                    'country_id' => 233,
                ),
            3925 =>
                array (
                    'id' => 3974,
                    'name' => 'Vermont',
                    'country_id' => 233,
                ),
            3926 =>
                array (
                    'id' => 3975,
                    'name' => 'Virginia',
                    'country_id' => 233,
                ),
            3927 =>
                array (
                    'id' => 3976,
                    'name' => 'Washington',
                    'country_id' => 233,
                ),
            3928 =>
                array (
                    'id' => 3977,
                    'name' => 'West Virginia',
                    'country_id' => 233,
                ),
            3929 =>
                array (
                    'id' => 3978,
                    'name' => 'Wisconsin',
                    'country_id' => 233,
                ),
            3930 =>
                array (
                    'id' => 3979,
                    'name' => 'Wyoming',
                    'country_id' => 233,
                ),
            3931 =>
                array (
                    'id' => 3980,
                    'name' => 'United States Minor Outlying I',
                    'country_id' => 234,
                ),
            3932 =>
                array (
                    'id' => 3981,
                    'name' => 'Artigas',
                    'country_id' => 235,
                ),
            3933 =>
                array (
                    'id' => 3982,
                    'name' => 'Canelones',
                    'country_id' => 235,
                ),
            3934 =>
                array (
                    'id' => 3983,
                    'name' => 'Cerro Largo',
                    'country_id' => 235,
                ),
            3935 =>
                array (
                    'id' => 3984,
                    'name' => 'Colonia',
                    'country_id' => 235,
                ),
            3936 =>
                array (
                    'id' => 3985,
                    'name' => 'Durazno',
                    'country_id' => 235,
                ),
            3937 =>
                array (
                    'id' => 3986,
                    'name' => 'FLorida',
                    'country_id' => 235,
                ),
            3938 =>
                array (
                    'id' => 3987,
                    'name' => 'Flores',
                    'country_id' => 235,
                ),
            3939 =>
                array (
                    'id' => 3988,
                    'name' => 'Lavalleja',
                    'country_id' => 235,
                ),
            3940 =>
                array (
                    'id' => 3989,
                    'name' => 'Maldonado',
                    'country_id' => 235,
                ),
            3941 =>
                array (
                    'id' => 3990,
                    'name' => 'Montevideo',
                    'country_id' => 235,
                ),
            3942 =>
                array (
                    'id' => 3991,
                    'name' => 'Paysandu',
                    'country_id' => 235,
                ),
            3943 =>
                array (
                    'id' => 3992,
                    'name' => 'Rio Negro',
                    'country_id' => 235,
                ),
            3944 =>
                array (
                    'id' => 3993,
                    'name' => 'Rivera',
                    'country_id' => 235,
                ),
            3945 =>
                array (
                    'id' => 3994,
                    'name' => 'Rocha',
                    'country_id' => 235,
                ),
            3946 =>
                array (
                    'id' => 3995,
                    'name' => 'Salto',
                    'country_id' => 235,
                ),
            3947 =>
                array (
                    'id' => 3996,
                    'name' => 'San Jose',
                    'country_id' => 235,
                ),
            3948 =>
                array (
                    'id' => 3997,
                    'name' => 'Soriano',
                    'country_id' => 235,
                ),
            3949 =>
                array (
                    'id' => 3998,
                    'name' => 'Tacuarembo',
                    'country_id' => 235,
                ),
            3950 =>
                array (
                    'id' => 3999,
                    'name' => 'Treinta y Tres',
                    'country_id' => 235,
                ),
            3951 =>
                array (
                    'id' => 4000,
                    'name' => 'Andijon',
                    'country_id' => 236,
                ),
            3952 =>
                array (
                    'id' => 4001,
                    'name' => 'Buhoro',
                    'country_id' => 236,
                ),
            3953 =>
                array (
                    'id' => 4002,
                    'name' => 'Buxoro Viloyati',
                    'country_id' => 236,
                ),
            3954 =>
                array (
                    'id' => 4003,
                    'name' => 'Cizah',
                    'country_id' => 236,
                ),
            3955 =>
                array (
                    'id' => 4004,
                    'name' => 'Fargona',
                    'country_id' => 236,
                ),
            3956 =>
                array (
                    'id' => 4005,
                    'name' => 'Horazm',
                    'country_id' => 236,
                ),
            3957 =>
                array (
                    'id' => 4006,
                    'name' => 'Kaskadar',
                    'country_id' => 236,
                ),
            3958 =>
                array (
                    'id' => 4007,
                    'name' => 'Korakalpogiston',
                    'country_id' => 236,
                ),
            3959 =>
                array (
                    'id' => 4008,
                    'name' => 'Namangan',
                    'country_id' => 236,
                ),
            3960 =>
                array (
                    'id' => 4009,
                    'name' => 'Navoi',
                    'country_id' => 236,
                ),
            3961 =>
                array (
                    'id' => 4010,
                    'name' => 'Samarkand',
                    'country_id' => 236,
                ),
            3962 =>
                array (
                    'id' => 4011,
                    'name' => 'Sirdare',
                    'country_id' => 236,
                ),
            3963 =>
                array (
                    'id' => 4012,
                    'name' => 'Surhondar',
                    'country_id' => 236,
                ),
            3964 =>
                array (
                    'id' => 4013,
                    'name' => 'Toskent',
                    'country_id' => 236,
                ),
            3965 =>
                array (
                    'id' => 4014,
                    'name' => 'Malampa',
                    'country_id' => 237,
                ),
            3966 =>
                array (
                    'id' => 4015,
                    'name' => 'Penama',
                    'country_id' => 237,
                ),
            3967 =>
                array (
                    'id' => 4016,
                    'name' => 'Sanma',
                    'country_id' => 237,
                ),
            3968 =>
                array (
                    'id' => 4017,
                    'name' => 'Shefa',
                    'country_id' => 237,
                ),
            3969 =>
                array (
                    'id' => 4018,
                    'name' => 'Tafea',
                    'country_id' => 237,
                ),
            3970 =>
                array (
                    'id' => 4019,
                    'name' => 'Torba',
                    'country_id' => 237,
                ),
            3971 =>
                array (
                    'id' => 4020,
                    'name' => 'Vatican City State (Holy See)',
                    'country_id' => 238,
                ),
            3972 =>
                array (
                    'id' => 4021,
                    'name' => 'Amazonas',
                    'country_id' => 239,
                ),
            3973 =>
                array (
                    'id' => 4022,
                    'name' => 'Anzoategui',
                    'country_id' => 239,
                ),
            3974 =>
                array (
                    'id' => 4023,
                    'name' => 'Apure',
                    'country_id' => 239,
                ),
            3975 =>
                array (
                    'id' => 4024,
                    'name' => 'Aragua',
                    'country_id' => 239,
                ),
            3976 =>
                array (
                    'id' => 4025,
                    'name' => 'Barinas',
                    'country_id' => 239,
                ),
            3977 =>
                array (
                    'id' => 4026,
                    'name' => 'Bolivar',
                    'country_id' => 239,
                ),
            3978 =>
                array (
                    'id' => 4027,
                    'name' => 'Carabobo',
                    'country_id' => 239,
                ),
            3979 =>
                array (
                    'id' => 4028,
                    'name' => 'Cojedes',
                    'country_id' => 239,
                ),
            3980 =>
                array (
                    'id' => 4029,
                    'name' => 'Delta Amacuro',
                    'country_id' => 239,
                ),
            3981 =>
                array (
                    'id' => 4030,
                    'name' => 'Distrito Federal',
                    'country_id' => 239,
                ),
            3982 =>
                array (
                    'id' => 4031,
                    'name' => 'Falcon',
                    'country_id' => 239,
                ),
            3983 =>
                array (
                    'id' => 4032,
                    'name' => 'Guarico',
                    'country_id' => 239,
                ),
            3984 =>
                array (
                    'id' => 4033,
                    'name' => 'Lara',
                    'country_id' => 239,
                ),
            3985 =>
                array (
                    'id' => 4034,
                    'name' => 'Merida',
                    'country_id' => 239,
                ),
            3986 =>
                array (
                    'id' => 4035,
                    'name' => 'Miranda',
                    'country_id' => 239,
                ),
            3987 =>
                array (
                    'id' => 4036,
                    'name' => 'Monagas',
                    'country_id' => 239,
                ),
            3988 =>
                array (
                    'id' => 4037,
                    'name' => 'Nueva Esparta',
                    'country_id' => 239,
                ),
            3989 =>
                array (
                    'id' => 4038,
                    'name' => 'Portuguesa',
                    'country_id' => 239,
                ),
            3990 =>
                array (
                    'id' => 4039,
                    'name' => 'Sucre',
                    'country_id' => 239,
                ),
            3991 =>
                array (
                    'id' => 4040,
                    'name' => 'Tachira',
                    'country_id' => 239,
                ),
            3992 =>
                array (
                    'id' => 4041,
                    'name' => 'Trujillo',
                    'country_id' => 239,
                ),
            3993 =>
                array (
                    'id' => 4042,
                    'name' => 'Vargas',
                    'country_id' => 239,
                ),
            3994 =>
                array (
                    'id' => 4043,
                    'name' => 'Yaracuy',
                    'country_id' => 239,
                ),
            3995 =>
                array (
                    'id' => 4044,
                    'name' => 'Zulia',
                    'country_id' => 239,
                ),
            3996 =>
                array (
                    'id' => 4045,
                    'name' => 'Bac Giang',
                    'country_id' => 240,
                ),
            3997 =>
                array (
                    'id' => 4046,
                    'name' => 'Binh Dinh',
                    'country_id' => 240,
                ),
            3998 =>
                array (
                    'id' => 4047,
                    'name' => 'Binh Duong',
                    'country_id' => 240,
                ),
            3999 =>
                array (
                    'id' => 4048,
                    'name' => 'Da Nang',
                    'country_id' => 240,
                ),
            4000 =>
                array (
                    'id' => 4049,
                    'name' => 'Dong Bang Song Cuu Long',
                    'country_id' => 240,
                ),
            4001 =>
                array (
                    'id' => 4050,
                    'name' => 'Dong Bang Song Hong',
                    'country_id' => 240,
                ),
            4002 =>
                array (
                    'id' => 4051,
                    'name' => 'Dong Nai',
                    'country_id' => 240,
                ),
            4003 =>
                array (
                    'id' => 4052,
                    'name' => 'Dong Nam Bo',
                    'country_id' => 240,
                ),
            4004 =>
                array (
                    'id' => 4053,
                    'name' => 'Duyen Hai Mien Trung',
                    'country_id' => 240,
                ),
            4005 =>
                array (
                    'id' => 4054,
                    'name' => 'Hanoi',
                    'country_id' => 240,
                ),
            4006 =>
                array (
                    'id' => 4055,
                    'name' => 'Hung Yen',
                    'country_id' => 240,
                ),
            4007 =>
                array (
                    'id' => 4056,
                    'name' => 'Khu Bon Cu',
                    'country_id' => 240,
                ),
            4008 =>
                array (
                    'id' => 4057,
                    'name' => 'Long An',
                    'country_id' => 240,
                ),
            4009 =>
                array (
                    'id' => 4058,
                    'name' => 'Mien Nui Va Trung Du',
                    'country_id' => 240,
                ),
            4010 =>
                array (
                    'id' => 4059,
                    'name' => 'Thai Nguyen',
                    'country_id' => 240,
                ),
            4011 =>
                array (
                    'id' => 4060,
                    'name' => 'Thanh Pho Ho Chi Minh',
                    'country_id' => 240,
                ),
            4012 =>
                array (
                    'id' => 4061,
                    'name' => 'Thu Do Ha Noi',
                    'country_id' => 240,
                ),
            4013 =>
                array (
                    'id' => 4062,
                    'name' => 'Tinh Can Tho',
                    'country_id' => 240,
                ),
            4014 =>
                array (
                    'id' => 4063,
                    'name' => 'Tinh Da Nang',
                    'country_id' => 240,
                ),
            4015 =>
                array (
                    'id' => 4064,
                    'name' => 'Tinh Gia Lai',
                    'country_id' => 240,
                ),
            4016 =>
                array (
                    'id' => 4065,
                    'name' => 'Anegada',
                    'country_id' => 241,
                ),
            4017 =>
                array (
                    'id' => 4066,
                    'name' => 'Jost van Dyke',
                    'country_id' => 241,
                ),
            4018 =>
                array (
                    'id' => 4067,
                    'name' => 'Tortola',
                    'country_id' => 241,
                ),
            4019 =>
                array (
                    'id' => 4068,
                    'name' => 'Saint Croix',
                    'country_id' => 242,
                ),
            4020 =>
                array (
                    'id' => 4069,
                    'name' => 'Saint John',
                    'country_id' => 242,
                ),
            4021 =>
                array (
                    'id' => 4070,
                    'name' => 'Saint Thomas',
                    'country_id' => 242,
                ),
            4022 =>
                array (
                    'id' => 4071,
                    'name' => 'Alo',
                    'country_id' => 243,
                ),
            4023 =>
                array (
                    'id' => 4072,
                    'name' => 'Singave',
                    'country_id' => 243,
                ),
            4024 =>
                array (
                    'id' => 4073,
                    'name' => 'Wallis',
                    'country_id' => 243,
                ),
            4025 =>
                array (
                    'id' => 4074,
                    'name' => 'Bu Jaydur',
                    'country_id' => 244,
                ),
            4026 =>
                array (
                    'id' => 4075,
                    'name' => 'Wad-adh-Dhahab',
                    'country_id' => 244,
                ),
            4027 =>
                array (
                    'id' => 4076,
                    'name' => 'al-\'Ayun',
                    'country_id' => 244,
                ),
            4028 =>
                array (
                    'id' => 4077,
                    'name' => 'as-Samarah',
                    'country_id' => 244,
                ),
            4029 =>
                array (
                    'id' => 4078,
                    'name' => '\'Adan',
                    'country_id' => 245,
                ),
            4030 =>
                array (
                    'id' => 4079,
                    'name' => 'Abyan',
                    'country_id' => 245,
                ),
            4031 =>
                array (
                    'id' => 4080,
                    'name' => 'Dhamar',
                    'country_id' => 245,
                ),
            4032 =>
                array (
                    'id' => 4081,
                    'name' => 'Hadramaut',
                    'country_id' => 245,
                ),
            4033 =>
                array (
                    'id' => 4082,
                    'name' => 'Hajjah',
                    'country_id' => 245,
                ),
            4034 =>
                array (
                    'id' => 4083,
                    'name' => 'Hudaydah',
                    'country_id' => 245,
                ),
            4035 =>
                array (
                    'id' => 4084,
                    'name' => 'Ibb',
                    'country_id' => 245,
                ),
            4036 =>
                array (
                    'id' => 4085,
                    'name' => 'Lahij',
                    'country_id' => 245,
                ),
            4037 =>
                array (
                    'id' => 4086,
                    'name' => 'Ma\'rib',
                    'country_id' => 245,
                ),
            4038 =>
                array (
                    'id' => 4087,
                    'name' => 'Madinat San\'a',
                    'country_id' => 245,
                ),
            4039 =>
                array (
                    'id' => 4088,
                    'name' => 'Sa\'dah',
                    'country_id' => 245,
                ),
            4040 =>
                array (
                    'id' => 4089,
                    'name' => 'Sana',
                    'country_id' => 245,
                ),
            4041 =>
                array (
                    'id' => 4090,
                    'name' => 'Shabwah',
                    'country_id' => 245,
                ),
            4042 =>
                array (
                    'id' => 4091,
                    'name' => 'Ta\'izz',
                    'country_id' => 245,
                ),
            4043 =>
                array (
                    'id' => 4092,
                    'name' => 'al-Bayda',
                    'country_id' => 245,
                ),
            4044 =>
                array (
                    'id' => 4093,
                    'name' => 'al-Hudaydah',
                    'country_id' => 245,
                ),
            4045 =>
                array (
                    'id' => 4094,
                    'name' => 'al-Jawf',
                    'country_id' => 245,
                ),
            4046 =>
                array (
                    'id' => 4095,
                    'name' => 'al-Mahrah',
                    'country_id' => 245,
                ),
            4047 =>
                array (
                    'id' => 4096,
                    'name' => 'al-Mahwit',
                    'country_id' => 245,
                ),
            4048 =>
                array (
                    'id' => 4103,
                    'name' => 'Central',
                    'country_id' => 246,
                ),
            4049 =>
                array (
                    'id' => 4104,
                    'name' => 'Copperbelt',
                    'country_id' => 246,
                ),
            4050 =>
                array (
                    'id' => 4105,
                    'name' => 'Eastern',
                    'country_id' => 246,
                ),
            4051 =>
                array (
                    'id' => 4106,
                    'name' => 'Luapala',
                    'country_id' => 246,
                ),
            4052 =>
                array (
                    'id' => 4107,
                    'name' => 'Lusaka',
                    'country_id' => 246,
                ),
            4053 =>
                array (
                    'id' => 4108,
                    'name' => 'North-Western',
                    'country_id' => 246,
                ),
            4054 =>
                array (
                    'id' => 4109,
                    'name' => 'Northern',
                    'country_id' => 246,
                ),
            4055 =>
                array (
                    'id' => 4110,
                    'name' => 'Southern',
                    'country_id' => 246,
                ),
            4056 =>
                array (
                    'id' => 4111,
                    'name' => 'Western',
                    'country_id' => 246,
                ),
            4057 =>
                array (
                    'id' => 4112,
                    'name' => 'Bulawayo',
                    'country_id' => 247,
                ),
            4058 =>
                array (
                    'id' => 4113,
                    'name' => 'Harare',
                    'country_id' => 247,
                ),
            4059 =>
                array (
                    'id' => 4114,
                    'name' => 'Manicaland',
                    'country_id' => 247,
                ),
            4060 =>
                array (
                    'id' => 4115,
                    'name' => 'Mashonaland Central',
                    'country_id' => 247,
                ),
            4061 =>
                array (
                    'id' => 4116,
                    'name' => 'Mashonaland East',
                    'country_id' => 247,
                ),
            4062 =>
                array (
                    'id' => 4117,
                    'name' => 'Mashonaland West',
                    'country_id' => 247,
                ),
            4063 =>
                array (
                    'id' => 4118,
                    'name' => 'Masvingo',
                    'country_id' => 247,
                ),
            4064 =>
                array (
                    'id' => 4119,
                    'name' => 'Matabeleland North',
                    'country_id' => 247,
                ),
            4065 =>
                array (
                    'id' => 4120,
                    'name' => 'Matabeleland South',
                    'country_id' => 247,
                ),
            4066 =>
                array (
                    'id' => 4121,
                    'name' => 'Midlands',
                    'country_id' => 247,
                )
        );
        DB::table('states')
            ->insert($sql);
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
}
