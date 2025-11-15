<?php

namespace Modules\Quiz\Entities;

use App\Traits\Tenantable;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Modules\CourseSetting\Entities\Category;
use Modules\Setting\Entities\UsedMedia;


class QuestionBank extends Model
{

    use Tenantable;

    protected $guarded = ['id'];

    public function questionGroup()
    {
        return $this->belongsTo('Modules\Quiz\Entities\QuestionGroup', 'q_group_id')->withDefault();
    }

    public function questionLevel()
    {
        return $this->belongsTo(QuestionLevel::class, 'level')->withDefault();
    }

    public function category()
    {

        return $this->belongsTo(Category::class, 'category_id', 'id')->withDefault();
    }

    public function subCategory()
    {

        return $this->belongsTo(Category::class, 'sub_category_id', 'id')->withDefault();
    }


    public function questionMu()
    {
        return $this->hasMany(QuestionBankMuOption::class, 'question_bank_id', 'id')->inRandomOrder();
    }

    public function questionMuInSerial()
    {
        return $this->hasMany(QuestionBankMuOption::class, 'question_bank_id', 'id');
    }
    public function questionSortingOptionsSerial()
    {
        return $this->hasMany(QuestionBankMuOption::class, 'question_bank_id', 'id')->orderBy('position');
    }
    public function questionSortingOptions()
    {
        return $this->hasMany(QuestionBankMuOption::class, 'question_bank_id', 'id')->inRandomOrder();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function quizAssign()
    {
        return $this->hasMany(OnlineExamQuestionAssign::class, 'question_bank_id');
    }

    public function image_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'image');
    }

    public function matchingOptions()
    {
        return $this->hasMany(MatchingTypeQuestionAssign::class, 'question_id', 'id');
    }

}
