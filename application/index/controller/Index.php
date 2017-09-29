<?php
namespace app\index\controller;

use \think\View;
use app\index\controller\Upload;

class Index {
    public function index() {
        $upload = new Upload();
        $upload->index();
    }

    private function checkToken() {
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $rand      = $_GET['rand'];
        $token     = '8b0b255ffb10cd97';
        $tmpArr = array($token, $timestamp, $rand);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if($tmpStr == $signature) {
          echo sha1($token);
          exit;
        }
    }
}
