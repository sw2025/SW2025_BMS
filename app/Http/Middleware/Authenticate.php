<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\DB;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;
    static private $publicarr = ['/index','/workData','/supplyData','/registerData','/rechargeData','/videoData','/memberData'];
    /**
     * Create a new middleware instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/');
            }
        }
        return $next($request);*/
        if(empty(session('userId'))){
            return redirect('/');
        }

        $str = session('str');
        $str = \Illuminate\Support\Facades\Crypt::decrypt($str);
        $b = explode('/', $_SERVER['REDIRECT_URL']);

        $b = '/'.$b[1];

        $result = in_array($b,$str);
        $result2 = in_array($b,self::$publicarr);
        if(!$result && !$result2){
            return "<script> alert('你没有权限访问');window.history.back(-1);   </script>";
        }

        return $next($request);

    }

}
