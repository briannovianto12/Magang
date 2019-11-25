<?php

namespace Bromo\Banner\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    protected $table = 'banner';
    protected $fillable = [
        'banner_type_id',
        'banner_location_id',
        'title',
        'image_file',
        'sort_by',
        'image_file',
        'visible',
        'url',
        'seller_only',
        'image_file',
        'period_start_date',
        'period_finish_date'
    ];
    protected $dateFormat = 'Y-m-d H:i:s.uO';

    public function type()
    {
        return $this->hasOne(BannerType::class, 'id', 'banner_type_id');
    }

    public function location()
    {
        return $this->hasOne(BannerLocation::class, 'id', 'banner_location_id');
    }
}
