<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SupplyController extends Controller
{
    /**
     * 供求信息首页
     * @return mixed
     */
    public function index(){
        return view("supply.index");
    }

    /**供求信息详情
     * @return mixed
     */
    public  function update(){
        return view("supply.update");
    }
    /**供求信息维护首页
     * @return mixed
     */
    public  function serveIndex(){
        return view("supply.serve");
    }

    /**
     * 供求信息维护详情
     * @return mixed
     */
    public function serveDetail(){
        return view("supply.detail");
    }


}
