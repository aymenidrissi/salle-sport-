<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * L’accès aux routes /admin/* est réservé aux utilisateurs dont le rôle a le slug « admin ».
     * Sans rôle chargé ou avec un rôle « client », isAdmin() est faux → accès refusé.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->guest(route('login'));
        }

        $user->loadMissing('role');

        if (! $user->isAdmin()) {
            return redirect()
                ->route('client.home')
                ->with('warning', 'L’espace d’administration est réservé aux comptes administrateur. Déconnectez-vous et connectez-vous avec un compte admin pour accéder aux profils.');
        }

        return $next($request);
    }
}
