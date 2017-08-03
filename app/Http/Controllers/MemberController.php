<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    /**会员权限
     * @return mixed
     */
 public function  member(){
     return view("member.member");
 }

    /**添加
     * @return mixed
     */
    public function addMember(){
        return view("member.addMember");
    }

    /*编辑
     * @return mixed
     */
    public function editMember(){
        return view("member.editMember");
    }
    

}
