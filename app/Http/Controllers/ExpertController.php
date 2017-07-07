<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ExpertController extends Controller
{
    /**专家审核首页
     * @return mixed
     */
    public function index(){
        return view("expert.index");
    }

    /**专家审核详情
     * @return mixed
     */
    public  function  update(){
        return view("expert.update");
    }

    /**专家信息维护首页
     * @return mixed
     */
    public  function serveIndex(){
        return view("expert.serve");
    }

    /**专家信息维护详情
     * @return mixed
     */
    public  function serveDetail(){
        return view("expert.detail");
    }

   
}
