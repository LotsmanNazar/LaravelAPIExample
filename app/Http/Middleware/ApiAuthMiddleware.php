<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ApiKeyService;

class ApiAuthMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		$token = $request->bearerToken() ?? '';
		if ( !ApiKeyService::check($token) ) {
			return response()->json([
				'error' => true,
				'message' => 'Unauthorized.'
			], 401);
		}

		return $next($request);
	}
}