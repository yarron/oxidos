<?php defined('SYSPATH') or die('No direct script access.');

class Model_Index_Articlesdescription extends ORM {

    protected $_table_name = 'articlesdescriptions';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    protected $_belongs_to = array(
        'articles' => array(
                'model' => 'Index_Article',
                'foreign_key' => 'article_id',
        ),
    );
    

} 