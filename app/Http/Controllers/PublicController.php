<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function getRemark(){
        $type=$_POST['type'];
        $id=$_POST['id'];
        switch($type){
            case "enterprise":
                $remark=DB::table("T_U_ENTERPRISEVERIFY")->where("enterpriseid",$id)->orderBy("id","desc")->take(1)->pluck('remark');
            break;
            case "expert":
                $remark=DB::table("T_U_EXPERTVERIFY")->where("expertid",$id)->orderBy("id","desc")->take(1)->pluck('remark');
            break;
            case "video":
                $remark=DB::table("T_C_CONSULTVERIFY")->where("consultid",$id)->orderBy("id","desc")->take(1)->pluck('remark');
            break;
            case "supply":
                $remark=DB::table("T_N_NEEDVERIFY")->where("needid",$id)->orderBy("id","desc")->take(1)->pluck('remark');
            break;
            case "work":
                $remark=DB::table("T_E_EVENTTVERIFY")->where("eventid",$id)->orderBy("id","desc")->take(1)->pluck('remark');
            break;
            case "recharge":
                $remark=DB::table("T_U_BILL")->where("id",$id)->pluck('remark');
            break;
        }
        return $remark ;
    }
}
