<?php

namespace App\Http\Middleware;

use Closure;
use App\JsonApi\MicroJsonApi;

class JsonApiMiddleware
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
        $microJsonApi = new MicroJsonApi();
        $responseStatus = $microJsonApi->checkHeaders($request);
        if ($responseStatus != 200) {
            return response()->json($microJsonApi->formatResponse('','','',$microJsonApi->getErrors()), $responseStatus);
        }
        return $next($request);
    }
}
