<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Articlesdescription extends ORM {

    protected $_table_name = 'articlesdescriptions';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    protected $_belongs_to = array(
        'articles' => array(
                'model' => 'Admin_Article',
                'foreign_key' => 'article_id',
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
        i18n::lang('admin/'.$config['admin_language_folder'].'/articles');
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