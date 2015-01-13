<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Advert extends ORM {
    protected $_table_name = 'adverts';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    protected $_has_many = array(
        'descriptions' => array(
            'model' => 'Admin_Advertsdescription',
            'foreign_key' => 'adverts_id',
        ),
        'images' => array(
            'model' => 'Admin_Advertsimage',
            'foreign_key' => 'adverts_id',
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
        i18n::lang('admin/'.$config['admin_language_folder'].'/adverts');
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
