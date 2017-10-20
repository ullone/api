<?php

namespace app\index\service;

use app\index\service\Func;
use app\index\service\ComposeSer;
use app\index\model\Voice;
use \think\Cookie;

class ComprehensionSer {

  public static function semanticComprehension($voiceText) {//$voiceText为要转义的文本
    $access_token = Func::getAccessToken('1jzCUFD9pjaysq4TLULYs1Qk','aBQTEe3Pf8YtZaeok5T8nDaAX60CyxOz');
    $token  = $access_token ;
    $url    = 'https://aip.baidubce.com/rpc/2.0/solution/v1/unit_utterance?access_token=' . $token;
    $bodys  = "{\"scene_id\":11128,\"query\":\"$voiceText\", \"session_id\":\" \"}";
    //返回的数据及转换成为数组
    $res    = Func::requestPost($url, $bodys);
    $res    = json_decode($res, true);
    $result = empty($res['result']['qu_res']['intent_candidates']) ? null : $res['result']['qu_res']['intent_candidates'][0]['slots'];
    if($result === null) {
      $msg = $res['result']['action_list'][0]['say'];
      $file = ComposeSer::voiceCompose($msg.',请重新录制');
      Cookie::clear('vid');
      Func::callBack(101, '文本转义失败', $file);
    }
    return $result;
  }

  public static function reply($data, $uid = 1) {
    //提取关键字
    $res  = array(
      'work' => '',
      'time' => ''
    );
    for($i = 0;$i < count($data);$i ++) {
      if($data[$i]['user_when']) $res['time'] = $data[$i]['normalized_word'];
      elseif($data[$i]['user_event']) $res['work'] .= $data[$i]['normalized_word'];
    }
    if(!empty($res['time'])) {
      if(strlen($res['time']) === 19) {
        $time   = strstr($res['time']), '|', true);
        $oclock = substr($res['time'], strpos($res['time']), '|') + 1, 5);
      } elseif(strlen($res['time'] === 10)) $time   = $res['time'];
      elseif(strlen($res['time'] === 8)) $oclock = $res['time'];
    }

    if(empty(Cookie::get('vid'))) {
      //第一次会话
      if(isset($time) && isset($oclock) && !empty($res['work'])) {
        //数据库记录
        Voice::addOne(array(
          'uid' => $uid,
          'date' => $time,
          'oclock' => $oclock,
          'work'   => $res['work'],
          'create_time' => date('Y-m-d H:i')
        ));
        $file = ComposeSer::voiceCompose('好的，已经为您记录');
        Func::callBack(0, '记录成功', $file);
      }
      if(empty($res['work'])) {
        //无事件
        if(!isset($time) && isset($oclock)) {
          //无日期
          $vid = Voice::addOne(array(
            'uid' => $uid,
            'date' => date('Y-m-d'),
            'oclock' => $oclock,
            'create_time' => date('Y-m-d H:i')
          ));
          Cookie::set('vid', $vid, 120);
          $file = ComposeSer::voiceCompose('好的，什么事情呢');
          Func::callBack(0, '记录成功', $file);
        } elseif(!isset($oclock) && isset($time)) {
          //无时间点
          $vid = Voice::addOne(array(
            'uid'  => $uid,
            'date' => $time,
            'create_time' => date('Y-m-d H:i')
          ));
          Cookie::set('vid', $vid, 120);
          $file = ComposeSer::voiceCompose('好的，什么事情,具体几点呢');
          Func::callBack(0, '记录成功', $file);
        } else {
          //仅无事件
          $vid = Voice::addOne(array(
            'uid'    => $uid,
            'date'   => $time,
            'oclock' => $oclock,
            'create_time' => date('Y-m-d H:i')
          ));
          Cookie::set('vid', $vid, 120);
          $file = ComposeSer::voiceCompose('好的，什么事情呢');
          Func::callBack(0, '记录成功', $file);
        }
      } else {
        if(isset($time) && !isset($oclock)) {
          //未设置时间点
          $vid = Voice::addOne(array(
            'uid' => $uid,
            'date' => $time,
            'work'   => $res['work'],
            'create_time' => date('Y-m-d H:i')
          ));
          $file = ComposeSer::voiceCompose('好的，具体几点呢');
          Cookie::set('vid', $vid, 120);
          Func::callBack(0, '记录成功', $file);
        } elseif(!isset($time) && isset($oclock)) {
          //未设置日期
          $vid = Voice::addOne(array(
            'uid' => $uid,
            'date' => date('Y-m-d'),
            'oclock' => $oclock,
            'work'   => $res['work'],
            'create_time' => date('Y-m-d H:i:s')
          ));
          $file = ComposeSer::voiceCompose('好的，已经为您记录');
          Func::callBack(0, '记录成功', $file);
        } else {
          //未设置时间
          $vid = Voice::addOne(array(
            'uid' => $uid,
            'work'   => $res['work'],
            'create_time' => date('Y-m-d H:i:s')
          ));
          $file = ComposeSer::voiceCompose('好的，具体哪一天，几点呢');
          Cookie::set('vid', $vid, 120);
          Func::callBack(0, '记录成功', $file);
        }
      }
    } else {
      //非第一次会话，用户补充内容
      $vid = Cookie::get('vid');
      if(isset($time)) Voice::update(array('date' => $time), $vid);
      if(isset($oclock)) Voice::update(array('oclock' => $oclock), $vid);
      if(!empty($res['work'])) Voice::update(array('work' => $res['work']), $vid);
      $data = Voice::find(array('vid' => $vid));
      if(($data['work'] != 0) && ($data['date'] != 0) && ($data['oclock'] !=0)) {
        //补充完成
        $file = ComposeSer::voiceCompose('好的，已经为您记录');
        Cookie::clear('vid');
        Func::callBack(0, '记录成功', $file);
      }
      if($data['work'] == 0) {
        if($data['oclock'] == 0) {
          $file = ComposeSer::voiceCompose('好的，什么事，具体几点呢');
          Cookie::set('vid', $vid, 120);//更新cookie时间
          Func::callBack(0, '记录成功', $file);
        } else {
          $file = ComposeSer::voiceCompose('好的，什么事呢');
          Cookie::set('vid', $vid, 120);//更新cookie时间
          Func::callBack(0, '记录成功', $file);
        }
      } else {
        if($data['oclock'] == 0 && $data['date'] != 0) {
          $file = ComposeSer::voiceCompose('好的，具体几点呢');
          Cookie::set('vid', $vid, 120);
          Func::callBack(0, '记录成功', $file);
        } else {
          $file = ComposeSer::voiceCompose('好的，请说出具体时间，哪一天，几点');
          Cookie::set('vid', $vid, 120);
          Func::callBack(0, '记录成功', $file);
        }
      }
    }
  }
}