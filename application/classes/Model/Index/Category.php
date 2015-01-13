<?php defined('SYSPATH') or die('No direct script access.');

class Model_Index_Category extends ORM_MPTT {
    protected $_primary_key = 'id';
    protected $_table_name = 'categories';
    protected $_db_group = 'default';
    protected $_load_with = array('Index_Categoriesdescription');
    
    protected $_has_many = array(
        'articles' => array(
            'model'   => 'Index_Article',
            'foreign_key' => 'category_id',
            'through' => 'articles_categories',
            'far_key' => 'article_id',
            
        ),
        'descriptions' => array(
            'model' => 'Index_Categoriesdescription',
            'foreign_key' => 'category_id',
        ),
    );
    
    public static function getCategories($id = 0, $type = 'by_parent', $lang){
        //$config = kohana::$config->load('config');
        static $data = null;

    	if ($data === null) {	
                $data = array();
                $categories = DB::select()
                    ->from('categories')   
                    ->join('categoriesdescriptions')->on('categories.id', '=', 'categoriesdescriptions.category_id')
                    ->where('categoriesdescriptions.language_id', '=', $lang)
                    ->and_where('categories.status', '=', 1)
                    ->order_by('categories.parent_id', 'ASC')
                    ->order_by('categories.sort_order', 'ASC')
                    ->execute()->as_array();
                foreach ($categories as $row) {
                        $data['by_id'][$row['id']] = $row;
                        $data['by_parent'][$row['parent_id']][] = $row;
                }
    	}
        return ((isset($data[$type]) && isset($data[$type][$id])) ? $data[$type][$id] : array());
    }
    
    
} 
