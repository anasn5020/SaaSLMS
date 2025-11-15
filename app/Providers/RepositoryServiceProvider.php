<?php

namespace App\Providers;

use App\Repositories\Eloquents\AdminRepository;
use App\Repositories\Eloquents\AssignmentRepository;
use App\Repositories\Eloquents\AuthRepository;
use App\Repositories\Eloquents\AuthUserRepository;
use App\Repositories\Eloquents\ChapterRepository;
use App\Repositories\Eloquents\ConversationRepository;
use App\Repositories\Eloquents\Course\DripRepository;
use App\Repositories\Eloquents\CourseExerciseRepository;
use App\Repositories\Eloquents\CoursePricePlanRepository;
use App\Repositories\Eloquents\CourseRepository;
use App\Repositories\Eloquents\CustomMeetingRepository;
use App\Repositories\Eloquents\GeneralSettingsRepository;
use App\Repositories\Eloquents\LanguageRepository;
use App\Repositories\Eloquents\LessonRepository;
use App\Repositories\Eloquents\MembershipRepository;
use App\Repositories\Eloquents\PaymentRepository;
use App\Repositories\Eloquents\QuizRepository;
use App\Repositories\Eloquents\UserNotificationRepository;
use App\Repositories\Eloquents\UserRepository;
use App\Repositories\Eloquents\VirtualClassRepository;
use App\Repositories\Eloquents\ZoomRepository;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\AssignmentRepositoryInterface;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Interfaces\AuthUserRepositoryInterface;
use App\Repositories\Interfaces\ChapterRepositoryInterface;
use App\Repositories\Interfaces\ConversationRepositoryInterface;
use App\Repositories\Interfaces\Course\DripRepositoryInterface;
use App\Repositories\Interfaces\CourseExerciseRepositoryInterface;
use App\Repositories\Interfaces\CoursePricePlanRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\CustomMeetingRepositoryInterface;
use App\Repositories\Interfaces\GeneralSettingsInterface;
use App\Repositories\Interfaces\LanguageRepositoryInterface;
use App\Repositories\Interfaces\LessonRepositoryInterface;
use App\Repositories\Interfaces\MembershipRepositoryInterface;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Repositories\Interfaces\QuizRepositoryInterface;
use App\Repositories\Interfaces\UserNotificationRepositoryInterface;
use App\Repositories\Interfaces\VirtualClassRepositoryInterface;
use App\Repositories\Interfaces\ZoomRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquents\FilepondRepository;
use App\Repositories\Interfaces\FilepondRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(UserNotificationRepositoryInterface::class, UserNotificationRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
        $this->app->bind(ChapterRepositoryInterface::class, ChapterRepository::class);
        $this->app->bind(LessonRepositoryInterface::class, LessonRepository::class);
        $this->app->bind(QuizRepositoryInterface::class, QuizRepository::class);
        $this->app->bind(AssignmentRepositoryInterface::class, AssignmentRepository::class);
        $this->app->bind(ConversationRepositoryInterface::class, ConversationRepository::class);
        $this->app->bind(VirtualClassRepositoryInterface::class, VirtualClassRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(GeneralSettingsInterface::class, GeneralSettingsRepository::class);
        $this->app->bind(LanguageRepositoryInterface::class, LanguageRepository::class);
        $this->app->bind(ZoomRepositoryInterface::class, ZoomRepository::class);
        $this->app->bind(CoursePricePlanRepositoryInterface::class, CoursePricePlanRepository::class);
        $this->app->bind(CourseExerciseRepositoryInterface::class, CourseExerciseRepository::class);
        $this->app->bind(AuthUserRepositoryInterface::class, AuthUserRepository::class);
        $this->app->bind(MembershipRepositoryInterface::class, MembershipRepository::class);
        $this->app->bind(CustomMeetingRepositoryInterface::class, CustomMeetingRepository::class);
        $this->app->bind(DripRepositoryInterface::class, DripRepository::class);
        $this->app->bind(FilepondRepositoryInterface::class, FilepondRepository::class);



    }
}
