<?php

use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

require_once(__DIR__ . "/Handler.php");
require_once(dirname(__DIR__) . "/MessageBuilderFactory.php");


class UnunderstandableRequestHandler extends Handler {

	public function __construct($event) {
		parent::__construct($event);
	}

	public function handle() {
		return $this->reply(new TextMessageBuilder("いいかー！男ならハッキリしゃべれーーー！！！"));
	}

}
