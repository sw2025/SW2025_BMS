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
                $datas = $datas->whereIn("configid",[1,2,3])->paginate(2);
                return view("video.index",compact("datas"));
                break;
            case 'wait':
                $datas = $datas->whereIn("configid",[1])->paginate(2);
                return view("video.index",compact("datas"));
                break;
            case 'fail':
                $datas = $datas->whereIn("configid",[3])->paginate(2);
                return view("video.index",compact("datas"));
                break;
            case 'pendingPush':
                $datas = $datas->whereIn("configid",[2])->paginate(2);
                return view("video.index",compact("datas"));
                break;
        }
       //return view("video.index");
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
        //dd($datas);

        return view("video.update",compact("datas"));
    }

    /**视频审核
     * @return
     */
    public  function changeVideo(){
        $array=array();
        $result=DB::table("T_C_CONSULTVERIFY")
            ->where("consultid",$_POST['consultid'])
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
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:null;
        $location=( isset($_GET['location'])&&$_GET['location']!="全国")?$_GET['location']:null;
        $sizeType=(isset($_GET['sizeType'])&&$_GET['sizeType']!="down")?"desc":"asc";
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?"desc":"asc";

        $idCard=(isset($_GET['idCard'])&&$_GET['idCard']!="null")?$_GET['idCard']:null;

        if(!empty($idCard)){
            $number=['全部'=>range(1,9),'已完成'=>[7,8],'正在办事'=>[2,4,5,6]];
            $idCard=!empty($idCard)? $number[$idCard]:null;
            //dd($idCard);
        }else{
            $idCard=range(1,9);
        }

        //dd($idCard);

        $sizeWhere=!empty($size)?array("size"=>$size):array();
        $jobWhere=!empty($job)?array("industry"=>$job):array();
        $locationWhere=!empty($location)?array("t_u_enterprise.address"=>$location):array();
        $data=DB::table('t_c_consult')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_c_consult.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_c_consultverify','t_c_consultverify.consultid' ,'=' ,'t_c_consult.consultid')
            ->leftJoin('t_u_user','t_c_consult.userid' ,'=' ,'t_u_user.userid')
            ->select('t_c_consult.*','view_userrole.role','t_u_enterprise.enterprisename','t_u_enterprise.enterpriseid','t_u_expert.expertname','t_u_user.phone','t_c_consultverify.verifytime','t_c_consultverify.configid')
            ->whereRaw('t_c_consultverify.id in (select max(id) from t_c_consultverify group by consultid)')
            ->whereIn("t_c_consultverify.configid",$idCard);

        $count=clone $data;

        if(!empty($serveName)){
            if(!empty($idCard)){
                $datas=$data->where("t_c_consult.brief","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->orderBy("size",$sizeType)->orderBy("t_c_consultverify.created_at",$regTime)->paginate(1);
                $counts=$data->where("t_c_consult.brief","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->count();
            }else{
                $datas=$data->where("t_c_consult.brief","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->orderBy("size",$sizeType)->orderBy("t_c_consultverify.created_at",$sizeType)->paginate(1);
                $counts=$data->where("t_c_consult.brief","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->count();
            }
        }else{
            if(!empty($idCard)){
                //dd($idCard);
                $datas=$data->where($sizeWhere)->where($jobWhere)->where($locationWhere)->orderBy("size",$sizeType)->orderBy("t_c_consultverify.created_at",$regTime)->paginate(1);
                $counts=$data->where($sizeWhere)->where($jobWhere)->where($locationWhere)->count();
            }else{
               // dd($locationWhere);
                $datas=$data->where($sizeWhere)->where($jobWhere)->where($locationWhere)->orderBy("size",$sizeType)->orderBy("t_c_consultverify.created_at",$regTime) ->paginate(1);
                $counts= $count->where($sizeWhere)->where($jobWhere)->where($locationWhere)->count();

            }
        }
        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:"null";
        $sizeType=(isset($_GET['sizeType'])&&$_GET['sizeType']!="down")?$_GET['sizeType']:"down";
        $size=(isset($_GET['size'])&&$_GET['size']!="null")?$_GET['size']:"null";
        $idCard=(isset($_GET['idCard'])&&$_GET['idCard']!="null")?$_GET['idCard']:"null";
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?$_GET['regTime']:"down";
        $location=(isset($_GET['location'])&&$_GET['location']!="null")?$_GET['location']:"全国";
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:"null";


        return view("video.serve",compact("datas","counts","serveName","sizeType","size","idCard","regTime","location","job"));
    }
    /**
     * 视频咨询信息维护详情
     * @return mixed
     */
    public function serveDetail($consultid){

        $datas=DB::table('t_c_consult')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_c_consult.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_c_consultverify','t_c_consultverify.consultid' ,'=' ,'t_c_consult.consultid')
            ->leftJoin('t_u_user','t_c_consult.userid' ,'=' ,'t_u_user.userid')
            ->select('t_c_consult.*','view_userrole.role','t_u_enterprise.enterprisename','t_u_enterprise.enterpriseid','t_u_expert.expertname','t_u_user.phone','t_c_consultverify.verifytime','t_c_consultverify.configid')
            ->where("T_C_CONSULT.consultid",$consultid)
            ->orderBy('t_c_consultverify.verifytime','desc')
            ->first();
        return view("video.detail",compact('datas'));
    }
}
