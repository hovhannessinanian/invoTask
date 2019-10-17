<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $content = json_decode($response->getContent(), true) ?? [];
        $updatedContent = [];
        $updatedContent['status'] = $response->exception
            ? 'fail' : 'success';
        if ($response->exception instanceof ModelNotFoundException) {
            $updatedContent['message'] = 'No query results found';
        }
        $updatedContent += $content;
        $response->setData($updatedContent);
        return $response;
    }

}
