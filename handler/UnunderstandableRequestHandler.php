<?php
namespace ymdarake\tamai\bot\handler;


use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use ymdarake\tamai\bot\handler\Handler;

require_once(__DIR__ . "/Handler.php");


class UnunderstandableRequestHandler extends Handler {

	public function __construct($event) {
		parent::__construct($event);
	}

	public function handle() {
		return $this->reply(new TextMessageBuilder("いいかー！男ならハッキリしゃべれーーー！！！"));
	}

}
