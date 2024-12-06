<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with('roles')->get();
        $role = Role::all();

        $data = [
            'title' => 'User',
            'users' => $user,
            'roles' => $role
        ];
        return view('user.index', $data);
    }


    public function update(Request $r)
    {
        $user = User::findOrFail($r->id); // Ambil instance user
        $user->update([
            'name' => $r->name,
            'email' => $r->email,
        ]);

        // Sinkronkan role
        $user->roles()->sync([$r->role]);

        return redirect()->route('user.index')->with(['sukses' => 'User Updated']);
    }
}
