<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Category extends ORM_MPTT {
    protected $_primary_key = 'id';
    protected $_table_name = 'categories';
    protected $_db_group = 'default';
    
    protected $_has_many = array(
        'articles' => array(
            'model'   => 'Article',
            'through' => 'articles_categories',
        ),
        'descriptions' => array(
            'model' => 'Categoriesdescription',
            'foreign_key' => 'category_id',
        ),
    );
    
    public function rules()
    {
        return array(
            'alias' => array(
                array(array($this, 'unique'), array('alias', ':value')),
                array('not_empty'),
            ),
        );
    }


    public function labels()
    {
        $config = kohana::$config->load('config');
        i18n::lang('admin/'.$config['admin_language_folder'].'/categories');
        
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

    //проверка на перемещение категории
    public static function cat_child($id_d, $id_s)
    {
        if(!$id_d) {
            $category_s = ORM::factory("Admin_Category")->where("id", '=', $id_s)->find();
            
            //если количество потомков текущего узла положительное, то ничего не делаем
            if ($category_s->count() > 0) return 0;
            else return 1;
        }
        else{
            //извлекаем категорию перемещения и категорию назначения
            $category_s = ORM::factory("Admin_Category")->where("id", '=', $id_s)->find();
            $category_d = ORM::factory("Admin_Category")->where("id", '=', $id_d)->find();

            //если деревья категорий разные
            if($category_s->scope != $category_d->scope){
                //если количество потомков текущего узла положительное, то ничего не делаем
                if ($category_s->count() > 0) return 0;
                else return 1;
            }
            else return 2;
        }
        
    }
    
    //проверка на удаление категории
    public static function cat_delete($id )
    {
        //ищем категорию
        $category = ORM::factory('Admin_Category')->where('id', '=', $id)->find();

        //если количество потомков текущего узла положительное, то ничего не делаем
        if ($category->count() > 0)
        {
            return false;
        }
        
        return true; 
    }
    
    //проверка статей при удалении категории
    public static function cat_article( $id )
    {
        //ищем категорию
        $categories = DB::select()
                ->from('articles_categories')
                ->where("category_id", "=", $id)->execute()->as_array();

        //если количество потомков текущего узла положительное, то ничего не делаем
        if (count($categories) > 0)
        {
            return false;
        }
        
        return true; 
    }
} 
