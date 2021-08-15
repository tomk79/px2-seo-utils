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

		if( $px->req()->get_request_file_path() == $plugin_conf->trigger ){
			$sitemapXml->generate_sitemapxml();
		}
		return;
	}

	/**
	 * constructor
	 *
	 * @param object $px Picklesオブジェクト
	 * @param object $plugin_conf プラグイン設定オブジェクト
	 */
	public function __construct( $px = null, $plugin_conf = null ){
		$this->px = $px;
		$this->plugin_conf = $plugin_conf;

		if( !isset($this->plugin_conf->trigger) || !strlen($this->plugin_conf->trigger) ){
			$this->plugin_conf->trigger = '/index.html';
		}
		if( !isset($this->plugin_conf->dist) || !strlen($this->plugin_conf->dist) ){
			$this->plugin_conf->dist = '/sitemap.xml';
		}
	}


	/**
	 * サイトマップXMLを生成する
	 */
	public function generate_sitemapxml(){

		$sitemap = $this->px->site()->get_sitemap();
		$sitemapXml = '';
		$sitemapXml .= '<'.'?xml version="1.0" encoding="UTF-8"?'.'>'."\n";
		$sitemapXml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">'."\n";
		foreach( $sitemap as $page_info ){
			$sitemapXml .= '<url>'."\n";
			$sitemapXml .= '	<loc>'.htmlspecialchars( $this->px->canonical( $page_info['path'] ) ).'</loc>'."\n";
			$sitemapXml .= '	<priority>1.0</priority>'."\n";
			if( isset($page_info['update_date']) && strlen( $page_info['update_date'] ) ){
				$timestamp = strtotime($page_info['update_date']);
				$sitemapXml .= '	<lastmod>'.htmlspecialchars( date('c', $timestamp) ).'</lastmod>'."\n";
			}
			$sitemapXml .= '	<changefreq>weekly</changefreq>'."\n";
			$sitemapXml .= '</url>'."\n";
		}
		$sitemapXml .= '</urlset>'."\n";

		$realpath_controot = $this->px->fs()->get_realpath( './' );
		$dist = $this->px->fs()->get_realpath( $realpath_controot.'/'.$this->plugin_conf->dist );
		$result = $this->px->fs()->save_file($dist, $sitemapXml);

		return !!$result;
	}

}
