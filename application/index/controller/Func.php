<?php
namespace app\index\controller;

class Func {
  public static function callBack($code, $msg, $data = null, $isExist = true) {
    $data = Func::revert($data);
    $result = json_encode([
        'code'   =>  $code,
        'msg'     =>  $msg,
        'data'     =>  $data,
      ], JSON_UNESCAPED_UNICODE);
    if(!$isExist) return $result;
    exit($result);
  }

  public static function getToken() {
    foreach($_SERVER as $key => $value) {
      if($key === 'HTTP_TOKEN')
        return $value;
    }
  }

  private static function revert($data) {
    if(!is_array($data))
      return $data;
    $newData = array();
    foreach ($data as $key => $value) {
      $key = ($key === strtoupper($key))?strtolower($key):$key;
      $key = str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
      $key[0] = strtolower($key[0]);
      if(is_array($value))
        $value = Func::revert($value);
      $newData[$key] = $value;
    }
    return $newData;
  }

  public static function randStr($length, $type = 'all') {
    if ($type == 'all')
      $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    elseif ($type == 'num')
      $chars='1234567890';
    $str = "";
    for ($i = 0; $i < $length; $i++)
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    return $str;
  }

  public static function getTime($format = null) {
    $format = empty($format)?'Y-m-d H:i:s':$format;
    return date($format);
  }

  public static function debug($data = null) {
    exit(var_dump($data));
  }

  public static function js2Array($data = null) {
    if(is_string($data)) return json_decode($data, true);
    else return $data;
  }

  public static function doCurl($url, $method = 'get', $data = null) {
    $header = [
      "X-Appid:59c37565",
      "X-CurTime:".$data['timestamp'],
      "X-Param:".$data['param'],
      "X-CheckSum:".$data['checkSum'],
      "Content-Type:application/x-www-form-urlencoded;charset=utf-8",
    ];
  	$ch = curl_init();
  	curl_setopt($ch, CURLOPT_URL, $url);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  	if($method == 'post') {
  		curl_setopt($ch, CURLOPT_POST, 1);
  		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  	}
  	$response = curl_exec($ch);
  	if(curl_errno($ch)){
  		print curl_error($ch);
  	}
  	curl_close($ch);
    return $response;
  }

  /**
   * 获取API访问授权码
   * @param ak: ak from baidu cloud app
   * @param sk: sk from baidu cloud app
   * @return - access_token string if succeeds, else false.
  */
  public static function getAccessToken($ak, $sk) {
    $url = 'https://aip.baidubce.com/oauth/2.0/token';
    $post_data = array();
    $post_data['grant_type']  = 'client_credentials';
    $post_data['client_id']   = $ak;
    $post_data['client_secret'] = $sk;
    $res = Func::requestPost($url, $post_data);
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
  public static function requestPost($url = '', $param = '') {
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
