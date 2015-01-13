<?php defined('SYSPATH') or die('No direct script access.');

class Model_Index_Userpassword extends ORM{
    protected $_table_name = 'users';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    public function rules()
    {
        return array(
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
            ),
            'password' => array(
                array('not_empty'),
                array('min_length', array(':value', 8)),
                array('alpha_dash', array(':value')),
            ),
            'password_confirm' => array(
                array('min_length', array(':value', 8)),
                array('alpha_dash', array(':value')),
                array('matches',    array($_POST, 'password','password_confirm')),
            ),
        );
    }
        
    public function labels()
    {
        $config = kohana::$config->load('config');
        i18n::lang('index/'.$config['index_language_folder'].'/account');
        
        return array(
            'username'          => __('label_username'),
            'email'             => __('label_email'),
            'name'              => __('label_name'),
            'password'          => __('label_password'),
            'password_confirm'  => __('label_confirm'),
        );
    }

} 
