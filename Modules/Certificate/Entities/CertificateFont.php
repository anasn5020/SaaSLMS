<?php

namespace Modules\Certificate\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\UsedMedia;

class CertificateFont extends Model
{
    use Tenantable;

    protected $fillable = [];

    public function font_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'font');
    }

}
