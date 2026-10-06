<?php

namespace App\Http\Middleware;

use App\Http\Controllers\BahasaController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetBahasa
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ambil pilihhan dari session; jka blum ada, pakai bawaan config

        $bahasa = $request->session()
            ->get('bahasa', config('app.locale'));

        // periksa lagi sekali untuk berjaga jaga
        if (!in_array($bahasa, BahasaController::BAHASA_TERSEDIA, true)) {
            $bahasa = config('app.locale');
        }

        App::setLocale($bahasa);

        return $next($request);
    }
}
