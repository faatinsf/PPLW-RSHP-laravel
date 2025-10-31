<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    public function index()
    {
        return response()->json(RoleUser::with(['user', 'role'])->get());
    }

    public function store(Request $request)
    {
        $roleUser = RoleUser::create($request->all());
        return response()->json($roleUser, 201);
    }

    public function show($id)
    {
        return response()->json(RoleUser::with(['user', 'role'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $roleUser = RoleUser::findOrFail($id);
        $roleUser->update($request->all());
        return response()->json($roleUser);
    }

    public function destroy($id)
    {
        RoleUser::destroy($id);
        return response()->json(['message' => 'RoleUser deleted']);
    }
}
