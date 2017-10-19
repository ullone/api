<?php

namespace app\index\service;

use app\index\model\User;
use app\index\service\Func;

class UserSer {
  public static function login($code) {
    if($code === null) Func::callBack(201, '登陆失败');
    $appid = 'wx61c00f82c85f0036';
    $appsecret = '97e7d6904e1f52ce70957c62e1756c23';
    $url   = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$appsecret&js_code=$code&grant_type=authorization_code";
    $res   = file_get_contents($url);
    var_dump($res);die;
  }
}
