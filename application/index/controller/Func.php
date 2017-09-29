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
      "X-Appid:59bf7ad0",
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
}
