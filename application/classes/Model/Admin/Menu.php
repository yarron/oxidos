<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Menu extends ORM {
    protected $_table_name = 'menu';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';

    public function filters()
    {
        return array(
            TRUE => array(
                array('trim'),
            ),
        );
    }
} 
