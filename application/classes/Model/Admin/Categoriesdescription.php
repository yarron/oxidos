<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Categoriesdescription extends ORM {

    protected $_table_name = 'categoriesdescriptions';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    protected $_belongs_to = array(
        'categories' => array(
                'model' => 'Admin_Category',
                'foreign_key' => 'category_id',
        ),
    );
    
    public function rules()
    {
        return array(
            'title' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
             ),   
            'description' => array(
                array('not_empty'),
            ),
        );
    }


    public function labels()
    {
        $config = kohana::$config->load('config');
        i18n::lang('admin/'.$config['admin_language_folder'].'/categories');
        return array(
            'title'         => __('label_title'),
            'description'   => __('label_description'),
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