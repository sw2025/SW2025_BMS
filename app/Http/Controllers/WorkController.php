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
    public  function serveIndex(Request $request){
        $datas = DB::table('t_e_event')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_e_event.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_e_eventverify','t_e_eventverify.eventid' ,'=' ,'t_e_event.eventid')
            ->leftJoin('t_e_eventverifyconfig','t_e_eventverify.configid' ,'=' ,'t_e_eventverifyconfig.configid')
            ->leftJoin('t_e_eventresponse','t_e_eventresponse.eventid' ,'=' ,'t_e_event.eventid')
            ->leftJoin('t_u_user','t_e_event.userid' ,'=' ,'t_u_user.userid')
            ->whereRaw('t_e_eventverify.id in (select max(id) from t_e_eventverify group by eventid)')
            ->select('t_e_eventresponse.state','t_e_eventresponse.expertid','t_e_event.*','t_u_enterprise.address','view_userrole.role','t_e_eventverifyconfig.name','t_e_eventverifyconfig.configid','t_u_enterprise.enterprisename','t_u_expert.expertname','t_u_user.phone','t_e_eventverify.verifytime','t_e_eventverify.configid');
        if($request->isMethod('post')){
            $wheres = $request->input();
            $arrwhere = unserialize($wheres['where']);
            $orderwhere = ['正在办事' => '(4,5,6)','已完成' => '(7,8)'];
            $sql = [];
            switch($wheres['key']){
                case 'publishing':
                    $arrwhere['t_e_eventverify.configid'] = $orderwhere[$wheres['value']];
                    break;
                case 'unpublishing':
                    unset($arrwhere['t_e_eventverify.configid']);
                    break;
                case 'domain':
                    $arrwhere['t_e_event.domain1'] = "'".$wheres['value']."'";
                    break;
                case 'undomain':
                    unset($arrwhere['t_e_event.domain1']);
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
                    $arrwhere['t_e_event.brief'] = '"%'. $wheres['value'] .'%"';
                    break;
                case 'unsearch':
                    unset($arrwhere['t_e_event.brief']);
                    break;
            }
            foreach($arrwhere as $k => $v){
                if($k == 't_e_eventverify.configid'){
                    $sql[] = $k . ' in ' . $v;
                } elseif($k == 't_e_event.brief') {
                    $sql[] = $k . ' like ' . $v;
                } else{
                    $sql[] = $k . '=' . $v;
                }
            }
            $where = implode(' and ',$sql);
            if(!empty($order)){
                $datas->orderBy('t_e_event.eventtime',$order);
            } else {
                $datas->orderBy('t_e_event.eventtime','desc');
            }

            $datas = $datas->whereRaw($where)->paginate(5)->toJson();
            return ['where' => serialize($arrwhere) ,'data' => $datas];
        }
        $datas = $datas->orderBy('t_e_event.eventtime','desc')->paginate(8);
        return view("work.serve",compact('datas'));
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
