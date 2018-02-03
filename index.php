<?php
/**
 * @link https://github.com/line/line-bot-sdk-php
 */

// TODO: autoloader


require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/config/config.php');
require_once(__DIR__ . "/handler/TextRequestHandler.php");
require_once(__DIR__ . "/handler/UnunderstandableRequestHandler.php");



$event = parseRequest();
$handler = getHandler($event);
$handler->handle();//TODO: give event
exit;


function parseRequest() {
	$postData = file_get_contents('php://input');
	error_log($postData);
	$json = json_decode($postData);
	$event = $json->events[0];
	return $event;
}

function getHandler($event) {
	
	if (!isset($event->message->type)) {
		error_log("Event message type missing.");
		return new UnunderstandableRequestHandler($event);
	}

	if ($event->message->type === "text") {
		return new TextRequestHandler($event);
	}

	return new UnunderstandableRequestHandler($event);
}