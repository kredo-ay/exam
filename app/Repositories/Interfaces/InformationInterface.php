<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface InformationInterface
{
    /**
     * @return LengthAwarePaginator
     */
    public function paginate(): LengthAwarePaginator;
}