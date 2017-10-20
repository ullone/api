<?php

namespace app\index\model;

use \think\Db;

class User {
  public static function find($data, $field = '') {
    if(empty($field))
      return Db::name('user')
        ->where($data)
        ->find();
    else
      return Db::name('users')
        ->where($data)
        ->value($field);
  }

  public static function addOne($data) {
    return Db::name('voice')->insertGetId($data);
  }
}
