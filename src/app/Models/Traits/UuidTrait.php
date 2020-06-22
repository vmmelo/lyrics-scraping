<?php

namespace App\Models\Traits;

use \Ramsey\Uuid\Uuid as RamseyUuid;

trait UuidTrait
{

    public static function boot()
    {
        parent::boot();

        static::creating(
            function ($obj) {
                if (empty($obj->id)) {
                    $obj->id = RamseyUuid::uuid4();
                }
            }
        );
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
