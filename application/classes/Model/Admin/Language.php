<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Language extends ORM {
    protected $_table_name = 'languages';

    protected $_primary_key = 'id';

    protected $_db_group = 'default';

   
    public function rules()
    {
        return array(
            'name' => array(
                array('not_empty'),
                array(array($this, 'unique'), array('name', ':value')),
            ),
            'code' => array(
                array('not_empty'),
                array(array($this, 'unique'), array('code', ':value')),
            ),
            'image' => array(
                array('not_empty'),
            ),
            'locale' => array(
                array('not_empty'),
            ),
        );
    }


    public function labels()
    {
        $config = kohana::$config->load('config');
        i18n::lang('admin/'.$config['admin_language_folder'].'/languages');
        return array(
            'name'      => __('label_name'),
            'code'      => __('label_code'),
            'image'     => __('label_image'),
            'locale'    => __('label_locale'),
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