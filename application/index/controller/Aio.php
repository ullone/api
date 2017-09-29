<?php

namespace app\index\controller;

use app\index\controller\Func;

class Aio {
  private $text;
  public function __construct() {
    var_dump($_POST);die;
    $this->text = isset($_POST['text'])?$_POST['text'] : null;
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
      $param    = base64_encode(json_encode($param));
      $checkSum = 'daa3e49549c8481389ef01d2a4488f88'.$timestamp.$param.$text;
      $checkSum = md5($checkSum);
      $url      = 'http://api.xfyun.cn/v1/aiui/v1/text_semantic';
      $data     = array(
        'timestamp' => $timestamp,
        'checkSum'  => $checkSum,
        'param'     => $param,
        'text'      => $text
      );
      Func::doCurl($url, 'post', $data);
    }

}
