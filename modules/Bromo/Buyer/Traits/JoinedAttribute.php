<?php

namespace Bromo\Buyer\Traits;

use Carbon\Carbon;

trait JoinedAttribute
{
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