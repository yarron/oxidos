<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Layout extends ORM {
    protected $_table_name = 'layouts';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    public function rules()
    {
        return array(
            'name' => array(
                array('not_empty'),
                array(array($this, 'unique'), array('name', ':value')),
            ),
            'route' => array(
                array('not_empty'),
                array(array($this, 'unique'), array('route', ':value')),
            ),
        );
    }


    public function labels()
    {
        $config = kohana::$config->load('config');
        i18n::lang('admin/'.$config['admin_language_folder'].'/layouts');
        return array(
            'name'      => __('label_name'),
            'route'     => __('label_route'),
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
