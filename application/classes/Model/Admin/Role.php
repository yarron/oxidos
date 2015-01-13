<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Role extends Model_Auth_User{
    protected $_table_name = 'roles';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    protected $_has_many = array(
        
        'users' => array(
            'model' => 'Admin_User',
            'foreign_key' => 'role_id',
            'through' => 'roles_users',
            'far_key' => 'user_id',
        ),
        
    );
    public function rules()
	{
		return array(
            'name' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
                array(array($this, 'unique'), array('name', ':value')),
            ),
        );
	}
        
    public function labels()
    {
        $config = kohana::$config->load('config');
        i18n::lang('admin/'.$config['admin_language_folder'].'/roles');
        return array(
            'name' => __('label_name'),
        );
    }

    public function filters()
    {
        return array(
            TRUE => array(
                array('trim'),
            ),
        );
    }

} 
