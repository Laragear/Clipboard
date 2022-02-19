<?php

namespace Laragear\Clipboard\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laragear\Clipboard\Facades\Clipboard;

class ClearClipboard
{
    /**
     * Handle the incoming request.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     *
     * @return void
     */
    public function terminate(): void
    {
        Clipboard::clear();
    }
}