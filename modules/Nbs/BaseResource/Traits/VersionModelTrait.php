<?php

namespace Nbs\BaseResource\Traits;

trait VersionModelTrait
{
    // Default exceptional attribute when update
    protected $logisticExcepts = [
        'status',
        'created_at',
        'updated_at',
        'modified_by',
        'modifier_role'
    ];

    protected $field = 'version';

    public static function bootVersionModelTrait()
    {
        static::creating(function ($model) {
            $model->version = 0;
        });

        static::updating(function ($model) {
            $model->increment("{$model->getVersionName()}", 1);
        });
    }

    private function filteredAttributes(): array
    {
        return array_except($this->getChanges(), $this->logisticExcepts);
    }

    private function validate(): bool
    {
        return count($this->filteredAttributes()) > 0;
    }

    public function updateVersionFromAdmin(): void
    {
        if ($this->validate()) {
            $this->increment($this->field);
        }
    }
}