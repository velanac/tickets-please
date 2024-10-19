<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\ApiRespones;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    use ApiRespones;

    public function include(string $relationship): bool
    {
        $param = request()->get('include');

        if (!isset($param)) {
            return false;
        }

        $includeValues = explode(',', strtolower($param));

        return in_array(strtolower($relationship), $includeValues);
    }
}
