<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    /**视频审核
     * @return mixed
     */
    public function index(){

        $ids=array();
        $consultids=array();
        $results=DB::table("T_C_CONSULTVERIFY")->select("id","consultid")->orderBy("verifytime","desc")->distinct()->get();
        foreach ($results as $result){
            if(!in_array($result->consultid,$consultids)){
                $consultids[]=$result->consultid;
                $ids[]=$result->id;
            }
        }

        $status=empty($_GET['status'])?'all' : $_GET['status'];
        $datas = DB::table('t_c_consult')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_c_consult.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_c_consultverify','t_c_consultverify.consultid' ,'=' ,'t_c_consult.consultid')
            ->leftJoin('t_u_user','t_c_consult.userid' ,'=' ,'t_u_user.userid')
            ->select('t_c_consult.*','view_userrole.role','t_u_enterprise.enterprisename','t_u_expert.expertname','t_u_user.phone','t_c_consultverify.verifytime','t_c_consultverify.configid')
            ->orderBy('t_c_consultverify.verifytime','desc');

        switch ($status) {
            case 'all':
                $datas = $datas->whereIn("configid",[1,3])->whereIn("T_C_CONSULTVERIFY.id",$ids)->distinct()->paginate(2);
                return view("video.index",compact("datas"));
                break;
            case 'wait':
                $datas = $datas->whereIn("configid",[1])->whereIn("T_C_CONSULTVERIFY.id",$ids)->distinct()->paginate(2);
                return view("video.index",compact("datas"));
                break;
            case 'fail':
                $datas = $datas->whereIn("configid",[3])->whereIn("T_C_CONSULTVERIFY.id",$ids)->distinct()->paginate(2);
                return view("video.index",compact("datas"));
                break;
            case 'pendingPush':
                $datas = $datas->whereIn("configid",[2])->whereIn("T_C_CONSULTVERIFY.id",$ids)->distinct()->paginate(2);
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
   
}
