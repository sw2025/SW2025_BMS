<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ExpertController extends Controller
{
    /**专家审核首页
     * @return mixed
     */
    public function index($status="all"){

        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_EXPERT","T_U_USER.USERID","=","T_U_EXPERT.USERID")
            ->leftJoin("T_U_EXPERTVERIFY","T_U_EXPERT.EXPERTID","=","T_U_EXPERTVERIFY.expertid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_EXPERT.*","T_U_EXPERTVERIFY.configid","T_U_EXPERTVERIFY.VERIFYTIME","T_U_EXPERT.expertid")
            ->orderBy("T_U_EXPERT.created_at","desc")
            ->whereRaw('T_U_EXPERTVERIFY.id in (select max(id) from T_U_EXPERTVERIFY group by expertid)');

        switch ($status) {
            case 'all':
                $datas = $datas->whereIn("configid",[1,3])->paginate(10);
                break;
            case 'wait':
                $datas = $datas->whereIn("configid",[1])->paginate(10);
                break;
            case 'fail':
                $datas = $datas->whereIn("configid",[3])->paginate(10);
                break;
        }
        return view("expert.index",compact("datas",'status'));

    }

    public  function  update(){
        $expertid=$_GET['expertid'];
        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_EXPERT","T_U_USER.USERID","=","T_U_EXPERT.USERID")
            ->leftJoin("T_U_EXPERTVERIFY","T_U_EXPERT.EXPERTID","=","T_U_EXPERTVERIFY.expertid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_EXPERT.*","T_U_EXPERTVERIFY.configid","T_U_EXPERT.expertid")
            ->where("T_U_EXPERT.expertid",$expertid)
            ->whereRaw('T_U_EXPERTVERIFY.id in (select max(id) from T_U_EXPERTVERIFY group by expertid)')
            ->first();
        return view("expert.update",compact("datas"));
    }

    //
    public  function changeExpert(){
        $array=array();
        $res=DB::table("T_U_EXPERT")
            ->leftJoin("T_U_USER","T_U_USER.userid","=","T_U_EXPERT.userid")
            ->leftJoin("T_U_EXPERTVERIFY","T_U_EXPERT.expertid","=","T_U_EXPERTVERIFY.expertid")
            ->where("T_U_EXPERTVERIFY.expertid",$_POST['expertid'])
            ->orderBy("T_U_EXPERTVERIFY.id")
            ->select("T_U_USER.phone","T_U_EXPERTVERIFY.created_at","T_U_USER.userid")
            ->take(1)
            ->get();
        foreach ($res as $value){
            $mobile=$value->phone;
            $time=$value->created_at;
            $receiveId=$value->userid;
        }
        $result=DB::table("T_U_EXPERTVERIFY")
            ->insert([
                "expertid"=>$_POST['expertid'],
                "configid"=>$_POST['configid'],
                "remark"=>isset($_POST['remark'])?$_POST['remark']:"",
                "verifytime"=>date("Y-m-d H:i:s",time()),
                "updated_at"=>date("Y-m-d H:i:s",time())
            ]);
        if($_POST['configid']==2){
            DB::table("T_M_SYSTEMMESSAGE")->insert([
                "sendid"=>0,
                "receiveid"=>$receiveId,
                "title"=>"专家认证成功",
                "content"=>"您提交的专家认证已经通过",
                "state"=>0,
                "sendtime"=>date("Y-m-d H:i:s",time()),
                "created_at"=>date("Y-m-d H:i:s",time()),
                "updated_at"=>date("Y-m-d H:i:s",time()),
            ]);
            $this->_sendSms($mobile,$time,"expertSuccess");
        }else{
            DB::table("T_M_SYSTEMMESSAGE")->insert([
                "sendid"=>0,
                "receiveid"=>$receiveId,
                "title"=>"专家认证失败",
                "content"=>"您提交的专家认证未通过,请重新提交",
                "state"=>0,
                "sendtime"=>date("Y-m-d H:i:s",time()),
                "created_at"=>date("Y-m-d H:i:s",time()),
                "updated_at"=>date("Y-m-d H:i:s",time()),
            ]);
            $this->_sendSms($mobile,$time,"expertFail");
        }
        if($result){
            $array['code']="success";
            return $array;
        }else{
            $array['code']="error";
            return $array;
        }

    }

    /**专家信息维护首页
     * @return mixed
     */
    public  function serveIndex(){

        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:null;
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?explode('-',$_GET['job']):null;
        $location=( isset($_GET['location'])&&$_GET['location']!="全国")?$_GET['location']:null;
        $idCard=(isset($_GET['idCard'])&&$_GET['idCard']!="null")?$_GET['idCard']:null;
        if(!empty($idCard)){
            $number=['首页'=>[1],'非首页'=>[0]];
            $idCard=!empty($idCard)? $number[$idCard]:null;
        }else{
            $idCard=range(0,1);
        }
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?"desc":"asc";

        if(!empty($job) && count($job) == 1 ){
            $jobWhere= array("t_u_expert.domain1" => $job[0]);
        } else {
            $jobWhere=!empty($job)?array("t_u_expert.domain1" => $job[0]):array();
            $domain2 = $job[1];
        }
        $domain2=(isset($domain2))?$domain2:null;

        $locationWhere=!empty($location)?array("address"=>$location):array();
        $data=DB::table("T_U_USER")
            ->leftJoin("T_U_EXPERT","T_U_USER.USERID","=","T_U_EXPERT.USERID")
            ->leftJoin("T_U_EXPERTVERIFY","T_U_EXPERT.EXPERTID","=","T_U_EXPERTVERIFY.expertid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_EXPERT.*","T_U_EXPERTVERIFY.configid","T_U_EXPERTVERIFY.VERIFYTIME","T_U_EXPERT.expertid")
            ->whereRaw('T_U_EXPERTVERIFY.id in (select max(id) from T_U_EXPERTVERIFY group by  T_U_EXPERTVERIFY.expertid)')
            ->where("t_u_expertverify.configid",2)
            ->whereIn("T_U_EXPERT.isfirst",$idCard);
       $count=clone $data;

     if(!empty($serveName)){
         $datas=$data->where("expertname","like","%".$serveName."%")->where("domain2","like","%".$domain2."%")->where($jobWhere)->where($locationWhere)->paginate(10);
         $counts=$count->where("expertname","like","%".$serveName."%")->where("domain2","like","%".$domain2."%")->where($jobWhere)->where($locationWhere)->count();
       }else{
         $datas=$data->where("domain2","like","%".$domain2."%")->where($jobWhere)->where($locationWhere)->orderBy("T_U_expert.created_at",$regTime) ->paginate(10);
         $counts= $count->where("domain2","like","%".$domain2."%")->where($jobWhere)->where($locationWhere)->count();
       }

        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:"null";
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?$_GET['regTime']:"down";
        $location=(isset($_GET['location'])&&$_GET['location']!="null")?$_GET['location']:"全国";
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:"null";

        $idCard=(isset($_GET['idCard'])&&$_GET['idCard']!="null")?$_GET['idCard']:"null";
        $label = DB::table('t_common_domaintype')->get();
        return view("expert.serve",compact("datas","counts","serveName","sizeType","regTime","location","job","label","idCard"));

    }

    /**专家信息维护详情
     * @return mixed
     */
    public  function serveDetail($expertid){
        $data=DB::table("T_U_USER")
            ->leftJoin("T_U_EXPERT","T_U_USER.USERID","=","T_U_EXPERT.USERID")
            ->leftJoin("T_U_EXPERTVERIFY","T_U_EXPERT.EXPERTID","=","T_U_EXPERTVERIFY.expertid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_EXPERT.*","T_U_EXPERTVERIFY.configid","T_U_EXPERTVERIFY.VERIFYTIME","T_U_EXPERT.expertid")
            ->whereRaw('T_U_EXPERTVERIFY.id in (select max(id) from T_U_EXPERTVERIFY group by  T_U_EXPERTVERIFY.expertid)')
            ->where("t_u_expert.expertid",$expertid)
            ->first();
        return view("expert.detail",compact('data'));
    }

    /**专家信息维护设置首页
     * @return mixed
     */
    public  function changeHomePage(){
        $array=array();
        $result=DB::table("T_U_EXPERT")
            ->where("expertid",$_POST['expertid'])
            ->update([
                "isfirst"=> $_POST['isfirst']
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
