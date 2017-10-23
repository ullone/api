<?php

namespace app\index\service;

use app\index\service\Func;
use app\index\service\Comprehensions;
use app\index\service\ComposeSer;

class Voice2textSer {

  public static function voiceToText($file) {
    $handle    = fopen($file,"rb");
    $content   = fread($handle,filesize($file));
    $tmp       = base64_encode($content);
    $text      = 'data='.$tmp;
    $timestamp = time();
    $param     = array('auf' => '16k', 'aue' => 'raw', 'scene' => 'main');
    $param     = base64_encode(json_encode($param));
    $checkSum  = md5('156607c2a7704572ab0fbaa632a04880'.$timestamp.$param.$text);
    $url       = 'http://api.xfyun.cn/v1/aiui/v1/iat';
    $header = [
        "X-Appid:59c37565",
        "X-CurTime:".$timestamp,
        "X-Param:".$param,
        "X-CheckSum:".$checkSum,
    ];
    $data = Func::doCurl($url, 'post', $text, $header);
    $data = json_decode($data, true);
    if($data["code"] != '00000')
      Func::callBack(107, '调用讯飞语音接口失败，请检查参数');
    if(empty($data['data']['result'])) {
      $file = ComposeSer::voiceCompose('很抱歉，这句话我难以理解!,请重新录制');
      $data = array(
        'code' => 108,
        'msg'  => '语音识别失败',
        'file' => $file
      );
      var_dump($data);die;
      Func::callBack(108, '语音识别失败', $file);
    }
    return $data['data']['result'];
  }
}
