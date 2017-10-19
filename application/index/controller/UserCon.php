<?php

namespace app\index\controller;

use \think\Cookie;
use app\index\service\UserSer;

class UserCon {
  public function index() {
    var_dump($_POST);die;
    $openid = isset($_POST['openid']) ? $_POST['openid'] : null;
    var_dump($openid);die;
    UserSer::login($openid);
  }
}
