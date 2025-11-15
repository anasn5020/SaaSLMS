<?php


use Illuminate\Support\Facades\Route;


Route::prefix('quiz')->middleware(['auth', 'admin'])->group(function () {


    Route::get('question-group', 'QuizController@index')->name('question-group')->middleware('RoutePermissionCheck:question-group');
    Route::post('question-group', 'QuizController@store')->name('question-group.store')->middleware('RoutePermissionCheck:question-group.store');
    Route::get('question-group/{id}', 'QuizController@show')->name('question-group.edit')->middleware('RoutePermissionCheck:question-group.edit');
    Route::put('question-group/{id}', 'QuizController@update')->name('question-group-update')->middleware('RoutePermissionCheck:question-group.edit');
    Route::delete('question-group/{id}', 'QuizController@destroy')->name('question-group-delete')->middleware('RoutePermissionCheck:question-group.delete');

    Route::get('question-bank', 'QuestionBankController@form')->name('question-bank')->middleware('RoutePermissionCheck:question-bank');
    Route::get('question-bank-list', 'QuestionBankController@index')->name('question-bank-list')->middleware('RoutePermissionCheck:question-bank-list');
    Route::post('question-bank', 'QuestionBankController@store')->name('question-bank.store')->middleware('RoutePermissionCheck:question-bank.store');
    Route::get('question-bank/{id}', 'QuestionBankController@show')->name('question-bank-edit')->middleware('RoutePermissionCheck:question-bank.edit');
    Route::put('question-bank/{id}', 'QuestionBankController@update')->name('question-bank-update')->middleware('RoutePermissionCheck:question-bank.edit');
    Route::post('remove-image-ajax', 'QuestionBankController@removeImageAjax')->middleware('RoutePermissionCheck:question-bank.edit');
    Route::post('question-bank-delete', 'QuestionBankController@destroy')->name('question-bank-delete')->middleware('RoutePermissionCheck:question-bank.delete');
    Route::post('question-bank-bulk-delete', 'QuestionBankController@bulkDestroy')->name('question-bank-bulk-delete')->middleware('RoutePermissionCheck:question-bank.delete');


    Route::get('question-bank-bulk', 'QuestionBankController@questionBulkImport')->name('question-bank-bulk')->middleware('RoutePermissionCheck:question-bank-bulk');
    Route::post('question-bank-bulk', 'QuestionBankController@questionBulkImportSubmit')->name('question-bank-bulk-submit')->middleware('RoutePermissionCheck:question-bank-bulk');

    Route::get('download-group', 'QuestionBankController@downloadGroup')->name('download-group');
    Route::get('download-category', 'QuestionBankController@downloadCategory')->name('download-category');
    Route::get('download-sub-category', 'QuestionBankController@downloadSubCategory')->name('download-sub-category');
    Route::get('download-sample', 'QuestionBankController@downloadSample')->name('download-sample');


    Route::get('course-question-bank/{id}', 'QuestionBankController@CourseQuetionShow')->name('question-bank-edit')->middleware('RoutePermissionCheck:question-bank.edit');

    Route::post('course-question-bank', 'QuestionBankController@storeCourse')->name('question-bank.course');
    Route::put('course-question-bank-update/{id}', 'QuestionBankController@updateCourse')->name('question-bank-update.course');


    Route::post('course-quiz', 'OnlineQuizController@CourseQuizStore')->name('save-course-quiz');
    Route::post('course-quiz-update', 'OnlineQuizController@CourseQuizUpdate')->name('update-course-quiz');

    Route::get('set-quiz', 'OnlineQuizController@index')->name('online-quiz')->middleware('RoutePermissionCheck:online-quiz');
    Route::post('online-exam', 'OnlineQuizController@store')->name('online-exam')->middleware('RoutePermissionCheck:set-quiz.store');
    Route::get('online-exam/{id}', 'OnlineQuizController@edit')->name('online-exam-edit')->middleware('RoutePermissionCheck:set-quiz.edit');
    Route::put('online-exam/{id}', 'OnlineQuizController@update')->name('online-exam-update')->middleware('RoutePermissionCheck:set-quiz.edit');
    Route::post('online-exam-delete', 'OnlineQuizController@delete')->name('online-exam-delete')->middleware('RoutePermissionCheck:set-quiz.delete');

    Route::get('quiz-setup', 'OnlineQuizController@quizSetup')->name('quizSetup')->middleware('RoutePermissionCheck:quizSetup');
    Route::POST('quiz-setup', 'OnlineQuizController@SaveQuizSetup')->name('quizSetup.store')->middleware('RoutePermissionCheck:quiz-setup.store');

    Route::get('quiz-result', 'OnlineQuizController@quizResult')->name('quizResult')->middleware('RoutePermissionCheck:quizResult');
    Route::get('quiz-result-data', 'OnlineQuizController@quizResultData')->name('quizResultData')->middleware('RoutePermissionCheck:quizResult');
    Route::get('quiz-result-export', 'OnlineQuizController@quizResultExport')->name('quizResultExport')->middleware('RoutePermissionCheck:quizResult');
    Route::POST('quiz-result', 'OnlineQuizController@getQuizResult')->middleware('RoutePermissionCheck:quizResult');


    Route::get('manage-online-exam-question/{id}', ['as' => 'set-quiz.set-question', 'uses' => 'OnlineQuizController@manageOnlineExamQuestion'])->middleware('RoutePermissionCheck:set-quiz.manage-question');
    Route::post('online_exam_question_store', ['as' => 'online_exam_question_store', 'uses' => 'OnlineQuizController@manageOnlineExamQuestionStore'])->middleware('RoutePermissionCheck:set-quiz.set-question');

    Route::get('online-exam-publish/{id}', ['as' => 'online_exam_publish', 'uses' => 'OnlineQuizController@onlineExamPublish'])->middleware('RoutePermissionCheck:set-quiz.publish-now');
    Route::get('online-exam-publish-cancel/{id}', ['as' => 'online_exam_publish_cancel', 'uses' => 'OnlineQuizController@onlineExamPublishCancel'])->middleware('RoutePermissionCheck:set-quiz.publish-now');

    Route::get('online-question-edit/{id}/{type}/{examId}', 'OnlineQuizController@onlineQuestionEdit');
    Route::post('online-exam-question-edit', ['as' => 'online_exam_question_edit', 'uses' => 'OnlineQuizController@onlineExamQuestionEdit']);
    Route::post('online-exam-question-delete', 'OnlineQuizController@onlineExamQuestionDelete')->name('online-exam-question-delete');

    // store online exam question
    Route::post('online-exam-question-assign', ['as' => 'online_exam_question_assign', 'uses' => 'OnlineQuizController@onlineExamQuestionAssign']);
    Route::post('online-exam-question-assign-by-ajax', ['as' => 'online_exam_question_assign_by_ajax', 'uses' => 'OnlineQuizController@onlineExamQuestionAssignByAjax']);

    Route::get('view_online_question_modal/{id}', ['as' => 'view_online_question_modal', 'uses' => 'OnlineQuizController@viewOnlineQuestionModal']);

    // Online exam marks
    Route::get('online-exam-marks-register/{id}', ['as' => 'online_exam_marks_register', 'uses' => 'OnlineQuizController@onlineExamMarksRegister'])->middleware('RoutePermissionCheck:set-quiz.mark-register');

    Route::post('online-exam-marks-store', ['as' => 'online_exam_marks_store', 'uses' => 'OnlineQuizController@onlineExamMarksStore']);
    Route::get('online-exam-result/{id}', ['as' => 'online_exam_result', 'uses' => 'OnlineQuizController@onlineExamResult'])->middleware('RoutePermissionCheck:set-quiz.quiz_result');

    Route::get('online-exam-marking/{exam_id}/{s_id}', ['as' => 'online_exam_marking', 'uses' => 'OnlineQuizController@onlineExamMarking']);
    Route::post('online-exam-marks-store', ['as' => 'online_exam_marks_store', 'uses' => 'OnlineQuizController@onlineExamMarkingStore']);

    Route::get('/all/quiz-data', 'QuestionBankController@getAllQuizData')->name('getAllQuizData')->middleware('RoutePermissionCheck:question-bank-list');


    Route::get('quiz-enrolled-student/{id}', 'OnlineQuizController@enrolledStudent')->name('set-quiz.enrolled-student')->middleware('RoutePermissionCheck:set-quiz.enrolled-student');
    Route::get('quiz-enrolled-marking/{quiz_test_id}', 'OnlineQuizController@markingScript')->name('set-quiz.mark-register')->middleware('RoutePermissionCheck:set-quiz.mark-register');
    Route::post('quiz-enrolled-marking', 'OnlineQuizController@quizMarkingStore')->name('quizMarkingStore');


    Route::get('getTotalQuizNumbers', 'OnlineQuizController@getTotalQuizNumbers')->name('getTotalQuizNumbers');
    Route::get('quiz-re-test/{id}', 'OnlineQuizController@quizReTest')->name('quizReTest')->middleware('RoutePermissionCheck:quizReTest');

});
