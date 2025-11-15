<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLanguageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('native');
            $table->tinyInteger('rtl')->default('0');
            $table->tinyInteger('status')->default('1');
            $table->tinyInteger('json_exist')->default('0');
            $table->timestamps();
        });

        DB::table('languages')->insert(array(
            0 =>
                array(
                    'code' => 'af',
                    'native' => 'Afrikaans',
                    'name' => 'Afrikaans',
                    'status' => 0,
                    'rtl' => 0,
                ),
            1 =>
                array(
                    'code' => 'am',
                    'native' => 'አማርኛ',
                    'name' => 'Amharic',
                    'status' => 0,
                    'rtl' => 0,
                ),
            2 =>
                array(
                    'code' => 'ar',
                    'native' => 'العربية',
                    'name' => 'Arabic',
                    'status' => 0,
                    'rtl' => 1,
                ),
            3 =>
                array(
                    'code' => 'ay',
                    'native' => 'Aymar',
                    'name' => 'Aymara',
                    'status' => 0,
                    'rtl' => 0,
                ),
            4 =>
                array(
                    'code' => 'az',
                    'native' => 'Azərbaycanca / آذربايجان',
                    'name' => 'Azerbaijani',
                    'status' => 0,
                    'rtl' => 0,
                ),
            5 =>
                array(
                    'code' => 'be',
                    'native' => 'Беларуская',
                    'name' => 'Belarusian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            6 =>
                array(
                    'code' => 'bg',
                    'native' => 'Български',
                    'name' => 'Bulgarian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            7 =>
                array(
                    'code' => 'bi',
                    'native' => 'Bislama',
                    'name' => 'Bislama',
                    'status' => 0,
                    'rtl' => 0,
                ),
            8 =>
                array(
                    'code' => 'bn',
                    'native' => 'বাংলা',
                    'name' => 'Bengali',
                    'status' => 0,
                    'rtl' => 0,
                ),
            9 =>
                array(
                    'code' => 'bs',
                    'native' => 'Bosanski',
                    'name' => 'Bosnian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            10 =>
                array(
                    'code' => 'ca',
                    'native' => 'Català',
                    'name' => 'Catalan',
                    'status' => 0,
                    'rtl' => 0,
                ),
            11 =>
                array(
                    'code' => 'ch',
                    'native' => 'Chamoru',
                    'name' => 'Chamorro',
                    'status' => 0,
                    'rtl' => 0,
                ),
            12 =>
                array(
                    'code' => 'cs',
                    'native' => 'Česky',
                    'name' => 'Czech',
                    'status' => 0,
                    'rtl' => 0,
                ),
            13 =>
                array(
                    'code' => 'da',
                    'native' => 'Dansk',
                    'name' => 'Danish',
                    'status' => 0,
                    'rtl' => 0,
                ),
            14 =>
                array(
                    'code' => 'de',
                    'native' => 'Deutsch',
                    'name' => 'German',
                    'status' => 0,
                    'rtl' => 0,
                ),
            15 =>
                array(
                    'code' => 'dv',
                    'native' => 'ދިވެހިބަސް',
                    'name' => 'Divehi',
                    'status' => 0,
                    'rtl' => 1,
                ),
            16 =>
                array(
                    'code' => 'dz',
                    'native' => 'ཇོང་ཁ',
                    'name' => 'Dzongkha',
                    'status' => 0,
                    'rtl' => 0,
                ),
            17 =>
                array(
                    'code' => 'el',
                    'native' => 'Ελληνικά',
                    'name' => 'Greek',
                    'status' => 0,
                    'rtl' => 0,
                ),
            18 =>
                array(
                    'code' => 'en',
                    'native' => 'English',
                    'name' => 'English',
                    'status' => 1,
                    'rtl' => 0,
                ),
            19 =>
                array(
                    'code' => 'es',
                    'native' => 'Español',
                    'name' => 'Spanish',
                    'status' => 0,
                    'rtl' => 0,
                ),
            20 =>
                array(
                    'code' => 'et',
                    'native' => 'Eesti',
                    'name' => 'Estonian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            21 =>
                array(
                    'code' => 'eu',
                    'native' => 'Euskara',
                    'name' => 'Basque',
                    'status' => 0,
                    'rtl' => 0,
                ),
            22 =>
                array(
                    'code' => 'fa',
                    'native' => 'فارسی',
                    'name' => 'Persian',
                    'status' => 0,
                    'rtl' => 1,
                ),
            23 =>
                array(
                    'code' => 'ff',
                    'native' => 'Fulfulde',
                    'name' => 'Peul',
                    'status' => 0,
                    'rtl' => 0,
                ),
            24 =>
                array(
                    'code' => 'fi',
                    'native' => 'Suomi',
                    'name' => 'Finnish',
                    'status' => 0,
                    'rtl' => 0,
                ),
            25 =>
                array(
                    'code' => 'fj',
                    'native' => 'Na Vosa Vakaviti',
                    'name' => 'Fijian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            26 =>
                array(
                    'code' => 'fo',
                    'native' => 'Føroyskt',
                    'name' => 'Faroese',
                    'status' => 0,
                    'rtl' => 0,
                ),
            27 =>
                array(
                    'code' => 'fr',
                    'native' => 'Français',
                    'name' => 'French',
                    'status' => 0,
                    'rtl' => 0,
                ),
            28 =>
                array(
                    'code' => 'ga',
                    'native' => 'Gaeilge',
                    'name' => 'Irish',
                    'status' => 0,
                    'rtl' => 0,
                ),
            29 =>
                array(
                    'code' => 'gl',
                    'native' => 'Galego',
                    'name' => 'Galician',
                    'status' => 0,
                    'rtl' => 0,
                ),
            30 =>
                array(
                    'code' => 'gn',
                    'native' => 'Avañe\'ẽ',
                    'name' => 'Guarani',
                    'status' => 0,
                    'rtl' => 0,
                ),
            31 =>
                array(
                    'code' => 'gv',
                    'native' => 'Gaelg',
                    'name' => 'Manx',
                    'status' => 0,
                    'rtl' => 0,
                ),
            32 =>
                array(
                    'code' => 'he',
                    'native' => 'עברית',
                    'name' => 'Hebrew',
                    'status' => 0,
                    'rtl' => 1,
                ),
            33 =>
                array(
                    'code' => 'hi',
                    'native' => 'हिन्दी',
                    'name' => 'Hindi',
                    'status' => 0,
                    'rtl' => 0,
                ),
            34 =>
                array(
                    'code' => 'hr',
                    'native' => 'Hrvatski',
                    'name' => 'Croatian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            35 =>
                array(
                    'code' => 'ht',
                    'native' => 'Krèyol ayisyen',
                    'name' => 'Haitian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            36 =>
                array(
                    'code' => 'hu',
                    'native' => 'Magyar',
                    'name' => 'Hungarian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            37 =>
                array(
                    'code' => 'hy',
                    'native' => 'Հայերեն',
                    'name' => 'Armenian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            38 =>
                array(
                    'code' => 'indo',
                    'native' => 'Bahasa Indonesia',
                    'name' => 'Indonesian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            39 =>
                array(
                    'code' => 'is',
                    'native' => 'Íslenska',
                    'name' => 'Icelandic',
                    'status' => 0,
                    'rtl' => 0,
                ),
            40 =>
                array(
                    'code' => 'it',
                    'native' => 'Italiano',
                    'name' => 'Italian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            41 =>
                array(
                    'code' => 'ja',
                    'native' => '日本語',
                    'name' => 'Japanese',
                    'status' => 0,
                    'rtl' => 0,
                ),
            42 =>
                array(
                    'code' => 'ka',
                    'native' => 'ქართული',
                    'name' => 'Georgian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            43 =>
                array(
                    'code' => 'kg',
                    'native' => 'KiKongo',
                    'name' => 'Kongo',
                    'status' => 0,
                    'rtl' => 0,
                ),
            44 =>
                array(
                    'code' => 'kk',
                    'native' => 'Қазақша',
                    'name' => 'Kazakh',
                    'status' => 0,
                    'rtl' => 0,
                ),
            45 =>
                array(
                    'code' => 'kl',
                    'native' => 'Kalaallisut',
                    'name' => 'Greenlandic',
                    'status' => 0,
                    'rtl' => 0,
                ),
            46 =>
                array(
                    'code' => 'km',
                    'native' => 'ភាសាខ្មែរ',
                    'name' => 'Cambodian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            47 =>
                array(
                    'code' => 'ko',
                    'native' => '한국어',
                    'name' => 'Korean',
                    'status' => 0,
                    'rtl' => 0,
                ),
            48 =>
                array(
                    'code' => 'ku',
                    'native' => 'Kurdî / كوردی',
                    'name' => 'Kurdish',
                    'status' => 0,
                    'rtl' => 1,
                ),
            49 =>
                array(
                    'code' => 'ky',
                    'native' => 'Kırgızca / Кыргызча',
                    'name' => 'Kirghiz',
                    'status' => 0,
                    'rtl' => 0,
                ),
            50 =>
                array(
                    'code' => 'la',
                    'native' => 'Latina',
                    'name' => 'Latin',
                    'status' => 0,
                    'rtl' => 0,
                ),
            51 =>
                array(
                    'code' => 'lb',
                    'native' => 'Lëtzebuergesch',
                    'name' => 'Luxembourgish',
                    'status' => 0,
                    'rtl' => 0,
                ),
            52 =>
                array(
                    'code' => 'ln',
                    'native' => 'Lingála',
                    'name' => 'Lingala',
                    'status' => 0,
                    'rtl' => 0,
                ),
            53 =>
                array(
                    'code' => 'lo',
                    'native' => 'ລາວ / Pha xa lao',
                    'name' => 'Laotian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            54 =>
                array(
                    'code' => 'lt',
                    'native' => 'Lietuvių',
                    'name' => 'Lithuanian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            55 =>
                array(
                    'code' => 'lu',
                    'native' => '',
                    'name' => '',
                    'status' => 0,
                    'rtl' => 0,
                ),
            56 =>
                array(
                    'code' => 'lv',
                    'native' => 'Latviešu',
                    'name' => 'Latvian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            57 =>
                array(
                    'code' => 'mg',
                    'native' => 'Malagasy',
                    'name' => 'Malagasy',
                    'status' => 0,
                    'rtl' => 0,
                ),
            58 =>
                array(
                    'code' => 'mh',
                    'native' => 'Kajin Majel / Ebon',
                    'name' => 'Marshallese',
                    'status' => 0,
                    'rtl' => 0,
                ),
            59 =>
                array(
                    'code' => 'mi',
                    'native' => 'Māori',
                    'name' => 'Maori',
                    'status' => 0,
                    'rtl' => 0,
                ),
            60 =>
                array(
                    'code' => 'mk',
                    'native' => 'Македонски',
                    'name' => 'Macedonian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            61 =>
                array(
                    'code' => 'mn',
                    'native' => 'Монгол',
                    'name' => 'Mongolian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            62 =>
                array(
                    'code' => 'ms',
                    'native' => 'Bahasa Melayu',
                    'name' => 'Malay',
                    'status' => 0,
                    'rtl' => 0,
                ),
            63 =>
                array(
                    'code' => 'mt',
                    'native' => 'bil-Malti',
                    'name' => 'Maltese',
                    'status' => 0,
                    'rtl' => 0,
                ),
            64 =>
                array(
                    'code' => 'my',
                    'native' => 'မြန်မာစာ',
                    'name' => 'Burmese',
                    'status' => 0,
                    'rtl' => 0,
                ),
            65 =>
                array(
                    'code' => 'na',
                    'native' => 'Dorerin Naoero',
                    'name' => 'Nauruan',
                    'status' => 0,
                    'rtl' => 0,
                ),
            66 =>
                array(
                    'code' => 'nb',
                    'native' => '',
                    'name' => '',
                    'status' => 0,
                    'rtl' => 0,
                ),
            67 =>
                array(
                    'code' => 'nd',
                    'native' => 'Sindebele',
                    'name' => 'North Ndebele',
                    'status' => 0,
                    'rtl' => 0,
                ),
            68 =>
                array(
                    'code' => 'ne',
                    'native' => 'नेपाली',
                    'name' => 'Nepali',
                    'status' => 0,
                    'rtl' => 0,
                ),
            69 =>
                array(
                    'code' => 'nl',
                    'native' => 'Nederlands',
                    'name' => 'Dutch',
                    'status' => 0,
                    'rtl' => 0,
                ),
            70 =>
                array(
                    'code' => 'nn',
                    'native' => 'Norsk (nynorsk)',
                    'name' => 'Norwegian Nynorsk',
                    'status' => 0,
                    'rtl' => 0,
                ),
            71 =>
                array(
                    'code' => 'no',
                    'native' => 'Norsk (bokmål / riksmål)',
                    'name' => 'Norwegian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            72 =>
                array(
                    'code' => 'nr',
                    'native' => 'isiNdebele',
                    'name' => 'South Ndebele',
                    'status' => 0,
                    'rtl' => 0,
                ),
            73 =>
                array(
                    'code' => 'ny',
                    'native' => 'Chi-Chewa',
                    'name' => 'Chichewa',
                    'status' => 0,
                    'rtl' => 0,
                ),
            74 =>
                array(
                    'code' => 'oc',
                    'native' => 'Occitan',
                    'name' => 'Occitan',
                    'status' => 0,
                    'rtl' => 0,
                ),
            75 =>
                array(
                    'code' => 'pa',
                    'native' => 'ਪੰਜਾਬੀ / पंजाबी / پنجابي',
                    'name' => 'Panjabi / Punjabi',
                    'status' => 0,
                    'rtl' => 0,
                ),
            76 =>
                array(
                    'code' => 'pl',
                    'native' => 'Polski',
                    'name' => 'Polish',
                    'status' => 0,
                    'rtl' => 0,
                ),
            77 =>
                array(
                    'code' => 'ps',
                    'native' => 'پښتو',
                    'name' => 'Pashto',
                    'status' => 0,
                    'rtl' => 1,
                ),
            78 =>
                array(
                    'code' => 'pt',
                    'native' => 'Português',
                    'name' => 'Portuguese',
                    'status' => 0,
                    'rtl' => 0,
                ),
            79 =>
                array(
                    'code' => 'qu',
                    'native' => 'Runa Simi',
                    'name' => 'Quechua',
                    'status' => 0,
                    'rtl' => 0,
                ),
            80 =>
                array(
                    'code' => 'rn',
                    'native' => 'Kirundi',
                    'name' => 'Kirundi',
                    'status' => 0,
                    'rtl' => 0,
                ),
            81 =>
                array(
                    'code' => 'ro',
                    'native' => 'Română',
                    'name' => 'Romanian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            82 =>
                array(
                    'code' => 'ru',
                    'native' => 'Русский',
                    'name' => 'Russian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            83 =>
                array(
                    'code' => 'rw',
                    'native' => 'Kinyarwandi',
                    'name' => 'Rwandi',
                    'status' => 0,
                    'rtl' => 0,
                ),
            84 =>
                array(
                    'code' => 'sg',
                    'native' => 'Sängö',
                    'name' => 'Sango',
                    'status' => 0,
                    'rtl' => 0,
                ),
            85 =>
                array(
                    'code' => 'si',
                    'native' => 'සිංහල',
                    'name' => 'Sinhalese',
                    'status' => 0,
                    'rtl' => 0,
                ),
            86 =>
                array(
                    'code' => 'sk',
                    'native' => 'Slovenčina',
                    'name' => 'Slovak',
                    'status' => 0,
                    'rtl' => 0,
                ),
            87 =>
                array(
                    'code' => 'sl',
                    'native' => 'Slovenščina',
                    'name' => 'Slovenian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            88 =>
                array(
                    'code' => 'sm',
                    'native' => 'Gagana Samoa',
                    'name' => 'Samoan',
                    'status' => 0,
                    'rtl' => 0,
                ),
            89 =>
                array(
                    'code' => 'sn',
                    'native' => 'chiShona',
                    'name' => 'Shona',
                    'status' => 0,
                    'rtl' => 0,
                ),
            90 =>
                array(
                    'code' => 'so',
                    'native' => 'Soomaaliga',
                    'name' => 'Somalia',
                    'status' => 0,
                    'rtl' => 0,
                ),
            91 =>
                array(
                    'code' => 'sq',
                    'native' => 'Shqip',
                    'name' => 'Albanian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            92 =>
                array(
                    'code' => 'sr',
                    'native' => 'Српски',
                    'name' => 'Serbian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            93 =>
                array(
                    'code' => 'ss',
                    'native' => 'SiSwati',
                    'name' => 'Swati',
                    'status' => 0,
                    'rtl' => 0,
                ),
            94 =>
                array(
                    'code' => 'st',
                    'native' => 'Sesotho',
                    'name' => 'Southern Sotho',
                    'status' => 0,
                    'rtl' => 0,
                ),
            95 =>
                array(
                    'code' => 'sv',
                    'native' => 'Svenska',
                    'name' => 'Swedish',
                    'status' => 0,
                    'rtl' => 0,
                ),
            96 =>
                array(
                    'code' => 'sw',
                    'native' => 'Kiswahili',
                    'name' => 'Swahili',
                    'status' => 0,
                    'rtl' => 0,
                ),
            97 =>
                array(
                    'code' => 'ta',
                    'native' => 'தமிழ்',
                    'name' => 'Tamil',
                    'status' => 0,
                    'rtl' => 0,
                ),
            98 =>
                array(
                    'code' => 'tg',
                    'native' => 'Тоҷикӣ',
                    'name' => 'Tajik',
                    'status' => 0,
                    'rtl' => 0,
                ),
            99 =>
                array(
                    'code' => 'th',
                    'native' => 'ไทย / Phasa Thai',
                    'name' => 'Thai',
                    'status' => 0,
                    'rtl' => 0,
                ),
            100 =>
                array(
                    'code' => 'ti',
                    'native' => 'ትግርኛ',
                    'name' => 'Tigrinya',
                    'status' => 0,
                    'rtl' => 0,
                ),
            101 =>
                array(
                    'code' => 'tk',
                    'native' => 'Туркмен /تركمن ',
                    'name' => 'Turkmen',
                    'status' => 0,
                    'rtl' => 0,
                ),
            102 =>
                array(
                    'code' => 'tn',
                    'native' => 'Setswana',
                    'name' => 'Tswana',
                    'status' => 0,
                    'rtl' => 0,
                ),
            103 =>
                array(
                    'code' => 'to',
                    'native' => 'Lea Faka-Tonga',
                    'name' => 'Tonga',
                    'status' => 0,
                    'rtl' => 0,
                ),
            104 =>
                array(
                    'code' => 'tr',
                    'native' => 'Türkçe',
                    'name' => 'Turkish',
                    'status' => 0,
                    'rtl' => 0,
                ),
            105 =>
                array(
                    'code' => 'ts',
                    'native' => 'Xitsonga',
                    'name' => 'Tsonga',
                    'status' => 0,
                    'rtl' => 0,
                ),
            106 =>
                array(
                    'code' => 'uk',
                    'native' => 'Українська',
                    'name' => 'Ukrainian',
                    'status' => 0,
                    'rtl' => 0,
                ),
            107 =>
                array(
                    'code' => 'ur',
                    'native' => 'اردو',
                    'name' => 'Urdu',
                    'status' => 0,
                    'rtl' => 1,
                ),
            108 =>
                array(
                    'code' => 'uz',
                    'native' => 'Ўзбек',
                    'name' => 'Uzbek',
                    'status' => 0,
                    'rtl' => 0,
                ),
            109 =>
                array(
                    'code' => 've',
                    'native' => 'Tshivenḓa',
                    'name' => 'Venda',
                    'status' => 0,
                    'rtl' => 0,
                ),
            110 =>
                array(
                    'code' => 'vi',
                    'native' => 'Tiếng Việt',
                    'name' => 'Vietnamese',
                    'status' => 0,
                    'rtl' => 0,
                ),
            111 =>
                array(
                    'code' => 'xh',
                    'native' => 'isiXhosa',
                    'name' => 'Xhosa',
                    'status' => 0,
                    'rtl' => 0,
                ),
            112 =>
                array(
                    'code' => 'zh',
                    'native' => '中文',
                    'name' => 'Chinese',
                    'status' => 0,
                    'rtl' => 0,
                ),
            113 =>
                array(
                    'code' => 'zu',
                    'native' => 'isiZulu',
                    'name' => 'Zulu',
                    'status' => 0,
                    'rtl' => 0,
                ),
        ));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
