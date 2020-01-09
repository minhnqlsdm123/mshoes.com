<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
class AdminAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        return route('admin.showLoginForm');
    }
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = ['admin'];

        // $this->authenticate($request,$guards);
        // return $next($request);
         if (!\Auth::guard('admin')->check()) {
            return redirect()->route('admin.showLoginForm');
        }
        return $next($request);
    }
}