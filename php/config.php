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

		// 検索ボット向けの制御メタ情報 を head要素内に追加する。
        $px2conf = $px->conf();

		if( isset( $plugin_conf->robots->enable ) && $plugin_conf->robots->enable ){
			array_push($px2conf->funcs->processor->html, 'tomk79\pickles2\px2_seo_utils\robots::plugin('.json_encode($plugin_conf->robots).')');
		}

		if( isset( $plugin_conf->{'sitemap.xml'}->enable ) && $plugin_conf->{'sitemap.xml'}->enable ){
			array_push($px2conf->funcs->before_output, 'tomk79\pickles2\px2_seo_utils\sitemapXml::plugin('.json_encode($plugin_conf->{'sitemap.xml'}).')');
		}

        return;
	}

}
