<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class isStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->session()->get('id')){

            $id = $request->session()->get('id');

            $user = User::where('id', $id)->first();

            if($user->rol == 'admin'){
                return back();
            }else if ($user->rol == 'company'){
                return back();
            }else if ($user->rol == 'student'){
                return $next($request);
            }
        }else{
            return redirect('/');
        }
    }
}
