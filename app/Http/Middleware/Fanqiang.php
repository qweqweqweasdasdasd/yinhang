<?php

namespace App\Http\Middleware;

use Route;
use Closure;
use App\Manager;

class Fanqiang
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
        $mg_id = \Auth::guard('back')->user()->mg_id;
        $ps_ca = Manager::find($mg_id)->role->ps_ca;
        //当前的权限
        $nowCA = strtolower(getCurrentControllerName().'-'.getCurrentMethodName());
       
        //dump($nowCA);
        //dump($ps_ca);
        if(strpos($ps_ca,$nowCA) === false){
            //return redirect('/error');
            exit('没有此项权限!');
        }
        return $next($request);
    }
}
