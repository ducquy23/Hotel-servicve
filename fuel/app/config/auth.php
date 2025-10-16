<?php

return array(
	// Danh sách driver sử dụng
	'driver' => array('Simpleauth'),

	// Cho phép đăng nhập từ nhiều nơi
	'verify_multiple_logins' => true,

	// Thời gian ghi nhớ đăng nhập (remember me) - 14 ngày
	'login_hash_salt' => 'changeme_login_hash_salt_please',

	// Tên session cho user id
	'users' => array(),
);
