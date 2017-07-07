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
    /**
     * 视频审核详情
     * @return mixed
     */
    public function update(){
        return view("video.update");
    }
    /**视频咨询维护首页
     * @return mixed
     */
    public  function serveIndex(){
        return view("video.serve");
    }
    /**
     * 视频咨询信息维护详情
     * @return mixed
     */
    public function serveDetail(){
        return view("video.detail");
    }
}
