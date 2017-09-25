<?php
function callBack ($errno,$msg,$data = NULL) {
  exit (json_encode(
    array(
      'errno' => $errno,
      'msg'   => $msg,
      'data'  => $data
    ),JSON_UNESCAPED_UNICODE));
}

function debug ($data = NULL) {
  exit(var_dump($data));
}

function clearCookie ($name) {
  setcookie($name,'');
}

function array2Js ($data = array()) {
  return json_encode($data,JSON_UNESCAPED_UNICODE);
}

function js2Array ($data = '') {
  return json_decode($data,true);
}

function randStr($length, $type = 'all') {
  if ($type == 'all')
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  else if ($type == 'num')
    $chars='1234567890';
  else if ($type == 'upNum')
    $chars='QWERTYUIOPASDFGHJKLZXCVBNM0123456789';
  $str = "";
  for ($i = 0; $i < $length; $i++)
    $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
  return $str;
}

function doCurl($url, $method = 'get', $data = null, $cookie = null) {
	$header[] = 'User-Agent:Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1 wechatdevtools/0.7.0 MicroMessenger/6.3.9 Language/zh_CN webview/0';
  $header[] = 'Cookie:token='.$cookie.';';
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
	// return is_Array($response)?$response:js2Array($response);
  return $response;
}

function getTpl($fileName) {
  $tplPath = __DIR__ . "/index/view/" . $fileName . '.html';
  $tplContent = '';
  if(file_exists($tplPath))
    $tplContent = file_get_contents($tplPath);
  // foreach ($param as $key => $value) {
  //   $key = '${' . $key . '}';
  //   $tplContent = str_replace($key, $value, $tplContent);
  // }
  // $newFileName = array();
  // preg_match_all('/\${[A-z0-9]+}/', $tplContent, $newFileName, PREG_SET_ORDER);
  // foreach ($newFileName as $newValue) {
  //   $newFileNamePath = $newValue[0];
  //   $newFileNamePath = substr(substr($newFileNamePath, 2), 0,  strlen($newFileNamePath)-3);
  //   if(file_exists(__DIR__ . "/index/view/" . $newFileNamePath . ".html"))
  //     $tplContent = str_replace('${' . $newFileNamePath . '}', getTpl($newFileNamePath, array()), $tplContent);
  // }
  return $tplContent;
}
function admin_getTpl($fileName, $param = array()) {
  $tplPath = __DIR__ . "/admin/view/" . $fileName . '.html';
  $tplContent = '';
  if(file_exists($tplPath))
    $tplContent = file_get_contents($tplPath);
  foreach ($param as $key => $value) {
    $key = '${' . $key . '}';
    $tplContent = str_replace($key, $value, $tplContent);
  }
  $newFileName = array();
  preg_match_all('/\${[A-z0-9]+}/', $tplContent, $newFileName, PREG_SET_ORDER);
  foreach ($newFileName as $newValue) {
    $newFileNamePath = $newValue[0];
    $newFileNamePath = substr(substr($newFileNamePath, 2), 0,  strlen($newFileNamePath)-3);
    if(file_exists(__DIR__ . "/admin/view/" . $newFileNamePath . ".html"))
      $tplContent = str_replace('${' . $newFileNamePath . '}', admin_getTpl($newFileNamePath, array()), $tplContent);
  }
  return $tplContent;
}
