<?php defined('SYSPATH') or die('No direct script access.');

//Модель новостей
class Model_Index_New extends ORM {

    protected $_table_name = 'news';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';

} 
