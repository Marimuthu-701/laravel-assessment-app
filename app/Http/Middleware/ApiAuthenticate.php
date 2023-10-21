<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthenticate extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $header_api_key = $request->header('x-api-key');
        $api_key = env('API_SECRET_KEY', '5e54a8a6-upex-8335-ue6l-c25446a60794');

        if ($header_api_key != $api_key) {
            return $this->sendResponse([], 'forbidden', 403);
        }

        return $next($request);
    }
}
