<?php
namespace ymdarake\tamai\bot\exception;


class UnhandleablePostbackDataException extends \Exception {

	public function __construct($given, $code = 0, $previous = null) {
		parent::__construct("Unexpected postback data '{$given}' given.", $code, $previous);
	}

}
