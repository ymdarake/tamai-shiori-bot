<?php

class Strings {
	
	public static function contains($haystack, $needle) {
		return mb_strpos($haystack, $needle) !== false;
	}

	public static function tryExtractKeyword($keywords, $examined, $default = "") {
		foreach ($keywords as $keyword) {
			if (Strings::contains($examined, $keyword)) {
				return $keyword;
			}
		}
		return $default;
	}

	public static function containsKeyword($keywords, $examined) {
		foreach ($keywords as $keyword) {
			if (Strings::contains($examined, $keyword)) {
				return true;
			}
		}
		return false;
	}

}
