<?php


namespace app\home\controller;


use app\login\controller\Login;
use think\Db;
use think\Request;

class Home
{
/*

结伴通行功能开始

*/
        public function addjbtx(Request $request){
            $post = $request->post();
            $userid = $post['userid'];
            $cxlx = $post['cxlx'];
            $cxcc =  $post['cxcc'];
            $wxh = $post['wxh'];
            $date = $post['date'];

            //数据进行
            //写入数据
            $data = ['jbtx_cxlx'=>$cxlx,'jbtx_userid'=>$userid,'jbtx_cxcc'=>$cxcc,'jbtx_wxh'=>$wxh,'jbtx_date'=>$date];
            $id = Db::table('jbtx_tb')->insertGetId($data);
            if ($id){
                return ['error'=>false,'msg'=>'写入成功'];
            }else{
                return ['error'=>true,'msg'=>'写入失败'];
            }
        }



        public function Getjbtx(Request $request){
            $post = $request->post();
            $userid = $post['userid'];
            $login = new Login();
            if (!$login->CheckIsLogin()){
                return ['error'=>true,'msg'=>'您暂未登录或登录已过期,无法发布.'];
            }
            //根据userid 进行匹配列表数据
            //查询userid 相关的数据 有没有一样的
            $r = Db::query("select * from jbtx_tb where jbtx_userid = '$userid' limit 1");
            $jbtx_cxlx = $r[0]['jbtx_cxlx'];
            $jbtx_cxcc = $r[0]['jbtx_cxcc'];
            $jbtx_wxh = $r[0]['jbtx_wxh'];
            $jbtx_date = $r[0]['jbtx_date'];
            //查询完全一致的
            $d = Db::query("select * from Select_jbtx_v1 where jbtx_cxlx = '$jbtx_cxlx' and jbtx_cxcc = '$jbtx_cxcc'
and jbtx_date = '$jbtx_date' and jbtx_userid != '$userid'");
            if ($d){
                return ['error'=>false,'data'=>$d];
            }else{
                return ['error'=>true,'msg'=>'未能找到乘坐相应车次/航班的用户'];
            }
        }

        //检测这个人是否参与成功
        public function check(Request $request){
            $post = $request->post();
            $userid = $post['userid'];
            $d = Db::query("select count(jbtx_userid) as  'num' from jbtx_tb where jbtx_userid = '$userid'");
            if ($d[0]['num'] != 0 ){
                return ['error'=>false,'is'=>true];
            }else{
                return ['error'=>false,'is'=>false];
            }
        }
    /*

    结伴通行功能结束

    */
}