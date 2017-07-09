<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * 角色列表
     * @return mixed
     */
    public function index(){
        $datas=DB::table("T_RBAC_ROLE")->where("state",0)->paginate(1);
        return view("role.index",compact("datas"));
    }

    /**查看权限
     * @param $roleId
     * @return mixed
     */
        public  function  lookRight(){
            $roleId=$_GET['roleId'];
        $auths1=\UserClass::getAuth($roleId,1);
        $auths2=\UserClass::getAuth($roleId,2);
        $roleName=DB::table("T_RBAC_ROLE")->where("roleid",$roleId)->where("state",0)->pluck("rolename");
        return view("role.lookRight",compact("auths1","auths2","roleName"));
        
    }

    /**添加角色
     * @return mixed
     */
    public  function addRole(){
        $auths1=\UserClass::allAuth(1);
        $auths2=\UserClass::allAuth(2);
        return view("role.addRole",compact("auths1","auths2"));
    }

    /**保存
     * @return mixed
     */
    public  function addRoleSave(){
        $name=$_POST['name'];
        $counts=DB::table("T_RBAC_ROLE")->where("rolename",$name)->where("state",0)->count();
        if($counts){
            return redirect()->back()->withInput()->with("msg","该角色已经存在!");
        }
        $roleId=DB::table("T_RBAC_ROLE")->insertGetId([
            "rolename"=>$name,
            "created_at"=>date("Y-m-d H:i:s",time()),
            "updated_at"=>date("Y-m-d H:i:s",time())
        ]);
        if($roleId){
            $auths=isset($_POST['auth'])? $_POST['auth']:"";
            if(!empty($auths)){
                $code=$this->insertRoleAuth($roleId,$auths);
                if($code==200){
                    return redirect("/role");
                }else{
                    return redirect()->back()->withInput()->with("msg","添加失败!");
                }
            }else{
                return redirect("/role");
            }
        }else{
            return redirect()->back()->withInput()->with("msg","添加失败!");
        }
    }

    /**修改角色
     * @param $roleId
     * @return mixed
     */
    public  function  editRole(){
        $roleId=$_GET['roleId'];
        session(["role_url"=>$_SERVER["HTTP_REFERER"]]);
        $auths1=\UserClass::allAuth(1);
        $auths2=\UserClass::allAuth(2);
        $auths=DB::table("T_RBAC_ROLEPERMISSION")->where("roleid",$roleId)->lists("permissionid");
        $datas=DB::table("T_RBAC_ROLE")->where("roleid",$roleId)->where("state",0)->get();
        return view("role.editRole",compact("auths1","auths2","auths","datas"));
    }

    /**保存修改信息
     * @return mixed
     */
    public function  editRoleSave(){
        $roleId=$_POST['roleId'];
        $name=$_POST['name'];
        $counts=DB::table("T_RBAC_ROLE")->where("rolename",$name)->where("state",0)->where("roleid","<>",$roleId)->count();
        if($counts){
            return redirect()->back()->withInput()->with("msg","该角色已经存在!");
        }
        $res=DB::table("T_RBAC_ROLE")->where("roleid",$roleId)->update([
            "rolename"=>$name,
            "updated_at"=>date("Y-m-d H:i:s",time())
        ]);
        if($res){
            $auths=isset($_POST['auth'])?$_POST['auth']:"";

            if(!empty($auths)){
                $code=$this->editRoleAuth($roleId,$auths);
                if($code==200){
                    echo "<script>location.href='".session('role_url')."';</script>";
                }else{
                    return redirect()->back()->withInput()->with("msg","修改失败!");
                }
            }else{
                echo "<script>location.href='".session('role_url')."';</script>";
            }
        }else{
            return redirect()->back()->withInput()->with("msg","修改失败!");
        }
    }

    public  function deleteRole(){
        $roleId=$_GET['roleId'];
        $counts=DB::table("T_RBAC_USERROLE")->where("roleid",$roleId)->count();
        if($counts){
            return redirect()->back()->with("msg","该角色存在用户,暂不能删除!");
        }
        $res=DB::table("T_RBAC_ROLE")->where("roleid",$roleId)->update([
            "state"=>1,
            "updated_at"=>date("Y-m-d H:i:s",time()),
        ]);
        if($res){
           $result=DB::table("T_RBAC_ROLEPERMISSION")->where("roleid",$roleId)->delete();
            if($result){
               return redirect("/role");
            }else{
                return redirect()->back()->with("msg","删除失败!");
            }
        }else{
            return redirect()->back()->with("msg","删除失败!");
        }

    }
    

    /**插入角色拥有的权限
     * @param $roleId
     * @param $auths
     * @return int
     */
    public  function  insertRoleAuth($roleId,$auths){
        $array=array();
        foreach ($auths as $auth){
            $result=DB::table("T_RBAC_ROLEPERMISSION")->insert([
                "roleid"=>$roleId,
                "permissionid"=>$auth,
                "created_at"=>date("Y-m-d H:i:s",time()),
                "updated_at"=>date("Y-m-d H:i:s",time())
            ]);
        }
        return $array['code']=200;
    }

    /**修改角色权限
     * @param $roleId
     * @param $auths
     * @return int
     */
    public  function  editRoleAuth($roleId,$auths){
        $array=array();
        $deleteRes=DB::table("T_RBAC_ROLEPERMISSION")->where("roleid",$roleId)->delete();
        if($deleteRes){
            foreach ($auths as $auth) {
                $result = DB::table("T_RBAC_ROLEPERMISSION")->insert([
                    "roleid" => $roleId,
                    "permissionid" => $auth,
                    "created_at" => date("Y-m-d H:i:s", time()),
                    "updated_at" => date("Y-m-d H:i:s", time())
                ]);
            }
            return $array['code']=200;
        }else{
            return $array['code']=400;
        }
    }

}
