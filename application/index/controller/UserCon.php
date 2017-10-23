<?php

namespace app\index\controller;

use \think\Cache;
use app\index\service\UserSer;
use app\index\service\ComposeSer;
use app\index\service\Comprehensions;

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
    $file = ComprehensionSer::semanticComprehension('明天我要去西藏');
    var_dump($file);die;
  }
}
