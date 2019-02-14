<?php

namespace Nbs\Theme\Utils;

use Carbon\Carbon;

trait FormatDates
{
    /**
     * Created At Formatted
     * field created_at_formatted
     * @return string
     */
    public function getCreatedAtFormattedAttribute()
    {
        if ($this->getCreatedAtTimezoneAttribute()) {
            return $this->getCreatedAtTimezoneAttribute()->format(config('themes.base_format_date'));
        }

        return '';
    }

    /**
     * Created At Timezone Attribute
     *
     * @return mixed
     */
    public function getCreatedAtTimezoneAttribute()
    {
        if (strlen($this->created_at) > 0) {
            $date = Carbon::createFromTimestamp($this->created_at);

            return $this->getMutatedTimestampValue($date);
        }

        return $this->created_at;
    }

    /**
     * Updated At Formatted
     * field updated_at_formatted
     * @return string
     */
    public function getUpdatedAtFormattedAttribute()
    {
        if ($this->getUpdatedAtTimezoneAttribute()) {
            return $this->getUpdatedAtTimezoneAttribute()->format(config('themes.base_format_date'));
        }

        return '';
    }

    public function getUpdatedAtTimezoneAttribute()
    {
        if (strlen($this->updated_at) > 0) {
            $date = Carbon::createFromTimestamp($this->updated_at);

            return $this->getMutatedTimestampValue($date);
        }

        return $this->updated_at;
    }
}