<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function userShow()
    {
        $users = User::with('roles')->Paginate(10);
        $roles = Role::all();
        return view('admin.user', compact('users', 'roles'));
    }
    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->username;
        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->password = Hash::make($request->password);
        $user->save();
        $user->assignRole('writer');
        return view('admin.done');
    }
    public function search(Request $request)
    {
        $roleId = $request->input('role_id');
        $query = User::with('roles');
        if ($roleId === 'all') {
            $users = $query->get();
        } elseif ($roleId === 'user') {
            $users = $query->doesntHave('roles')->get();
        } else {
            $users = $query->whereHas('roles', function ($q) use ($roleId) {
                $q->where('roles.id', $roleId);
            })->get();
        }
        return response()->json($users);
    }//
}
