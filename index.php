<?php
/**
 * @link https://github.com/line/line-bot-sdk-php
 */

use ymdarake\tamai\bot\application\Application;
use ymdarake\tamai\bot\handler\TextRequestHandler;
use ymdarake\tamai\bot\handler\UnunderstandableRequestHandler;
use ymdarake\lib\Logger;


date_default_timezone_set("Asia/Tokyo");

// TODO: autoloader
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/config/config.php');
require_once(__DIR__ . "/application/Application.php");
require_once(__DIR__ . "/handler/TextRequestHandler.php");
require_once(__DIR__ . "/handler/UnunderstandableRequestHandler.php");
require_once(__DIR__ . "/lib/Logger.php");


$event = parseRequest();
$handler = getHandler($event);
$application = new Application();
$application->setHandler($handler);
$application->run();
exit;


function parseRequest() {
	$postData = file_get_contents('php://input');
	$json = json_decode($postData);
	Logger::getInstance()->info($json);
	$event = $json->events[0];
	return $event;
}

function getHandler($event) {
	
	if (!isset($event->message->type)) {
		Logger::getInstance()->warn("Event message type missing");
		return new UnunderstandableRequestHandler($event);
	}

	if ($event->message->type === "text") {
		return new TextRequestHandler($event);
	}

	return new UnunderstandableRequestHandler($event);
}
