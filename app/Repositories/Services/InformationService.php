<?php

namespace App\Repositories\Services;

use App\Models\Information;
use App\Repositories\Interfaces\InformationInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class InformationService implements InformationInterface
{
    /**
     * @param mixed $request
     * @return LengthAwarePaginator
     */
    public function paginate($request = null): LengthAwarePaginator 
    {
        $result = Information::when($request->input('from', false), function (Builder $query) use ($request) {
            return $query->whereDate('calldate','>=', $request->from);
        })
        ->when($request->input('to', false), function (Builder $query) use ($request) {
            return $query->whereDate('calldate','<=', $request->to);
        })
        ->when($request->input('src', false), function (Builder $query) use ($request) {
            return $query->where('src','=', $request->src);
        })
        ->when($request->input('dst', false), function (Builder $query) use ($request) {
            if ($request->dst == "like") {
                return $query->where('dst','like', '%'.$request->dstvalue.'%');
            } else {
                return $query->where('dst','=', $request->dstvalue);
            }
          
        });

        if($request->has('page')) {
           return $result->paginate(20, ['*'], 'page', $request->page);
        } else { 
            return $result->paginate(20);
        }

    }

    /**
     * @return Collection
     */
    public function source()
    {
        return Information::select('src')->distinct()->get();
    }

    /**
     * @return Collection
     */
    public function destination()
    {
        return Information::select('dst')->distinct()->get();
    }
}