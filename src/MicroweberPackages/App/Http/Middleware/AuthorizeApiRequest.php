<?php

namespace MicroweberPackages\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthorizeApiRequest
{
    /**
     * Authorize userToken and UserPassToken fron an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {

//        if ($request->header('Content-Type') != 'application/json') {
//             if ($request->expectsJson()) {
//                return response()->json(['error' => 'Only JSON requests are allowed'], 406);
//             }
//             return abort(403, 'Api unauthorized');
//        }

        if (($request->header('userToken') == Config('microweber.userToken')) && ($request->header('userPassToken') == Config('microweber.userPassToken'))) {
            return $next($request);
        }
        else{
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Api unauthorized, Wrong userToken or userPassToken.'], 401);
            }
            return abort(403, 'Api unauthorized');
        }

    }

}
