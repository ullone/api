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
}
