<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class WorkController extends Controller
{
    /**办事审核
     * @return mixed
     */
    public function index($action = 'all'){
        $datas = DB::table('t_e_event')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_e_event.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_e_eventverify','t_e_eventverify.eventid' ,'=' ,'t_e_event.eventid')
            ->leftJoin('t_u_user','t_e_event.userid' ,'=' ,'t_u_user.userid')
            ->select('t_e_event.*','view_userrole.role','t_u_enterprise.enterprisename','t_u_expert.expertname','t_u_user.phone','t_e_eventverify.verifytime','t_e_eventverify.configid')
            ->orderBy('t_e_eventverify.verifytime','desc')
            ->whereRaw('t_e_eventverify.id in (select max(id) from t_e_eventverify group by eventid)');
        switch ($action) {
            case 'all':
                $datas = $datas->whereIn("configid", [1,2,3])->paginate(1);
                break;
            case 'wait':
                $datas = $datas->where("configid", 1)->paginate(1);
                break;
            case 'fail':
                $datas = $datas->where("configid", 3)->paginate(1);
                break;
            case 'wput':
                $datas = $datas->where("configid", 2)->paginate(1);
                break;
        }
        return view("work.index",compact('datas','action'));
    }

    /**
     * 办事审核详情
     * @return mixed
     */
    public function update($event_id){
        $datas = DB::table('t_e_event')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_e_event.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_e_eventverify','t_e_eventverify.eventid' ,'=' ,'t_e_event.eventid')
            ->leftJoin('t_u_user','t_e_event.userid' ,'=' ,'t_u_user.userid')
            ->select('t_u_enterprise.brief as desc1','t_u_expert.brief as desc2','t_e_event.*','view_userrole.role','t_u_enterprise.enterprisename','t_u_expert.expertname','t_u_user.phone','t_e_eventverify.verifytime','t_e_eventverify.configid')
            ->orderBy('t_e_eventverify.verifytime','desc')
            ->where("t_e_event.eventid", $event_id)
            ->first();
        return view("work.update",compact('datas'));
    }

    /**ajax请求处理办事审核
     * @param Request $request
     * @return string
     */
    public function changeEvent(Request $request)
    {
        $datas = $request->input();

        $result=DB::table("t_e_eventverify")
            ->insert([
                'eventid'    => $datas['event_id'],
                "configid"   => $datas['config_id'],
                'verifytime' => date('Y-m-d H:i:s',time()),
                "remark"     => !empty($datas['remark']) ? $datas['remark'] : "",
                "updated_at" => date("Y-m-d H:i:s",time()),
            ]);
        if ($result) {
            return json_encode(['errorMsg' => 'success']);
        } else {
            return json_encode(['errorMsg' => 'error']);
        }
    }

    /**办事信息维护首页
     * @return mixed
     */
    public  function serveIndex(){
        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:null;
        $size=(isset($_GET['size'])&&$_GET['size']!="null")?$_GET['size']:null;
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?explode('/',$_GET['job']):null;
        $location=( isset($_GET['location'])&&$_GET['location']!="全国")?$_GET['location']:null;
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?"desc":"asc";
        $orderwhere = ['正在办事' => [4,5,6],'已完成' => [7,8],'全部' => range(1,9)];
        $sizeWhere=!empty($size)?$orderwhere[$size]:range(1,9);
        $jobWhere=!empty($job)?array("t_e_event.domain1" => $job[0],'t_e_event.domain2' => $job[1]):array();
        $locationWhere=!empty($location)?array("t_u_enterprise.address"=>$location):array();
        $data=DB::table('t_e_event')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_e_event.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_e_eventverify','t_e_eventverify.eventid' ,'=' ,'t_e_event.eventid')
            ->leftJoin('t_e_eventverifyconfig','t_e_eventverify.configid' ,'=' ,'t_e_eventverifyconfig.configid')
            ->leftJoin('t_e_eventresponse','t_e_eventresponse.eventid' ,'=' ,'t_e_event.eventid')
            ->leftJoin('t_u_user','t_e_event.userid' ,'=' ,'t_u_user.userid')
            ->whereRaw('t_e_eventverify.id in (select max(id) from t_e_eventverify group by eventid)')
            ->select('t_e_eventresponse.state','t_e_eventresponse.expertid','t_e_event.*','t_u_enterprise.address','view_userrole.role','t_e_eventverifyconfig.name','t_e_eventverifyconfig.configid','t_u_enterprise.enterprisename','t_u_expert.expertname','t_u_user.phone','t_e_eventverify.verifytime','t_e_eventverify.configid');
        $obj = $data->whereIn('t_e_eventverify.configid',$sizeWhere)->where($jobWhere)->where($locationWhere);
        $copy_obj = clone $obj;
        if(!empty($serveName)){
            $datas= $obj->where("t_e_event.brief","like","%".$serveName."%")->orderBy("t_e_event.eventtime",$regTime)->paginate(4);
            $counts= $copy_obj->where("t_e_event.brief","like","%".$serveName."%")->count();
        }else{
            $datas= $obj->orderBy("t_e_event.eventtime",$regTime)->paginate(4);
            $counts=  $copy_obj->count();
        }
        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:"null";
        $size=(isset($_GET['size'])&&$_GET['size']!="null")?$_GET['size']:"null";
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?$_GET['regTime']:"down";
        $location=(isset($_GET['location'])&&$_GET['location']!="null")?$_GET['location']:"全国";
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:"null";
        return view("work.serve",compact("datas","counts","serveName","size","regTime","location","job"));
    }

    static public function getExpertName ($expertid)
    {
        $datas = DB::table('t_u_expert')->where('expertid',$expertid)->first();
        return $datas->expertname;
    }

    /**
     * 办事信息维护详情
     * @return mixed
     */
    public function serveDetail($eventid){
        $datas = DB::table('t_e_event')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_e_event.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_e_eventverify','t_e_eventverify.eventid' ,'=' ,'t_e_event.eventid')
            ->leftJoin('t_e_eventverifyconfig','t_e_eventverify.configid' ,'=' ,'t_e_eventverifyconfig.configid')
            ->leftJoin('t_u_user','t_e_event.userid' ,'=' ,'t_u_user.userid')
            ->select('t_u_enterprise.brief as desc1','t_u_expert.brief as desc2','t_e_event.*','view_userrole.role','t_e_eventverifyconfig.name','t_e_eventverifyconfig.configid','t_u_enterprise.enterprisename','t_u_expert.expertname','t_u_user.phone')
            ->where('t_e_event.eventid',$eventid)->first();
        return view("work.detail",compact('datas'));
    }
}
