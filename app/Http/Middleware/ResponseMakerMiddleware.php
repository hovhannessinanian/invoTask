<?php

namespace App\Http\Middleware;

use Closure;

class ResponseMakerMiddleware
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
        $response = $next($request);
        $content = json_decode($response->getContent(), true);
        $statusInfo = $response->exception
            ? 'fail' : 'success';
        $response->setData(['status' => $statusInfo] + $content);
        return $response;
    }

}
