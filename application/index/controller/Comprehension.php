<?php

namespace app\index\controller;

use app\index\controller\Func;

class Comprehension {
  // private $text;
  //
  // public function __construct() {
  //   $this->text = isset($_POST['text'])?$_POST['text'] : '明天星期几';
  // }
  //
  // public function index() {
  //   if($this->text == null) exit('要转义的内容不能为空');
  //   $this->semanticComprehension();
  // }

  public function semanticComprehension($voiceText) {
      $text      = base64_encode($voiceText);
      $text      = 'text='.$text;
      $timestamp = time();
      //生成param参数
      $userid = '';
      for ($i = 0; $i < 10; $i++)
      {
        $userid .= chr(mt_rand(33, 126));
      }
      $param    = array('scene' => 'main', 'userid' => $userid);
      $param     = base64_encode(json_encode($param));
      $checkSum  = md5('156607c2a7704572ab0fbaa632a04880'.$timestamp.$param.$text);
      $url       = 'http://api.xfyun.cn/v1/aiui/v1/text_semantic';
      $data      = array(
        'timestamp' => $timestamp,
        'checkSum'  => $checkSum,
        'param'     => $param,
        'text'      => $text
      );
      $data = $this->doCurl($url, 'post', $data);
      $data = json_decode($data, true);
      if($data['code'] != '00000')
        Func::callBack(201, '调用讯飞文本语义接口失败，请检查参数');
      if(empty($data['data']['answer']['text']))
        Func::callBack(0, '语音录制成功', array('text' => $voiceText));
      Func::callBack(0, '成功录制语音并转义', array('text' => $data['data']['answer']['text']));
    }

    private function doCurl($url, $method = 'get', $data = null) {
      $header = [
        "X-Appid:59c37565",
        "X-CurTime:".$data['timestamp'],
        "X-Param:".$data['param'],
        "X-CheckSum:".$data['checkSum'],
      ];
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    	if($method == 'post') {
    		curl_setopt($ch, CURLOPT_POST, 1);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, $data['text']);
    	}
    	$response = curl_exec($ch);
    	if(curl_errno($ch)){
    		print curl_error($ch);
    	}
    	curl_close($ch);
      return $response;
    }

}
