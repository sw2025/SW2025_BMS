<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RechargeController extends Controller
{

    /**
     * 提现审核
     * @return mixed
     */
    public function index(){
        return view("recharge.index");
    }


}
