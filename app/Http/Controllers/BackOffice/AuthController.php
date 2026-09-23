<?php

namespace App\Http\Controllers\BackOffice;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function tampilkanForm()
    {
        if (Auth::check()) {
            return redirect()->route('back_office.dashboard');
        }
        return view('back_office.login');
    }

    public function proses(Request $request)
    {

        $credentials = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required']
            ],
            [
                'email.required' => 'Email wajib diisi',
                'email.email' => "Format email tidak benar",
                'password.required' => "Password wajib diisi"
            ]
        );

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {

            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        /** @var User $user */
        $user = Auth::user();
        if (! $user->isAdmin()) {

            Auth::logout();

            return back()
                ->withErrors(['email' => 'Akun ini tidak berhak mengakses back office.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()
            ->intended(route('back_office.dashboard'))
            ->with('sukses', 'Selamat datang kembali, ' . Auth::user()->name . '.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('back_office.login')
            ->with('sukses', 'Anda sudah keluar dari sistem.');
    }
}
