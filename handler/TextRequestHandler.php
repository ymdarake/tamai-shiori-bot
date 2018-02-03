<?php

use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

require_once(__DIR__ . "/Handler.php");
require_once(dirname(__DIR__) . "/MessageBuilderFactory.php");
require_once(dirname(__DIR__) . "/lib/Strings.php");


class TextRequestHandler extends Handler {

	public function __construct($event) {
		parent::__construct($event);
	}

	public function handle() {
		// イベントタイプがmessage以外はスルー
		if ($this->event->type != "message") {
			error_log(__CLASS__ . ": event type 'message' expected, but '{$this->event->type}' given.");
		    return;
		}

		// NOTE: able to send multi messages when specific keyword given.
		if ($keyword = Strings::tryExtractKeyword(RIVAL_NAMES, $this->event->message->text)) {
			return $this->replyMultiTextMessages(
				"何が{$keyword}だー！浮かれるなー！",
				"http://www.momoclo.net/",
				"https://natalie.mu/music/news/list/artist_id/7630",
				"ちゃんと読んどけよー！！"
			);
		}

		return $this->reply((new MessageBuilderFactory($this->event->message->text))->create());
	}

}
