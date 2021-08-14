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
	 * 検索ボット向けの制御メタ情報 を head要素内に追加する。
	 *
	 * @param object $px Picklesオブジェクト
	 */
	public static function append( $px, $plugin_conf ){
		$apply = new apply( $px );
		$apply->append();
	}


	/**
	 * 検索ボット向けの制御メタタグ を生成して取得する。
	 *
	 * @param object $px Picklesオブジェクト
	 */
	public static function tag( $cond = null ){
		$apply = new apply();
		return $apply->tag($cond);
	}

}
