<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $urlId = $request->route('id');
        if ($urlId && session('user_id') != $urlId) {
            return abort(403, 'Unauthorized action. You cannot access another user\'s data.');
        }
        $pathRole = $request->segment(1); 
        $userRole = session('role');

        $protectedRoles = ['researcher', 'lab_manager', 'financial_department', 'admin', 'pi', 'supervisor'];

        if (in_array($pathRole, $protectedRoles)) {
            if ($userRole !== $pathRole) {
                abort(403, 'Unauthorized role access. You are a ' . $userRole . ' trying to access ' . $pathRole . ' pages.');
            }
        }
        return $next($request);
    }
}
