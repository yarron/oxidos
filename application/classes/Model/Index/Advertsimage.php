<?php defined('SYSPATH') or die('No direct script access.');

class Model_Index_Advertsimage extends ORM {

    protected $_table_name = 'advertsimages';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';
    
    protected $_belongs_to = array(
        'adverts' => array(
                'model' => 'Index_Advert',
                'foreign_key' => 'advert_id',
        ),
    );
    
    
} 