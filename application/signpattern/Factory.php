<?php

//工厂模式  题外话：一个类可以同时实现多个接口，但一个类只能继承于一个抽象类。
//定义抽象类的好处：把共同的实现写在一个类里，提高代码重用性；
//子类实现父类的抽象方法便于拓展维护；

abstract class Operation {
  abstract public function getValue($value1, $value2);
}

class Add extends Operation {
  public function getValue($value1, $value2) {
    return $value1 + $value2;
  }
}

class Del extends Operation {
  public function getValue($value1, $value2) {
    return $value1 - $value2;
  }
}

class Mul extends Operation {
  public function getValue($value1, $value2) {
    return $value1 * $value2;
  }
}

class Div extends Operation {
  public function getValue($value1, $value2) {
    try {
       if ($value2==0){
           throw new Exception("除数不能为0");
       }else {
           return $value1/$value2;
       }
    } catch (Exception $e){
       echo "错误信息：".$e->getMessage();
    }
  }
}

class Factory {
  public function doWork($operation) {
    switch ($operation) {
      case '+':
        return new Add();
        break;

      case '-':
        return new Dec();
        break;

      case '*':
        return new Mul();
        break;

      case '/':
        return new Div();
        break;

      default:
        exit('暂无此功能');
        break;
    }
  }
}

$obj = new Factory();
$operate = $obj->doWork('/');
echo $operate->getValue(1, 2);
