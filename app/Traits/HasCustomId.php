<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasCustomId
{
    protected static function bootHasCustomId()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $prefix = $model->getPrefix();
                $lastRecord = static::orderBy($model->getKeyName(), 'desc')->first();

                $number = 1;
                if ($lastRecord) {
                    // Extract number from last ID (e.g., 'kdr005' -> 5)
                    $lastId = $lastRecord->{$model->getKeyName()};
                    $lastNumber = (int) substr($lastId, strlen($prefix));
                    $number = $lastNumber + 1;
                }

                // Format: prefix + 3 digits (e.g., kdr001)
                $model->{$model->getKeyName()} = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    // Must be implemented by Model
    abstract public function getPrefix();

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
