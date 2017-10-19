<?php

namespace app\index\service;

use app\index\model\User;
use app\index\service\Func;

class UserSer {
  public static function login($openid) {
    if(empty($openid)) Func::callBack('登陆失败');
    if(!($uid = User::find(array('openid' => $openid), 'id'))) {
      $uid = User::addOne(array('openid' => $openid, 'create_time' => date('Y-m-d H:i:s')));
    }
    var_dump($uid);die;
  }
}
