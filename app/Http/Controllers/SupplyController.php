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


}
