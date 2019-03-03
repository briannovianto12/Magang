<?php

namespace Modules\Nbs\BaseResource\Traits;

trait VersionModelTrait
{
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $model->increment("{$model->getVersionName()}", 1);
        });
    }
}