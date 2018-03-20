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
            ->whereRaw('t_s_showverify.id in (select max(id) from t_s_showverify group by showid)')
            ->select('t_u_user.phone','t_s_show.*','t_u_enterprise.enterprisename','t_s_showverify.configid')
            ->orderBy('t_s_show.showtime','desc');



        $pushOk = DB::table('t_s_pushshow')
            ->leftJoin('t_u_expert','t_s_pushshow.expertid','=','t_u_expert.expertid')
            ->whereRaw('t_s_pushshow.id in (select max(id) from t_s_pushshow group by showid,expertid)')
            ->select('t_s_pushshow.id','t_s_pushshow.expertid','t_s_pushshow.showid','t_u_expert.expertname','t_u_expert.expertid','t_u_expert.userid','t_s_pushshow.state')
            ->get();


        $config = ['1'=>'待支付','3'=>'未通过','4'=>'已推送','5'=>'已完成','6'=>'已评议'];

        //dd($pushOk);

        $result= DB::table('t_s_messagetoshow')
            ->where('isdelete',0);

        $datamessage = clone $result;
        $message = $datamessage->get();
        $counts = $datamessage->count();



        switch ($action) {
            case 'all':
                $datas = $datas->whereIn("configid", [1,2,3,4,5,6])->paginate(10);
                break;
            case 'wait':
                $datas = $datas->where("configid", 1)->paginate(10);
                break;
            case 'wput':
                $datas = $datas->where("configid", 2)->paginate(10);
                break;
            case 'fail':
                $datas = $datas->where("configid", 3)->paginate(10);
                break;
            case 'pushok':
                $datas = $datas->where("configid", 4)->paginate(10);
                break;
        }


        return view('Review.index',compact('datas','action','pushOk','message','counts','config'));
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
        return view('Review.detail',compact('datas','pushOk','counts','message','config'));
    }

    /**
     * 通过按钮：项目评议
     *
     */
    public function changeShow()
    {
        $showid = $_POST['showid'];
        $configid = $_POST['configid'];

        $result = DB::table('t_s_showverify')->where('showid',$showid)->insert([
            'showid'=>$showid,
            'configid'=>$configid,
            'verifytime'=>date('Y-m-d,H-i-s',time()),
            'created_at'=>date('Y-m-d,H-i-s',time()),
            'updated_at'=>date('Y-m-d,H-i-s',time())
        ]);

        if($result){
            return ['errorMsg'=>'success'];
        }else{
            return ['errorMsg'=>'error'];

        }
    }

    /**
     * 返回专家数据
     */

    public  function showSelectExpert(){

        /*$res=array();
        $expertids=array();*/

        $expertData=DB::table("t_u_expert")
            ->leftJoin('t_u_expertverify','t_u_expertverify.expertid','=','t_u_expert.expertid')
            ->whereRaw('t_u_expertverify.id in (select max(id) from t_u_expertverify group by expertid)')
            ->where('t_u_expertverify.configid',2)
            ->where('t_u_expert.domain1','找技术')
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
           'updated_at'=>date('Y-m-d,H-i-s',time())
       ]);

        if($result){
            return ['errorMsg'=>'success'];
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

        switch ($action){
            case 'all':
                $datas = $datas->whereIn("configid", [1,2,3,4,5])->paginate(8);
                break;
            case 'wait':
                $datas = $datas->where("configid", 2)->paginate(8);
                break;
            case 'fail':
                $datas = $datas->where("configid", 4)->paginate(8);
                break;
            case 'wput':
                $datas = $datas->where("configid", 3)->paginate(8);
                break;
            case 'ver_pushok':
                $datas = $datas->where("configid", 5)->paginate(8);
                break;
        }

        return view('review.linemeet',compact('datas'),compact('action','config'));
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
     * 线下路演
     */

    public function roadShow()
    {
        $result = DB::table('t_s_show')
            ->leftJoin('t_s_showverify','t_s_showverify.showid','=','t_s_show.showid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.userid','=','t_s_show.userid')
            //->leftJoin('t_s_pushshow','t_s_pushshow.showid','=','t_s_show.showid')
            ->leftJoin('t_u_user','t_u_user.userid','=','t_s_show.userid')
            ->whereRaw('t_s_showverify.id in (select max(id) from t_s_showverify group by showid)')
            ->select('t_u_user.phone','t_s_show.*','t_u_enterprise.enterprisename','t_s_showverify.configid')
            ->orderBy('t_s_show.showtime','desc');

        $datas = clone $result;
        $datass = clone $result;
        $datas = $datas->paginate(10);
        $counts = $datass->count();
        //dd($datas);
        return view('review.roadshow',compact('datas','counts'));
    }
    /**
     * 线下路演详情页面
     *
     * */
    public function roadShowdetail($roadid)
    {
        $datas = DB::table('t_s_show')
            ->leftJoin('t_s_showverify','t_s_showverify.showid','=','t_s_show.showid')
            ->leftJoin('t_u_enterprise','t_u_enterprise.userid','=','t_s_show.userid')
            //->leftJoin('t_s_pushshow','t_s_pushshow.showid','=','t_s_show.showid')
            ->leftJoin('t_u_user','t_u_user.userid','=','t_s_show.userid')
            ->whereRaw('t_s_showverify.id in (select max(id) from t_s_showverify group by showid)')
            ->where('t_s_show.showid',$roadid)
            ->orderBy('t_s_show.showtime','desc')
            ->first();

        return view('review.roadShowdetail',compact('datas'));
    }
}
