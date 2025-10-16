<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.9-dev
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

/**
 * -----------------------------------------------------------------------------
 *  Database settings for development environment
 * -----------------------------------------------------------------------------
 *
 *  These settings get merged with the global settings.
 *
 */

return array(
	'default' => array(
        'type'       => 'mysql',
		'connection' => array(
			'dsn'      => 'mysql:host=fuelphp_mysql;port=3306;dbname=fuelphp_db',
			'username' => 'fuelphp_user',
			'password' => 'fuelphp_password',
		),
        'charset'   => 'utf8mb4',
        'table_prefix' => '',
        'profiling' => true,
	),
);
