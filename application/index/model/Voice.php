<?php

namespace app\index\model;

use \think\Db;

class Voice {
  public static function addOne($data) {
    return Db::name('voice')->insertGetId($data);
  }

  public static function find($data) {
    return Db::name('voice')
             ->where($data)
             ->find();
  }

  public static function update($data, $vid = 1) {
    return Db::name('voice')
             ->where('id', $vid)
             ->update($data);
  }

  public static function select($uid = 1, $start, $end) {
    return Db::name('voice')
             ->where('uid', $uid)
            //  ->where('date', 'between', "$start, $end")
             ->where('del', 0)
             ->select();
  }
}
