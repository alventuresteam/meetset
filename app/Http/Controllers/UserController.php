<?php

namespace App\Http\Controllers;

use App\Http\Middleware\isAdmin;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum','is_admin']);
    }

    public function create(UserRequest $request)
    {
        User::create($request->validated());

        return response()->json(['success' => true]);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->validated());

        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true]);
    }
}
