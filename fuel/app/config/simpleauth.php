<?php

return array(
	'table_name' => 'admins',

	'columns' => array(
		'username'     => 'username',
		'password'     => 'password',
		'email'        => 'email',
		'group'        => 'group',
		'last_login'   => 'last_login',
		'login_hash'   => 'login_hash',
//		'profile_fields' => 'profile_fields',
	),

	'groups' => array(
		1  => array('name' => 'Users', 'roles' => array('user')),
		50 => array('name' => 'Managers', 'roles' => array('manager')),
		100 => array('name' => 'Administrators', 'roles' => array('admin')),
	),

	'roles' => array(
		'user'    => array('read'),
		'manager' => array('read', 'write'),
		'admin'   => array('read', 'write', 'delete'),
	),
);
