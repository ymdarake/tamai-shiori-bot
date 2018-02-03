<?php

use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;


abstract class Handler {

	protected $bot;
	protected $event;

	abstract protected function handle();

	public function __construct($event) {
		$this->bot = new LINEBot(
			new CurlHTTPClient(getenv(LINE_MESSAGE_API_CHANNEL_ACCESS_TOKEN)),
			['channelSecret' => getenv(LINE_MESSAGE_API_CHANNEL_SECRET)]
		);
		$this->event = $event;
	}

	protected function reply($messageBuilder) {
		return $this->bot->replyMessage($this->event->replyToken, $messageBuilder);
	}

	protected function replyMultiTextMessages(...$messages) {
		return $this->bot->replyText($this->event->replyToken, ...$messages);
	}



}
