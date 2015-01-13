<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_User extends Model_Auth_User{
    protected $_table_name = 'users';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    protected $_has_many = array(
        'roles' => array(
            'model'   => 'Role',
            'through' => 'roles_users',
            'foreign_key' => 'user_id',
        ),
    );
    
    

    public function rules()
	{
	    $pass = array();
            //если поля пароля и подтверждения не пустые, то делаем проверку на валидацию
            if(isset($_POST["action"]) && $_POST["action"]!='login'){
                if($_POST["password"]!= ""  || $_POST["confirm"]!="" ){

                    $pass = array(
                        'confirm' => array(
                            array('matches',    array($_POST, 'password','confirm')),
                        ),
                        'password' => array(
                            array('min_length', array($_POST['password'], 8)),
                            array('max_length', array($_POST['password'], 16)),
                            array('alpha_dash', array($_POST['password'])),
                        ),
                    );
                }
            }
        
        
            //проверяем на валидацию остальные поля
            $data =  array(
                'username' => array(
			array('not_empty'),
                        array('min_length', array(':value', 3)),
			array('max_length', array(':value', 32)),
			array(array($this, 'unique'), array('username', ':value')),
		),
                'name' => array(
			array('not_empty'),
			array('min_length', array(':value', 3)),
			array('max_length', array(':value', 32)),
		),
			
		'email' => array(
			array('not_empty'),
			array('email'),
			array(array($this, 'unique'), array('email', ':value')),
            ));
            
            //возвращаем склеенный массив
            return array_merge($pass, $data) ;	
	}
        
    public function labels()
    {
        $config = kohana::$config->load('config');
        i18n::lang('admin/'.$config['admin_language_folder'].'/users');
        
        return array(
            'username'      => __('label_username'),
            'email'         => __('label_email'),
            'name'          => __('label_name'),
            'password'      => __('label_password'),
            'confirm'       => __('label_confirm'),
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
