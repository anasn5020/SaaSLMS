<?php

use Illuminate\Support\Facades\DB;
use Modules\Setting\Model\Currency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateTableCurrencieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('symbol')->nullable();
            $table->double('conversion_rate')->default(1);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        DB::table('currencies')->insert(array (
            0 =>
                array (
                    'name' => 'Leke',
                    'code' => 'ALL',
                    'symbol' => 'Lek',
                ),
            1 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'USD',
                    'symbol' => '$',
                ),
            2 =>
                array (
                    'name' => 'Afghanis',
                    'code' => 'AFN',
                    'symbol' => '؋',
                ),
            3 =>
                array (
                    'name' => 'Pesos',
                    'code' => 'ARS',
                    'symbol' => '$',
                ),
            4 =>
                array (
                    'name' => 'Guilders',
                    'code' => 'AWG',
                    'symbol' => 'ƒ',
                ),
            5 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'AUD',
                    'symbol' => '$',
                ),
            6 =>
                array (
                    'name' => 'New Manats',
                    'code' => 'AZN',
                    'symbol' => 'ман',
                ),
            7 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'BSD',
                    'symbol' => '$',
                ),
            8 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'BBD',
                    'symbol' => '$',
                ),
            9 =>
                array (
                    'name' => 'Rubles',
                    'code' => 'BYR',
                    'symbol' => 'p.',
                ),
            10 =>
                array (
                    'name' => 'Euro',
                    'code' => 'EUR',
                    'symbol' => '€',
                ),
            11 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'BZD',
                    'symbol' => 'BZ$',
                ),
            12 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'BMD',
                    'symbol' => '$',
                ),
            13 =>
                array (
                    'name' => 'Bolivianos',
                    'code' => 'BOB',
                    'symbol' => '$b',
                ),
            14 =>
                array (
                    'name' => 'Convertible Marka',
                    'code' => 'BAM',
                    'symbol' => 'KM',
                ),
            15 =>
                array (
                    'name' => 'Pula',
                    'code' => 'BWP',
                    'symbol' => 'P',
                ),
            16 =>
                array (
                    'name' => 'Leva',
                    'code' => 'BGN',
                    'symbol' => 'лв',
                ),
            17 =>
                array (
                    'name' => 'Reais',
                    'code' => 'BRL',
                    'symbol' => 'R$',
                ),
            18 =>
                array (
                    'name' => 'Pounds',
                    'code' => 'GBP',
                    'symbol' => '£',
                ),
            19 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'BND',
                    'symbol' => '$',
                ),
            20 =>
                array (
                    'name' => 'Riels',
                    'code' => 'KHR',
                    'symbol' => '៛',
                ),
            21 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'CAD',
                    'symbol' => '$',
                ),
            22 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'KYD',
                    'symbol' => '$',
                ),
            23 =>
                array (
                    'name' => 'Pesos',
                    'code' => 'CLP',
                    'symbol' => '$',
                ),
            24 =>
                array (
                    'name' => 'Yuan Renminbi',
                    'code' => 'CNY',
                    'symbol' => '¥',
                ),
            25 =>
                array (
                    'name' => 'Pesos',
                    'code' => 'COP',
                    'symbol' => '$',
                ),
            26 =>
                array (
                    'name' => 'Colón',
                    'code' => 'CRC',
                    'symbol' => '₡',
                ),
            27 =>
                array (
                    'name' => 'Kuna',
                    'code' => 'HRK',
                    'symbol' => 'kn',
                ),
            28 =>
                array (
                    'name' => 'Pesos',
                    'code' => 'CUP',
                    'symbol' => '₱',
                ),
            29 =>
                array (
                    'name' => 'Koruny',
                    'code' => 'CZK',
                    'symbol' => 'Kč',
                ),
            30 =>
                array (
                    'name' => 'Kroner',
                    'code' => 'DKK',
                    'symbol' => 'kr',
                ),
            31 =>
                array (
                    'name' => 'Pesos',
                    'code' => 'DOP ',
                    'symbol' => 'RD$',
                ),
            32 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'XCD',
                    'symbol' => '$',
                ),
            33 =>
                array (
                    'name' => 'Pounds',
                    'code' => 'EGP',
                    'symbol' => '£',
                ),
            34 =>
                array (
                    'name' => 'Colones',
                    'code' => 'SVC',
                    'symbol' => '$',
                ),
            35 =>
                array (
                    'name' => 'Pounds',
                    'code' => 'FKP',
                    'symbol' => '£',
                ),
            36 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'FJD',
                    'symbol' => '$',
                ),
            37 =>
                array (
                    'name' => 'Cedis',
                    'code' => 'GHC',
                    'symbol' => '¢',
                ),
            38 =>
                array (
                    'name' => 'Pounds',
                    'code' => 'GIP',
                    'symbol' => '£',
                ),
            39 =>
                array (
                    'name' => 'Quetzales',
                    'code' => 'GTQ',
                    'symbol' => 'Q',
                ),
            40 =>
                array (
                    'name' => 'Pounds',
                    'code' => 'GGP',
                    'symbol' => '£',
                ),
            41 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'GYD',
                    'symbol' => '$',
                ),
            42 =>
                array (
                    'name' => 'Lempiras',
                    'code' => 'HNL',
                    'symbol' => 'L',
                ),
            43 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'HKD',
                    'symbol' => '$',
                ),
            44 =>
                array (
                    'name' => 'Forint',
                    'code' => 'HUF',
                    'symbol' => 'Ft',
                ),
            45 =>
                array (
                    'name' => 'Kronur',
                    'code' => 'ISK',
                    'symbol' => 'kr',
                ),
            46 =>
                array (
                    'name' => 'Rupees',
                    'code' => 'INR',
                    'symbol' => '₹',
                ),
            47 =>
                array (
                    'name' => 'Rupiahs',
                    'code' => 'IDR',
                    'symbol' => 'Rp',
                ),
            48 =>
                array (
                    'name' => 'Rials',
                    'code' => 'IRR',
                    'symbol' => '﷼',
                ),
            49 =>
                array (
                    'name' => 'Pounds',
                    'code' => 'IMP',
                    'symbol' => '£',
                ),
            50 =>
                array (
                    'name' => 'New Shekels',
                    'code' => 'ILS',
                    'symbol' => '₪',
                ),
            51 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'JMD',
                    'symbol' => 'J$',
                ),
            52 =>
                array (
                    'name' => 'Yen',
                    'code' => 'JPY',
                    'symbol' => '¥',
                ),
            53 =>
                array (
                    'name' => 'Pounds',
                    'code' => 'JEP',
                    'symbol' => '£',
                ),
            54 =>
                array (
                    'name' => 'Tenge',
                    'code' => 'KZT',
                    'symbol' => 'лв',
                ),
            55 =>
                array (
                    'name' => 'Won',
                    'code' => 'KPW',
                    'symbol' => '₩',
                ),
            56 =>
                array (
                    'name' => 'Won',
                    'code' => 'KRW',
                    'symbol' => '₩',
                ),
            57 =>
                array (
                    'name' => 'Soms',
                    'code' => 'KGS',
                    'symbol' => 'лв',
                ),
            58 =>
                array (
                    'name' => 'Kips',
                    'code' => 'LAK',
                    'symbol' => '₭',
                ),
            59 =>
                array (
                    'name' => 'Lati',
                    'code' => 'LVL',
                    'symbol' => 'Ls',
                ),
            60 =>
                array (
                    'name' => 'Pounds',
                    'code' => 'LBP',
                    'symbol' => '£',
                ),
            61 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'LRD',
                    'symbol' => '$',
                ),
            62 =>
                array (
                    'name' => 'Switzerland Francs',
                    'code' => 'CHF',
                    'symbol' => 'CHF',
                ),
            63 =>
                array (
                    'name' => 'Litai',
                    'code' => 'LTL',
                    'symbol' => 'Lt',
                ),
            64 =>
                array (
                    'name' => 'Denars',
                    'code' => 'MKD',
                    'symbol' => 'ден',
                ),
            65 =>
                array (
                    'name' => 'Ringgits',
                    'code' => 'MYR',
                    'symbol' => 'RM',
                ),
            66 =>
                array (
                    'name' => 'Rupees',
                    'code' => 'MUR',
                    'symbol' => '₨',
                ),
            67 =>
                array (
                    'name' => 'Pesos',
                    'code' => 'MXN',
                    'symbol' => '$',
                ),
            68 =>
                array (
                    'name' => 'Tugriks',
                    'code' => 'MNT',
                    'symbol' => '₮',
                ),
            69 =>
                array (
                    'name' => 'Meticais',
                    'code' => 'MZN',
                    'symbol' => 'MT',
                ),
            70 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'NAD',
                    'symbol' => '$',
                ),
            71 =>
                array (
                    'name' => 'Rupees',
                    'code' => 'NPR',
                    'symbol' => '₨',
                ),
            72 =>
                array (
                    'name' => 'Guilders',
                    'code' => 'ANG',
                    'symbol' => 'ƒ',
                ),
            73 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'NZD',
                    'symbol' => '$',
                ),
            74 =>
                array (
                    'name' => 'Cordobas',
                    'code' => 'NIO',
                    'symbol' => 'C$',
                ),
            75 =>
                array (
                    'name' => 'Nairas',
                    'code' => 'NGN',
                    'symbol' => '₦',
                ),
            76 =>
                array (
                    'name' => 'Krone',
                    'code' => 'NOK',
                    'symbol' => 'kr',
                ),
            77 =>
                array (
                    'name' => 'Rials',
                    'code' => 'OMR',
                    'symbol' => '﷼',
                ),
            78 =>
                array (
                    'name' => 'Rupees',
                    'code' => 'PKR',
                    'symbol' => '₨',
                ),
            79 =>
                array (
                    'name' => 'Balboa',
                    'code' => 'PAB',
                    'symbol' => 'B/.',
                ),
            80 =>
                array (
                    'name' => 'Guarani',
                    'code' => 'PYG',
                    'symbol' => 'Gs',
                ),
            81 =>
                array (
                    'name' => 'Nuevos Soles',
                    'code' => 'PEN',
                    'symbol' => 'S/.',
                ),
            82 =>
                array (
                    'name' => 'Pesos',
                    'code' => 'PHP',
                    'symbol' => 'Php',
                ),
            83 =>
                array (
                    'name' => 'Zlotych',
                    'code' => 'PLN',
                    'symbol' => 'zł',
                ),
            84 =>
                array (
                    'name' => 'Rials',
                    'code' => 'QAR',
                    'symbol' => '﷼',
                ),
            85 =>
                array (
                    'name' => 'New Lei',
                    'code' => 'RON',
                    'symbol' => 'lei',
                ),
            86 =>
                array (
                    'name' => 'Rubles',
                    'code' => 'RUB',
                    'symbol' => 'руб',
                ),
            87 =>
                array (
                    'name' => 'Pounds',
                    'code' => 'SHP',
                    'symbol' => '£',
                ),
            88 =>
                array (
                    'name' => 'Riyals',
                    'code' => 'SAR',
                    'symbol' => '﷼',
                ),
            89 =>
                array (
                    'name' => 'Dinars',
                    'code' => 'RSD',
                    'symbol' => 'Дин.',
                ),
            90 =>
                array (
                    'name' => 'Rupees',
                    'code' => 'SCR',
                    'symbol' => '₨',
                ),
            91 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'SGD',
                    'symbol' => '$',
                ),
            92 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'SBD',
                    'symbol' => '$',
                ),
            93 =>
                array (
                    'name' => 'Shillings',
                    'code' => 'SOS',
                    'symbol' => 'S',
                ),
            94 =>
                array (
                    'name' => 'Rand',
                    'code' => 'ZAR',
                    'symbol' => 'R',
                ),
            95 =>
                array (
                    'name' => 'Rupees',
                    'code' => 'LKR',
                    'symbol' => '₨',
                ),
            96 =>
                array (
                    'name' => 'Kronor',
                    'code' => 'SEK',
                    'symbol' => 'kr',
                ),
            97 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'SRD',
                    'symbol' => '$',
                ),
            98 =>
                array (
                    'name' => 'Pounds',
                    'code' => 'SYP',
                    'symbol' => '£',
                ),
            99 =>
                array (
                    'name' => 'New Dollars',
                    'code' => 'TWD',
                    'symbol' => 'NT$',
                ),
            100 =>
                array (
                    'name' => 'Baht',
                    'code' => 'THB',
                    'symbol' => '฿',
                ),
            101 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'TTD',
                    'symbol' => 'TT$',
                ),
            102 =>
                array (
                    'name' => 'Lira',
                    'code' => 'TRY',
                    'symbol' => 'TL',
                ),
            103 =>
                array (
                    'name' => 'Liras',
                    'code' => 'TRL',
                    'symbol' => '£',
                ),
            104 =>
                array (
                    'name' => 'Dollars',
                    'code' => 'TVD',
                    'symbol' => '$',
                ),
            105 =>
                array (
                    'name' => 'Hryvnia',
                    'code' => 'UAH',
                    'symbol' => '₴',
                ),
            106 =>
                array (
                    'name' => 'Pesos',
                    'code' => 'UYU',
                    'symbol' => '$U',
                ),
            107 =>
                array (
                    'name' => 'Sums',
                    'code' => 'UZS',
                    'symbol' => 'лв',
                ),
            108 =>
                array (
                    'name' => 'Bolivares Fuertes',
                    'code' => 'VEF',
                    'symbol' => 'Bs',
                ),
            109 =>
                array (
                    'name' => 'Dong',
                    'code' => 'VND',
                    'symbol' => '₫',
                ),
            110 =>
                array (
                    'name' => 'Rials',
                    'code' => 'YER',
                    'symbol' => '﷼',
                ),
            111 =>
                array (
                    'name' => 'Taka',
                    'code' => 'BDT',
                    'symbol' => '৳',
                ),
            112 =>
                array (
                    'name' => 'Zimbabwe Dollars',
                    'code' => 'ZWD',
                    'symbol' => 'Z$',
                ),
            113 =>
                array (
                    'name' => 'Kenya',
                    'code' => 'KES',
                    'symbol' => 'KSh',
                ),
            114 =>
                array (
                    'name' => 'Nigeria',
                    'code' => 'naira',
                    'symbol' => '₦',
                ),
            115 =>
                array (
                    'name' => 'Ghana',
                    'code' => 'GHS',
                    'symbol' => 'GH₵',
                ),
            116 =>
                array (
                    'name' => 'Ethiopian',
                    'code' => 'ETB',
                    'symbol' => 'Br',
                ),
            117 =>
                array (
                    'name' => 'Tanzania',
                    'code' => 'TZS',
                    'symbol' => 'TSh',
                ),
            118 =>
                array (
                    'name' => 'Uganda',
                    'code' => 'UGX',
                    'symbol' => 'USh',
                ),
            119 =>
                array (
                    'name' => 'Rwandan',
                    'code' => 'FRW',
                    'symbol' => 'FRw',
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
        Schema::dropIfExists('currencies');
    }
}
