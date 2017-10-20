<?php

namespace app\index\controller;

use \think\Cookie;
use \think\Cache;
use app\index\service\UserSer;
use app\index\service\ComposeSer;

class UserCon {

  public function getUserInfo($isLogin) {
    $userInfo = Cache::get($isLogin);
    return empty($userInfo) ? false : $userInfo;
  }

  public function index() {
    $code = isset($_POST['code']) ? $_POST['code'] : null;
    UserSer::login($code);
  }

  public function test() {
    $file = ComposeSer::voiceCompose('很抱歉，这句话我不理解');
    var_dump($file);die;
  }
}
