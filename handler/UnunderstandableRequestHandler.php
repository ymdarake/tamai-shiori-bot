<?php
namespace ymdarake\tamai\bot\handler;


use ymdarake\tamai\bot\handler\Handler;

require_once(__DIR__ . "/Handler.php");


class UnunderstandableRequestHandler extends Handler {

	public function __construct($event) {
		parent::__construct($event);
	}

	public function handle() {
		return $this->replyMultiTextMessages("いいかー！男ならハッキリしゃべれーーー！！！");
	}

}
