<?php
/**
 * px2-seo-utils
 */
namespace tomk79\pickles2\px2_seo_utils;

/**
 * config.php
 */
class config{

	/**
	 * config を一括してセットアップする
	 *
	 * @param object $px Picklesオブジェクト
	 * @param object $plugin_conf プラグイン設定
	 */
	public static function init( $px = null, $plugin_conf = null ){

		if( count(func_get_args()) <= 1 ){
			return __CLASS__.'::'.__FUNCTION__.'('.( is_array($px) ? json_encode($px) : '' ).')';
		}


		// px2-seo-utils
		// 検索ボット向けの制御メタ情報 を head要素内に追加する。
        $conf = $px->conf();
        array_push($conf->funcs->processor->html, 'tomk79\pickles2\px2_seo_utils\main::append('.json_encode(array(
		)).')');


		// $apply = new apply( $px );
		// $apply->append();
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
