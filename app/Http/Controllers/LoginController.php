<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller{
    /**
     * 登录页
     * @return mixed
     */
    public  function  index(){
        return view("login.index");
    }
    
    /**
     * 登录验证
     * @return mixed
     */
    public function login(){
        $phone=$_POST['phone'];
        $passWord=$_POST['passWord'];
        $datas= \UserClass::LoginVerify($phone,$passWord);

        return $datas;
    }

    /**
     * 退出
     * @return mixed
     */
    public function quit(Request $request){

        $request->session()->flush();
        $result=array();
        if(session("userId")){
            $result['code']="error";
        }else{
            $result['code']="success";
        }
        return $result;
    }
    /**
     * 修改密码
     * @return mixed
     */
    public  function  changePwd(){
        return view("login.changePwd");
    }

    /**
     * 保存修改的密码
     * @param Request $request
     * @return mixed
     */
    public function savePwd(Request $request){
        $password=md5($_POST['password']);
        $userId=session("userId");
        $result=DB::table("T_RBAC_USER")->where("userId",$userId)->update([
            "password"=>$password,
            "updated_at"=>date("Y-m-d H:i:s",time())
        ]);
        if($result){
            $request->session()->flush();
            return redirect("/");
        }else{
            return redirect()->back()->withInput()->with("msg","修改失败!");
        }
    }

    /**
     * 操作人员列表
     * @return mixed
     */
    public  function operatePeople(){
        $datas=DB::table("T_RBAC_USER")->leftJoin("T_RBAC_USERROLE","T_RBAC_USER.userid","=","T_RBAC_USERROLE.userid")
                    ->leftJoin("T_RBAC_ROLE","T_RBAC_USERROLE.roleid","=","T_RBAC_ROLE.roleid")
                    ->where("T_RBAC_USER.state",0)
                    ->paginate(20);
        return view("login.operatePeople",compact("datas"));
    }

    /**
     * 添加人员
     * @return mixed
     */
    public function addOperator(){
       $datas=\UserClass::getRole();
        return view("login.addOperate",compact("datas"));
    }

    /**
     * 保存
     * @return mixed
     */
    public function  addOperatorSave(){
        $counts=DB::table("T_RBAC_USER")->where("state",0)->where("phone",$_POST['telephone'])->count();
        if(!$counts){
            return redirect()->back()->withInput()->with("msg","该手机号已存在!");
        }
        if(!preg_match("/^1[34578]{1}\d{9}$/",$_POST['telephone'])){
            return redirect()->back()->withInput()->with("msg","手机号格式填写错误!");
        }
        $userId=DB::table("T_RBAC_USER")->insertGetId([
            "name"=>$_POST['name'],
            "phone"=>$_POST['telephone'],
            "password"=>md5("sw2025"),
            "department"=>"技术部",
            "position"=>$_POST['job'],
            "created_at"=>date("Y-m-d H:i:s",time()),
            "updated_at"=>date("Y-m-d H:i:s",time()),
        ]);
        if($userId){
            $result=DB::table("T_RBAC_USERROLE")->insert([
                "userid"=>$userId,
                "roleid"=>$_POST['selector'],
                "created_at"=>date("Y-m-d H:i:s",time()),
                "updated_at"=>date("Y-m-d H:i:s",time()),
            ]);
            if($result){
                return redirect("/operate_people");
            }else{
                return redirect()->back()->withInput()->with("msg","添加失败!");
            }
        }else{
            return redirect()->back()->withInput()->with("msg","添加失败!");
        }
    }

    /**
     * 编辑人员
     * @param $userId
     * @return mixed
     */
    public  function  editOperator(){
        session(["login_url"=>$_SERVER["HTTP_REFERER"]]);
        $datas=DB::table("T_RBAC_USER")->leftJoin("T_RBAC_USERROLE","T_RBAC_USER.userid","=","T_RBAC_USERROLE.userid")
            ->leftJoin("T_RBAC_ROLE","T_RBAC_USERROLE.roleid","=","T_RBAC_ROLE.roleid")
            ->where("T_RBAC_USER.userid",$_GET['userId'])
            ->get();
        $roles=\UserClass::getRole();
        return view("login.editOperator",compact('datas',"roles"));
    }
    /**
     * 保存
     * @return mixed
     */
    public  function  editOperatorSave(){
        $userId=$_POST['userId'];
        $counts=DB::table("T_RBAC_USER")->where("state",0)->where("userid","<>",$userId)->where("phone",$_POST['telephone'])->count();
        if($counts){
            return redirect()->back()->withInput()->with("msg","该手机号已存在!");
        }
        if(!preg_match("/^1[34578]{1}\d{9}$/",$_POST['telephone'])){
            return redirect()->back()->withInput()->with("msg","手机号格式填写错误!");
        }
        $datas=DB::table("T_RBAC_USER")->where("userid",$userId)->update([
            "name"=>$_POST['name'],
            "phone"=>$_POST['telephone'],
            "position"=>$_POST['job'],
            "updated_at"=>date("Y-m-d H:i:s",time()),
        ]);
        if($datas){
            $results=DB::table("T_RBAC_USERROLE")->where("userid",$userId)->update([
                "roleid"=>$_POST['selector'],
                "updated_at"=>date("Y-m-d H:i:s",time()),
            ]);
            if($results){
                echo "<script>location.href='".session('login_url')."';</script>";
            }else{
                return redirect()->back()->withInput()->with("msg","修改失败!");
            }
        }else{
            return redirect()->back()->withInput()->with("msg","修改失败!");
        }
    }

    /**删除人员
     * @param $userId
     * @return mixed
     */
    public function  deleteOperator(){
        $results=DB::table("T_RBAC_USER")->where("userid",$_GET['userId'])->update([
            "state"=>1,
            "updated_at"=>date("Y-m-d H:i:s",time()),
        ]);
       return redirect("/operate_people");
    }

    /**
     * 重置密码
     * @param $userId
     * @return mixed
     */
    public  function  resetOperator(Request $request){
        $results=DB::table("T_RBAC_USER")->where("userid",$_GET['userId'])->update([
            "password"=>md5("sw2025"),
            "updated_at"=>date("Y-m-d H:i:s",time()),
        ]);
        $request->session()->flush();
        return redirect("/");
    }

    
}
