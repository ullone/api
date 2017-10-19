<?php

namespace app\index\controller;

use \think\Cookie;
use app\index\service\UserSer;

class UserCon {
  public function index() {
    $code = isset($_POST['code']) ? $_POST['code'] : null;
    UserSer::login($code);
  }
}
