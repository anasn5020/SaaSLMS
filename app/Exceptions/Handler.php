<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \League\OAuth2\Server\Exception\OAuthServerException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];


    public function report(Throwable $exception)
    {
        parent::report($exception);
    }


    public function register()
    {
        $this->reportable(function (Throwable $exception) {
            if ($exception
                instanceof
                ModelNotFoundException) {
                abort(404, '');
            }


            if ($exception instanceof MethodNotAllowedHttpException) {
                abort(500, $exception->getMessage());
            }

            if ($exception instanceof TokenMismatchException) {
                return redirect()->route('login');
            }
//            if (App::environment('production')) {
////                return redirect()->to('/');
//                GettingError($exception->getMessage(), url()->current(), request()->ip(), request()->userAgent());
//            }

        });
    }

//    public function render($request, Throwable $exception)
//    {
//        if ($exception
//            instanceof
//            \Illuminate\Database\Eloquent\ModelNotFoundException) {
//            abort(404);
//        }
//
//
//        if ($exception instanceof MethodNotAllowedHttpException) {
//            abort(500, $exception->getMessage());
//        }
//
//        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
//            return redirect()->route('login');
//        }
//
//        return parent::render($request, $exception);
//    }
//
}
