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
        $ids=array();
        $enterpriseids=array();
        $results=DB::table("T_U_ENTERPRISEVERIFY")->select("id","enterpriseid")->orderBy("verifytime","desc")->distinct()->get();
        foreach ($results as $result){
            if(!in_array($result->enterpriseid,$enterpriseids)){
                $enterpriseids[]=$result->enterpriseid;
                $ids[]=$result->id;
            }
        }
        if($status==0){
        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
            ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid")
            ->whereIn("configid",[1,2,3])
            ->whereIn("T_U_ENTERPRISEVERIFY.id",$ids)
            ->orderBy("T_U_ENTERPRISE.created_at","desc")
            ->distinct()
            ->paginate(2);
        }else{
        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
            ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid")
            ->where("configid",$status)
            ->whereIn("T_U_ENTERPRISEVERIFY.id",$ids)
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
        $id=DB::table("T_U_ENTERPRISEVERIFY")->where("enterpriseid",$enterpriseId)->orderBy("verifytime","desc")->take(1)->pluck("id");
        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
            ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid")
            ->where("T_U_ENTERPRISE.enterpriseid",$enterpriseId)
            ->where("T_U_ENTERPRISEVERIFY.id",$id)
            ->orderBy("T_U_ENTERPRISE.created_at","desc")
            ->get();
        return view("enterprise.update",compact("datas"));
    }

    /**
     * 企业审核状态
     * @return array
     */
    public  function changeEnterprise(){
        $array=array();
        $result=DB::table("T_U_ENTERPRISEVERIFY")->insert([
                        "configid"=>$_POST['configid'],
                        "enterpriseid"=>$_POST['enterpriseId'],
                        "remark"=>isset($_POST['remark'])?$_POST['remark']:"",
                        "verifytime"=>date("Y-m-d H:i:s",time()),
                        "created_at"=>date("Y-m-d H:i:s",time()),
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

    /**
     * 企业信息维护
     * @return mixed
     */
    public  function serveIndex(){
        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
            ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid")
            ->where("configid",4)
            ->orderBy("T_U_ENTERPRISE.created_at","desc")
            ->paginate(2);
        $counts=DB::table("T_U_USER")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
            ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
            ->where("configid",4)
            ->count();
        return view("enterprise.serve",compact("datas","counts"));
    }
    /**
     * 企业信息详情
     * @return mixed
     */
    public  function servedetail(){
        return view("enterprise.detail");
    }


}
