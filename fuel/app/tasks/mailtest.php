<?php

namespace Fuel\Tasks;

use Email\Email;
use Fuel\Core\Config;
use Fuel\Core\Package;

class Mailtest
{
	/**
	 * Test send email: php oil r mailtest [to_email]
	 */
	public static function run($to = null)
	{
		Package::load('email');
		$setup = Config::get('email.default_setup', 'default');
		$cfg = Config::get('email.setups.'.$setup, array());
		$fromEmail = isset($cfg['from']['email']) ? $cfg['from']['email'] : 'no-reply@localhost';
		$fromName = isset($cfg['from']['name']) ? $cfg['from']['name'] : 'Task Manager';
		$to = $to ?: $fromEmail;
		$subject = 'FuelPHP Mail Test';
		$body = "This is a test email sent at " . date('Y-m-d H:i:s');

		try {
//            die(Config::get('db.host', 'no-reply@localhost'));
//            die(Config::get('email.from.email', 'no-reply@localhost'));
			Email::forge()
				->to($to)
				->from($fromEmail, $fromName)
				->subject($subject)
				->body($body)
				->send();
			echo "Mail sent to: {$to}\n";
		} catch (\Exception $e) {
			echo "Mail send failed: " . $e->getMessage() . "\n";
		}
	}
}


