<?php
//策略模式

interface Eating {
  public function eat();
}

class EatWithChopsticks implements Eating {
  public function eat() {
    echo "我是用筷子吃饭的<br>";
  }
}

class EatWithSpoon implements Eating {
  public function eat() {
    echo "我是用勺子吃饭的<br>";
  }
}

class People {
  private $method;

  public function performEat() {
    $this->method->eat();
  }

  public function setMethod($obj) {
    $this->method = $obj;
  }
}

class Chinese extends People {

}

$obj1 = new Chinese();
$obj1->setMethod(new EatWithChopsticks);
$obj1->performEat();

//中国人学会了用勺子吃饭
$obj1->setMethod(new EatWithSpoon);
$obj1-> performEat();
