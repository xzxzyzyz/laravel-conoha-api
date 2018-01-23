<?php

namespace Xzxzyzyz\ConohaAPI\Http\Middleware;

use Closure;
use Illuminate\Encryption\Encrypter;

class AutoCreateEmailPassword
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
        $password = base64_encode(
            Encrypter::generateKey(config('app.cipher'))
        );

        $request->merge(['password' => $password]);

        return $next($request);
    }
}
