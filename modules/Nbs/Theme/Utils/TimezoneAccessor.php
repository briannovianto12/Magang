<?php

namespace Nbs\Theme\Utils;

use Carbon\Carbon;

trait TimezoneAccessor
{
    public function getMutatedTimestampValue($value)
    {
        $timezone = session()->has('timezone') ? session()->get('timezone') : 'Asia/Jakarta';

//        if (Auth::check() && Auth::user()->timezone) {
//            $timezone = Auth::user()->timezone;
//        }

        return Carbon::parse($value)
            ->timezone($timezone);
    }
}