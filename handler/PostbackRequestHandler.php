<?php
namespace ymdarake\tamai\bot\handler;


use ymdarake\tamai\bot\handler\Handler;
use ymdarake\tamai\bot\exception\UnhandleableEventTypeException;


use ymdarake\lib\Logger;

require_once(__DIR__ . "/Handler.php");
require_once(dirname(__DIR__) . "/exception/UnhandleableEventTypeException.php");

require_once(dirname(__DIR__) . "/lib/Logger.php");


class PostbackRequestHandler extends Handler {

	public function __construct($event) {
		parent::__construct($event);
	}

	public function handle() {

		if ($this->event->type != "postback") {
			throw new UnhandleableEventTypeException('postback', $this->event->type);
		}

		Logger::getInstance()->info($this->event->postback);

		return $this->replyMultiTextMessages($this->event->postback->data);
	}

}
