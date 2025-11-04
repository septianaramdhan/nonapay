<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kasir;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login', ['title' => 'Login Kasir']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $kasir = Kasir::where('username', $request->username)->first();

        if ($kasir && Hash::check($request->password, $kasir->password)) {
            Session::put('kasir_id', $kasir->id_kasir);
            Session::put('kasir_name', $kasir->nama_kasir);
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['login' => 'Username atau password salah!']);
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login.form');
    }
}
