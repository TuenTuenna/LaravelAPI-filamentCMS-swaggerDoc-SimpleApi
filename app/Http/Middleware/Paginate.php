<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Paginate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $data = $response->getData(true);

        if (isset($data['links'])) {
            unset($data['links']); // links 는 빼주세요
        }

        if (isset($data['meta'], $data['meta']['links'], $data['meta']['path'])) {
            unset($data['meta']['links']); // meta안에 links 는 빼주세요
            unset($data['meta']['path']); // meta안에 path 는 빼주세요
        }

        $response->setData($data);

        return $response;
    }
}
