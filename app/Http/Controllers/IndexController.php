<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * 后台首页
     * @return mixed
     */
    public function index(){

        $data=DB::table("T_U_USER")->count();
        $datas=DB::table("T_U_EXPERT")->count();
        $datad=DB::table("T_U_ENTERPRISE")->count();

        $dataed=DB::table("T_U_USER")
            ->leftJoin("T_U_EXPERT","T_U_USER.USERID","=","T_U_EXPERT.USERID")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.USERID","=","T_U_ENTERPRISE.USERID")
            ->whereRaw('T_U_EXPERT.USERID in (select T_U_USER.USERID from T_U_USER)')
            ->whereRaw('T_U_ENTERPRISE.USERID in (select T_U_USER.USERID from T_U_USER)')
            ->count();

        return view("index.index",compact('data','datas','datad'));
    }

    public function registerData()
    {
        $array=array();

        $result=DB::table("T_U_USER")
            ->leftJoin("T_U_EXPERT","T_U_USER.USERID","=","T_U_EXPERT.USERID")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.USERID","=","T_U_ENTERPRISE.USERID")
            ->whereRaw('T_U_EXPERT.USERID in (select T_U_USER.USERID from T_U_USER)')
            ->whereRaw('T_U_ENTERPRISE.USERID in (select T_U_USER.USERID from T_U_USER)')
            ->count();
        //返回json
    /*    header("Content-Type:application/json");
         echo json_encode($result);*/

        if($result){
            $array['code']="success";
            return $array;
        }else{
            $array['code']="error";
            return $array;
        }
        //$this->ajaxReturn($result,'JSON');
    }

    public function rechargeData()
    {

    }
    
}
