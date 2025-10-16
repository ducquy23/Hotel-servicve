<?php

class Func_Icon
{
	/**
	 * Trả về danh sách icon figma (PNG) trong thư mục public/assets/icon-figma
	 * @return array [ [ 'value' => 'assets/icon-figma/xxx.png', 'name' => 'xxx' ], ... ]
	 */
	public static function get_figma_icons(): array
	{
		$icons = array();
		$dir = DOCROOT . 'assets/img/icon-figma';
		if (!is_dir($dir)) {
			return $icons;
		}
		$files = scandir($dir);
		foreach ($files as $file) {
			if ($file === '.' || $file === '..') {
				continue;
			}
			if (preg_match('/\.png$/i', $file)) {
				$basename = preg_replace('/\.png$/i', '', $file);
				$icons[] = array(
					'value' => 'assets/img/icon-figma/' . $file,
					'name' => str_replace(array('-', '_'), ' ', $basename),
				);
			}
		}
		return $icons;
	}
}


