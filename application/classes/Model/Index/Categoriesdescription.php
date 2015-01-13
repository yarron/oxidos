<?php defined('SYSPATH') or die('No direct script access.');

class Model_Index_Categoriesdescription extends ORM {

    protected $_table_name = 'categoriesdescriptions';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    protected $_belongs_to = array(
        'categories' => array(
                'model' => 'Index_Category',
                'foreign_key' => 'category_id',
        ),
    );
    

} 