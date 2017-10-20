<?php

namespace app\index\service;

use app\index\model\User;
use app\index\service\Func;
use \think\Cache;

class UserSer {
  public static function login($code) {
    if($code === null) Func::callBack(301, '获取code失败');
    $url = "https://api.weixin.qq.com/sns/jscode2session?appid=wx61c00f82c85f0036&secret=97e7d6904e1f52ce70957c62e1756c23&js_code=$code&grant_type=authorization_code";
    $header = [
      "content-type:application/x-www-form-urlencoded"
    ];
    $res = Func::doCurl($url, 'get', '', $header);
    $res = json_decode($res, true);
    if(!isset($res['openid'])) Func::callBack(301, '登陆失败');
    //openid获取成功
    if(!($uid = User::find(array('openid' => $res['openid']), 'id'))) {
      $uid = User::addOne(array('openid' => $res['openid'], 'create_time' => date('Y-m-d H:i:s')));
    }

    $pr_bits = '';
    $fp = @fopen('/dev/urandom','rb');
    if ($fp !== FALSE) {
        $pr_bits .= @fread($fp, 16);
        @fclose($fp);
    }
    var_dump($pr_bits);die;

    Cache::set($res['session_key'], $res['session_key'].$res['openid'], 7200);
    Func::callBack(0, '登录成功', $res['session_key']);
  }
}
