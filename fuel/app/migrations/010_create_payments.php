<?php

namespace Fuel\Migrations;

class Create_payments
{
	public function up()
	{
		\DBUtil::create_table('payments', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
			'booking_id' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'amount' => array('constraint' => '10,2', 'null' => false, 'type' => 'decimal'),
			'payment_method' => array('null' => false, 'constraint' => '"cash","credit_card","paypal"', 'type' => 'enum'),
			'status' => array('null' => false, 'constraint' => '"pending","success","failed"', 'type' => 'enum'),
			'created_at' => array('null' => false, 'type' => 'datetime'),
			'updated_at' => array('constraint' => '11', 'null' => true, 'type' => 'int', 'unsigned' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('payments');
	}
}