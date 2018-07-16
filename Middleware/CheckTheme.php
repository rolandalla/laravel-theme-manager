<?php

namespace App\Http\Middleware;

use Closure;
use Theme;
use Exception;
class CheckTheme
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$theme)
    {
        if (! Theme::exists($theme)) {
            throw new Exception('The theme '.'"'.$theme.'"'.' does not exist.');
        }
        Theme::set($theme);
        return $next($request);
    }
}
