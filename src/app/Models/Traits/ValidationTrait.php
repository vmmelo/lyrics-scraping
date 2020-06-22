<?php


namespace App\Models\Traits;

use Illuminate\Support\Facades\Validator;

trait ValidationTrait
{

    public function validate($inputs)
    {
        if (!empty(self::$rules)) {
            $v = Validator::make($inputs, self::$rules);
            if (!$v->passes()) {
                \Log::channel('modelValidation')->alert(self::class.' - '.json_encode($v->messages()));
                return false;
            }
        }

        return true;
    }

}
