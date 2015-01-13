<?php defined('SYSPATH') or die('No direct script access.');

class Model_Index_Advertsdescription extends ORM {

    protected $_table_name = 'advertsdescriptions';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    protected $_belongs_to = array(
        'adverts' => array(
                'model' => 'Index_Advert',
                'foreign_key' => 'advert_id',
        ),
    );
   
    
} 