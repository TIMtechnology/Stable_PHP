<?php


namespace app\trends\controller;


use app\login\controller\Login;
use think\Db;
use think\Request;

class Trends
{
    //获取动态接口
    public function GetNewleastTrends(Request $request){
        $post= $request->post();
        //$userid = $post['userid'];

//        if (!$userid){
//            return ['error'=>true,'msg'=>'缺少必要参数'];
//        }
//        $login = new Login();
//        if (!$login->CheckIsLogin()){
//            return ['error'=>true,'msg'=>'您还未登录或登录已过期，请重新登录'];
//        }
//
        if (!session('index')){
            $r = Db::query("select * from Select_Trends_v1 order by post_id desc limit 10");

            $index  = count($r) -1 ;
            if ($index == -1){
                return ['error'=>false,'info'=>$r];
            }
            $index = $r[$index]['post_id'];
            session('index',$index);
            foreach ($r as $key=>$value){
                $post_id = $value['post_id'];
                $r[$key]['content'] = json_decode($r[$key]['content']);
                $r[$key]['islike'] = 0;
                //根据postid 查询 点赞 以及 评论
                $a = Db::query("select * from Select_like_v1 where like_postid = '$post_id'");
                //print_r($a);
                //查询自己是否点赞
                if(isset($post['userid'])){
                    $userid=$post['userid'];
                    $c = Db::query("select count(uid) as num from Select_like_v1 where like_postid = '$post_id' and uid='$userid'");
                    if (isset($c[0]['num'])){
                        $r[$key] =array_merge($r[$key],['islike'=>1]);
                    }
                }


                $b = Db::query("select * from Select_comment_v1 where comment_postid = '$post_id'");
                //print_r($b);
                $total = count($b);

                $r[$key]=array_merge($r[$key],['like'=>$a]);
                $r[$key]=array_merge($r[$key],['comments'=>['total'=>$total,'comment'=>$b]]);
            }
            return ['error'=>false,'info'=>$r];
        }else{
             $index = session('index');
             $r = Db::query("select * from Select_Trends_v1 where post_id < $index order by post_id desc limit 10");

            $index  = count($r) -1 ;
            if ($index == -1){
                return ['error'=>false,'info'=>$r];
            }
            $index = $r[$index]['post_id'];
            session('index',$index);
            foreach ($r as $key=>$value){
                $post_id = $value['post_id'];
                $r[$key]['content'] = json_decode($r[$key]['content']);
                $r[$key]['islike'] = 0;
                //根据postid 查询 点赞 以及 评论
                $a = Db::query("select * from Select_like_v1 where like_postid = '$post_id'");
                //print_r($a);
                //查询自己是否点赞
                if(isset($post['userid'])){
                    $userid=$post['userid'];
                    $c = Db::query("select count(uid) as num from Select_like_v1 where like_postid = '$post_id' and uid='$userid'");
                    if (isset($c[0]['num'])){
                        $r[$key] =array_merge($r[$key],['islike'=>1]);
                    }
                }


                $b = Db::query("select * from Select_comment_v1 where comment_postid = '$post_id'");
                //print_r($b);
                $total = count($b);

                $r[$key]=array_merge($r[$key],['like'=>$a]);
                $r[$key]=array_merge($r[$key],['comments'=>['total'=>$total,'comment'=>$b]]);
            }
            return ['error'=>false,'info'=>$r];
        }

        //第一次获取数据库中 倒数10条 记录当前session 读取到最后一条的主键ID
        //第二次开始 查询小于该主键ID的10条记录 并返回
        //select count(*) from table where 销量 <= (select 销量 from table where 产品编码=xxx)


        //分批次查询
        //下拉刷新标志 如果刷新 清空现有的数据 重新获取最新10条

    }



    //下拉刷新
    public function GetNewleastTrendsByDown(Request $request){

        $post = $request->post();
        $r = Db::query("select * from Select_Trends_v1 order by post_id desc limit 10");
        $index  = count($r) -1 ;
        if ($index == -1){
            return ['error'=>false,'info'=>$r];
        }
        $index = $r[$index]['post_id'];
        session('index',$index);


        foreach ($r as $key=>$value){
            $post_id = $value['post_id'];
            $r[$key]['content'] = json_decode($r[$key]['content']);
           // print_r($r[$key]['content']);
            if (isset($r[$key]['content'])){
                $data = $r[$key]['content'];
                $data->text= urldecode($data->text);
                $r[$key]['content'] =  $data;
            }
            $r[$key]['islike'] = 0;
            //根据postid 查询 点赞 以及 评论
            $a = Db::query("select * from Select_like_v1 where like_postid = '$post_id'");
            //print_r($a);
            //查询自己是否点赞
            if(isset($post['userid'])){
                $userid=$post['userid'];
                $c = Db::query("select count(uid) as num from Select_like_v1 where like_postid = '$post_id' and uid='$userid'");
                if ($c[0]['num']==0){
                    $r[$key] =array_merge($r[$key],['islike'=>0]);
                }else{
                    $r[$key] =array_merge($r[$key],['islike'=>1]);
                }
            }


            $b = Db::query("select * from Select_comment_v1 where comment_postid = '$post_id'");
            //print_r($b);
            $total = count($b);

            $r[$key]=array_merge($r[$key],['like'=>$a]);
            $r[$key]=array_merge($r[$key],['comments'=>['total'=>$total,'comment'=>$b]]);
        }
        return ['error'=>false,'info'=>$r];
    }



    //点赞
    public function ChangeIsLike(Request $request){
        $data = $request->post();
        $userid = $data['userid'];
        $postid = $data['postid'];
        $islike  = $data['islike'];
        $j = ['like_userid'=>$userid,'like_postid'=>$postid,'like_time'=>date("Y-m-d H:i:s",time())];
        if ($islike){
            $r = Db::table('like_tb')->insertGetId($j);

        }else{
            Db::query("DELETE FROM like_tb WHERE like_postid='$postid' and like_userid = '$userid'");
        }
    }


    //评论
    public function AddPINGLUN(Request $request){
        $data = $request->post();
        $userid = $data['userid'];
        $postid = $data['postid'];
        $text  = $data['text'];
        $j = ['comment_postid'=>$postid,'comment_userid'=>$userid,'comment_text'=>$text,'comment_time'=>date("Y-m-d H:i:s",time())];
        $r = Db::table('comment_tb')->insertGetId($j);


    }
}