<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
})*/;
Route::get('/','LoginController@index');
//登录
Route::post('/login','LoginController@login');
//退出
Route::post('/quit','LoginController@login');
//首页
Route::get('/index','IndexController@index');
/***************************基础设置*****************************/
// 修改密码
Route::get('/change_pwd','LoginController@changePwd');
//保存密码
Route::post('/save_pwd','LoginController@savePwd');
//操作人员
Route::get('/operate_people','LoginController@operatePeople');
//添加操作人员
Route::get('/add_operator','LoginController@addOperator');
//保存添加操作人员
Route::post('/add_operatorSave','LoginController@addOperatorSave');
//编辑操作人员
Route::get('/edit_operator','LoginController@editOperator');
//保存编辑操作人员
Route::post('/edit_operatorSave','LoginController@editOperatorSave');
//删除操作人员
Route::get('/delete_operator','LoginController@deleteOperator');
//重置密码
Route::get('/reset_operator','LoginController@resetOperator');
//角色权限
Route::get('/role','RoleController@index');
//查看权限
Route::get('/look_right','RoleController@lookRight');
//添加角色
Route::get('/add_role','RoleController@addRole');
//保存角色
Route::post('/add_roleSave','RoleController@addRoleSave');
//修改角色
Route::get('/edit_role','RoleController@editRole');
//保存修改角色
Route::post('/edit_roleSave','RoleController@editRoleSave');
//删除角色
Route::get('/delete_role','RoleController@deleteRole');
/******************************审核操作*************************************************/
//企业审核
Route::get('/cert_enterprise/','EnterpriseController@index');
//企业审核详情
Route::get('/details_enterprise','EnterpriseController@update');
//修改企业状态
Route::post('/changeEnterprise','EnterpriseController@changeEnterprise');
//专家审核
Route::get('/cert_expert/{status?}','ExpertController@index');
//修改专家状态
Route::post('/changeExpert','ExpertController@changeExpert');
//专家审核详情
Route::get('/details_expert','ExpertController@update');

/*
 王宁修改路由开始*/

//供求审核
Route::get('/cert_supply/{action?}','SupplyController@index');
//供求审核详情
Route::get('/details_supply/{supplyId}','SupplyController@update');
//修改供求审核
Route::post('/changeSupply','SupplyController@changeSupply');

//办事审核
Route::get('/cert_work/{action?}','WorkController@index');
//办事审核详情
Route::get('/details_work/{eventId}','WorkController@update');
//修改办事审核
Route::post('/changeEvent','WorkController@changeEvent');
/*
 修改路由结束*/

//视频审核
Route::get('/cert_video/{status?}','VideoController@index');
//修改视频状态
Route::post('/changeVideo','VideoController@changeVideo');
//视频审核详情
Route::get('/details_video','VideoController@update');
//提现申请审核
Route::get('/cert_recharge/{status?}','RechargeController@index');
//提现审核状态
Route::post('/changeRecharge','RechargeController@changeRecharge');
//提现申请审核详情
Route::get('/details_recharge','RechargeController@update');
/******************************维护*************************************************/
//企业信息维护
Route::get('/serve_enterprise','EnterpriseController@serveIndex');
//企业信息维护详情
Route::get('/serve_enterpriseDet','EnterpriseController@serveDetail');
//专家维护
Route::any('/serve_expert','ExpertController@serveIndex');
//专家维护详情
Route::get('/serve_expertDet/{expertid}','ExpertController@serveDetail');
//专家首页设置
Route::post('/changeHomePage','ExpertController@changeHomePage');
//供求信息维护
Route::any('/serve_supply','SupplyController@serveIndex');
//供求信息维护详情
Route::get('/serve_supplyDet/{supplyid}','SupplyController@serveDetail');
//办事信息维护
Route::any('/serve_work','WorkController@serveIndex');
//办事信息维护详情
Route::get('/serve_workDet/{eventid}','WorkController@serveDetail');
//视频咨询维护
Route::any('/serve_video','VideoController@serveIndex');
//视频咨询维护详情
Route::get('/serve_videoDet/{videoId}','VideoController@serveDetail');
//提现信息维护
Route::get('/serve_recharge','RechargeController@serveIndex');
//提现信息维护详情
Route::get('/serve_rechargeDet/{rechargeid}','RechargeController@serveDetail');