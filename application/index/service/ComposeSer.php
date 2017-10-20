<?php

namespace app\index\controller;

use app\index\service\Func;

class ComposeSer {

  public static function voiceCompose($reply) {
    if(empty($reply)) Func::callBack(301, '回复不能为空');
    $text = urlencode($reply);
    $access_token = Func::getAccessToken('1jzCUFD9pjaysq4TLULYs1Qk','aBQTEe3Pf8YtZaeok5T8nDaAX60CyxOz');
    $token = $access_token;
    $cuid  = uniqid();
    $url   = "http://tsn.baidu.com/text2audio?tex=$text&lan=zh&cuid=$cuid&ctp=1&tok=$access_token";
    $res   = file_get_contents($url);
    $fp    = fopen('/webdata/api/download/'.$cuid.'.mp3', 'w');
    if(!$fp) Func::callBack(302, '下载文件失败');
    fwrite($fp, $res);
    fclose($fp);
    return '/webdata/api/download/'.$cuid.'.mp3';
  }
}