<?php
//适配器模式

//甲乙三个公司生产玩具狗类，狗有开口闭口两个行为，甲乙分别对此做出了实现；
//如今丙公司与甲乙合作，用遥控控制玩具狗的开口闭口。

abstract class Toy {
  public abstract function openMouth();
  public abstract function closeMouth();
}

class Dog extends Toy {
  public function openMouth() {
    echo "dog open the mouth<br>";
  }

  public function closeMouth() {
    echo "dog close the mouth<br>";
  }
}

//甲公司dog接口
interface Red {
  public function doOpen();
  public function doClose();
}

//乙公司dog接口
interface Green {
  public function open();
  public function close();
}

//甲公司适配器
class RedAdapter implements Red {
  private $adapter;

  public function __construct(Toy $obj) {
    $this->adapter = $obj;
  }

  public function doOpen() {
    $this->adapter->openMouth();
  }

  public function doClose() {
    $this->adapter->closeMouth();
  }
}

//乙公司适配器
class GreenAdapter implements Green {
  private $adapter;

  public function __construct(Toy $obj) {
    $this->adapter = $obj;
  }

  public function Open() {
    $this->adapter->openMouth();
  }

  public function Close() {
    $this->adapter->closeMouth();
  }
}

$dog = new Dog();
$adapter = new RedAdapter($dog);
$adapter->doOpen();//仍然使用甲公司的doOpen方法
$adapter->doClose();
