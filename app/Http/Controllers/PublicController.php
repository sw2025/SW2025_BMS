<?php

namespace App\Http\Controllers;

use Faker\Provider\Image;
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
        $data = DB::table('T_N_NEED')
                ->select('T_N_NEED.userid','T_N_NEED.needtype')
                ->where('needid',$needId)
                ->first();
        $confid=DB::table("T_N_NEEDVERIFY")
            ->leftJoin('T_N_NEED','T_N_NEEDVERIFY.needid','=','T_N_NEED.needid')
            ->whereRaw('T_N_NEEDVERIFY.id in (select max(id) from T_N_NEEDVERIFY group by  T_N_NEEDVERIFY.needid)')
            ->where('T_N_NEEDVERIFY.needid',$needId)
            ->first()->configid;

        if($confid==1){
            DB::table('T_N_NEEDVERIFY')->insert([
                'needid'     =>  $needId,
                "configid"   =>  3,
                'verifytime' =>  date('Y-m-d H:i:s',time()),
                "remark"     =>  !empty($datas['remark'])?$datas['remark']:"",
                "updated_at" =>  date("Y-m-d H:i:s",time()),
                "created_at" =>  date("Y-m-d H:i:s",time())
            ]);
        }
        $userId =  $data->userid;
        $needtype = $data->needtype;
        $pushNeedUserId =array();
        $pushNeed = DB::table('T_N_PUSHNEED')->where('needid',$needId)->get();
        if($pushNeed){
            foreach ($pushNeed as $value){
                $pushNeedUserId[]=$value->userid;
            }
        }
        if($needtype == '专家'){
            $enterprise =DB::table("T_U_USER")
                ->leftJoin("T_U_ENTERPRISE","T_U_USER.userid","=","T_U_ENTERPRISE.userid")
                ->leftJoin("T_U_ENTERPRISEVERIFY","T_U_ENTERPRISE.enterpriseid","=","T_U_ENTERPRISEVERIFY.enterpriseid")
                ->leftJoin("T_N_PUSHNEED","T_U_USER.userid","=","T_N_PUSHNEED.userid")
                ->whereRaw('T_U_ENTERPRISEVERIFY.id in (select max(id) from T_U_ENTERPRISEVERIFY group by  T_U_ENTERPRISEVERIFY.enterpriseid)')
                ->where("T_U_ENTERPRISEVERIFY.configid",3)
                ->where('T_U_USER.userid','<>',$userId)
                ->whereNotIn('t_u_user.userid',$pushNeedUserId)
                ->select('t_u_user.userid','T_U_ENTERPRISE.enterprisename','T_U_ENTERPRISE.enterpriseid','T_U_ENTERPRISE.showimage','T_U_ENTERPRISE.industry');
        }else{
            $enterprise =DB::table("T_U_USER")
                ->leftJoin("T_U_EXPERT","T_U_USER.userid","=","T_U_EXPERT.userid")
                ->leftJoin("T_U_EXPERTVERIFY","T_U_EXPERT.expertid","=","T_U_EXPERTVERIFY.expertid")
                ->leftJoin("T_N_PUSHNEED","T_U_USER.userid","=","T_N_PUSHNEED.userid")
                ->whereRaw('T_U_EXPERTVERIFY.id in (select max(id) from T_U_EXPERTVERIFY group by  T_U_EXPERTVERIFY.expertid)')
                ->where("T_U_EXPERTVERIFY.configid",2)
                ->where('T_U_USER.userid','<>',$userId)
                ->whereNotIn('t_u_user.userid',$pushNeedUserId)
                ->select('t_u_user.userid','T_U_EXPERT.expertname','T_U_EXPERT.expertid','T_U_EXPERT.showimage','T_U_EXPERT.domain1','T_U_EXPERT.domain2');
        }

        $selectExperts=clone $enterprise;
        $experts=$selectExperts->paginate(46);
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

    public function changeAvatar(Request $request)
    {
        // 声明路径名
        $destinationPath = 'uploads/';
        // 取到图片
        $file = $request->file('avatar');
        dd($request->input());
        // 验证
        $input = array('image' => $file);
        $rules = array(
            'image' => 'image'
        );
        $validator = \Validator::make($input, $rules);
        if ( $validator->fails() ) {
            return \Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        // 获得图片的名称 为了保证不重复 我们加上userid和time
        $file_name = \Auth::user()->id . '_' . time() . $file->getClientOriginalName();
        // 执行move方法
        $file->move($destinationPath, $file_name);
        // 裁剪图片 生成400的缩略图
        Image::make($destinationPath . $file_name)->fit(500)->save();

        return \Response::json([
            'success' => true,
            'avatar' => asset($destinationPath.$file_name),
        ]);
    }

    public function cropAvatar(Request $request)
    {
//        array:6 [▼
//  "_token" => "PB7DoFssm6vTQGsDREbpm2zZppSb80BdfKCFpmCf"
//  "photo" => "http://localhost:8000/uploads/21_1492618494IMG_2332.JPG"
//  "x" => "0"
//  "y" => "29"
//  "w" => "450"
//  "h" => "450"
//]
//        dd($request->all());
        // 拿到数据
       // $photo=strstr($request->get('photo'),'uploads');
        $photo=$request->get('photo');
        $width = (int) $request->get('w');
        $height = (int) $request->get('h');
        $x = (int) $request->get('x');
        $y = (int) $request->get('y');
        // 使用Image对图像进行裁剪后保存
        Image::make('21_1492618494IMG_2332.JPG')->crop($width, $height, $x, $y)->save();

        // 保存到数据库
        $user = \Auth::user();
        $user->avatar = '/' . $photo;
        $user->save();
dd(123);
        return redirect('/user/avatar');
    }


    public function dumpexcel()
    {
        $data = DB::table('t_u_expert as expert')
            ->leftJoin('t_u_user as user','user.userid','=','expert.userid')
            ->where('expert.expertname','<>','')
            ->select('user.phone','expert.expertname','expert.category','expert.address','expert.brief','expert.domain1','expert.domain2')
            ->get();
        $arr = [];
        foreach($data as $k => $v){
            $arr2 = [];
            foreach($v as $kk => $vv){
                $arr2[$kk] = addslashes($vv);
            }
            $arr[$k] = $arr2;
        }
        dd($arr);

        $filename = '升维网专家信息'.date('YmdHis');
        $header = array('手机号','专家名称','专家分类','所在地区','专家描述','一级领域','二级领域');
        $index = array('phone','expertname','category','address','brief','domain1','domain2');
        $this->createtable($arr,$filename,$header,$index);
    }

    /**
     * 创建(导出)Excel数据表格
     * @param  array   $list 要导出的数组格式的数据
     * @param  string  $filename 导出的Excel表格数据表的文件名
     * @param  array   $header Excel表格的表头
     * @param  array   $index $list数组中与Excel表格表头$header中每个项目对应的字段的名字(key值)
     * 比如: $header = array('编号','姓名','性别','年龄');
     *       $index = array('id','username','sex','age');
     *       $list = array(array('id'=>1,'username'=>'YQJ','sex'=>'男','age'=>24));
     * @return [array] [数组]
     */
    protected function createtable($list,$filename,$header=array(),$index = array()){
       /*header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:filename=".$filename.".xls");
        $teble_header = implode("\t",$header);
        $strexport = $teble_header."\r";
        foreach ($list as $row){
            foreach($index as $val){
                $strexport.=$row[$val]."\t";
            }
            $strexport.="\r";

        }
        $strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport);
        exit($strexport);*/

        $str = "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\"\r\nxmlns:x=\"urn:schemas-microsoft-com:office:excel\"\r\nxmlns=\"http://www.w3.org/TR/REC-html40\">\r\n<head>\r\n<meta http-equiv=Content-Type content=\"text/html; charset=utf-8\">\r\n</head>\r\n<body>";
        $str .="<table border=1><head>".'升维网专家信息'."</head>";
        foreach ($list  as $key=> $rt )
        {
            $str .= "<tr>";
            foreach ( $rt as $k => $v )
            {
                $str .= "<td>{$v}</td>";
            }
            $str .= "</tr>\n";
        }
        $str .= "</table></body></html>";
        header( "Content-Type: application/vnd.ms-excel; name='excel'" );
        header( "Content-type: application/octet-stream" );
        header( "Content-Disposition: attachment; filename=".$filename.".xls" );
        header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
        header( "Pragma: no-cache" );
        header( "Expires: 0" );
        exit( $str );
    }
}
