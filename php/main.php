<?php
/**
 * px2-seo-utils
 */
namespace tomk79\pickles2\px2_seo_utils;

/**
 * main.php
 */
class main{

	/**
	 * Picklesオブジェクト
	 */
	private $px;

	/**
	 * プラグイン設定オブジェクト
	 */
	private $plugin_conf;

	/**
	 * constructor
	 *
	 * @param object $px Picklesオブジェクト
	 * @param object $plugin_conf プラグイン設定オブジェクト
	 */
	public function __construct( $px = null, $plugin_conf = null ){
		$this->px = $px;
		$this->plugin_conf = $plugin_conf;
	}

	/**
	 * robotsオブジェクトを生成して返す
	 *
	 * @param array $cond メタタグ生成の条件
	 */
	public function robots(){
		$robots = new robots( $this->px );
		return $robots;
	}

}
