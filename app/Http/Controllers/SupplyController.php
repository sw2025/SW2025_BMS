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
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_n_need.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_user','t_n_need.userid' ,'=' ,'t_u_user.userid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('view_needstatus as status','status.needid','=','t_n_need.needid')
            ->select('t_u_enterprise.enterprisename as entname','t_u_expert.expertname as extname',"status.configid", "t_u_user.phone", "t_u_user.name", "t_n_need.*")
            ->orderBy("t_n_need.needid", "desc");
        switch($action){
            case 'all':
                $datas = $datas->whereIn("configid", [1, 2])->paginate(10);
                break;
            case 'wait':
                $datas = $datas->where('configid',1)->paginate(10);
                break;
            case 'fail':
                $datas = $datas->where("configid", 2)->paginate(10);
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
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_n_need.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_user','t_n_need.userid' ,'=' ,'t_u_user.userid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('view_needstatus as status','status.needid','=','t_n_need.needid')
            ->select('view_userrole.role','t_u_enterprise.enterprisename','t_u_expert.expertname',"status.configid", "t_u_user.phone", "t_u_user.name", "t_n_need.*")
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
        if(!$datas['flag']){
           DB::table("t_n_needverify")
                ->insert([
                    'needid'     =>  $datas['supply_id'],
                    "configid"   =>  $datas['config_id'],
                    'verifytime' =>  date('Y-m-d H:i:s',time()),
                    "remark"     =>  !empty($datas['remark'])?$datas['remark']:"",
                    "updated_at" =>  date("Y-m-d H:i:s",time()),
                    "created_at" =>  date("Y-m-d H:i:s",time())
                ]);
            return json_encode(['errorMsg' => 'success']);
        } else {
            return json_encode(['errorMsg' => 'error']);
        }
    }
    /**供求信息维护首页
     * @return mixed
     */
    public  function serveIndex(){

        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:null;
        $size=(isset($_GET['size'])&&$_GET['size']!="null")?$_GET['size']:null;
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?explode('/',$_GET['job']):null;
        $location=( isset($_GET['location'])&&$_GET['location']!="全国")?$_GET['location']:null;
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?"desc":"asc";

        $sizeWhere=!empty($size)?array("needtype"=>$size):array();
        if(!empty($job) && count($job) == 1 ){
            $jobWhere= array("t_n_need.domain1" => $job[0]);
        } else {
            $jobWhere=!empty($job)?array("t_n_need.domain1" => $job[0],'t_n_need.domain2' => $job[1]):array();
        }
        $locationWhere=!empty($location)?array("t_u_enterprise.address"=>$location):array();
        $data=DB::table('t_n_need')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_n_need.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_user','t_n_need.userid' ,'=' ,'t_u_user.userid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->select('t_n_need.*','view_userrole.role','t_u_enterprise.enterprisename','t_u_enterprise.address','t_u_expert.expertname','t_u_user.phone');
        $obj = $data->where($sizeWhere)->where($jobWhere)->where($locationWhere);
        $copy_obj = clone $obj;
        if(!empty($serveName)){
            $datas= $obj->where("t_n_need.brief","like","%".$serveName."%")->orderBy("t_n_need.needtime",$regTime)->paginate(10);
            $counts= $copy_obj->where("t_n_need.brief","like","%".$serveName."%")->count();
        }else{
            $datas= $obj->orderBy("t_n_need.needtime",$regTime)->paginate(10);
            $counts= $copy_obj->count();
        }
        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:"null";
        $size=(isset($_GET['size'])&&$_GET['size']!="null")?$_GET['size']:"null";
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?$_GET['regTime']:"down";
        $location=(isset($_GET['location'])&&$_GET['location']!="null")?$_GET['location']:"全国";
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:"null";
        //查询2级分类
        $cate = DB::table('t_common_domaintype')->get();
        return view("supply.serve",compact("datas","counts","serveName","size","regTime","location","job",'cate'));

    }

    /**
     * 供求信息维护详情
     * @return mixed
     */
    public function serveDetail($supply_id){
        $datas = DB::table('t_n_need')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_n_need.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_user','t_n_need.userid' ,'=' ,'t_u_user.userid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->select('t_u_enterprise.brief as desc1','t_u_expert.brief as desc2','t_n_need.*','view_userrole.role','t_u_enterprise.enterprisename','t_u_enterprise.address','t_u_expert.expertname','t_u_user.phone')
            ->where('needid',$supply_id)
            ->first();

        $result = DB::table('t_n_messagetoneed')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_n_messagetoneed.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_user','t_n_messagetoneed.userid' ,'=' ,'t_u_user.userid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->where('t_n_messagetoneed.needid',$supply_id)
            ->where('isdelete',0)
            ->get();
        //dd($result);
        return view("supply.detail",compact('datas','result'));
    }


    /**
     * 需求评论信息删除
     * @return mixed
     */

    public function deleteSupplyContent()
    {
        $id = $_GET['id'];
        $needid=$_GET['needid'];
        DB::table("t_n_messagetoneed")
            ->where('id',$id)
            ->update([
                'isdelete' => 1,
            ]);

        return redirect("/serve_supplyDet/$needid");
    }


    /**
     * 需求咨询信息删除
     * @return mixed
     */

    public function deleteSupply()
    {
        $needid = $_GET['needid'];
        DB::table("t_n_needverify")
            ->insert([
                'needid' => $needid,
                "configid" => 3,
                'verifytime' => date('Y-m-d H:i:s', time()),
                "updated_at" => date("Y-m-d H:i:s", time()),
                "created_at" => date("Y-m-d H:i:s", time())
            ]);

        return redirect("/serve_supply");
    }


}
