<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Client
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->type == 3) {
            if($request->user()->onTrial()){
                return $next($request);
            }elseif($request->user()->subscription('default') && $request->user()->subscription('default')->active()){
                return $next($request);
            }else{
                return redirect()->route('subscription.create');
            }
        }

        return redirect()->route('login')->with('error', "You don't have the rights.");
    }
}
