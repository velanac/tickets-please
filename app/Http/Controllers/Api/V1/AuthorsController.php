<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Filters\V1\AuthorFilter;
use App\Http\Resources\V1\UserResource;

class AuthorsController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(AuthorFilter $filter)
    {
        return UserResource::collection(User::select('users.*')
            ->join('tickets', 'users.id', '=', 'tickets.user_id')
            ->filter($filter)
            ->distinct()
            ->paginate());
    }

    /**
     * Display the specified resource.
     */
    public function show(User $author)
    {
        if ($this->include('tickets')) {
            return new UserResource($author->load('tickets'));
        }

        return new UserResource($author);
    }
}
