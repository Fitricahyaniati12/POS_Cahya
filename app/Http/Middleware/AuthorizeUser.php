<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser {
    public function handle(Request $request, Closure $next, ...$roles): Response
{
    // Flatten roles jika ada yang menggunakan koma
    $allowedRoles = collect($roles)
        ->flatMap(fn($role) => explode(',', $role))
        ->map(fn($role) => strtoupper(trim($role)))
        ->toArray();

    $user = $request->user();

    if (!$user || !in_array(strtoupper($user->getRole()), $allowedRoles)) {
        abort(403, 'Forbidden. Kamu tidak mempunyai akses ke halaman ini');
    }

    return $next($request);
    }
}