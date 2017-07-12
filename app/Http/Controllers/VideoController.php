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
        $ids=array();
        $consultids=array();
        $results=DB::table("T_C_CONSULTVERIFY")->select("id","consultid")->orderBy("verifytime","desc")->distinct()->get();
        foreach ($results as $result){
            if(!in_array($result->consultid,$consultids)){
                $consultids[]=$result->consultid;
                $ids[]=$result->id;
            }
        }

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
                $datas = $datas->whereIn("configid",[1,2,3])->whereIn("T_C_CONSULTVERIFY.id",$ids)->distinct()->paginate(2);
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
        $ids=array();
        $consultids=array();
        $results=DB::table("T_C_CONSULTVERIFY")->select("id","consultid")->orderBy("verifytime","desc")->distinct()->get();
        //dd($results);
        foreach ($results as $result){
            if(!in_array($result->consultid,$consultids)){
                $consultids[]=$result->consultid;
                $ids[]=$result->id;
            }
        }

        $datas=DB::table('t_c_consult')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_c_consult.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_c_consultverify','t_c_consultverify.consultid' ,'=' ,'t_c_consult.consultid')
            ->leftJoin('t_u_user','t_c_consult.userid' ,'=' ,'t_u_user.userid')
            ->select('t_c_consult.*','view_userrole.role','t_u_enterprise.enterprisename','t_u_expert.expertname','t_u_user.phone','t_c_consultverify.verifytime','t_c_consultverify.configid');

        if($request->isMethod('post')){
            $wheres = $request->input();
            $arrwhere = unserialize($wheres['where']);
            $pagenum = !empty($request->input('page')) ? $request->input('page') : 1;
            $sql = [];
            switch($wheres['key']){
                case 'publishing':
                    $arrwhere['t_c_consultverify.configid'] = "'".$wheres['value']."'";
                    break;
                case 'unpublishing':
                    unset($arrwhere['t_c_consultverify.configid']);
                    break;
                case 'domain':
                    $arrwhere['t_c_consult.domain1'] = "'".$wheres['value']."'";
                    break;
                case 'undomain':
                    unset($arrwhere['t_c_consult.domain1']);
                    break;
                case 'address':
                    $arrwhere['t_u_enterprise.address'] = "'".$wheres['value']."'";
                    break;
                case 'unaddress':
                    unset($arrwhere['t_u_enterprise.address']);
                    break;
                case 'ordertime':
                    $order = $wheres['value'];
                    break;
                case 'search':
                    $arrwhere['t_c_consult.brief'] = '"%'. $wheres['value'] .'%"';
                    break;
                case 'unsearch':
                    unset($arrwhere['t_c_consult.brief']);
                    break;
            }
            foreach($arrwhere as $k => $v){
                $sql[] = $k != 't_c_consult.brief' ? $k . '=' . $v : $k . ' like ' . $v;
            }
            $where = implode(' and ',$sql);
            if(!empty($order)){
                $datas->whereIn("T_C_CONSULTVERIFY.id",$ids)->distinct()->orderBy('t_c_consult.consulttime',$order);

            } else {
                $datas->whereIn("T_C_CONSULTVERIFY.id",$ids)->distinct()->orderBy('t_c_consult.consulttime','desc');
            }

            $datas = $datas->whereRaw($where)
                ->paginate(3)->toJson();
            /*dd($datas);
            $datas = $datas->forPage($pagenum,5);*/
            return ['where' => serialize($arrwhere) ,'data' => $datas];
        }
        $datas = $datas->whereIn("T_C_CONSULTVERIFY.id",$ids)->distinct()->orderBy('t_c_consult.consulttime','desc')
            ->paginate(1);
        return view("video.serve",compact('datas'));
    }
    /**
     * 视频咨询信息维护详情
     * @return mixed
     */
    public function serveDetail(){
        return view("video.detail");
    }
}
