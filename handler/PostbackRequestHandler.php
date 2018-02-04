<?php
namespace ymdarake\tamai\bot\handler;


use ymdarake\tamai\bot\handler\Handler;
use ymdarake\tamai\bot\exception\UnhandleableEventTypeException;

require_once(__DIR__ . "/Handler.php");
require_once(dirname(__DIR__) . "/exception/UnhandleableEventTypeException.php");

class PostbackRequestHandler extends Handler {

	public function __construct($event) {
		parent::__construct($event);
	}

	public function handle() {

		//TODO: ボットでパースしてないせいか、postback'で取れてくる
		if ($this->type != "postback" && $this->type != "postback'") {
			throw new UnhandleableEventTypeException('postback', $this->event->type);
		}

		return $this->replyMultiTextMessages($this->event->data);
	}

}
