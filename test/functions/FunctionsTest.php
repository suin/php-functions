<?php

require_once dirname(dirname(__DIR__)).'/functions/functions.php';

class Suin_PhpFunctions_FunctionsTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @return Suin_PhpFunctions
	 */
	public function newFunctions()
	{
		return new Suin_PhpFunctions();
	}

	/**
	 * @param $expect
	 * @param $string
	 * @dataProvider dataForTestIsHiragana
	 */
	public function testIsHiragana($expect, $string)
	{
		$function = $this->newFunctions();
		$actual = $function->isHiragana($string);
		$this->assertSame($expect, $actual);
	}

	public static function dataForTestIsHiragana()
	{
		return array(
			// [expect, string]
			array(true, "あ"),
			array(true, "ん"),
			array(true, "ぁ"),
			array(true, "ゎ"),
			array(true, "ー"),
			array(true, "ぴーえっちっぴー"),
			array(true, "ぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでとどなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐゑをんゔゕゖー"),

			array(false, "。"),
			array(false, "、"),
			array(false, "ア"),
			array(false, "ａ"),
			array(false, "４"),
			array(false, "ぴーえっちっぴー5.4"),
		);
	}
}
