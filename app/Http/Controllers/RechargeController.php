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
        $datas=DB::table("T_U_BILL")
            ->leftJoin('view_userrole','view_userrole.userid', '=','T_U_BILL.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_u_user','T_U_BILL.userid' ,'=' ,'t_u_user.userid')
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_EXPERT.*","t_u_enterprise.enterpriseid","t_u_enterprise.enterprisename","T_U_BILL.*")
            ->orderBy("T_U_BILL.billtime","desc")
            ->whereRaw('T_U_BILL.id in (select max(id) from T_U_BILL group by userid)');
        //dd($datas);
        switch ($status) {
            case 'all':
                $datas = $datas->whereIn("type",['在途','收入'])->paginate(10);
                break;
            case 'wait':
                $datas = $datas->where("type",'在途')->paginate(10);
                break;
            case 'fail':
                $datas = $datas->where("type",'收入')->paginate(10);
                break;
        }
        return view("recharge.index",compact("datas","status"));
    }
    /**提现审核
     * @return
     */
    public function changeRecharge(){
        $id = $_POST['id'];
        $data = DB::table("T_U_BILL")->select("money","userid","id")->where("id",$id)->first();
        $array=array();
        $res = DB::table("T_U_BILL")
            ->where("id",$data->id)
            ->update([
                "type"=>'失效'
            ]);
        if($res){
            $result=DB::table("T_U_BILL")
                ->whereRaw('T_U_BILL.id in (select max(id) from T_U_BILL group by userid)')
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
        }
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
        $id=$_GET['id'];
        $datas=DB::table("T_U_BILL")
            ->leftJoin('view_userrole','view_userrole.userid', '=','T_U_BILL.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_u_user','T_U_BILL.userid' ,'=' ,'t_u_user.userid')
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_EXPERT.*","t_u_enterprise.enterpriseid","t_u_enterprise.enterprisename","t_u_enterprise.brief","T_U_BILL.*")
            ->where("T_u_user.userid",$id)
            ->orderBy("T_U_BILL.billtime","desc")
            ->first();
        //dd($datas);
        return view("recharge.update",compact("datas"));
    }
    /**
     * 提现信息维护首页
     * @return mixed
     */
    public function serveIndex(){
        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:null;
        $size=(isset($_GET['size'])&&$_GET['size']!="null")?$_GET['size']:null;
        /*        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:null;*/
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?explode('/',$_GET['job']):null;
        $location=( isset($_GET['location'])&&$_GET['location']!="全国")?$_GET['location']:null;
        $sizeType=(isset($_GET['sizeType'])&&$_GET['sizeType']!="down")?"desc":"asc";
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?"desc":"asc";
        $idCard=(isset($_GET['idCard'])&&$_GET['idCard']!="null")?$_GET['idCard']:null;
        if(!empty($idCard)){
            if($idCard=="专家"){
                $res = 'T_U_BILL.userid in (select userid from t_u_expert )';
            }else{
                $res = 'T_U_BILL.userid in (select userid from t_u_enterprise)';
            }
        }
        if(!empty($size)) {
            if($size=="提现"){
                $size="支出";
            }
        }
        $sizeWhere=!empty($size)?array("T_U_BILL.type"=>$size):array();
        //$jobWhere=!empty($job)?array("domain1"=>$job):array();
        if(!empty($job) && count($job) == 1 ){
            $jobWhere= array("t_u_expert.domain1" => $job[0]);
            //dd($jobWhere);
        } else {
            $jobWhere=!empty($job)?array("t_u_expert.domain1" => $job[0],'t_u_expert.domain2' => $job[1]):array();
        }
        $locationWhere=!empty($location)?array("t_u_enterprise.address"=>$location):array();
        //dd($sizeWhere);
        $data=DB::table("T_U_BILL")
            ->leftJoin('view_userrole','view_userrole.userid', '=','T_U_BILL.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_u_user','T_U_BILL.userid' ,'=' ,'t_u_user.userid')
            ->select("T_U_USER.phone",'view_userrole.role',"T_U_USER.created_at","T_U_EXPERT.*","t_u_enterprise.enterpriseid","t_u_enterprise.enterprisename","T_U_BILL.*")
            ->whereRaw('T_U_BILL.id in (select max(id) from T_U_BILL group by userid)')
            ->whereIn("TYPE",['支出','充值']);
        $count=clone $data;
        if(!empty($serveName)){
            $datas=$data->where("enterprisename","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->orderBy("size",$sizeType)->orderBy("T_U_ENTERPRISE.created_at",$sizeType)->paginate(10);
            $counts=$count->where("enterprisename","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->count();
        }else{
            $datas=$data->where($sizeWhere)->where($jobWhere)->where($locationWhere)->orderBy("size",$sizeType)->orderBy("T_U_BILL.BILLTIME",$regTime) ->paginate(10);
            $counts= $count->where($sizeWhere)->where($jobWhere)->where($locationWhere)->count();
        }
        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:"null";
        $sizeType=(isset($_GET['sizeType'])&&$_GET['sizeType']!="down")?$_GET['sizeType']:"down";
        $size=(isset($_GET['size'])&&$_GET['size']!="null")?$_GET['size']:"null";
        $idCard=(isset($_GET['idCard'])&&$_GET['idCard']!="null")?$_GET['idCard']:"null";
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?$_GET['regTime']:"down";
        $location=(isset($_GET['location'])&&$_GET['location']!="null")?$_GET['location']:"全国";
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:"null";
        $label = DB::table('t_common_domaintype')->get();
        return view("recharge.serve",compact("datas","counts","serveName","sizeType","size","idCard","regTime","location","job","label"));
    }
    /**
     * 提现信息维护详情
     * @return mixed
     */
    public function serveDetail($rechargeid){
        $data=DB::table("T_U_BILL")
            ->leftJoin('view_userrole','view_userrole.userid', '=','T_U_BILL.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->leftJoin('t_u_user','T_U_BILL.userid' ,'=' ,'t_u_user.userid')
            ->select("T_U_USER.phone",'view_userrole.role',"T_U_USER.created_at","T_U_EXPERT.*","t_u_enterprise.enterpriseid","t_u_enterprise.enterprisename","T_U_BILL.*")
            ->whereRaw('T_U_BILL.id in (select max(id) from T_U_BILL group by userid)')
            ->where("t_u_enterprise.enterpriseid",$rechargeid)
            ->orderBy('T_U_BILL.billtime','desc')
            ->first();
        return view("recharge.detail",compact('data'));
    }
}