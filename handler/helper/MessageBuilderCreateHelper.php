<?php
namespace ymdarake\tamai\bot\handler\helper;


use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;

use ymdarake\tamai\bot\model\dao\NewsDao;
use ymdarake\lib\Strings;
use ymdarake\lib\Arrays;

require_once(dirname(__DIR__, 2) . "/lib/Strings.php");
require_once(dirname(__DIR__, 2) . "/lib/Arrays.php");
require_once(dirname(__DIR__, 2) . "/model/dao/NewsDao.php");

define("IMAGES_MAIN", ['shao-e-shao.jpg', 'bdbook.jpg', 'beer.jpg', 'line.jpg', 'onigiri.jpg', 'tanpopo.jpg']);
define("IMAGES_FOOD", ["onigiri.jpg", "wankosoba.jpg", "soba.jpg", "udon.jpg", "curry.jpg", "yakisoba.jpg"]);
define("IMAGES_ALCOHOL", ["beer.jpg", "beer2.jpg", "wine.jpg"]);

define("CAROUSEL_MAX_COUNT", 10);

/**
 * TODO: handlerに寄せてリファクタ
 * TODO: Androidだと音声が再生できない
 * @link https://github.com/line/line-bot-sdk-go/issues/30
 */
class MessageBuilderCreateHelper {

	private $text;

	public function __construct($text) {
		$this->text = is_string($text) ? $text : "";
	}

	public function create() {

		$templateResponseBuilder = $this->tryGetSpecificBuilder();
		if (!is_null($templateResponseBuilder)) {
			return $templateResponseBuilder;
		}

		if (rand(0, 20) === 0) {
			return $this->genAudioMessageBuilder();
		}
		if (rand(0, 5) === 0) {
			return $this->genImageMessageBuilder();
		}

		return $this->genTextMessageBuilder();
	}

	private function genTextMessageBuilder() {
	    include(MESSAGES_FILE_PATH);
	    $replyMessage = $MESSAGES[rand(0, count($MESSAGES) - 1)];
		return new TextMessageBuilder($replyMessage);
	}

	private function genImageMessageBuilder() {
		$image = APP_RESOURCE_PATH . Arrays::random(IMAGES_MAIN);
		return new ImageMessageBuilder($image, $image);
	}

	private function genAudioMessageBuilder() {
		return new AudioMessageBuilder(AUDIO_URL, 7000);
	}

	private function genExternalLinkCarouselTemplateMessageBuilder() {
		$uriActions = [
			["title" => "Instagram", "description" => "玉井詩織 公式Instagram", "image" => APP_RESOURCE_PATH . "instagram.jpg", "uri" => "https://www.instagram.com/shioritamai_official/"],
			["title" => "楽しおりん生活", "description" => "玉井詩織 公式ブログ", "image" => APP_RESOURCE_PATH . "tanoshiorin.png", "uri" => "https://ameblo.jp/tamai-sd/"],
			["title" => "スケジュール", "description" => "ももいろクローバーZ スケジュール", "image" => APP_RESOURCE_PATH . "shao-e-shao-rect.jpg", "uri" => "http://momoirocloverz.blog.fc2.com/blog-category-38.html"],
			["title" => "Instagram", "description" => "百田夏菜子 公式Instagram", "image" => "https://scontent-nrt1-1.cdninstagram.com/vp/7a2e7a4fdf075c7c45349c8ce58235c7/5B15A810/t51.2885-19/s150x150/27573355_803494643167452_3111618129944379392_n.jpg", "uri" => "https://www.instagram.com/kanakomomota_official/"],
		];

		$carouselColumnTemplateBuilders = [];
		foreach ($uriActions as $ua) {
			$carouselColumnTemplateBuilders[] = 
				new CarouselColumnTemplateBuilder(
					$ua["title"],
					$ua["description"],
					$ua["image"],
					[
						new UriTemplateActionBuilder("View", $ua["uri"])
					]
				);
		}
		$carouselTemplateBuilder = new CarouselTemplateBuilder($carouselColumnTemplateBuilders);
		return new TemplateMessageBuilder("外部リンク集", $carouselTemplateBuilder);
	}

	/**
	 * TODO: カルーセルの生成ロジックを分離
	 */
	private function genCarouselTemplateMessageBuilder($searchWord = "") {
		$news = (new NewsDao())->fetch($searchWord);
		$carouselCount = 0;
		$carouselColumnTemplateBuilders = [];
		foreach ($news as $n) {
			if ($carouselCount >= CAROUSEL_MAX_COUNT) {
				break;
			}
			if (!$n->hasLink()) {
				continue;
			}
			++$carouselCount;
			$carouselColumnTemplateBuilders[] = 
				new CarouselColumnTemplateBuilder(
					$n->getTitle(),
					$n->getDescription(),
					$n->getImage(),
					[
						new UriTemplateActionBuilder("詳細", $n->getLink()),
						new UriTemplateActionBuilder("ツイート", "https://twitter.com/intent/tweet?hashtags=しおったー&text=「" . rawurlencode($n->getTitle()) . "」&url=".$n->getLinkForTwitter())
					]
				);
		}
		$carouselTemplateBuilder = new CarouselTemplateBuilder($carouselColumnTemplateBuilders);
		return new TemplateMessageBuilder("新着ニュース", $carouselTemplateBuilder);
	}

	private function tryGetSpecificBuilder() {
		if ($this->isExternalLinks()) {
			return $this->genExternalLinkCarouselTemplateMessageBuilder();
		}
		if ($this->isNews()) {
			return $this->genCarouselTemplateMessageBuilder();
		}
		if ($this->isMomocloNews()) {
			return $this->genCarouselTemplateMessageBuilder($this->getMomocloKeywordRandom());
		}
		if ($this->isNatalie()) {
			return $this->genCarouselTemplateMessageBuilder("natalie");
		}
		if ($this->isHaraheri()) {
			$image = APP_RESOURCE_PATH . Arrays::random(IMAGES_FOOD);
			return new ImageMessageBuilder($image, $image);
		}
		if ($this->isThirsty()) {
			$image = APP_RESOURCE_PATH . Arrays::random(IMAGES_ALCOHOL);
			return new ImageMessageBuilder($image, $image);
		}
		if ($this->isTemplateRequestMessageImage()) {
			return $this->genImageMessageBuilder();
		}
		if ($this->isTemplateRequestMessageAudio()) {
			return $this->genAudioMessageBuilder();
		}
		return null;
	}

	private function isExternalLinks() {
		return Strings::containsKeyword(["インスタ", "instagram", "スケジュール", "ブログ", "リンク集", "外部リンク"], $this->text);
	}

	private function isNews() {
		return Strings::containsKeyword(["世間", "時代"], $this->text);
	}
	private function isMomocloNews() {
		return Strings::containsKeyword(['\uD83C\uDF40', "ニュース", "速報", "しおったー", "最新", "情報"], $this->text);
	}
	private function isNatalie() {
		return Strings::containsKeyword(["ナタリー", "natalie"], strtolower($this->text));
	}
	private function getMomocloKeywordRandom() {
		$whiteList = ["玉井詩織", "百田夏菜子", "ももクロ", "ももいろクローバーZ", "佐々木彩夏", "高城れに", "ももいろクローバー"];
		return Arrays::random($whiteList);
	}

	private function isHaraheri() {
		return Strings::containsKeyword(["腹減った", "お腹空いた", "おなかすいた", "はらへった"], $this->text);
	}

	private function isThirsty() {
		return Strings::containsKeyword(["飲もう", "のもう", "かわいた", "ビール", "ワイン", "お酒", "おさけ", "こども", "ガキ"], $this->text);
	}

	private function isTemplateRequestMessageImage() {
		return Strings::containsKeyword(["画像", "写真"], $this->text);
	}

	private function isTemplateRequestMessageAudio() {
		return Strings::containsKeyword(["シュプレヒコール", "叫", "声", "喋"], $this->text);
	}

}
