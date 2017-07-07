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
    
    public  function  update(){
        return view("expert.update");
    }

   
}
