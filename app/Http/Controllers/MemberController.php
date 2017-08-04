<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    /**会员权限
     * @return mixed
     */
 public function  member(){
     $datas = DB::table('t_u_memberright')->paginate(5);
     return view("member.member",compact('datas'));
 }

    /**添加
     * @return mixed
     */
    public function addMember(){
        return view("member.addMember");
    }

    public function dealAddMember(Request $request)
    {
        $data = $request->input();
        $data['updated_at'] = date('Y-m-d H:i:s',time());
        DB::table('t_u_memberright')->insert($data);
        return redirect('/member');
    }

    public function deleteMember(Request $request)
    {
        $memberid = $request->input('memberid');
        $res = DB::table('t_u_memberright')->where('memberid',$memberid)->delete();
        if($res){
            return 1;
        } else {
            return 0;
        }
    }

    /*编辑
     * @return mixed
     */
    public function editMember($memberid){
        $datas = DB::table('t_u_memberright')->where('memberid',$memberid)->first();
        return view("member.editMember",compact('datas'));
    }

    public function dealEditMember(Request $request)
    {
        $data = $request->input();
        $memberid = $data['memberid'];
        unset($data['memberid']);
        $data['updated_at'] = date('Y-m-d H:i:s',time());
        DB::table('t_u_memberright')->where('memberid',$memberid)->update($data);
        return redirect('/member');
    }
    

}
