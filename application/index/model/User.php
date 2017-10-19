<?php

namespace app\index\model;

use \think\Db;

class User {
  public static function find($data) {
    return Db::name('users')
      ->where($data)
      ->find();
  }
}
