<?php
//单例模式
class Single {

  //设置一个私有静态成员供静态方法调用
  private static $instance;

  //将构造方法设置成私有的，以致外部不能实例化这个类的对象；
  private function __construct() {
    echo "实例化对象成功";
  }

  //设置一个公有静态单例方法，实例化一个类的对象提供给外部
  public static function getInstance() {
    if(!isset(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  //若用户尝试克隆对象，弹出一个用户级别的错误
  public function __clone() {
    trigger_error('<br>单例模式不能复制该类', E_USER_ERROR);
  }

  public function doSomething() {
    echo '<br>这样单例模式的类会提供一个且仅有一个对象来服务外部系统';
  }
}
// $obj = new Single();  调用私有方法__construct报错
$obj = Single::getInstance();
// $obj1 = clone $obj;   调用自定义__clone方法，报用户级别错误
$obj->doSomething();
