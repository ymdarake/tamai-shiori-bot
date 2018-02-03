<?php
namespace ymdarake\tamai\bot\application;


use ymdarake\lib\Logger;
use ymdarake\application\Application;

require_once(dirname(__DIR__) . "/lib/Logger.php");
require_once(__DIR__ . "/Application.php");


/**
 * Effective Java Builderパターンもどき
 * @see https://qiita.com/disc99/items/840cf9936687f97a482b
 */
class ApplicationBuilder {

	private $handler;
	private $logger;

	public function __construct($handler) {
		$this->handler = $handler;
	}

	public function logger($logger) {
		$this->logger = $logger;
		return $this;
	}

	public function build() {
		if (is_null($this->handler)) {
			throw new Exception("No handler set.");
		}
		if (is_null($this->logger)) {
			$this->logger = Logger::getInstance();
		}

		$application = new Application();
		$application->setLogger($this->logger);
		$application->setHandler($this->handler);
		return $application;
	}

}
