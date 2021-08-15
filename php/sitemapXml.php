<?php
/**
 * px2-seo-utils
 */
namespace tomk79\pickles2\px2_seo_utils;

/**
 * sitemapXml.php
 */
class sitemapXml{

	/**
	 * Picklesオブジェクト
	 */
	private $px;

	/**
	 * プラグイン設定オブジェクト
	 */
	private $plugin_conf;

	/**
	 * sitemap.xml を生成する
	 *
	 * @param object $px Picklesオブジェクト
	 * @param object $plugin_conf プラグイン設定オブジェクト
	 */
	public static function plugin( $px, $plugin_conf = null ){
		$sitemapXml = new self( $px, $plugin_conf );
		// $robots->append();
		return;
	}

	/**
	 * constructor
	 * @param object $px Picklesオブジェクト
	 * @param object $plugin_conf プラグイン設定オブジェクト
	 */
	public function __construct( $px = null, $plugin_conf = null ){
		$this->px = $px;
		$this->plugin_conf = $plugin_conf;
	}

}
