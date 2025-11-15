<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes(['verify' => true]);

Route::group(['namespace' => 'Api'], function () {
});


Route::group([
    'namespace' => 'Api'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('send-2fa', 'AuthController@sendTFA')->middleware('auth:api');
    Route::post('check-2fa', 'AuthController@checkTFA')->middleware('auth:api');
    Route::post('auto-verify-2fa', 'AuthController@autoVerify')->middleware('auth:api');
    Route::post('social-login', 'AuthController@socialLogin');
    Route::post('signup', 'AuthController@signup');
    Route::post('send-otp', 'AuthController@sendOtp');
    Route::post('reset', 'AuthController@resetWithOtp');
    Route::get('get-lang', 'AuthController@getLang');
//new
    Route::post('resend-email', 'AuthController@resendEmail');

    //CourseApiController
    Route::get('/get-all-courses', 'CourseApiController@getAllCourses');
    Route::get('/get-all-classes', 'CourseApiController@getAllClasses');
    Route::get('/get-all-quizzes', 'CourseApiController@getAllQuizzes');
    Route::get('/get-popular-courses', 'CourseApiController@getPopularCourses');
    Route::get('/get-popular-classes', 'CourseApiController@getPopularClasses');
    Route::get('/get-popular-quizzes', 'CourseApiController@getPopularQuizes');
    Route::get('/get-course-details/{id}', 'CourseApiController@getCourseDetails');
    Route::get('/get-class-details/{id}', 'CourseApiController@getClassDetails');
    Route::get('/get-quiz-details/{id}', 'CourseApiController@getQuizDetails');
    Route::get('/get-lesson-quiz-details/{id}', 'CourseApiController@getLessonQuizDetails');
    Route::get('/top-categories', 'CourseApiController@topCategories');
    Route::get('/search-course', 'CourseApiController@searchCourse');
    Route::get('/filter-course', 'CourseApiController@filterCourse');
    Route::get('/check-sequence/{course_id}/{lesson_id}', 'CourseApiController@getLessonCompleteStatus');


    Route::get('/payment-gateways', 'WebsiteApiController@paymentGateways');
    Route::get('/sliders', 'WebsiteApiController@sliders');
    Route::get('categories', 'CourseApiController@categories');
    Route::get('sub-categories/{category_id}', 'CourseApiController@subCategories');
    Route::get('levels', 'CourseApiController@levels');
    Route::get('languages', 'CourseApiController@languages');
    Route::get('mobile-menu', 'MobileMenuController@mobileMenus');

    Route::get('settings', 'WebsiteApiController@settings');


    Route::get('get-institutes', 'WebsiteApiController@getInstitute');


    Route::group([
        'middleware' => ['auth:api', 'verified', '2faApi']
    ], function () {
        //with login routes

        Route::post('set-fcm-token', 'AuthController@setFcmToken');

        Route::post('set-lang', 'AuthController@setLang');

        Route::any('lesson-complete', 'WebsiteApiController@lessonComplete')->name('lesson.complete');


        Route::get('/get-bbb-start-url/{meeting_id}/{user_name}', 'WebsiteApiController@getBbbMeetingUrl');

        Route::get('/cart-list', 'WebsiteApiController@cartList');
        Route::get('/add-to-cart/{id}', 'WebsiteApiController@addToCart');
        Route::get('/remove-to-cart/{id}', 'WebsiteApiController@removeCart');
        Route::post('/apply-coupon', 'WebsiteApiController@applyCoupon');

        //AuthController
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::post('change-password', 'AuthController@changePassword');
        Route::post('account-delete', 'AuthController@accountDelete');
        Route::post('/update-profile', 'WebsiteApiController@updateProfile');
        Route::post('logout-device', 'AuthController@logOutDevice');


        //WebsiteApiController

        Route::get('/countries', 'WebsiteApiController@countries');
        Route::get('/states/{country_id}', 'WebsiteApiController@states');
        Route::get('/cities/{state_id}', 'WebsiteApiController@cities');
        Route::get('/my-courses', 'WebsiteApiController@myCourses');
        Route::get('/my-quizzes', 'WebsiteApiController@myQuizzes');
        Route::get('/my-classes', 'WebsiteApiController@myClasses');
        Route::post('/submit-review', 'WebsiteApiController@submitReview');
        Route::post('/comment', 'WebsiteApiController@comment');
        Route::post('/comment-reply', 'WebsiteApiController@commentReply');
        Route::post('/delete-comment', 'WebsiteApiController@deleteComment');
        Route::post('/delete-comment-reply', 'WebsiteApiController@deleteCommnetReply');
        Route::post('/delete-course-review', 'WebsiteApiController@deleteReview');
        Route::get('/payment-methods', 'WebsiteApiController@paymentMethods');

        Route::post('/make-order', 'WebsiteApiController@makeOrder');
        Route::post('/make-order-ssl', 'WebsiteApiController@makeOrderForSSL');
        Route::post('/make-payment/{gateWayName}', 'WebsiteApiController@payWithGateWay');
        Route::get('/my-billing-address', 'WebsiteApiController@myBilling');

        Route::post('paytm-order-generate', 'WebsiteApiController@paytmOrderGenerate');
        Route::post('paytm-order-verify', 'WebsiteApiController@paytmOrderVerify');


        //quiz route
        Route::post('quiz-start/{course_id}/{quiz_id}', 'WebsiteApiController@quizStart');
        Route::post('quiz-single-submit', 'WebsiteApiController@singleQusSubmit');
        Route::post('quiz-final-submit', 'WebsiteApiController@finalQusSubmit');
        Route::post('quiz-result/{course_id}/{quiz_id}', 'WebsiteApiController@quizResult');
        Route::post('quiz-results', 'WebsiteApiController@quizResults');
        Route::any('quiz-result-preview/{quiz_id}', 'WebsiteApiController@quizResultPreview');
        //new quiz result
        Route::post('quiz-history/{quiz_id}', 'WebsiteApiController@quizHistory');
        Route::post('quiz-test-result/{quiz_test__id}', 'WebsiteApiController@quizTestResult');

        Route::get('custom-class-messages/{class_id}', 'WebsiteApiController@getCustomClassMessages');
        Route::post('custom-class-messages/{class_id}', 'WebsiteApiController@sendCustomClassMessages');


        //new
        Route::get('/news', 'WebsiteApiController@news');
        Route::get('/activities', 'WebsiteApiController@activities');
        Route::get('/login-devices', 'WebsiteApiController@loginDevices');
        Route::get('/certificate-records', 'WebsiteApiController@certificateRecords');
        Route::get('/course-list', 'WebsiteApiController@courseList');
        Route::get('/quiz-list', 'WebsiteApiController@quizList');
        Route::get('/learning-schedule-plans', 'WebsiteApiController@learningSchedulePlans');
        Route::get('/learning-schedule-plan-icon/{plan_id}', 'WebsiteApiController@learningSchedulePlanIcon');
        Route::get('/learning-schedule-plan-list/{plan_id}', 'WebsiteApiController@learningSchedulePlanList');
        Route::get('/course-sequence/{course_id}', 'WebsiteApiController@CourseSequence');
        Route::get('/course-report', 'WebsiteApiController@courseReport');
        Route::get('/quiz-report', 'WebsiteApiController@quizReport');
        Route::get('/notifications', 'WebsiteApiController@notifications');
        Route::any('/Notification-make-all-read', 'WebsiteApiController@markAllRead');

        Route::get('category-courses', 'CourseApiController@categoryCourses');
        Route::post('buy-now', 'CourseApiController@buyNow');
        Route::get('get-course-certificate/{id}', 'CourseApiController@getCertificate');

        Route::get('/offline-attendance-report', 'WebsiteApiController@offlineAttendanceReport');
        Route::post('/get-course-from-slug', 'CourseApiController@getCourseFromSlug');
        Route::get('/blog-visit/{blog_id}', 'WebsiteApiController@visitBlogPost');
        Route::post('/enroll-iap', 'WebsiteApiController@enrollIAP');

        Route::get('/refund-list', 'WebsiteApiRefundController@index');
        Route::get('/refund-show/{id}', 'WebsiteApiRefundController@show');
        Route::post('/refund-create', 'WebsiteApiRefundController@store');
        Route::post('/refund-delete', 'WebsiteApiRefundController@delete');

        //my blog
        Route::get('/my-blogs', 'BlogController@index');
        Route::post('/my-blogs', 'BlogController@store');
        Route::get('/my-blogs/{id}', 'BlogController@show');
        Route::post('/my-blogs/{id}', 'BlogController@update');
        Route::delete('/my-blogs/{id}', 'BlogController@delete');

        Route::get('/blogs', 'BlogController@blogList');
        Route::get('/blog-categories', 'BlogController@blogCategories');
        Route::get('/blogs/{id}', 'BlogController@blogDetails');


        Route::get('/blog-comments/{blog_id}', 'BlogController@blogCommentList');
        Route::post('/blog-comments/{blog_id}', 'BlogController@blogCommentSubmit');
        Route::delete('/blog-comments/{id}', 'BlogController@blogCommentDelete');

        //affiliate
        Route::group([
            'prefix' => 'affiliate',
        ], function () {
            Route::get('/statistics', 'AffiliateController@statistics');
            Route::get('/links', 'AffiliateController@links');
            Route::get('/commissions', 'AffiliateController@commissions');
            Route::get('/withdraws', 'AffiliateController@withdraws');
            Route::post('/add-link', 'AffiliateController@addLink');
            Route::post('/add-paypal', 'AffiliateController@addPaypal');
            Route::get('/get-paypal', 'AffiliateController@getPaypal');
            Route::get('/get-list', 'AffiliateController@getList');
            Route::post('/balance-transfer', 'AffiliateController@balanceTransfer');
            Route::post('/withdraw-request', 'AffiliateController@withdrawRequest');
        });




    });
});
