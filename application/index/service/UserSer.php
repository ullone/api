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

    // $rand = UserSer::getUrandom();
    var_dump($uid);die;

    // Cache::set($res['session_key'], $res['session_key'].$res['openid'], 7200);
    // Func::callBack(0, '登录成功', $res['session_key']);
  }
}


public static function getUrandom($min = 0, $max = 0x7FFFFFFF)
{
  return 1;
        // $diff = $max - $min;
        // if ($diff > PHP_INT_MAX) {
        //     throw new RuntimeException('Bad Range');
        // }
        //
        // $fh = fopen('/dev/urandom', 'r');
        // stream_set_read_buffer($fh, PHP_INT_SIZE);
        // $bytes = fread($fh, PHP_INT_SIZE );
        // if ($bytes === false || strlen($bytes) != PHP_INT_SIZE ) {
        //     //throw new RuntimeException("nable to get". PHP_INT_SIZE . "bytes");
        //     return 0;
        // }
        // fclose($fh);
        //
        // if (PHP_INT_SIZE == 8) { // 64-bit versions
        //     list($higher, $lower) = array_values(unpack('N2', $bytes));
        //     $value = $higher << 32 | $lower;
        // }
        // else { // 32-bit versions
        //     list($value) = array_values(unpack('Nint', $bytes));
        //
        // }
        //
        // $val = $value & PHP_INT_MAX;
        // $fp = (float)$val / PHP_INT_MAX; // convert to [0,1]
        //
        // return (int)(round($fp * $diff) + $min);
}
