<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()

    {


        if (session('userId')) {
            $roleid = DB::table('t_rbac_userrole')->where('userid', session('userId'))->first()->roleid;
            $data = DB::table('t_rbac_rolepermission')
                ->leftjoin('t_rbac_permission', 't_rbac_rolepermission.permissionid', '=', 't_rbac_permission.permissionid')
                ->where('roleid', $roleid)
                ->select('t_rbac_rolepermission.*', 't_rbac_permission.*')
                ->get();
            view()->share('rbacdata', $data);
        }


   }

    public  function  _sendSms($mobile,$time,$action){
        ini_set("display_errors", "on");
        require(base_path().'/vendor/alidayus/api_sdk/vendor/autoload.php');
        //require_once dirname(__DIR__) . '/api_sdk/vendor/autoload.php';
        //此处需要替换成自己的AK信息
        Config::load();
        $accessKeyId = "LTAI8Iu9OevZOFP6";//参考本文档步骤2
        $accessKeySecret = "7TFTEtNVJgAxTzgKpUMJRfsh1PkvXL";//参考本文档步骤2
        //短信API产品名（短信产品名固定，无需修改）
        $product = "Dysmsapi";
        //短信API产品域名（接口地址固定，无需修改）
        $domain = "dysmsapi.aliyuncs.com";
        //暂时不支持多Region（目前仅支持cn-hangzhou请勿修改）
        $region = "cn-hangzhou";
        //初始化访问的acsCleint
        $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
        DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
        $acsClient= new DefaultAcsClient($profile);
        $request = new SendSmsRequest();
        //必填-短信接收号码。支持以逗号分隔的形式进行批量调用，批量上限为1000个手机号码,批量调用相对于单条调用及时性稍有延迟,验证码类型的短信推荐使用单条调用的方式
        $request->setPhoneNumbers($mobile);
        //必填-短信签名
        $request->setSignName("升维网");
        //必填-短信模板Code
        if($action == 'enterpriseSuccess'){
            $request->setTemplateCode("SMS_94675024");//设置模板
        } elseif($action == 'enterpriseFail') {
            $request->setTemplateCode("SMS_94675025");//设置模板
        }elseif($action=='expertSuccess'){
            $request->setTemplateCode("SMS_94795019");//设置模板
        }else{
            $request->setTemplateCode("SMS_94790038");//设置模板
        }


        //选填-假如模板中存在变量需要替换则为必填(JSON格式),友情提示:如果JSON中需要带换行符,请参照标准的JSON协议对换行符的要求,比如短信内容中包含\r\n的情况在JSON中需要表示成\\r\\n,否则会导致JSON在服务端解析失败
        $request->setTemplateParam("{\"name\":\"{$mobile}\",\"time\":\"{$time}\"}");
        //选填-发送短信流水号
        $request->setOutId("1234");
        //发起访问请求
        $acsResponse = $acsClient->getAcsResponse($request);

    }


}
