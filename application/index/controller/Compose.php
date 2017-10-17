<?php

namespace app\index\controller;

use app\index\controller\Func;

class Compose {

  public function voiceCompose() {
    $text = urlencode('好的，已经为您记录');
    $access_token = $this->getAccessToken('1jzCUFD9pjaysq4TLULYs1Qk','aBQTEe3Pf8YtZaeok5T8nDaAX60CyxOz');
    exit();
    $token        = $access_token;
    $cuid         = uniqid();
    exit('dfsa');
    $url          = "http://tsn.baidu.com/text2audio?tex=$text&lan=zh&cuid=$cuid&ctp=1&tok=$access_token";
    $res    = file_get_contents($url);
    $res    = json_decode($res, true);
    var_dump($res);die;
  }

  /**
   * 获取API访问授权码
   * @param ak: ak from baidu cloud app
   * @param sk: sk from baidu cloud app
   * @return - access_token string if succeeds, else false.
  */
  private function getAccessToken($ak, $sk) {
    $url = 'https://aip.baidubce.com/oauth/2.0/token';
    $post_data = array();
    $post_data['grant_type']  = 'client_credentials';
    $post_data['client_id']   = $ak;
    $post_data['client_secret'] = $sk;
    $res = $this->requestPost($url, $post_data);
    if (!!$res) {
        $res = json_decode($res, true);
        return $res['access_token'];
    } else {
        return false;
    }
  }

  /**
   * 发起http post请求(REST API), 并获取REST请求的结果
   * @param string $url
   * @param string $param
   * @return - http response body if succeeds, else false.
  */
  private function requestPost($url = '', $param = '') {
    if (empty($url) || empty($param)) {
        return false;
    }

    $postUrl = $url;
    $curlPost = $param;
    // 初始化curl
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $postUrl);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    // 要求结果为字符串且输出到屏幕上
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    // post提交方式
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
    // 运行curl
    $data = curl_exec($curl);
    curl_close($curl);

    return $data;
  }
}
