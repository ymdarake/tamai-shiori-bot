<?php
namespace ymdarake\lib;


class Arrays {
	
	public static function random($array) {
		return $array[random_int(0, count($array) - 1)];
	}

}
