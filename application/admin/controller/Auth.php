<?php


namespace app\admin\controller;


use think\Db;
use think\Request;

class Auth
{

    //获取本单位用户列表
    public function GetUserListByDwId(Request $request){

        $dqdw = 1;
        //查询
        $d  = Db::query("SELECT
       Auth_User_id as 'key',
Auth_User_tb.Auth_User_name,
Auth_User_tb.Auth_User_num,
Auth_DW_tb.Auth_DW_name,
Auth_DW_tb.Auth_DW_id
FROM
Auth_JSUSER_tb
INNER JOIN Auth_DW_tb ON Auth_JSUSER_tb.Auth_JSUSER_DW_id = Auth_DW_tb.Auth_DW_id
INNER JOIN Auth_User_tb ON Auth_JSUSER_tb.Auth_JSUSER_User_id = Auth_User_tb.Auth_User_id
where  Auth_DW_id = '$dqdw'
GROUP BY Auth_User_id  ");
       // print_r($d[1]);
        $data = [];
        foreach ($d as $index=>$value){
           // print_r($d[$index]);
           // print_r($index);
            $key = $value['key'];
            $r = Db::query("SELECT
       Auth_JS_id as 'key',
Auth_DW_tb.Auth_DW_name,
Auth_User_tb.Auth_User_name,
Auth_User_tb.Auth_User_num,
       Auth_GN_name,
       Auth_JS_name
FROM
Auth_User_tb
INNER JOIN Auth_JSUSER_tb ON Auth_User_tb.Auth_User_id = Auth_JSUSER_tb.Auth_JSUSER_User_id
INNER JOIN Auth_DW_tb ON Auth_JSUSER_tb.Auth_JSUSER_DW_id = Auth_DW_tb.Auth_DW_id
INNER JOIN Auth_GN_tb ON Auth_GN_tb.Auth_GN_id = Auth_JSUSER_tb.Auth_JSUSER_GN_id AND Auth_JSUSER_tb.Auth_JSUSER_DW_id = Auth_GN_tb.Auth_GN_DW_id
INNER JOIN Auth_JS_tb ON Auth_JSUSER_tb.Auth_JSUSER_JS_id = Auth_JS_tb.Auth_JS_id WHERE Auth_DW_id = '$dqdw' and Auth_User_id = '$key'
GROUP BY Auth_User_num,Auth_GN_name,Auth_JS_name ");
           $data[]= array_merge($d[$index],['list'=>$r]);
        }

        //print_r($r);
        //对结果进行变更

        return ['d'=>$data];

    }


    //添加用户
    //回 用户ID
    public function AddAuthUser($username,$usernum,$password){

        $data = ['Auth_User_name'=>$username,'Auth_User_num'=>$usernum,'Auth_User_pwd'=>$password];
        $r = Db::table('Auth_User_tb')->insertGetId($data);
        return $r;
    }

    //添加用户功能角色
    public function AddJSUser($dw,$gn,$js,$userid){

        //检查当前单位是否用用该功能
        $dd = Db::query("select count(Auth_GN_id) as 'num',Auth_GN_name from Auth_GN_tb where Auth_GN_DW_id = '$dw' and Auth_GN_id = '$gn'");
        if ($dd[0]['num'] > 0){
            //可以
            $data = ['Auth_JSUSER_User_id'=>$userid,'Auth_JSUSER_DW_id'=>$dw,'Auth_JSUSER_GN_id'=>$gn,'Auth_JSUSER_JS_id'=>$js];
            $r = Db::table('Auth_JSUSER_tb')->insertGetId($data);
            return ['error'=>false,'data'=>$r];
        }else{
            return ['error'=>true,'msg'=>'当前单位不存在_'.$dd[0]['Auth_GN_name'].'_功能，无法添加。'];
        }


    }

    //根据传递的数据进行执行
    //{"username":"","usernum":"","password":"","dqdw":"","data":[{"gn":"1","js":"1"},{"gn":"2","js":"2"}]}
    public function AddUser(){
        //创建完成用户后 一定要检测 当前单位是否拥有该项功能
//        $dqdw= 2;
//        $list = '[{"gn":"1","js":"1"},{"gn":"2","js":"2"}]';
//        $list = json_decode($list,true);
//
//        $r = Db::query("select Auth_GN_id from Auth_GN_tb where Auth_GN_DW_id = '$dqdw'");
//        print_r($r);


    }
}