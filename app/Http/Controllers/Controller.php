<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function __construct()
    {
        if(session('userId')){
            $roleid = DB::table('t_rbac_userrole')->where('userid',session('userId'))->first()->roleid;
            $data = DB::table('t_rbac_rolepermission')
                ->leftjoin('t_rbac_permission','t_rbac_rolepermission.permissionid','=','t_rbac_permission.permissionid')
                ->where('roleid',$roleid)
                ->select('t_rbac_rolepermission.*','t_rbac_permission.*')
                ->get();
            view()->share('rbacdata',$data);
        }

    }


}
