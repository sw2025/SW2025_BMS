<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class VideoController extends Controller
{
    /**视频审核
     * @return mixed
     */
    public function index($status='all'){
        $datas = DB::table('t_c_consult')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_c_consult.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_c_consultverify','t_c_consultverify.consultid' ,'=' ,'t_c_consult.consultid')
            ->leftJoin('t_u_user','t_c_consult.userid' ,'=' ,'t_u_user.userid')
            ->select('t_c_consult.*','view_userrole.role','t_u_enterprise.enterprisename','t_u_expert.expertname','t_u_user.phone','t_c_consultverify.verifytime','t_c_consultverify.configid')
            ->orderBy('t_c_consultverify.verifytime','desc')
            ->whereRaw('t_c_consultverify.id in (select max(id) from t_c_consultverify group by consultid)');
        switch ($status) {
            case 'all':
                $datas = $datas->whereIn("configid",[1,2,3])->paginate(10);
                break;
            case 'wait':
                $datas = $datas->whereIn("configid",[1])->paginate(10);
                break;
            case 'fail':
                $datas = $datas->whereIn("configid",[3])->paginate(10);
                break;
            case 'pendingPush':
                $datas = $datas->whereIn("configid",[2])->paginate(10);
                break;
        }
        return view("video.index",compact("datas",'status'));
    }
    /**
     * 视频审核详情
     * @return mixed
     */
    public function update(){
        $consultid=$_GET['consultid'];
        $datas = DB::table('t_c_consult')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_c_consult.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_c_consultverify','t_c_consultverify.consultid' ,'=' ,'t_c_consult.consultid')
            ->leftJoin('t_u_user','t_c_consult.userid' ,'=' ,'t_u_user.userid')
            ->select('t_c_consult.*','view_userrole.role','t_u_enterprise.enterprisename','t_u_expert.expertname','t_u_user.phone','t_c_consultverify.verifytime','t_c_consultverify.configid')
            ->where("T_C_CONSULT.consultid",$consultid)
            ->orderBy('t_c_consultverify.verifytime','desc')
            ->first();

        return view("video.update",compact("datas"));
    }

    /**视频审核
     * @return
     */
    public  function changeVideo(){
        $array=array();
        $result=DB::table("T_C_CONSULTVERIFY")
            ->insert([
                "consultid"=>$_POST['consultid'],
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
    /**视频咨询维护首页
     * @return mixed
     */
    public  function serveIndex(Request $request){

        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:null;
        $size=(isset($_GET['size'])&&$_GET['size']!="null")?$_GET['size']:null;
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?explode('-',$_GET['job']):null;
        $location=( isset($_GET['location'])&&$_GET['location']!="全国")?$_GET['location']:null;
        $sizeType=(isset($_GET['sizeType'])&&$_GET['sizeType']!="down")?"desc":"asc";
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?"desc":"asc";
        $idCard=(isset($_GET['idCard'])&&$_GET['idCard']!="null")?$_GET['idCard']:null;

        //dd($_GET['job']);
        if(!empty($idCard)){
            $number=['全部' => range(4,9),'已完成'=>[7,8],'正在办事'=>[4,5,6]];
            $idCard=!empty($idCard)? $number[$idCard]:null;
        }else{
            $idCard=range(4,9);
        }
        if(!empty($job) && count($job) == 1 ){
            $jobWhere= array("t_c_consult.domain1" => $job[0]);
            $domain2 = array();
        } else {
            $jobWhere=!empty($job)?array("t_c_consult.domain1" => $job[0]):array();
            $domain2 = count($job) == 2?array("t_c_consult.domain2" => $job[1]):array();
        }


        $sizeWhere=!empty($size)?array("size"=>$size):array();
        $locationWhere=!empty($location)?array("t_u_enterprise.address"=>$location):array();

        $data=DB::table('t_c_consult')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_c_consult.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_c_consultverify','t_c_consultverify.consultid' ,'=' ,'t_c_consult.consultid')
            ->leftJoin('t_c_consultverifyconfig','t_c_consultverify.configid' ,'=' ,'t_c_consultverifyconfig.configid')
            //->leftJoin('t_c_consultresponse','t_c_consultresponse.consultid' ,'=' ,'t_c_consult.consultid')
            ->leftJoin('t_u_user','t_c_consult.userid' ,'=' ,'t_u_user.userid')
            ->select('t_c_consult.*','view_userrole.role','t_u_enterprise.enterprisename','t_u_enterprise.enterpriseid','t_u_expert.expertname','t_u_user.phone','t_c_consultverify.verifytime','t_c_consultverify.configid')
            ->whereRaw('t_c_consultverify.id in (select max(id) from t_c_consultverify group by consultid)');

        $obj=$data->whereIn("t_c_consultverify.configid",$idCard);

       //dd($obj);

        $count=clone $obj;
        if(!empty($serveName)){
                $datas=$obj->where("t_c_consult.brief","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->orderBy("size",$sizeType)->orderBy("t_c_consultverify.created_at",$regTime)->paginate(10);
                $counts=$count->where("t_c_consult.brief","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->count();
        }else{
                $datas=$obj->where($sizeWhere)->where($jobWhere)->where($domain2)->where($locationWhere)->orderBy("size",$sizeType)->orderBy("t_c_consult.created_at",$regTime)->paginate(10);
                $counts=$count->where($sizeWhere)->where($jobWhere)->where($domain2)->where($locationWhere)->count();
                //  dd($datas);
        }
        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:"null";
        $sizeType=(isset($_GET['sizeType'])&&$_GET['sizeType']!="down")?$_GET['sizeType']:"down";
        $size=(isset($_GET['size'])&&$_GET['size']!="null")?$_GET['size']:"null";
        $idCard=(isset($_GET['idCard'])&&$_GET['idCard']!="null")?$_GET['idCard']:"null";
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?$_GET['regTime']:"down";
        $location=(isset($_GET['location'])&&$_GET['location']!="null")?$_GET['location']:"全国";
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:"null";
        $label = DB::table('t_common_domaintype')->get();
        return view("video.serve",compact("datas","counts","serveName","sizeType","size","idCard","regTime","location","job","label"));
    }

    static public function getExpertName ($expertid)
    {
        $datas = DB::table('t_u_expert')->where('expertid',$expertid)->first();
        return $datas->expertname;
    }
    /**
     * 视频咨询信息维护详情
     * @return mixed
     */
    public function serveDetail($consultid){

        $datas=DB::table('t_c_consult')
            ->leftJoin('t_c_consultresponse','t_c_consultresponse.consultid' ,'=' ,'t_c_consult.consultid')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_c_consult.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_c_consultverify','t_c_consultverify.consultid' ,'=' ,'t_c_consult.consultid')
            ->leftJoin('t_c_consultverifyconfig','t_c_consultverifyconfig.configid' ,'=' ,'t_c_consultverify.configid')
            ->leftJoin('t_u_user','t_c_consult.userid' ,'=' ,'t_u_user.userid')
            ->select('t_c_consult.*','view_userrole.role','t_u_enterprise.enterprisename','t_u_enterprise.enterpriseid','t_u_user.phone','t_c_consultverify.verifytime','t_c_consultverify.configid','t_c_consultresponse.state','t_c_consultverifyconfig.name')
            ->where("T_C_CONSULT.consultid",$consultid)
            ->whereRaw('t_c_consultverify.id in (select max(id) from t_c_consultverify group by consultid)')
            //->orderBy('t_c_consultresponse.consultid','desc')
            ->first();
        $expertData=DB::table('t_u_expert')
            ->leftJoin('t_c_consultresponse','t_c_consultresponse.expertid' ,'=' ,'t_u_expert.expertid')
            ->leftJoin('t_u_user','t_u_expert.userid' ,'=' ,'t_u_user.userid')
            ->where("t_c_consultresponse.consultid",$consultid)
            ->whereRaw('t_c_consultresponse.id in (select max(id) from t_c_consultresponse group by consultid)')
            ->orderBy('t_c_consultresponse.id','desc')
            ->groupBy('t_c_consultresponse.expertid','t_c_consultresponse.consultid')
            ->get();
        return view("video.detail",compact('datas','expertData'));
    }


    /**
     * 视频咨询信息删除
     * @return mixed
     */

    public function deleteVideo(Request $request)
    {
        $datas = $request->input();
        $result= DB::table("t_c_consultverify")
                ->insert([
                    'consultid' => $datas['consultid'],
                    "configid" => 3,
                    'remark'=>$datas['remark'],
                    'verifytime' => date('Y-m-d H:i:s', time()),
                    "updated_at" => date("Y-m-d H:i:s", time()),
                    "created_at" => date("Y-m-d H:i:s", time())
                ]);

        if($result){
            $array['code']="操作成功";
            return $array;
        }else{
            $array['code']="操作失败";
            return $array;
        }
    }
}
