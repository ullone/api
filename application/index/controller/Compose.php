<?php

namespace app\index\controller;

use app\index\controller\Func;

class Compose {

  public function voiceCompose() {
    header("Content-type: audio/mp3");
    $text = urlencode('好的，已经为您记录');
    $access_token = Func::getAccessToken('1jzCUFD9pjaysq4TLULYs1Qk','aBQTEe3Pf8YtZaeok5T8nDaAX60CyxOz');
    $token        = $access_token;
    $cuid         = uniqid();
    exit('fail');
    $url          = "http://tsn.baidu.com/text2audio?tex=$text&lan=zh&cuid=$cuid&ctp=1&tok=$access_token";
    $res    = file_get_contents($url);
    var_dump($res);die;
  }
}
