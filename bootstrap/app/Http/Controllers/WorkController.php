<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WorkController extends Controller
{
    /**办事审核
     * @return mixed
     */
    public function index(){
        return view("work.index");
    }

    /**
     * 办事审核详情
     * @return mixed
     */
    public function update(){
        return view("work.update");
    }

  
}
