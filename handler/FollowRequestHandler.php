<?php
namespace ymdarake\tamai\bot\handler;


use ymdarake\tamai\bot\handler\Handler;
use ymdarake\tamai\bot\exception\UnhandleableEventTypeException;


require_once(__DIR__ . "/Handler.php");
require_once(dirname(__DIR__) . "/exception/UnhandleableEventTypeException.php");

class FollowRequestHandler extends Handler {

	public function __construct($event) {
		parent::__construct($event);
	}

	public function handle() {

		if ($this->event->type != "follow") {
			throw new UnhandleableEventTypeException('follow', $this->event->type);
		}


		$userName = "";
		$response = $this->bot->getProfile($this->event->source->userId);
		if ($response->isSucceeded()) {
		    $profile = $response->getJSONDecodedBody();
		    $userName = $profile['displayName'];
		}
	    $selfIntroduce = "いいか" . $userName . "！！私が玉井詩織だーーーーっ！！！";
	    $followMe = "道は私が作るーーーっ！！！だから黙ってついてこーーーいっ！！！";
	    return $this->replyMultiTextMessages($selfIntroduce, $followMe);
	}

}
