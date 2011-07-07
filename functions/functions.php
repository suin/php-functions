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


/**
 * コマンドラインで標準入力を取得する関数
 * @link http://suin.asia/2011/04/04/how_to_pass_stdin_to_php
 */
function getStdin()
{
	return file_get_contents('php://stdin');
}

/**
 * glob()を再帰的に行う
 * @link http://suin.asia/2011/02/25/recursive_glob_method_php
 */
function rglob($pattern = '*', $flags = 0, $path = '')
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
 */
function make_password($chars = 8)
{
	return substr(str_shuffle('1234567890qwertyuiopasdfghjklzxcvbnm'), 0, $chars);
}

/**
 * 正規表現にマッチするかどうがboolで返す
 */
function is_match($pattern, $subject)
{
	return ( preg_match($pattern, $subject) > 0 );
}

/**
 * 正規表現置換に失敗したらNOTICEを出す
 */

function regex_replace($pattern, $replacement, $subject)
{
	$string = preg_replace($pattern, $replacement, $subject)

	if ( $string === null )
	{
		trigger_error('preg_replace: failed to replace.', E_USER_NOTICE);
	}

	return $string;
}

/**
 * 連想配列をKey-Value配列に変換する
 */
function hashToKeyValue(array $data, $keyName, $valueName)
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
 */
function get_namespace($obj)
{
	$className = get_class($obj);
	$className = strtr($className, '\\', '/');
	$className = dirname($className);
	$namespace = strtr($className, '/', '\\');
	return $namespace;
}

/**
 * キーストレッチしてより解読困難なパスワードハッシュを生成する
 */
function stretch($password, $salt, $stretch = 100000)
{
	$key = '';

	for ( $i = 0; $i < $stretch; $i++ )
	{
		$key = md5($key.$password.$salt);
	}

	return $key;
}
