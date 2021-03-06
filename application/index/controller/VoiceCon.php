<?php

namespace app\index\controller;

use app\index\service\UploadSer;
use app\index\service\ComposeSer;
use app\index\service\ComprehensionSer;
use app\index\service\Voice2textSer;
use app\index\service\VoiceSer;
use app\index\service\Func;
use app\index\controller\UserCon;
use \think\Cookie;

class VoiceCon {

  private $userInfo;

  public function __construct() {
    $isLogin = $_GET['isLogin'];
    if(!$isLogin) Func::callBack('602', '请先登陆');
    $user = new UserCon();
    $this->userInfo = $user->getUserInfo($isLogin);
    if(!$this->userInfo) Func::callBack('601', '登陆已过期');
  }

  public function index() {
    $data = $this->upload();
    // $this->silkToText($data);
  }

  public function getData() {
    VoiceSer::getData($this->userInfo['uid']);
  }

  private function upload() {
    $data = array(
      'upload_name'       => isset($_FILES['file']['name']) ? $_FILES['file']['name'] : null, //取得上传文件名
      'upload_filetype'   => isset($_FILES['file']['type']) ? $_FILES['file']['type'] : null,
      'upload_tmp_name'   => isset($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'] : null,
      'upload_file_size'  => isset($_FILES['file']['size']) ? $_FILES['file']['size'] : 0,
      'upload_target_dir' => '/webdata/api/upload/silk-v3-decoder-master/upload',
      'allow_uploadedfile_type' => array('jpeg','silk','jpg','png','gif','doc','zip','rar','txt')
    );
    $res = array();
    $res = UploadSer::upload($data);
    $this->silkToText($res);
  }

  private function silkToText($data) {
    $file = UploadSer::silkToWav($data['dir'], $data['name']);
    $text = Voice2textSer::voiceToText($file);
    $data = ComprehensionSer::semanticComprehension($text, $this->userInfo['uid']);
    ComprehensionSer::reply($data, $this->userInfo['uid']);
  }

}
