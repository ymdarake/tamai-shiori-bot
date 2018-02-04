<?php

namespace ymdarake\tamai\bot\handler\helper;

final class PostbackData {
	const NEWS_SHIORI = "news.shiori";
	const NEWS_MOMOCLO = "news.momoclo";
	const NEWS_NATALIE = "news.natalie";
	const NEWS_CNN = "news.cnn";

	public static function all() {
		return [self::NEWS_SHIORI, self::NEWS_MOMOCLO, self::NEWS_NATALIE, self::NEWS_CNN];
	}

}
