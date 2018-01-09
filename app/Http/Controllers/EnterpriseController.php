<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;

class EnterpriseController extends Controller{

    /*
     * 注册及企业信息
     */
    public function enterpriseData()
    {
        $status=!empty($_GET['status'])?$_GET['status']:0;
        if($status==0){
            $datas = DB::table('t_u_enterprise')
                ->leftJoin("T_U_user","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
                ->orderBy('t_u_enterprise.created_at', 'desc')
                ->select("T_U_USER.phone","t_u_enterprise.*")
                ->paginate(5);
        }elseif($status==1){
            $datas = DB::table('t_u_enterprise')
                ->leftJoin("T_U_user","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
                ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
                ->whereRaw('T_U_ENTERPRISEVERIFY.id in (select max(id) from T_U_ENTERPRISEVERIFY group by T_U_ENTERPRISEVERIFY.enterpriseid)')
                ->orderBy('t_u_enterprise.created_at', 'desc')
                ->select("T_U_USER.phone","t_u_enterprise.*",'T_U_ENTERPRISEVERIFY.configid')
                ->paginate(5);
        }else{
            $datas = DB::table('t_u_enterprise')
                ->leftJoin("T_U_user","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
                ->where('t_u_enterprise.enterprisename',null)
                ->orderBy('t_u_enterprise.created_at', 'desc')
                ->select("T_U_USER.phone","t_u_enterprise.*")
                ->paginate(5);
        }

        return view("member.enterpriseData",compact('datas','status'));
    }

    /*
     * 导入企业信息维护
     */
    public function importEnterprises()
    {
        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:null;
        $size=(isset($_GET['size'])&&$_GET['size']!="null")?$_GET['size']:null;
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:null;
        $location=( isset($_GET['location'])&&$_GET['location']!="全国")?$_GET['location']:null;
        $sizeType=(isset($_GET['sizeType'])&&$_GET['sizeType']!="down")?"desc":"asc";
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?"desc":"asc";
        $idCard=(isset($_GET['idCard'])&&$_GET['idCard']!="null")?$_GET['idCard']:null;
        if(!empty($idCard)){
            if($idCard=="普通"){
                $idCard=1;
            }else{
                $idCard=2;
            }
        }
        $sizeWhere=!empty($size)?array("size"=>$size):array();
        $jobWhere=!empty($job)?array("industry"=>$job):array();
        $locationWhere=!empty($location)?array("address"=>$location):array();
        $data=DB::table("enterpriseuser");
        $count=DB::table("enterpriseuser");


        if(!empty($serveName)){
            if(!empty($idCard)){
                $datas=$data->where("enterprisename","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->where("memberid",$idCard)->orderBy("size",$sizeType)->paginate(10);
                $counts=$data->where("enterprisename","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->where("memberid",$idCard)->count();
            }else{
                $datas=$data->where("enterprisename","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->orderBy("size",$sizeType)->paginate(10);
                $counts=$data->where("enterprisename","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->count();
            }
        }else{
            if(!empty($idCard)){
                $datas=$data->where($sizeWhere)->where($jobWhere)->where($locationWhere)->where("memberid",$idCard)->orderBy("size",$sizeType)->paginate(10);
                $counts=$data->where($sizeWhere)->where($jobWhere)->where($locationWhere)->where("memberid",$idCard)->count();
            }else{
                $datas=$data->where($sizeWhere)->where($jobWhere)->where($locationWhere)->orderBy("size",$sizeType)->paginate(10);
                $counts= $count->where($sizeWhere)->where($jobWhere)->where($locationWhere)->count();

            }
        }
        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:"null";
        $sizeType=(isset($_GET['sizeType'])&&$_GET['sizeType']!="down")?$_GET['sizeType']:"down";
        $size=(isset($_GET['size'])&&$_GET['size']!="null")?$_GET['size']:"null";
        $idCard=(isset($_GET['idCard'])&&$_GET['idCard']!="null")?$_GET['idCard']:"null";
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?$_GET['regTime']:"down";
        $location=(isset($_GET['location'])&&$_GET['location']!="null")?$_GET['location']:"全国";
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:"null";

        return view("enterprise.importEnterprises",compact("datas","counts","serveName","sizeType","size","idCard","regTime","location","job"));

    }

    /**
     * 专家审核首页
     * @param int $status
     * @return mixed
     */
    public function index(){
      /*  $ids=$this->returnIds();*/
        $status=!empty($_GET['status'])?$_GET['status']:0;
        if($status==0){
        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
            ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid","T_U_ENTERPRISEVERIFY.id")
            ->whereIn("configid",[1,2])
            ->whereRaw('T_U_ENTERPRISEVERIFY.id in (select max(id) from T_U_ENTERPRISEVERIFY group by  T_U_ENTERPRISEVERIFY.enterpriseid)')
            ->orderBy("T_U_ENTERPRISE.created_at","desc")
            ->paginate(10);
        }else{
        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
            ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid")
            ->where("configid",$status)
            ->whereRaw('T_U_ENTERPRISEVERIFY.id in (select max(id) from T_U_ENTERPRISEVERIFY group by  T_U_ENTERPRISEVERIFY.enterpriseid)')
            ->orderBy("T_U_ENTERPRISE.created_at","desc")
            ->paginate(10);
        }
        return view("enterprise.index",compact("datas","status"));
    }



    /**详情
     * @param $enterpriseId
     * @return mixed
     */
    public  function update(){
       $enterpriseId=$_GET['id'];
        $id=DB::table("T_U_ENTERPRISEVERIFY")->where("enterpriseid",$enterpriseId)->orderBy("verifytime","desc")->take(1)->pluck("id");
        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
            ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid")
            ->where("T_U_ENTERPRISE.enterpriseid",$enterpriseId)
            ->whereRaw('T_U_ENTERPRISEVERIFY.id in (select max(id) from T_U_ENTERPRISEVERIFY group by  T_U_ENTERPRISEVERIFY.enterpriseid)')
            ->orderBy("T_U_ENTERPRISE.created_at","desc")
            ->get();
        return view("enterprise.update",compact("datas"));
    }

    /**
     * 企业审核状态
     * @return array
     */
    public  function changeEnterprise(){
        $array=array();
        $res=DB::table("T_U_ENTERPRISE")
                ->leftJoin("T_U_USER","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
                ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
                ->where("T_U_ENTERPRISEVERIFY.enterpriseid",$_POST['enterpriseId'])
                ->orderBy("T_U_ENTERPRISEVERIFY.id")
                ->select("T_U_USER.phone","T_U_ENTERPRISEVERIFY.created_at","T_U_USER.userid")
                ->take(1)
               ->get();
        foreach ($res as $value){
            $mobile=$value->phone;
            $time=$value->created_at;
            $receiveId=$value->userid;
        }
        $result=DB::table("T_U_ENTERPRISEVERIFY")->insert([
                        "configid"=>$_POST['configid'],
                        "enterpriseid"=>$_POST['enterpriseId'],
                        "remark"=>isset($_POST['remark'])?$_POST['remark']:"",
                        "verifytime"=>date("Y-m-d H:i:s",time()),
                        "created_at"=>date("Y-m-d H:i:s",time()),
                        "updated_at"=>date("Y-m-d H:i:s",time())
                    ]);
        if($_POST['configid']==3){
            DB::table("T_M_SYSTEMMESSAGE")->insert([
                "sendid"=>0,
                "receiveid"=>$receiveId,
                "title"=>"企业审核成功",
                "content"=>"您提交的企业审核已经通过,马上开通会员享受更多优惠吧",
                "state"=>0,
                "sendtime"=>date("Y-m-d H:i:s",time()),
                "created_at"=>date("Y-m-d H:i:s",time()),
                "updated_at"=>date("Y-m-d H:i:s",time()),
            ]);
            $this->_sendSms($mobile,$time,"enterpriseSuccess");
        }else{
            DB::table("T_M_SYSTEMMESSAGE")->insert([
                "sendid"=>0,
                "receiveid"=>$receiveId,
                "title"=>"企业审核失败",
                "content"=>"您提交的企业审核未通过,请重新提交",
                "state"=>0,
                "sendtime"=>date("Y-m-d H:i:s",time()),
                "created_at"=>date("Y-m-d H:i:s",time()),
                "updated_at"=>date("Y-m-d H:i:s",time()),
            ]);
            $this->_sendSms($mobile,$time,"enterpriseFail");
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
     * 企业信息维护
     * @return mixed
     */
    public  function serveIndex(){
        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:null;
        $size=(isset($_GET['size'])&&$_GET['size']!="null")?$_GET['size']:null;
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:null;
        $location=( isset($_GET['location'])&&$_GET['location']!="全国")?$_GET['location']:null;
        $sizeType=(isset($_GET['sizeType'])&&$_GET['sizeType']!="down")?"desc":"asc";
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?"desc":"asc";
        $idCard=(isset($_GET['idCard'])&&$_GET['idCard']!="null")?$_GET['idCard']:null;
        if(!empty($idCard)){
            if($idCard=="普通"){
                $idCard=1;
            }else{
                $idCard=2;
            }
        }
        $sizeWhere=!empty($size)?array("size"=>$size):array();
        $jobWhere=!empty($job)?array("industry"=>$job):array();
        $locationWhere=!empty($location)?array("address"=>$location):array();
        $data=DB::table("T_U_USER")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
            ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
            ->leftJoin("T_U_ENTERPRISEMEMBER","T_U_ENTERPRISEMEMBER.enterpriseid","=","T_U_ENTERPRISE.enterpriseid")
            ->select("T_U_USER.phone","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid","T_U_ENTERPRISEMEMBER.memberid")
            ->whereRaw('T_U_ENTERPRISEVERIFY.id in (select max(id) from T_U_ENTERPRISEVERIFY group by  T_U_ENTERPRISEVERIFY.enterpriseid)')
            ->where("configid",3);
        $count=DB::table("T_U_USER")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
            ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
            ->leftJoin("T_U_ENTERPRISEMEMBER","T_U_ENTERPRISEMEMBER.enterpriseid","=","T_U_ENTERPRISE.enterpriseid")
            ->whereRaw('T_U_ENTERPRISEVERIFY.id in (select max(id) from T_U_ENTERPRISEVERIFY group by  T_U_ENTERPRISEVERIFY.enterpriseid)')
            ->where("configid",3);

        if(!empty($serveName)){
            if(!empty($idCard)){
                $datas=$data->where("enterprisename","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->where("memberid",$idCard)->orderBy("size",$sizeType)->orderBy("T_U_ENTERPRISE.created_at",$regTime)->paginate(10);
                $counts=$data->where("enterprisename","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->where("memberid",$idCard)->count();
            }else{
                $datas=$data->where("enterprisename","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->orderBy("size",$sizeType)->orderBy("T_U_ENTERPRISE.created_at",$sizeType)->paginate(10);
                $counts=$data->where("enterprisename","like","%".$serveName."%")->where($sizeWhere)->where($jobWhere)->where($locationWhere)->count();
            }
        }else{
            if(!empty($idCard)){
                $datas=$data->where($sizeWhere)->where($jobWhere)->where($locationWhere)->where("memberid",$idCard)->orderBy("size",$sizeType)->orderBy("T_U_ENTERPRISE.created_at",$regTime)->paginate(10);
                $counts=$data->where($sizeWhere)->where($jobWhere)->where($locationWhere)->where("memberid",$idCard)->count();
            }else{
                $datas=$data->where($sizeWhere)->where($jobWhere)->where($locationWhere)->orderBy("size",$sizeType)->orderBy("T_U_ENTERPRISE.created_at",$regTime) ->paginate(10);
                $counts= $count->where($sizeWhere)->where($jobWhere)->where($locationWhere)->count();

            }
        }
        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:"null";
        $sizeType=(isset($_GET['sizeType'])&&$_GET['sizeType']!="down")?$_GET['sizeType']:"down";
        $size=(isset($_GET['size'])&&$_GET['size']!="null")?$_GET['size']:"null";
        $idCard=(isset($_GET['idCard'])&&$_GET['idCard']!="null")?$_GET['idCard']:"null";
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?$_GET['regTime']:"down";
        $location=(isset($_GET['location'])&&$_GET['location']!="null")?$_GET['location']:"全国";
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:"null";
        //dd($datas);
        return view("enterprise.serve",compact("datas","counts","serveName","sizeType","size","idCard","regTime","location","job"));

    }
    /**
     * 企业信息详情
     * @return mixed
     */
    public  function servedetail(){
        $enterpriseId=$_GET['id'];
        $id=DB::table("T_U_ENTERPRISEVERIFY")->where("enterpriseid",$enterpriseId)->orderBy("verifytime","desc")->take(1)->pluck("id");
        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
            ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_ENTERPRISE.*","T_U_ENTERPRISEVERIFY.configid")
            ->where("T_U_ENTERPRISE.enterpriseid",$enterpriseId)
            ->where("T_U_ENTERPRISEVERIFY.id",$id)
            ->orderBy("T_U_ENTERPRISE.created_at","desc")
            ->get();
        return view("enterprise.detail",compact("datas"));
    }

    /**
     * 查询企业最新的一条状态信息
     * @return array
     */
    public  function  returnIds(){
        $ids=array();
        $enterpriseids=array();
        $results=DB::table("T_U_ENTERPRISEVERIFY")->select("id","enterpriseid")->orderBy("verifytime","desc")->distinct()->get();
        foreach ($results as $result){
            if(!in_array($result->enterpriseid,$enterpriseids)){
                $enterpriseids[]=$result->enterpriseid;
                $ids[]=$result->id;
            }
        }
        return $ids;
    }

    public function registerEnterprise()
    {
        $error = empty($_GET['error']) ? '' : $_GET['error'];
        $domain1 = DB::table('t_common_domaintype')->where('level',1)->get();
        $domain2 = DB::table('t_common_domaintype')->where('level',2)->get();
        return view('enterprise.register',compact('domain1','domain2','error'));
    }

    public function submitEnterprise(Request $request)
    {
        $data = $request->input();
        foreach($data as $k => $v){
            if(empty($v)){
                switch ($k) {
                    case 'phonenumber':
                        return redirect('/registerenterprise')->withErrors(['error'=> '电话号是空的']);
                        break;
                    case 'password':
                        return redirect('/registerenterprise')->withErrors(['error'=> '密码不能为空']);
                        break;
                    case 'name':
                        return redirect('/registerenterprise')->withErrors(['error'=> '名称不能为空']);
                        break;
                    case 'size':
                        return redirect('/registerenterprise')->withErrors(['error'=> '企业规模不能为空']);
                        break;
                    case 'address':
                        return redirect('/registerenterprise')->withErrors(['error'=> '地址不能为空']);
                        break;
                    case 'industry':
                        return redirect('/registerenterprise')->withErrors(['error'=> '行业不能为空']);
                        break;
                    case 'brief':
                        return redirect('/registerenterprise')->withErrors(['error'=> '描述不能是空的']);
                        break;
                    case 'showimage':
                        return redirect('/registerenterprise')->withErrors(['error'=> '头像不能是空的']);
                        break;
                }
            }
        }
        $isregister = DB::table('t_u_user')->where('phone',$data['phonenumber'])->count();
        if($isregister){
            return redirect('/registerenterprise')->withErrors(['error'=> '该手机号码已经注册']);
        }
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $data['showimage'], $result)){
            $type = $result[2];
            $time = time();
            $new_file = '../../swUpload/images/'.$time.'.'.$type;
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $data['showimage'])))){
                unset($data['showimage']);
                $data['showimage'] = '/images/'.$time.'.'.$type;
            } else {
                return redirect('/registerenterprise')->withErrors(['error'=> '上传头像错误（保存文件失败）']);
            }
        } else{
            return redirect('/registerenterprise')->withErrors(['error'=> '上传头像错误（图像dataurl错误）']);
        }

        DB::beginTransaction();
        try {
            $userid = DB::table("T_U_USER")->insertGetId([
                "phone" => $data['phonenumber'],
                "password" => md5($data['password']),
                "registertime" => date("Y-m-d H:i:s", time()),
                'avatar' => $data['showimage'],
                'nickname' => $data['name'],
                "created_at" => date("Y-m-d H:i:s", time()),
                "updated_at" => date("Y-m-d H:i:s", time()),
            ]);
            $expertid = DB::table('t_u_enterprise')->insertGetId([
                "userid" => $userid,
                'enterprisename' => $data['name'],
                'size' => $data['size'],
                'address' => $data['address'],
                'licenceimage' => $data['showimage'],
                'showimage' => $data['showimage'],
                'brief' => $data['brief'],
                'industry' => $data['industry'],
                "created_at" => date("Y-m-d H:i:s", time()),
                "updated_at" => date("Y-m-d H:i:s", time()),
            ]);
            DB::table('t_u_enterpriseverify')->insert([
                'enterpriseid' => $expertid,
                'configid' => 2,
                'verifytime' =>  date("Y-m-d H:i:s", time()),
            ]);
            if($data['isvip']){
                DB::table("t_c_vipcode")->insert([
                    "phone"=>$data['phonenumber'],
                    "vipcode"=>$data['code'],
                    "starttime"=> date("Y-m-d H:i:s", time()),
                    "endtime"=>date("Y-m-d H:i:s", time()+60*60*24*365),
                    "type"=>$data['livepeople'],
                    "islive"=>1,
                ]);
            }
            DB::table("t_m_systemmessage")->insert([
                "sendid"=>0,
                "receiveid"=>$userid,
                "sendtime"=>date("Y-m-d H:i:s",time()),
                "title"=>"感谢您注册升维网",
                "content"=>"您已成功注册升维网",
                "state"=>0,
                "created_at"=>date("Y-m-d H:i:s",time()),
                "updated_at"=>date("Y-m-d H:i:s",time()),
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        if (!isset($e)) {
            $result = \UserClass::getAccId($userid,$data['phonenumber']);
            if($result){
                return redirect('/registerenterprise')->withErrors(['error'=> '注册成功']);
            } else {
                return redirect('/registerenterprise')->withErrors(['error'=> '注册失败（插入网易云accid失败但是专家数据已录入）']);
            }
        } else {
            return redirect('/registerenterprise')->withErrors(['error'=> '注册失败（插入数据失败但是专家数据已录入）']);
        }
    }


}
