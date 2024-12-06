<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user  = User::with('roles')->get();
        $data = [
            'title' =>'User',
            'users' => $user
        ];
        return view('user.index',$data);
    }
}
