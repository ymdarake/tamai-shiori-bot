<?php
namespace ymdarake\tamai\bot\handler;


use ymdarake\tamai\bot\handler\Handler;
use ymdarake\tamai\bot\exception\UnhandleableEventTypeException;
use ymdarake\tamai\bot\exception\UnhandleablePostbackDataException;
use ymdarake\tamai\bot\handler\helper\PostbackData;
use ymdarake\tamai\bot\handler\helper\MessageBuilderCreateHelper;


require_once(__DIR__ . "/Handler.php");
require_once(dirname(__DIR__) . "/exception/UnhandleableEventTypeException.php");
require_once(dirname(__DIR__) . "/exception/UnhandleablePostbackDataException.php");
require_once(__DIR__ . "/helper/MessageBuilderCreateHelper.php");

class PostbackRequestHandler extends Handler {

	public function __construct($event) {
		parent::__construct($event);
	}

	public function handle() {

		if ($this->event->type != "postback") {
			throw new UnhandleableEventTypeException('postback', $this->event->type);
		}

		if (in_array($this->event->postback->data, PostbackData::all())) {
			//TODO: ロジックを分離
			return $this->reply((new MessageBuilderCreateHelper())->genCarouselTemplateMessageBuilder($this->event->postback->data));
		}

		throw new UnhandleablePostbackDataException($this->event->postback->data);
	}

}
