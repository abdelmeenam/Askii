<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class Localization
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

        $default = config('app.locale');
        $accept_Language = $request->header('Accept-Language');
        if ($accept_Language) {
            list($default) = explode(',', $accept_Language);
        }

        //--------------------Session method-------------
                $default=Session::get('lang', $default);
                $lang = $request->query('lang', $default);
                Session::put('lang', $lang);
                App::setLocale($lang);


        //--------------------URL method-------------
//        $lang = $request->route('lang' , $default);
//        App::setLocale($lang);
//        URL::defaults(['lang' => $lang]);
//        Route::current()->forgetParameter('lang');


        return $next($request);
    }
}
