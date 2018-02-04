<?php

namespace ymdarake\tamai\bot\handler\helper;

final class PostbackData {
	const NEWS_SHIORI = "news.shiori";
	const NEWS_KANAKO = "news.kanako";
	const NEWS_MOMOCLO = "news.momoclo";
	const NEWS_NATALIE = "news.natalie";
	const NEWS_CNN = "news.cnn";

	public static function all() {
		return [self::NEWS_SHIORI, self::NEWS_KANAKO, self::NEWS_MOMOCLO, self::NEWS_NATALIE, self::NEWS_CNN];
	}

	public function toSearchKeyword($postbackData) {
		$map = [
			self::NEWS_SHIORI => "玉井詩織",
			self::NEWS_KANAKO => "百田夏菜子",
			self::NEWS_MOMOCLO => "ももクロ",
			self::NEWS_NATALIE => "natalie",
			self::NEWS_CNN => "",
		];
		return isset($map[$postbackData]) ? $map[$postbackData] : self::NEWS_MOMOCLO;
	}

}
