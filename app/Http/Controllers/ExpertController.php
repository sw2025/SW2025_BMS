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
                $datas = $datas->whereIn("configid",[1,3])->paginate(10);
                break;
            case 'wait':
                $datas = $datas->whereIn("configid",[1])->paginate(10);
                break;
            case 'fail':
                $datas = $datas->whereIn("configid",[3])->paginate(10);
                break;
        }
        return view("expert.index",compact("datas",'status'));

    }

    public  function  update(){
        $expertid=$_GET['expertid'];
        $datas=DB::table("T_U_USER")
            ->leftJoin("T_U_EXPERT","T_U_USER.USERID","=","T_U_EXPERT.USERID")
            ->leftJoin("T_U_EXPERTVERIFY","T_U_EXPERT.EXPERTID","=","T_U_EXPERTVERIFY.expertid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_EXPERT.*","T_U_EXPERTVERIFY.configid","T_U_EXPERT.expertid")
            ->where("T_U_EXPERT.expertid",$expertid)
            ->whereRaw('T_U_EXPERTVERIFY.id in (select max(id) from T_U_EXPERTVERIFY group by expertid)')
            ->first();
        return view("expert.update",compact("datas"));
    }

    //
    public  function changeExpert(){
        $array=array();
        $res=DB::table("T_U_EXPERT")
            ->leftJoin("T_U_USER","T_U_USER.userid","=","T_U_EXPERT.userid")
            ->leftJoin("T_U_EXPERTVERIFY","T_U_EXPERT.expertid","=","T_U_EXPERTVERIFY.expertid")
            ->where("T_U_EXPERTVERIFY.expertid",$_POST['expertid'])
            ->orderBy("T_U_EXPERTVERIFY.id")
            ->select("T_U_USER.phone","T_U_EXPERTVERIFY.created_at","T_U_USER.userid")
            ->take(1)
            ->get();
        foreach ($res as $value){
            $mobile=$value->phone;
            $time=$value->created_at;
            $receiveId=$value->userid;
        }
        $result=DB::table("T_U_EXPERTVERIFY")
            ->insert([
                "expertid"=>$_POST['expertid'],
                "configid"=>$_POST['configid'],
                "remark"=>isset($_POST['remark'])?$_POST['remark']:"",
                "verifytime"=>date("Y-m-d H:i:s",time()),
                "updated_at"=>date("Y-m-d H:i:s",time())
            ]);
        if($_POST['configid']==2){
            $count= DB::table('t_u_expertfee')->where('expertid',$_POST['expertid'])->count();
            if(!$count){
                DB::table('t_u_expertfee')->insert([
                    'expertid' => $_POST['expertid'],
                    'fee' => 0,
                    'state' => 0
                ]);
            }
            DB::table("T_M_SYSTEMMESSAGE")->insert([
                "sendid"=>0,
                "receiveid"=>$receiveId,
                "title"=>"专家认证成功",
                "content"=>"您提交的专家认证已经通过",
                "state"=>0,
                "sendtime"=>date("Y-m-d H:i:s",time()),
                "created_at"=>date("Y-m-d H:i:s",time()),
                "updated_at"=>date("Y-m-d H:i:s",time()),
            ]);
            $this->_sendSms($mobile,$time,"expertSuccess");
        }else{
            DB::table("T_M_SYSTEMMESSAGE")->insert([
                "sendid"=>0,
                "receiveid"=>$receiveId,
                "title"=>"专家认证失败",
                "content"=>"您提交的专家认证未通过,请重新提交",
                "state"=>0,
                "sendtime"=>date("Y-m-d H:i:s",time()),
                "created_at"=>date("Y-m-d H:i:s",time()),
                "updated_at"=>date("Y-m-d H:i:s",time()),
            ]);
            $this->_sendSms($mobile,$time,"expertFail");
        }
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

        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:null;
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?explode('-',$_GET['job']):null;
        $location=( isset($_GET['location'])&&$_GET['location']!="全国")?$_GET['location']:null;
        $idCard=(isset($_GET['idCard'])&&$_GET['idCard']!="null")?$_GET['idCard']:null;
        if(!empty($idCard)){
            $number=['首页'=>[1],'非首页'=>[0]];
            $idCard=!empty($idCard)? $number[$idCard]:null;
        }else{
            $idCard=range(0,1);
        }
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?"asc":"desc";

        if(!empty($job) && count($job) == 1 ){
            $jobWhere= array("t_u_expert.domain1" => $job[0]);
        } else {
            $jobWhere=!empty($job)?array("t_u_expert.domain1" => $job[0]):array();
            $domain2 = $job[1];
        }
        $domain2=(isset($domain2))?$domain2:null;

        $locationWhere=!empty($location)?array("address"=>$location):array();
        $data=DB::table("T_U_USER")
            ->leftJoin("T_U_EXPERT","T_U_USER.USERID","=","T_U_EXPERT.USERID")
            ->leftJoin("T_U_EXPERTVERIFY","T_U_EXPERT.EXPERTID","=","T_U_EXPERTVERIFY.expertid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_EXPERT.*","T_U_EXPERTVERIFY.configid","T_U_EXPERTVERIFY.VERIFYTIME","T_U_EXPERT.expertid")
            ->whereRaw('T_U_EXPERTVERIFY.id in (select max(id) from T_U_EXPERTVERIFY group by  T_U_EXPERTVERIFY.expertid)')
            ->where("t_u_expertverify.configid",2)
            ->whereIn("T_U_EXPERT.isfirst",$idCard);
       $count=clone $data;

     if(!empty($serveName)){
         $datas=$data->where("expertname","like","%".$serveName."%")->where("domain2","like","%".$domain2."%")->where($jobWhere)->where($locationWhere)->paginate(10);
         $counts=$count->where("expertname","like","%".$serveName."%")->where("domain2","like","%".$domain2."%")->where($jobWhere)->where($locationWhere)->count();
       }else{
         $datas=$data->where("domain2","like","%".$domain2."%")->where($jobWhere)->where($locationWhere)->orderBy("T_U_expert.expertid",$regTime) ->paginate(10);
         $counts= $count->where("domain2","like","%".$domain2."%")->where($jobWhere)->where($locationWhere)->count();
       }

        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:"null";
        $regTime=(isset($_GET['regTime'])&&$_GET['regTime']!="down")?$_GET['regTime']:"down";
        $location=(isset($_GET['location'])&&$_GET['location']!="null")?$_GET['location']:"全国";
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:"null";

        $idCard=(isset($_GET['idCard'])&&$_GET['idCard']!="null")?$_GET['idCard']:"null";
        $label = DB::table('t_common_domaintype')->get();

        return view("expert.serve",compact("datas","counts","serveName","sizeType","regTime","location","job","label","idCard"));

    }

    /**专家信息维护详情
     * @return mixed
     */
    public  function serveDetail($expertid){
        $data=DB::table("T_U_USER")
            ->leftJoin("T_U_EXPERT","T_U_USER.USERID","=","T_U_EXPERT.USERID")
            ->leftJoin("T_U_EXPERTVERIFY","T_U_EXPERT.EXPERTID","=","T_U_EXPERTVERIFY.expertid")
            ->select("T_U_USER.phone","T_U_USER.created_at","T_U_EXPERT.*","T_U_EXPERTVERIFY.configid","T_U_EXPERTVERIFY.VERIFYTIME","T_U_EXPERT.expertid")
            ->whereRaw('T_U_EXPERTVERIFY.id in (select max(id) from T_U_EXPERTVERIFY group by  T_U_EXPERTVERIFY.expertid)')
            ->where("t_u_expert.expertid",$expertid)
            ->first();

        $result = DB::table('t_u_messagetoexpert')
            ->leftJoin('view_userrole','view_userrole.userid', '=','t_u_messagetoexpert.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.enterpriseid', '=','view_userrole.enterpriseid')
            ->leftJoin('t_u_user','t_u_messagetoexpert.userid' ,'=' ,'t_u_user.userid')
            ->leftJoin('t_u_expert','t_u_expert.expertid' ,'=' ,'view_userrole.expertid')
            ->where('t_u_messagetoexpert.expertid',$expertid)
            ->where('isdelete',0)
            ->get();
        return view("expert.detail",compact('data','result'));
    }

    /**
     * 专家评论信息维护删除
     * @return mixed
     */

    public function deleteExpertContent()
    {
        $id = $_GET['id'];
        $expertid=$_GET['expertid'];
        DB::table("t_u_messagetoexpert")
            ->where('id',$id)
            ->update([
                'isdelete' => 1,
            ]);

        return redirect("/serve_expertDet/$expertid");
    }

    /**专家信息维护设置首页
     * @return mixed
     */
    public  function changeHomePage(){
        //$array=array();

            $result=DB::table("T_U_EXPERT")
                ->where("expertid",$_POST['expertid'])
                ->update([
                    "isfirst"=> $_POST['isfirst'],
                    "order"=>empty($_POST['order']) ? 0: $_POST['order']
                ]);
        if($result){
            $array['code']="success";
            return $array;
        }else{
            $array['code']="error";
            return $array;
        }
    }
    /**专家信息维护设置等级
     * @return mixed
     */
    public function changeGrade(){

            //$array=array();
            $result=DB::table("T_U_EXPERT")
                ->where("expertid",$_POST['expertid'])
                ->update([
                    //"isfirst"=> $_POST['isfirst'],
                    "level"=>empty($_POST['level']) ? 0: $_POST['level']
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
     * 后台手工注册专家
     */
  /*  public function registerExpert()
    {
        return view('expert.register');
    }*/
    public function registerExpert2()
    {
        $error = empty($_GET['error']) ? '' : $_GET['error'];
        $domain1 = DB::table('t_common_domaintype')->where('level',1)->get();
        $domain2 = DB::table('t_i_investment')->where('type',1)->get();
        $domain3 = DB::table('t_i_investment')->where('type',2)->get();
        return view('expert.register2',compact('domain1','domain2','domain3','error'));
    }

    public function submitExpert(Request $request)
    {
        $data = $request->input();
        foreach($data as $k => $v){
            if(empty($v)){
                switch ($k) {
                    case 'phonenumber':
                        return redirect('/registerexpert2')->withErrors(['error'=> '电话号是空的']);
                        break;
                    case 'password':
                        return redirect('/registerexpert2')->withErrors(['error'=> '密码不能为空']);
                        break;
                    case 'name':
                        return redirect('/registerexpert2')->withErrors(['error'=> '名称不能为空']);
                        break;
                    case 'category':
                        return redirect('/registerexpert2')->withErrors(['error'=> '分类不能为空']);
                        break;
                    case 'address':
                        return redirect('/registerexpert2')->withErrors(['error'=> '地址不能为空']);
                        break;
                    case 'domain1':
                        return redirect('/registerexpert2')->withErrors(['error'=> '领域不能为空']);
                        break;
                    case 'domain2':
                        return redirect('/registerexpert2')->withErrors(['error'=> '领域不能为空']);
                        break;
                    case 'brief':
                        return redirect('/registerexpert2')->withErrors(['error'=> '描述不能是空的']);
                        break;
                    case 'showimage':
                        return redirect('/registerexpert2')->withErrors(['error'=> '头像不能是空的']);
                        break;
                }
            }
        }
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $data['showimage'], $result)){
            $type = $result[2];
            $time = time();
            $new_file = '../../swUpload/images/'.$time.'.'.$type;
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $data['showimage'])))){
                unset($data['showimage']);
                $data['showimage'] = '/images/'.$time.'.'.$type;
            } else {
                return redirect('/registerexpert2')->withErrors(['error'=> '上传头像错误（保存文件失败）']);
            }
        } else{
            return redirect('/registerexpert2')->withErrors(['error'=> '上传头像错误（图像dataurl错误）']);
        }
        $isregister = DB::table('t_u_user')->where('phone',$data['phonenumber'])->count();
        if($isregister){
            return redirect('/registerexpert2')->withErrors(['error'=> '该手机号码已经注册']);
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
            $expertid = DB::table('t_u_expert')->insertGetId([
                "userid" => $userid,
                'expertname' => $data['name'],
                'category' => '专家',
                'address' => $data['address'],
                'licenceimage' => $data['showimage'],
                'showimage' => $data['showimage'],
                'brief' => $data['brief'],
                'domain1' => $data['domain1'],
                'domain2' => $data['domain2'],
                'preference' => $data['preference'],
                'workexperience' => $data['preference'],
                'job' => $data['job'],
                'worklife' => $data['worklife'],
                'edubg' => $data['edubg'],
                'level' => $data['level'],
                'isfirst' => $data['isfirst'],
                'order' => $data['order'],
                "created_at" => date("Y-m-d H:i:s", time()),
                "updated_at" => date("Y-m-d H:i:s", time()),
            ]);
            DB::table('t_u_expertverify')->insert([
                'expertid' => $expertid,
                'configid' => 2,
                'verifytime' =>  date("Y-m-d H:i:s", time()),
            ]);
            DB::table('t_u_expertfee')->insert([
                'expertid' => $expertid,
                'fee' => 0,
                'state' => 0,
                'linefee' => 1000
            ]);
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
                return redirect('/registerexpert2')->withErrors(['error'=> '注册成功']);
            } else {
                return redirect('/registerexpert2')->withErrors(['error'=> '注册失败（插入网易云accid失败但是专家数据已录入）']);
            }
        } else {
            return redirect('/registerexpert2')->withErrors(['error'=> '注册失败（插入数据失败但是专家数据已录入）']);
        }
    }



}
