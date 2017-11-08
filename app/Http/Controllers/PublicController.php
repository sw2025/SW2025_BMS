<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;

class PublicController extends Controller
{
    /**获取审核拒绝的原因
     * @return mixed
     */
    public function getRemark(){
        $type=$_POST['type'];
        $id=$_POST['id'];
        switch($type){
            case "enterprise":
                $remark=DB::table("T_U_ENTERPRISEVERIFY")->where("enterpriseid",$id)->orderBy("id","desc")->take(1)->pluck('remark');
            break;
            case "expert":
                $remark=DB::table("T_U_EXPERTVERIFY")->where("expertid",$id)->orderBy("id","desc")->take(1)->pluck('remark');
            break;
            case "video":
                $remark=DB::table("T_C_CONSULTVERIFY")->where("consultid",$id)->orderBy("id","desc")->take(1)->pluck('remark');
            break;
            case "supply":
                $remark=DB::table("T_N_NEEDVERIFY")->where("needid",$id)->orderBy("id","desc")->take(1)->pluck('remark');
            break;
            case "work":
                $remark=DB::table("T_E_EVENTTVERIFY")->where("eventid",$id)->orderBy("id","desc")->take(1)->pluck('remark');
            break;
            case "recharge":
                $remark=DB::table("T_U_BILL")->where("id",$id)->pluck('remark');
            break;
        }
        return $remark ;
    }

    /**推送专家的列表
     * @return mixed
     */
    public  function  selectExpert(){
        if($_POST['label']=="work"){
            $userId=DB::table("T_E_EVENT")->where("eventid",$_POST['eventId'])->pluck("userid");
        }else{
            $userId=DB::table("T_C_CONSULT")->where("consultid",$_POST['consultId'])->pluck("userid");
        }
        $expertids=DB::table("T_U_EXPERT")->where("userid",$userId)->pluck("expertid");
        $types=explode("/",$_POST['type']);
        $expert=DB::table("T_U_EXPERT")
            ->leftJoin("T_U_EXPERTVERIFY","T_U_EXPERTVERIFY.expertid","=","T_U_EXPERT.expertid")
            ->select("T_U_EXPERT.*","T_U_EXPERTVERIFY.configid")
            ->whereRaw('T_U_EXPERTVERIFY.id in (select max(id) from T_U_EXPERTVERIFY group by expertid)')
            ->where("domain1",$types[0])
            ->where("domain2","like","%".$types[1]."%")
            ->where("configid",2);
        $selectExperts=clone $expert;
        if($expertids){
            $experts=$selectExperts->where("T_U_EXPERT.expertid","<>",$expertids) ->paginate(9);
        }else{
            $experts=$selectExperts->paginate(9);
        }
        foreach ($experts as $expert){
            $newDomian2=explode(",",$expert->domain2);
            $expert->domain2=$newDomian2;
        }
        return $experts;

    }

    /**返回已指定的专家
     * @return array
     */
    public function  returnCountExpert(){
        $res=array();
        $expertids=array();
        $consultId=$_POST['consultId'];
        $counts=DB::table("T_C_CONSULTRESPONSE")->where("consultid",$consultId)->count();
        $expertIds=DB::table("T_C_CONSULTRESPONSE")->select("expertid")->where("consultid",$consultId)->get();
        if($counts){
            foreach ($expertIds as $value){
                if(!in_array($value->expertid,$expertids)){
                    $expertids[]=$value->expertid;
                }
            }
            $res['expertids']=implode(",",$expertids);
            $res['expertCount']=intval(env("countExpert"))-$counts;
        }else{
            $res['expertCount']=intval(env("countExpert"));
            $res['expertids']=123;
        }
        return $res;
    }

    public  function pushSelect(){
        $expertids=array();
        $expertSelects=explode(",",$_POST['expertSelect']);
        $expertSelect=array_filter($expertSelects);
        $expertIds=DB::table("T_C_CONSULTRESPONSE")->select("expertid")->where("consultid",$_POST['consultId'])->get();
        foreach ($expertIds as $value){
            if(!in_array($value->expertid,$expertids)){
                $expertids[]=$value->expertid;
            }
        }
        try{
            foreach ($expertSelect as $value){
                if(!in_array($value,$expertids)){
                    $results=DB::table("T_C_CONSULTRESPONSE")->insert([
                        "consultid"=>$_POST['consultId'],
                        "expertid"=>$value,
                        "responsetime"=>date("Y-m-d H:i:s",time()),
                        "state"=>1,
                        "remark"=>"",
                        "created_at"=>date("Y-m-d H:i:s",time()),
                        "updated_at"=>date("Y-m-d H:i:s",time()),
                    ]);
                }
            }
            DB::table("T_C_CONSULTVERIFY")->insert([
                "consultid"=>$_POST['consultId'],
                "configid"=>4,
                "verifytime"=>date("Y-m-d H:i:s",time()),
                "remark"=>"",
                "created_at"=>date("Y-m-d H:i:s",time()),
                "updated_at"=>date("Y-m-d H:i:s",time()),
            ]);
        }catch(Exception $e){
            throw $e;
        }
        if(!isset($e)){
            return "success";
        }else{
            return "error";
        }


    }

    /**返回已指定的专家
     * @return array
     */
    public function  eventCountExpert(){
        $res=array();
        $expertids=array();
        $eventtId=$_POST['eventId'];
        $counts=DB::table("T_E_EVENTRESPONSE")->where("eventid",$eventtId)->count();
        $expertIds=DB::table("T_E_EVENTRESPONSE")->select("expertid")->where("eventid",$eventtId)->get();
        if($counts){
            foreach ($expertIds as $value){
                if(!in_array($value->expertid,$expertids)){
                    $expertids[]=$value->expertid;
                }
            }
            $res['expertids']=implode(",",$expertids);
            $res['expertCount']=intval(env("countExpert"))-$counts;
        }else{
            $res['expertCount']=intval(env("countExpert"));
            $res['expertids']=0;
        }
        return $res;
    }

    public  function eventPushSelect(){
        $expertids=array();
        $expertSelects=explode(",",$_POST['expertSelect']);
        $expertSelect=array_filter($expertSelects);
        $expertIds=DB::table("T_E_EVENTRESPONSE")->select("expertid")->where("eventid",$_POST['eventId'])->get();
        foreach ($expertIds as $value){
            if(!in_array($value->expertid,$expertids)){
                $expertids[]=$value->expertid;
            }
        }
        try{
            foreach ($expertSelect as $value) {
                if (!in_array($value, $expertids)) {
                    DB::table("T_E_EVENTRESPONSE")->insert([
                        "eventid" => $_POST['eventId'],
                        "expertid" => $value,
                        "responsetime" => date("Y-m-d H:i:s", time()),
                        "state" => 1,
                        "remark" => "",
                        "created_at" => date("Y-m-d H:i:s", time()),
                        "updated_at" => date("Y-m-d H:i:s", time()),
                    ]);
                }
            }
                $res=DB::table("T_E_EVENTVERIFY")->insert([
                    "eventid"=>$_POST['eventId'],
                    "configid"=>4,
                    "verifytime"=>date("Y-m-d H:i:s",time()),
                    "remark"=>"",
                    "created_at"=>date("Y-m-d H:i:s",time()),
                    "updated_at"=>date("Y-m-d H:i:s",time()),
                ]);
        }catch(Exception $e){
            throw $e;
        }
        if(!isset($e)){
            return "success";
        }else{
            return "error";
        }

    }

    /**推送企业的列表
     * @return mixed
     */
    public  function  selectEnterprise(){
        $needId = $_POST['needId'];
        $userId = DB::table('T_N_NEED')->where('needid',$needId)->first()->userid;
        $pushNeedUserId =array();
        $pushNeed = DB::table('T_N_PUSHNEED')->where('needid',$needId)->get();
        if($pushNeed){
            foreach ($pushNeed as $value){
                $pushNeedUserId[]=$value->userid;
            }
        }

        $expert =DB::table("T_U_USER")
            ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
            ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
            ->leftJoin("T_N_PUSHNEED","T_U_USER.userid","=","T_N_PUSHNEED.userid")
            ->whereRaw('T_U_ENTERPRISEVERIFY.id in (select max(id) from T_U_ENTERPRISEVERIFY group by  T_U_ENTERPRISEVERIFY.enterpriseid)')
            ->where("configid",3)
            ->where('T_U_USER.userid','<>',$userId)
            ->whereNotIn('t_u_user.userid',$pushNeedUserId)
            ->select('t_u_user.userid','T_U_ENTERPRISE.enterprisename','T_U_ENTERPRISE.enterpriseid','T_U_ENTERPRISE.showimage','T_U_ENTERPRISE.industry');
        $selectExperts=clone $expert;
        $experts=$selectExperts->paginate(9);
        return $experts;
    }

    public  function needPushSelect(){
        $expertids=array();
        $enterpriseSelects=explode(",",$_POST['expertSelect']);
        $enterpriseSelect=array_filter($enterpriseSelects);
        try{
            foreach ($enterpriseSelect as $value) {
                if (!in_array($value, $expertids)) {
                    DB::table("T_N_PUSHNEED")->insert([
                        "userid" => $value,
                        "needid" => $_POST['needId'],
                        "created_at" => date("Y-m-d H:i:s", time()),
                        "updated_at" => date("Y-m-d H:i:s", time()),
                    ]);
                }
            }
        }catch(Exception $e){
            throw $e;
        }
        if(!isset($e)){
            return "success";
        }else{
            return "error";
        }
    }
}
