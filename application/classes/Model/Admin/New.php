<?php defined('SYSPATH') or die('No direct script access.');

//Модель новостей
class Model_Admin_New extends ORM {

    protected $_table_name = 'news';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';

   
    public function rules()
    {
        return array(
            'alias' => array(
                array('not_empty'),
                array('alpha_dash'),
                array(array($this, 'unique'), array('alias', ':value')),
            ),
        );
    }


    public function labels()
    {
        $config = kohana::$config->load('config');
        i18n::lang('admin/'.$config['admin_language_folder'].'/news');
        return array(
            'alias' => __('label_alias'),
        );
    }

    public function filters()
    {
        return array(
            TRUE => array(
                array('trim'),
            ),
        );
    }

} 
