<?php
    class  UserClass extends BaseClass{
        /**
         * 登录验证
         * @param $userName
         * @param $passWord
         * @return array
         */
        public static  function  LoginVerify($phone,$passWord){
            $array=array();
            $nameCount=DB::table("T_RBAC_USER")->where("phone",$phone)->count();
            if($nameCount){
                $counts=DB::table("T_RBAC_USER")
                    ->leftjoin("T_RBAC_USERROLE",'T_RBAC_USER.USERID','=','T_RBAC_USERROLE.USERID')
                    ->where("phone",$phone)->where("password",md5($passWord))
                    ->get();

                if($counts){
                    $str = DB::table('T_RBAC_ROLEPERMISSION')
                        ->leftjoin("T_RBAC_PERMISSION",'T_RBAC_ROLEPERMISSION.PERMISSIONID','=','T_RBAC_PERMISSION.PERMISSIONID')
                        ->select("url",'T_RBAC_PERMISSION.permissionid')
                        ->where('roleid',$counts[0]->roleid)
                        ->whereIn('level',[2,3])
                        ->get();
                    $arr = [];
                    foreach($str as $v){
                        $a = explode(',',$v->url);
                        $arr = array_merge($arr,$a);
                    }
                    if(in_array('/change_pwd',$arr)){
                        array_push($arr,"/save_pwd");
                    }
                    if(in_array('/operate_people',$arr)){
                        array_push($arr,"/edit_operator",'/edit_operatorSave',"/add_operator",'/add_operatorSave','/delete_operator',"/reset_operator","/look_right");
                    }
                    if(in_array('/role',$arr)){
                        array_push($arr,"/edit_roleSave","/edit_role","/look_right","/delete_role","/add_role",'/add_roleSave');
                    }
                    if(in_array('/modular',$arr)){
                        array_push($arr,'/addModular','/deleteEnterprise','/zhanshi','/baocun');
                    }
                    if(in_array('/cert_enterprise',$arr)){
                        array_push($arr,'/details_enterprise','/changeEnterprise');
                    }
                    if(in_array('/cert_expert',$arr)){
                        array_push($arr,'/details_expert','/changeExpert');
                    }
                    if(in_array('/cert_supply',$arr)){
                        array_push($arr,'/details_supply','/changeSupply');
                    }
                    if(in_array('/cert_work',$arr)){
                        array_push($arr,'/details_work','/changeEvent');
                    }
                    if(in_array('/cert_video',$arr)){
                        array_push($arr,'/details_video','/changeVideo');
                    }

                    if(in_array('/cert_recharge',$arr)){
                        array_push($arr,'/details_recharge','/changeRecharge');
                    }

                    if(in_array('/supplyShow',$arr)){
                        array_push($arr,'/details_show','/changeShow','/getRemark','/showSelectExpert','/pushExpert');
                    }


                    if(in_array('/serve_enterprise',$arr)){
                        array_push($arr,'/serve_enterpriseDet');
                    }
                    if(in_array('/serve_expert',$arr)){
                        array_push($arr,'/serve_expertDet','/changeHomePage','/deleteExpertContent','/changeGrade');
                    }
                    if(in_array('/serve_supply',$arr)){
                        array_push($arr,'/serve_supplyDet','/deleteSupply','/deleteSupplyContent','/needPushSelect','/selectEnterprise');
                    }
                    if(in_array('/serve_work',$arr)){
                        array_push($arr,'/serve_workDet','/deleteWork');
                    }
                    if(in_array('/serve_video',$arr)){
                        array_push($arr,'/serve_videoDet','/deleteVideo');
                    }
                    if(in_array('/serve_recharge',$arr)){
                        array_push($arr,'/serve_rechargeDet');
                    }
                    if(in_array('/member',$arr)){
                        array_push($arr,'/edit_member','/add_member','/dealeditmember','dealaddmember','/deletemember');
                    }
                    //$str = serialize($str);
                    $str = \Illuminate\Support\Facades\Crypt::encrypt($arr);

                    session(["str"=>$str]);

                    $array['code']="success";
                    session(["userId"=>$counts[0]->userid]);
                    session(["name"=>$counts[0]->name]);
                    $array['userId']=$counts[0]->userid;
                    $array['name']=$counts[0]->name;
                }else{
                    $array['code']="passWord";
                    $array['msg']="密码错误!";
                }
            }else{
                $array['code']="phone";
                $array['msg']="账号错误!";
            }
            return $array;
        }

        /**
         * 获取角色信息
         * @return mixed
         */
        public  static  function  getRole(){
            $datas=DB::table("T_RBAC_ROLE")->where("state",0)->get();
            return $datas;
        }

        /**根据角色和level获取权限
         * @param $roleId
         * @param $level
         * @return mixed
         */
        public  static  function  getAuth($roleId,$level){
            $auth=DB::table("T_RBAC_ROLEPERMISSION")
                ->leftJoin("T_RBAC_PERMISSION","T_RBAC_ROLEPERMISSION.permissionid","=","T_RBAC_PERMISSION.permissionid")
                ->where("roleid",$roleId)
                ->where("level",$level)
                ->get();
            return $auth;
        }

        /**获取所有的一级，二级权限
         * @param $level
         * @return mixed
         */
        public  static  function  allAuth($level){
            $auth=DB::table("T_RBAC_PERMISSION")->where("level",$level)->get();
            return $auth;
        }

        /**网易云信accid和token
         * @param $userId
         * @param $nickname
         * @throws Exception
         */
        public static  function getAccId($userId,$phone){
            $AppKey = env('AppKey');
            $AppSecret = env('AppSecret');
            $serverApi = new \ServerApiClass($AppKey, $AppSecret);
            $accid = "sw_" . $userId;
            $name = substr_replace($phone,'****',3,4);
            $props="";
            $icon="/avatar.jpg";
            $token="";
            $result = $serverApi->createUserId($accid, $name,$props,$icon,$token);
            if ($result['code'] == 200) {
                try {
                    DB::table("t_u_user")->where("userid", $userId)->update([
                        "accid" => $accid,
                        "imtoken" => $result['info']['token'],
                    ]);
                } catch (Exception $e) {
                    throw $e;
                }
                if(!isset($e)){
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }
    }
?>