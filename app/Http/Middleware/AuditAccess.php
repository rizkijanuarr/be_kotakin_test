<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditAccess
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (auth()->check()) {
            try {
                Audit::create([
                    'user_type'       => get_class(auth()->user()),
                    'user_id'         => auth()->id(),
                    'event'           => 'accessed',
                    'auditable_type'  => null,
                    'auditable_id'    => null,
                    'old_values'      => [],
                    'new_values'      => [],
                    'url'             => $request->fullUrl(),
                    'ip_address'      => $request->ip(),
                    'user_agent'      => $request->userAgent(),
                    'tags'            => 'access',
                ]);
            } catch (\Throwable $e) {
                // silent fail to not break user request
            }
        }

        return $response;
    }
}
