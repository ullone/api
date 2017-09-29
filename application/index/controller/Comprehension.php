<?php

namespace app\index\controller;

use app\index\controller\Func;

class Comprehension {
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
      $data = Func::doCurl($url, 'post', $data);
      $data = json_decode($response, true);
      $data = json_encode($data, JSON_UNESCAPED_UNICODE);
      exit($data);
    }

}
