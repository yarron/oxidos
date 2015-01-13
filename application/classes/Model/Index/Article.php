<?php defined('SYSPATH') or die('No direct script access.');

class Model_Index_Article extends ORM {
    protected $_table_name = 'articles';
    protected $_primary_key = 'id';
    protected $_db_group = 'default';
    protected $_load_with = array('Index_Articlesdescription');
    
    protected $_has_many = array(
        'descriptions' => array(
            'model' => 'Index_Articlesdescription',
            'foreign_key' => 'article_id',
        ),
        'categories' => array(
            'model' => 'Index_Category',
            'foreign_key' => 'article_id',
            'through' => 'articles_categories',
            'far_key' => 'category_id',
        ),
        'comments' => array(
            'model' => 'Index_Comment',
            'foreign_key' => 'article_id',
        ),
    );
    
    
} 
