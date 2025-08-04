<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function create()
    {
        return view('superadmin.account');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'role' => 'admin', // ⬅️ otomatis admin
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('superadmin.account')->with('success', 'Akun admin berhasil dibuat.');
    }
}
