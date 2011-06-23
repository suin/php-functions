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

