<?php

namespace Modules\Nbs\BaseResource\Traits;

trait VersionModelTrait
{
    public static function bootVersionModelTrait()
    {
        static::creating(function ($model) {
            $model->version = 0;
        });

        static::updating(function ($model) {
            $model->increment("{$model->getVersionName()}", 1);
        });
    }
}