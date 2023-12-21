<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequet;
use App\Http\Resources\UserResource;

class UserController extends Controller
{

    public function index()
    {
        return UserResource::collection(User::orderByDesc('created_at')->get());
    }


    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->all());
        if ($user) {
            return response()->json([
                'message' => 'Usuario creado con exito',
                'data' => UserResource::make($user)
            ]);
        }

        return response()->json([
            'message' => 'Error al crear usuario',
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return UserResource::make($user);
    }

    public function update(UserUpdateRequet $request, $id)
    {
        $user = User::findOrFail($id)->update($request->all());

        if ($user) {
            return response()->json([
                'message' => 'Usuario Modificado con exito',
                'data' => UserResource::make(User::findOrFail($id))
            ]);
        }

        return response()->json([
            'message' => 'Error al Editar usuario',
        ]);
    }
}
