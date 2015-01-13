<?php defined('SYSPATH') or die('No direct script access.');

class Model_Index_Useredit extends Model_Auth_User{
    protected $_table_name = 'users';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    public function rules()
    {
        $pass = array();
        //если поля пароля и подтверждения не пустые, то делаем проверку на валидацию
        if(isset($_POST["save"]) && $_POST["action"]=='password' || $_POST["action"]=='reset'){
            $pass = array(
                'password_confirm' => array(
                    array('matches',    array($_POST, 'password','password_confirm')),
                    
                ),
                'password' => array(
                    array('not_empty'),
                    array('min_length', array($_POST['password'], 8)),
                    array('max_length', array($_POST['password'], 16)),
                    array('alpha_dash', array($_POST['password'])),
                ),
            );
            return $pass;
        }
        else{
        
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
            return $data ;
        }
    }
  
    public function labels()
    {
        $config = kohana::$config->load('config');
        i18n::lang('index/'.$config['index_language_folder'].'/account');
        
        return array(
            'username'      => __('label_username'),
            'email'         => __('label_email'),
            'name'          => __('label_name'),
            'password'      => __('label_password'),
            'password_confirm'       => __('label_confirm'),
        );
    }
    
    
    
} 
