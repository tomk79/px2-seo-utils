<?php
/**
 * px2-seo-utils
 */
namespace tomk79\pickles2\px2_seo_utils;

/**
 * robots.php
 */
class robots{

	/**
	 * Picklesオブジェクト
	 */
	private $px;

	/**
	 * プラグイン設定オブジェクト
	 */
	private $plugin_conf;

	/**
	 * 検索ボット向けの制御メタ情報 を head要素内に追加する。
	 *
	 * @param object $px Picklesオブジェクト
	 * @param object $plugin_conf プラグイン設定オブジェクト
	 */
	public static function plugin( $px, $plugin_conf = null ){
		$robots = new self( $px, $plugin_conf );
		$robots->append();
		return;
	}

	/**
	 * constructor
	 * @param object $px Picklesオブジェクト
	 * @param object $plugin_conf プラグイン設定オブジェクト
	 */
	public function __construct( $px, $plugin_conf = null ){
		$this->px = $px;
		$this->plugin_conf = $plugin_conf;
	}

	/**
	 * 検索ボット向けの制御メタ情報 を head要素内に追加する。
	 */
	public function append(){
		$key = 'main';
		$src = $this->px->bowl()->get_clean( $key );

		$cond = $this->get_conditions_auto();
		$meta = $this->tag($cond);

		$src = preg_replace('/(<\/head>)/si', $meta.'$1', $src);

		$this->px->bowl()->replace( $src, $key );

		return;
	}

	/**
	 * meta 要素を生成する
	 * @return string meta content string.
	 */
	public function tag( $cond = null ){
		$meta_content = $this->meta_content($cond);
		if( !strlen($meta_content) ){
			return '';
		}
		$meta = '<meta name="robots" content="'.htmlspecialchars($meta_content).'" />';
		$this->http_header($cond);

		return $meta;
	}

	/**
	 * HTTPヘッダー `X-Robots-Tag` を出力する
	 */
	private function http_header( $cond = null ){
		$meta_content = $this->meta_content($cond);
		if( !strlen($meta_content) ){
			return;
		}
		if( !headers_sent() ){
			header('X-Robots-Tag: '.$meta_content);
		}
		return;
	}

	/**
	 * 条件を取得する
	 * @return array 条件
	 */
	private function get_conditions_auto(){
		$cond = array(
			'follow' => null,
			'index' => null,
			'archive' => null,
		);
		if( !is_object($this->px) ){
			return $cond;
		}
		$cond['follow'] = $this->px->site()->get_current_page_info('robots:follow');
		$cond['index'] = $this->px->site()->get_current_page_info('robots:index');
		$cond['archive'] = $this->px->site()->get_current_page_info('robots:archive');

		/*
		// NOTE: `$plugin_conf->columnName` に、サイトマップ上のカラム名を設定できる機能を想定したが、
		// 有用かどうかわからないのでひとまず固定名とする。
		if( isset( $this->plugin_conf->columnName->follow ) && strlen($this->plugin_conf->columnName->follow) ){
			$cond['follow'] = $this->px->site()->get_current_page_info($this->plugin_conf->columnName->follow);
		}
		if( isset( $this->plugin_conf->columnName->index ) && strlen($this->plugin_conf->columnName->index) ){
			$cond['index'] = $this->px->site()->get_current_page_info($this->plugin_conf->columnName->index);
		}
		if( isset( $this->plugin_conf->columnName->archive ) && strlen($this->plugin_conf->columnName->archive) ){
			$cond['archive'] = $this->px->site()->get_current_page_info($this->plugin_conf->columnName->archive);
		}
		*/
		return $cond;
	}

	/**
	 * meta content 文字列を生成する
	 * @return string meta content string.
	 */
	private function meta_content( $cond = null ){
		if( !is_array($cond) ){
			return '';
		}
		$strs = array();
		foreach($cond as $key=>$val){
			switch( strtolower($key) ){
				case 'index':
				case 'follow':
				case 'archive':
					$str = $this->val_to_str($key, $val);
					if( strlen($str) ){
						array_push($strs, $str);
					}
					break;
			}
		}
		return implode(',', $strs);
	}

	/**
	 * meta content 値となる文字列を得る
	 * @return string string.
	 */
	private function val_to_str( $key, $val ){
		$bool = utils::to_boolean($val);
		if( $bool === true ){
			return $key;
		}elseif( $bool === false ){
			return 'no'.$key;
		}
		return '';
	}

}
