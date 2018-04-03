<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * 项目评议推送列表
     */
    public function supplyShow($action = 'all')
    {
        $datas = DB::table('t_s_show')
            ->leftJoin('t_s_showverify','t_s_showverify.showid','=','t_s_show.showid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.userid','=','t_s_show.userid')
            //->leftJoin('t_s_pushshow','t_s_pushshow.showid','=','t_s_show.showid')
            ->leftJoin('t_u_user','t_u_user.userid','=','t_s_show.userid')
            ->where('t_s_show.userid', '<>',0)
            ->where('t_s_show.level', 1)
            ->whereRaw('t_s_showverify.id in (select max(id) from t_s_showverify group by showid)')
            ->select('t_u_user.phone','t_s_show.*','t_u_enterprise.enterprisename','t_s_showverify.configid')
            ->orderBy('t_s_show.showtime','desc');

        $pushOk = DB::table('t_s_pushshow')
            ->leftJoin('t_u_expert','t_s_pushshow.expertid','=','t_u_expert.expertid')
            ->whereRaw('t_s_pushshow.id in (select max(id) from t_s_pushshow group by showid,expertid)')
            ->select('t_s_pushshow.id','t_s_pushshow.expertid','t_s_pushshow.showid','t_u_expert.expertname','t_u_expert.expertid','t_u_expert.userid','t_s_pushshow.state')
            ->get();

        $config = ['1'=>'待支付','3'=>'未通过','4'=>'已推送','5'=>'已完成','6'=>'已评议'];

        $result= DB::table('t_s_messagetoshow')
            ->where('isdelete',0);

        $datamessage = clone $result;
        $message = $datamessage->get();
        $count = clone $datas;

        switch ($action) {
            case 'all':
                $datas = $datas->whereIn("configid", [1,2,3,4,5,6])->paginate(10);
                $counts = $count->whereIn("configid", [1,2,3,4,5,6])->count();
                break;
            case 'wait':
                $datas = $datas->where("configid", 1)->paginate(10);
                $counts = $count->where("configid",1)->count();
                break;
            case 'wput':
                $datas = $datas->where("configid", 2)->paginate(10);
                $counts = $count->where("configid",2)->count();
                break;
            case 'fail':
                $datas = $datas->where("configid", 3)->paginate(10);
                $counts = $count->where("configid",3)->count();
                break;
            case 'pushok':
                $datas = $datas->where("configid", 4)->paginate(10);
                $counts = $count->where("configid",4)->count();
                break;
        }


        return view('review.index',compact('datas','action','pushOk','message','counts','config'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 项目评议详情页面
     */
    public function details_show($showid)
    {
        $datas = DB::table('t_s_show')
            ->leftJoin('t_s_showverify','t_s_showverify.showid','=','t_s_show.showid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.userid','=','t_s_show.userid')
            ->leftJoin('t_u_user','t_u_user.userid','=','t_s_show.userid')
            ->whereRaw('t_s_showverify.id in (select max(id) from t_s_showverify group by showid)')
            ->where('t_s_show.showid',$showid)
            ->select('t_u_user.phone','t_s_show.*','t_u_enterprise.enterprisename','t_s_showverify.configid')
            ->first();

        $pushOk = DB::table('t_s_pushshow')
            ->leftJoin('t_u_expert','t_s_pushshow.expertid','=','t_u_expert.expertid')
            ->whereRaw('t_s_pushshow.id in (select max(id) from t_s_pushshow group by showid,expertid)')
            ->select('t_s_pushshow.id','t_s_pushshow.expertid','t_s_pushshow.showid','t_u_expert.expertname','t_u_expert.expertid','t_u_expert.userid','t_s_pushshow.state')
            ->get();

        $result= DB::table('t_s_messagetoshow')
            ->leftJoin('t_u_expert','t_s_messagetoshow.userid','=','t_u_expert.userid')
            ->where('isdelete',0)
            ->where('showid',$showid);
        $config = ['2'=>'已支付','3'=>'未通过','4'=>'已推送','5'=>'已完成','6'=>'已评议'];


        $datamessage = clone $result;
        $message = $datamessage->get();
        $counts = $datamessage->count();

        //dd($message);
        return view('review.detail',compact('datas','pushOk','counts','message','config'));
    }

    /**
     * 通过按钮：项目评议
     *
     */
    public function changeShow()
    {
        $showid = $_POST['showid'];
        $configid = $_POST['configid'];
        $expetid =  DB::table("t_s_show")->where('t_s_show.showid',$showid)->first();
        $expetid=explode(",",$expetid->expertids);
        $expetid=array_filter($expetid);

        DB::beginTransaction();
        try {
            DB::table('t_s_showverify')->where('showid',$showid)->insert([
                'showid'=>$showid,
                'configid'=>$configid,
                'verifytime'=>date('Y-m-d,H-i-s',time()),
                'created_at'=>date('Y-m-d,H-i-s',time()),
                'updated_at'=>date('Y-m-d,H-i-s',time())
            ]);

            if($configid!=3){
                foreach ($expetid as $value){
                    DB::table('t_s_pushshow')->insert([
                        'expertid'=>$value,
                        'showid'=>$showid,
                        'created_at'=>date('Y-m-d,H-i-s',time()),
                        'updated_at'=>date('Y-m-d,H-i-s',time()),
                        'pushtime'=>date('Y-m-d,H-i-s',time())
                    ]);
                }
            }
            DB::commit();
            $msg = ['msg' => 'success'];
        } catch (Exception $e) {
            //异常处理
            $msg = ['msg' => 'error'];
            throw $e;
        }

        return $msg;

    }

    /**
     * 返回专家数据
     */

    public  function showSelectExpert(Request $request){

        /*$res=array();
        $expertids=array();*/
        $data = $request->input();
        $typeWhere = empty($data['type']) ? array() : array("t_u_expert.domain2" => $data['type']);

        $expertData=DB::table("t_u_expert")
            ->leftJoin('t_u_expertverify','t_u_expertverify.expertid','=','t_u_expert.expertid')
            ->whereRaw('t_u_expertverify.id in (select max(id) from t_u_expertverify group by expertid)')
            ->where('t_u_expertverify.configid',2)
            ->where($typeWhere)
            ->orderBy('t_u_expert.expertid','desc')
            ->get();
            return $expertData;

    }


    /**项目评议推送专家
     * @return mixed
     */
    public function  pushExpert(){

        $showid = $_POST['showId'];
        $puttime = DB::table('t_s_show')->where('showid',$showid)->first()->showtime;
        $expetid=explode(",",$_POST['expertSelect']);
        //$sum=count($expetid);
        $expetid=array_filter($expetid);
        /*for ($i=0; $i<=$sum; $i++)
        {
            DB::table('t_s_showverify')->insert([
                'expertid'=>$expetid[i],
                'showid'=>$showid,
                'created_at'=>date('Y-m-d,H-i-s',time()),
                'updated_at'=>date('Y-m-d,H-i-s',time()),
                'pushtime'=>$puttime
            ]);
        }*/

       foreach ($expetid as $value){
           DB::table('t_s_pushshow')->insert([
               'expertid'=>$value,
               'showid'=>$showid,
               'created_at'=>date('Y-m-d,H-i-s',time()),
               'updated_at'=>date('Y-m-d,H-i-s',time()),
               'pushtime'=>$puttime
           ]);
       }

       $result = DB::table('t_s_showverify')->insert([
           'showid'=>$showid,
           'configid'=>4,
           'verifytime'=>date('Y-m-d,H-i-s',time()),
           'created_at'=>date('Y-m-d,H-i-s',time()),
       ]);

        if($result){
            return ['errorMsg'=>'success','url' => url('roadShow')];
        }else{
            return ['errorMsg'=>'error'];
        }

    }

    /**
     * 线下约见列表
     */
    public function lineMeet($action = 'all')
    {
        $datas = DB::table('t_m_meet')
            ->leftJoin('t_u_expert','t_m_meet.expertid','=','t_u_expert.expertid')
            ->leftJoin('t_u_user','t_u_user.userid','=','t_m_meet.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.userid','=','t_m_meet.userid')
            ->leftJoin('t_m_meetverify','t_m_meetverify.meetid','=','t_m_meet.meetid')
            ->whereRaw('t_m_meetverify.id in (select max(id) from t_m_meetverify group by meetid)')
            ->orderBy('t_m_meet.puttime','desc')
            ->select('t_m_meet.*','t_u_expert.expertname','t_u_enterprise.enterprisename','t_u_user.phone','t_m_meetverify.configid');

        $config = ['1'=>'已提交','2'=>'已支付','3'=>'已响应','4'=>'未通过','5'=>'已完成'];

        $count = clone $datas;

        switch ($action){
            case 'all':
                $datas = $datas->whereIn("configid", [1,2,3,4,5])->paginate(8);
                $counts = $count->whereIn("configid", [1,2,3,4,5])->count();
                break;
            case 'wait':
                $datas = $datas->where("configid", 2)->paginate(8);
                $counts = $count->where("configid",2)->count();
                break;
            case 'fail':
                $datas = $datas->where("configid", 4)->paginate(8);
                $counts = $count->where("configid",4)->count();
                break;
            case 'wput':
                $datas = $datas->where("configid", 3)->paginate(8);
                $counts = $count->where("configid",3)->count();
                break;
            case 'ver_pushok':
                $datas = $datas->where("configid", 5)->paginate(8);
                $counts = $count->where("configid",5)->count();
                break;
        }

        return view('review.linemeet',compact('datas','action','config','counts'));
    }

    /**
     * 线下约见详情页面
     */
    public function linemeetdetail($meetid)
    {
        $config = ['1'=>'已提交','2'=>'已支付','3'=>'已响应','4'=>'未通过','5'=>'已完成'];

        $datas = DB::table('t_m_meet')
            ->leftJoin('t_u_expert','t_m_meet.expertid','=','t_u_expert.expertid')
            ->leftJoin('t_u_user','t_u_user.userid','=','t_m_meet.userid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.userid','=','t_m_meet.userid')
            ->leftJoin('t_m_meetverify','t_m_meetverify.meetid','=','t_m_meet.meetid')
            ->where('t_m_meet.meetid',$meetid)
            ->whereRaw('t_m_meetverify.id in (select max(id) from t_m_meetverify group by meetid)')
            ->select('t_m_meet.*','t_u_expert.expertname','t_u_enterprise.enterprisename','t_u_user.phone','t_m_meetverify.configid')
        ->first();

        return view('review.linemeetdetail',compact('datas','config'));
    }

    /**
     * 完善
     */
    public function perfectRoadShow($showid)
    {
        $data =  DB::table('t_s_show')
            ->leftJoin('t_s_showverify','t_s_showverify.showid','=','t_s_show.showid')
            //->leftJoin('t_u_enterprise','t_u_enterprise.userid','=','t_s_show.userid')
            //->leftJoin('t_s_pushshow','t_s_pushshow.showid','=','t_s_show.showid')
            ->leftJoin('t_u_user','t_u_user.userid','=','t_s_show.userid')
            //->whereRaw('t_s_showverify.id in (select max(id) from t_s_showverify group by showid)')
            ->where("t_s_show.showid",$showid)
            ->orderBy('t_s_show.showtime','desc')
            ->first();
        $cate1 = DB::table('t_i_investment')->where('type', 1)->get();
        $cate2 = DB::table('t_i_investment')->where('type', 2)->get();

        return view('review.perfectRoadShow',compact('data','cate2','cate1'));

    }
    /**
     * 保存
     */
    public function preservation(Request $request)
    {
        $data = $request->input();

         $basicdata = [
                        "enterprisename"=>$data['enterprisename'],
                        "job"=>$data['username'],
                        'industry' => $data['industry']
                       ];
        $result =  DB::table('t_s_show')->where("showid",$data['showid'])->update([

            "title"=>$data['title'],
            "oneword"=>$data['oneword'],
            "domain1"=>$data['domain1'],
            "preference"=>$data['preference'],
            "brief"=>$data['brief'],
            'basicdata' => serialize($basicdata)

        ]);
        //return view('enterprise.perfectRoadShow',compact('data'));
        if($result){
            return ['errorMsg'=>'success'];
        }else{
            return ['errorMsg'=>'error'];
        }
    }

    /**
     * 线下路演
     */

    public function roadShow()
    {
        $serveName=(isset($_GET['serveName'])&&$_GET['serveName']!="null")?$_GET['serveName']:null;
        $job=(isset($_GET['job'])&&$_GET['job']!="null")?$_GET['job']:null;
        $idCard=(isset($_GET['idCard'])&&$_GET['idCard']!="null")?$_GET['idCard']:null;
        $location=( isset($_GET['location'])&&$_GET['location']!="全国")?$_GET['location']:null;
        $scale=(isset($_GET['scale'])&&$_GET['scale']!="null")?$_GET['scale']:null;
        $stage=(isset($_GET['stage'])&&$_GET['stage']!="null")?$_GET['stage']:null;

        if($job=='免费通道'){$number=0;$symbol='=';}elseif ($job=='定点推送'){$number=2;$symbol='=';}else{$number=1;$symbol='<>';}

        $industryWhere = !empty($idCard)?array("t_s_show.domain1" => $idCard):array();
        $stageWhere = !empty($stage)?array("t_s_show.preference" => $stage):array();

   /*     echo date("Y-m-d",strtotime("-1 week")), "\n";
        echo date("Ymd",strtotime("-1 week")), "\n";
        echo date("Ymd",strtotime("+0 week")), "\n";
        echo date("Ymd",strtotime("+0 week")), "\n";*/
        $date = ['一周前'=>  date("Y-m-d",strtotime("-1 week")),'一个月前'=>  date("Y-m-d",strtotime("-1 month")),'三个月前'=>  date("Y-m-d",strtotime("-3 month"))/*,'三个月后'=>  ,*/];
/*        $scaleWhere = !empty($scale)?array("t_s_show.showtime" => array('lt',$date[$scale])):array();*/


        $result = DB::table('t_s_show')
            ->leftJoin('t_s_showverify','t_s_showverify.showid','=','t_s_show.showid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.userid','=','t_s_show.userid')
            //->leftJoin('t_s_pushshow','t_s_pushshow.showid','=','t_s_show.showid')
            ->leftJoin('t_u_user','t_u_user.userid','=','t_s_show.userid')
            ->whereRaw('t_s_showverify.id in (select max(id) from t_s_showverify group by showid)')
            ->where('t_s_show.userid','<>',0)
            ->select('t_u_user.phone','t_s_show.*','t_u_enterprise.enterprisename','t_u_enterprise.industry','t_s_showverify.configid')
            ->orderBy('t_s_show.showtime','desc');

        $pushOk = DB::table('t_s_pushshow')
            ->leftJoin('t_u_expert','t_s_pushshow.expertid','=','t_u_expert.expertid')
            ->whereRaw('t_s_pushshow.id in (select max(id) from t_s_pushshow group by showid,expertid)')
            ->select('t_s_pushshow.id','t_s_pushshow.expertid','t_s_pushshow.showid','t_u_expert.expertname','t_u_expert.expertid','t_u_expert.userid','t_s_pushshow.state')
            ->get();

        $message= DB::table('t_s_messagetoshow')
            ->leftJoin('t_u_expert','t_s_messagetoshow.userid','=','t_u_expert.userid')
            ->where('isdelete',0)
            ->get();

        $datas = clone $result;
        $datass = clone $result;

        if($scale){
            $datas = $datas->where('t_s_show.level',$symbol,$number)->where("t_s_show.title","like","%".$serveName."%")->where("t_s_show.bpname","like","%".$serveName."%")->where($industryWhere)->where($stageWhere)->where('t_s_show.showtime','<',$date[$scale])->paginate(10);
            $counts = $datass->where('t_s_show.level',$symbol,$number)->where("t_s_show.title","like","%".$serveName."%")->where("t_s_show.bpname","like","%".$serveName."%")->where($industryWhere)->where($stageWhere)->where('t_s_show.showtime','<',$date[$scale])->count();
        }else{
            $datas = $datas->where('t_s_show.level',$symbol,$number)->where("t_s_show.title","like","%".$serveName."%")->where("t_s_show.bpname","like","%".$serveName."%")->where($industryWhere)->where($stageWhere)->paginate(10);
            $counts = $datass->where('t_s_show.level',$symbol,$number)->where("t_s_show.title","like","%".$serveName."%")->where("t_s_show.bpname","like","%".$serveName."%")->where($industryWhere)->where($stageWhere)->count();
        }
               /*        break;
            case 'wait':
                $datas =$datas->where('t_s_show.level',0)->where("t_s_show.title","like","%".$serveName."%")->where("t_s_show.bpname","like","%".$serveName."%")->where($industryWhere)->where($stageWhere)->paginate(10);
                $counts = $datass->where('t_s_show.level',0)->where("t_s_show.title","like","%".$serveName."%")->where("t_s_show.bpname","like","%".$serveName."%")->where($industryWhere)->where($stageWhere)->count();
                break;
            case 'fail':
                $datas = $datas->where('t_s_show.level',2)->where("t_s_show.title","like","%".$serveName."%")->where("t_s_show.bpname","like","%".$serveName."%")->where($industryWhere)->where($stageWhere)->paginate(10);
                $counts = $datass->where('t_s_show.level',2)->where("t_s_show.title","like","%".$serveName."%")->where("t_s_show.bpname","like","%".$serveName."%")->where($industryWhere)->where($stageWhere)->count();
                break;
        }*/

        $cate1 = DB::table('t_i_investment')->where('type', 1)->get();
        $cate2 = DB::table('t_i_investment')->where('type', 2)->get();

        return view('review.roadshow',compact('datas','counts','pushOk','message','action','job','idCard','location','size','cate1','cate2','stage','serveName','scale'));
    }
    /**
     * 线下路演详情页面
     *
     * */
    public function roadShowdetail($roadid)
    {
        $datas = DB::table('t_s_show')
            ->leftJoin('t_s_showverify','t_s_showverify.showid','=','t_s_show.showid')
            //->leftJoin('t_u_enterprise','t_u_enterprise.userid','=','t_s_show.userid')
            //->leftJoin('t_s_pushshow','t_s_pushshow.showid','=','t_s_show.showid')
            ->leftJoin('t_u_user','t_u_user.userid','=','t_s_show.userid')
            ->whereRaw('t_s_showverify.id in (select max(id) from t_s_showverify group by showid)')
            ->where('t_s_show.showid',$roadid)
            ->orderBy('t_s_show.showtime','desc')
            ->first();

        $pushOk = DB::table('t_s_pushshow')
            ->leftJoin('t_u_expert','t_s_pushshow.expertid','=','t_u_expert.expertid')
            ->whereRaw('t_s_pushshow.id in (select max(id) from t_s_pushshow group by showid,expertid)')
            ->select('t_s_pushshow.id','t_s_pushshow.expertid','t_s_pushshow.showid','t_u_expert.expertname','t_u_expert.expertid','t_u_expert.userid','t_s_pushshow.state')
            ->get();

        $message= DB::table('t_s_messagetoshow')
            ->leftJoin('t_u_expert','t_s_messagetoshow.userid','=','t_u_expert.userid')
            ->where('isdelete',0)
            ->where('showid',$roadid)
            ->get();

        return view('review.roadshowdetail',compact('datas','message','pushOk'));
    }
}
