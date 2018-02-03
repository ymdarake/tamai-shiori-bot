<?php

namespace ymdarake\tamai\news\application;

use ymdarake\lib\Logger;
require_once(dirname(__DIR__) . "/lib/Logger.php");

class Application {

	private $handler;
	private $logger;

	public function __construct() {
		$this->logger = Logger::getInstance();
	}

	public function setHandler($handler) {
		$this->handler = $handler;
	}

	public function run() {
		try {
			$response = $this->handler->handle();
			$this->logger->info($response);
		}
		catch (Exception $ex) {
			$this->logger->error($ex->getMessage());
			$this->logger->error($ex->getTraceAsString());
		}
	}

}
