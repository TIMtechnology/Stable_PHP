<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

route('api/v1/login','login/Login/Login');
route('api/v1/fakelogin','login/Login/testlogin');
route('api/v1/upload','upload/Upload/Upload');
route('api/v1/publish','publish/Publish/Publish');
route('api/v1/GetTrends','trends/Trends/GetNewleastTrends');
route('api/v1/GetTrendsPull','trends/Trends/GetNewleastTrendsByDown');
route('api/v1/GetBaseInfo','login/Login/GetBaseInfo');
route('api/v1/addjbtx','home/Home/addjbtx');
route('api/v1/Getjbtx','home/Home/Getjbtx');
route('api/v1/check','home/Home/check');
route('api/v1/UploadHeadImg','upload/Upload/UploadHeadImg');
route('api/v1/ChangeIsLike','trends/Trends/ChangeIsLike');
route('api/v1/AddPINGLUN','trends/Trends/AddPINGLUN');
route('api/v1/GetMenuData','login/Login/GetMenu');


//测试接口

route('api/v1/AdminLogin','login/Login/AdminLogin');
route('api/user/info','login/Login/currentUser');

//权限接口
route('api/v1/admin/UserList','admin/Auth/GetUserListByDwId');