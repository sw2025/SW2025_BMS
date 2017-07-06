<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    /**视频审核
     * @return mixed
     */
    public function index(){
       return view("video.index");
    }

   
}
