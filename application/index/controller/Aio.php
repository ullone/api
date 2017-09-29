<?php

namespace app\index\controller;

use app\index\controller\Func;

class Aio {
  private $text;

  public function __construct() {
    $this->text = isset($_POST['text'])?$_POST['text'] : '明天星期几';
  }

  public function index() {
    if($this->text == null) exit('要转义的内容不能为空');
    $this->semanticComprehension();
  }

  public function semanticComprehension() {
      $text      = $this->text;
      $text      = base64_encode($text);
      $text      = 'text='.$text;
      $timestamp = time();
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
      $this->doCurl($url, 'post', $data);
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
      $data = json_decode($response, true);
      $data = json_encode($data, JSON_UNESCAPED_UNICODE);
      exit($data);
    }

}
