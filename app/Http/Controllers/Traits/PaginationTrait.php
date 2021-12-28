<?php

namespace App\Http\Controllers\Traits;

trait PaginationTrait
{
    public function getPerPage()
    {
        $defaultPageSize = 10;
        return request('limit', $defaultPageSize);
    }
}
