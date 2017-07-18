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
                $datas = $datas->whereIn("configid",[1,3])->paginate(2);
                break;
            case 'wait':
                $datas = $datas->whereIn("configid",[1])->paginate(2);
                break;
            case 'fail':
                $datas = $datas->whereIn("configid",[3])->paginate(2);
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
        //dd($datas);
        return view("expert.update",compact("datas"));
    }

    //
    public  function changeExpert(){
        $array=array();
        $result=DB::table("T_U_EXPERTVERIFY")
            ->insert([
                "expertid"=>$_POST['expertid'],
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
  
    /**专家信息维护首页
     * @return mixed
     */
    public  function serveIndex(){

        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:null;
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:null;
        $location=( isset($_GET['location'])&&$_GET['location']!="全国")?$_GET['location']:null;
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?"desc":"asc";
        if(!empty($job) && count($job) == 1 ){
            $jobWhere= array("t_u_expert.domain1" => $job[0]);
        } else {
            $jobWhere=!empty($job)?array("t_u_expert.domain1" => $job[0],'t_u_expert.domain2' => $job[1]):array();
        }
        $locationWhere=!empty($location)?array("address"=>$location):array();
        $data=DB::table("T_U_USER")
            ->leftJoin("T_U_EXPERT","T_U_USER.USERID","=","T_U_EXPERT.USERID")
            ->leftJoin("T_U_EXPERTVERIFY","T_U_EXPERT.EXPERTID","=","T_U_EXPERTVERIFY.expertid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_EXPERT.*","T_U_EXPERTVERIFY.configid","T_U_EXPERTVERIFY.VERIFYTIME","T_U_EXPERT.expertid")
            ->whereRaw('T_U_EXPERTVERIFY.id in (select max(id) from T_U_EXPERTVERIFY group by  T_U_EXPERTVERIFY.expertid)')
            ->where("t_u_expertverify.configid",2);
       $count=clone $data;

     if(!empty($serveName)){
         $datas=$data->where("expertname","like","%".$serveName."%")->where($jobWhere)->where($locationWhere)->paginate(1);
         $counts=$count->where("expertname","like","%".$serveName."%")->where($jobWhere)->where($locationWhere)->count();

       }else{
         $datas=$data->where($jobWhere)->where($locationWhere)->orderBy("T_U_expert.created_at",$regTime) ->paginate(1);
         $counts= $count->where($jobWhere)->where($locationWhere)->count();
       }

        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:"null";
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?$_GET['regTime']:"down";
        $location=(isset($_GET['location'])&&$_GET['location']!="null")?$_GET['location']:"全国";
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:"null";
        $label = DB::table('t_common_domaintype')->get();
        return view("expert.serve",compact("datas","counts","serveName","sizeType","regTime","location","job","label"));

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
