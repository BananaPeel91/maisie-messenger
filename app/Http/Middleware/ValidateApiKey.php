<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-Key');
        $validApiKey = config('services.api.key');

        if (empty($validApiKey)) {
            return response()->json([
                'success' => false,
                'message' => 'API key not configured on server',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (empty($apiKey) || !hash_equals($validApiKey, $apiKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or missing API key',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}

