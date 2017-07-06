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
Route::get('/change_pwd','LoginController@change_pwd');
//保存密码
Route::post('/save_pwd','LoginController@save_pwd');
//操作人员
Route::get('/operate_people','LoginController@operate_people');
//添加操作人员
Route::get('/add_operator','LoginController@add_operator');
//保存添加操作人员
Route::post('/add_operatorSave','LoginController@add_operatorSave');
//编辑操作人员
Route::get('/edit_operator/{userId}','LoginController@edit_operator');
//保存编辑操作人员
Route::post('/edit_operatorSave','LoginController@edit_operatorSave');
//删除操作人员
Route::get('/delete_operator/{userId}','LoginController@delete_operator');
//重置密码
Route::get('/reset_operator/{userId}','LoginController@reset_operator');
//角色权限
Route::get('/role','RoleController@index');
//查看权限
Route::get('/look_right/{roleId}','RoleController@look_right');
//添加角色
Route::get('/add_role','RoleController@add_role');
//保存角色
Route::post('/add_roleSave','RoleController@add_roleSave');
//修改角色
Route::get('/edit_role/{roleId}','RoleController@edit_role');
//保存修改角色
Route::post('/edit_roleSave','RoleController@edit_roleSave');
//保存修改角色
Route::get('/delete_role/{roleId}','RoleController@delete_role');
/******************************审核操作*************************************************/
//企业审核
Route::get('/cert_enterprise','EnterpriseController@index');
//专家审核
Route::get('/cert_expert','ExpertController@index');
//供求审核
Route::get('/cert_supply','SupplyController@index');
//办事审核
Route::get('/cert_work','SupplyController@index');
//办事审核
Route::get('/cert_video','VideoController@index');
//办事审核
Route::get('/cert_recharge','RechargeController@index');