<?php

namespace Modules\Quiz\Entities;

use App\Traits\Tenantable;
use App\User;
use Illuminate\Database\Eloquent\Model;


class QuestionGroup extends Model
{
    use Tenantable;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function childs()
    {
        return $this->hasMany(QuestionGroup::class, 'parent_id')->orderBy('order', 'asc')->with('parent', 'childs');
    }

    public function parent()
    {
        return $this->belongsTo(QuestionGroup::class, 'parent_id')->withDefault();
    }

    public function getAllChildIds($child, $pathId = [])
    {
        if (isset($child->childs)) {
            if (count($child->childs) != 0) {
                foreach ($child->childs as $child) {
                    $pathId[] = $child->id;
                    $pathId = $this->getAllChildIds($child, $pathId);
                }
                return $pathId;
            }
        }
        return $pathId;
    }

    public function questions()
    {
        return $this->hasMany(QuestionBank::class, 'q_group_id');
    }
}
