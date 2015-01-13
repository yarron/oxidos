<?php defined('SYSPATH') or die('No direct script access.');

class Model_Index_User extends Model_Auth_User{
    protected $_table_name = 'users';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    protected $_has_many = array(
        'roles' => array(
            'model'   => 'Index_Role',
            'through' => 'roles_users',
            'foreign_key' => 'user_id',
        ),
        
    );  
} 
