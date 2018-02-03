<?php

namespace ymdarake\lib;

class Logger {

	private static $instance;

	private function __construct() {
	}

	private function log($level, $message) {
		$dateTimeString = date("Y-m-d H:i:s");
		error_log("[{$level}]{$dateTimeString} {$message}.\n");
	}

	public static function getInstance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __call($methodName, $arguments) {
		$message = isset($arguments[0]) && is_string($arguments[0]) ? $arguments[0] : "No message given";
		$this->log($methodName, $message);
	}

}
