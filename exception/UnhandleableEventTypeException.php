<?php
namespace ymdarake\tamai\bot\exception;


class UnhandleableEventTypeException extends \Exception {

	public function __construct($expected, $given, $code = 0, $previous = null) {
		parent::__construct("Unexpected event type '{$given}'' given. Expected '{$expected}'.", $code, $previous);
	}

}
