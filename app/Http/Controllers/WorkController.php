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
            ->where('is_deal',0);
        switch ($action) {
            case 'all':
                $datas = $datas->whereIn("configid", [1,2,3])->paginate(3);
                break;
            case 'wait':
                $datas = $datas->where("configid", 1)->paginate(3);
                break;
            case 'fail':
                $datas = $datas->where("configid", 3)->paginate(3);
                break;
            case 'wput':
                $datas = $datas->where("configid", 2)->paginate(3);
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

    public function changeEvent(Request $request)
    {
        $datas = $request->input();
        $update = DB::table('t_e_eventverify')->where('eventid' , $datas['event_id'])
            ->update(
                ['is_deal' => 1]
            );
        $result=DB::table("t_e_eventverify")
            ->insert([
                'eventid'    => $datas['event_id'],
                "configid"   => $datas['config_id'],
                'verifytime' => date('Y-m-d H:i:s',time()),
                "remark"     => !empty($datas['remark']) ? $datas['remark'] : "",
                "updated_at" => date("Y-m-d H:i:s",time()),
            ]);
        if ($result || $update) {
            return json_encode(['errorMsg' => 'success']);
        } else {
            return json_encode(['errorMsg' => 'error']);
        }
    }

  
}
