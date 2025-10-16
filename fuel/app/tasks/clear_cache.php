<?php

namespace Fuel\Tasks;

class Clear_Cache
{
	/**
	 * php oil refine clear_cache
	 */
	public static function run()
	{
		try {
			\Cache::delete_all();
			echo "Cache::delete_all() done\n";
		} catch (\Exception $e) {
			echo "Cache::delete_all() error: " . $e->getMessage() . "\n";
		}
		$cache_dir = APPPATH . 'cache';
		$deleted = 0;
		if (is_dir($cache_dir)) {
			$items = scandir($cache_dir);
			foreach ($items as $item) {
				if ($item === '.' || $item === '..') { continue; }
				$path = $cache_dir . DIRECTORY_SEPARATOR . $item;
				if (is_file($path)) {
					@unlink($path);
					$deleted++;
				} elseif (is_dir($path)) {
					self::rrmdir($path);
					$deleted++;
				}
			}
		}
		echo "Removed {$deleted} cache items from app cache folder\n";
	}

	private static function rrmdir($dir)
	{
		if (!is_dir($dir)) { return; }
		$items = scandir($dir);
		foreach ($items as $item) {
			if ($item === '.' || $item === '..') { continue; }
			$path = $dir . DIRECTORY_SEPARATOR . $item;
			if (is_dir($path)) {
				self::rrmdir($path);
			} else {
				@unlink($path);
			}
		}
		@rmdir($dir);
	}
}


