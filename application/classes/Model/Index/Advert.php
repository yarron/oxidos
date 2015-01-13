<?php defined('SYSPATH') or die('No direct script access.');

class Model_Index_Advert extends ORM {
    protected $_table_name = 'adverts';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    protected $_has_many = array(
        'descriptions' => array(
            'model' => 'Index_Advertsdescription',
            'foreign_key' => 'adverts_id',
        ),
        'images' => array(
            'model' => 'Index_Advertsimage',
            'foreign_key' => 'adverts_id',
        ),
        
    );
 
} 
