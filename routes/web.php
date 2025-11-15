<?php

use Carbon\Carbon;
use App\Subscription;
use Illuminate\Support\Facades\Route;
use Modules\Membership\Entities\MembershipPlanCheckout;

if (isModuleActive('LmsSaas') || isModuleActive('LmsSaasMD')) {
    Route::group(['middleware' => ['subdomain']], function ($routes) {
        require('tenant.php');
    });
} else {
    require('tenant.php');
}
