<?php
namespace ymdarake\lib;


class Logger {

	private static $instance;

	private function __construct() {
	}

	private function log($level, $message) {
		$dateTimeString = date("Y-m-d H:i:s");
		error_log("\n[{$level}]{$dateTimeString} {$message}.\n");
	}

	public static function getInstance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __call($methodName, $arguments) {
		ob_start();
		var_dump($arguments);
		$message = ob_get_contents();
		ob_end_clean();
		$this->log($methodName, $message);
	}

}
