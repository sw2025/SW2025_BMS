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
        $ids=array();
        $expertids=array();
        $results=DB::table("T_U_EXPERTVERIFY")->select("id","expertid")->orderBy("verifytime","desc")->distinct()->get();
        foreach ($results as $result){
            if(!in_array($result->expertid,$expertids)){
                $expertids[]=$result->expertid;
                $ids[]=$result->id;
            }
        }
        //$status=empty($_GET['status'])?'all' : $_GET['status'];
        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_EXPERT","T_U_USER.USERID","=","T_U_EXPERT.USERID")
            ->leftJoin("T_U_EXPERTVERIFY","T_U_EXPERT.EXPERTID","=","T_U_EXPERTVERIFY.expertid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_EXPERT.*","T_U_EXPERTVERIFY.configid","T_U_EXPERT.expertid")
            ->orderBy("T_U_EXPERT.created_at","desc");

        switch ($status) {
            case 'all':
                $datas = $datas->whereIn("configid",[1,3])->whereIn("T_U_EXPERTVERIFY.id",$ids)->distinct()->paginate(2);
                return view("expert.index",compact("datas"));
                break;
            case 'wait':
                $datas = $datas->whereIn("configid",[1])->whereIn("T_U_EXPERTVERIFY.id",$ids)->distinct()->paginate(2);
                return view("expert.index",compact("datas"));
                break;
            case 'fail':
                $datas = $datas->whereIn("configid",[3])->whereIn("T_U_EXPERTVERIFY.id",$ids)->distinct()->paginate(2);
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
    public  function serveIndex(){
        return view("expert.serve");

    }

    /**专家信息维护详情
     * @return mixed
     */
    public  function serveDetail(){
        return view("expert.detail");
    }
   
}
