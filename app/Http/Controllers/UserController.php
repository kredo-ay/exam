<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\InformationInterface;
use App\Http\Requests\PaginationRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * @param InformationInterface $service
     * @param PaginationRequest $request
     */
    public function show(InformationInterface $service, PaginationRequest $request)
    {
        if ($request->has('page')) {
            return $service->paginate($request);
        } else {
            return Inertia::render('User/Show', [
            'user' => auth()->user(),
            'items' => $service->paginate($request),
            'source' => $service->source()
            ]);
        }
    }
}
