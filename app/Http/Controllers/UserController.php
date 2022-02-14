<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request, User $user) {
        $this->authorize('create', $user);
        User::create($request->validated());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  UserRequest $request, User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user) {
        $this->authorize('update', $user);
        $user->update($request->validated());
    }
}
