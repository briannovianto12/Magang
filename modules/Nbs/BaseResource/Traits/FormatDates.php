<?php

namespace Nbs\BaseResource\Traits;

use Carbon\Carbon;

trait FormatDates
{
    /**
     * Created At Formatted
     * field created_at_formatted
     * @return string
     */
    public function getCreatedAtFormattedAttribute(): string
    {
        return $this->getCreatedAtTimezoneAttribute() ?
            $this->getCreatedAtTimezoneAttribute()->format(config('themes.base_format_date')) : '';
    }

    /**
     * Created At Timezone Attribute
     *
     * @return mixed
     */
    public function getCreatedAtTimezoneAttribute()
    {
        if (is_null($this->created_at) || $this->created_at == '') {
            return $this->created_at;
        }

        $date = Carbon::createFromTimestamp(strtotime($this->created_at));

        return (config('database.default') == 'pgsql') ? $date : $this->getMutatedTimestampValue($date);
    }

    /**
     * Updated At Formatted
     * field updated_at_formatted
     * @return string
     */
    public function getUpdatedAtFormattedAttribute()
    {
        return $this->getUpdatedAtTimezoneAttribute() ?
            $this->getUpdatedAtTimezoneAttribute()->format(config('themes.base_format_date')) : '';
    }

    public function getUpdatedAtTimezoneAttribute()
    {
        if (is_null($this->updated_at) || $this->updated_at == '') {
            return $this->updated_at;
        }

        $date = Carbon::createFromTimestamp(strtotime($this->updated_at));

        return (config('database.default') == 'pgsql') ? $date : $this->getMutatedTimestampValue($date);
    }
}