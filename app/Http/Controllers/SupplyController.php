<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SupplyController extends Controller
{
    /**
     * 供求信息首页
     * @return mixed
     */
    public function index(){
        $status = empty($_GET['status']) ? 'all' : $_GET['status'];
        $datas = DB::table("t_n_need")
            ->leftJoin("t_u_user", "t_u_user.userid", "=", "t_n_need.userid")
            ->leftJoin("t_n_needverify", "t_n_needverify.needid", "=", "t_n_need.needid")
            ->select("t_n_needverify.configid", "t_n_needverify.verifytime", "t_n_needverify.remark", "t_u_user.phone", "t_u_user.name", "t_n_need.*")
            ->orderBy("t_n_needverify.verifytime", "desc")
            ->where('is_deal','0');
        switch($status){
            case 'all':
                $datas = $datas->whereIn("configid", [1, 3])->paginate(3);
                break;
            case 'wait':
                $datas = $datas->where('configid',1)->paginate(3);
                break;
            case 'fail':
                $datas = $datas->where("configid", 3)->paginate(3);
                break;
        }
        return view("supply.index", compact('datas','status'));
    }

    /**供求信息详情
     * @param $supply_id  供求表中id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public  function update($supply_id){

        $datas = DB::table("t_n_need")
            ->leftJoin("t_u_user", "t_u_user.userid", "=", "t_n_need.userid")
            ->leftJoin("t_n_needverify", "t_n_needverify.needid", "=", "t_n_need.needid")
            ->select("t_n_needverify.configid", "t_n_needverify.verifytime", "t_n_needverify.remark", "t_u_user.phone", "t_u_user.name", "t_n_need.*")
            ->where('t_n_need.needid',$supply_id)
            ->orderBy("created_at", "desc")
            ->first();
        return view("supply.update",compact('datas'));
    }

    /**更改供求审核
     * @param Request $request
     * @return string
     */
    public function changeSupply(Request $request)
    {
        $datas = $request->input();
        $update = DB::table('t_n_needverify')->where('needid' , $datas['supply_id'])
            ->update(
                ['is_deal' => 1]
            );
        $result=DB::table("t_n_needverify")
            ->insert([
                'needid' => $datas['supply_id'],
                "configid"=>$datas['config_id'],
                'verifytime' => date('Y-m-d H:i:s',time()),
                "remark"=>!empty($datas['remark'])?$datas['remark']:"",
                "updated_at"=>date("Y-m-d H:i:s",time()),
                "created_at"=>date("Y-m-d H:i:s",time())
            ]);
        if ($result || $update) {
            return json_encode(['errorMsg' => 'success']);
        } else {
            return json_encode(['errorMsg' => 'error']);
        }
    }
}

