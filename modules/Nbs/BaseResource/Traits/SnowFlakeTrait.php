<?php

namespace Nbs\BaseResource\Traits;

trait SnowFlakeTrait
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!isset($model->attributes[$model->getKeyName()])) {
                $model->{$model->getKeyName()} = snowflake_id();
            }
        });
    }
}