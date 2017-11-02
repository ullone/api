<?php
//观察者模式

/**
 *
 */
interface Observer {
  public function onBuyTicket($ticket);
}

interface Observerable {
  public function addObserver($observer);
}

class Ticket implements Observerable {

  private $observers = [];

  public function addObserver($observer) {
    $this->observers[] = $observer;
  }

  public function buyTicket($ticket) {
    foreach($this->observers as $observer) {
      $observer->onBuyTicket($ticket);
    }
  }
}

class Message implements Observer {
  public function onBuyTicket($ticket) {
    echo "出票成功：$ticket, 已发短信通知<br>";
  }
}

class Log implements Observer {
  public function onBuyTicket($ticket) {
    echo "出票成功：$ticket, 已记录日志信息<br>";
  }
}

$ticket = new Ticket();
$ticket->addObserver(new Message());
$ticket->addObserver(new Log());
$ticket->buyTicket('明月几时有');
