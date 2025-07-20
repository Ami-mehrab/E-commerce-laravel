<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Rolemanager
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $authuserRole = Auth::user()->role; // 0=admin, 1=vendor, 2=customer

        // Check if the user role matches the required role
        if (
            ($role === 'admin' && $authuserRole == 0) ||
            ($role === 'vendor' && $authuserRole == 1) ||
            ($role === 'customer' && $authuserRole == 2)
        ) {
            return $next($request);
        }

        // Redirect based on actual user role
        switch ($authuserRole) {
            case 0:
                return redirect()->route('admin');
            case 1:
                return redirect()->route('vendor');
            case 2:
                return redirect()->route('dashboard');
            default:
                return redirect()->route('login');
        }
    }
}
