<?php

namespace app\index\service;

use app\index\model\User;
use app\index\service\Func;

class UserSer {
  public static function login($code) {
    if($code === null) Func::callBack(301, '获取code失败');
    var_dump($code);die;
    $url = 'https://api.weixin.qq.com/sns/jscode2session';
    $data = array(
      'appid' => 'wx61c00f82c85f0036',
      'appsecret' => '97e7d6904e1f52ce70957c62e1756c23',
      'code' => $code,
      'grant_type' => 'authorization_code'
    );
    $header = [
      "content-type:application/x-www-form-urlencoded"
    ];
    $res = Func::doCurl($url, 'post', $data, $header);
    if(empty($res)) Func::callBack(301, '登陆失败');
    else Func::callBack(0, '成功');
    if(!($uid = User::find(array('openid' => $openid), 'id'))) {
      $uid = User::addOne(array('openid' => $openid, 'create_time' => date('Y-m-d H:i:s')));
    }
    $token = uniqid().$uid;
    Cookie::set()
    var_dump($uid);die;
  }
}
