<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use App\Services\Activities\ActivityService;
use Illuminate\Support\Facades\Log;

class CatchActivity
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/admin/*'
    ];

    public function handle(Request $request, Closure $next)
    {

        try {
            if (!$this->inExceptArray($request)) {
                $url = $request->url();
                (new ActivityService())->create($url);
            }
        } catch (\Exception $exception) {
            Log::error('Landing middleware error: ' . $exception->getMessage());
        }

        return $next($request);
    }

    /**
     * Determine if the request has a URI that should pass except
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }
}