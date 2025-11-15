<?php

namespace Modules\SystemSetting\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

use Modules\SystemSetting\Entities\FooterContent;

class FooterCategory extends Model
{
    use Tenantable;

    protected $fillable = ['title', 'description', 'placeholder'];

    public function contents()
    {
        return $this->hasMany(FooterContent::class);
    }
}
