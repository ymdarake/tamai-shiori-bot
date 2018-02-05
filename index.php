<?php
/**
 * @link https://github.com/line/line-bot-sdk-php
 */

use ymdarake\tamai\bot\application\ApplicationBuilder;
use ymdarake\tamai\bot\handler\FollowRequestHandler;
use ymdarake\tamai\bot\handler\TextRequestHandler;
use ymdarake\tamai\bot\handler\PostbackRequestHandler;
use ymdarake\tamai\bot\handler\UnunderstandableRequestHandler;
use ymdarake\lib\Logger;


date_default_timezone_set("Asia/Tokyo");

// TODO: autoloader
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/config/config.php');
require_once(__DIR__ . "/application/ApplicationBuilder.php");
require_once(__DIR__ . "/handler/FollowRequestHandler.php");
require_once(__DIR__ . "/handler/TextRequestHandler.php");
require_once(__DIR__ . "/handler/PostbackRequestHandler.php");
require_once(__DIR__ . "/handler/UnunderstandableRequestHandler.php");
require_once(__DIR__ . "/lib/Logger.php");


(new ApplicationBuilder(getHandler(parseRequest())))
	->build()
	->run();
exit;


function parseRequest() {
	$postData = file_get_contents('php://input');
	$json     = json_decode($postData);
	Logger::getInstance()->info($json);
	$event    = $json->events[0];
	return $event;
}

//TODO: use $bot->parseEventRequest
function getHandler($event) {

	if (!isset($event->type)) {
		Logger::getInstance()->warn("Event type missing");
		return new UnunderstandableRequestHandler($event);
	}

	if ($event->type === "message" && $event->message->type === "text") {
		return new TextRequestHandler($event);
	}

	if ($event->type === "postback") {
		return new PostbackRequestHandler($event);
	}

	if ($event->type === "follow") {
		return new FollowRequestHandler();
	}

	if ($event->type === "unfollow" || $event->type === "join" || $event->type === "leave" || $event->type === "beacon") {
		Logger::getInstance()->info("Not implemented: event '{$event->type}'");
		exit;
	}

	// 'image'    => 'LINE\LINEBot\Event\MessageEvent\ImageMessage',
	// 'video'    => 'LINE\LINEBot\Event\MessageEvent\VideoMessage',
	// 'audio'    => 'LINE\LINEBot\Event\MessageEvent\AudioMessage',
	// 'location' => 'LINE\LINEBot\Event\MessageEvent\LocationMessage',
	// 'sticker'  => 'LINE\LINEBot\Event\MessageEvent\StickerMessage',
	return new UnunderstandableRequestHandler($event);
}
