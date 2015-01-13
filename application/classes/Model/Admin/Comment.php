<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Comment extends ORM {
    protected $_table_name = 'comments';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    protected $_belongs_to = array(
        'article' => array(
                'model' => 'Admin_Article',
                'foreign_key' => 'article_id',
        ),
        
    );
    
    public function rules()
    {
        return array(
            'author' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
            ),
            'article_id' => array(
                array('not_empty'),
                array(array($this, 'is_article'), array(':value'))
            ),
            'text' => array(
                array('not_empty'),
                array('min_length', array(':value', 10)),
            ),
            
        );
    }


    public function labels()
    {
        $config = kohana::$config->load('config');
        i18n::lang('admin/'.$config['admin_language_folder'].'/comments');
        return array(
            'author'    => __('label_author'),
            'article_id'   => __('label_article'),
            'text'      => __('label_text'),
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
    
    
    public function is_article($value)
    {
        $article = ORM::factory('Admin_Article')->where('id', '=', $value)->count_all();
        
        if($article > 0)
            return true;
        else
            return false;
    }
} 
