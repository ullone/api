<?php

namespace app\index\model;

use \think\Db;

class User {
  public static function find($data, $field = '') {
    if(empty($field))
      return Db::name('users')
        ->where($data)
        ->find();
    else
      return Db::name('users')
        ->where($data)
        ->value($field);
  }
}
