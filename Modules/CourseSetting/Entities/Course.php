<?php

namespace Modules\CourseSetting\Entities;

use App\LessonComplete;
use App\Models\LmsBadge;
use App\Traits\Tenantable;
use App\User;
use Carbon\Carbon;
use Cocur\Slugify\Slugify;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\AdvanceQuiz\Entities\OnlineQuizTestShift;
use Modules\Certificate\Entities\Certificate;
use Modules\Certificate\Entities\CertificateRecord;
use Modules\CertificatePro\Entities\CertificateTemplate;
use Modules\EarlyBird\Entities\PricePlan;
use Modules\Forum\Entities\Forum;
use Modules\Group\Entities\Group;
use Modules\Homework\Entities\InfixHomework;
use Modules\Localization\Entities\Language;
use Modules\OrgSubscription\Entities\OrgAttendance;
use Modules\OrgSubscription\Entities\OrgSubscriptionCourseList;
use Modules\Payment\Entities\Cart;
use Modules\Quiz\Entities\OnlineQuiz;
use Modules\Quiz\Entities\QuizTest;
use Modules\Setting\Entities\UsedMedia;
use Modules\Store\Entities\Product;
use Modules\Store\Entities\ProductCategory;
use Modules\Store\Entities\ProductSku;
use Modules\Survey\Entities\Survey;
use Modules\VirtualClass\Entities\ClassComplete;
use Modules\VirtualClass\Entities\VirtualClass;
use Modules\WaitList\Entities\CourseWaitingList;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Traits\HasTranslations;

class Course extends Model
{

    use HasSlug;
    use Tenantable;

    public $translatable = ['about', 'outcomes', 'requirements', 'title'];
    protected $guarded = [];
    use HasTranslations;
    protected $appends = ['dateFormat', 'publishedDate', 'sumRev', 'purchasePrice', 'enrollCount'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($course) {
            if ($course->type == 1) {
                saasPlanManagement('course', 'create');
            }
        });
        static::updating(function ($course) {

            $carts = Cart::where('course_id', $course->id)->get();
            foreach ($carts as $cart) {
                $price=  $course->discount_price > 0 ? $course->discount_price : $course->price;
                 if (isModuleActive('Store') && $cart->is_store ) {
                    if ($cart->product_sku_id) {
                        $sku = ProductSku::find($cart->product_sku_id);
                        $cart->price = $sku->price ?? 0;
                    }else{
                        $cart->price = $price;
                    }

                } else {

                    if (hasCouponApply($cart->course_id)) {
                        $price = getCouponPrice($cart->course_id);
                    }
                    $cart->price = $price;
                }

                $cart->save();
            }

        });
        self::deleted(function ($model) {
            if ($model->type == 1) {
                saasPlanManagement('course', 'delete');
            }
        });
    }

    public function forums()
    {
        return $this->hasMany(Forum::class, 'course_id', 'id');
    }

    public function uniqueForums()
    {
        return $this->hasMany(Forum::class, 'course_id', 'id')->groupBy('created_by');
    }

    public function enrollUsers()
    {
        return $this->belongsToMany(User::class, 'course_enrolleds', 'course_id', 'user_id');
    }

    public function cartUsers()
    {
        return $this->belongsToMany(User::class, 'carts', 'course_id', 'user_id');
    }

    public function BookmarkUsers()
    {
        return $this->belongsToMany(User::class, 'bookmark_courses', 'course_id', 'user_id');
    }

    public function quiz()
    {

        return $this->belongsTo(OnlineQuiz::class, 'quiz_id', 'id')
            ->withDefault([
                'title' => ' '
            ]);
    }

    public function class()
    {

        return $this->belongsTo(VirtualClass::class, 'class_id', 'id')->withDefault();
    }

    public function category()
    {

        return $this->belongsTo(Category::class, 'category_id', 'id')->withDefault([
            'name' => ' '
        ]);
    }

    public function subCategory()
    {

        return $this->belongsTo(Category::class, 'subcategory_id', 'id')->withDefault();
    }

    public function chapters()
    {

        return $this->hasMany(Chapter::class)->orderBy('position', 'asc');
    }

    public function lessons()
    {

        return $this->hasMany(Lesson::class, 'course_id')
            ->orderBy('position', 'asc');
    }

    public function lessonQuizzes()
    {
        return $this->hasMany(Lesson::class, 'course_id')->where('quiz_id', '>', '0')
            ->orderBy('position', 'asc');
    }

    public function comments()
    {

        return $this->hasMany(CourseComment::class, 'course_id')
            ->select(
                'id',
                'user_id',
                'course_id',
                'instructor_id',
                'status',
                'comment',
                'created_at',
            );
    }

    public function reviews()
    {

        return $this->hasMany(CourseReveiw::class, 'course_id')->where('status', 1)
            ->select(
                'user_id',
                'course_id',
                'status',
                'comment',
                'star',
            );
    }

    public function files()
    {

        return $this->hasMany(CourseExercise::class, 'course_id');
    }

    public function getdateFormatAttribute()
    {
        return Carbon::parse($this->created_at)->format(Settings('active_date_format') ?? 'jS M, Y');
    }

    public function getpublishedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format(Settings('active_date_format') ?? 'jS M, Y');
    }

    public function getsumRevAttribute()
    {
        return round($this->enrolls->sum('reveune'), 2);
    }

    public function getenrollCountAttribute()
    {
        return $this->enrolls->count();
    }

    public function getpurchasePriceAttribute()
    {
        return round($this->enrolls->sum('purchase_price'), 2);
    }

    public function virtualClass()
    {
        return $this->belongsTo(VirtualClass::class, 'class_id')->withDefault();
    }

    public function completeLessons()
    {
        if (Auth::check()) {
            return $this->hasMany(LessonComplete::class)->where('user_id', Auth::user()->id);

        } else {
            return $this->hasMany(LessonComplete::class)->whereNull('user_id');

        }
    }

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault([
            'name' => ' '
        ]);
    }

    public function completeQuiz()
    {
        if (Auth::check()) {
            return $this->hasMany(QuizTest::class)->where('user_id', Auth::user()->id);

        } else {
            return $this->hasMany(QuizTest::class)->whereNull('user_id');
        }
    }

    public function getDiscountPriceAttribute()
    {
        $price = $this->attributes['discount_price'];
//        if (Auth::check() && Auth::user()->role_id == 3 && isModuleActive('Subscription') && isSubscribe()) {
//            return 0;
//        }
        if (isModuleActive('CourseOffer')) {
            if ($this->offer == 1) {
                $main_price = $this->attributes['price'];
                return $this->offerPrice($this, $main_price);
            }
        } elseif (Settings('gamification_status') && Settings('gamification_reward_status')) {
            $percentage = [];
            if (Settings('gamification_reward_discount_course_point_status')) {
                if (Auth::check() && Auth::user()->gamification_total_points >= Settings('gamification_reward_course_point')) {
                    $percentage[] = Settings('gamification_reward_discount_course_point');

                }
            }


            if (Settings('gamification_reward_discount_course_level_status')) {
                if (Auth::check() && Auth::user()->user_level >= Settings('gamification_reward_course_level')) {
                    $percentage[] = Settings('gamification_reward_discount_course_level');
                }
            }

            if (Settings('gamification_reward_discount_course_badge_status')) {
                if (Auth::check() && Auth::user()->userLatestBadges->count() >= Settings('gamification_reward_course_badge')) {
                    $percentage[] = Settings('gamification_reward_discount_course_badge');
                }
            }
            if (count($percentage) != 0) {
                $per = max($percentage);
                $main_price = $this->attributes['price'];
                if ($main_price > 0) {
                    $discount = ($main_price / 100) * $per;
                    return $main_price - $discount;
                }
            }

        }
        if ($price <= 0) {
            return null;
        }
        return $price;
    }

//    public function getPriceAttribute()
//    {
//
//        $price = $this->attributes['price'];
//
//
//        return $price;
//    }
//

    public function offerPrice($course, $price)
    {

        if ($course->offer == 1) {
            if (Settings('offer_type') == 0) {
                $price = Settings('offer_amount');
            } else {
                $price = $price - ((Settings('offer_amount') / 100) * $price);

            }
        }
        if ($price <= 0) {
            $price = 0;
            $this->attributes['price'] = 0;
        }
        return $price;
    }

    public function courseLevel()
    {
        return $this->belongsTo(CourseLevel::class, 'level')->withDefault([
            'id' => 0,
            'title' => ''
        ]);
    }

    public function activeReviews()
    {
        return $this->hasMany(CourseReveiw::class, 'course_id', 'id')->where('status', 1);
    }

    public function getTotalReviewAttribute()
    {
        if (empty($this->total_rating)) {
            $total = 0;
        } else {
            $total = $this->total_rating;
        }
        return round($total, 2);
    }

    public function getIsLoginUserEnrolledAttribute()
    {

        $user = Auth::user();
        if (!$user){
            $user =Auth::guard('api')->user();
        }
        if (!$user) {
            return false;
        }

        if (isModuleActive('Store') && $this->attributes['type'] == 5 && $this->attributes['product_type'] == 2) {
            if ($user->role_id == 2) {
                if ($this->user_id == $user->id) {
                    return true;
                }
            }
            return false;
        }

        if ($user->role_id == 1) {
            return true;
        }
        if (isModuleActive('MyClass') && $user->role_id == 2) {
            if ($this->hasEnrollForClass()) {
                return true;
            }
        }
        if (isModuleActive('CPD') && $user->role_id == 2) {
            if ($this->hasEnrollForCPd()) {
                return true;
            }
        }
        $assign_ids = [];
        if (isModuleActive('OrgInstructorPolicy')) {

            $assigns = $user->policy->course_assigns;
            foreach ($assigns as $assign) {
                $assign_ids[] = $assign->course_id;
            }
        }
        if ($user->role_id == 2) {
            if ($this->user_id == $user->id) {
                return true;
            } elseif (count($assign_ids) && in_array($this->id, $assign_ids)) {
                return true;
            } elseif (!empty($this->assistant_instructors) && in_array($user->id, $this->assistantInstructorsIds)) {
                return true;
            } elseif ($this->enrollUsers->where('id', $user->id)->count()) {
                return true;
            }
        }
        if ($user->role_id == 4 || $user->role_id > 5) {
            if (Settings('staff_can_view_course') == 'yes') {
                return true;
            }
        }
        if ($this->enrollUsers->where('id', $user->id)->count()) {
            return true;
        }

        return false;

    }

    public function hasEnrollForClass()
    {
        $user = Auth::user();
        if (!$user){
            $user =Auth::guard('api')->user();
        }
        if (!$user) {
            return null;
        }
        return $this->hasOne('Modules\MyClass\Entities\ClassCourseAssignStudent', 'course_id', 'id')->when($user, function ($q) use ($user){
            $q->where('student_id', $user->id);
        });
    }

    public function hasEnrollForCPd()
    {
        $user = Auth::user();
        if (!$user){
            $user =Auth::guard('api')->user();
        }
        if (!$user) {
            return null;
        }
        return $this->hasOne('Modules\CPD\Entities\AssignStudent', 'course_id', 'id')->when($user, function ($q) use ($user) {
            $q->where('student_id', $user->id);
        });
    }

    public function getIsLoginUserCartAttribute()
    {
        $user = Auth::user();
        if (!$user){
            $user =Auth::guard('api')->user();
        }
        if (!$user) {
            return false;
        }
        if (!$this->cartUsers->where('user_id', $user->id)->count()) {
            return false;
        } else {
            return true;
        }
    }

    public function getIsLoginUserBookmarkAttribute()
    {
        $user = Auth::user();
        if (!$user){
            $user =Auth::guard('api')->user();
        }
        if (!$user) {
            return false;
        }
        if (!$this->BookmarkUsers->where('user_id', $user->id)->count()) {
            return false;
        } else {
            return true;
        }
    }

    public function getIsLoginUserReviewAttribute()
    {
        $user = Auth::user();
        if (!$user){
            $user =Auth::guard('api')->user();
        }
        if (!$user) {
            return false;
        }
        if (!$this->activeReviews->where('user_id', $user->id)->count()) {
            return false;
        } else {
            return true;
        }
    }

    public function getLoginUserTotalPercentageAttribute()
    {
        $percentage = 0;
        if (!isset($this->attributes['type'])) {
            return 0;
        }
        if ($this->attributes['type'] == 2) {
            $countCourse = count($this->completeQuiz->where('pass', 1));
            if ($countCourse != 0) {
                $percentage = 100;
            }
        } elseif ($this->attributes['type'] == 3) {

            $percentage = $this->userTotalClassPercentage(Auth::id(), $this->id);
        } else {
            $countCourse = count($this->completeLessons->where('status', 1));
            if ($countCourse != 0 && count($this->lessons) != 0) {
                $percentage = ceil($countCourse / count($this->lessons) * 100);
            }
            if ($percentage > 100) {
                $percentage = 100;
            }
        }

        return $percentage;

    }

    public function userQuizPercentage($user_id, $course_id)
    {
        $percentage = 0;
        $givenQuiz = QuizTest::where('user_id', $user_id)->where('course_id', $course_id)->get();
        if (count($givenQuiz) != 0) {
            $percentage = 50;
            foreach ($givenQuiz as $q) {
                $percentage = 100;
            }
        }
        return $percentage;
    }

    public function getIsGuestUserCartAttribute()
    {
        if (session()->has('cart')) {
            foreach (session()->get('cart') as $item) {
                if ($item['course_id'] == $this->id) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getStarWiseReviewAttribute()
    {
        $data['1'] = $this->activeReviews->where('star', '1')->count();
        $data['2'] = $this->activeReviews->where('star', '2')->count();
        $data['3'] = $this->activeReviews->where('star', '3')->count();
        $data['4'] = $this->activeReviews->where('star', '4')->count();
        $data['5'] = $this->activeReviews->where('star', '5')->count();
        $data['total'] = $data['1'] + $data['2'] + $data['3'] + $data['4'] + $data['5'];
        return $data;
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_id', 'id')->withDefault();

    }

    public function result()
    {
        $incomplete = 0;
        $complete = 0;
        foreach ($this->enrolls as $key => $enroll) {
            $percentage = round($this->userTotalPercentage($enroll->user_id, $enroll->course_id));
            if ($percentage < 100) {
                $incomplete += 1;
            } else {
                $complete += 1;
            }
        }
        $result = [
            'incomplete' => $incomplete,
            'complete' => $complete,
        ];
        return $result;
    }

    /* private function createSlug($name)
     {
         if (static::whereSlug($slug = Str::slug($name))->exists()) {

             $max = static::whereTitle($name)->latest('id')->skip(1)->value('slug');

             if (isset($max[-1]) && is_numeric($max[-1])) {

                 return preg_replace_callback('/(\d+)$/', function ($mathces) {

                     return $mathces[1] + 1;
                 }, $max);
             }
             return "{$slug}-2";
         }
         return $slug;
     }*/

    public function userTotalPercentage($user_id, $course_id)
    {
        $complete_lesson = LessonComplete::where('user_id', $user_id)->where('course_id', $course_id)->where('status', 1)->get();

        $countCourse = count($complete_lesson);
        if ($countCourse != 0 && count($this->lessons) != 0) {
            $percentage = ceil($countCourse / count($this->lessons) * 100);
        } else {
            $percentage = 0;
        }
        if ($percentage > 100) {
            $percentage = 100;
        }
        return $percentage;
    }

    public function isGroupCourse()
    {
        return $this->hasOne(Group::class, 'course_id');
    }

    public function courseStudyMaterials()
    {
        return $this->hasMany(InfixHomework::class, 'course_id', 'id');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    //slug start

    public function survey()
    {
        return $this->hasOne(Survey::class, 'course_id', 'id');
        // ->whereDate('publish_date', '>=', Settings('active_time_zone'))
        // ->where('publish_time', '>=', date("h:i:sa"));
    }

    public function badges()
    {
        return $this->morphMany(LmsBadge::class, 'badgeable');
    }

    //slug end

    public function userEnrollPercentage($enroll_id, $user_id, $course_id)
    {
        $complete_lesson = LessonComplete::where('user_id', $user_id)
            ->where('course_id', $course_id)
            ->where('enroll_id', $enroll_id)
            ->where('status', 1)
            ->get();
        $countCourse = count($complete_lesson);
        if ($countCourse != 0 && count($this->lessons) != 0) {
            $percentage = ceil($countCourse / count($this->lessons) * 100);
        } else {
            $percentage = 0;
        }
        if ($percentage > 100) {
            $percentage = 100;
        }
        return $percentage;

    }

    public function getAssistantInstructorsIdsAttribute()
    {
        $result = null;
        $assistant_instructors = $this->assistant_instructors;
        if (!empty($assistant_instructors)) {
            $result = json_decode($assistant_instructors, true);
        }
        return $result;
    }

    public function totalQuizStatistic($filters=[])
    {
        $data['not_start'] = 0;
        $data['fail'] = 0;
        $data['pass'] = 0;

        $totalEnroll = $this->enrolls()->whereHas('user', function ($query) use ($filters) {
            if (isset($filters['id'])) {
                $query->where('id', $filters['id']);
            }
            if (isset($filters['institute_id'])) {
                $query->where('institute_id', $filters['institute_id']);
            }
            if (isset($filters['status'])) {
                $query->where('status', $filters['status']);
            }
        })->get();

        foreach ($totalEnroll as $enroll) {
            $result = $this->userTotalQuizPercentage($enroll->user_id, $enroll->course_id);

            if ($result == 0) {
                $data['not_start'] = $data['not_start'] + 1;
            } elseif ($result == 100) {
                $data['pass'] = $data['pass'] + 1;
            } else {
                $data['fail'] = $data['fail'] + 1;

            }
        }
        $data['total_enroll'] = $data['not_start'] + $data['pass'] + $data['fail'];

        return $data;
    }

    public function enrolls()
    {

        return $this->hasMany(CourseEnrolled::class, 'course_id', 'id');
    }

    public function userTotalQuizPercentage($user_id, $course_id)
    {
        $percentage = 0;
        $givenQuiz = QuizTest::where('user_id', $user_id)->where('course_id', $course_id)->get();
        if (count($givenQuiz) != 0) {
            $percentage = 50;
            foreach ($givenQuiz as $q) {
                if ($q->pass == 1) {
                    $percentage = 100;
                }
            }
        }
        return $percentage;
    }

    public function getNotStatedYetAttribute()
    {
        return $this->totalStatistic()['not_start'];
    }

    public function totalStatistic($filters=[])
    {
        $data['not_start'] = 0;
        $data['in_process'] = 0;
        $data['finished'] = 0;

        $totalEnroll = $this->enrolls()->whereHas('user', function ($query) use ($filters) {
            if (isset($filters['id'])) {
                $query->where('id', $filters['id']);
            }
            if (isset($filters['institute_id'])) {
                $query->where('institute_id', $filters['institute_id']);
            }
            if (isset($filters['status'])) {
                $query->where('status', $filters['status']);
            }
        })->get();

        foreach ($totalEnroll as $enroll) {
            $result = $this->userTotalPercentage($enroll->user_id, $enroll->course_id);

            if ($result == 0) {
                $data['not_start'] = $data['not_start'] + 1;
            } elseif ($result == 100) {
                $data['finished'] = $data['finished'] + 1;
            } else {
                $data['in_process'] = $data['in_process'] + 1;
            }
        }
        $data['total_enroll'] = $data['not_start'] + $data['in_process'] + $data['finished'];

        return $data;
    }

    public function totalClassStatistic($filters=[])
    {
        $data['not_start'] = 0;
        $data['in_process'] = 0;
        $data['finished'] = 0;

        $totalEnroll = $this->enrolls()->whereHas('user', function ($query) use ($filters) {
            if (isset($filters['id'])) {
                $query->where('id', $filters['id']);
            }
            if (isset($filters['institute_id'])) {
                $query->where('institute_id', $filters['institute_id']);
            }
            if (isset($filters['status'])) {
                $query->where('status', $filters['status']);
            }
        })->get();

        foreach ($totalEnroll as $enroll) {
            $result = $this->userTotalClassPercentage($enroll->user_id, $enroll->course_id);

            if ($result == 0) {
                $data['not_start'] = $data['not_start'] + 1;
            } elseif ($result == 100) {
                $data['finished'] = $data['finished'] + 1;
            } else {
                $data['in_process'] = $data['in_process'] + 1;
            }
        }
        $data['total_enroll'] = $data['not_start'] + $data['in_process'] + $data['finished'];

        return $data;
    }

    public function userTotalClassPercentage($user_id, $course_id)
    {
        $complete_class = ClassComplete::where('user_id', $user_id)->where('course_id', $course_id)->where('status', 1)->get();
        $countCourse = count($complete_class);

        $class = $this->class;
        $totalClass = 0;
        if ($class->host == 'Zoom') {
            $totalClass = count($class->zoomMeetings);
        } elseif ($class->host == 'BBB') {
            $totalClass = count($class->bbbMeetings);
        } elseif ($class->host == 'Jitsi') {
            $totalClass = count($class->jitsiMeetings);
        }elseif ($class->host == 'Custom') {
            $totalClass = count($class->customMeetings);
        }elseif ($class->host == 'InAppLiveClass') {
            $totalClass = count($class->inAppMeetings);
        }

        if ($countCourse != 0 && $totalClass != 0) {
            $percentage = ceil($countCourse / $totalClass * 100);
        } else {
            $percentage = 0;
        }
        if ($percentage > 100) {
            $percentage = 100;
        }
        return $percentage;
    }

    public function getInProcessAttribute()
    {
        return $this->totalStatistic()['in_process'];
    }

    public function orgCourseList()
    {
        return $this->hasMany(OrgSubscriptionCourseList::class, 'course_id');
    }

    public function orgAttendance()
    {
        return $this->hasMany(OrgAttendance::class, 'course_id', 'id');
    }

    public function attendanceData()
    {
        $total_enroll = $this->attributes['total_enrolled'];
        $attendances = $this->orgAttendance;
        $ontime = $attendances->where('attend', '=', 'O')->count();
        $late = $attendances->where('attend', '=', 'L')->count();
        $absence = $total_enroll - ($ontime + $late);
        $pass = $attendances->where('pass', '=', '1')->count();
        $fail = $total_enroll - $pass;
        $attend_rate = getPercentage(($ontime + $late), $total_enroll);
        $pass_rate = getPercentage($pass, $total_enroll);
        $data['on_time'] = $ontime;
        $data['late'] = $late;
        $data['absence'] = $absence;
        $data['pass'] = $pass;
        $data['fail'] = $fail;
        $data['attend_rate'] = $attend_rate;
        $data['pass_rate'] = $pass_rate;
        return $data;

    }

    public function orgSubscriptionCourseList()
    {
        return $this->hasMany(orgSubscriptionCourseList::class, 'course_id');
    }

    public function quizCompletes()
    {
        $user = Auth::user();
        if (!$user){
            $user =Auth::guard('api')->user();
        }
        if (!$user) {
            return [];
        }
        return $this->hasMany(QuizTest::class, 'course_id', 'id')->where('user_id', $user->id)->orderBy('id');
    }

    public function moreQuizzes()
    {
        return Course::where('type', 2)->where('id', '!=', $this->attributes['id'])->take(5)->get();
    }

    public function certificate()
    {
        if (isModuleActive('CertificatePro') && Settings('use_certificate_template') == 'pro') {
            return $this->belongsTo(CertificateTemplate::class, 'pro_certificate_id')->withDefault([
                'id' => 0,
                'title' => ' ',
            ]);
        } else {
            return $this->belongsTo(Certificate::class, 'certificate_id')->withDefault([
                'id' => 0,
                'title' => ' ',
            ]);
        }
    }

    public function shifts()
    {
        return $this->hasMany(OnlineQuizTestShift::class, 'test_id')->orderBy('shift');
    }

    public function waitList()
    {
        return $this->hasMany(CourseWaitingList::class, 'course_id', 'id');
    }

    public function courseType()
    {
        $type = '';
        if ($this->type == 1) {
            $type = trans('courses.Course');
        } elseif ($this->type == 2) {
            $type = trans('courses.Quiz');
        } elseif ($this->type == 3) {
            $type = trans('courses.Virtual Class');
        }
        return $type;
    }

    public function isOrganizationCourse()
    {
        if ($this->user->role_id == 5 || $this->user->organization_id != null) {
            return true;
        }
        return false;
    }

    public function courseOrganization()
    {
        if ($this->user->role_id == 5) {
            return $this->user;
        } elseif ($this->user->organization_id) {
            return User::find($this->user->organization_id);
        }
        return null;

    }

    public function userCourseCompletePercentage($user_id)
    {

        $percentage = 0;
        if (!isset($this->attributes['type'])) {
            return 0;
        }
        if ($this->attributes['type'] == 2) {
            $countCourse = $this->hasMany(QuizTest::class)->where('user_id', $user_id)->where('pass', 1)->count();
            if ($countCourse != 0) {
                $percentage = 100;
            }
        } else {
            $countCourse = $this->hasMany(LessonComplete::class)->where('user_id', $user_id)->where('status', 1)->count();
            if ($countCourse != 0 && count($this->lessons) != 0) {
                $percentage = ceil($countCourse / count($this->lessons) * 100);
            }
            if ($percentage > 100) {
                $percentage = 100;
            }
        }

        return $percentage;

    }

    public function pricePlans()
    {
        return $this->morphMany(PricePlan::class, 'price_planable');
    }

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id')->withDefault();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->withDefault();
    }

    public function image_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'image');
    }
    public function course_badge_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'course_badge');
    }

    public function trailer_link_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'trailer_link');
    }

    public function certificate_records()
    {
        return $this->hasMany(CertificateRecord::class, 'course_id', 'id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault([
            'name' => ' '
        ]);
    }

    public function getModeOfDeliveryAttribute($value){
        return (int)$value;
    }

    protected function generateNonUniqueSlug(): string
    {
        $slugField = $this->slugOptions->slugField;
        if ($this->hasCustomSlugBeenUsed() && !empty($this->$slugField)) {
            return $this->$slugField;
        }

        try {
            $slugify = new Slugify(['rulesets' => ['default', lcfirst($this->language->name)]]);
        } catch (Exception $e) {
            $slugify = new Slugify(['rulesets' => ['default']]);
        }

        return $slugify->slugify($this->getSlugSourceString(), $this->slugOptions->slugSeparator);
    }


}
