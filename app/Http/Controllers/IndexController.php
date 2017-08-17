<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * 后台首页
     * @return mixed
     */
    public function index(){
        return view("index.index");
    }

    /**
     * 注册信息
     * @return mixed
     */
    public function registerData()
    {

        $user=DB::table("T_U_USER")->count();

        $expert=DB::table("T_U_EXPERT")
            ->leftJoin("t_u_expertverify","t_u_expertverify.expertid","=","t_u_expert.expertid")
            ->whereNotIn('t_u_expertverify.configid',[1,3])
            ->whereRaw('T_U_EXPERTVERIFY.id in (select max(id) from T_U_EXPERTVERIFY group by expertid)')
            ->count();

        $enterprise=DB::table("T_U_ENTERPRISE")
            ->leftJoin("t_u_enterpriseverify","t_u_enterpriseverify.enterpriseid","=","t_u_enterprise.enterpriseid")
            ->whereNotIn('t_u_enterpriseverify.configid',[1,2])
            ->whereRaw('T_U_ENTERPRISEVERIFY.id in (select max(id) from T_U_ENTERPRISEVERIFY group by  T_U_ENTERPRISEVERIFY.enterpriseid)')
            ->count();

        $result=DB::table("T_U_USER")
            ->leftJoin("T_U_EXPERT","T_U_USER.USERID","=","T_U_EXPERT.USERID")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.USERID","=","T_U_ENTERPRISE.USERID")
            ->leftJoin("t_u_enterpriseverify","t_u_enterpriseverify.enterpriseid","=","t_u_enterprise.enterpriseid")
            ->leftJoin("t_u_expertverify","t_u_expertverify.expertid","=","t_u_expert.expertid")
            ->whereNotIn('t_u_enterpriseverify.configid',[1,2])
            ->whereNotIn('t_u_expertverify.configid',[1,3])
/*          ->whereRaw('T_U_EXPERT.USERID in (select T_U_USER.USERID from T_U_USER)')
            ->whereRaw('T_U_ENTERPRISE.USERID in (select T_U_USER.USERID from T_U_USER)')*/
            ->whereRaw('T_U_ENTERPRISEVERIFY.id in (select max(id) from T_U_ENTERPRISEVERIFY group by  T_U_ENTERPRISEVERIFY.enterpriseid)')
            ->count();

            return json_encode(['data' => [$enterprise,$expert,$result,$user]]);

    }

    /**
     * 充值体现信息
     * @return mixed
     */
    public function rechargeData()
    {
        $data=DB::table("T_U_BILL")
            ->where('type','支出')
            ->sum('money');

        $datas=DB::table("T_U_BILL")
            ->where('type','充值')
            ->sum('money');

        if($data==null)
        {
            $data=0;
        }
        if($datas==null)
        {
            $datas=0;
        }
        return json_encode(['data' => [$data,$datas]]);

    }

    /**
     * 供求信息
     * @return mixed
     */
    public function supplyData()
    {
        $data=DB::table('t_n_need')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_n_need.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->whereRaw('t_u_enterprise.USERID in (select T_U_USER.USERID from T_U_USER)')
            ->count();

        $result = DB::table('t_n_need')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_n_need.userid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->whereRaw('t_u_expert.USERID in (select T_U_USER.USERID from T_U_USER)')
            ->count();

        return json_encode(['expert'=>$data,'enterprise'=>$result]);

    }

    /**
     * 会员费
     * @return mixed
     */
    public function memberData()
    {

    }

    /**
     * 办事信息
     * @return mixed
     */
    public function workData()
    {

        $result=DB::table('t_e_eventverify')
            ->leftJoin('t_e_eventverifyconfig','t_e_eventverify.configid' ,'=' ,'t_e_eventverifyconfig.configid')
            ->whereRaw('t_e_eventverify.id in (select max(id) from t_e_eventverify group by eventid)')
            ->select('t_e_eventverify.configid',DB::raw('COUNT(t_e_eventverify.configid) as num'))
            ->groupBy('t_e_eventverify.configid')
            ->get();
        $work=[];
        foreach ($result as $v){
            for($i=1;$i<=9;$i++)
            {
                if($v->configid == $i){
                    $work[$i] = $v->num;
                }
                if (!key_exists($i,$work)){
                    $work[$i] = 0;
                }
            }
        }
        return json_encode(['work'=>$work]);

    }

    /**
     * 视频信息
     * @return mixed
     */
    public function videoData()
    {
        $result=DB::table('t_c_consultverify')
            ->leftJoin('t_c_consultverifyconfig','t_c_consultverify.configid' ,'=' ,'t_c_consultverifyconfig.configid')
            ->whereRaw('t_c_consultverify.id in (select max(id) from t_c_consultverify group by consultid)')
            ->select('t_c_consultverify.configid',DB::raw('COUNT(t_c_consultverify.configid) as num'))
            ->groupBy('t_c_consultverify.configid')
            ->get();

        $video=[];
        foreach ($result as $v){
            for($i=1;$i<=9;$i++)
            {
                if($v->configid == $i){
                    $video[$i] = $v->num;
                }
                if (!key_exists($i,$video)){
                    $video[$i] = 0;
                }
            }
        }
        return json_encode(['video'=>$video]);
    }



}
