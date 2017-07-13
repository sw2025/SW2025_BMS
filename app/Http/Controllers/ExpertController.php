<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ExpertController extends Controller
{
    /**专家审核首页
     * @return mixed
     */
    public function index($status="all"){

        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_EXPERT","T_U_USER.USERID","=","T_U_EXPERT.USERID")
            ->leftJoin("T_U_EXPERTVERIFY","T_U_EXPERT.EXPERTID","=","T_U_EXPERTVERIFY.expertid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_EXPERT.*","T_U_EXPERTVERIFY.configid","T_U_EXPERTVERIFY.VERIFYTIME","T_U_EXPERT.expertid")
            ->orderBy("T_U_EXPERT.created_at","desc")
            ->whereRaw('T_U_EXPERTVERIFY.id in (select max(id) from T_U_EXPERTVERIFY group by expertid)');

        switch ($status) {
            case 'all':
                $datas = $datas->whereIn("configid",[1,3])->paginate(2);
                return view("expert.index",compact("datas"));
                break;
            case 'wait':
                $datas = $datas->whereIn("configid",[1])->paginate(2);
                return view("expert.index",compact("datas"));
                break;
            case 'fail':
                $datas = $datas->whereIn("configid",[3])->paginate(2);
                return view("expert.index",compact("datas"));
                break;
        }
    }

    public  function  update(){
        $expertid=$_GET['expertid'];
        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_EXPERT","T_U_USER.USERID","=","T_U_EXPERT.USERID")
            ->leftJoin("T_U_EXPERTVERIFY","T_U_EXPERT.EXPERTID","=","T_U_EXPERTVERIFY.expertid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_EXPERT.*","T_U_EXPERTVERIFY.configid","T_U_EXPERT.expertid")
            ->where("T_U_EXPERT.expertid",$expertid)
            ->first();
        //dd($datas);

        return view("expert.update",compact("datas"));
    }
    //
    public  function changeExpert(){
        $array=array();
        $result=DB::table("T_U_EXPERTVERIFY")
            ->where("expertid",$_POST['expertid'])
            ->insert([
                "expertid"=>$_POST['expertid'],
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
  
    /**专家信息维护首页
     * @return mixed
     */
    public  function serveIndex(Request $request){


        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_EXPERT","T_U_USER.USERID","=","T_U_EXPERT.USERID")
            ->leftJoin("T_U_EXPERTVERIFY","T_U_EXPERT.EXPERTID","=","T_U_EXPERTVERIFY.expertid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_EXPERT.*","T_U_EXPERTVERIFY.configid","T_U_EXPERTVERIFY.VERIFYTIME","T_U_EXPERT.expertid")
            ->whereRaw('T_U_EXPERTVERIFY.id in (select max(id) from T_U_EXPERTVERIFY group by expertid)');

        if($request->isMethod('post')){
            $wheres = $request->input();
            $arrwhere = unserialize($wheres['where']);

            $pagenum = !empty($request->input('page')) ? $request->input('page') : 1;
            $sql = [];
            switch($wheres['key']){
                case 'domain':
                    $arrwhere['T_U_EXPERT.domain1'] = "'".$wheres['value']."'";
                    break;
                case 'undomain':
                    unset($arrwhere['T_U_EXPERT.domain1']);
                    break;
                case 'address':
                    $arrwhere['T_U_EXPERT.address'] = "'".$wheres['value']."'";
                    break;
                case 'unaddress':
                    unset($arrwhere['T_U_EXPERT.address']);
                    break;
                case 'ordertime':
                    $order = $wheres['value'];
                    break;
                case 'search':
                    $arrwhere['T_U_EXPERT.brief'] = '"%'. $wheres['value'] .'%"';
                    break;
                case 'unsearch':
                    unset($arrwhere['T_U_EXPERT.brief']);
                    break;
            }
            foreach($arrwhere as $k => $v){
                $sql[] = $k != 'T_U_EXPERT.brief' ? $k . '=' . $v : $k . ' like ' . $v;
            }

            $where = implode(' and ',$sql);
            if(!empty($order)){
                $data->orderBy('T_U_EXPERTVERIFY.VERIFYTIME',$order);

            } else {
                $datas->orderBy('T_U_EXPERTVERIFY.VERIFYTIME','desc');
            }

            $count=$datas->count();

            $datas = $datas->whereRaw($where)
                ->paginate(2)->toJson();

            return ['where' => serialize($arrwhere) ,'data' => $datas];
        }

        $count=$datas->count();

        $datas = $datas->orderBy('T_U_EXPERTVERIFY.VERIFYTIME','desc')
            ->paginate(2);

        return view("expert.serve",compact('datas','count'));

    }

    /**专家信息维护详情
     * @return mixed
     */
    public  function serveDetail(){
        return view("expert.detail");
    }
   
}
