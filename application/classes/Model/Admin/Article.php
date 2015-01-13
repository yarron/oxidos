<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Article extends ORM {
    
    
    protected $_table_name = 'articles';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    protected $_has_many = array(
        'descriptions' => array(
            'model' => 'Admin_Articlesdescription',
            'foreign_key' => 'article_id',
        ),
        'categories' => array(
            'model' => 'Admin_Category',
            'foreign_key' => 'article_id',
            'through' => 'articles_categories',
            'far_key' => 'category_id',
        ),
        'comments' => array(
            'model' => 'Admin_Comment',
            'foreign_key' => 'article_id',
        ),
        
    );

    public function rules()
    {
        return array(
            'alias' => array(
                array('not_empty'),
                array('alpha_dash'),
                array(array($this, 'unique'), array('alias', ':value')),
            ),
        );
    }


    public function labels()
    {
        $config = kohana::$config->load('config');
        i18n::lang('admin/'.$config['admin_language_folder'].'/articles');
        
        return array(
            'alias' => __('label_alias'),
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
