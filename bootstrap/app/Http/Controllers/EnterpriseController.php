<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;

class EnterpriseController extends Controller{
    /**
     * 专家审核首页
     * @param int $status
     * @return mixed
     */
    public function index($status=0){
        if($status==0){
            $datas=DB::table("T_U_USER")
                ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
                 ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
                ->select("T_U_USER.phone","T_U_USER.created_at","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid")
                ->whereIn("configid",[1,3])
                ->orderBy("T_U_ENTERPRISE.created_at","desc")
                ->paginate(2);
            }else{
            $datas=DB::table("T_U_USER")
                ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
                ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
                ->select("T_U_USER.phone","T_U_USER.created_at","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid")
                ->where("configid",$status)
                ->orderBy("T_U_ENTERPRISE.created_at","desc")
                ->paginate(2);
          }

        return view("enterprise.index",compact("datas","status"));
    }

    /**详情
     * @param $enterpriseId
     * @return mixed
     */
    public  function update($enterpriseId){
        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
            ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid")
            ->where("T_U_ENTERPRISE.enterpriseid",$enterpriseId)
            ->orderBy("T_U_ENTERPRISE.created_at","desc")
            ->get();
        return view("enterprise.update",compact("datas"));
    }

    public  function changeEnterprise(){
        $array=array();
        $result=DB::table("T_U_ENTERPRISEVERIFY")
                    ->where("enterpriseid",$_POST['enterpriseId'])
                    ->update([
                        "configid"=>$_POST['configid'],
                        "remark"=>isset($_POST['remark'])?$_POST['remark']:"",
                        "verifytime"=>date("Y-m-d H:i:s",time()),
                        "updated_at"=>date("Y-m-d H:i:s",time())
                    ]);
        if($result){
           $array['code']="success";
            return $array;
        }else{
           $array['code']="error";
            return $array;
        }
    }



}
