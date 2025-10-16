<?php

class Model_Room_Image extends \Orm\Model
{
    protected static $_table_name = 'room_images';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id',
        'room_id',
        'image_path',
        'is_primary',
        'sort_order',
        'created_at',
        'updated_at',
    );

    protected static $_belongs_to = array(
        'room' => array(
            'key_from' => 'room_id',
            'model_to' => 'Model_Room',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
    );
}


