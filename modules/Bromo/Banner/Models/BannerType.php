<?php

namespace Bromo\Banner\Models;

use Illuminate\Database\Eloquent\Model;

class BannerType extends Model
{
    protected $table = 'banner_type';
    protected $fillable = [
        'name'
    ];
    protected $dateFormat = 'Y-m-d H:i:s.uO';

    public function banner()
    {
        return $this->belongsTo(Banner::class, 'banner_type_id');
    }
}
