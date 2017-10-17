<?php

namespace app\index\controller;

use app\index\controller\Func;

class Comprehensions {

  public function semanticComprehension($voiceText) {//$voiceText为要转义的文本
    $access_token = Func::getAccessToken('1jzCUFD9pjaysq4TLULYs1Qk','aBQTEe3Pf8YtZaeok5T8nDaAX60CyxOz');
    $token  = $access_token ;
    $url    = 'https://aip.baidubce.com/rpc/2.0/solution/v1/unit_utterance?access_token=' . $token;
    $bodys  = "{\"scene_id\":11128,\"query\":\"$voiceText\", \"session_id\":\" \"}";
    //返回的数据及转换成为数组
    $res    = Func::requestPost($url, $bodys);
    $res    = json_decode($res, true);
    $result = empty($res['result']['qu_res']['intent_candidates']) ? null : $res['result']['qu_res']['intent_candidates'][0]['slots'];
    if($result === null) {
      $msg = $res['result']['action_list'][0]['say'];
      Func::callBack(101, $msg);
    }
    $time  = strstr($result[0]['normalized_word'],'|',true);
    if(!$time) {
      //返回字符串中无'|',用户语音未输入具体时间
      $time  = $result[0]['normalized_word'];
      $clock = '00:00';
    } else {
      $clock = substr($result[0]['normalized_word'], strpos($result[0]['normalized_word'], '|')+1, 5);
    }
    $data  = array(
      'time'    => $time,
      'clock'   => $clock,
      'address' => $result[1]['normalized_word']
    );
    Func::callBack(0,'转义成功',$data);//result为转义后的数组
  }
}
