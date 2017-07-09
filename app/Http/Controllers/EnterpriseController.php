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
    public function index(){
        $ids=array();
        $enterpriseids=array();
        $results=DB::table("T_U_ENTERPRISEVERIFY")->select("id","enterpriseid")->orderBy("verifytime","desc")->distinct()->get();
        foreach ($results as $result){
            if(!in_array($result->enterpriseid,$enterpriseids)){
                $enterpriseids[]=$result->enterpriseid;
                $ids[]=$result->id;
            }
        }
        $status=!empty($_GET['status'])?$_GET['status']:0;
        if($status==0){
        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
            ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid")
            ->whereIn("configid",[1,2,3])
            ->whereIn("T_U_ENTERPRISEVERIFY.id",$ids)
            ->orderBy("T_U_ENTERPRISE.created_at","desc")
            ->distinct()
            ->paginate(1);
        }else{
        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
            ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid")
            ->where("configid",$status)
            ->whereIn("T_U_ENTERPRISEVERIFY.id",$ids)
            ->orderBy("T_U_ENTERPRISE.created_at","desc")
            ->paginate(1);
        }
        return view("enterprise.index",compact("datas","status"));
    }

    /**详情
     * @param $enterpriseId
     * @return mixed
     */
    public  function update(){
       $enterpriseId=$_GET['id'];
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

        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:null;
        $size=(isset($_GET['size'])&&$_GET['size']!="null")?$_GET['size']:null;
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:null;
        $location=( isset($_GET['location'])&&$_GET['location']!="全国")?$_GET['location']:null;
        $sizeType=(isset($_GET['sizeType'])&&$_GET['sizeType']!="down")?"desc":"asc";
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?"desc":"asc";
        $idCard=(isset($_GET['idCard'])&&$_GET['idCard']!="null")?$_GET['idCard']:null;
        if(!empty($idCard)){
            if($idCard=="普通"){
                $idCard=1;
            }else{
                $idCard=2;
            }
        }
        $sizeWhere=!empty($size)?array("size"=>$size):array();
        $jobWhere=!empty($job)?array("industry"=>$job):array();
        $locationWhere=!empty($location)?array("address"=>$location):array();
        if(!empty($serveName)){
            if(!empty($idCard)){
                $datas=DB::table("T_U_USER")
                    ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
                    ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
                    ->leftJoin("T_U_ENTERPRISEMEMBER","T_U_ENTERPRISEMEMBER.enterpriseid","=","T_U_ENTERPRISE.enterpriseid")
                    ->select("T_U_USER.phone","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid","T_U_ENTERPRISEMEMBER.memberid")
                    ->where("enterprisename","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->where("memberid",$idCard)->orderBy("size",$sizeType)->orderBy("T_U_ENTERPRISE.created_at",$regTime) ->where("configid",4)->paginate(1);
                $counts=DB::table("T_U_USER")
                    ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
                    ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
                    ->leftJoin("T_U_ENTERPRISEMEMBER","T_U_ENTERPRISEMEMBER.enterpriseid","=","T_U_ENTERPRISE.enterpriseid")
                    ->select("T_U_USER.phone","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid","T_U_ENTERPRISEMEMBER.memberid")
                    ->where("enterprisename","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->where("memberid",$idCard)->where("configid",4)->count();
            }else{
                $datas=DB::table("T_U_USER")
                    ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
                    ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
                    ->leftJoin("T_U_ENTERPRISEMEMBER","T_U_ENTERPRISEMEMBER.enterpriseid","=","T_U_ENTERPRISE.enterpriseid")
                    ->select("T_U_USER.phone","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid","T_U_ENTERPRISEMEMBER.memberid")
                    ->where("enterprisename","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->orderBy("size",$sizeType)->orderBy("T_U_ENTERPRISE.created_at",$sizeType) ->where("configid",4)->paginate(1);
                $counts=DB::table("T_U_USER")
                    ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
                    ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
                    ->leftJoin("T_U_ENTERPRISEMEMBER","T_U_ENTERPRISEMEMBER.enterpriseid","=","T_U_ENTERPRISE.enterpriseid")
                    ->select("T_U_USER.phone","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid","T_U_ENTERPRISEMEMBER.memberid")
                    ->where("enterprisename","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere) ->where("configid",4)->count();
            }
        }else{
            if(!empty($idCard)){
                $datas=DB::table("T_U_USER")
                    ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
                    ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
                    ->leftJoin("T_U_ENTERPRISEMEMBER","T_U_ENTERPRISEMEMBER.enterpriseid","=","T_U_ENTERPRISE.enterpriseid")
                    ->select("T_U_USER.phone","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid","T_U_ENTERPRISEMEMBER.memberid")
                    ->where($sizeWhere)->where($jobWhere)->where($locationWhere)->where("memberid",$idCard)->orderBy("size",$sizeType)->orderBy("T_U_ENTERPRISE.created_at",$regTime) ->where("configid",4)->paginate(1);
                $counts=DB::table("T_U_USER")
                    ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
                    ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
                    ->leftJoin("T_U_ENTERPRISEMEMBER","T_U_ENTERPRISEMEMBER.enterpriseid","=","T_U_ENTERPRISE.enterpriseid")
                    ->select("T_U_USER.phone","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid","T_U_ENTERPRISEMEMBER.memberid")
                    ->where($sizeWhere)->where($jobWhere)->where($locationWhere)->where("memberid",$idCard)->where("configid",4)->count();
            }else{
                $datas=DB::table("T_U_USER")
                    ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
                    ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
                    ->leftJoin("T_U_ENTERPRISEMEMBER","T_U_ENTERPRISEMEMBER.enterpriseid","=","T_U_ENTERPRISE.enterpriseid")
                    ->select("T_U_USER.phone","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid","T_U_ENTERPRISEMEMBER.memberid")
                    ->where($sizeWhere)->where($jobWhere)->where($locationWhere)->orderBy("size",$sizeType)->orderBy("T_U_ENTERPRISE.created_at",$regTime) ->where("configid",4)->paginate(1);

                $counts=DB::table("T_U_USER")
                    ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
                    ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
                    ->leftJoin("T_U_ENTERPRISEMEMBER","T_U_ENTERPRISEMEMBER.enterpriseid","=","T_U_ENTERPRISE.enterpriseid")
                    ->select("T_U_USER.phone","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid","T_U_ENTERPRISEMEMBER.memberid")
                    ->where($sizeWhere)->where($jobWhere)->where($locationWhere)->where("configid",4)->count();
            }
        }
        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:"null";
        $sizeType=(isset($_GET['sizeType'])&&$_GET['sizeType']!="down")?$_GET['sizeType']:"down";
        $size=(isset($_GET['size'])&&$_GET['size']!="null")?$_GET['size']:"null";
        $idCard=(isset($_GET['idCard'])&&$_GET['idCard']!="null")?$_GET['idCard']:"null";
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?$_GET['regTime']:"down";
        $location=(isset($_GET['location'])&&$_GET['location']!="null")?$_GET['location']:"全国";
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:"null";
        return view("enterprise.serve",compact("datas","counts","serveName","sizeType","size","idCard","regTime","location","job"));

    }
    /**
     * 企业信息详情
     * @return mixed
     */
    public  function servedetail(){
        $enterpriseId=$_GET['id'];
        $id=DB::table("T_U_ENTERPRISEVERIFY")->where("enterpriseid",$enterpriseId)->orderBy("verifytime","desc")->take(1)->pluck("id");
        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
            ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid")
            ->where("T_U_ENTERPRISE.enterpriseid",$enterpriseId)
            ->where("T_U_ENTERPRISEVERIFY.id",$id)
            ->orderBy("T_U_ENTERPRISE.created_at","desc")
            ->get();
        return view("enterprise.detail",compact("datas"));
    }


}
