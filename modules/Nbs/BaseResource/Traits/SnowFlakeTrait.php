<?php

namespace Nbs\BaseResource\Traits;

trait SnowFlakeTrait
{
    public static function bootSnowFlakeTrait()
    {
        static::creating(function ($model) {
            if (!isset($model->attributes[$model->getKeyName()])) {
                $model->{$model->getKeyName()} = snowflake_id();
            }
        });
    }
}