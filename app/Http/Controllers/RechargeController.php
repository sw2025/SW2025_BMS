<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RechargeController extends Controller
{

    /**
     * 提现审核
     * @return mixed
     */
    public function index($status='all'){

        $ids=array();
        $userids=array();
        $results=DB::table("T_U_BILL")->select("id","userid")->orderBy("billtime","desc")->distinct()->get();
        foreach ($results as $result){
            if(!in_array($result->userid,$userids)){
                $userids[]=$result->userid;
                $ids[]=$result->id;
            }
}

        //$status=empty($_GET['status'])?'all' : $_GET['status'];

        $datas=DB::table("T_U_BILL")
            ->leftJoin('view_userrole','view_userrole.userid', '=','T_U_BILL.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_u_user','T_U_BILL.userid' ,'=' ,'t_u_user.userid')
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_EXPERT.*","t_u_enterprise.enterpriseid","t_u_enterprise.enterprisename","T_U_BILL.*")
            ->orderBy("T_U_BILL.billtime","desc");
        //dd($datas);

        switch ($status) {
            case 'all':
                $datas = $datas->whereIn("type",['在途','收入'])->whereIn("T_U_BILL.id",$ids)->distinct()->paginate(2);
                return view("recharge.index",compact("datas"));
                break;
            case 'wait':
                $datas = $datas->where("type",'在途')->whereIn("T_U_BILL.id",$ids)->distinct()->paginate(2);
                return view("recharge.index",compact("datas"));
                break;
            case 'fail':
                $datas = $datas->where("type",'收入')->whereIn("T_U_BILL.id",$ids)->distinct()->paginate(2);
                return view("recharge.index",compact("datas"));
                break;
        }
        //return view("recharge.index");
    }

    /**提现审核
     * @return
     */
    public function changeRecharge(){

        $id = $_POST['id'];
        $data = DB::table("T_U_BILL")->select("money","userid")->where("id","$id")->first();
        $array=array();
        $result=DB::table("T_U_BILL")
            ->where("id",$_POST['id'])
            ->insert([
                "userid"=>$data->userid,
                "type"=>$_POST['type'],
                "channel"=>$_POST['channel'],
                "billtime"=>date("Y-m-d H:i:s",time()),
                "money"=>$data->money,
                "remark"=>isset($_POST['remark'])?$_POST['remark']:"",
                "created_at"=>date("Y-m-d H:i:s",time()),
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


    /**
     * 提现审核详情
     * @return mixed
     */
    public function update(){
        return view("recharge.update");
    }

    /**
     * 提现信息维护首页
     * @return mixed
     */
    public function serveIndex(){
        return view("recharge.serve");
    }
    /**
     * 提现信息维护详情
     * @return mixed
     */
    public function serveDetail(){
        return view("recharge.detail");
    }

}
