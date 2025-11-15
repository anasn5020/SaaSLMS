<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{

    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'admin/questions/exit-online',
        '/payment/sslcommerz/*',
        '/app/payment/sslcommerz/*',
        '/paytm/*',
        '/install/*',
        'mobilpay/*',
        'mobilpay/*',
        '/xapi/*',
        '/scorm/*',
        '/razerms/*',
        '/page-builder/new-upload',
        '/flutterwave/*',
        '/flutterwave/*',
        'callback/*',
        "mollie/*",
        "tranzak/*",
        "amazonpayment/*",
        "astrapay/*",
        "callback/*",
        'ccavenue/*'
    ];
}
