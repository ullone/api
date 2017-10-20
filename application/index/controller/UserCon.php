<?php

namespace app\index\controller;

use \think\Cookie;
use \think\Cache;
use app\index\service\UserSer;

class UserCon {

  public function getUserInfo($isLogin) {
    $userInfo = Cache::get($isLogin);
    return empty($userInfo) ? false : $userInfo;
  }

  public function index() {
    $code = isset($_POST['code']) ? $_POST['code'] : null;
    UserSer::login($code);
  }
}
