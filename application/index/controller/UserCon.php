<?php

namespace app\index\controller;

use \think\Cache;
use app\index\service\UserSer;
use app\index\service\ComposeSer;
use app\index\service\ComprehensionSer;

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
    header('Content-type: audio/mp3');
    $result = ComprehensionSer::semanticComprehension('明天我要去西藏');
    $file   = ComprehensionSer::reply($result);
    var_dump($file);die;
  }
}
