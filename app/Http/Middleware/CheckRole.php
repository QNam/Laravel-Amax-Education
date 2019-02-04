<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $admin_role_code = 1;
    private $mod_role_code = 2;
    public function handle($request, Closure $next)
    {
        $checker = Auth::user()['role'] == $this->admin_role_code;
        
        if (!$checker) 
            return redirect()->route('index');
        return $next($request);    
    }

}
