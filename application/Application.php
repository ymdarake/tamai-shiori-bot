<?php
namespace ymdarake\tamai\bot\application;


use ymdarake\lib\Logger;

require_once(dirname(__DIR__) . "/lib/Logger.php");

class Application {

	private $handler;
	private $logger;

	public function __construct() {
	}

	public function setHandler($handler) {
		$this->handler = $handler;
	}
	public function setLogger($logger) {
		$this->logger = $logger;
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
