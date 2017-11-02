<?php

interface BaseCommand {
  public function execCommand($name);
}

class GeneralCommand implements BaseCommand {
  public function execCommand($name) {
    if($name != 'general') {
      return false;
    }
    else {
      echo "我是普通用户<br>";
      return true;
    }
  }
}

class VipCommand implements BaseCommand {
  public function execCommand($name) {
    if($name != 'vip') {
      return false;
    }
    else {
      echo "我是vip用户<br>";
      return true;
    }
  }
}

class ControlPanel {
  private $commands = array();

  public function addCommand($obj) {
    $this->commands[] = $obj;
  }

  public function runCommand($name) {
    foreach($this->commands as $obj) {
      if($obj->execCommand($name))
        return ;
    }
  }
}

$obj = new ControlPanel();
$obj->addCommand(new GeneralCommand);
$obj->addCommand(new VipCommand);
$obj->runCommand('general');
