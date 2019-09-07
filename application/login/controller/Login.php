<?php


namespace app\login\controller;





use think\Db;
use think\Request;
use thans\jwt\facade\JWTAuth;

class login
{

    public function Login(Request $request){
        $data = $request->post();

        $user_num = $data['user_num'];
        $user_password = $data['password'];
        $type = $data['type'];

        //查询学号是否注册
        $r = Db::query("select count(user_id) as 'is' from user_tb where user_num = '$user_num'");
        if ($r[0]['is'] == 0){
            //进行系统校验登录
            switch ($type){
                //调用接口 进行登录 返回用户信息
                case 1 :
                    //进行新生系统登录接口
                    $h = file_get_contents('https://synu.timkj.com/user/login?Usernum='.$user_num.'&Password='.$user_password);
                    $result = json_decode($h);
                    if ($result ->error == false){
                        //登录成功
                        $user_xm = $result->data->user_xm;
                        $user_xsh= $result->data->user_xsh;
                        $user_zymc = $result->data->user_zymc;
                        $user_xh =$result->data->user_xh;
                        //开始注册用户
                        $data = ['user_name'=>$user_xm,'user_num'=>$user_xh,'user_password'=>$user_password,
                            'user_xsh'=>$user_xsh,'user_zymc'=>$user_zymc];
//                        insert into user_tb (user_name, user_num, user_password, user_xsh, user_zymc, user_lastLoginTime) values (
//                            '$user_xm','$user_num','$user_password','$user_xsh','$user_zymc',current_time()
//                        )
                        $res = Db::table('user_tb')->insertGetId($data);
                        if ($res)
                        {
                            //存在userid 进行下一步
                            $r = Db::query("insert into BindUser_tb ( bind_type, bind_num, bind_password, bind_time)values (
1,'$user_num','$user_password',current_time ()
) ON DUPLICATE KEY UPDATE bind_num='$user_num',bind_password='$user_password'");
                            //记录绑定数据

                            $token = JWTAuth::builder(['uid' => $res]);//参数为用户认证的信息，请自行添加
                            $data = ['user_name'=>$user_xm,'user_num'=>$user_xh,'user_xsh'=>$user_xsh,'user_zymc'=>$user_zymc,'user_headImg'=>'https://synu.timkj.com/weapp/img/logo1.png'];
                            session('user_id',$res);
                            return ['error'=>'0','msg'=>'登录成功','userid'=>$res,'token'=>$token,'data'=>$data];
                        }else{
                            return ['error'=>'1','msg'=>'使用迎新系统数据创建账号失败'];
                        }
                    }else{
                        print_r($h);
                    }
                    break;
            }
        }else{
            //进行当前系统登录
            $r = Db::query("Select user_id,user_num,user_zymc,user_xsh,user_headImg,user_name from user_tb where user_num = '$user_num' and user_password = '$user_password'");
            if ($r != []){
                //使用session记录当前账户的登录状态
                $token = JWTAuth::builder(['uid' => $r[0]['user_id']]);//参数为用户认证的信息，请自行添加

                session('user_id',$r[0]['user_id']);
                return ['error'=>'0','msg'=>'登录成功','userid'=>$r[0]['user_id'],'token'=>$token,'data'=>$r[0]];
            }else{
                return ['error'=>'1','msg'=>'登录失败,请检查账号密码重试.'];
            }
        }
        //当输入账号与密码进行登录后  检测是否为新生 如果为新生 则进行账户关联


        //当前只做账户密码为当前子系统的情况




    }


    //检测登录
    public function CheckIsLogin(){

            if (JWTAuth::auth()){
                return true;
            }else{
                return false;
            }


    }

    public function testlogin(Request $request){
        $data = $request->post();

        $r = $this->CheckIsLogin();
        print_r($r);

    }

    //查询个人信息
    public function GetBaseInfo(Request $request){
        $data = $request->post();
        $userid = $data['userid'];

        if (!$userid){
            return ['error'=>false,'user_headImg'=>'https://synu.timkj.com/weapp/img/logo1.png','user_name'=>'游客'];
        }else{
            $r = Db::query("select user_id,user_name,user_headImg from user_tb where user_id = '$userid'");
            $data = ['error'=>false,'data'=>$r[0]];
            return $data;
        }

    }



    //获取权限列表 生成菜单
    public function GetMenu(Request $request){
        //$post = $request->post();

        if (JWTAuth::auth()){
            $data = $request->post();
            $usernum = $data['usernum'];
            $dqdw = $data['dqdw'];
            $rst = $this->gettree($usernum,$dqdw);
            return $rst;
        }else{
            return false;
        }



    }

    //获取权限树方法
    function gettree($user_num,$dqdw,$pid = null){
        //首次进入 获取所有一级菜单
        if ($pid){
            $r = Db::query("select * from V_AdminUserMenuList_v1 where Auth_User_num = '$user_num' and Auth_JSUSER_DW_id = '$dqdw' and Auth_QX_parentId ='$pid'");
        }else{
            $r = Db::query("select Auth_QX_id, Auth_QX_code, Auth_QX_SU_name, Auth_QX_title,
       Auth_QX_key, Auth_QX_name, Auth_QX_component, Auth_QX_redirect, Auth_QX_parentId,
       Auth_QX_icon,Auth_QX_show
from V_AdminUserMenuList_v1 where Auth_User_num = '$user_num' and Auth_JSUSER_DW_id = '$dqdw'");
        }
        $tree  = array();

        //分析数据 是否需要递归
        if (!empty($r)){
            foreach ($r as $val){
                $Auth_QX_id = $val['Auth_QX_id'];
                $Auth_QX_code = $val['Auth_QX_code'];
                $Auth_QX_title = $val['Auth_QX_title'];
                $Auth_QX_key= $val['Auth_QX_key'];
                $Auth_QX_name = $val['Auth_QX_name'];
                $Auth_QX_component = $val['Auth_QX_component'];
                $Auth_QX_redirect = $val['Auth_QX_redirect'];
                $Auth_QX_parentId = $val['Auth_QX_parentId'];
                $Auth_QX_icon = $val['Auth_QX_icon'];
                $Auth_QX_show= $val['Auth_QX_show'];
                //$child = [];


                    //查询当前的子菜单
                //$child = $this->gettree($user_num,$dqdw,$Auth_QX_id);

               // $tree[] = array('title'=>$Auth_QX_title,'key'=>$Auth_QX_key,'name'=>$Auth_QX_name,'component'=>$Auth_QX_component,'redirect'=>$Auth_QX_redirect,'icon'=>$Auth_QX_icon,'children'=>$child);
                $tree[] = array('id'=>$Auth_QX_id,'parentId'=>$Auth_QX_parentId,'name'=>$Auth_QX_name,'component'=>$Auth_QX_component,'meta'=>['icon'=>$Auth_QX_icon,'title'=>$Auth_QX_title,'show'=>$Auth_QX_show]);
            }
        }
        return ['result'=>$tree];
    }


    //管理端用户登录
    public function AdminLogin(Request $request){
       $data =$request->post();
       $username= $data['username'];
       $password = $data['password'];
        $r = Db::query("select Auth_DW_id,Auth_DW_name, Auth_DW_logo, Auth_User_name, Auth_User_num, Auth_User_pwd from V_AuthUserLogin where Auth_User_num='$username' and  Auth_User_pwd = '$password'");
        if (empty($r)){
            return ['error'=>true,'msg'=>"登录失败"];
        }else{
            $Auth_User_num = $r[0]['Auth_User_num'];
            $token = JWTAuth::builder(['Auth_User_num' => $Auth_User_num]);
            return ['error'=>false,'result'=>['username'=>$username,'name'=>$r[0]['Auth_User_name'],'Auth_DW_id'=>$r[0]['Auth_DW_id'],'avatar'=>$r[0]['Auth_DW_logo'],
                'status'=>1,'roleId'=>'admin','token'=>$token,'lang'=>'zh-CN','DWList'=>$r]];
        }
    }
    //查询管理端人员信息
    public function currentUser(Request $request)
    {
        $data = $request->post();
        $usernum = $data['usernum'];
        $dqdw = $data['dqdw'];
        if (JWTAuth::auth()){
            $r = Db::query("select Auth_DW_name as 'dw', Auth_DW_logo as 'avatar', Auth_User_name as 'name', Auth_User_num as 'username' from V_AuthUserLogin where Auth_User_num ='$usernum' and Auth_DW_id ='$dqdw'");
            $r = array_merge($r[0],['roleId'=>'user']);
            return ['result'=>$r];
        }else{
            return ['result'=>[]];
        }


    }
}