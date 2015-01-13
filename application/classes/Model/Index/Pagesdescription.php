<?php defined('SYSPATH') or die('No direct script access.');

class Model_Index_Pagesdescription extends ORM {

    protected $_table_name = 'pagesdescriptions';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    protected $_belongs_to = array(
        'pages' => array(
                'model' => 'Index_Page',
                'foreign_key' => 'page_id',
        ),
    );
    
    
} 