<?php

use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;


abstract class Handler {

	protected $bot;
	protected $event;

	abstract protected function handleImpl();

	public function __construct($event) {
		$this->bot = new LINEBot(
			new CurlHTTPClient(getenv(LINE_MESSAGE_API_CHANNEL_ACCESS_TOKEN)),
			['channelSecret' => getenv(LINE_MESSAGE_API_CHANNEL_SECRET)]
		);
		$this->event = $event;
	}

	public function handle() {
		return $this->handleImpl();
	}

	protected function reply($messageBuilder) {
		$response = $this->bot->replyMessage($this->event->replyToken, $messageBuilder);
		$this->log($response);
	}

	protected function replyMultiTextMessages(...$messages) {
		$this->bot->replyText($this->event->replyToken, ...$messages);
	}

	protected function log($data) {
		ob_start();
		var_dump($data);
		$str = ob_get_contents();
		ob_end_clean();
		error_log(get_class($this));
		error_log($str);
	}

}
