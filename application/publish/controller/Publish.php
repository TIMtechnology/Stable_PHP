<?php


namespace app\publish\controller;


use app\login\controller\Login;
use app\upload\controller\Upload;
use think\Db;
use think\Request;

class Publish
{

    public function Publish(Request $request){
        //根据内容 将数据存入数据库
        $data =$request->post();

        $userid = $data['userid'];
        $connect = $data['connect'];
        $login = new Login();
        if (!$login->CheckIsLogin()){
            return ['error'=>true,'msg'=>'您暂未登录或登录已过期,无法发布.'];
        }

        if (!$userid){
            return ['error'=>true,'msg'=>"缺少重要参数,无法提交"];
        }
        if (!$connect){
            return ['error'=>true,'msg'=>"缺少重要参数,无法提交"];
        }
        //检测是否有图片 如果有 对这个用户的使用的图片 上传至七牛云
        $upload = new Upload();
        if ($connect['text']){
            $connect['text'] = urlencode($connect['text']);
        }
        if ($connect['images']){
            foreach ($connect['images'] as $key =>$value){
               // print_r($value);
                 $value = str_replace('https://zhss.timkj.com/uploads/','',$value);
                 //print_r($value);
                 $i = $upload->UploadToQiNiu('uploads/'.$value,$value);
                 if ($i){
                     //上传成功
                     //删除原地址 文件
                     unlink('uploads/'.$value);
                     //修改文件链接
                     $connect['images'][$key]='http://file.zhss.timkj.com/'.$value;

                 }else{
                     //还原文件链接 使用源服务器 地址
                     $connect['images'][$key]='http://zhss.timkj.com/upload/'.$value;
                 }
            }
        }
        $connect = json_encode($connect);
        Db::query("insert into post_tb (post_userid, post_content,post_time)values (
'$userid', '$connect',CURRENT_TIME()
)");

        return ['error'=>false,'msg'=>'发布成功'];

    }
}