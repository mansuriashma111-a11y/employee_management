<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session('role') !== 'employee') {
            return redirect('/login')->with('error', 'You are not authorized.');
        }

        return $next($request);
    }
}