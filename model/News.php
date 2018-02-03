<?php
namespace ymdarake\tamai\bot\model;


class News {
	
	private $title;
	private $description;
	private $image;
	private $link;
	private $linkForTwitter;

	private $hasLink;

	public function __construct($title, $description, $image, $link) {
		$this->title = mb_substr($title, 0, LINE_CAROUSEL_TITLE_MAX_LENGTH, 'UTF-8');
		$this->description = mb_substr($description, 0, LINE_CAROUSEL_DESCRIPTION_MAX_LENGTH, 'UTF-8');
		$this->image = $this->isValidImageUrl($image) ? $image : NO_IMAGE_URL;
		$this->hasLink = $this->isValidLink($link);
		$this->link = $this->hasLink ? $link : GOOGLE_SEARCH_URL . urlencode($title);
		$this->linkForTwitter = $this->hasLink ? rawurlencode($link) : GOOGLE_SEARCH_URL . rawurlencode($title);
	}

	public function getTitle() {
		return $this->title;
	}
	public function getDescription() {
		return $this->description;
	}
	public function getImage() {
		return $this->image;
	}
	public function getLink() {
		return $this->link;
	}
	public function getLinkForTwitter() {
		return $this->linkForTwitter;
	}
	public function hasLink() {
		return $this->hasLink;
	}

	private function isValidImageUrl($url) {
		return !empty($url) && strpos($url, "https://") === 0;
	}

	private function isValidLink($url) {
		return !empty($url) && (strpos($url, "https://") === 0 || strpos($url, "http://") === 0);
	}

}
