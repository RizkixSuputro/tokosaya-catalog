<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('back_office.login');
        }

        /** @var User $user */
        $user = Auth::user();
        if (!$user->isAdmin()) {
            Auth::logout();

            return redirect()->route('back_office.login')
                ->withErrors([
                    'email' => 'Akun ini tidak memiliki akses ke back office.'
                ]);
        }

        return $next($request);
    }
}
