<?php

namespace app\index\service;

use app\index\service\Func;
use app\index\model\Voice;

class VoiceSer {

  public static function getData($uid) {
    $start = date('Y-m-d');
    $end   = date('Y-m-d',strtotime('+1 week'));
    // var_dump($uid);die;// var_dump($start);var_dump($end);die;
    $data  = Voice::select($uid, $start, $end);
    Func::callBack(0, '获取成功', $data);
  }
}
