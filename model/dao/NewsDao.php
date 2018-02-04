<?php
namespace ymdarake\tamai\bot\model\dao;


use ymdarake\tamai\bot\model\News;


require_once(dirname(__DIR__) . "/News.php");


class NewsDao {

	public function __construct() {
	}

	public function fetch($searchWord = "") {
		return $this->toEntity(
			json_decode(
				file_get_contents(NEWS_API_ENDPOINT . "?word=$searchWord"),
				true
			)
		);
	}

	private function toEntity($assocArray) {
		return array_map(
			function ($news) {
				return new News($news['title'], $news['description'], $news['image'], $news['link']);
			},
			$assocArray
		);
	}

}