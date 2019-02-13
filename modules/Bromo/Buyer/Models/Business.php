<?php

namespace Bromo\Buyer\Models;

use Bromo\Theme\Utils\FormatDates;
use Bromo\Theme\Utils\TimezoneAccessor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use FormatDates, TimezoneAccessor;

    public $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    public $incrementing = false;
    protected $table = 'business';
    protected $dateFormat = 'Y-m-d H:i:s.uO';
    protected $fillable = [
        'tag',
        'name',
        'description',
        'tax_no',
        'tax_no_image_file',
        'logo_file',
        'status'
    ];

    public function status()
    {
        return $this->belongsTo(BusinessStatus::class, 'status');
    }

    /**
     * Created At Formatted
     * field created_at_formatted
     * @return string
     */
    public function getJoinedAtFormattedAttribute()
    {
        if ($this->getJoinedAtTimezoneAttribute()) {
            return $this->getJoinedAtTimezoneAttribute()->format(config('themes.base_format_date'));
        }

        return '';
    }

    /**
     * Created At Timezone Attribute
     *
     * @return mixed
     */
    public function getJoinedAtTimezoneAttribute()
    {
        if (strlen($this->joined_at) > 0) {
            $date = Carbon::createFromTimestamp($this->joined_at);

            return $this->getMutatedTimestampValue($date);
        }

        return $this->joined_at;
    }
}