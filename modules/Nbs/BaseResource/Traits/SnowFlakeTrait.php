<?php

namespace Modules\Nbs\BaseResource\Traits;

trait SnowFlakeTrait
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){

            $model->{$model->getKeyName()} = snowflake_id();

        });
    }
}