<?php

namespace Nbs\BaseResource\Utils;

use Carbon\Carbon;

trait TimezoneAccessor
{
    public function getCreatedAtAttribute($value)
    {
        if (present($value)) {
            return $this->getMutatedTimestampValue($value);
        }

        return $value;
    }

    public function getMutatedTimestampValue($value)
    {
        $timezone = session()->has('timezone') ? session()->get('timezone') : 'Asia/Jakarta';

//        if (Auth::check() && Auth::user()->timezone) {
//            $timezone = Auth::user()->timezone;
//        }

        return Carbon::parse($value)
            ->timezone($timezone);
    }

    public function getUpdatedAtAttribute($value)
    {
        if (present($value)) {
            return $this->getMutatedTimestampValue($value);
        }

        return $value;
    }
}