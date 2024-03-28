<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AuthenticationModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{

    public function index(){
        if (Auth::guest()) {
            return view('auth.login');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function login(Request $request)
    {
        // Ambil email dan password dari request
        $credentials = $request->only('email', 'password');

        // Coba melakukan login
        if (Auth::attempt($credentials)) {
            // Set variabel sesi untuk pesan berhasil
            Session::flash('success_login', 'Login berhasil');
            // Kembalikan ke halaman utama atau halaman yang Anda inginkan
            return redirect()->route('dashboard');
        }

        // Jika login gagal, kembalikan pengguna ke halaman login dengan pesan flash
        return redirect()->route('login')->with('failed_login', 'Email atau password salah');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = AuthenticationModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Set variabel sesi untuk pesan berhasil
        Session::flash('success_register', 'Pendaftaran anda berhasil');

        // Kembalikan ke halaman utama atau halaman yang Anda inginkan
        return view('auth.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
