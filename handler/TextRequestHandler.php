<?php
namespace ymdarake\tamai\bot\handler;


use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use ymdarake\tamai\bot\handler\Handler;
use ymdarake\tamai\bot\handler\helper\MessageBuilderCreateHelper;
use ymdarake\tamai\bot\exception\UnhandleableEventTypeException;
use ymdarake\lib\Strings;

require_once(__DIR__ . "/Handler.php");
require_once(dirname(__DIR__) . "/helper/MessageBuilderCreateHelper.php");
require_once(dirname(__DIR__) . "/lib/Strings.php");
require_once(dirname(__DIR__) . "/exception/UnhandleableEventTypeException.php");

class TextRequestHandler extends Handler {

	public function __construct($event) {
		parent::__construct($event);
	}

	public function handle() {

		if ($this->event->type != "message") {
			throw new UnhandleableEventTypeException('message', $this->event->type);
		}

		if ($keyword = Strings::tryExtractKeyword(RIVAL_NAMES, $this->event->message->text)) {
			return $this->replyMultiTextMessages(
				"何が{$keyword}だー！浮かれるなー！",
				"http://www.momoclo.net/",
				"https://natalie.mu/music/news/list/artist_id/7630",
				"ちゃんと読んどけよー！！"
			);
		}

		return $this->reply((new MessageBuilderCreateHelper($this->event->message->text))->create());
	}

}
