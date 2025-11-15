<?php

namespace App\Http;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ApiKeyMiddleware;
use App\Http\Middleware\AppOnlyModeMiddleware;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckApi2Fa;
use App\Http\Middleware\CheckForMaintenanceMode;
use App\Http\Middleware\CheckUserActiveStatus;
use App\Http\Middleware\DemoPreventMiddleware;
use App\Http\Middleware\EncryptCookies;
use App\Http\Middleware\HttpsProtocol;
use App\Http\Middleware\Impersonate;
use App\Http\Middleware\IpCheck;
use App\Http\Middleware\LastActivityMiddleware;
use App\Http\Middleware\MaintenanceModeMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RoutePermissionCheck;
use App\Http\Middleware\SaasAdmin;
use App\Http\Middleware\SecureHeaders;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\StudentMiddleware;
use App\Http\Middleware\SubdomainMiddleware;
use App\Http\Middleware\TrimStrings;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Middleware\XSS;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Modules\Localization\Http\Middleware\Language;
use PragmaRX\Google2FALaravel\Middleware;

//use App\Http\Middleware\XAuthorizationHeader;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        TrustProxies::class,
        HandleCors::class,
        CheckForMaintenanceMode::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
//        XAuthorizationHeader::class

    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            Language::class,
            SubstituteBindings::class,
            SetLocale::class,
            CheckUserActiveStatus::class,
            XSS::class,
            IpCheck::class,
            HttpsProtocol::class,
            LastActivityMiddleware::class,
            Impersonate::class,
            SecureHeaders::class
        ],

        'api' => [
            'throttle:60,1',
            SubstituteBindings::class,
            ApiKeyMiddleware::class,
            MaintenanceModeMiddleware::class
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'bindings' => SubstituteBindings::class,
        'cache.headers' => SetCacheHeaders::class,
        'can' => Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'password.confirm' => RequirePassword::class,
        'signed' => ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
        'verified' => EnsureEmailIsVerified::class,
        'admin' => AdminMiddleware::class,
        'student' => StudentMiddleware::class,
        'RoutePermissionCheck' => RoutePermissionCheck::class,
        'maintenanceMode' => MaintenanceModeMiddleware::class,
        'onlyAppMode' => AppOnlyModeMiddleware::class,
        'subdomain' => SubdomainMiddleware::class,
        'saasAdmin' => SaasAdmin::class,
        'demo' => DemoPreventMiddleware::class,
        '2fa' => Middleware::class,
        '2faApi' => CheckApi2Fa::class

    ];
}
