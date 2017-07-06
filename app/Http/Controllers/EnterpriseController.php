<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EnterpriseController extends Controller
{

    public function index(){
        $condition=isset($_Get['condition'])?$_Get['condition']:"";
        if(empty($condition) || $condition=="全部"){
            $datas=DB::table("T_U_USER")
                ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
                 ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
                ->select("T_U_USER.phone","T_U_USER.created_at","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid")
                ->whereIn("configid",[1,3])
                ->orderBy("T_U_ENTERPRISE.created_at","desc")
                ->paginate(2);
            }else{
              
          }

        return view("enterprise.index",compact("datas"));
    }


}
