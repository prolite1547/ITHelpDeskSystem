<?php

namespace App\Http\Middleware;

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
    public function handle($request, Closure $next)
    {
        if($request->user()->position->department->id === 60666){
            if($request->is('/admin')){
                if($request->user()->role === 4){
                    return $next($request);
                }else {
                    return back();
                }
            }else {
                return $next($request);
            }
        }
        return back();
    }
}
