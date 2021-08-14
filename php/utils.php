<?php
/**
 * px2-seo-utils
 */
namespace tomk79\pickles2\px2_seo_utils;

/**
 * utils.php
 */
class utils{

	/**
	 * Boolean で評価する
	 * @param mixed $val 評価対象
	 * @return boolean 真偽評価した結果。 または `null` を返す場合があります。
	 */
	public static function to_boolean( $val ){
		if( is_bool( $val ) ){
			// boolean 値はそのまま返却
			return $val;
		}
		if( is_null( $val ) ){
			// null 値はそのまま返却
			return $val;
		}
		if( is_string( $val ) ){
			$val = strtolower($val);
			$val = trim($val);
			switch( $val ){
				case 'true':
				case 'yes':
				case 'on':
					return true;
					break;
				case 'false':
				case 'no':
				case 'off':
					return false;
					break;
				case 'null':
				case '':
					return null;
					break;
			}
			if( preg_match('/^(?:\-|\+)?[0-9]+(?:\.[0-9]*)?$/', $val) ){
				$val = intval($val);
			}
		}
		if( is_int($val) || is_double($val) || is_float($val) ){
			if( $val < 0 ){
				return false;
			}
		}

		return !!$val;
	}

}
