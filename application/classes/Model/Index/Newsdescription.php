<?php defined('SYSPATH') or die('No direct script access.');

class Model_Index_Newsdescription extends ORM {

    protected $_table_name = 'newsdescriptions';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    protected $_belongs_to = array(
        'news' => array(
                'model' => 'Index_New',
                'foreign_key' => 'new_id',
        ),
    );
    

} 