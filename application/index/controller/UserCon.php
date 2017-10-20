<?php

namespace app\index\controller;

use \think\Cookie;
use app\index\service\UserSer;

class UserCon {
  public function index() {
    $openid = 'test';//isset($_POST['openid']) ? $_POST['openid'] : null;
    UserSer::login($openid);
  }
}
