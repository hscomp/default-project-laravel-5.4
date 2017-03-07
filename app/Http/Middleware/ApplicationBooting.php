<?php

namespace App\Http\Middleware;

use App\Utilities\FlashMessenger;
use Closure;

class ApplicationBooting
{
    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        app()->make(FlashMessenger::class)->handle();

        return $next($request);
    }

}