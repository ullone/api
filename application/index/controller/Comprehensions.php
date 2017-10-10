<?php

namespace app\index\controller;

use app\index\controller\Func;

class Comprehensions {

  public function semanticComprehension() {//$voiceText为要转义的文本
    $access_token = $this->getAccessToken('1jzCUFD9pjaysq4TLULYs1Qk','aBQTEe3Pf8YtZaeok5T8nDaAX60CyxOz');
    $token  = $access_token ;
    $url    = 'https://aip.baidubce.com/rpc/2.0/solution/v1/unit_utterance?access_token=' . $token;
    $bodys  = "{\"scene_id\":11128,\"query\":\"明天我要去西藏。\", \"session_id\":\" \"}";
    //返回的数据及转换成为数组
    $res    = $this->requestPost($url, $bodys);
    $res    = json_decode($res, true);
    $result = empty($res['result']['qu_res']['intent_candidates']) ? null : $res['result']['qu_res']['intent_candidates'][0]['slots'];
    if($result === null) {
      $msg = $res['result']['action_list'][0]['say'];
      Func::callBack(101, $msg);
    }
    $data = array(
      'time'    => $res[0]['normalized_word'],
      'address' => $res[1]['normalized_word']
    );
    Func::callBack(0,'success',$data);//result为转义后的数组
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
