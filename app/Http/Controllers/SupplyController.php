<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class SupplyController extends Controller
{
    /**
     * 供求信息首页
     * @return mixed
     */
    public function index($action = 'all'){
        $datas = DB::table("t_n_need")
            ->leftJoin("t_u_user", "t_u_user.userid", "=", "t_n_need.userid")
            ->leftJoin("t_n_needverify", "t_n_needverify.needid", "=", "t_n_need.needid")
            ->select("t_n_needverify.configid", "t_n_needverify.verifytime", "t_n_needverify.remark", "t_u_user.phone", "t_u_user.name", "t_n_need.*")
            ->orderBy("t_n_needverify.verifytime", "desc")
            ->where('is_deal','0');
        switch($action){
            case 'all':
                $datas = $datas->whereIn("configid", [1, 3])->paginate(1);
                break;
            case 'wait':
                $datas = $datas->where('configid',1)->paginate(1);
                break;
            case 'fail':
                $datas = $datas->where("configid", 3)->paginate(1);
                break;
        }
        return view("supply.index", compact('datas','action'));
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
    /**供求信息维护首页
     * @return mixed
     */
    public  function serveIndex(Request $request){
        $datas = DB::table('t_n_need')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_n_need.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_user','t_n_need.userid' ,'=' ,'t_u_user.userid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->select('t_n_need.*','view_userrole.role','t_u_enterprise.enterprisename','t_u_enterprise.address','t_u_expert.expertname','t_u_user.phone');

        if($request->isMethod('post')){
            $wheres = $request->input();
            $arrwhere = unserialize($wheres['where']);
            $pagenum = !empty($request->input('page')) ? $request->input('page') : 1;
            $sql = [];
            switch($wheres['key']){
                case 'publishing':
                    $arrwhere['needtype'] = "'".$wheres['value']."'";
                    break;
                case 'unpublishing':
                    unset($arrwhere['needtype']);
                    break;
                case 'domain':
                    $arrwhere['t_n_need.domain1'] = "'".$wheres['value']."'";
                    break;
                case 'undomain':
                    unset($arrwhere['t_n_need.domain1']);
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
                    $arrwhere['t_n_need.brief'] = '"%'. $wheres['value'] .'%"';
                    break;
                case 'unsearch':
                    unset($arrwhere['t_n_need.brief']);
                    break;
            }
            foreach($arrwhere as $k => $v){
                $sql[] = $k != 't_n_need.brief' ? $k . '=' . $v : $k . ' like ' . $v;
            }
            $where = implode(' and ',$sql);
            if(!empty($order)){
                $datas->orderBy('t_n_need.needtime',$order);
            } else {
                $datas->orderBy('t_n_need.needtime','desc');
            }

            $datas = $datas->whereRaw($where)
                ->paginate(5)->toJson();
            /*dd($datas);
            $datas = $datas->forPage($pagenum,5);*/
            return ['where' => serialize($arrwhere) ,'data' => $datas];
        }
        $datas = $datas->orderBy('t_n_need.needtime','desc')
            ->paginate(5);
        return view("supply.serve",compact('datas'));
    }

    /**
     * 供求信息维护详情
     * @return mixed
     */
    public function serveDetail(){

        return view("supply.detail");
    }


}
