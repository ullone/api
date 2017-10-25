<?php

namespace app\index\service;

use app\index\service\Func;

class VoiceSer {

  public static function getData($uid) {
    $start = date('Y-m-d');
    $end   = date('Y-m-d',strtotime('+1 week'));
    Voice::select($uid, $start, $end);
  }
}
