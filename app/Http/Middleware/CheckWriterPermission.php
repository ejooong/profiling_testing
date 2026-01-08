<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckWriterPermission
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }
        
        // Cek apakah user memiliki permission untuk menulis berita
        if (!$request->user()->can('create-berita')) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        
        return $next($request);
    }
}