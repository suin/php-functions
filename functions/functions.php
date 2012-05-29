<?php
/**
 * 便利なPHP関数まとめ
 *
 * PHP Version 5.2.0 or Upper version
 *
 * @package    Suin's PHP Functions
 * @author     Hidehito NOZAWA aka Suin <suinyeze@gmail.com>
 * @copyright  2011 Hidehito NOZAWA
 * @license    MIT license
 *
 */

class Suin_PhpFunctions
{
	/**
	 * コマンドラインで標準入力を取得する関数
	 * @link http://suin.asia/2011/04/04/how_to_pass_stdin_to_php
	 * @return string
	 */
	public function getStdin()
	{
		return file_get_contents('php://stdin');
	}

	/**
	 * glob()を再帰的に行う
	 * @link http://suin.asia/2011/02/25/recursive_glob_method_php
	 * @param string $pattern
	 * @param int $flags
	 * @param string $path
	 * @return array
	 */
	public function rglob($pattern = '*', $flags = 0, $path = '')
	{
		$paths = glob($path.'*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT);
		$files = glob($path.$pattern, $flags);

		foreach ( $paths as $path )
		{
			$files = array_merge($files, rglob($pattern, $flags, $path));
		}

		return $files;
	}

	/**
	 * パスワード生成関数を1行で
	 * @link http://suin.asia/2010/12/08/php_password_generate_function
	 * @param int $chars
	 * @return string
	 */
	public function makePassword($chars = 8)
	{
		return substr(str_shuffle('1234567890qwertyuiopasdfghjklzxcvbnm'), 0, $chars);
	}

	/**
	 * 正規表現にマッチするかどうがboolで返す
	 * @param $pattern
	 * @param $subject
	 * @return bool
	 */
	public function isMatch($pattern, $subject)
	{
		return ( preg_match($pattern, $subject) > 0 );
	}

	/**
	 * 正規表現置換に失敗したらNOTICEを出す
	 * @param $pattern
	 * @param $replacement
	 * @param $subject
	 * @return mixed
	 */
	public function regexReplace($pattern, $replacement, $subject)
	{
		$string = preg_replace($pattern, $replacement, $subject);

		if ( $string === null )
		{
			trigger_error('preg_replace: failed to replace.', E_USER_NOTICE);
		}

		return $string;
	}

	/**
	 * 連想配列をKey-Value配列に変換する
	 * @param array $data
	 * @param $keyName
	 * @param $valueName
	 * @return array
	 */
	public function hashToKeyValue(array $data, $keyName, $valueName)
	{
		$keyValueData = array();

		foreach ( $data as $datum )
		{
			$key   = $datum[$keyName];
			$value = $datum[$valueName];
			$keyValueData[$key] = $value;
		}

		return $keyValueData;
	}

	/**
	 * オブジェクトの名前空間を返す
	 * @param $obj
	 * @return string
	 */
	public function getNamespace($obj)
	{
		$className = get_class($obj);
		$className = strtr($className, '\\', '/');
		$className = dirname($className);
		$namespace = strtr($className, '/', '\\');
		return $namespace;
	}

	/**
	 * キーストレッチしてより解読困難なパスワードハッシュを生成する
	 * @param $password
	 * @param $salt
	 * @param int $stretch
	 * @return string
	 */
	public function stretch($password, $salt, $stretch = 100000)
	{
		$key = '';

		for ( $i = 0; $i < $stretch; $i++ )
		{
			$key = md5($key.$password.$salt);
		}

		return $key;
	}

	/**
	 * 文字列がひらがなかを返す
	 *
	 * 次の文字以外にマッチした場合、FALSEを返します:
	 * ぁ あ ぃ い ぅ う ぇ え ぉ お か が き ぎ く ぐ け げ こ ご さ ざ し じ す ず せ ぜ そ ぞ
	 * た だ ち ぢ っ つ づ て で と ど な に ぬ ね の は ば ぱ ひ び ぴ ふ ぶ ぷ へ べ ぺ ほ ぼ
	 * ぽ ま み む め も ゃ や ゅ ゆ ょ よ ら り る れ ろ ゎ わ ゐ ゑ を ん ゔ ゕ ゖ ー
	 *
	 * @param string $string
	 * @return bool
	 */
	public function isHiragana($string)
	{
		$hiragana = '\xe3(\x81[\x81-\xbf]|\x82[\x80-\x96])'; // [ぁ-み]|[む-ゖ]
		$chonpu   = '\xe3\x83\xbc'; // ー
		$pattern  = "/^($hiragana|$chonpu)+$/";

		if ( preg_match($pattern, $string) ) {
			return true;
		}

		return false;
	}
}