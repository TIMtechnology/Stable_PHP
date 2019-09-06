<?php


namespace app\upload\controller;
use app\login\controller\Login;
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;
use think\Db;
use think\Request;


class Upload
{

    public function Upload($filePath='index.php',$filePathAndName = '/2091/index.php'){
        header('Content-Type:application/json; charset=utf-8');



            // 获取表单上传文件 例如上传了001.jpg
            $file =request()->file('image');
            $data = request()->get();
            if (!isset($data['userid'])){
                return ["error"=>true,"msg"=>urlencode('数据残缺,请重新登录后上传.')];

            }
            $login = new Login();

            if (!$login->CheckIsLogin()){
                return ["error"=>true,"msg"=>urlencode('登录过期或未登录,请登录后重试')];
            }
            // 移动到框架应用根目录/uploads/ 目录下
               // print_r($file);
            $info = $file->validate(['size'=>2097152,'ext'=>'jpg,png,gif'])->rule('md5')->move( 'uploads/'.$data['userid'].'/');
            if($info){

                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                return ['error'=>false,"msg"=>urlencode('上传成功'),'url'=>$info->getSaveName()];




            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }

    }

    public function UploadToQiNiu($filepath,$pathandname){
                // 需要填写你的 Access Key 和 Secret Key
        $accessKey ="oAaab3pULXoTMUvD1zn46Qc7RNTPHOUsCZm_gAYU";
        $secretKey = "29iO_3N8CcQvOfeoRscmxVF6HBDtdMrCW6Rs_vU3";
        $bucket = "zhss";
        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);
        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        // 要上传文件的本地路径


        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token,$pathandname, $filepath);
        if ($err !== null) {
           return false;
        } else {
            return true;
        }

    }

    //用户上传头像

    public function UploadHeadImg(Request $request){
        $data =$request->post();

        $userid = $data['userid'];
        $imgurl = $data['imgurl'];
        $login = new Login();
        if (!$login->CheckIsLogin()){
            return ['error'=>true,'msg'=>'您暂未登录或登录已过期,无法发布.'];
        }

        if (!$userid){
            return ['error'=>true,'msg'=>"缺少重要参数,无法提交"];
        }
        if (!$imgurl){
            return ['error'=>true,'msg'=>"缺少重要参数,无法提交"];
        }
        $value = str_replace('https://zhss.timkj.com/uploads/','',$imgurl);
        //print_r($value);

        $i = $this->UploadToQiNiu('uploads/'.$value,$value);
        if ($i){
            //上传成功
            //删除原地址 文件
            unlink('uploads/'.$value);
            //修改文件链接
            $img = 'http://file.zhss.timkj.com/'.$value;

        }else{
            //还原文件链接 使用源服务器 地址
            $img = 'http://zhss.timkj.com/upload/'.$value;
        }

        //开始更新
        Db::query("update user_tb set user_headImg = '$img' where user_id = '$userid'");

        return ['error'=>false,'msg'=>'更新成功'];
    }
}