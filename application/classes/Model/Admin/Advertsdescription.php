<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Advertsdescription extends ORM {

    protected $_table_name = 'advertsdescriptions';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    protected $_belongs_to = array(
        'adverts' => array(
                'model' => 'Admin_Advert',
                'foreign_key' => 'advert_id',
        ),
    );
    public function rules()
    {
        return array(
            'title' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
            ),
        );
    }


    public function labels()
    {
        $config = kohana::$config->load('config');
        i18n::lang('admin/'.$config['admin_language_folder'].'/adverts');
        return array(
            'title' => __('label_title'),
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