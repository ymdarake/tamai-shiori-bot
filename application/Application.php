<?php

class Application {

	private $handler;
	private $logger;

	public function __construct() {

	}

	public function setHandler($handler) {
		$this->handler = $handler;
	}

	// TODO: trye - catch - log
	public function run() {
		$response = $this->handler->handle();
		$this->log($response);
	}

	//TODO: logger
	private function log($data) {
		ob_start();
		var_dump($data);
		$str = ob_get_contents();
		ob_end_clean();
		error_log(get_class($this));
		error_log($str);
	}

}
