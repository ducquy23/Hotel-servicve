<?php

class Model_Admin extends Orm\Model
{
    protected static $_properties = array(
        'id' => array(
            'label' => 'ID',
            'data_type' => 'int',
        ),
        'username' => array(
            'label' => 'Username',
            'data_type' => 'varchar',
        ),
        'status' => array(
            'label' => 'Status',
            'data_type' => 'enum',
            'default' => 'active',
        ),
        'group' => array(
            'label' => 'Group',
            'data_type' => 'int',
        ),
        'last_login' => array(
            'label' => 'Last Login',
            'data_type' => 'int',
        ),
        'login_hash' => array(
            'label' => 'Login Hash',
            'data_type' => 'varchar',
        ),
        'profile_fields' => array(
            'label' => 'Profile Fields',
            'data_type' => 'text',
        ),
        'admin_created_id' => array(
            'label' => 'Admin Created ID',
            'data_type' => 'bigint',
            'null' => true,
        ),
        'email' => array(
            'label' => 'Email',
            'data_type' => 'varchar',
        ),
        'password' => array(
            'label' => 'Password',
            'data_type' => 'varchar',
        ),
        'salt' => array(
            'label' => 'Salt',
            'data_type' => 'varchar',
        ),
        'full_name' => array(
            'label' => 'Full Name',
            'data_type' => 'varchar',
            'null' => true,
        ),
        'two_factor_secret' => array(
            'label' => '2FA Secret',
            'data_type' => 'text',
            'null' => true,
        ),
        'two_factor_recovery_codes' => array(
            'label' => '2FA Recovery Codes',
            'data_type' => 'text',
            'null' => true,
        ),
        'two_factor_confirmed_at' => array(
            'label' => '2FA Confirmed At',
            'data_type' => 'timestamp',
            'null' => true,
        ),
        'created_at' => array(
            'label' => 'Created At',
            'data_type' => 'timestamp',
            'null' => true,
        ),
        'updated_at' => array(
            'label' => 'Updated At',
            'data_type' => 'timestamp',
            'null' => true,
        ),
    );

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'property' => 'created_at',
            'mysql_timestamp' => true,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'property' => 'updated_at',
            'mysql_timestamp' => true,
        ),
    );

    protected static $_table_name = 'admins';

    protected static $_primary_key = array('id');

    protected static $_has_many = array(
    );

    protected static $_belongs_to = array(
    );
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_PENDING = 'pending';
}
